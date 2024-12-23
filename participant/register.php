<?php include('../includes/header_login.php'); ?>
<?php include('../includes/db.php'); ?>

<?php
// Hàm kiểm tra chuỗi không dấu
function isNoDiacritics($string) {
    $normalized = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    return $string === $normalized;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Thu thập dữ liệu từ form
    $name = $_POST['name'];
    $nationality = $_POST['nationality'];
    $sex = $_POST['sex'];
    $age = $_POST['age'];
    $passport_no = $_POST['passport_no'];
    $current_address = $_POST['current_address'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];

    // Kiểm tra chuỗi không dấu
    if (!isNoDiacritics($name) || !isNoDiacritics($nationality) || !isNoDiacritics($current_address)) {
        echo "<div class='alert alert-danger text-center'>Please enter all fields without diacritics (e.g., no Vietnamese accents).</div>";
    } else {
        // Kiểm tra email hoặc số điện thoại đã tồn tại
        $stmt = $conn->prepare("SELECT * FROM Users WHERE email = ? OR mobile_number = ?");
        $stmt->bind_param("ss", $email, $mobile_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<div class='alert alert-danger text-center'>Email or mobile number already registered. Please use different details.</div>";
        } else {
            // Insert vào cơ sở dữ liệu
            $stmt = $conn->prepare("INSERT INTO Users (name, nationality, sex, age, passport_no, current_address, email, mobile_number) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssissss", $name, $nationality, $sex, $age, $passport_no, $current_address, $email, $mobile_number);

            if ($stmt->execute()) {
                header("Location: ../login.php");
                exit;
            } else {
                echo "<div class='alert alert-danger text-center'>Error: " . htmlspecialchars($stmt->error) . "</div>";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Marathon Participant Registration</title>
</head>
<body>

<!-- Header Section -->
<div class="container-fluid bg-primary text-white py-5 text-center shadow">
    <h1 class="display-4 fw-bold">Marathon Registration</h1>
    <p class="lead">Join us in this exciting event and challenge your limits!</p>
</div>

<!-- Form Section -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Participant Registration Form</h3>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="register.php">
                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                        </div>

                        <!-- Nationality -->
                        <div class="mb-3">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Enter your nationality" required>
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label for="sex" class="form-label">Gender</label>
                            <select id="sex" name="sex" class="form-select" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Age -->
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" placeholder="Enter your age" required>
                        </div>

                        <!-- Passport Number -->
                        <div class="mb-3">
                            <label for="passport_no" class="form-label">Passport Number</label>
                            <input type="text" class="form-control" id="passport_no" name="passport_no" placeholder="Enter your passport number" required>
                        </div>

                        <!-- Current Address -->
                        <div class="mb-3">
                            <label for="current_address" class="form-label">Current Address</label>
                            <textarea class="form-control" id="current_address" name="current_address" rows="3" placeholder="Enter your address" required></textarea>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <!-- Mobile Number -->
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter your mobile number" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Register Now</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted text-center">
                    <small>Already registered? <a href="../login.php" class="text-primary">Login here</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include('../includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
