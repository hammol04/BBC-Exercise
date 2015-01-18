<?php
/**
 * This AJAX file is for the ResultsView
 */
if ($_POST['action'] == 'sort_ion_json') {
    date_default_timezone_set('Europe/London');
    if (is_array($_POST['results_array'])) {
        $m_html = "";
        $m_data = $_POST['results_array'];
        foreach($m_data as $m_row) {
            foreach($m_row as $m_row_key => $m_row_value) {
                if ($m_row_key == 'ondemand_start') {
                    $m_{$m_row_key}[] = date(strtotime($m_row_value));
                } else {
                    $m_{$m_row_key}[] = $m_row_value;
                }
            }
        }
        array_multisort($m_{$_POST['sort_by']}, $_POST['sort_order'] == "1" ? SORT_ASC : SORT_DESC, $m_data);

        $m_json_data = json_encode($m_data);
        $m_row_number = 0;
        foreach($m_data as $p_data_element) {
            $m_row_number++;
            $m_formatted_date = date('l jS \of F Y H:i:s', strtotime($p_data_element['ondemand_start']));
            $m_formatted_duration = floor($p_data_element['duration']/60)." minutes";
            if ($p_data_element['image']) {
                $p_data_element_image = str_replace('$recipe', "272x153", $p_data_element['image']);
                $p_data_image_html = "<a href=\"http://www.$p_data_element[url]\" target=\"_blank\"><img style=\"width:70px;\" alt=\"$p_data_element[complete_title]\" src=\"$p_data_element_image\"/></a>";
            } else {
                $p_data_image_html = "<a href=\"http://www.$p_data_element[url]\" target=\"_blank\">More Info</a>";
            }
            $m_html .= <<< HTML
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
        }
        $m_html .= <<< HTML
            <div id="json_results_data">$m_json_data</div>
HTML;
    }
    echo $m_html;
}