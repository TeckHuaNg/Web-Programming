<?php ob_start(); 
// auth check
require_once('auth.php');
?>

<?php   
    
// set the page title
$page_title = "Movies";

// embed the header
    require_once('header.php');
    
try{

// connect
   require_once('db.php'); 
       
// prepare the query
   $sql = "SELECT * FROM movies";
    
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
    $movies = $cmd->fetchAll();
    
// start our grid
    echo '<div class="col-sm-6">
          <a href="movie.php" title="Add a New Movie">Add a New Movie</a></div>';
    
    echo '<div class="col-sm-6">
    <form method="get" action="movies.php">
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
        <th><a href="movies.php?$keywords=' . $keywords . '&search_type=' . $search_type . '&sort=title&dir=' . $next_dir . '">Title</a>
            <i class="' . set_arrow('title', $sort, $dir) . '"></i></th>
        <th><a href="movies.php?keywords=' . $keywords . '&search_type=' . $search_type . '&sort=year&dir=' . $next_dir . '">Year</a>
            <i class="' . set_arrow('year', $sort, $dir) . '"></i></th>
        <th><a href="movies.php?keywords=' . $keywords . '&search_type=' . $search_type . '&sort=length&dir=' . $next_dir . '">Length</a>
            <i class="' . set_arrow('length', $sort, $dir) . '"></i></th>
        <th><a href="movies.php?keywords=' . $keywords . '&search_type=' . $search_type . '&sort=url&dir=' . $next_dir . '">URL</a>
            <i class="' . set_arrow('url', $sort, $dir) . '"></i></th>
        <th>Edit</th>
        <th>Delete</th>
        </thead><tbody>';
    
// loop through the data and display the results
    foreach ($movies as $movie){
        echo '<tr><td>' . $movie['title'] . '</td>
              <td>' . $movie['year'] . '</td>
              <td>' . $movie['length'] . '</td>
              <td>' . $movie['url'] . '</td>
              <td><a href="movie.php?movie_id=' . $movie['movie_id'] . '">Edit</a>
              <td><a href="delete-movie.php?movie_id=' . $movie['movie_id'] . '" onclick="return confirm(\'Are you sure you want to delete this movie?\');">Delete</a></td></tr>';
    }
    
// close the grid
    echo '</tbody></table>';

//comment plugin     
    echo '<div class="fb-comments" data-href="http://gc200348264.computerstudi.es/comp1006/week12/movies.php" data-numposts="5"></div>';    

// disconnect
    $conn = null;

}catch (Exception $e){
    mail('michaelngteckhua@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
    header('location:error.php');
}    
// embed footer
require_once('footer.php');
ob_flush();
?>    
