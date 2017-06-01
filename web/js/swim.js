$(document).on('change', '.beach_swim', function() {
    var li = $(this).parent();
    var select = li.find('select');
    var direction_val = select.find(":selected").val();
    var direction_text = select.find(":selected").text();

    if(direction_val.includes('NORD') || direction_val.includes('SUD')) {
        var article="le ";
    }
    else {
        var article = "l'";
    }
    var swimming = confirm('Nager vers '+article+direction_text+' ?');

    if (swimming) {

        $.ajax({
            method: "POST",
            url: Routing.generate("moveInIsland", { type: "swimming", direction: direction_val}),

            success: function(result, status) {
                console.log("OK : "+result);
                var newDoc = document.open("text/html", "replace");
                newDoc.write(result);
                newDoc.close();
            },

            error: function(result, status, error) {
                console.log("KO : "+error);
                li.find('p').fadeIn("slow");
                li.find('p').delay(2000).fadeOut("slow");
                select.prop('selectedIndex',0);
            }
        });
    }


});
