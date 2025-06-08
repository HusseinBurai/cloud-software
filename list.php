<?php

$conn = new mysqli("localhost", "root", "", "cloud_db");
$conn->set_charset("utf8");


$result = $conn->query("SELECT * FROM documents ORDER BY title ASC");

echo "<h2> المستندات المرتبة حسب العنوان</h2>";
echo "<ul>";

while ($row = $result->fetch_assoc()) {
    $title = htmlspecialchars($row['title']);
    $file = $row['filename'];
    $size_kb = round($row['size'] / 1024, 2);
    $category = $row['category'] ?: "غير مصنف";

    echo "<li>
            <a href='$file' target='_blank'>$title</a> 
            ( $size_kb KB) -  <b>تصنيف:</b> $category
          </li>";
}

echo "</ul>";
?>
