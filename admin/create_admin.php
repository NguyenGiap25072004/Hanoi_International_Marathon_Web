<?php
include('includes/db.php');

// Mã hóa mật khẩu
$email = 'admin@hanoimarathon.com';
$password = password_hash('admin123', PASSWORD_DEFAULT);

// Thêm admin vào cơ sở dữ liệu
$stmt = $conn->prepare("INSERT INTO Admins (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $password);

if ($stmt->execute()) {
    echo "Admin account created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
