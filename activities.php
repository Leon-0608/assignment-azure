<?php    session_start();?>
<!DOCTYPE html>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="activities.css" rel="stylesheet" type="text/css"/>
        <link href="includes/header.css" rel="stylesheet" type="text/css"/>
        <link href="includes/footer1.css" rel="stylesheet" type="text/css"/>
        <title>Activities</title>
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
        
        <div>
            <h1>Activities</h1>
        </div>
            
        <div class="searchbox">
        </div>
            
        <div class="section">
            <h2 class="y2018">2018</h2>
        </div>    
        
        <div class="act">
             <div class="activities">
                    <h3>Bernad Pang Workshop</h3>
                    <img src="activities3.jpg" alt="Bernard Pang Workshop Poster" width="500" height="600"/>
                    <ul class="details">
                        <li class="list">ORGANIZED BY : TARUC Dancing Society<br></li>
                        <li class="list">DATE : 30 Jun 2018<br></li>
                        <li class="list">TIME : 12:00pm to 4:00pm<br></li>
                        <li class="list">LOCATION : Tunku Abdul Rahman University College<br></li> 
                    </ul>
                </div> 
                   

            
                <div class="activities">
                    <h3>D' Dance Vol.5</h3>
                    <img src="activities2.jpg" width="500" height="500"/>
                    <ul class="details">
                        <li class="list">ORGANIZED BY : D'Dance<br></li>
                        <li class="list">DATE : 4th of August and 5th of August<br></li>
                        <li class="list">TIME : 11am to 6pm(4th of August ) and 12pm to 10pm(5th of August)<br></li>
                        <li class="list">LOCATION : TARUC College Hall<br></li> 
                    </ul>     
                
                </div>
        </div>
               
            
        <div class="section">
            <h2 class="y2019">2019</h2>
        </div>
            
        <div class="act">
            <div class="activities">
                    <h3>TARUC Dancing Society</h3>
                    <img src="activities1.jpg" width="500" height="600"/>
                    
                    <ul class="details">
                        <li class="list">ORGANIZED BY : TARUC Dancing Society<br></li>
                        <li class="list">DATE : 21th April 2019<br></li>
                        <li class="list">TIME : 12:00am to 2:00pm<br></li>
                        <li class="list">LOCATION : Jalan Genting Kelang,Setapak,53000 Kuala Lumpur<br></li> 
                    </ul>
                
                </div>
        </div>
                
                

            
    </body>
    
</html>

