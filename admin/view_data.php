<?php include('../includes/header2.php'); ?>
<?php include('../includes/db.php'); ?>

<?php
session_start();

// Kiểm tra nếu admin chưa đăng nhập
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Hàm xuất dữ liệu ra file CSV
if (isset($_GET['export']) && isset($_GET['table'])) {
    $table = $_GET['table'];
    $filename = $table . "_data_" . date('Ymd') . ".csv";

    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=$filename");

    $output = fopen("php://output", "w");

    // Lấy cột và dữ liệu từ bảng
    $result = $conn->query("SELECT * FROM $table");
    if ($result) {
        $columns = array_keys($result->fetch_assoc());
        fputcsv($output, $columns); // Ghi tên cột vào file CSV
        $result->data_seek(0); // Đặt lại con trỏ để ghi dữ liệu
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }
    fclose($output);
    exit;
}
?>

<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="display-6 text-primary">View and Export Data</h2>
        <p class="text-muted">Manage and export data from the Hanoi Marathon database.</p>
    </div>

    <!-- Users Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Users Table</h5>
            <a href="view_data.php?export=true&table=Users" class="btn btn-light btn-sm">Export Users Table</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Nationality</th>
                            <th>Sex</th>
                            <th>Age</th>
                            <th>Passport No</th>
                            <th>Current Address</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT user_id, name, nationality, sex, age, passport_no, current_address, email, mobile_number FROM Users");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['user_id']}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['nationality']}</td>
                                        <td>{$row['sex']}</td>
                                        <td>{$row['age']}</td>
                                        <td>{$row['passport_no']}</td>
                                        <td>{$row['current_address']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['mobile_number']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>No data found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Races Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Races Table</h5>
            <a href="view_data.php?export=true&table=Races" class="btn btn-light btn-sm">Export Races Table</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Race ID</th>
                            <th>Race Name</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM Races");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['race_id']}</td>
                                        <td>{$row['race_name']}</td>
                                        <td>{$row['date']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>No data found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Past Participant Results -->
    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Past Participant Results</h5>
            <a href="view_data.php?export=true&table=Past_Races" class="btn btn-light btn-sm">Export Past Results</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Past Race ID</th>
                            <th>User ID</th>
                            <th>Race Name</th>
                            <th>Race Date</th>
                            <th>Race Bib</th>
                            <th>Marathon Time Record</th>
                            <th>Standing</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM Past_Races");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['past_race_id']}</td>
                                        <td>{$row['user_id']}</td>
                                        <td>{$row['race_name']}</td>
                                        <td>{$row['race_date']}</td>
                                        <td>{$row['race_bib']}</td>
                                        <td>{$row['marathon_time_record']}</td>
                                        <td>{$row['standings']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>No data found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Participants Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Participants Table</h5>
            <a href="view_data.php?export=true&table=Participants" class="btn btn-light btn-sm">Export Participants Table</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Participant ID</th>
                            <th>User ID</th>
                            <th>Race ID</th>
                            <th>Hotel Name</th>
                            <th>Entry Number</th>
                            <th>Race Bib</th>
                            <th>Time Record</th>
                            <th>Standing</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT participant_id, user_id, race_id, hotel_name, entry_number, race_bib, marathon_time_record, standings FROM Participants");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['participant_id']}</td>
                                        <td>{$row['user_id']}</td>
                                        <td>{$row['race_id']}</td>
                                        <td>" . htmlspecialchars($row['hotel_name'] ?? 'Not Provided') . "</td>
                                        <td>{$row['entry_number']}</td>
                                        <td>{$row['race_bib']}</td>
                                        <td>{$row['marathon_time_record']}</td>
                                        <td>{$row['standings']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No data found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
