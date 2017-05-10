$(document).ready(function() {
    $(document).on('click', '.put-in-chest-button', function() {
        var currentItem = $(this);
        var currentItemText = currentItem.parent('li').find('p');
        currentItem.parent('li').remove();

        $.ajax({
            method:"POST",
            url: Routing.generate("putinchest", { id: currentItem.attr('itemid')}),

            success: function(result, status) {
                console.log("OK : "+currentItem.html());

                var newButton = '<input type="button" itemid="'+currentItem.attr('itemid')+'" name="take-from-chest" class="take-from-chest-button" value="Prendre">';

                $('.chest_panel ul').append('<li><p>'+currentItemText.html()+'</p>'+newButton+'</li>');
            },
            error: function(result, status, error) {
                console.log("KO : "+error);
            }
        });

    });

    $(document).on('click', '.take-from-chest-button', function() {
        var currentItem = $(this);
        var currentItemText = currentItem.parent('li').find('p');
        currentItem.parent('li').remove();

        $.ajax({
            method:"POST",
            url: Routing.generate("takefromchest", { id: currentItem.attr('itemid')}),

            success: function(result, status) {
                console.log("OK : "+result);

                var newButton = '<input type="button" itemid="'+currentItem.attr('itemid')+'" name="put-in-chest" class="put-in-chest-button" value="Déposer">';

                $('.inventory_panel ul').append('<li><p>'+currentItemText.html()+'</p>'+newButton+'</li>');
            },
            error: function(result, status, error) {
                console.log("KO : "+error);
            }
        });

    });

});
