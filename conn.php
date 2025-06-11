<?php
$conn = new mysqli(
    "sql107.infinityfree.com",      // MySQL Host Name
    "if0_39205005",                 // MySQL Username
    "hussein8851476",        
    "if0_39205005_cloud_db"         // اسم قاعدة البيانات
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>
