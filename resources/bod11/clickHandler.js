// JavaScript Document
$(document).ready(function(){
    $("#startGeocode").click(function(){
      $.ajax({
         success: function(){
            window.location.href = '';  
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

