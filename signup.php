<?php
require_once 'header.php';
echo <<<_END
<script> 
    function checkUser(user)  
    {    
        if (user.value == '')    
        {        
            O('info').innerHTML = ''        
            return    
        }
     

        params  = "user=" + user.value    
        request = new ajaxRequest()    
        request.open("POST", "checkuser.php", true)    
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded")    
        request.setRequestHeader("Content-length", params.length)    
        request.setRequestHeader("Connection", "close")
        
        request.onreadystatechange = function()    
        {        
            if (this.readyState == 4)           
                if (this.status == 200)              
                    if (this.responseText != null)                 
                        O('info').innerHTML = this.responseText    
        }    
        request.send(params)  
    }

    function ajaxRequest()  
    {    
        try {
                var request = new XMLHttpRequest()
            }    
        catch(e1)
        {        
            try {request = new ActiveXObject("Msxml2.XMLHTTP")
        }        
            catch(e2)
            {            
                try {
                    request = new ActiveXObject("Microsoft.XMLHTTP")
                    }            
                catch(e3)
                {                
                 request = false    
                } 
            }
            
        }    
        return request
    }
</script>  
<div class='main'><h3>Please enter your details to sign up</h3>          
_END;

$error = $user = $pass = "";  
if (isset($_SESSION['user'])) destroySession();

if (isset($_POST['user']))  
{    
    $user = sanitizeString($_POST['user']);    
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")       
        $error = "Not all fields were entered!<br><br>";
    else    
    {      
        $result = queryMysql("SELECT * FROM members WHERE user='$user'");           
        if ($result->num_rows)            
            $error = "This name already exists!<br><br>";
        else            
        {   $pass = md5($pass);
            queryMysql("INSERT INTO members VALUES('$user','$pass')");
            die("<div class='alert alert-success' role='alert''> <h4>Account created!</h4>Please Log in.<br><br> </div>");

        }    
    }  
}

if ($error != '')
    echo "<div class='alert alert-danger' role='alert''> <span class='error'>$error</span> </div>";

echo <<<_END
<form method='post' action='signup.php'>  


    <div class="form-group">
        <label for="Username">Username</label>
        <input type="text" class="form-control" id="Username" maxlength='16' placeholder="Enter Username" name='user' value='$user' onBlur='checkUser(this)'><span id='info'></span>
        
    </div>
    <div class="form-group">
        <label for="InputPassword1">Password</label>
        <input type="text" class="form-control" id="leInputPassword1" placeholder="Password" maxlength='16' name='pass' value='$pass'>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
</form></div><br>  
</body> 
</html>
_END;

 
?>


 