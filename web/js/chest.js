$(document).ready(function() {
    $('.put-in-chest-button').on('click', function() {
        var currentItem = $(this);
        console.log(currentItem.attr('itemid'));
        currentItem.remove();

        $.ajax({
            method:"POST",
            url: Routing.generate(""),
            data: { itemid: currentItem.attr('itemid'), itemname: currentItem.attr('itemname')},

            success: function(result, status) {

            },
            error: function(result, status, error) {
                
            }
        });
    });
});
