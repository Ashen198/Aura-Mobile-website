<?php
header('Content-Type: application/json');

// 1. Database Connection Configuration
$servername = "localhost";
$username = "root";       
$password = "";           
$dbname = "aura_mobile";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// 2. Retrieve Text Form Data
$pname  = $_POST['pname'] ?? '';
$pprice = $_POST['pprice'] ?? '';
$pstock = $_POST['pstock'] ?? '';
$pdesc  = $_POST['pdesc'] ?? '';

// 3. Handle File Upload
$pimagePath = "";
if (isset($_FILES['pimage']) && $_FILES['pimage']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['pimage']['tmp_name'];
    $fileName = $_FILES['pimage']['name'];
    
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = time() . '_' . uniqid() . '.' . $fileExtension;

    // Matches the updated folder name exactly
    $uploadFileDir = './uploads/';
    
    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }
    
    $dest_path = $uploadFileDir . $newFileName;

    if(move_uploaded_file($fileTmpPath, $dest_path)) {
        $pimagePath = $dest_path; 
    } else {
        echo json_encode(["status" => "error", "message" => "Error moving the uploaded file to directory."]);
        exit();
    }
} else {
    echo json_encode(["status" => "error", "message" => "Image upload missing or errored."]);
    exit();
}

// 4. Insert data using Prepared Statements
$sql = "INSERT INTO product_tb (pname, pprice, pstock, pdesc, pimage) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssss", $pname, $pprice, $pstock, $pdesc, $pimagePath);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Product Added Successfully to MySQL!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database execution failure: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Failed to prepare SQL query: " . $conn->error]);
}

$conn->close();
?>