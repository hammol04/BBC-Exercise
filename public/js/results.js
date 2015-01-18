var sort_order = "0";
$j(document).ready(function () {
    $j(document).tooltip();
});

function sort_results(sort_by) {
    var results_array = (JSON.parse($j("#json_results_data").text()));
    if (sort_order == "1") {
        sort_order = "0";
    } else if(sort_order == "0") {
        sort_order = "1";
    }
    $j.ajax({
        url: "view/ajax/ajax_ResultsView.php",
        type: "post",
        data: {
            action: 'sort_ion_json',
            results_array: results_array,
            sort_by: sort_by,
            sort_order: sort_order
        }, success: function(data){
            $j("#table_content").hide().html(data).fadeIn('slow');
        }
    });
}

function change_page(page_no) {
    $j.ajax({
        url: "/bbc_exercise/results",
        type: "post",
        data: {
            iplayer_search: $j("#iplayer_search").val(),
            iplayer_search_type_filter: $j("#iplayer_search_type_filter").val(),
            iplayer_search_media_filter: $j("#iplayer_search_media_filter").val(),
            iplayer_search_page: page_no
        }, success: function(data){
            var new_document = document.open("text/html", "replace");
            new_document.write(data);
            new_document.close();
        }
    });
}