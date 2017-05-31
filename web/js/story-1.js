$( document ).ready(function() {






    $.getJSON( "/json/jdvelh.json", function( data ) {


        // ON PLACE MANUELEMENT LA PREMIERE QUESTION !
        $(".story").append("<p>"+data.story["0"].desc+"</p></br><button class='buttonForest' id='1'>"+data.story["0"].action+"</button>");




      $(document).on('click','.buttonForest',function(){

            // l'id est récupéré du précédent clic
            var i = $(this).attr('id');
            console.log("l'id est égal à : "+i);

            // On ajoute l'item à la bd

            var currentItem = data.story[i].item;
            console.log(data.story[i].item);
            if (currentItem != "null") {
              $.ajax({
                  method:"POST",
                  url: Routing.generate("takeitem", { itemName: currentItem}),

                  success: function(result, status) {
                    console.log("ok");
                  },
                  error: function(result, status, error) {
                      console.log("KO : "+error);
                  }
              });
            }
            //


            var q = data.story[i].reponse;
            console.log('les réponses sont : '+q)

            $(".story").empty();
            console.log(q.length);


            $(".story").append("<p>"+data.story[i].desc+"</p></br>");

            for(a = 0; a < q.length; a++){
                $('.story').append("<button class='buttonForest' id="+q[a]+">"+data.story[q[a]].action+"</button>");
            }

        });
    });
});
