<?php
$dbhost  = 'localhost'; 
$dbname  = 'messagelog';    
$dbuser  = 'root';    
$dbpass  = '';   
$appname = "MessageLog"; 

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);  
if ($connection->connect_error) 
    die($connection->connect_error);

function createTable($name, $query)  
{    
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");    
    echo "Таблица '$name' создана или уже существовала";  
}

function queryMysql($query)  
{    
    global $connection;    
    $result = $connection->query($query);    
    if (!$result) die($connection->error);    
    return $result;  
}

function destroySession()
{    
    $_SESSION=array();
    if (session_id() != "" || isset($_COOKIE[session_name()]))        
        setcookie(session_name(), '', time()-2592000, '/');
    
    session_destroy();  
}

function sanitizeString($var)  
{    
    global $connection;    
    $var = strip_tags($var);    
    $var = htmlentities($var);    
    $var = stripslashes($var); 
    
    return $connection->real_escape_string($var);  

}

function showProfile($user)  
{    
    if (file_exists("$user.jpg"))        
        echo "<img src='$user.jpg' align='left'>";
    
    $result = queryMysql("SELECT * FROM profiles WHERE  user='$user'");
    if ($result->num_rows)    
    {        
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($row['calendar'] != '')
            echo 'Birthday: ' . stripslashes($row['calendar']  ) . '<br>';
        if ($row['city'] != '')
            echo 'City: ' . stripslashes($row['city']  ) . '<br>';
        if ($row['work'] != '')
            echo 'Place of study / work: ' . stripslashes($row['work']  ) . '<br>';
        if ($row['vk'] != '')
        {
            $link = $row['vk'];
            echo 'Vk: ' . "<a data-role='button' data-transition='slide' href='$link'>$link</a>" ;
        }

        echo "<br style='clear:left;'><br>";
        if ($row['text'] != '')
            echo 'About me: ' . stripslashes($row['text']) . "<br style='clear:left;'><br>";
    }
}

function savePhoto ($path, $max)
{
    move_uploaded_file($_FILES['image']['tmp_name'], $path);
    $typeok = TRUE;

    switch($_FILES['image']['type'])
    {
        case "image/gif":   $src = imagecreatefromgif($path);
            break;
        case "image/jpeg":
            //Как обычный, так и прогрессивный JPEG-формат
        case "image/pjpeg": $src = imagecreatefromjpeg($path);
            break;
        case "image/png":   $src = imagecreatefrompng($path);
            break;
        default: $typeok = FALSE;
            break;
    }
    if ($typeok) {
        list($w, $h) = getimagesize($path);

        $tw = $w;
        $th = $h;
        if ($w > $h && $max < $w) {
            $th = $max / $w * $h;
            $tw = $max;
        } elseif ($h > $w && $max < $h) {
            $tw = $max / $h * $w;
            $th = $max;
        } elseif ($max < $w) {
            $tw = $th = $max;
        }
        $tmp = imagecreatetruecolor($tw, $th);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
        //imageconvolution($tmp, array(array(–1, –1, –1), array(–1, 16, –1), array(–1, –1, –1)), 8, 0);
        imagejpeg($tmp, $path);
        imagedestroy($tmp);
        imagedestroy($src);
    }
}

?>