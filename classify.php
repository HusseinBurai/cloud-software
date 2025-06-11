<?php
include("conn.php"); 

$categories = [
    "تعليم" => ["education", "student", "school", "university", "teacher"],
    "صحة" => ["health", "doctor", "hospital", "medicine", "clinic"],
    "اقتصاد" => ["economy", "money", "finance", "market", "business"],
    "تكنولوجيا" => ["computer", "software", "internet", "technology", "AI"]
];

$result = $conn->query("SELECT id, content FROM documents");

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $text = strtolower($row['content']); 

    $max_matches = 0;
    $best_category = "غير مصنف";

    foreach ($categories as $category => $keywords) {
        $match_count = 0;
        foreach ($keywords as $word) {
            $match_count += substr_count($text, strtolower($word));
        }

        if ($match_count > $max_matches) {
            $max_matches = $match_count;
            $best_category = $category;
        }
    }

    $stmt = $conn->prepare("UPDATE documents SET category = ? WHERE id = ?");
    $stmt->bind_param("si", $best_category, $id);
    $stmt->execute();
    $stmt->close(); 
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تصنيف المستندات</title>
    <style>
        body {
            direction: rtl;
            text-align: center;
            font-family: Arial, sans-serif;
            margin-top: 50px;
        }
        .message {
            font-size: 20px;
            color: green;
        }
    </style>
</head>
<body>
    <div class="message">تم تصنيف جميع المستندات تلقائيًا بنجاح.</div>
</body>
</html>
