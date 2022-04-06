<?php    
session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="homepage.css" rel="stylesheet" type="text/css"/>
        <link href="includes/header.css" rel="stylesheet" type="text/css"/>
        <link href="includes/footer1.css" rel="stylesheet" type="text/css"/>
        <script src="includes/jquery-1.9.1.js"></script>
        <title>TARUC Dance Club</title>
    </head>
    
    <header>
        <?php 
            if(isset($_SESSION['class']))
            {
                if($_SESSION['class'] == "admin")
                {
                include ('includes\header-al.php');
                }
                elseif($_SESSION['class'] == "user") 
                {
                include ('includes\header-ul.php');
                }
            }
            else
            {
                include ('includes\header.html');
            }
        ?>
    </header>
    
    <body>
        <div><h1>Welcome To The <span id="society-name">TARUC Dance Club</span>'s website</h1></div>
        <div>
            <p>Dancing Society is one of the society in Tunku Abdul Rahman University College.</p>
            <p>We provide a stage for all TARCian to show their passion in dancing.</p>
            <p>The dancing style in our Society is divided into 4 categories.</p>
            <p>They are Street Dance, KPOP Dance, Latin Dance, Cheerleading and Traditional Dance.</p>
            <p>We provide training sessions for every type of style of dances mentioned.</p><br>
        </div>
        
        <div class="button">
            <a href="aboutus.php" class="learn-more">LEARN MORE</a>
        </div>
        
    </body>
    
</html>
