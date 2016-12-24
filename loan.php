<?php
	session_start();
	if(!isset($_SESSION['userlogin'])) {
		header("Location: index.php");
	}
?>

<html>
	<head>
		<title>ShareLibrary | My Books</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="src/css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	</head>
	<body>
		<center>
		<nav class="navbar navbar navbar-fixed" id="thisnav">
			<div class="navbar-header">
      			<a class="navbar-brand" href="user.php"><img src="src/images/lettermark.png" width="40%"></a>
    		</div>
    		<ul class="nav navbar-nav">
				<li><a class="inactive" href="user.php""><b><b>Library</b></b></a></li>
				<li class="active"><a href="#"><b><b>My Books</b></b></a></li>
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
		<div class="home mybooks">
			<br>
			<br>
			<br>
			<p><img src="src/images/rack.png" width="10%"></p>
			<h2>MY BOOKS</h2>
			<div class="line2"></div>
			<br>
		</div>

		<?php
			include "services/feature.php";
			$books = viewLoanBook();
			$row = mysqli_fetch_row($books);
			do {

				if (count($row) === 0) {
							echo "<br><br><br><br><br><p><img src='src/images/loanbook.png' width='5%'></p><p class='booktitle'>There's no book you borrow</p><br><br><br><br><br>";
						}
						else {
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
								echo '<p>
								<form action="services/feature.php" method="post">
									<input type="hidden" id="return-book" name="bookid" value="'.$row[0].'">
									<input type="hidden" id="return-command" name="command" value="return">
									<button type="submit" class="btn btn-danger">Return</button>
								</form>
								<form action="services/feature.php" method="post">
									<input type="hidden" id="loan-book" name="bookid" value="'.$row[0].'">
									<input type="hidden" id="book-command" name="command" value="toBookPage">
									<button type="submit" class="btn btn-grey">Detail</button>
								</form>
								</p>';
								echo "</div>";
							}
						}
			while ($row = mysqli_fetch_row($books));
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