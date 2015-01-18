<?php

/**
 * Class Functions
 * The Functions class stores useful parameters which can be called statically for use within this exercise
 */
class Functions {
    /**
     * @param $p_data
     * @param string $p_type
     * @return mixed
     * The sanitise function sanitises data for security - it can sanitise in a range of different
     * methods using the PHP inbuilt filter_var() function
     */
    public static function sanitise($p_data, $p_type="") {
        if ($p_type == "") {
            $p_data = filter_var(filter_var($p_data,FILTER_SANITIZE_STRING), FILTER_SANITIZE_URL);
        } else if($p_type == "string") {
            $p_data = filter_var($p_data, FILTER_SANITIZE_STRING);
        } else if ($p_type == "email") {
            $p_data = filter_var($p_data, FILTER_SANITIZE_EMAIL);
        } else if ($p_type == "url") {
            $p_data = filter_var($p_data, FILTER_SANITIZE_URL);
        } else if ($p_type == "page") {
            $p_data = str_replace('/','',stripslashes(filter_var(filter_var($p_data, FILTER_SANITIZE_STRING), FILTER_SANITIZE_STRIPPED)));
        } else if ($p_type == "array") {
            foreach($p_data as $p_data_element) {
                $p_data_element = Functions::sanitise($p_data_element, "string");
            }
        }
        return $p_data;
    }

    /**
     * @return string
     * This function returns a list of javascript files which will be included in
     * every single page within this exercise
     */
    public static function javascript() {
        $m_javascript_array = array(
            "public/js/jquery-2.1.1.min.js?ver=1.00",
            "public/js/main.js?ver=1.00",
        );

        $m_javascript = "";
        foreach($m_javascript_array as $m_javascript_array_element) {
            $m_javascript .= '<script type="text/javascript" src="'.$m_javascript_array_element.'"></script>';
        }
        return $m_javascript;
    }

    /**
     * @return string
     * This function returns a list of css files which will be included in
     * every single page within this exercise
     */
    public static function css() {
        $m_css_array = array(
            "public/css/main.css",
        );

        $m_css = "";
        foreach($m_css_array as $m_css_array_element) {
            $m_css .= '<link rel="stylesheet" type="text/css" href="'.$m_css_array_element.'" >';
        }
        return $m_css;
    }

    /**
     * This function defines certain constants and sets the time location
     * incase it has not been set correctly in the server settings
     */
    public static function do_definitions() {
        date_default_timezone_set('Europe/London');
        define('DIR_SEP', DIRECTORY_SEPARATOR);
        define('DOC_ROOT', realpath($_SERVER["DOCUMENT_ROOT"].DIR_SEP.'bbc_exercise'));
        define('DOC_ROOT_URL', rtrim($_SERVER["PHP_SELF"], 'index.php'));
    }
} 