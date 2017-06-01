$( document ).ready(function() {
    $.getJSON( "/json/jdvelh.json", function( data ) {
        // ON PLACE MANUELEMENT LA PREMIERE QUESTION !
        $(".story").append("<p>"+data.story["0"].desc+"</p></br><button class='buttonForest' id='1'>"+data.story["0"].action+"</button>");
      $(document).on('click','.buttonForest',function(){
      
            // l'id est récupéré du précédent clic
            var i = $(this).attr('id');
            console.log("l'id est égal à : "+i);
            
            // recupere les reponses de la question correspondant a l'id
            var q = data.story[i].reponse;
            console.log('les réponses sont : '+q)
            // on vide la story
            $(".story").empty();
            console.log(q.length);

            // on affiche la description de la question
            $(".story").append("<p>"+data.story[i].desc+"</p></br>");

            if (data.story[i].style == "choice")
            {
              for(a = 0; a < q.length; a++)
              {
                  $('.story').append("<button class='buttonForest' id="+q[a]+">"+data.story[q[a]].action+"</button>");
              };
            }
            // on affiche les questions de maniere aléatoire suivantes si style = random
            else
            {
              console.log("nombre de reponses : "+q.length);
              a = Math.floor(Math.random()*q.length);
              console.log("reponse donnee: "+a);
              $('.story').append("<button class='buttonForest' id="+q[a]+">"+data.story[q[a]].action+"</button>");

            };

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
        });
    });
});
