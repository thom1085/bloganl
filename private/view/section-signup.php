<h2>Sign up for an account!</h2>

<form id="signin"  method="GET" action="">
    
    <input type="email" name="email" class="select" placeholder="your email" value="<?php showEntered("email"); ?>">
    <input type = "password" name="password" class="select" placeholder="Your Password" value="<?php showEntered("password"); ?>">
    <input type = "password" name="passwordcheck" class="select" placeholder="Re-write your Password" value="<?php showEntered("passwordcheck"); ?>">
    <input type="text" name="user" class="select" placeholder="user" value="<?php showEntered("user"); ?>">
    <input type="hidden" name="codebarre" value="signin"> 
    <button type="submit">sign up!</button>
    <div class="response"></div>
    <br>
    <br>
    
<?php

if (count($_GET) > 0)
{
    require_once("private/control/traitment-formula-signup.php");
}

?>