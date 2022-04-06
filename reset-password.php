<!DOCTYPE html>
<?php
    require_once ('includes/mysqli_connect.php');
    session_start();
    
    if(empty($_SESSION['username'])){
        header("Location: login.php");
    }

    $error = [];
    $errorpass = null;
    $errorpass1 = null;
    $errorpass2 = null;
    
    $correctPass;
    $pass = null;
    $pass1 = null;
    $pass2 = null;
    
    if($_SESSION['class'] == 'user')
    {
        $details = "SELECT username, password FROM user WHERE username = '" . $_SESSION['username'] . "'";
        
        $detailsResult = @mysqli_query($dbc, $details);
        
        while ($rowu = mysqli_fetch_array($detailsResult)) {
        if($rowu['username'] == $_SESSION['username'])
        {
            $correctPass = $rowu['password'];
        }            
    }
    }
    else if($_SESSION['class'] == 'admin')
    {
        $details = "SELECT admin_uname, admin_pswd FROM admin WHERE admin_uname = '" . $_SESSION['username'] . "'";
        
        $detailsResult = @mysqli_query($dbc, $details);
        
        while ($rowa = mysqli_fetch_array($detailsResult)) {
        if($rowa['admin_uname'] == $_SESSION['username'])
        {
            $correctPass = $rowa['admin_pswd'];
        }         
    }
    }
    
    
    if(null !== filter_input(INPUT_POST, 'hidden')){
        if(null !== filter_input(INPUT_POST, 'pass'))
        {
            if(sha1(filter_input(INPUT_POST, 'pass')) == $correctPass)
            {
                $pass = trim(filter_input(INPUT_POST, 'pass')); 
                
                if(null !== filter_input(INPUT_POST, 'pass1'))
                {
                    if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', filter_input(INPUT_POST, 'pass1')))
                    {
                        $pass1 = trim(filter_input(INPUT_POST, 'pass1'));  
                    }
                    else {
                        $errorpass1 = "*Password Must Be Between 8 to 12 Characters And Contain Both Digit and Word Character";
                    }
                }
                else {
                    $error[] = "*Please Enter Your New Password";
                }
        
                if(null !== filter_input(INPUT_POST, 'pass2'))
                {       
                    if(filter_input(INPUT_POST, 'pass1') == filter_input(INPUT_POST, 'pass2'))
                    {
                        $pass2 = trim(filter_input(INPUT_POST, 'pass2'));
                        
                        if($_SESSION['class'] == 'user')
                        {
                            $q = "UPDATE user SET password = '" . sha1($pass1) . "' WHERE username = '" . $_SESSION['username'] . "'";
        
                            $Result = @mysqli_query($dbc, $q);
                            
                            mysqli_close($dbc);
                            
                            header("Location: user-profile.php");
                        }
                        
                        else if($_SESSION['class'] == 'admin')
                        {
                            $q = "UPDATE admin SET admin_pswd = '" . sha1($pass1) . "' WHERE admin_uname = '" . $_SESSION['username'] . "'";
        
                            $Result = @mysqli_query($dbc, $q);
                            
                            mysqli_close($dbc);
                            
                            header("Location: admin-profile.php");
                        }
                      
                    }
                    else {
                    $errorpass2 = "*New Password Is Not Match, Please Try Again";
                    }
                }           
                else {
                    $error[] = "*Please Confirm Your New Password";
                }
            }
            else {
                $errorpass = "*The Old Password You Have Entered Is Incorrect";
            }
        }
        else {
            $error[] = "*Please Enter The Old Password";
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
        <title>Reset Password</title>
        <link href="signup.css" rel="stylesheet" type="text/css"/>
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
                header("Location: login.php");
            }
        ?>
    </header>
    
    <body>
        <div><h1>Reset Password</h1></div>

            <div class="signup-box">

                <div class="signup">
                   
                    
                    <form action="reset-password.php" method="post" id="signup-form">
                        <fieldset>
                            <div class="form-group">
                                <label>Enter Old Password</label><br>
                                <input type="password" name="pass" class="form-control" value="" required/>
                                <?php if(null !== $errorpass) {echo "<br><p>" . $errorpass . "</p><br>";}?>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Enter New Password</label><br>
                                <input type="password" name="pass1" class="form-control" value="" required/>
                                <?php if(null !== $errorpass1) {echo "<br><p>" . $errorpass1 . "</p><br>";}?>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Confirm New Password</label><br>
                                <input type="password" name="pass2" class="form-control" value="" required/>
                                <?php if(null !== $errorpass2) {echo "<br><p>" . $errorpass2 . "</p><br>";}?>
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="hidden" name="hidden" value="TRUE">                            
                            </div>
                        </fieldset>
                        <div class="cancel">
                            <button type="submit" class="button" onclick="confirmUpdate()">Update</button>
                        </div>
                        <div class="cancel">
                        <input type="reset" value="Cancel" name="cancel" class="button"/>
                        </div>
                    </form>
                
            </div>
        
        </div>
        <script>
            function confirmUpdate() {
                confirm("Are you sure you want to make this change(s) to your password?");
            }
        </script>
    </body>
    
    
</html>
