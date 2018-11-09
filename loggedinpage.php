<?php  

    session_start();
    if (array_key_exists("id", $_COOKIE)) {
        $_SESSION['id'] = $_COOKIE['id'];
    }
    if (array_key_exists("id", $_SESSION)) {
        echo "<p>Logged In! <a href='index.php?logout=1'>Log out</a></p>";
    }else {
        header("Location: index.php");
    }



?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script
    src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
    integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css">
    <link rel="stylesheet" media="print" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.print.css">
    <style type="text/css">
       
        
        body{
            color: black;
            background: url(lib/diary2.jpg) no-repeat center center fixed;
            background-size: cover;
        }
        .container{
            margin-top: 5%;
            width: 45%;
            text-align: center;
            
        }
        
    </style>
    <title>My Online Diary!</title>


    <script>
    $(document).ready(function() {
     $("#calendar").fullCalendar({
        selectable: true,
        editable: true,
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'month,listWeek'
                },
        //contentHeight: 600,        
        defaultView: 'month',
        dayClick: function(date) {
        alert('clicked ' + date.format());
        },
        select: function(startDate, endDate) {
        alert('selected ' + startDate.format() + ' to ' + endDate.format());
        }   
     });
    });
    </script>
  </head>
  <body>
  
  <div class="container">
        
        <div id="calendar"></div>
  </div>
  
   
   
  </body>
  </html>