<?php
require_once 'header.php';
if (!$loggedin) 
    die();
echo "<div class='main'><h3>Your Profile</h3>";

$result = queryMysql("SELECT * FROM profiles WHERE user='$user'");
if (isset($_POST['text']) or isset($_POST['calendar']) or isset($_POST['city']) or isset($_POST['work']) or isset($_POST['vk']) )
{
    if (isset($_POST['calendar']))
        $calendar = sanitizeString($_POST['calendar']);
    if (isset($_POST['city']))
        $city = sanitizeString($_POST['city']);
    if (isset($_POST['work']))
        $work = sanitizeString($_POST['work']);
    if (isset($_POST['vk']))
        $vk = sanitizeString($_POST['vk']);

    $text = sanitizeString($_POST['text']);    
    $text = preg_replace('/\s\s+/', ' ', $text);

    if ($result->num_rows)         
        queryMysql("UPDATE profiles SET calendar = '$calendar', city = '$city', work = '$work', vk = '$vk', text='$text' where user='$user'");
    else     
        queryMysql("INSERT INTO profiles VALUES('$user','$calendar', '$city', '$work', '$vk', '$text')");
}
else  
{   
    if ($result->num_rows)    
    {        
        $row = $result->fetch_array(MYSQLI_ASSOC);        
        $text = stripslashes($row['text']);    
    }    else $text = "";  
}
$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));  
if (isset($_FILES['image']['name']))  
{    
    $saveto = "$user.jpg";
    savePhoto($saveto, 150);
}

showProfile($user);

echo <<<_END
 <br style='clear:left;'><br>
 <form method='post' action='profile.php' enctype='multipart/form-data'>  
 <u><h5> Enter or edit your details and/or upload an image: </h5>  </u>
   
 Birthday: <input class="form-control" type="date" name="calendar" style="width: 45%">
 City: <input type="text" class="form-control" name='city' style="width: 45%">
 Place of study / work: <input type="text" class="form-control" name='work' style="width: 45%">
 Vk: <input type="text" class="form-control" name='vk' placeholder="Enter the link to your Vk" style="width: 45%"><br>
 <textarea class="form-control" name='text' cols='50' rows='3'>$text</textarea><br> 

Image: <input type='file' name='image' size='14'>
    <button type="submit" class="btn btn-primary">Save Profile</button>

	    
	</form></div><br>  
  </body> 
</html>
_END;
?>



