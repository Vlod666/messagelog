<?php
require_once 'header.php';  
echo "<div class='main'>            
        <h3>Please enter your details to log in</h3>";
$error = $user = $pass = "";

if (isset($_POST['user']))  
{    
    $user = sanitizeString($_POST['user']);    
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")    
    {        
        $error = "Not all fields were entered!<br>";
    }
    else    
    {   $pass = md5($pass);        $result = queryMySQL("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");
        if ($result->num_rows == 0)        
        {        
            $error = "<span class='error'>Username/Password invalid</span><br><br>";
        }        
        else        
        {            
            $_SESSION['user'] = $user;            
            $_SESSION['pass'] = $pass;            
            die("You are now logged in." . "Please <a href='members.php?view=$user'>" . "click here</a> to continue.<br><br>");                

        }
        
    }
}

if ($error != '')
    echo "<div class='alert alert-danger' role='alert''> <span class='error'>$error</span> </div>";
echo <<<_END
<form method='post' action='login.php'>

  

    <div class="form-group">
        <label for="Username">Username</label>
        <input type="text" class="form-control" id="Username" maxlength='16' placeholder="Enter Username" name='user' value='$user'>
        
    </div>
    <div class="form-group">
        <label for="InputPassword1">Password</label>
        <input type="password" class="form-control" id="leInputPassword1" placeholder="Password" maxlength='16' name='pass' value='$pass'>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>

    <br>      

 	 
 	</form><br></div>


</body> 
</html>
_END;
?>
