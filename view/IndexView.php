<?php

/**
 * Class IndexView
 * This class creates the Index View
 */
class IndexView {
    private $c_data;

    /**
     * @param $p_data
     * @return string
     * This is the page data for this view
     */
    public function page_data($p_data) {
        $this->c_data = $p_data;
        $m_page_data = <<< HTML
        <div class="content">
            <p>Please type to search for a programme on the BBC</p>
            <form action="$_SERVER[REQUEST_URI]results" id="iplayer_search_form" method="post">
                <div id="iplayer_search_wrapper">
                    <input type="text" name="iplayer_search" id="iplayer_search" placeholder="Find a programme on the BBC">
                    <select name="iplayer_search_media_filter" id="iplayer_search_media_filter">
                        <option value="1">iPlayer</option>
                        <option value="2">Discoverable</option>
                        <option value="3">On Demand</option>
                        <option value="4">Simulcast</option>
                        <option value="5">Coming Up</option>

                    </select>
                    <select name="iplayer_search_type_filter" id="iplayer_search_type_filter">
                        <option value="0">All Platforms</option>
                        <option value="1">TV</option>
                        <option value="2">Radio</option>
                    </select>
                    <input type="submit" id="iplayer_search_submit" value="Find">
                    <div style="clear:both;"></div>
                </div>
                <input type="hidden" id="search_submitted" name="search_submitted" val="1">
            </form>
        </div>
HTML;
        return $m_page_data;
    }

    /**
     * @return mixed
     * This is the metadata to be included for this view
     */
    public function metadata() {
        $m_metadata['title'] = "BBC Programme Finder";
        // Files to be included only for this particular page
        $m_metadata['include'] = "<link rel='stylesheet' type='text/css' href='public/css/index.css?ver=1.00'>
                                  <script type='text/javascript' src='public/js/index.js?ver=1.00'></script>
                                  <script type='text/javascript' src='public/js/jquery-ui.js?ver=1.00'></script>";
        return $m_metadata;
    }
} 