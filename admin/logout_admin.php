<?php
session_start();
session_destroy();

echo "<script>alert('Logout Sukses')</script>";

header('location: login_admin.php');
