<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=database_nienluan', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Không thể kết nối CSDL";
    include_once 'footer.php';
    exit();
}
