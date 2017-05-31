$(document).on('click', '.bottlemessage_p', function() {
    var messagebox = $(this).parent();
    var idbottle = messagebox.attr('idbottle');
    var message = messagebox.text().replace(/\s/g,'').replace(/"/g,'');
    $(this).empty();
    messagebox.append('<form><input type="text" name="textmessage" placeholder="'+message+'"><br><input class="validatemessage" type="button" value="OK" okidbottle="'+idbottle+'"></form>')
});

$(document).on('click', '.validatemessage', function() {
    var idbottle = $(this).attr('okidbottle');
    var messagebox = $("[idbottle="+idbottle+"]");
    var currenttext = messagebox.find('input:first').val();

    if(currenttext) {
        console.log(currenttext);
        messagebox.empty();

        $.ajax({
            method:"POST",
            url: Routing.generate("update_bottle_message", { id: idbottle}),
            data: {newmessage: currenttext},

            success: function(result, status) {
                console.log("OK : "+result);

            },
            error: function(result, status, error) {
                console.log("KO : "+error);
            }
        });

        messagebox.append('<p class="bottlemessage_p">"'+currenttext+'"</p>');
    }
    else {
        var placeholder = messagebox.find('input:first').attr('placeholder');
        messagebox.empty();
        messagebox.append('<p class="bottlemessage_p">"'+placeholder+'"</p>');

    }

});
