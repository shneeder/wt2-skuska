// JavaScript Document
$(document).ready(function(){
    $("#startGeocode").click(function(){
      $.ajax({
         success: function(){
            window.location.href = 'http://147.175.98.234/wt2-skuska/public/bod11/geocoding.php';  
            }     
      }); 
    });
    $("#naspat").click(function(){
      $.ajax({
         success: function(){
            window.location.href = 'http://147.175.98.234/wt2-skuska/public/bod11/admin.php';  
            }     
      }); 
    });
    $("#showSko").click(function(){
      $.ajax({
         success: function(){
            window.location.href = 'http://147.175.98.234/?show=skoly';  
            }     
      }); 
    });
    $("#showByd").click(function(){
      $.ajax({
         success: function(){    
            window.location.href = 'http://147.175.98.234/?show=bydliska';  
            }     
      }); 
    });
});

