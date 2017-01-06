<?php 

//var_dump($_POST);
if(isset($_POST['name'])){ $name = $_POST['name']; } 

if(isset($_POST['email'])){ $email = $_POST['email']; } 

if(isset($_POST['information'])){ $info = $_POST['information']; } 

//print_r($info);

$new = json_decode($info);
var_dump($new);




?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<p> Order for: <?php echo $name; ?>  Email: <?php echo $email; ?></p>

<pre>
	<?php 
		print_r($new);
	 ?>
</pre>
</body>
</html>