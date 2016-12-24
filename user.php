<?php
	session_start();
	if(!isset($_SESSION['userlogin'])) {
		header("Location: index.php");
	}
?>

<html>
	<head>
		<title>ShareLibrary | Homepage</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="src/css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	</head>
	<body>
		<center>
		<nav class="navbar navbar navbar-fixed" id="thisnav">
			<div class="navbar-header">
      			<a class="navbar-brand" href="#"><img src="src/images/lettermark.png" width="40%"></a>
    		</div>
    		<ul class="nav navbar-nav">
				<li><a href="#"><b><b>Library</b></b></a></li>
				<li><a class="inactive" href="loan.php"><b><b>My Books</b></b></a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<?php
						$temp = explode(" ", $_SESSION['userlogin']);
						$username = $temp[2];
						echo "<a>Hello, <b>" . $username . "</b></a>";
					?>
				</li>
				<li>
					<form method="post" action="services/feature.php" enctype="multipart/form-data">
						<input name="command" value="logout" type="hidden">
						<button id="logout" type="submit"><b>Logout</b></button>
					</form>
				</li>
			</ul>
		</nav>
		<div class="home index">
			<br>
			<br>
			<br>
			<p><img src="src/images/library.png" width="8%"></p>
			<h2>LIBRARY</h2>
			<div class="line2"></div>
			<br>
		</div>

		<?php
			include "services/feature.php";
			$books = selectAllFromTable("book");
				while ($row = mysqli_fetch_row($books)) {
								echo "<div class='card'>";
								foreach($row as $key => $value) {
									if($key === 1) {
										echo "<img class='bitmap' src='$value'><br>";
									}
									else if($key === 2) {
										echo "<p class='booktitle'>$value</p>";
									}
									else if($key === 3) {
										echo "<p class='author'>by $value published by ";
									}
									else if($key === 4) {
										echo "$value</p><hr>";
									}
									else if($key === 5) {
										echo "<p class='description'> </p>";
									}
									else if($key === 6) {
										echo "<p class='quantity'>$value books left</p>";
									}
									else if($key !== 0) {
										echo "<p>$value</p>";
									}
								}
								$button = '<p>';
								if($row[6] < 1) {
									$button .= '<form><p class="text-grey">No Book Left </p></form>';
								}
								else {
									if($check = checkBorrowBook($row[0])) {
										$button .= '<form>
										<p class="text-grey">
										You Already Borrow This Book </p></form>';
									}
									else {
										$button .= '<form action="services/feature.php" method="post">
										<input type="hidden" id="loan-book" name="bookid" value="'.$row[0].'">
										<input type="hidden" id="loan-command" name="command" value="loan">
										<button type="submit" class="btn btn-primary">
										Borrow <span class="glyphicon glyphicon-triangle-right"></button></form>';
									}
								}
								echo $button;
								echo '<form action="services/feature.php" method="post">
									<input type="hidden" id="loan-book" name="bookid" value="'.$row[0].'">
									<input type="hidden" id="book-command" name="command" value="toBookPage">
									<button type="submit" class="btn btn-grey">Detail</button></form></p></div>';
							}
						?>
		<br>
   		<div class="line"></div>
   		<br>
   		<footer>
        	<p class="text-grey">- Tugas Akhir PPW / Gibran Muhammad F Wisesa / Ilyas Fahreza -</p>
        <br>
    	</footer>
		</center>
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
</html>