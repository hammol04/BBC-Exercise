<?php

/**
 * Class ResultsModel
 * The ResultsModel class gets the data from the BBC API and returns it to the Controller
 */
class ResultsModel {

    /**
     * @param $p_term
     * @param $p_filter
     * @param $p_filter_media
     * @param $p_filter_page
     * @return array
     * The get_ion_json_data() function calls the BBC API using cURL and returns an array to be displayed later
     */
    public function get_ion_json_data($p_term, $p_filter, $p_filter_media, $p_filter_page) {
        $m_filter_text = "";
        $m_filter_media_text = "";
        if (!$p_filter_page) {
            $p_filter_page = "1";
        }
        if ($p_filter != 0) {
            if ($p_filter == 1) {
                $m_filter_text = "service_type/tv/";
            } else if ($p_filter == 2) {
                $m_filter_text = "service_type/radio/";
            }
        }
        if ($p_filter_media != 0) {
            if ($p_filter_media == 1) {
                $m_filter_media_text = "search_availability/iplayer/";
            } else if ($p_filter_media == 2) {
                $m_filter_media_text = "search_availability/discoverable/";
            } else if ($p_filter_media == 3) {
                $m_filter_media_text = "search_availability/ondemand/";
            } else if ($p_filter_media == 4) {
                $m_filter_media_text = "search_availability/simulcast/";
            } else if ($p_filter_media == 5) {
                $m_filter_media_text = "search_availability/comingup/";
            }
        } else {
            $m_filter_media_text = "search_availability/any/";
        }
        $m_url = "http://www.bbc.co.uk/iplayer/ion/searchextended/".$m_filter_media_text.$m_filter_text."per_page/10/page/".$p_filter_page."/format/json/q/".rawurlencode($p_term);
        $m_ch = curl_init();
        curl_setopt($m_ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($m_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($m_ch, CURLOPT_URL, $m_url);
        $m_result = curl_exec($m_ch);
        curl_close($m_ch);
        $m_json_data = "";
        if (isset($m_result)) {
            $m_result = json_decode($m_result, true);
            if ($m_result['blocklist']) {
                foreach($m_result['blocklist'] as $m_search_results) {
                    $m_json_data[] = array(     'complete_title' => $m_search_results['complete_title'],
                                                'masterbrand_title' => $m_search_results['masterbrand_title'],
                                                'ondemand_start' => $m_search_results['ondemand_start'],
                                                'synopsis' => $m_search_results['synopsis'],
                                                'short_synopsis' => $m_search_results['short_synopsis'],
                                                'duration' => $m_search_results['duration'],
                                                'image' => $m_search_results['image_template_url'],
                                                'url' => $m_search_results['my_short_url'],
                    );
                }
                return array(
                    array(Functions::sanitise($m_result['pagination']['page']),
                        Functions::sanitise($m_result['pagination']['total_count']),
                        Functions::sanitise(array("iplayer_search"  =>  $p_term,
                                "iplayer_search_type_filter"        =>  $p_filter,
                                "iplayer_search_media_filter"       =>  $p_filter_media,
                                "iplayer_search_page"               =>  $p_filter_page)
                            , 'array'),
                    ),
                    Functions::sanitise($m_json_data, 'array')
                );
            } else if ($m_result['error']) {
                return array("status" => Functions::sanitise($m_result['error']['status']), "message" => Functions::sanitise($m_result['error']['message']));
            }
        }
    }
}