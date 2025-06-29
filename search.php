<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>بحث في المستندات</title>
    <style>
        body {
            direction: rtl;
            text-align: right;
            font-family: Arial, sans-serif;
        }
        input[type="text"] {
            width: 300px;
            padding: 5px;
        }
        input[type="submit"] {
            padding: 5px 10px;
        }
        mark {
            background-color: yellow;
        }
        hr {
            border: 1px solid #ccc;
        }
        a {
            color: blue;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>🔍 البحث داخل المستندات</h2>

    <form method="GET">
        <input type="text" name="q" placeholder="أدخل كلمة البحث" required>
        <input type="submit" value="بحث">
    </form>

    <?php
    include("conn.php");  

    if (isset($_GET['q'])) {
        $q = trim($_GET['q']);
        $q_lower = strtolower($q);

        $result = $conn->query("SELECT * FROM documents");

        echo "<h3>نتائج البحث عن: <mark>" . htmlspecialchars($q) . "</mark></h3>";

        $found = false;

        while ($row = $result->fetch_assoc()) {
            $text = strtolower($row['content']);

            if (strpos($text, $q_lower) !== false) {
                $found = true;

                $preview = substr($row['content'], 0, 1000);
                $highlighted = preg_replace("/(" . preg_quote($q, '/') . ")/i", "<mark>$1</mark>", $preview);

                echo "<div style='margin-bottom:20px;'>";
                echo "<h4><a href='" . $row['filename'] . "' target='_blank'>" . htmlspecialchars($row['title']) . "</a></h4>";
                echo "<p>$highlighted... <a href='" . $row['filename'] . "' target='_blank'>فتح الملف</a></p>";
                echo "</div><hr>";
            }
        }

        if (!$found) {
            echo "<p>لم يتم العثور على أي مستند يحتوي على هذه الكلمة.</p>";
        }

        $conn->close();
    }
    ?>
</body>
</html>
