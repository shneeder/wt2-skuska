// JavaScript Document
$(document).ready(function(){
    $("#startGeocode").click(function(){
      $.ajax({
         success: function(){
            window.location.href = 'http://localhost/nove/geocoding.php';  
            }     
      }); 
    });
    $("#naspat").click(function(){
      $.ajax({
         success: function(){
            window.location.href = 'http://localhost/nove/admin.php';  
            }     
      }); 
    });
    $("#showSko").click(function(){
      $.ajax({
         success: function(){
            window.location.href = 'http://localhost/nove/hlavna.php?show=skoly';  
            }     
      }); 
    });
    $("#showByd").click(function(){
      $.ajax({
         success: function(){
            window.location.href = 'http://localhost/nove/hlavna.php?show=bydliska';  
            }     
      }); 
    });
});

