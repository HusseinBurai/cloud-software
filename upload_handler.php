<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Upload PDF or Word</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .upload-box {
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .upload-box h2 {
            margin-bottom: 20px;
        }
        .upload-box input[type="file"] {
            margin-bottom: 20px;
        }
        .upload-box input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        .upload-box input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="upload-box">
        <h2>رفع مستند PDF أو Word</h2>
        <form action="upload_handler.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="doc" required><br>
            <input type="submit" value="Upload">
        </form>
    </div>
</body>
</html>
