<!DOCTYPE html>
<?php
    require_once ('includes/mysqli_connect.php');
    
    session_start();
    
    if(isset($_SESSION['username'])){
        header("Location: destroy-session.php");
    }
    
    $error = [];
    $errorfname = null;
    $errorlname = null;
    $erroruname = null;
    $errorstudentID = null;
    $erroremail = null;
    $errorpass1 = null;
    $errorpass2 = null;
    $errorphone = null;
    
    $fname = null;
    $lname = null;
    $uname = null;
    $studID = null;
    $email = null;
    $pass1 = null;
    $pass2 = null;
    $phone = null;
    
    
    if(null !== filter_input(INPUT_POST, 'hidden')){
        if(null !== filter_input(INPUT_POST, 'fname'))
        {
            if(preg_match("/^[a-zA-Z-' ]*$/", filter_input(INPUT_POST, 'fname')))
            {
                $fname = trim((filter_input(INPUT_POST, 'fname')));
            }
            else {
                $errorfname = "*Name Fields Only Allows Letters and Specific Symbols";
            }
        }
        else {
            $error[] = "*Please Enter Your First Name";
        }
        
        if(null !== filter_input(INPUT_POST, 'lname'))
        {
           if(preg_match("/^[a-zA-Z-' ]*$/", filter_input(INPUT_POST, 'lname')))
            {
                $lname = trim((filter_input(INPUT_POST, 'lname')));
            }
            else {
                $errorlname = "*Name Fields Only Allows Letters and Specific Symbols";
            }
        }
        else {
            $error[] = "*Please Enter Your Last Name";
        }
        
        if (null !== filter_input(INPUT_POST, 'uname'))
        {
            if (preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', filter_input(INPUT_POST, 'uname')) )
            {
                $uname = trim((filter_input(INPUT_POST, 'uname')));
            }
            else {
                $erroruname = "*Username Should Contain At Least 5 Characters to A Maximum of 31 Characters And Does Not Include Any Special Characters And Space";
            }
        }
        else {
            $error[] = "*Please Enter Your Username";
        }
        
        if(null !== filter_input(INPUT_POST, 'gender'))
        {
            if(filter_input(INPUT_POST, 'gender') != "male" && filter_input(INPUT_POST, 'gender') != "female")
            {
                $errorgender = "*Gender Can Only Be Either Male or Female";
            }
            else {
                $gender = (filter_input(INPUT_POST, 'gender'));
            }
        }
        else {
            $error[] = "*Please Select Your Gender";
        }
        
        if(null !== filter_input(INPUT_POST, 'studID'))
        {
            if(preg_match('/(\d{2})(\w{3})(\d{5})/',(filter_input(INPUT_POST, 'studID'))))
            {
                $studID = trim((filter_input(INPUT_POST, 'studID')));
            }
            else {
                $errorstudentID = "*Please Follow The Format of Student ID Set by The UC (12ABC34567)";   
            }
        }
        else {
            $error[] = "*Please Enter Your Student ID";
        }
        
        if(null !== filter_input(INPUT_POST, 'email'))
        {
            if(!filter_var(filter_input(INPUT_POST, 'email'), FILTER_VALIDATE_EMAIL))
            {
                $erroremail = "*Invalid Email Format";  
            }
            else {
                $email = trim(filter_input(INPUT_POST, 'email'));
            }
        }
        else {
            $error[] = "*Please Enter Your E-mail";
        }
        
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
            $error[] = "*Please Enter Your Password";
        }
        
        if(null !== filter_input(INPUT_POST, 'pass2'))
        {
            if(filter_input(INPUT_POST, 'pass1') == filter_input(INPUT_POST, 'pass2'))
            {
                $pass2 = trim(filter_input(INPUT_POST, 'pass2'));  
            }
            else {
                $errorpass2 = "*Password Is Not Match, Please Try Again";
            }
        }
        else {
            $error[] = "*Please Confirm Your Password";
        }
        
        if(null !== filter_input(INPUT_POST, 'phone'))
        {
            if(preg_match('/(\d{3})\W(\d{7})/',(filter_input(INPUT_POST, 'phone'))))
            {
                $phone = trim(filter_input(INPUT_POST, 'phone')); 
            }
            else {
                $errorphone = "*Please Enter Your Phone Number In XXX-XXXXXXX Format";             
            }
        }
        else {
            $error[] = "*Please Enter Your Phone Number";
        }
  
       if($fname && $lname && $uname && $studID && $email && $pass1 && $pass2 && $phone){
            $quu = "SELECT username, student_id, email FROM user";
            $qau = "SELECT admin_uname, admin_sid, admin_email FROM admin";
            $resultquu = @mysqli_query($dbc, $quu);
            $resultqau = @mysqli_query($dbc, $qau);
            
            if($resultqau)
            {
                while($row = mysqli_fetch_array($resultqau))
                {
                    if($row['admin_uname'] == $uname){
                        $erroruname = "Username Already Exist, Please Try Other Username";
                    }
                    if($row['admin_sid'] == $studID){
                        $errorstudentID = "Entered Student ID Already Registered, Please Try Again";
                    }
                    if($row['admin_email'] == $email){
                        $erroremail = "Entered Email Already Registered, Please Try Again Using Other E-mail";
                    }
                }
            }
            
            if($resultquu)
            {
                 while($row = mysqli_fetch_array($resultquu))
                {
                    if($row['username'] == $uname){
                        $erroruname = "Username Already Exist, Please Try Other Username";
                    }
                    if($row['student_id'] == $studID){
                        $errorstudentID = "Entered Student ID Already Registered, Please Try Again";
                    }
                    if($row['email'] == $email){
                        $erroremail = "Entered Email Already Registered, Please Try Again Using Other email";
                    }
                }
            }
            
            $q = "INSERT INTO user(first_name, last_name, username, student_id, email, password, phone_no)
                  VALUES ('$fname', '$lname', '$uname', '$studID', '$email', SHA1('$pass1'), '$phone')";
            
            $result = @mysqli_query($dbc, $q);
            
            mysqli_close($dbc);
            
            if ($result) { 
                header("Location: sign-up-success.html");
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
        <title>Sign Up As User</title>
        <link href="signup.css" rel="stylesheet" type="text/css"/>
        <link href="includes/header.css" rel="stylesheet" type="text/css"/>
        <link href="includes/footer1.css" rel="stylesheet" type="text/css"/>
    </head>
    
    <header>
        <?php include ('includes\header.html');?>
    </header>
    
    <body>
        <div><h1>Sign Up</h1></div>

            <div class="signup-box">

                <div class="signup">
                   
                    
                    <form action="signup.php" method="post" id="signup-form">
                        <fieldset>
                        <div class="form-group">
                            <label>First Name</label><br>
                            <input type="text" name="fname" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'fname')){echo filter_input(INPUT_POST, 'fname');} ?>" placeholder="E.g.: abc" required>
                            <?php if(null !== $errorfname) {echo "<br><p>" . $errorfname . "</p><br>";}?>
                            <br><br>
                            <label>Last Name</label><br>
                            <input type="text" name="lname" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'lname')){echo filter_input(INPUT_POST, 'lname');} ?>" placeholder="E.g.: def" required>
                            <?php if(null !== $errorlname) {echo "<br><p>" . $errorlname . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Username</label><br>
                            <input type="text" name="uname" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'uname')){echo filter_input(INPUT_POST, 'uname');} ?>" placeholder="*At Least 5 Characters to A Maximum of 31 Characters" required>
                            <?php if(null !== $erroruname) {echo "<br><p>" . $erroruname . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Student ID</label><br>
                            <input type="text" name="studID" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'studID')){echo filter_input(INPUT_POST, 'studID');} ?>" placeholder="E.g.: 12AMD34567" required>
                            <?php if(null !== $errorstudentID) {echo "<br><p>" . $errorstudentID . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>E-mail</label><br>
                            <input type="text" name="email" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'email')){echo filter_input(INPUT_POST, 'email');}?>" placeholder="E.g.: abc@mail.com" required>
                            <?php if(null !== $erroremail) {echo "<br><p>" . $erroremail . "</p><br>";}?>
                        </div>
                        <br> 
                        <div class="form-group">
                            <label>Password</label><br>
                            <input type="password" name="pass1" class="form-control" value="" required/>
                            <?php if(null !== $errorpass1) {echo "<br><p>" . $errorpass1 . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Confirm Password</label><br>
                            <input type="password" name="pass2" class="form-control" value="" required/>
                            <?php if(null !== $errorpass2) {echo "<br><p>" . $errorpass2 . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Phone NO.</label><br>
                            <input type="text" name="phone" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'phone')){echo filter_input(INPUT_POST, 'phone');} ?>" placeholder="E.g.: 012-3456789" required> 
                            <?php if(null !== $errorphone) {echo "<br><p>" . $errorphone . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                             <input type="hidden" name="hidden" value="TRUE">                            
                        </div>
                        <div class="reminder">
                            <p><a class="admin" href="signup-admin.php"><b>Are You an Admin? Click to Sign Up as Admin</b></a></P>
                        </div>
                        <br>
                        </fieldset>
                        <div class="cancel">
                            <button type="submit" class="button">Sign&nbsp;Up</button>
                        </div>
                        <div class="cancel">
                        <input type="reset" value="Cancel" name="cancel" class="button"/>
                        </div>
                    </form>
                
            </div>
        
        </div>
        <?php

        ?>
          
    
    </body>
    
    
</html>
