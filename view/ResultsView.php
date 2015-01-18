<?php

/**
 * Class ResultsView
 * This class creates the Results View
 */
class ResultsView {
    private $c_data;

    /**
     * @param $p_data
     * @return string
     * This function creates the page data for this view
     */
    public function page_data($p_data) {
        $doc_root_url = DOC_ROOT_URL;
        if ($p_data['status']) {
            $this->c_data .= <<< HTML
            <div class="table_row">
                Error $p_data[status] - BBC API Connection Problem
                <div style="word-wrap: break-word;">$p_data[message]</div>
            </div>
HTML;
        } else if ($p_data[1]) {
            $m_json_data = json_encode($p_data[1]);
            $m_row_number = 0;
            foreach($p_data[1] as $p_data_element) {
                $m_row_number++;
                $m_formatted_date = date('l jS \of F Y H:i:s', strtotime($p_data_element['ondemand_start']));
                $m_formatted_duration = floor($p_data_element['duration']/60)." minutes";
                if ($p_data_element['image']) {
                    $p_data_element_image = str_replace('$recipe', "272x153", $p_data_element['image']);
                    $p_data_image_html = "<a href=\"http://www.$p_data_element[url]\" target=\"_blank\"><img style=\"width:70px;\" alt=\"$p_data_element[complete_title]\" src=\"$p_data_element_image\"/></a>";
                } else {
                    $p_data_image_html = "<a href=\"http://www.$p_data_element[url]\" target=\"_blank\">More Info</a>";
                }
                $this->c_data .= <<< HTML
                <div class="table_row" id="table_row_$m_row_number">
                    <div class="table_row_element_tiny">
                        $p_data_image_html
                    </div>
                    <div class="table_row_element_large">
                        $p_data_element[complete_title]
                    </div>
                    <div class="table_row_element_large table_row_element_synopsis" title="$p_data_element[synopsis]">
                        $p_data_element[short_synopsis]
                    </div>
                    <div class="table_row_element">
                        $p_data_element[masterbrand_title]
                    </div>
                    <div class="table_row_element">
                        $m_formatted_date
                    </div>
                    <div class="table_row_element_small">
                        $m_formatted_duration
                    </div>
                </div>
HTML;
                $m_total_pages =  ceil($p_data[0][1]/10);
                $m_page_no = $p_data[0][0];
                if ($m_page_no > 1 && $m_page_no != $m_total_pages) {
                    $m_next_page = ($m_page_no+1);
                    $m_prev_page = ($m_page_no-1);
                    $m_pagination = <<< HTML
                    <div id="table_pagination_controls">
                        <a onclick="change_page(1);return false;"><-- First Page</a>
                        |
                        <a onclick="change_page($m_prev_page);return false;">< Previous Page</a>
                        |
                        <a onclick="change_page($m_next_page);return false;">Next Page ></a>
                        |
                        <a onclick="change_page($m_total_pages);return false;">Last Page --></a>
                    </div>
HTML;
                } else if ($m_page_no == 1) {
                    if ($m_page_no != $m_total_pages) {
                        $m_next_page = ($m_page_no+1);
                        $m_pagination = <<< HTML
                        <div id="table_pagination_controls">
                            <a onclick="change_page($m_next_page);return false;">Next Page ></a>
                            |
                            <a onclick="change_page($m_total_pages);return false;">Last Page --></a>
                        </div>
HTML;
                    }
                } else if ($m_page_no == $m_total_pages) {
                    $m_prev_page = ($m_page_no-1);
                    $m_pagination = <<< HTML
                    <div id="table_pagination_controls">
                        <a onclick="change_page(1);return false;"><-- First Page</a>
                        |
                        <a onclick="change_page($m_prev_page);return false;">< Previous Page</a>
                    </div>
HTML;
                }

                $m_table_pagination = <<< HTML
                    <div id="table_pagination">
                        Page $m_page_no of $m_total_pages
                        $m_pagination
                    </div>
HTML;
            }
            $this->c_data .= <<< HTML
            <div id="json_results_data">$m_json_data</div>
HTML;
        } else {
            $this->c_data .= <<< HTML
            <div class="table_row">
                No Results
            </div>
HTML;
        }
        $m_page_details = $p_data[0][2];
        $m_page_data = <<< HTML
        <div class="content">
            <div id="table">
                <div id="table_wrapper">
                    <input type="hidden" id="iplayer_search" value="$m_page_details[iplayer_search]"/>
                    <input type="hidden" id="iplayer_search_type_filter" value="$m_page_details[iplayer_search_type_filter]"/>
                    <input type="hidden" id="iplayer_search_media_filter" value="$m_page_details[iplayer_search_media_filter]"/>
                    <input type="hidden" id="iplayer_search_page" value="$m_page_details[iplayer_search_page]"/>
                    <div id="table_header">
                        <div class="table_header_element_tiny"></div>
                        <div class="table_header_element_large"><a onclick="sort_results('complete_title');return false;">Episode Title</a></div>
                        <div class="table_header_element_large"><a onclick="sort_results('synopsis');return false;">Synopsis</a></div>
                        <div class="table_header_element"><a onclick="sort_results('masterbrand_title');return false;">Service</a></div>
                        <div class="table_header_element"><a onclick="sort_results('ondemand_start');return false;">Broadcast Time</a></div>
                        <div class="table_header_element_small"><a onclick="sort_results('duration');return false;">Duration</a></div>
                    </div>
                    <div id="table_content">
                        $this->c_data
                    </div>
                </div>
            </div>
            $m_table_pagination
            <a href="$doc_root_url">Back To Search</a>
        </div>
HTML;
        return $m_page_data;
    }

    /**
     * @return mixed
     * This function creates the metadata for this view
     */
    public function metadata() {
        $m_metadata['title'] = "BBC Programme Finder - Results";
        // Files to be included only for this particular page
        $m_metadata['include'] = "<link rel='stylesheet' type='text/css' href='public/css/results.css?ver=1.00'>
                                  <script type='text/javascript' src='public/js/results.js?ver=1.00'></script>
                                  <script type='text/javascript' src='public/js/jquery-ui.js?ver=1.00'></script>";
        return $m_metadata;
    }
} 