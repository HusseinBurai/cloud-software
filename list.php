<?php
include("conn.php");

$result = $conn->query("SELECT * FROM documents ORDER BY title ASC");

echo "<!DOCTYPE html>
<html lang='ar'>
<head>
    <meta charset='UTF-8'>
    <style>
        body {
            direction: rtl;
            text-align: right;
            font-family: Arial, sans-serif;
        }
        ul {
            list-style-type: disc;
        }
        a {
            text-decoration: none;
            color: blue;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>";

echo "<h2>المستندات المرتبة حسب العنوان</h2>";
echo "<ul>";

while ($row = $result->fetch_assoc()) {
    $title = htmlspecialchars($row['title']);
    $file = $row['filename'];
    $size_kb = round($row['size'] / 1024, 2);
    $category = $row['category'] ?: "غير مصنف";

    echo "<li>
            <a href='$file' target='_blank'>$title</a> 
            ( $size_kb KB) - <b>تصنيف:</b> $category
          </li>";
}

echo "</ul>
</body>
</html>";
?>
