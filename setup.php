<!DOCTYPE html> 
<html> 
	<head>   
		<title>Setting database</title>
	</head> 
	<body>
  		<h3>Setting up...</h3>
		<?php 
		require_once 'functions.php';
        createTable('members',
                    'user VARCHAR(16),            
                    pass VARCHAR(255),            
                    INDEX(user(6))');
        createTable('messages',
                    'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,            
                    auth VARCHAR(16),            
                    recip VARCHAR(16),            
                    pm CHAR(1),            
                    time INT UNSIGNED,            
                    message VARCHAR(4096),            
                    INDEX(auth(6)),            
                    INDEX(recip(6))');
        createTable('friends',            
                    'user VARCHAR(16),            
                    friend VARCHAR(16),            
                    INDEX(user(6)),            
                    INDEX(friend(6))');
        createTable('profiles',            
                    'user VARCHAR(16),
                    calendar VARCHAR(255),
                    city VARCHAR(255),
                    work VARCHAR(255),
                    vk VARCHAR(255),           
                    text VARCHAR(4096),            
                    INDEX(user(6))');
        createTable('posts',
            'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,            
                    auth VARCHAR(16),                                
                    time INT UNSIGNED,            
                    message VARCHAR(4096),            
                    INDEX(auth(6))');
					
		if (!file_exists('images')) {
			mkdir('images', 0777, true);
}
        ?>
  <br>...done.
  </body> 
</html>
