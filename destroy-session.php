<?php
    function dessess(){
        session_start();
        $_SESSION = array();
        session_destroy();
    }
    dessess();
?>

<html>
    <head>
        <title>Logging Out. . .</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="refresh" content="0; url=homepage.php" />   
    </head>
    <body>
        
    </body>
</html>