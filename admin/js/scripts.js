

$(document).ready(function () {
    
    
    
    $('#selectAllBoxes').click(function (event) {
        if (this.checked) {
            $('.checkBoxes').each(function () {
                this.checked = true;
            });
        } else {
            $('.checkBoxes').each(function () {
                this.checked = false;
            });
        }
    });
    
    
    //loading page in admin_header.
//    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
//    $("body").prepend(div_box);
//    $('#load-screen').delay(700).fadeOut(600, function(){
//        $(this).remove();
//    });
});

function loadUsersOnline(){
    $.get("functions.php?onlineusers=result", function(data){
        $(".usersonline").text(data);
    });
}
//loadUsersOnline();
//every half of one second it will be work.
setInterval(function(){
    loadUsersOnline();
},500);


