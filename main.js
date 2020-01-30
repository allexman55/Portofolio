

$(document).ready(function(){
   

    $("#nav").click(function(){
        $("#nav-body").css('left','0%');
        $("#nav-body").css('z-index','10');
        $(this).css("display", 'none');
    });

    $("#close-nav").click(function(){
        $("#nav-body").css('left','-80%');
        $("#nav-body").css('z-index','10');
        setTimeout(function(){ $("#nav").css("display", 'block'); }, 400);
    });

    $(".change").click(function(){
        var id = $(this).attr("id");
        $.post("uploadProfile.php", {pic: pic, id: id}).done(function(data){
        });
    });

    var check = $("#check").val();
    var uid = $("#uid").val();

    $('#check').click(function(){
        if($(this).prop("checked") == true){
            $.post("ajax.php", {val: "add", check: check, uid: uid}).done(function(data){
                
            });
            $("#heart").removeClass( "text-dark" ).addClass( "text-danger" );
                $("#text").removeClass( "text-dark" ).addClass( "text-danger" );
                $("#text").html("Remove from favorite");
            
        }
        else if($(this).prop("checked") == false){
            $.post("ajax.php", {val: "remove", check: check, uid: uid}).done(function(data){
                
            }); 
            $("#heart").removeClass( "text-danger" ).addClass( "text-dark" );
                $("#text").removeClass( "text-danger" ).addClass( "text-dark" );
                $("#text").html("Add to favorite"); 
        }
    });

    // var postId = $("#postId");
    // $("#deleteAd").click(function(){
    //     $.post("ajax.php?action=deleteAd", {action:action, postId:postId}).done(function(data){

    //     });
    // });

});