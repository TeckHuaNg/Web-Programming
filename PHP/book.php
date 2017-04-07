<?php ob_start(); 

//auth check
require_once('auth.php');

// set page title
$page_title = "Book Details";

require_once('header.php');
    // check the url for a movie_id parameter and store the value in a variable if we find one

try{
if (empty($_GET['book_id']) == false) {
    $book_id = $_GET['book_id'];

    // connect
    require_once('db.php');
    
    // write the sql query
    $sql = "SELECT * FROM books WHERE book_id = :book_id";
    
    // execute the query and store the results
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $cmd->execute();
    $books = $cmd->fetchAll();
    
    // populate the fields for the selected movie from the query result
    foreach ($books as $book) {
        $title = $book['title'];
        $author = $book['author'];
        $year = $book['year'];
        $photo = $book['photo'];
    }
    
    // disconnect
    $conn = null;
}
    }
catch (Exception $e){
    mail('michaelngteckhua@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
    header('location:error.php');
} 
    ?>
    
   <div class="container">
    <h1>Book Info</h1> 
    <form method="post" action="save-book.php" enctype="multipart/form-data">
        <fieldset class="form-group">
            <label for="title" class="col-sm-2">Title: </label>
            <input name="title" id="title" required value="<?php echo $title; ?>" />
        </fieldset>
        
        <fieldset class="form-group">
            <label for="author" class="col-sm-2">Author: </label>
            <input name="author" id="author" required value="<?php echo $author; ?>" />
        </fieldset>
        
        <fieldset class="form-group">
            <label for="year" class="col-sm-2">Year: </label>
            <input name="year" id="year" required type="number" value="<?php echo $year; ?>" />
        </fieldset>
        
        <fieldset class="form-group">
            <label for="photo" class="col-sm-2">Photo:</label>
            <input type="file" id="photo" name="photo">
        </fieldset>
        
        <?php if (!empty($photo)) { ?>
           <div class="col-sm-offset-2">
               <img src="images/<?php echo $photo; ?>" alt="Book Cover">
           </div>
        <?php } ?>
        
        <input name="book_id" type="hidden" value="<?php echo $book_id; ?>"/>
        
        <button type="submit" class="col-sm-offset-2 btn btn-success">Submit</button>
    </form>
  </div>

<?php
require_once('footer.php');
ob_flush(); ?>