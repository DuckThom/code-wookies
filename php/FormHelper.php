<?php namespace App\Helpers;

/**
 * Generate input fields conform the Twitter Bootstrap styling
 * 
 * Optional parameters for $params:
 * - id:        Add the 'id' attribute with $name as value
 * - required:  Add the 'required' attribute
 */

class FormHelper
{

    /**
     * Generate a Twitter Bootstrap input field
     *
     * @param $type
     * @param $name
     * @param $label
     * @param array $params
     * @param string $labelwidth
     * @param string $inputwidth
     * @return string
     */
    public static function input($type, $name, $label, $params = [], $labelwidth = 'col-md-4', $inputwidth = 'col-md-8')
    {
        if (old($name))
            $value = old($name);
        else if (isset($params['value']))
            $value = $params['value'];
        else
            $value = '';

        if (in_array('inline', $params)) {
            return
                "<div class='form-group'>" .
                "<label class='$labelwidth'>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<div class='$inputwidth'>" .
                "<input name='$name' " . (in_array('id', $params) ? "id='$name'" : "") . " type='$type' class='form-control' placeholder='$label' value='$value' " . (in_array('required', $params) ? 'required' : '') . ">" .
                "</div>" .
                "</div>";
        } else {
            return
                "<div class='form-group'>" .
                "<label>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<input name='$name' " . (in_array('id', $params) ? "id='$name'" : "") . "  type='$type' class='form-control' placeholder='$label' value='$value' " . (in_array('required', $params) ? 'required' : '') . ">" .
                "</div>";
        }
    }

    /**
     * Generate a Twitter Bootstrap password field
     *
     * @param $name
     * @param $label
     * @param array $params
     * @param string $labelwidth
     * @param string $inputwidth
     * @return string
     */
    public static function password($name, $label, $params = [], $labelwidth = 'col-md-4', $inputwidth = 'col-md-8')
    {
        if (in_array('inline', $params)) {
            return
                "<div class='form-group'>" .
                "<label class='$labelwidth'>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<div class='$inputwidth'>" .
                "<input name='$name' " . (in_array('id', $params) ? "id='$name'" : "") . " type='password' class='form-control' placeholder='$label' " . (in_array('required', $params) ? 'required' : '') . ">" .
                "</div>" .
                "</div>";
        } else {
            return
                "<div class='form-group'>" .
                "<label>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<input name='$name' " . (in_array('id', $params) ? "id='$name'" : "") . "  type='password' class='form-control' placeholder='$label' " . (in_array('required', $params) ? 'required' : '') . ">" .
                "</div>";
        }
    }

    /**
     * Generate a date picker html field
     *
     * @param $name
     * @param $label
     * @param array $params
     * @param string $labelwidth
     * @param string $inputwidth
     * @return string
     */
    public static function date($name, $label, $params = [], $labelwidth = 'col-md-4', $inputwidth = 'col-md-8')
    {
        if (old($name))
            $value = old($name);
        else if (isset($params['value']))
            $value = $params['value'];
        else
            $value = '';

        if (in_array('inline', $params)) {
            return
                "<div class='form-group'>" .
                "<label class='$labelwidth'>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<div class='$inputwidth'>" .
                "<input name='$name' " . (in_array('id', $params) ? "id='$name'" : "") . "  type='date' class='form-control datepicker' placeholder='$label' value='$value' " . (in_array('required', $params) ? 'required' : '') . ">" .
                "</div>" .
                "</div>";
        } else {
            return
                "<div class='form-group'>" .
                "<label>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<input name='$name' " . (in_array('id', $params) ? "id='$name'" : "") . "  type='date' class='form-control datepicker' placeholder='$label' value='$value' " . (in_array('required', $params) ? 'required' : '') . ">" .
                "</div>";
        }
    }

    /**
     * Price input field html generator
     *
     * @param $type
     * @param $name
     * @param $label
     * @param array $params
     * @param string $labelwidth
     * @param string $inputwidth
     * @return string
     */
    public static function prefix($type, $prefix, $name, $label, $params = [], $labelwidth = 'col-md-4', $inputwidth = 'col-md-8')
    {
        if (old($name))
            $value = old($name);
        else if (isset($params['value']))
            $value = $params['value'];
        else
            $value = '';

        if (in_array('inline', $params)) {
            return
                "<div class='form-group'>" .
                "<label class='$labelwidth'>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<div class='$inputwidth'>" .
                "<div class='input-group'>".
                "<span class='input-group-addon'>$prefix</span>".
                "<input name='$name' " . (in_array('id', $params) ? "id='$name'" : "") . "  type='$type' class='form-control' placeholder='$label' value='$value' " . (in_array('required', $params) ? 'required' : '') . ">" .
                "</div>" .
                "</div>" .
                "</div>";
        } else {
            return
                "<div class='form-group'>" .
                "<label>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<div class='input-group'>".
                "<span class='input-group-addon'>$prefix</span>".
                "<input name='$name' " . (in_array('id', $params) ? "id='$name'" : "") . "  type='$type' class='form-control' placeholder='$label' value='$value' " . (in_array('required', $params) ? 'required' : '') . ">" .
                "</div>" .
                "</div>";
        }
    }

