<?php

/**
 * Class RouterController
 * This class creates the necessary controller for the parameter which has been passed into it
 */
class RouterController {
    /**
     * @param $p_page
     * This is the constructor for the RouterController class and calls the create_controller() function
     */
    public function __construct($p_page) {
        $this->create_controller($p_page);
    }

    /**
     * @param $p_page
     * This is the create_controller function which instantiates the Controller Class depending on the parameter
     */
    private function create_controller($p_page) {
        $m_class_name = "{$p_page}Controller";
        new $m_class_name($p_page);
    }
}