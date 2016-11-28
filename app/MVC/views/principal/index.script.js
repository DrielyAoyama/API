$( document ).ready(function() 
{
    var controller = "{{$_SESSION['controller']}}";
    $('#MENU'+controller).addClass("active"); 
});