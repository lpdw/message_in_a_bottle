$( document ).ready(function() {






    $.getJSON( "/json/jdvelh.json", function( data ) {

        
        // ON PLACE MANUELEMENT LA PREMIERE QUESTION ! 
        $(".story").append("<p>"+data.story["0"].desc+"</p></br><button class='button' id='1'>"+data.story["0"].action+"</button>");

        


      $(document).on('click','.button',function(){

            // l'id est récupéré du précédent clic
            var i = $(this).attr('id'); // BUG : fonctionnel mais récupere le premier id, bug quand plusieurs
            console.log("l'id est égal à : "+i);


            var q = data.story[i].reponse;
            console.log('les réponses sont : '+q)

            $(".story").empty();
            console.log(q.length);
            
            
            $(".story").append("<p>"+data.story[i].desc+"</p></br>");

            for(a = 0; a < q.length; a++){
                $('.story').append("<button class='button' id="+q[a]+">"+data.story[q[a]].action+"</button>");
            }

        });
    });
});