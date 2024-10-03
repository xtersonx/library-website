
//for the drawer
$(document).ready(function() {
    $('.btn').click(function() {
      $(this).toggleClass("click");
      $('.sidebar').toggleClass("show");
    });
  
    $('.feat-btn').click(function() {
      $('nav ul .feat-show').toggleClass("show");
      $('nav ul .first').toggleClass("rotate");
    });
  
  });













