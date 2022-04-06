<?php    
    session_start();
    if(empty($_SESSION['username']) || empty($_SESSION['class']))
    {
        header("Location: login.php");
    }
    elseif($_SESSION['class'] != 'user'){
        header("Location: homepage.php");
    }
    require_once ('includes/mysqli_connect.php');
    
    $q ="SELECT student_id FROM user WHERE username = '" . $_SESSION['username'] . "'";
    $result = @mysqli_query ($dbc, $q);
                    
    if ($result) { 
        while ($row = mysqli_fetch_array($result)) {
            $studentID = $row['student_id'];
        }
    }
    
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
        <link href="manage-event.css" rel="stylesheet" type="text/css"/>
        <link href="includes/header.css" rel="stylesheet" type="text/css"/>
        <script src="includes/jquery-1.9.1.js"></script>
        <title>Participation History</title>
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
        <div class="container">
        <div class="left">
            <a href="user-profile.php" class="submenu" id="first-submenu">PROFILE</a>
            <a href="participation-history.php" class="submenu">PARTICIPATION HISTORY</a>
            <a href="destroy-session.php" class="submenu">LOG&nbsp;OUT</a>
        </div>
        <div class="right">
            <h1>PARTICIPATION HISTORY</h1>
            <form action='participation-history.php' method="post" id="search-bar">
            <select name="ad-hoc">
                <option value="event_name" <?php if(null !== filter_input(INPUT_POST, 'ad-hoc') && filter_input(INPUT_POST, 'ad-hoc') == "event_name") {echo 'selected';}?>>Event Name</option>
                <option value="payment_stat" <?php if(null !== filter_input(INPUT_POST, 'ad-hoc') && filter_input(INPUT_POST, 'ad-hoc') == "payment_stat") {echo 'selected';}?>>Payment Status</option>
            </select>
                <input type="text" name="varchar" size="50">
                <input type="hidden" name="search-confirm"value="1">
                <button class="search" type="submit">Search</button>
            </form>
            
            <form action="participation-history.php" method="post" id="main">
            <table>
                <tr>
                        <th>Student ID </th>
                        <th>Event Name</th>
                        <th>Payment Status</th>
                        
                </tr>
                <?php
                    if(ISSET($_POST['search-confirm']))
                    {
                        $varchar = $_POST['varchar'];
                        $adhoc = $_POST['ad-hoc'];
                                
                        if ($adhoc == 'event_name')
                        {
                            $cq ="SELECT r.student_id AS studentID, r.payment_stat AS paymentStat, e.event_name AS eventname FROM registration r, event e WHERE r.event_id = e.event_id AND r.student_id = '" . $studentID . "' AND e." . $adhoc . " LIKE '%" . $varchar . "%'";
                        $result = @mysqli_query ($dbc, $cq);
                        $numOfRow = mysqli_num_rows($result);
                    
                        if ($result) { 
                            while ($row = mysqli_fetch_array($result)) {
                                if($row['studentID'] == $studentID)
                                {
                                            printf("
                                    <tr>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        
                                    </tr>    
                ", $row['studentID'], $row['eventname'], $row['paymentStat']);
                                        }
                                    }
                                }
                            
                            
                                
                        }
                        
                       
                        
                        elseif($adhoc == 'payment_stat')
                        {
                        $cq ="SELECT * FROM registration WHERE student_id = '" . $studentID . "' AND " . $adhoc . " LIKE '%" . $varchar . "%'";
                        $result = @mysqli_query ($dbc, $cq);
                        $numOfRow = mysqli_num_rows($result);
                    
                        if ($result) { 
                            while ($row = mysqli_fetch_array($result)) {
                                if($row['student_id'] == $studentID)
                                {
                                    $eventID = $row['event_id'];
                                    $query = "SELECT event_name FROM event WHERE event_id = $eventID";
                                    $queryResult = @mysqli_query ($dbc, $query);
                                    
                                    if ($queryResult) { 
                                        while ($rowEvent = mysqli_fetch_array($queryResult)) {
                                            $eventName = $rowEvent['event_name'];

                                            printf("
                                    <tr>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        
                                    </tr>    
                ", $row['student_id'], $eventName, $row['payment_stat']);
                                        }
                                    }
                                }
                            
                            
                                
                        }
                        }
                        }
                    }

                    else{
                        $q ="SELECT * FROM registration WHERE student_id = '" . $studentID . "'";
                        $result = @mysqli_query ($dbc, $q);
                        $numOfRow = mysqli_num_rows($result);
                    
                        if ($result) { 
                            while ($row = mysqli_fetch_array($result)) {
                                if($row['student_id'] == $studentID)
                                {
                                    $eventID = $row['event_id'];
                                    $query = "SELECT event_name FROM event WHERE event_id = $eventID";
                                    $queryResult = @mysqli_query ($dbc, $query);
                                    
                                    if ($queryResult) { 
                                        while ($rowEvent = mysqli_fetch_array($queryResult)) {
                                            $eventName = $rowEvent['event_name'];

                                            printf("
                                    <tr>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        
                                    </tr>    
                ", $row['student_id'], $eventName, $row['payment_stat']);
                                        }
                                    }
                                }
                            
                            
                                
                        }
                    }
                    }
                ?>
            </table>
                <?php 
                    echo '<p class="numOfRow">' . $numOfRow . ' record(s) returned</P>';
                    mysqli_close($dbc);
                ?>
                <input type="hidden" name="submitted" value="1">
            </form>
            
        </div>
        </div>

    </body>
    
</html>
