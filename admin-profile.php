<?php    
    session_start();
    if(empty($_SESSION['username']) || empty($_SESSION['class']))
    {
        header("Location: login.php");
    }
    elseif($_SESSION['class'] != 'admin'){
        header("Location: homepage.php");
    }
    require_once ('includes/mysqli_connect.php');
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
        <link href="user-profile.css" rel="stylesheet" type="text/css"/>
        <link href="includes/header.css" rel="stylesheet" type="text/css"/>
        <script src="includes/jquery-1.9.1.js"></script>
        <title>Profile</title>
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
            <h1>PROFILE</h1>
            <table>
                <?php
                    $q ="SELECT * FROM admin WHERE admin_uname = '" . $_SESSION['username'] . "'";
                    $result = @mysqli_query ($dbc, $q);
                    
                    if ($result) { 
                        while ($row = mysqli_fetch_array($result)) {
                            printf(" <tr>
                    <td>First Name: </td>
                    <td class='value'>%s</td>
                    
                </tr>
                <tr>
                    <td>Last Name: </td>
                    <td class='value'>%s</td>
                    
                </tr>
                <tr>
                    <td>Username: </td>
                    <td class='value'>%s</td>
                    
                </tr>
                <tr>
                    <td>Student ID: </td>
                    <td class='value'>%s</td>
                    
                </tr>
                <tr>
                    <td>E-mail: </td>
                    <td class='value'>%s</td>
                    
                </tr>
                <tr>
                    <td>Phone Number: </td>
                    <td class='value'>%s</td>
                    
                </tr>", $row['admin_fname'], $row['admin_lname'], $row['admin_uname'], $row['admin_sid'], $row['admin_email'], $row['admin_tel']);
                        }
                    }
                ?>
               
            </table>
            
            <button class="update-profile" onclick="window.location.href='update-profile.php';">Update Profile</button>
            <button class="reset-pswd" onclick="window.location.href='reset-password.php';">Reset Password</button>
            
        </div>
        </div>
    </body>
    
</html>
