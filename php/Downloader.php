<?php namespace App\Helpers;

if (!defined('LARAVEL_START'))
    throw new \Exception("This helper class must be used with the Laravel 5 framework");

use File;

define("STORAGE_PATH", storage_path());

class Downloader {

    private $url;
    private $headers;
    private $info = false;
    private $curl;
    private $data;

    private $etag = "";
    private $etag_array;
    private $etag_path;

    private $save_path;

    /**
     * Constructor for the Downloader class
     * 
     * @param String $url Url for the file to be downloaded
     * @param String $path Absolute path to save the file
     * @param OutputInterface $bar The progress bar interface for a Artisan command
     */
    public function __construct($url, $path = (STORAGE_PATH . "/import"))
    {
        // Set the url
        $this->url = $url;

        // Path to save the downloaded file
        $this->save_path = rtrim($path, "/");

        // Set the path to the etags file
        $this->etag_path = storage_path() . "/import/etags";

        // Init curl
        $this->curl = curl_init($this->url);

        // Save the headers for the external file
        $this->headers = get_headers($this->url, true);

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($this->curl, CURLOPT_NOPROGRESS, false);

        // Check if the etags file exists
        if (File::exists($this->etag_path))
        {
            // Temp storage for the unserialization
            $file = unserialize(File::get($this->etag_path));
 
            // Set the etags array
            $this->etag_array = ($file === false ? [] : $file);

            // Find the etag for the current url
            if (array_key_exists($this->url, $this->etag_array))
            {
                // Set the etag for this instance
                $this->etag = $this->etag_array[$this->url];
            }
        }

        // Set the etag in the header
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            'If-None-Match: ' . $this->etag
        ]);
    }

    /**
     * Get the size of the download in MB's
     *
     * @returns String
     */
    public function getSize()
    {
        return ($this->headers['Content-Length'] / 1000000) . " MB";
    }

    /**
     * Get the headers for the set url
     *
     * @returns Array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get the info from the curl transmission, 
     * returns false if the download hasn't been executed yet
     *
     * @returns Array|false
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Download the file
     *
     * @returns Boolean
     */
    public function download($name)
    {
        // Save the returned data
        $this->data = curl_exec($this->curl);

        // Set the download info
        $this->info = curl_getinfo($this->curl);

        // Check for 304 Not Modified
        if ($this->notModified()) {
            // Return false if the download has not been executed
            return false;
        } else {
            // Save the ETag
            if (array_key_exists("ETag", $this->headers))
            {
                $this->saveETags($this->headers['ETag']);
            }

            // Save the data to file
            File::put($this->save_path . "/" . $name, $this->data);

            // Download was succesful
            return true;
        }
    }
    
    /**
     * Check for a 304 Not Modified header
     *
     * @returns Boolean
     */
    public function notModified()
    {
        return $this->info['http_code'] === 304;
    }

    /**
     * Save the etag to the etags array
     *
     * @returns Void
     */
    private function saveETags($etag)
    {
        $this->etag_array[$this->url] = $etag;

        File::put($this->etag_path, serialize($this->etag_array));
    }
}
