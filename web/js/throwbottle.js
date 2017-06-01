$(document).on('change', '.throwbottle', function() {
    var throwBottle = confirm('Jeter cette bouteille à la mer ?');

    if (throwBottle) {

        var li = $(this).parent();
        var idBottle = li.attr('idbottle');
        li.fadeOut();

        var direction = li.find('select').find(":selected").val();
        console.log(direction);

        $.ajax({
            method: "POST",
            url: Routing.generate("launchBottle", { id: idBottle}),
            data: {direction: direction},

            success: function(result, status) {
                console.log("OK : "+result);
            },

            error: function(result, status, error) {
                console.log("KO : "+error);
            }
        });

        li.remove();
    }


});
