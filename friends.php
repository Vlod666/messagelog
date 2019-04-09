<?php  
require_once 'header.php';
if (!$loggedin) 
    die();
if (isset($_GET['view'])) 
    $view = sanitizeString($_GET['view']);  
else                      
    $view = $user;
if ($view == $user)  
{    
    $name1 = $name2 = "Your";    

    $name3 = "You are"; 

}  
else  
{    
    $name1 = "<a href='members.php?view=$view'>$view</a>'s";    
    $name2 = "$view's";
    $name3 = "$view is";  
}
      
echo "<div class='main'>";

// showProfile($view);
$followers = array();
$following = array();
$result = queryMysql("SELECT * FROM friends WHERE user='$view'");  
$num    = $result->num_rows;

for ($j = 0 ; $j < $num ; ++$j)  
{    
    $row = $result->fetch_array(MYSQLI_ASSOC);    
    $followers[$j] = $row['friend'];  
}

$result = queryMysql("SELECT * FROM friends WHERE friend='$view'");
$num    = $result->num_rows;

for ($j = 0 ; $j < $num ; ++$j)  
{    
    $row = $result->fetch_array(MYSQLI_ASSOC);    
    $following[$j] = $row['user'];  
}

$mutual    = array_intersect($followers, $following);  
$followers = array_diff($followers, $mutual);  
$following = array_diff($following, $mutual);  
$friends   = FALSE;

if (sizeof($mutual))  
{   $count = count($mutual);
    echo "<span class='subhead'>$name2 mutual friends ($count)</span><ul>";
    // Взаимные друзья    
    foreach($mutual as $friend)        
        echo "<li><a href='members.php?view=$friend'>$friend</a>";
    
    echo "</ul>";    
    $friends = TRUE;  
}

if (sizeof($followers))  
{
    $count = count($followers);
    echo "<span class='subhead'>$name2 followers ($count)</span><ul>";
    // Интересующиеся в дружбе с...    
    foreach($followers as $friend)        
        echo "<li><a href='members.php?view=$friend'>$friend</a>";    
    echo "</ul>";    
    $friends = TRUE;  
}

if (sizeof($following))  
{
    $count = count($following);
    echo "<span class='subhead'>$name3 following ($count)</span><ul>";
    // Заинтересован в дружбе с...    
    foreach($following as $friend)        
        echo "<li><a href='members.php?view=$friend'>$friend</a>";    
    echo "</ul>";    
    $friends = TRUE;  
}

if (!$friends) 
    echo "<br>You don't have any friends yet.<br><br>";       
// Пока у вас нет друзей    
echo "<a class='button' href='messages.php?view=$view'>" . "View $name2 messages</a>";       
// Просмотр сообщений от ...  
?>

		</div><br>  
	</body> 
</html>