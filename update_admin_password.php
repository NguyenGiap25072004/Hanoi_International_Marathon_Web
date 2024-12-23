<?php
include('includes/db.php');

// Mã hóa mật khẩu
$new_password = password_hash('admin123', PASSWORD_DEFAULT);

// Cập nhật mật khẩu cho admin
$stmt = $conn->prepare("UPDATE Admins SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $new_password, $email);
$email = 'admin@hanoimarathon.com';

if ($stmt->execute()) {
    echo "Password updated successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
