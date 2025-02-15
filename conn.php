<?php

$conn = new mysqli("127.0.0.1", "root", "rizky", "hotelky");
// $con = mysqli_connect("mysql-kyluxx.alwaysdata.net","kyluxx","unbelievableButYeah?","kyluxx_db");

if($conn->connect_error) {
  die('err: ' . $conn->connect_error);
}

?>