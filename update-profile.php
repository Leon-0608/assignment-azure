<!DOCTYPE html>
<?php
    require_once ('includes/mysqli_connect.php');
    session_start();
    
    if(empty($_SESSION['username'])){
        header("Location: login.php");
    }

    $error = [];
    $errorfname = null;
    $errorlname = null;
    $erroruname = null;
    $errorstudentID = null;
    $erroremail = null;
    $errorphone = null;
    
    if(null == filter_input(INPUT_POST, 'hidden')){
    if($_SESSION['class'] == 'user')
    {
        $details = "SELECT * FROM user WHERE username = '" . $_SESSION['username'] . "'";
        
        $detailsResult = @mysqli_query($dbc, $details);
        
        while ($rowu = mysqli_fetch_array($detailsResult)) {
        if($rowu['username'] == $_SESSION['username'])
        {
            $fname = $rowu['first_name'];
            $lname = $rowu['last_name'];
            $uname = $rowu['username'];
            $studID = $rowu['student_id'];
            $email = $rowu['email'];
            $phone = $rowu['phone_no'];
            
            $tfname = $rowu['first_name'];
            $tlname = $rowu['last_name'];
            $tuname = $rowu['username'];
            $tstudID = $rowu['student_id'];
            $temail = $rowu['email'];
            $tphone = $rowu['phone_no'];
        }            
    }
    }
    else if($_SESSION['class'] == 'admin')
    {
        $details = "SELECT * FROM admin WHERE admin_uname = '" . $_SESSION['username'] . "'";
        
        $detailsResult = @mysqli_query($dbc, $details);
        
        while ($rowa = mysqli_fetch_array($detailsResult)) {
        if($rowa['admin_uname'] == $_SESSION['username'])
        {
            $fname = $rowa['admin_fname'];
            $lname = $rowa['admin_lname'];
            $uname = $rowa['admin_uname'];
            $studID = $rowa['admin_sid'];
            $email = $rowa['admin_email'];
            $phone = $rowa['admin_tel'];
            
            $tfname = $rowa['admin_fname'];
            $tlname = $rowa['admin_lname'];
            $tuname = $rowa['admin_uname'];
            $tstudID = $rowa['admin_sid'];
            $temail = $rowa['admin_email'];
            $tphone = $rowa['admin_tel'];
        }         
    }
    }
    }
    
    if(null !== filter_input(INPUT_POST, 'hidden')){
        if(null !== filter_input(INPUT_POST, 'fname'))
        {
            if(preg_match("/^[a-zA-Z-' ]*$/", filter_input(INPUT_POST, 'fname')))
            {
                $fname = trim((filter_input(INPUT_POST, 'fname')));
            }
            else {
                $fname = null;
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
                $lname = null;
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
                $uname = null;
                $erroruname = "*Username Should Contain At Least 5 Characters to A Maximum of 31 Characters";
            }
        }
        else {
            
        }
       
        
        if(null !== filter_input(INPUT_POST, 'studID'))
        {
            if(preg_match('/(\d{2})(\w{3})(\d{5})/',(filter_input(INPUT_POST, 'studID'))))
            {
                $studID = trim((filter_input(INPUT_POST, 'studID')));
            }
            else {
                $studID = null;
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
                $email = null;
                $erroremail = "*Invalid Email Format";  
            }
            else {
                $email = trim(filter_input(INPUT_POST, 'email'));
            }
        }
        else {
            $error[] = "*Please Enter Your E-mail";
        }
        
        if(null !== filter_input(INPUT_POST, 'phone'))
        {
            if(preg_match('/(\d{3})\W(\d{7})/',(filter_input(INPUT_POST, 'phone'))))
            {
                $phone = trim(filter_input(INPUT_POST, 'phone')); 
            }
            else {
                $phone = null;
                $errorphone = "*Please Enter Your Phone Number In XXX-XXXXXXX Format";             
            }
        }
        else {
            $error[] = "*Please Enter Your Phone Number";
        }
  
        if($fname && $lname && $uname && $studID && $email && $phone){
            $quu = "SELECT username, student_id, email FROM user";
            $qau = "SELECT admin_uname, admin_sid, admin_email FROM admin";
            $resultquu = @mysqli_query($dbc, $quu);
            $resultqau = @mysqli_query($dbc, $qau);
            
            if($resultqau)
            {
                while($row = mysqli_fetch_array($resultqau))
                {
                    if($row['admin_uname'] == $uname && $uname != $tuname){
                        $erroruname = "Username Already Exist, Please Try Other Username";
                    }
                    if($row['admin_sid'] == $studID && $studID != $tstudID){
                        $errorstudentID = "Entered Student ID Already Registered, Please Try Again";
                    }
                    if($row['admin_email'] == $email && $email != $temail){
                        $erroremail = "Entered Email Already Registered, Please Try Again Using Other E-mail";
                    }
                }
            }
            
            if($resultquu)
            {
                 while($row = mysqli_fetch_array($resultquu))
                {
                    if($row['username'] == $uname && $uname != $tuname){
                        $erroruname = "Username Already Exist, Please Try Other Username";
                    }
                    if($row['student_id'] == $studID && $studID != $tstudID){
                        $errorstudentID = "Entered Student ID Already Registered, Please Try Again";
                    }
                    if($row['email'] == $email && $email != $temail){
                        $erroremail = "Entered Email Already Registered, Please Try Again Using Other email";
                    }
                }
            }
            
            if($_SESSION['class'] == 'user')
            {
                $q = "UPDATE user
                  SET first_name = '$fname', last_name = '$lname', username = '$uname', student_id = '$studID', email = '$email', phone_no = '$phone'
                  WHERE username = '" . $_SESSION['username'] . "'";
            }
            else if($_SESSION['class'] == 'admin')
            {
                $q = "UPDATE admin
                  SET admin_fname = '$fname', admin_lname = '$lname', admin_uname = '$uname', admin_sid = '$studID', admin_email = '$email', admin_tel = '$phone'
                  WHERE admin_uname = '" . $_SESSION['username'] . "'";
            }
            
            $result = @mysqli_query($dbc, $q);
            
            mysqli_close($dbc);
            
            if ($result) { 
                if($_SESSION['class'] == 'user')
                {   
                    header("Location: user-profile.php");
                }
                else if($_SESSION['class'] == 'admin')
                {
                    header("Location: admin-profile.php");
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
        <title>Update Profile</title>
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
        <div><h1>Update Profile</h1></div>

            <div class="signup-box">

                <div class="signup">
                   
                    
                    <form action="update-profile.php" method="post" id="signup-form">
                        <fieldset>
                        <div class="form-group">
                            <label>First Name</label><br>
                            <input type="text" name="fname" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'fname')){echo filter_input(INPUT_POST, 'fname');}elseif(isset($fname)){echo $fname;} ?>" placeholder="E.g.: abc" required>
                            <?php if(null !== $errorfname) {echo "<br><p>" . $errorfname . "</p><br>";}?>
                            <br><br>
                            <label>Last Name</label><br>
                            <input type="text" name="lname" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'lname')){echo filter_input(INPUT_POST, 'lname');}elseif(isset($lname)){echo $lname;} ?>" placeholder="E.g.: def" required>
                            <?php if(null !== $errorlname) {echo "<br><p>" . $errorlname . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Username</label><br>
                            <input type="text" name="uname" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'uname')){echo filter_input(INPUT_POST, 'uname');}elseif(isset($uname)){echo $uname;} ?>" placeholder="*At Least 5 Characters to A Maximum of 31 Characters" required>
                            <?php if(null !== $erroruname) {echo "<br><p>" . $erroruname . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Student ID</label><br>
                            <input type="text" name="studID" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'studID')){echo filter_input(INPUT_POST, 'studID');}elseif(isset($studID)){echo $studID;} ?>" placeholder="E.g.: 12AMD34567" required>
                            <?php if(null !== $errorstudentID) {echo "<br><p>" . $errorstudentID . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>E-mail</label><br>
                            <input type="text" name="email" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'email')){echo filter_input(INPUT_POST, 'email');}elseif(isset($email)){echo $email;}?>" placeholder="E.g.: abc@mail.com" required>
                            <?php if(null !== $erroremail) {echo "<br><p>" . $erroremail . "</p><br>";}?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Phone NO.</label><br>
                            <input type="text" name="phone" class="form-control" value="<?php if(null !== filter_input(INPUT_POST, 'phone')){echo filter_input(INPUT_POST, 'phone');}elseif(isset($phone)){echo $phone;} ?>" placeholder="E.g.: 012-3456789" required> 
                            <?php if(null !== $errorphone) {echo "<br><p>" . $errorphone . "</p><br>";}?>
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
                confirm("Are you sure you want to make this change(s) to your account?");
            }
        </script>
    </body>
    
    
</html>
