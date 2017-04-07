<?php ob_start(); 

require_once('auth.php');

// set the page title
$page_title = "Books";

// embed the header
    require_once('header.php');

try{    
// connect
   require_once('db.php'); 
    
// prepare the query
   $sql = "SELECT * FROM books";
    
// check if the user entered keywords for searching
$keywords = $_GET['keywords'];

if (!empty($keywords)) {

    // start the WHERE clause MAKING SURE to include spaces around the word WHERE
    $where = " WHERE ";
    
    // split the keywords into an array of individual words
    $word_list = explode(" ", $keywords);
    
    // start a counter so we know which element in the array we are at
    $counter = 1;
    
    // loop through the word list and add each word to the where clause individually
    foreach($word_list as $word) {
    
        // for the first word OMIT the word OR
        if ($counter == 1) {
            $where .= " title LIKE '%$word%' ";
        }
        else {
            // did the user pick Any or All Keywords?
            $search_type = $_GET['search_type'];
            
            $where .= " $search_type title LIKE '%$word%' ";
        } 
        
        // increment counter 
        $counter++;
    }

    $sql .= $where;
}
    
    
// set default direction to ascending
    $dir = 'asc';
    $next_dir = 'asc';
    
    // add the sort column if there is one
    if (!empty($_GET['sort'])) {
        $sort = $_GET['sort'];
        $sql .= " ORDER BY $sort";
        
        // add the sort direction if there is one
        if(!empty($_GET['dir'])) {
            $dir = $_GET['dir'];
            
            if ($dir == 'desc') {
                // add descending direction to the SQL query
                $sql .= " DESC";
                
                // toggle direction for next time
                $next_dir = 'asc';
            }
            else {
                // add ascending direction to the SQL query
                $sql .= " ASC";
                
                // toggle direction for next time
                $next_dir = 'desc';
            }
        }    
    }
    
    function set_arrow($column, $sort_column, $sort_direction) {
    
        //empty class name by default
        $class = '';
        
        //is the current column the same as the sort column?
        if ($column == $sort_column) {
            //show the up or down arrow accordingly
            if ($sort_direction == 'asc') {
                $class = "fa fa-sort-asc";
            }
            else {
                $class = "fa fa-sort-desc";
            }
        }
        
        return $class;
    }
    
// run the query and store the result
    $cmd = $conn->prepare($sql);
    $cmd -> execute();
    $books = $cmd->fetchAll();
    
// start our grid
    echo '<div class="col-sm-6">
          <a href="book.php" title="Add a New Movie">Add a New Book</a></div>';
    
    echo '<div class="col-sm-6">
    <form method="get" action="books.php">
        <label for="keywords">Enter Keywords to Search:</label>
        <input name="keywords" />
        <select name="search_type">
            <option value="OR">Any Keyword</option>
            <option value="AND">All Keywords</option>
        </select>
        <button type="submit" class="btn btn-success">Search</button>
    </form>
</div>';
   
    // start the html display table
    echo '<table class="table table-striped table-hover"><thead>
        <th><a href="books.php?$keywords=' . $keywords . '&search_type=' . $search_type . '&sort=title&dir=' . $next_dir . '">Title</a>
            <i class="' . set_arrow('title', $sort, $dir) . '"></i></th>
        <th><a href="books.php?keywords=' . $keywords . '&search_type=' . $search_type . '&sort=author&dir=' . $next_dir . '">Author</a>
            <i class="' . set_arrow('author', $sort, $dir) . '"></i></th>
        <th><a href="books.php?keywords=' . $keywords . '&search_type=' . $search_type . '&sort=year&dir=' . $next_dir . '">Year</a>
            <i class="' . set_arrow('year', $sort, $dir) . '"></i></th>
        <th>Edit</th>
        <th>Delete</th>
        </thead><tbody>';
    
// loop through the data and display the results
    foreach ($books as $book){
        echo '<tr><td>' . $book['title'] . '</td>
              <td>' . $book['author'] . '</td>
              <td>' . $book['year'] . '</td>
              <td><a href="book.php?book_id=' . $book['book_id'] . '">Edit</a>
              <td><a href="delete-book.php?book_id=' . $book['book_id'] . '" onclick="return confirm(\'Are you sure you want to delete this book?\');">Delete</a></td></tr>';
    }
    
// close the grid
    echo '</tbody></table>';
    
// disconnect
    $conn = null;    
}
catch (Exception $e){
    mail('michaelngteckhua@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
    header('location:error.php');
}    
        
?>    

<?php 
require_once('footer.php');
ob_flush(); ?>