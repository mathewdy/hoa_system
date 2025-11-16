<?php
$conn = mysqli_connect('localhost', 'root', '', 'hoa_system');
if (!$conn) die("DB Error: " . mysqli_connect_error());
mysqli_set_charset($conn, 'utf8mb4');