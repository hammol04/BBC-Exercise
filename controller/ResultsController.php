<?php

/**
 * Class ResultsController
 * This is the Results Controller which extends Controller
 * This class gets the data from the BBC API
 */
class ResultsController extends Controller {
    /**
     * This is the constructor for the Results Controller class
     */
    public function __construct() {
        if (isset($_POST['iplayer_search'])) {
            $this->set_data($this->get_ion_json_data($_POST['iplayer_search'], $_POST['iplayer_search_type_filter'], $_POST['iplayer_search_media_filter'], $_POST['iplayer_search_page']));
            $this->build_view('Results');
        } else {
            $this->build_view('Error');
        }
    }

    /**
     * @param $p_term
     * @param $p_filter
     * @param $p_filter_type
     * @param $p_filter_page
     * @return mixed
     * This function creates the Results Model and gets data from this model and then returns it
     */
    private function get_ion_json_data($p_term, $p_filter, $p_filter_type, $p_filter_page) {
        $m_results_model = new ResultsModel;
        $m_json_data = $m_results_model->get_ion_json_data($p_term, $p_filter, $p_filter_type, $p_filter_page);
        return $m_json_data;
    }
} 