    /**
     * Textarea html generator
     *
     * @param $name
     * @param $label
     * @param array $params
     * @param int $rows
     * @param string $labelwidth
     * @param string $inputwidth
     * @return string
     */
    public static function textarea($name, $label, $params = [], $rows = 5, $labelwidth = 'col-md-4', $inputwidth = 'col-md-8')
    {
        if (in_array('inline', $params)) {
            return
                "<div class='form-group'>" .
                "<label class='$labelwidth'>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<div class='$inputwidth'>" .
                "<textarea name='$name' " . (in_array('id', $params) ? "id='$name'" : "") . " rows='$rows' class='form-control' placeholder='$label' " . (in_array('required', $params) ? 'required' : '') . ">" . old($name) . "</textarea>" .
                "</div>" .
                "</div>";
        } else {
            return
                "<div class='form-group'>" .
                "<label>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<textarea name='$name' " . (in_array('id', $params) ? "id='$name'" : "") . " rows='$rows' class='form-control' placeholder='$label' " . (in_array('required', $params) ? 'required' : '') . ">" . old($name) . "</textarea>" .
                "</div>";
        }
    }

    /**
     * Form select html generator
     *
     * @param $name
     * @param $label
     * @param $data
     * @param array $params
     * @param string $labelwidth
     * @param string $inputwidth
     * @return string
     */
    public static function select($name, $label, $data, $params = [], $labelwidth = 'col-md-4', $inputwidth = 'col-md-8')
    {
        if (gettype($data) != 'array')
        {
            $data = $data->toArray();
        }

        if (in_array('inline', $params)) {
            $html =
                "<div class='form-group'>" .
                "<label class='$labelwidth'>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<div class='$inputwidth'>" .
                "<select name='$name' class='form-control' " . (in_array('required', $params) ? 'required' : '') . ">" .
                "<option value='0'>" . trans('form.select_default') . "</option>";

            foreach ($data as $a) {
                $html .= "<option value='" . $a['id'] . "'>" . $a['name'] . "</option>";
            }

            $html .=
                "</select>" .
                "</div>" .
                "</div>";
        } else {
            $html =
                "<div class='form-group'>" .
                "<label>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<select name='$name' class='form-control'" . (in_array('required', $params) ? 'required' : '') . ">" .
                "<option value='0'>" . trans('form.select_default') . "</option>";

            foreach ($data as $a) {
                $html .= "<option value='" . $a['id'] . "'>" . $a['name'] . "</option>";
            }

            $html .=
                "</select>" .
                "</div>";
        }

        return $html;
    }

    /**
     * Form file input html generator
     *
     * @param string $name
     * @param string $label
     * @param array $params
     * @param string $helptext
     * @param string $labelwidth
     * @param string $inputwidth
     * @return string
     */
    public static function file($name, $label, $params = [], $helptext = '', $labelwidth = 'col-md-4', $inputwidth = 'col-md-8')
    {
        if (in_array('inline', $params)) {
            $html =
                "<div class='form-group'>" .
                "<label class='$labelwidth'>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<div class='$inputwidth'>" .
                "<input type='file' name='$name' " . (in_array('multiple', $params) ? 'multiple="multiple"' : '') . " " . (in_array('required', $params) ? 'required' : '') . ">" .
                "<p class='help-block'>Max size: " . ini_get('upload_max_filesize') . ' ' . (in_array('multiple', $params) ? trans('form.multiple_files_allowed') : '') . " $helptext</p>" .
                "</div>" .
                "</div>";
        } else {
            $html =
                "<div class='form-group'>" .
                "<label>$label" . (in_array('required', $params) ? '*' : '') . "</label>" .
                "<input type='file' name='$name' " . (in_array('multiple', $params) ? 'multiple="multiple"' : '') . " " . (in_array('required', $params) ? 'required' : '') . ">" .
                "<p class='help-block'>Max size: " . ini_get('upload_max_filesize') . ' ' . (in_array('multiple', $params) ? trans('form.multiple_files_allowed') : '') . " $helptext</p>" .
                "</div>";
        }

        return $html;
    }

}
