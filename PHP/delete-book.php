<?php ob_start(); 

require_once('auth.php');

require_once('header.php');

try{
    
    //capture the selected movie id from the url and store it in a variable with the same name
    $book_id = $_GET['book_id'];
    
    //connect
    require_once('db.php');
    
    //set up the SQL command
    $sql = "DELETE FROM books WHERE book_id = :book_id";
    
    //create a command object so we can populate the movie_id value, then run the deletion
    $cmd = $conn -> prepare($sql);
    $cmd -> bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $cmd -> execute();
    
    //disconnect
    $conn = null;
    
    header('location:books.php');
    
}
catch (Exception $e){
    mail('michaelngteckhua@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
    header('location:error.php');
} 
    ?>

<?php
require_once('footer.php');
ob_flush(); ?>