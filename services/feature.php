<?php
 if (session_status() == PHP_SESSION_NONE) {
     session_start();
 }
 function connectDB() {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "tugas2";
  
  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  
  // Check connection
  if (!$conn) {
   die("Connection failed: " + mysqli_connect_error());
  }
  return $conn;
 }

 function checkBorrowBook($bookid) {
  $conn = connectDB();
  $temp = explode(" ", $_SESSION['userlogin']);
  $user_id = $temp[0];
  $sql = "SELECT * FROM `loan` WHERE user_id='$user_id' and book_id='$bookid'";
  $res = $conn->query($sql);
  if($res->num_rows > 0) {
   return true;
  }
  else {
   return false;
  }
 }

 function checkBook($title) {
  $conn = connectDB();
  $temp = explode(" ", $_SESSION['userlogin']);
  $user_id = $temp[0];
  $sql = "SELECT * FROM `book` WHERE title='$title'";
  $res = $conn->query($sql);
  if($res->num_rows > 0) {
   return true;
  }
  else {
   return false;
  }
 }

 function viewLoanBook() {
  $conn = connectDB();
  $temp = explode(" ", $_SESSION['userlogin']);
  $user_id = $temp[0];
  $sql = "SELECT book.book_id, book.img_path, book.title, book.author, book.publisher, book.description, book.quantity FROM `book` inner join `loan` on book.book_id=loan.book_id WHERE loan.user_id='$user_id'";
  if(!$result = mysqli_query($conn, $sql)) {
   die("Error: $sql");
  }
  mysqli_close($conn);
  return $result;

 }

 function login() {
  $conn = connectDB();
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = 'SELECT * FROM `user` WHERE password=\'' . $password . '\' AND username=\'' . $username . '\''; 
  $res = $conn->query($sql);

  if($res->num_rows > 0) {
   $row = $res->fetch_assoc();
   $_SESSION['userlogin'] = $row['user_id'] . " " . $row['role'] . " " . $username;
   $role = "";

   if($row['role'] === 'admin') {
    $role = 'admin';
   }
   else {
    $role = 'user';
   }

   $status = "{\"status\":\"sukses\", \"role\":\"" . $role . "\"}";
   return $status;
  }
  else {
   unset($_SESSION['userlogin']);
   $status = "{\"status\":\"gagal\"}";
   return $status;
  }
 }

 function selectAllFromTable($table) {
  $conn = connectDB();
  
  $sql = "SELECT * FROM $table";
  
  if(!$result = mysqli_query($conn, $sql)) {
   die("Error: $sql");
  }
  mysqli_close($conn);
  return $result;
 }

 function review($bookid, $review) {
  $conn = connectDB();
  $temp = explode(" ", $_SESSION['userlogin']);
  $user_id = $temp[0];
  $date = date("Y-m-d");
  $sql = "INSERT INTO `review`(`book_id`, `user_id`, `date`, `content`) VALUES ('$bookid', '$user_id', '$date',\"". $review ."\")";
  if($result = mysqli_query($conn, $sql)) {
   return "{\"status\":\"sukses\"}";
  }
  else {
   die("Error: $sql");
  }
  mysqli_close($conn);
 }

 function editReview($bookid, $review) {
  $conn = connectDB();
  $temp = explode(" ", $_SESSION['userlogin']);
  $user_id = $temp[0];
  $date = date("Y-m-d");
  $sql = "UPDATE `review` set `content`=\"". $review ."\", `date`='$date' WHERE book_id='$bookid' and user_id='$user_id'";
  if($result = mysqli_query($conn, $sql)) {
   return "{\"status\":\"sukses\"}";
  }
  else {
   die("Error: $sql");
  }
  mysqli_close($conn);
 }

 function bookDetail($bookid) {
  $conn = connectDB();
  
  $sql = "SELECT book.book_id, book.img_path, book.title, book.author, book.publisher, book.description, book.quantity, user.username, review.date, review.content FROM `review` right join `book` on book.book_id=review.book_id left join user on review.user_id=user.user_id where book.book_id='$bookid'";
   # code...
  
  if(!$result = mysqli_query($conn, $sql)) {
   die("Error: $sql");
  }
  mysqli_close($conn);
  return $result;
 }

 function logout() {
  unset($_SESSION['userlogin']);
  header("Location: ../index.php");
 }

 function addBook($img_path, $title, $author, $publisher, $description, $quantity) {
 	$conn = connectDB();
  if(checkBook($title)) {   
  	$sql = "UPDATE `book` SET quantity=quantity+$quantity WHERE title='$title'";
   if($result = mysqli_query($conn, $sql)) {
    $sql = "SELECT * FROM `book` WHERE title='$title'";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    $_SESSION['bookid'] = $row['book_id'];
    return "{\"status\":\"sukses\"}";
   } 
   else {
    die("Error: $sql");
   }
   mysqli_close($conn);
   }
  else {
   if(preg_match('/^(http|https):\/\/\S+[.][a-zA-Z]+$/', $img_path)) {
    $sql = "INSERT INTO `book`(`img_path`, `title`, `author`, `publisher`, `description`, `quantity`) VALUES ('$img_path',\"" . $title . "\",\"" . $author . "\",\"" . $publisher . "\", \"" . $description . "\",'$quantity')";
    if($result = mysqli_query($conn, $sql)) {
      $sql = "SELECT * FROM `book` WHERE title='$title'";
      $res = $conn->query($sql);
      $row = $res->fetch_assoc();
      $_SESSION['bookid'] = $row['book_id'];
     return "{\"status\":\"sukses\"}";
    }
    else {
     die("Error: $sql");
    }
    mysqli_close($conn);
   }
   else {
    return "{\"status\":\"gagal\"}";
   }
  }
 }

 function loan($bookid) {
  $conn = connectDB();
  $temp = explode(" ", $_SESSION['userlogin']);
  $user_id = $temp[0];
  $sql = "INSERT INTO `loan`(`book_id`, `user_id`) VALUES ('$bookid','$user_id')";
  $result = mysqli_query($conn, $sql);
  $sql = "UPDATE book SET quantity=quantity-1 WHERE book_id='$bookid'";
  if($result = mysqli_query($conn, $sql)) {
   header("Location: ../loan.php");
  } 
  else {
   die("Error: $sql");
  }
  mysqli_close($conn);
 }

 function returnBook($bookid) {
  $conn = connectDB();
  $temp = explode(" ", $_SESSION['userlogin']);
  $user_id = $temp[0];
  $sql = "DELETE FROM `loan` WHERE book_id='$bookid' and user_id='$user_id'"; 
  $result = mysqli_query($conn, $sql);
  $sql = "UPDATE book SET quantity=quantity+1 WHERE book_id='$bookid'";
  if($result = mysqli_query($conn, $sql)) {
   header("Location: ../loan.php");
  } 
  else {
   die("Error: $sql");
  }
  mysqli_close($conn);
 }

 function toBookPage($bookid) {
  $_SESSION['bookid'] = $bookid;
  header("Location: ../book.php");
 }

 function toBookPageIndex($bookid) {
  $_SESSION['bookid'] = $bookid;
  header("Location: ../book_index.php");
 }

 function toBookPageAdmin($bookid) {
  $_SESSION['bookid'] = $bookid;
  header("Location: ../book_admin.php");
 }
 
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if($_POST['command'] === 'login') {
   echo login();
  } 
  else if($_POST['command'] === 'logout') {
   logout();
  }
  else if($_POST['command'] === 'loan') {
   loan($_POST['bookid']);
  }
  else if($_POST['command'] === 'return') {
   returnBook($_POST['bookid']);
  }
  else if($_POST['command'] === 'add') {
   echo addBook($_REQUEST['img_path'], $_REQUEST['title'], $_REQUEST['author'], $_REQUEST['publisher'], $_REQUEST['description'], $_REQUEST['quantity']);
  }
  else if($_POST['command'] === 'review') {
   echo review($_REQUEST['bookid'], $_REQUEST['review']);
  }
  else if($_POST['command'] === 'toBookPage') {
   toBookPage($_POST['bookid']);
  }
  else if($_POST['command'] === 'editReview') {
   echo editReview($_REQUEST['bookid'], $_REQUEST['review']);
  }
  else if($_POST['command'] === 'toBookPageIndex') {
   toBookPageIndex($_POST['bookid']);
  }
  else if($_POST['command'] === 'toBookPageAdmin') {
   toBookPageAdmin($_POST['bookid']);
  }
 }