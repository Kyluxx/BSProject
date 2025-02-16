<?php

date_default_timezone_set('Asia/Jakarta');
$conn = new mysqli("127.0.0.1", "root", "", "hotelky");
// $conn = new mysqli("127.0.0.1", "root", "rizky", "hotelky");
//$conn = mysqli_connect("mysql-kyluxx.alwaysdata.net","kyluxx","unbelievableButYeah?","kyluxx_hotel");

if($conn->connect_error) {
  die('err: ' . $conn->connect_error);
}

?>