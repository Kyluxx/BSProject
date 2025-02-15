<?php

if (function_exists('password_hash')) {
    echo "password_hash() tersedia!";
} else {
    echo "password_hash() tidak tersedia!";
}

phpinfo();
?>
