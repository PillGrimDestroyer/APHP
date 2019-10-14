<?php 
	session_start(); 

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: login.php");
	}
	
	function getFeeds($url)
	{
		$content = file_get_contents($url);
		$items = new SimpleXmlElement($content);

		foreach ($items->xpath('//item') as $item) {
			echo "<div class='card' style='width: 30rem; margin-top: 10px; margin-right: auto; margin-left: auto;'>
				<div class='card-body'>
					<h5 class='card-title'>$item->title</h5>
					<p class='card-text'>$item->description</p>
					<a href='$item->guid' class='card-link'>Подробнее...</a>
				</div>
			</div>";
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
</head>
<body>
	<div class="header">
		<h2>Home Page</h2>
	</div>
	<div class="content">

		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		<!-- logged in user information -->
		<?php
			if (isset($_SESSION['username'])) {
				echo "
				<p>Welcome <strong>" . $_SESSION['username'] . "</strong></p>
				<p> <a href=\"index.php?logout='1'\" style='color: red;'>logout</a> </p>
				";
				getFeeds("http://news.yandex.ru/gadgets.rss");
			} else {
				echo "<a href='/pages/login.php' style='font-size: 21pt'>Авторизоваться</a>";
			}
		?>
	</div>
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</body>
</html>