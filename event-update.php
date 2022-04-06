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
        
    if(null == filter_input(INPUT_POST, 'hidden')){       
        $eventID;
        $eventName;
        $eventYear;
        $eventMonth;
        $eventYear;
    
        if(null == filter_input(INPUT_POST, 'event_id'))
        {
            header("Location: manage-event.php");
        }
        
        $eventID = $_POST['event_id'];
        $_SESSION['event_id'] = $_POST['event_id'];
        $details = "SELECT * FROM event WHERE event_id = " . $eventID;
        
        $detailsResult = @mysqli_query($dbc, $details);
        
        while ($row = mysqli_fetch_array($detailsResult)) {
        if($row['event_id'] === $eventID)
        {
            $eventName = $row['event_name'];
            $eventDate = explode('-',$row['event_date']);
            
            $teventName = $row['event_name'];
            $teventDate = explode('-',$row['event_date']);
        }            
    }
    }
    
    $eventID = $_SESSION['event_id'];
    
    $details = "SELECT * FROM event WHERE event_id = " . $_SESSION['event_id'];
        
    $detailsResult = @mysqli_query($dbc, $details);
        
    while ($row = mysqli_fetch_array($detailsResult)) {
        if($row['event_id'] === $_SESSION['event_id'])
        {
            $teventName = $row['event_name'];
            $teventDate = explode('-',$row['event_date']);
        }
    }
    
    if(null !== filter_input(INPUT_POST, 'hidden')){
        if(null !== filter_input(INPUT_POST, 'eName'))
        {
            if(preg_match("/^[a-z0-9 .\-]+$/i", filter_input(INPUT_POST, 'eName')))
            {
                $eventName = trim((filter_input(INPUT_POST, 'eName')));
            }
            else {
                $eventName = null;
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
                $eventYear = null;
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
                $eventMonth = null;
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
                $eventMonth = null;
                $errorEDay= "*The Day Entered Must Be Between 1 And 31";
            }
        }
        else {
            $error[] = "*Please Enter The Event Day";
        }
        
        if(empty($eventID))
        {
            $eventID = null;
        }
        
        if($eventID && $eventName && $eventYear && $eventMonth && $eventDay){
            $q = "UPDATE event SET event_name = '$eventName', event_date = '" . $eventYear. "-" . $eventMonth . "-" . $eventDay . "' WHERE event_id = $eventID";
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
        <title>UPDATE Event</title>
        <link href="signup.css" rel="stylesheet" type="text/css"/>
        <link href="includes/header.css" rel="stylesheet" type="text/css"/>
        <link href="includes/footer1.css" rel="stylesheet" type="text/css"/>
    </head>
    
    <header>
        <?php include ('includes\header-al.php');?>
    </header>
    
    <body>
        <div><h1>UPDATE EVENT</h1></div>

            <div class="signup-box">

                <div class="signup">
                   
                    
                    <form action="event-update.php" method="post" id="signup-form">
                        <fieldset>
                        
                        <div class="form-group">
                            <label>Event Name</label><br>
                            <input type="text" name="eName" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'eName')){echo filter_input(INPUT_POST, 'eName');}elseif(isset($eventName)){echo $eventName;} ?>"required>
                            <?php if(null !== $errorEName) {echo "<br><p>" . $errorEName . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Event Year</label><br>
                            <input type="text" name="eYear" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'eYear')){echo filter_input(INPUT_POST, 'eYear');}elseif(isset($eventDate[0])){echo $eventDate[0];} ?>"required>
                            <?php if(null !== $errorEYear) {echo "<br><p>" . $errorEYear . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Event Month</label><br>
                            <input type="text" name="eMonth" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'eMonth')){echo filter_input(INPUT_POST, 'eMonth');}elseif(isset($eventDate[1])){echo $eventDate[1];}?>"required>
                            <?php if(null !== $errorEMonth) {echo "<br><p>" . $errorEMonth . "</p><br>";}?>
                        </div>
                        <br> 
                        <div class="form-group">
                            <label>Event Day</label><br>
                            <input type="text" name="eDay" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'eDay')){echo filter_input(INPUT_POST, 'eDay');}elseif(isset($eventDate[2])){echo $eventDate[2];}?>"required>
                            <?php if(null !== $errorEDay) {echo "<br><p>" . $errorEDay . "</p><br>";}?>
                        </div>
                        <br> 
                        <div class="form-group">
                             <input type="hidden" name="hidden" value="TRUE">                            
                        </div>
                        
                        </fieldset>
                        <div class="cancel">
                            <button type="submit" class="button">UPDATE</button>
                        </div>
                        <div class="cancel">
                        <input type="reset" value="Cancel" name="cancel" class="button"/>
                        </div>
                    </form>
                
            </div>
        
        </div>
    
    </body>
    
    
</html>
