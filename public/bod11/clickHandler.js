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
            window.location.href = 'https://github.com/shneeder/wt2-skuska/blob/bod11/public/bod11/clickHandler.js?show=skoly';  
            }     
      }); 
    });
    $("#showByd").click(function(){
      $.ajax({
         success: function(){
            window.location.href = 'https://github.com/shneeder/wt2-skuska/blob/bod11/public/bod11/clickHandler.js?show=bydliska';  
            }     
      }); 
    });
});

