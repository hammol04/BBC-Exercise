<?php

/**
 * Class View
 * The View class contains the HTML that will be included on all the views it generates
 */
class View {
    private $c_view;
    protected $c_data;
    public function __construct($p_view, $p_data = "") {
        if (isset($p_data)) {
            $this->c_data = $p_data;
        }
        $this->c_view = $p_view;
        echo $this->build_view();
    }

    /**
     * @param $m_metadata
     * @return string
     * This is the header view which will contain the header
     */
    private function header_view($m_metadata) {
        $m_javascript = Functions::javascript();
        $m_css = Functions::css();
        $m_metadata_include =  isset($m_metadata['include']) ? $m_metadata['include'] : "";
        $doc_root_url = DOC_ROOT_URL;
        $m_header_view = <<< HTML
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>$m_metadata[title]</title>
                $m_javascript
                $m_css
                $m_metadata_include
            </head>
        <body>
        <div id="header">
            <div class="content">
                <h2><a href="$doc_root_url">BBC Programme Finder</a></h2>
            </div>
        </div>
        <div id="container">
HTML;
        return $m_header_view;

    }

    /**
     * @return string
     * This is the footer view which will contain the footer
     */
    private function footer_view() {
        $m_footer_view = <<< HTML
        </div>
        <div id="footer">
            <p>Laurence Hammond</p>
        </div>
    </body>
</html>
HTML;
        return $m_footer_view;
    }

    /**
     * @return array
     * This function will instantiate the appropriate view for the user
     */
    private function create_view() {
        $m_view = "view/".$this->c_view."View.php";

        if (file_exists($m_view)) {
            $m_class_name = "{$this->c_view}View";
            $m_view_obj = new $m_class_name;
            return array(
                "page_data" => $m_view_obj->page_data($this->c_data),
                "metadata" => $m_view_obj->metadata()
            );
        } else {
            die("Error");
        }
    }

    /**
     * @return string
     * This function will build the view by calling the different functions within this class
     */
    private function build_view() {
        $m_view = "";
        $m_view_array = $this->create_view();

        // get header first
        $m_view .= $this->header_view($m_view_array["metadata"]);

        // get data
        $m_view .= $m_view_array["page_data"];

        // get footer
        $m_view .= $this->footer_view();

        return $m_view;
    }
} 