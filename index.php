<?php
 session_start();
 if(isset($_SESSION['userlogin'])) {
  $temp = explode(" ", $_SESSION['userlogin']);
  $role = $temp[1];
  if($role === 'admin') {
   header("Location: admin.php");
  }
  else if($role === 'user') {
   header("Location: user.php");
  }
 }
?>

<html>
 <head>
  <title>ShareLibrary | Homepage</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="src/css/style_login.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script>
   $(document).scroll(function()
   {
     if ($(window).scrollTop() > 345) {
          $("nav").addClass('navbar-fixed');
       }
       if ($(window).scrollTop() < 346) {
          $("nav").removeClass('navbar-fixed');
       }
      });
  </script>
 </head>
 <body>
  <center>
  <div class="home index">
   <br>
   <br>
   <p><img src="src/images/logo.png" width="10%"></p>
   <p><img src="src/images/ShareLibrary.png" width="20%"></p>
   <p class="quote">“Open Your Book, Widen Your Knowledge”</p>
   <br>
  </div>
  <nav class="navbar navbar" id="thisnav">
   <div class="navbar-header">
         <a class="navbar-brand" href="#"><img src="src/images/lettermark.png" width="40%"></a>
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
  <p><img src="src/images/bookshelf.png" width="5%"></p>
  <h2>OUR COLLECTION</h2>
  <div class="line2"></div>
  <br>

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
         <input type="hidden" id="book-command" name="command" value="toBookPageIndex">
         <button type="submit" class="btn btn-grey">Detail</button>
        </form>';
        echo "<br></div>";

       }
      ?>
  <br>
  <br>
  <p class="quote2">“Sometimes, you read a book and it fills you with this weird evangelical zeal, and you become convinced that the shattered world will never be put back together unless and until all living humans read the book.”</p>
  <p class="quoter">― John Green, The Fault in Our Stars</p>
  <br>
  <br>
     <div class="line"></div>
     <br>
     <footer>
         <p class="text-grey">-Tugas Akhir PPW / Gibran Muhammad F Wisesa / Ilyas Fahreza -</p>
        <br>
     </footer>
  </center>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script type="text/javascript" src="src/js/script.js"></script>
 </body>
</html>