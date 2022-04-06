<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Profile.css" rel="stylesheet" type="text/css"/>
        <link href="includes/header.css" rel="stylesheet" type="text/css"/>
        <link href="includes/footer1.css" rel="stylesheet" type="text/css"/>
        <title><?php //user name ?>Profile</title>
    </head>
    
    <header>
        <?php include ('includes\UIheader.html');?>
    </header>
    
    <body>
        <div><h1>Profile</h1></div>
        <div>
            <h3>Events Joined</h3>
            <table class="content-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Event</th>
                        <th>Final Result</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="activerow">
                        <td>database</td>
                        <td>database</td>
                        <td>database</td>
                    </tr>
                    <tr>
                        <td>database</td>
                        <td>database</td>
                        <td>database</td>
                    </tr>
                    <tr>
                        <td>database</td>
                        <td>database</td>
                        <td>database</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
        // put your code here
        ?>
    </body>
    
    <footer>
        <?php include ('includes\footer.html');?>
    </footer>
</html>