<?php include('includes/header_login.php'); ?>
<?php include('includes/db.php'); ?>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $identifier = $_POST['identifier']; // Password (Admin) hoặc Số điện thoại (Participant)
    $role = $_POST['role'];

    if ($role === 'admin') {
        // Đăng nhập cho admin
        $stmt = $conn->prepare("SELECT * FROM Admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            // Kiểm tra mật khẩu
            if ($identifier === $admin['password']) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['role'] = 'admin';
                header("Location: admin/index.php");
                exit;
            } else {
                $error = "Invalid password. Please try again.";
            }
        } else {
            $error = "No admin found with that email.";
        }
    } else {
        // Đăng nhập cho participants
        $stmt = $conn->prepare("SELECT * FROM Users WHERE email = ? AND mobile_number = ?");
        $stmt->bind_param("ss", $email, $identifier);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $participant = $result->fetch_assoc();
            $_SESSION['user_id'] = $participant['user_id'];
            $_SESSION['role'] = 'participant';
            header("Location: participant/index.php");
            exit;
        } else {
            $error = "Invalid email or mobile number. Please try again.";
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login - Marathon Website</title>
</head>
<body>

<!-- Header Section -->
<div class="container-fluid bg-primary text-white py-4 text-center shadow">
    <h1 class="display-5 fw-bold">Marathon Login</h1>
    <p class="lead">Access your account and join the excitement!</p>
</div>

<!-- Login Form -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-10">
            <div class="card shadow-lg border-0 rounded">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Login</h3>
                </div>
                <div class="card-body p-4">
                    <!-- Error Message -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form method="post" action="login.php">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <!-- Password or Mobile Number -->
                        <div class="mb-3">
                            <label for="identifier" class="form-label">Password (Admin) or Mobile Number (Participant)</label>
                            <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Enter your password or mobile number" required>
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" name="role" class="form-select" required>
                                <option value="participant">Participant</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="card-footer text-muted text-center">
                    <small>Not registered yet? <a href="participant/register.php" class="text-primary">Register here</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
