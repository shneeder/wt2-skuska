// JavaScript Document
$(document).ready(function(){
    $("#startGeocode").click(function(){
      $.ajax({
         success: function(){
            window.location.href = '/bod11/geocoding.php';
            }
      });
    });
    $("#naspat").click(function(){
      $.ajax({
         success: function(){
            window.location.href = '/bod11/admin.php';
            }
      });
    });
    $("#showSko").click(function(){
      $.ajax({
         success: function(){
            window.location.href = '/map?show=skoly';
            }
      });
    });
    $("#showByd").click(function(){
      $.ajax({
         success: function(){
            window.location.href = '/map?show=bydliska';  
            }
      });
    });
});
