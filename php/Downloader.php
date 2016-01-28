<?php namespace App\Helpers;

use File;

if (!defined('LARAVEL_START'))
    throw new \Exception("This class must be used with the Laravel 5 framework");

class Downloader {

    private $url;
    private $headers;
    private $info;
    private $curl;
    private $data;

    private $etag = "";
    protected $etag_array = [];
    protected $etag_path = "";

    public function __construct($url)
    {
        $this->url = $url;
        $this->etag_path = storage_path() . "/import/etags";
        $this->curl = curl_init($this->url);
        $this->headers = get_headers($this->url, true);

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, false);

        if (File::exists($this->etag_path))
        {
            $this->etag_array = unserialize(File::get($this->etag_path));

            if (array_key_exists($this->url, $this->etag_array))
            {
                $this->etag = $this->etag_array[$this->url];
            }
        }

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            'If-None-Match: ' . $this->etag
        ]);
    }

    public function getSize()
    {
        return ($this->headers['Content-Length'] / 1000000) . " MB";
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function download($name)
    {
        $this->data = curl_exec($this->curl);
        $this->info = curl_getinfo($this->curl);

        if ($this->notModified()) {
            return false;
        } else {
            $this->saveETags($this->headers['ETag']);

            File::put(storage_path() . "/import/" . $name, $this->data);

            return true;
        }
    }

    public function notModified()
    {
        return $this->info['http_code'] === 304;
    }

    protected function saveETags($etag)
    {
        $this->etag_array[$this->url] = $etag;

        File::put($this->etag_path, serialize($this->etag_array));
    }
}
