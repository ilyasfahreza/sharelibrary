<?php
	session_start();
	if(!isset($_SESSION['userlogin'])) {
		header("Location: index.php");
	}
	else {
		$temp = explode(" ", $_SESSION['userlogin']);
		$role = $temp[1];
		if($role !== "admin") {
			unset($_SESSION['userlogin']);
			header("Location: index.php");
		}
	}
?>

<html>
	<head>
		<title>ShareLibrary | Admin Dashboard</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="src/css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	</head>
	<body>
		<center>
				<nav class="navbar navbar navbar-fixed" id="thisnav">
			<div class="navbar-header">
      			<a class="navbar-brand" href="admin.php"><img src="src/images/lettermark.png" width="40%"></a>
    		</div>
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
		<div class="home admin">
			<br>
			<br>
			<br>
			<p><img src="src/images/notepad.png" width="7%"></p>
			<h2>ADMIN DASHBOARD</h2>
			<div class="line2"></div>
			<br>
		</div>
		<br>
		<br>
		<p><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#insertBook">
				Click Here to Add Book <span class="glyphicon glyphicon-plus-sign"></span>
		</button></p>
		<div class="modal fade" id="insertBook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<br><p><img src="src/images/addbook.png" width="10%"></p>
						<h4 class="modal-title" id="insertModalLabel">ADD BOOK</h4>
						</div>
						<div class="modal-body">
							<form id="insert-form">
								<div class="form-group">
									<label for="title">Book Title</label>
									<input type="text" class="form-control" id="insert-title" name="title" placeholder="Book Title" required>
								</div><br>
								<div class="form-group">
									<label for="img_path">Cover Book Image-URL</label>
									<input type="text" class="form-control" id="insert-img_path" name="img_path" placeholder="http://something.com/image.jpg">
								</div><br>
								<div class="form-group">
									<label for="publisher">Publisher</label>
									<input type="text" class="form-control" id="insert-publisher" name="publisher" placeholder="Publisher">
								</div><br>
								<div class="form-group">
									<label for="author">Author</label>
									<input type="text" class="form-control" id="insert-author" name="author" placeholder="Author">
								</div><br>
								<div class="form-group">
									<label for="description">Description</label>
									<p><textarea name="description" rows="4" cols="50" id="insert-description" form="insert-form" class="form-control reviewplace" placeholder="Short description about the book"></textarea></p>
								</div><br>
								<div class="form-group">
									<label for="quantity">Quantity</label>
									<input type="number" class="form-control" id="insert-quantity" name="quantity" placeholder="Number of book" min="1" required>
								</div><br>
								<button type="submit" class="btn btn-primary">Submit</button>
								<p class="message"></p>
							</form>
						</div>
					</div>
				</div>
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
										echo "<p class='author'>by $value, and published by ";
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
								echo '</form>
        <form action="services/feature.php" method="post">
         <input type="hidden" id="loan-book" name="bookid" value="'.$row[0].'">
         <input type="hidden" id="book-command" name="command" value="toBookPageAdmin">
         <button type="submit" class="btn btn-grey">Detail</button>
        </form>';
								echo "<br></div>";
							}
						?>
		<br>
		<br>
		<br>
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
		<script type="text/javascript" src="src/js/script.js"></script>
	</body>
</html>