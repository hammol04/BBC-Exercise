<?php
/**
 * This AJAX file is for the IndexView
 */
if ($_POST['action'] == 'get_ion_json') {
    if (isset($_POST['term'])) {
        $m_filter_text = "";
        $m_filter_media_text = "";
        if ($_POST['filter'] != 0) {
            if ($_POST['filter'] == 1) {
                $m_filter_text = "service_type/tv/";
            } else if ($_POST['filter'] == 2) {
                $m_filter_text = "service_type/radio/";
            }
        }
        if ($_POST['filter_media'] != 0) {
            if ($_POST['filter_media'] == 1) {
                $m_filter_media_text = "search_availability/iplayer/";
            } else if ($_POST['filter_media'] == 2) {
                $m_filter_media_text = "search_availability/discoverable/";
            } else if ($_POST['filter_media'] == 3) {
                $m_filter_media_text = "search_availability/ondemand/";
            } else if ($_POST['filter_media'] == 4) {
                $m_filter_media_text = "search_availability/simulcast/";
            } else if ($_POST['filter_media'] == 5) {
                $m_filter_media_text = "search_availability/comingup/";
            }
        } else {
            $m_filter_media_text = "search_availability/any/";
        }
        $m_url = "http://www.bbc.co.uk/iplayer/ion/searchextended/".$m_filter_media_text.$m_filter_text."page/1/perpage/10/format/json/q/".rawurlencode($_POST['term']);
        $m_ch = curl_init();
        curl_setopt($m_ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($m_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($m_ch, CURLOPT_URL, $m_url);
        $m_result = curl_exec($m_ch);
        curl_close($m_ch);
        if (isset($m_result)) {
            $m_result = json_decode($m_result, true);
            $m_title_array = "";
            if ($m_result['blocklist']) {
                foreach($m_result['blocklist'] as $m_search_results) {
                    $m_title_array[] = $m_search_results['passionsite_title'];
                }
                echo json_encode(array_unique($m_title_array));
            } else {
                echo json_encode(array("No Results"));
            }
        }
    }
}