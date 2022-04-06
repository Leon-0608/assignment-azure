<!DOCTYPE html>
<?php
    require_once ('includes/mysqli_connect.php');
    
    session_start();
    
    if(empty($_SESSION['username'])){
        header("Location: login-admin.php");
    }
    elseif($_SESSION['class'] != 'admin'){
        header("Location: homepage.php");
    }

    $error = [];
    $errorEName = null;
    $errorEYear = null;
    $errorEMonth = null;
    $errorEDay = null;
    
    $eventName = null;
    $eventYear = null;
    $eventMonth = null;
    $eventDay = null;
    
    if(null !== filter_input(INPUT_POST, 'hidden')){
        if(null !== filter_input(INPUT_POST, 'eName'))
        {
            if(preg_match("/^[a-z0-9 .\-]+$/i", filter_input(INPUT_POST, 'eName')))
            {
                $eventName = trim((filter_input(INPUT_POST, 'eName')));
            }
            else {
                $errorEName = "*Name Fields Only Allows Letters and Specific Symbols";
            }
        }
        else {
            $error[] = "*Please Enter The Event Name";
        }
        
        if(null !== filter_input(INPUT_POST, 'eYear') && is_numeric(filter_input(INPUT_POST, 'eYear')))
        {
           if(round(filter_input(INPUT_POST, 'eYear')) >= 1969)
            {
                $eventYear = round(filter_input(INPUT_POST, 'eYear'));
            }
            else {
                $errorEYear = "*The Year Entered Must Be After 1968";
            }
        }
        else {
            $error[] = "*Please Enter The Event Year";
        }
        
        if(null !== filter_input(INPUT_POST, 'eMonth') && is_numeric(filter_input(INPUT_POST, 'eMonth')))
        {
           if(round(filter_input(INPUT_POST, 'eMonth')) >= 1 && round(filter_input(INPUT_POST, 'eMonth')) <= 12)
            {
                $eventMonth = round(filter_input(INPUT_POST, 'eMonth'));
            }
            else {
                $errorEMonth= "*The Month Entered Must Be Between 1 And 12";
            }
        }
        else {
            $error[] = "*Please Enter The Event Month";
        }
        
        if(null !== filter_input(INPUT_POST, 'eDay') && is_numeric(filter_input(INPUT_POST, 'eDay')))
        {
           if(round(filter_input(INPUT_POST, 'eDay')) >= 1 && round(filter_input(INPUT_POST, 'eDay')) <= 31)
            {
                $eventDay = round(filter_input(INPUT_POST, 'eDay'));
            }
            else {
                $errorEDay= "*The Day Entered Must Be Between 1 And 31";
            }
        }
        else {
            $error[] = "*Please Enter The Event Day";
        }
  
        if($eventName && $eventYear && $eventMonth && $eventDay){
            $q = "INSERT INTO event (event_name, event_date) VALUES ('$eventName', '" . $eventYear. "-" . $eventMonth . "-" . $eventDay . "')";
            $result = @mysqli_query($dbc, $q);
            
            mysqli_close($dbc);
            
            if ($result) { 
                header("Location: manage-event.php");
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
        <title>Add Event</title>
        <link href="signup.css" rel="stylesheet" type="text/css"/>
        <link href="includes/header.css" rel="stylesheet" type="text/css"/>
        <link href="includes/footer1.css" rel="stylesheet" type="text/css"/>
    </head>
    
    <header>
        <?php include ('includes\header-al.php');?>
    </header>
    
    <body>
        <div><h1>ADD EVENT</h1></div>

            <div class="signup-box">

                <div class="signup">
                   
                    
                    <form action="event-add.php" method="post" id="signup-form">
                        <fieldset>
                        
                        <div class="form-group">
                            <label>Event Name</label><br>
                            <input type="text" name="eName" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'eName')){echo filter_input(INPUT_POST, 'eName');} ?>"required>
                            <?php if(null !== $errorEName) {echo "<br><p>" . $errorEName . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Event Year</label><br>
                            <input type="text" name="eYear" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'eYear')){echo filter_input(INPUT_POST, 'eYear');} ?>"required>
                            <?php if(null !== $errorEYear) {echo "<br><p>" . $errorEYear . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Event Month</label><br>
                            <input type="text" name="eMonth" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'eMonth')){echo filter_input(INPUT_POST, 'eMonth');}?>"required>
                            <?php if(null !== $errorEMonth) {echo "<br><p>" . $errorEMonth . "</p><br>";}?>
                        </div>
                        <br> 
                        <div class="form-group">
                            <label>Event Day</label><br>
                            <input type="text" name="eDay" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'eDay')){echo filter_input(INPUT_POST, 'eDay');}?>"required>
                            <?php if(null !== $errorEDay) {echo "<br><p>" . $errorEDay . "</p><br>";}?>
                        </div>
                        <br> 
                        <div class="form-group">
                             <input type="hidden" name="hidden" value="TRUE">                            
                        </div>
                        
                        </fieldset>
                        <div class="cancel">
                            <button type="submit" class="button">INSERT</button>
                        </div>
                        <div class="cancel">
                        <input type="reset" value="Cancel" name="cancel" class="button"/>
                        </div>
                    </form>
                
            </div>
        
        </div>
    
    </body>
    
    
</html>
