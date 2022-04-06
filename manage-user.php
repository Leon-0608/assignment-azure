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
    
    if(null !== filter_input(INPUT_POST, 'submitted')){
        $userName = $_POST['username'];
                                
        $dq ="DELETE FROM user WHERE username = '" . $userName . "'";
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
        <title>Manage User</title>
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
            <h1>MANAGE USER</h1>
            <form action='manage-user.php' method="post" id="search-bar">
            <select name="ad-hoc">
                <option value="first_name" <?php if(null !== filter_input(INPUT_POST, 'ad-hoc') && filter_input(INPUT_POST, 'ad-hoc') == "first_name") {echo 'selected';}?>>First Name</option>
                <option value="last_name" <?php if(null !== filter_input(INPUT_POST, 'ad-hoc') && filter_input(INPUT_POST, 'ad-hoc') == "last_name") {echo 'selected';}?>>Last Name</option>
                <option value="username" <?php if(null !== filter_input(INPUT_POST, 'ad-hoc') && filter_input(INPUT_POST, 'ad-hoc') == "username") {echo 'selected';}?>>Username</option>
                <option value="student_id" <?php if(null !== filter_input(INPUT_POST, 'ad-hoc') && filter_input(INPUT_POST, 'ad-hoc') == "student_id") {echo 'selected';}?>>Student ID</option>
                <option value="email" <?php if(null !== filter_input(INPUT_POST, 'ad-hoc') && filter_input(INPUT_POST, 'ad-hoc') == "email") {echo 'selected';}?>>E-mail</option>
                <option value="phone_no" <?php if(null !== filter_input(INPUT_POST, 'ad-hoc') && filter_input(INPUT_POST, 'ad-hoc') == "phone_no") {echo 'selected';}?>>Phone No.</option>
            </select>
                <input type="text" name="varchar" size="50">
                <input type="hidden" name="search-confirm" value="1">
                <button class="search" type="submit">Search</button>
            </form>
            
            <form action="manage-user.php" method="post" id="main">
            <table>
                <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Student ID</th>
                        <th>E-mail</th>
                        <th>Phone No.</th>
                        <th>Select</th>
                </tr>
                <?php
                    if(ISSET($_POST['search-confirm']))
                    {
                        $varchar = $_POST['varchar'];
                        $adhoc = $_POST['ad-hoc'];
                                
                        $cq ="SELECT * FROM user WHERE " . $adhoc . " LIKE '%" . $varchar . "%'";
                        $result = @mysqli_query ($dbc, $cq);
                        $numOfRow = mysqli_num_rows($result);
                    
                        if ($result) { 
                        while ($row = mysqli_fetch_array($result)) {
                            printf("
                                    <tr>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td><input type='checkbox' name='username' value='%s' class='select'/></td>
                                    </tr>    
                ", $row['first_name'], $row['last_name'], $row['username'], $row['student_id'], $row['email'], $row['phone_no'], $row['username']);
                        }
                    }
                    }

                    else{
                        $q ="SELECT * FROM user";
                        $result = @mysqli_query ($dbc, $q);
                        $numOfRow = mysqli_num_rows($result);

                        if ($result) { 
                            while ($row = mysqli_fetch_array($result)) {
                                printf("
                                        <tr>
                                            <td>%s</td>
                                            <td>%s</td>
                                            <td>%s</td>
                                            <td>%s</td>
                                            <td>%s</td>
                                            <td>%s</td>
                                            <td><input type='checkbox' name='username' value='%s' class='select'/></td>
                                        </tr>    
                    ", $row['first_name'], $row['last_name'], $row['username'], $row['student_id'], $row['email'], $row['phone_no'], $row['username']);
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
            
            <button type='submit' class="add" onclick="confirmDelete()" form="main">Delete User</button>
            
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
