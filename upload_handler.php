<?php
require 'vendor/autoload.php'; 

use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;


if (!isset($_FILES["doc"]) || $_FILES["doc"]["error"] !== UPLOAD_ERR_OK) {
    die(" فشل في تحميل الملف.");
}

$target_dir = "uploads/";
if (!is_dir($target_dir)) mkdir($target_dir);

$filename = basename($_FILES["doc"]["name"]);
$filename = preg_replace("/[^A-Za-z0-9_\-\.]/", '_', $filename);
$target_file = $target_dir . $filename;

$ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$allowed = ['pdf', 'docx'];
if (!in_array($ext, $allowed)) {
    die(" نوع الملف غير مدعوم.");
}


if ($_FILES["doc"]["size"] > 5 * 1024 * 1024) {
    die(" الملف أكبر من 5MB.");
}


move_uploaded_file($_FILES["doc"]["tmp_name"], $target_file);


$title = "بدون عنوان";
$content = "";

if ($ext === "pdf") {
    
    $parser = new Parser();
    $pdf = $parser->parseFile($target_file);
    $text = $pdf->getText();
    $lines = explode("\n", $text);
    $title = trim($lines[0]);
    $content = $text;

} elseif ($ext === "docx") {
    $phpWord = IOFactory::load($target_file);
    $text = '';

    foreach ($phpWord->getSections() as $section) {
        $elements = $section->getElements();
        foreach ($elements as $element) {
            if ($element instanceof Text) {
                $text .= $element->getText() . "\n";
            } elseif ($element instanceof TextRun) {
                foreach ($element->getElements() as $e) {
                    if ($e instanceof Text) {
                        $text .= $e->getText() . "\n";
                    }
                }
            }
        }
    }

    $lines = explode("\n", $text);
    $title = trim($lines[0]);
    $content = $text;
}

if (empty($content)) {
    $title = pathinfo($target_file, PATHINFO_FILENAME);
    $content = file_get_contents($target_file);
}

$size = filesize($target_file);


$conn = new mysqli("localhost", "root", "", "cloud_db");
$conn->set_charset("utf8mb4");

$stmt = $conn->prepare("INSERT INTO documents (title, filename, content, size) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $title, $target_file, $content, $size);
$stmt->execute();
$stmt->close();
$conn->close();

echo " تم رفع الملف وتخزينه بنجاح";

?>
