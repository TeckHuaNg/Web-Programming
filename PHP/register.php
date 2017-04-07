<?php
$page_title = "User Registration";
require_once('header.php'); ?>
  
<main class="container">
    
    <h1>User Registration</h1>
    
    <form method="post" action="save-registration.php">
        <fieldset class="form-group">
            <label for="username" class="col-sm-2">Email:</label>
            <input name="username" required type="email" id="username">
        </fieldset>
        <fieldset class="form-group">
            <label for="password" class="col-sm-2">Password:</label>
            <input name="password" required type="password" id="password">
        </fieldset>
        <fieldset class="form-group">
            <label for="confirm" class="col-sm-2">Confirm:</label>
            <input name="confirm" required type="password" id="confirm">
        </fieldset>
        <div class="g-recaptcha" data-sitekey="6LdlbBsUAAAAAKf665avczqf68SUhq_hIDiYUUSi"></div> 
        <button class="btn btn-success col-sm-offset-2">Register</button>
    </form>
    
</main>    

<?php require_once('footer.php'); ?>