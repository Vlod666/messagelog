<?php
session_start();  
echo "<!DOCTYPE html>\n<html><head>";  
require_once 'functions.php';
$userstr = ' (Guest)';
if (isset($_SESSION['user']))  
{    
    $user = $_SESSION['user'];    
    $loggedin = TRUE;    
    $userstr  = " ($user)";  
}  
else 
    $loggedin = FALSE;

echo
<<<_INIT
<title>$appname$userstr</title>
    
    <link rel="shortcut icon" href="rob.ico" type="image/x-icon">

    <link rel='stylesheet' href='styles.css' type='text/css'>          
    </head><body><center><canvas id='logo' width='624'       
    height='96'>$appname</canvas></center>                     
    <div class='appname'>$appname$userstr</div>                
    <script src='javascript.js'></script>
    <link rel='stylesheet' href='jquery.mobile-1.4.5.min.css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel='stylesheet' href='styles.css' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

_INIT;


if ($loggedin)
{
    echo
    <<<_LOGGEDIN

    <br ><ul class='menu'>   
    <li><a href='posts.php'>Posts</a></li>      
    <li><a href='members.php?view=$user'>Home</a></li>         
    <li><a href='members.php'>Members</a></li>                 
    <li><a href='friends.php'>Friends</a></li>                
    <li><a href='messages.php'>Messages</a></li>            
    <li><a href='profile.php'>Edit Profile</a></li>            
    <li><a href='logout.php'>Log out</a></li>
    </ul><br></ul><br>
    
        
_LOGGEDIN;


}
else  
    {    
        echo ("<br><ul class='menu'>" .         
        "<li><a href='index.php'>Home</a></li>"                .         
        "<li><a href='signup.php'>Sign up</a></li>"            .         
        "<li><a href='login.php'>Log in</a></li></ul><br>" .         
        "<span class='info'>&#8658; You must be logged in to " . "view this page.</span><br><br>");         // Для просмотра этой страницы нужно войти на сайт
    } 

?>