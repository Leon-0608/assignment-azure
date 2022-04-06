<!DOCTYPE html>
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
    
    $error = [];
    $errorevent = null;
    
    $event = null;
    
    
                                
    if(null !== filter_input(INPUT_POST, 'hidden')){     
        if(null !== filter_input(INPUT_POST, 'event'))
        {
            $event = $_POST['event'];
        }
        else {
            $error[] = "*Please Select The Appropriate Event";
        }
        if($event)
        {
            $query ="SELECT * FROM user WHERE username = '" . $_SESSION['username'] . "'";
            $queryResult = @mysqli_query ($dbc, $query);
            
            if ($queryResult) { 
                while ($row = mysqli_fetch_array($queryResult)) {
                    $student_id = $row['student_id'];
                }
            }       
            
            $q ="SELECT * FROM registration";
            $result = @mysqli_query ($dbc, $q);
            
            
            if ($result) { 
                while ($row = mysqli_fetch_array($result)) {
                    if($event === $row['event_id']){
                        if($student_id == $row['student_id'])
                        {
                            $errorevent = "*Event Already Registered";
                        }
                    }       
                }
            }
            
            if($errorevent == null)
            {
                $InsertQuery = "INSERT INTO registration VALUES ('$student_id', '$event', 'N')";
                $insertQueryResult = @mysqli_query ($dbc, $InsertQuery);
                
                if($result) {
                    header("Location: registration-success.html");
                }
            }
            
        }
    }
    
    
    else {
        $error[] = "*The form is not yet submmited";
    }

?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <meta name="description" content="width=device-width, initial-scale=1.0">
        <title>Event Registration</title>
        <link href="register.css" rel="stylesheet" type="text/css"/>
        <link href="includes/header.css" rel="stylesheet" type="text/css"/>
        <link href="includes/footer1.css" rel="stylesheet" type="text/css"/>
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
        <div><h1>Event Registration</h1></div>
        
            <div class="register-box">
            
                <div class="col-md-6 register-left">
                    <div><h2>Register here</h2></div>
                    <div><h5>*Registration Fee RM50.00 </h5></div>
                    <form action="register.php" method="post">
                        <br>
                        <div class="form-group">
                            <label for="cars">Choose an Event: </label>
                        <select name="event" id="event">
                            <?php
                                $q ="SELECT * FROM event";
                                $result = @mysqli_query ($dbc, $q);
                    
                                if ($result) { 
                                    while ($row = mysqli_fetch_array($result)) {
                                        printf("
                                                <option value='%d'>%s</option>
                                                ", $row['event_id'], $row['event_name']);
                                    }
                                }
                            ?>
                            
                        </select>

                        </div>
                        <br>
                        <div class="form-group">
                             <input type="hidden" name="hidden" value="TRUE">                            
                        </div>
                        <br>
                        </fieldset>
                        <?php 
                            if($errorevent != null)
                            {
                                echo '<p>' . $errorevent . '<p>';
                            }
                        ?>
                        <button type="submit" class="button">Register</button>
                        <input type="reset" value="Cancel" name="cancel" class="button"/>
                    </form>
                
            </div>
        
        </div>

    </body>
    
</html>   

