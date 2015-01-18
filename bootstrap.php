<?php
/**
 * This is the bootstrap file which contains an spl_autoloader to securely autoload
 * the classes when they are needed
 */
include_once "includes/Functions.php";
Functions::do_definitions();
/**
 * @param $p_class_name
 * This is the custom spl_autoload class which will load the classes
 * from the directories within this project
 */
function bbc_excercise_autoload($p_class_name) {
    $m_file_name = $p_class_name.".php";
    $m_file_directories = array("model","view", "controller");
    foreach ($m_file_directories as $m_directory) {
        $m_file_name_path = DOC_ROOT.DIR_SEP.$m_directory.DIR_SEP.$m_file_name;
        if (file_exists($m_file_name_path)) {
            require_once $m_file_name_path;
        }
    }
}
spl_autoload_register('bbc_excercise_autoload');
include_once "includes/Router.php";
new Router;