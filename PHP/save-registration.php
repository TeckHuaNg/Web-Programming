<?php ob_start();

$page_title = 'Saving your Registration';
require_once('header.php');

try{
// 1. store form inputs in variables
$username = $_POST['username'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];
$ok = true;
    
// 2. validate the inputs - no blanks, matching passwords
if (empty($username)){
   echo 'Email is required<br/>';
   $ok = false;
}

if (empty($password)){
    echo 'Password is required<br/>';
    $ok = false;
}

if (empty($confirm)){
    echo 'Confirm Password is required<br/>';
    $ok = false;
}    
    
if ($password != $confirm){
    echo 'Passwords must match<br/>';
    $ok = false;
}
    
//set up values checking Recaptcha
    $secret = "6LdlbBsUAAAAAN9QDtuQGBE_ek0f8WGo2Aui_hk3";
    $response = $_POST['g-recaptcha-response'];
    
//set up url request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    
//create an array to hold the values we want to post to Google
    $post_data = array();
    $post_data['secret'] = $secret;
    $post_data['response'] = $response;
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    
//execute the curl request
    $result = curl_exec($ch);
    curl_close($ch);
    
// convert the response object from a json object to an array so we can read it 
    $result_array = json_decode($result, true);
    
//check if the success value is tur or false
    if($result_array['success']==false){
        echo 'Are you human?';
        $ok = false;
    }
    
// 3. if inputs are ok, connect
if ($ok == true){
    require_once('db.php');
    
    // 4. set up the sql command
    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
    
    // 5. Hash the password for added security
    $hashed_password = hash('sha512', $password);
    
    // 6. execute the save
    $cmd = $conn -> prepare($sql);
    $cmd-> bindParam(':username', $username, PDO::PARAM_STR, 50);
    $cmd-> bindParam(':password', $hashed_password, PDO::PARAM_STR, 128);
    $cmd-> execute();
    
    // 7. disconnect
    $conn = null;
    
    // 8. Show a confirmation message to the user
    echo 'User Saved';

}
}
catch (Exception $e){
    mail('michaelngteckhua@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
    header('location:error.php');
} 
       
require_once('footer.php');    
    
?>