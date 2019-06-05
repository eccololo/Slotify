$(document).ready(function() {
   $("#hideLogin").click(function() {
        $("#loginForm").hide(500);
        $("#registerForm").show(500);
   });

   $("#hideRegister").click(function() {
    $("#loginForm").show(500);
    $("#registerForm").hide(500);
});
});