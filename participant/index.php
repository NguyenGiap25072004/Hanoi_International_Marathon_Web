<?php include('../includes/header.php'); ?>
<?php include('../includes/db.php'); ?>

<?php
session_start();

// Kiểm tra nếu người tham gia chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Lấy thông tin người tham gia từ cơ sở dữ liệu
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM Users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="display-5">Participant Dashboard</h2>
        <p class="lead">Welcome to your personalized marathon dashboard!</p>
    </div>

    <div class="alert alert-info text-center" role="alert">
        <h4 class="alert-heading">Hello, <?php echo htmlspecialchars($user['name']); ?>!</h4>
        <p>Manage your marathon activities, track your results, and explore the race map.</p>
    </div>

    <!-- Thông tin cá nhân -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5>Your Personal Information</h5>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Nationality:</strong> <?php echo htmlspecialchars($user['nationality']); ?></p>
            <p><strong>Sex:</strong> <?php echo htmlspecialchars($user['sex']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
            <p><strong>Passport Number:</strong> <?php echo htmlspecialchars($user['passport_no']); ?></p>
            <p><strong>Current Address:</strong> <?php echo htmlspecialchars($user['current_address']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($user['mobile_number']); ?></p>
        </div>
    </div>

    <!-- Kết quả các cuộc đua trước đây -->
    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white">
            <h5>Your Past Marathon Results</h5>
        </div>
        <div class="card-body">
            <?php
            $stmt = $conn->prepare("
                SELECT past_race_id, race_name, race_date, race_bib, marathon_time_record, standings
                FROM Past_Races
                WHERE user_id = ?
            ");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<div class='table-responsive'>
                        <table class='table table-hover'>
                            <thead class='thead-light'>
                                <tr>
                                    <th>Race Name</th>
                                    <th>Date</th>
                                    <th>Race Bib</th>
                                    <th>Time Record</th>
                                    <th>Standing</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['race_name']) . "</td>
                            <td>" . htmlspecialchars($row['race_date']) . "</td>
                            <td>" . htmlspecialchars($row['race_bib']) . "</td>
                            <td>" . htmlspecialchars($row['marathon_time_record']) . "</td>
                            <td>" . htmlspecialchars($row['standings']) . "</td>
                            <td>
                                <a href='update_past_race.php?past_race_id=" . $row['past_race_id'] . "' class='btn btn-warning btn-sm'>Update</a>
                            </td>
                          </tr>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "<p class='text-muted'>No past marathon results available.</p>";
            }
            $stmt->close();
            ?>
        </div>
    </div>

    <!-- Đăng ký tham gia -->
    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white">
            <h5>Your Race Registrations</h5>
        </div>
        <div class="card-body">
            <?php
            $stmt = $conn->prepare("
                SELECT r.race_name, r.date, p.entry_number, p.race_bib
                FROM Participants p
                JOIN Races r ON p.race_id = r.race_id
                WHERE p.user_id = ?
            ");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<div class='table-responsive'>
                        <table class='table table-hover'>
                            <thead class='thead-light'>
                                <tr>
                                    <th>Race Name</th>
                                    <th>Date</th>
                                    <th>Entry Number</th>
                                    <th>Race Bib</th>
                                </tr>
                            </thead>
                            <tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['race_name']) . "</td>
                            <td>" . htmlspecialchars($row['date']) . "</td>
                            <td>" . htmlspecialchars($row['entry_number'] ?? 'Pending') . "</td>
                            <td>" . htmlspecialchars($row['race_bib'] ?? 'Pending') . "</td>
                          </tr>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "<p class='text-muted'>You have not registered for any races yet. <a href='race_registration.php'>Register for a race now</a>.</p>";
            }
            $stmt->close();
            ?>
        </div>
    </div>

    <!-- Kết quả cuộc thi -->
    <div class="card shadow mb-4">
        <div class="card-header bg-danger text-white">
            <h5>Your Race Results</h5>
        </div>
        <div class="card-body">
            <?php
            $stmt = $conn->prepare("
                SELECT r.race_name, r.date, p.marathon_time_record, p.standings
                FROM Participants p
                JOIN Races r ON p.race_id = r.race_id
                WHERE p.user_id = ? AND p.marathon_time_record IS NOT NULL AND p.standings IS NOT NULL
            ");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<div class='table-responsive'>
                        <table class='table table-hover'>
                            <thead class='thead-light'>
                                <tr>
                                    <th>Race Name</th>
                                    <th>Date</th>
                                    <th>Time Record</th>
                                    <th>Standing</th>
                                </tr>
                            </thead>
                            <tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['race_name']) . "</td>
                            <td>" . htmlspecialchars($row['date']) . "</td>
                            <td>" . htmlspecialchars($row['marathon_time_record']) . "</td>
                            <td>" . htmlspecialchars($row['standings']) . "</td>
                          </tr>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "<p class='text-muted'>No race results available yet. Please check back later.</p>";
            }
            $stmt->close();
            ?>
        </div>
    </div>

    <!-- Bản đồ -->
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h5>Explore the Marathon Map</h5>
        </div>
        <div class="card-body text-center">
            <p>Click the button below to explore the race map and detailed stages of the marathon.</p>
            <a href="race_map.php" class="btn btn-primary">View Race Map</a>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
