<?php ob_start();

// access the existing session
session_start();

// remove all session variables
session_unset();

// destroy the user session
session_destroy();

// redirect to login
header('location:login.php');

?>

<!DOCTYPE html>
<html>
    
<head>
    <meta content="text/html" charset="utf-8" http-equiv="content-type">
    <title>Log Out</title>
</head>    

<body>

</body>
</html>

<?php ob_flush(); ?>