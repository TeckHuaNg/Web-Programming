<?php ob_start(); ?>
 
<!DOCTYPE html>
<html>

<body>

<?php   
session_start();
// store the inputs & hash the password
     
$username = $_POST['username'];
$password = hash('sha512', $_POST['password']);

try{    
// connect
require_once('db.php');

// write the query
$sql = "SELECT user_id FROM users WHERE username = :username AND password = :password";

// create the command, run the query and store the result
$cmd = $conn->prepare($sql);
$cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
$cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
$cmd->execute();
$users = $cmd->fetchAll();
 
// if count is 1, we found a matching username and password in the database
if (count($users) >= 1) {
     
    echo 'Logged in Successfully.';   
    
    foreach  ($users as $user) {
     $_SESSION['user_id'] = $user['user_id'];
    }
    header('location:menu.php');       
}
else {
    echo 'Invalid Login';
}

$conn = null;
}
catch (Exception $e){
    mail('michaelngteckhua@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
    header('location:error.php');
}       
?>

</body>
</html>
<?php ob_flush(); ?>