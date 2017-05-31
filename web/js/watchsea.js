$(document).on('click', '.watchsea', function() {
    var oldInfo = $('.seainfo');
    oldInfo.fadeOut().remove();


    $.ajax({
        method:"POST",
        url: Routing.generate("watchSea"),

        success: function(result, status) {
            var html = $('.beach_watchsea');
            var infos = JSON.parse(result);

            infos.forEach(function(value, index) {
                html.append('<span class="seainfo">'+value+'...</span> ');
                $('.seainfo').fadeIn();
            });
        },

        error: function(result, status, error) {
            console.log("KO : "+error);
        }
    });
});
