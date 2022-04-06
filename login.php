<!DOCTYPE html>
<?php
    require_once ('includes/mysqli_connect.php');
    session_start();
    
    if(isset($_SESSION['username'])){
        header("Location: user-profile.php");
    }
    
    $error = [];

    $erroruname = null;
    $errorpass = null;
    $errorunameval = null;
    $errorpassval = null;
    
    $uname = null;
    $pass = null;

    if(null !== filter_input(INPUT_POST, 'hidden')){
        if (null !== filter_input(INPUT_POST, 'uname'))
        {
            if (preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', filter_input(INPUT_POST, 'uname')) )
            {
                $uname = trim((filter_input(INPUT_POST, 'uname')));
            }
            else {
                $erroruname = "*Username Should Contain At Least 5 Characters to A Maximum of 31 Characters";
            }
        }
        else {
            $error[] = "*Please Enter Your User-name";
        }
        
        if(null !== filter_input(INPUT_POST, 'pass'))
        {
            if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', filter_input(INPUT_POST, 'pass')))
            {
                $pass = trim(filter_input(INPUT_POST, 'pass'));  
            }
            else {
                $errorpass = "*Password Must Be Between 8 to 12 Characters And Contain Both Digit and Word Character";
            }
        }
        else {
            $error[] = "*Please Enter Your Password";
        }
        
        if($uname && $pass){
            $q = "SELECT username, password FROM user";
            
            $result = @mysqli_query($dbc, $q);

            if ($result) { 
                while ($row = mysqli_fetch_array($result)) {
                    if($row['username'] == $uname){
                        if($row['password'] == sha1($pass)){
                            mysqli_close($dbc);
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['class'] = "user";
                            header("Location: homepage.php");
                        }
                        else {
                            $errorpassval = "*Incorrect Password, Please Try Again.";
                        } 
                    }
                    else {
                        $errorunameval = "*Username not found.";
                    }
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
        <title>Log In As User</title>
        <link href="login.css" rel="stylesheet" type="text/css"/>
        <link href="includes/header.css" rel="stylesheet" type="text/css"/>
        <link href="includes/footer1.css" rel="stylesheet" type="text/css"/>
    </head>
    
    <header>
        <?php include ('includes\header.html');?>
    </header>
    
    <body>
        <div><h1>Log In</h1></div>

            <div class="login-box">

                <div class="login">
                   
                    
                    <form action="login.php" method="post" id="login-form">
                        <fieldset>
                        <div class="form-group">
                            <label>Username</label><br>
                            <input type="text" name="uname" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'uname')){echo filter_input(INPUT_POST, 'uname');} ?>" required>
                            <?php if(null !== $erroruname) {echo "<br><p>" . $erroruname . "</p><br>";}?>
                            <?php if(null !== $errorunameval) {echo "<br><p>" . $errorunameval . "</p><br>";}?>
                        </div>
                        <br> 
                        <div class="form-group">
                            <label>Password</label><br>
                            <input type="password" class="form-control" name="pass" value="" required/>
                            <?php if(null !== $errorpass) {echo "<br><p>" . $errorpass . "</p><br>";}?>
                            <?php if(null !== $errorpassval) {echo "<br><p>" . $errorpassval . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                             <input type="hidden" name="hidden" value="TRUE">                            
                        </div>
                        <br>
                        <div class="reminder">
                            <p><a class="admin" href="login-admin.php"><b>Are You an Admin? Click to Log In as Admin</b></a></P>
                        </div>
                        </fieldset>
                        <div class="submit">
                            <button type="submit" class="button">Log&nbsp;In</button>
                        </div>
                        <div class="cancel">
                        <input type="reset" value="Cancel" name="cancel" class="button"/>
                        </div>
                    </form>
                
            </div>
        
        </div>
          
    
    </body>
   
    
</html>
