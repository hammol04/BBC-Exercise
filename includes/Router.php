<?php

/**
 * Class Router
 * The Router class actually routes the user from the parameters they have entered in the URL
 */
class Router {
private $c_page;

    /**
     * The constructor for the Router class reads the URL parameters and then directs
     * the user accordingly
     */
    public function __construct() {
        $m_page = preg_replace('#\\/(.+)\\/{1}#','',$_SERVER['REQUEST_URI']);
        $m_elements = explode('/', $m_page);
        if ($m_elements[0]) {
                $this->c_page = Functions::sanitise(strtolower($m_elements[0]), 'page');
                $this->route_page($this->c_page);
        } else {
            $this->route_page('index');
        }
    }

    /**
     * @param string $p_page
     * The route_page() function determines where the user will be routed too
     */
    private function route_page($p_page = "") {
        //  case url param  =>  Class name
        switch($p_page) {
            case 'index'    :   $this->do_routing('Index');     break;
            case 'results'  :   $this->do_routing('Results');   break;
            default         :   $this->do_routing('Error');     break;
        }
    }

    /**
     * @param $p_page
     * The do_routing() function will instantiate the RouterController class and routes the user
     */
    private function do_routing($p_page) {
        Functions::do_definitions();
        new RouterController($p_page);
    }
}