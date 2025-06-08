<?php
$start_time = microtime(true); 

$conn = new mysqli("localhost", "root", "", "cloud_db");
$conn->set_charset("utf8");

$result = $conn->query("SELECT COUNT(*) as total_files, SUM(size) as total_size FROM documents");
$data = $result->fetch_assoc();

$total_files = $data['total_files'];
$total_size_kb = round($data['total_size'] / 1024, 2);

$end_time = microtime(true);
$execution_time = round($end_time - $start_time, 4); 
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إحصائيات المستندات</title>
    <style>
        body {
            direction: rtl;
            text-align: right;
            font-family: Arial, sans-serif;
        }
        ul {
            list-style-type: disc;
        }
        li {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h2>إحصائيات المستندات</h2>
    <ul>
        <li>عدد المستندات: <b><?php echo $total_files; ?></b></li>
        <li>الحجم الكلي: <b><?php echo $total_size_kb; ?> KB</b></li>
        <li>الزمن المستغرق في التنفيذ: <b><?php echo $execution_time; ?> ثانية</b></li>
    </ul>
</body>
</html>
