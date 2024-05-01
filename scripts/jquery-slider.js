$(document).ready(function(){
    $("#f-slider").slideUp("fast");
    $("#f-slider2").slideUp("fast");

    $("#following").click(function(){
        $("#f-slider").slideToggle("slow");
        $("#f-slider2").slideUp("fast");
    });

    $("#followers").click(function(){
        $("#f-slider2").slideToggle("slow");
        $("#f-slider").slideUp("fast");
    });
});