$j(document).ready(function () {
    $j("#iplayer_search").autocomplete({
        source: function(request, response) {
            $j.ajax({
               url: "view/ajax/ajax_IndexView.php",
               type: "post",
               dataType: "json",
               data: {
                   action: 'get_ion_json',
                   term: request.term,
                   filter: $j("#iplayer_search_type_filter").val(),
                   filter_media: $j("#iplayer_search_media_filter").val()
               }, success: function(data){
                    response(data);
               }
            });
        },
        minLength: 3,
        select: function(event, ui) {
            $j(this).val(ui.item.label);
        }
    });

    $j("#iplayer_search_submit").click(function() {
        if ($j("#iplayer_search").val() == "" || $j("#iplayer_search").val() == "No Results") {
            $j("#iplayer_search_wrapper").css('border', '1px solid red');
            return false;
        }
        return true;
    })

});