<?php

/**
 * Class ErrorView
 * This class creates the Error View
 */
class ErrorView {
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
            <p>There has been an error...</p>
        </div>
HTML;
        return $m_page_data;
    }

    /**
     * @return mixed
     * This is the metadata to be included on the page
     */
    public function metadata() {
        $m_metadata['title'] = "Error";
        return $m_metadata;
    }
} 