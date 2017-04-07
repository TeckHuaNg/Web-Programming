<?php ob_start();

// auth check
require_once('auth.php');

try{
    //capture the selected movie id from the url and store it in a variable with the same name
    $movie_id = $_GET['movie_id'];
    
    //connect
    require_once('db.php');
    
    //set up the SQL command
    $sql = "DELETE FROM movies WHERE movie_id = :movie_id";
    
    //create a command object so we can populate the movie_id value, then run the deletion
    $cmd = $conn -> prepare($sql);
    $cmd -> bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $cmd -> execute();
    
    //disconnect
    $conn = null;
    header('location:movies.php');
}
catch (Exception $e){
    mail('michaelngteckhua@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
    header('location:error.php');
}    

require_once('footer.php');
ob_flush(); ?>