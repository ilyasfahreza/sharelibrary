<?php
 session_start();
?>

<html>
 <head>
  <title>ShareLibrary | Book Detail</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="src/css/style_book.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 </head>
 <body>
  <center>
  <nav class="navbar navbar navbar-fixed">
   <div class="navbar-header">
         <a class="navbar-brand" href="index.php"><img src="src/images/lettermark.png" width="40%"></a>
      </div>
   <ul class="nav navbar-nav navbar-right">
    <li><a href="#" data-toggle="modal" data-target="#insertModal">Click Here to  <span class="glyphicon glyphicon-log-in"></span> <b><b>Login</b></b></a></li>
   </ul>
  </nav>
  <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
     <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <br>
       <p><img src="src/images/entrance.png" width="10%"></p>
       <h4 class="modal-title" id="insertModalLabel">LOGIN</h4>
       <hr>
       <p>Please insert your username and password to continue</p>
       <form id="login-form">
        <br>
          <input id="username" type="text" class="orange form-control" placeholder="Username" autofocus="on" required>
        <br>
          <input id="password" type="password" class="form-control" placeholder="Password" required>
        <br>
        <button type="submit" class="btn btn-primary btn-lg">Login</button>
        <p class="message"></p>
       </form>
      </div>
      <div class="modal-body">
      </div>
     </div>
    </div>
   </div>
  <br>
  <br>
  <br>
  <br>
  <p><img src="src/images/book.png" width="5%"></p>
  <h2>BOOK DETAIL</h2>
  <div class="line2"></div>
  <br>
      <?php
       include 'services/feature.php';
       $books =bookdetail($_SESSION['bookid']);
       $row = mysqli_fetch_row($books);
       foreach($row as $key => $value) {
        if($key === 1) {
									echo "<div class='card'><img class='bitmap' src='$value'><br></div>";
								}
								else if($key === 2) {
									echo "<div class='card_content'><p class='section'>Book Title<p><p class='booktitle'>$value</p><br>";
								}
								else if($key === 3) {
									echo "<p class='section'>Author<p><p class='author'>$value<p><br>";
								}
								else if($key === 4) {
									echo "<p class='section'>Publisher<p><p class='author'>$value</p><br>";
								}
								else if($key === 5) {
									echo "<p class='section'>Description<p><p class='description'>" . str_replace( "\n", '<br />', $value) . "</p>";
								}
								else if($key === 6) {
									echo "<br><p class='quantity'>$value books left</p></div>";
								}
								else if($key === 7) {
									if($value === null) {
										echo "<h4>- NO REVIEW -</h4>";
									}
									else {
									echo "<h4>- BOOK REVIEW -</h4><br><div class='review_container'><p class='headreview'><span>$value</span> reviewed this book</p>";
									}
								}
								else if($key === 8) {
									if($value === null) {
										echo "";
									}
									else {
										echo "<p class='date'>at $value</p><div class='line3'></div><br>";
									}
									
								}
								else if($key === 9) {
									if($value === null) {
										echo "";
									}
									else {
										echo "<p class='reviewcontent'>\"$value\"</p></div><br><br>";
									}
								}

       }
       while($row2 = mysqli_fetch_row($books)) {
        foreach($row2 as $key => $value) {
         if($key === 7) {
									echo "<div class='review_container'><p class='headreview'><span>$value</span> reviewed this book</p>";
								}
								else if($key === 8) {
									echo "<p class='date'>at $value</p><div class='line3'></div><br>";
								}
								else if($key === 9) {
									echo "<p class='reviewcontent'>\"$value\"</p></div>";
								}
        }
       }
      ?>
  <br>
  <br>
  <hr>
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