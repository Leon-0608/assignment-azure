<?php    session_start();?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta name="description" content="width=device-width, initial-scale=1.0">
        <link href="about.css" rel="stylesheet" type="text/css">
        <link href="includes/header.css" rel="stylesheet" type="text/css"/>
        <link href="includes/footer1.css" rel="stylesheet" type="text/css"/>
        <title>About Us</title>
        
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
        <h1 id="head">About US</h1>
        <div id="template">
            <div class="slide-content">
                <h2 class="club">Club Details</h2>
                <br>
                <p>We are a dance club from Kolej University Tunku Abdul Rahman, our club has start since year 2010.</p>
                <p>We are having some dance practices through google meet weekly and you are free to join us.</p>
                <p>Four Division in Our Society :</p>
                <p>  ~ Street Dance (training every Thursday 6 to 9 pm)</p>
                <p>  ~ KPOP Dance (training every Wednesday 6 to 9 pm)</p>
                <p>  ~ Latin Dance (training every Monday 4 to 6 pm)</p>
                <p>  ~ Cheerleading (training every Tuesday 6 to 9 pm)</p>
                <p>  ~ Traditional Dance (training every Friday 6 to 9 pm)</p>
                <p> Do email us for any invitation or competition.</p>
                <p> For more details feel free to contact us: 018-4896996(Tan) or 012-1395408(Leo)</p> 
                <p> Also, please like our <a href="https://www.facebook.com/TARUC-Dancing-Society-257582531029669/?ref=py_c" class="facebook">Facebook page</a> to get the latest update</p>
            </div>


            <div class="slide-content">
                <h2 class="competition">Competition Details</h2>
                <br>
                <p>Our event are mainly sponsored by TARUC, Dato Alan, CWH.sdn.bhd, and others.</p>
                <p>The competition are allow in group up to 5 members, and the price pool are up to RM100000.</p>
                <p>You can enjoy rewards when you or your team reach the top 8 of the competition.</p>
                <p>You may start to register to our competition from now, join us now and good luck to you!</p>
                <p>To know more details feel free to call to: 018-4896996(Tan) or 012-1395408(Leo) to understand more!</p>
                <p>The register date will be end at 11 October 2021, quickly to sign up <a href="register.php" class="now">now</a>!</p>
            </div>
 
        </div>

    </body>

</html>
