<?php

/**
 * Class Controller
 * This class gets any necessary data and then creates the view
 */
class Controller {
    protected $c_page;
    protected $c_data;

    /**
     * @param $p_page
     * This function is the constructor and builds the view
     */
    public function __construct($p_page) {
        $this->c_page = $p_page;
        $this->build_view($p_page);
    }

    /**
     * @param $p_data
     * This sets the data for the class
     */
    protected function set_data($p_data) {
        $this->c_data = $p_data;
    }

    /**
     * @return mixed
     * This gets the data of the class
     */
    protected function get_data() {
        return $this->c_data;
    }

    /**
     * @param $p_page
     * This creates the View Class and passes data from the controller into it
     */
    protected function build_view($p_page) {
        new View($p_page, $this->get_data());
    }
} 