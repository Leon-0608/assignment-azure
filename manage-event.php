<?php    
    session_start();
    if(empty($_SESSION['username']) || empty($_SESSION['class']))
    {
        header("Location: login-admin.php");
    }
    elseif($_SESSION['class'] != 'admin'){
        header("Location: homepage.php");
    }
    require_once ('includes/mysqli_connect.php');
    
    if(null !== filter_input(INPUT_POST, 'submitted')){
        $eventID = $_POST['event_id'];
                                
        $dq ="DELETE FROM event WHERE event_id = " . $eventID;
        $deleteResult = @mysqli_query ($dbc, $dq);
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
        <title>Manage Event</title>
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
            <a href="admin-profile.php" class="submenu" id="first-submenu">PROFILE</a>
            <a href="manage-event.php" class="submenu">MANAGE EVENT</a>
            <a href="manage-user.php" class="submenu">MANAGE USER</a>
            <a href="destroy-session.php" class="submenu">LOG&nbsp;OUT</a>
        </div>
        <div class="right">
            <h1>MANAGE EVENT</h1>
            <form action='manage-event.php' method="post" id="search-bar">
            <select name="ad-hoc">
                <option value="event_id" <?php if(null !== filter_input(INPUT_POST, 'ad-hoc') && filter_input(INPUT_POST, 'ad-hoc') == "event_id") {echo 'selected';}?>>ID</option>
                <option value="event_name" <?php if(null !== filter_input(INPUT_POST, 'ad-hoc') && filter_input(INPUT_POST, 'ad-hoc') == "event_name") {echo 'selected';}?>>Name</option>
                <option value="event_date" <?php if(null !== filter_input(INPUT_POST, 'ad-hoc') && filter_input(INPUT_POST, 'ad-hoc') == "event_date") {echo 'selected';}?>>Date</option>
            </select>
                <input type="text" name="varchar" size="50">
                <input type="hidden" name="search-confirm"value="1">
                <button class="search" type="submit">Search</button>
            </form>
            
            <form action="manage-event.php" method="post" id="main">
            <table>
                <tr>
                        <th>Event ID </th>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Select</th>
                </tr>
                <?php
                    if(ISSET($_POST['search-confirm']))
                    {
                        $varchar = $_POST['varchar'];
                        $adhoc = $_POST['ad-hoc'];
                                
                        $cq ="SELECT * FROM event WHERE " . $adhoc . " LIKE '%" . $varchar . "%'";
                        $result = @mysqli_query ($dbc, $cq);
                        $numOfRow = mysqli_num_rows($result);
                    
                        if ($result) { 
                        while ($row = mysqli_fetch_array($result)) {
                            printf("
                                    <tr>
                                        <td>%d</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td><input type='checkbox' name='event_id' value='%d' class='select'/></td>
                                    </tr>    
                ", $row['event_id'], $row['event_name'], $row['event_date'], $row['event_id']);
                        }
                    }
                    }

                    else{
                    $q ="SELECT * FROM event";
                    $result = @mysqli_query ($dbc, $q);
                    $numOfRow = mysqli_num_rows($result);
                    
                    if ($result) { 
                        while ($row = mysqli_fetch_array($result)) {
                            printf("
                                    <tr>
                                        <td>%d</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td><input type='checkbox' name='event_id' value='%d' class='select'/></td>
                                    </tr>    
                ", $row['event_id'], $row['event_name'], $row['event_date'], $row['event_id']);
                        }
                    }
                    }
                ?>
            </table>
                <?php 
                    echo '<p class="numOfRow">' . $numOfRow . ' record(s) returned</P>';
                ?>
                <input type="hidden" name="submitted" value="1">
            </form>
            
            <button class="add" onclick="window.location.href='event-add.php';">Add Event</button>
            <button type='submit' class="update" onclick="submitForm('event-update.php')" form="main">Update Event</button>
            <button type='submit' class="delete" onclick="confirmDelete()" form="main">Delete Event</button>
            
        </div>
        </div>
        <script>
            function confirmDelete() {
                confirm("Are you sure you want to delete this record(s)?");
            }
            
            function submitForm(action) {
                var form = document.getElementById('main');
                    form.action = action;
                    form.submit();
            }
        </script>
    </body>
    
</html>
