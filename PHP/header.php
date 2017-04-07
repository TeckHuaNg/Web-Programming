<!DOCTYPE html>
<html>

<head>
    <meta content="text/html"; charset="utf-8" http-equiv="content-type">
    <title><?php echo $page_title; ?></title>
    
    <!-- Add font-awesome for up / down arrows -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    
     <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>  
   
</head>

<body>
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    
<nav class="navbar">
    <a href="menu.php" title="COMP1006 Web Application" class="navbar-brand">COMP1006 App</a>
    
    <ul class="nav navbar-nav">
        <?php //show public or private links depending on whether the user has been authenticated 
            if (!empty($_SESSION[user_id])) { ?>
            <li><a href="movies.php" title="Movies">Movies</a></li>
            <li><a href="gallery.php" title="Gallery">Gallery</a></li>
            <li><a href="books.php" title="books">Books</a></li>   
            <li><a href="logout.php" title="Logout">Logout</a></li>
        <?php        
}else {  ?>
        <li><a href="register.php" title="Register">Register</a></li>
        <li><a href="login.php" title="Login">Login</a></li>
<?php } ?>
        
    </ul>
</nav>    

<!-- page contents start here -->