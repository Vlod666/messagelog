<?php
require_once 'header.php';
echo "<div class='main'>";
if (!$loggedin) die("</div></body></html>");
$error = '';
if (isset($_POST['text']))
{

    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);
    if ($text == "" )
    {
        $error = "Enter your message!";
    }
    else
    {
        $time = time();
        queryMysql("INSERT INTO posts VALUES(NULL ,'$user', '$time', '$text')");

        $result = queryMysql("SELECT id FROM posts ORDER BY id DESC LIMIT 1");
        $row = $result->fetch_array(MYSQLI_ASSOC);

        $lastid = $row['id'];

        if (isset($_FILES['image']['name']))
        {
            $saveto = "images/$lastid.jpg";

            savePhoto($saveto, 200);
        }
    }

}


if ($error != '')
    echo "<div class='alert alert-danger' role='alert''> <span class='error'>$error</span> </div>";

echo <<<_END
 <form method='post' action='posts.php' enctype='multipart/form-data'>  
 <h5>Enter here to leave a message and/or image:</h5>  
   
 <textarea name='text' cols='50' rows='3'></textarea><br> 
Image: <input  type='file' name='image' size='14'>
    <button type="submit" class="btn btn-primary">Post</button><br>    
 </form>
	
_END;

echo "<br><a data-role='button'
        href='posts.php'>Refresh messages</a><br><br>";

if (isset($_GET['delete']))
{
    $delete = sanitizeString($_GET['delete']);
    queryMysql("DELETE FROM posts WHERE id=$delete");
    $file = "images/$delete.jpg";
    if (file_exists($file)) {
        unlink($file);
    }
}


$query  = "SELECT user FROM friends WHERE friend='$user'";
$result = queryMysql($query);
$num_auth    = $result->num_rows;
$sql_str_auth = "'" . $user . "'";

for ($j = 0 ; $j < $num_auth ; ++$j)
{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $sql_str_auth = $sql_str_auth . ",'" . $row['user'] . "'";
}

$query  = "SELECT * FROM posts WHERE auth IN ($sql_str_auth) ORDER BY time DESC";
$result = queryMysql($query);
$num    = $result->num_rows;


for ($j = 0 ; $j < $num ; ++$j)
{
    $row = $result->fetch_array(MYSQLI_ASSOC);

    echo date("Y-m-d H:i:s", $row['time']);
    echo " <a href='messages.php?view=" . $row['auth'] . "'>" . $row['auth']. "</a>";
    if ($row['auth'] == $user)
    {
        echo "[<a href='posts.php?" . "delete=" . $row['id'] . "'>delete</a>]";
    }
    echo ":<br>";
    echo " &quot;" . $row['message'] . "&quot; ";


    $name_image = $row['id'];
    if (file_exists("images/$name_image.jpg"))
    {
        echo '<br>';
        echo "<img src='images/$name_image.jpg' align='left'><br><br><br><br><br><br><br>";

    }



    echo '<br><br>';
}

if (!$num)
    echo "<br><span class='info'>No posts yet</span><br>";

?>

</div><br>
</body>
</html>
