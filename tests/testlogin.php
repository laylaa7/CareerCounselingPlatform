<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Career Counseling</title>
  <!-- Add your CSS and icon links here -->
  <link href="../public/assets/styles/main.css" rel="stylesheet">
   
</head>

<body class="index-page">
  <!-- Header and Navigation -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="../index.html" class="logo d-flex align-items-center me-auto">
        <img src="../public/assets/images/logo.png" alt="">
        <h1 class="sitename">Career Counseling</h1>
      </a>
      
      <!-- Navigation Links -->
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <!-- Other menu items -->
          <li><a href="#contact">Contact</a></li>
        </ul>
      </nav>

      <!-- Login Button that opens modal -->
      <a class="btn-getstarted flex-md-shrink-0" href="javascript:void(0);">Login</a>
    </div>
  </header>

  <!-- Modal Structure -->
  <div id="loginModal" class="modal" style="display:none;">
    <div class="modal-content">
      <span class="close">&times;</span>
      <div id="loginFormContainer"></div> <!-- Loaded login form will display here -->
    </div>
  </div>

  <!-- JavaScript to handle modal functionality -->
  <script>
   var modal = document.getElementById("loginModal");
 var btn = document.querySelector(".btn-getstarted");
 var closeBtn = document.querySelector(".close");

 // Open modal and fetch login form
 btn.onclick = function () {
     modal.style.display = "block";
     fetch("login.html")  // Adjust path if needed
         .then(response => response.text())
         .then(data => {
             document.getElementById("loginFormContainer").innerHTML = data;
             initLoginForm();  // Initialize the login form after loading it
         });
 }

 // Close the modal when clicking the 'X' button
 closeBtn.onclick = function () {
     modal.style.display = "none";
 }

 // Close modal when clicking outside of it
 window.onclick = function (event) {
     if (event.target == modal) {
         modal.style.display = "none";
     }
 }

 // Function to initialize the login form
 function initLoginForm() {
     $(".input input").focus(function () {
         $(this).parent(".input").each(function () {
             $("label", this).css({
                 "line-height": "18px",
                 "font-size": "18px",
                 "font-weight": "100",
                 "top": "0px"
             });
             $(".spin", this).css({
                 "width": "100%"
             });
         });
     }).blur(function () {
         $(".spin").css({
             "width": "0px"
         });
         if ($(this).val() == "") {
             $(this).parent(".input").each(function () {
                 $("label", this).css({
                     "line-height": "60px",
                     "font-size": "24px",
                     "font-weight": "300",
                     "top": "10px"
                 });
             });
         }
     });

     $(".button").click(function (e) {
         var pX = e.pageX,
             pY = e.pageY,
             oX = parseInt($(this).offset().left),
             oY = parseInt($(this).offset().top);

         $(this).append('<span class="click-efect x-' + oX + ' y-' + oY + '" style="margin-left:' + (pX - oX) + 'px;margin-top:' + (pY - oY) + 'px;"></span>');
         $('.x-' + oX + '.y-' + oY + '').animate({
             "width": "500px",
             "height": "500px",
             "top": "-250px",
             "left": "-250px",
         }, 600);
         $("button", this).addClass('active');
     });

     $(".alt-2").click(function () {
         if (!$(this).hasClass('material-button')) {
             $(".shape").css({
                 "width": "100%",
                 "height": "100%",
                 "transform": "rotate(0deg)"
             });

             setTimeout(function () {
                 $(".overbox").css({
                     "overflow": "initial"
                 });
             }, 600);

             $(this).animate({
                 "width": "140px",
                 "height": "140px"
             }, 500, function () {
                 $(".box").removeClass("back");
                 $(this).removeClass('active');
             });

             $(".overbox .title").fadeOut(300);
             $(".overbox .input").fadeOut(300);
             $(".overbox .button").fadeOut(300);

             $(".alt-2").addClass('material-buton');
         }
     });

     $(".material-button").click(function () {
         if ($(this).hasClass('material-button')) {
             setTimeout(function () {
                 $(".overbox").css({
                     "overflow": "hidden"
                 });
                 $(".box").addClass("back");
             }, 200);
             $(this).addClass('active').animate({
                 "width": "700px",
                 "height": "700px"
             });

             setTimeout(function () {
                 $(".shape").css({
                     "width": "50%",
                     "height": "50%",
                     "transform": "rotate(45deg)"
                 });

                 $(".overbox .title").fadeIn(300);
                 $(".overbox .input").fadeIn(300);
                 $(".overbox .button").fadeIn(300);
             }, 700);

             $(this).removeClass('material-button');
         }

         if ($(".alt-2").hasClass('material-buton')) {
             $(".alt-2").removeClass('material-buton');
             $(".alt-2").addClass('material-button');
         }
     });
 }
  </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="login.js"></script>
</body>
</html>
