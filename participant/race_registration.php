<?php include('../includes/header.php'); ?>
<?php include('../includes/db.php'); ?>

<?php
session_start();

// Kiểm tra user đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $race_id = $_POST['race_id'];
    $hotel_name = $_POST['hotel_name'];
    $race_name = $_POST['race_name'];
    $race_date = $_POST['race_date'];
    $race_bib = $_POST['race_bib'];
    $time_record = $_POST['time_record'];
    $standings = $_POST['standings'];

    $check_stmt = $conn->prepare("SELECT * FROM Participants WHERE user_id = ? AND race_id = ?");
    $check_stmt->bind_param("ii", $user_id, $race_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $message = "<div class='alert alert-warning'>You have already registered for this marathon. Please choose a different race.</div>";
    } else {
        $insert_stmt = $conn->prepare("INSERT INTO Participants (user_id, race_id, hotel_name) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("iis", $user_id, $race_id, $hotel_name);

        if ($insert_stmt->execute()) {
            $past_race_stmt = $conn->prepare("INSERT INTO Past_Races (user_id, race_name, race_date, race_bib, marathon_time_record, standings) 
                                             VALUES (?, ?, ?, ?, ?, ?)");
            $past_race_stmt->bind_param("issssi", $user_id, $race_name, $race_date, $race_bib, $time_record, $standings);

            if ($past_race_stmt->execute()) {
                $message = "<div class='alert alert-success'>You have successfully registered for the marathon and added past race details!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Error saving past race details: " . $past_race_stmt->error . "</div>";
            }
            $past_race_stmt->close();
        } else {
            $message = "<div class='alert alert-danger'>Error registering for the marathon: " . $insert_stmt->error . "</div>";
        }

        $insert_stmt->close();
    }

    $check_stmt->close();
}
?>

<div class="container mt-5">
    <!-- Title -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">Marathon Registration</h1>
        <p class="lead">Register for your next marathon and keep track of your past race details!</p>
    </div>

    <!-- Alerts -->
    <?php if (isset($message)) echo $message; ?>

    <!-- Registration Form -->
    <div class="card shadow-lg mb-5">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Register for a Marathon</h4>
        </div>
        <div class="card-body">
            <form method="post" action="race_registration.php">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="race_id" class="form-label">Select a Marathon</label>
                        <select id="race_id" name="race_id" class="form-select" required>
                            <option value="" disabled selected>Select a race</option>
                            <?php
                            $result = $conn->query("SELECT * FROM Races ORDER BY date ASC");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['race_id']}'>{$row['race_name']} ({$row['date']})</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="hotel_name" class="form-label">Hotel Name</label>
                        <input type="text" class="form-control" id="hotel_name" name="hotel_name" placeholder="e.g., Marathon Hotel" required>
                    </div>
                </div>

                <h5 class="mt-4 mb-3 text-primary">Past Race Details</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="race_name" class="form-label">Past Race Name</label>
                        <input type="text" class="form-control" id="race_name" name="race_name" placeholder="e.g., Hanoi Marathon">
                    </div>
                    <div class="col-md-6">
                        <label for="race_date" class="form-label">Past Race Date</label>
                        <!-- Chỉ cho phép nhập ngày không vượt quá ngày hiện tại -->
                        <input 
                            type="date" 
                            class="form-control" 
                            id="race_date" 
                            name="race_date" 
                            max="<?php echo date('Y-m-d'); ?>" 
                            required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="race_bib" class="form-label">Race Bib</label>
                        <input type="text" class="form-control" id="race_bib" name="race_bib" placeholder="e.g., MAR2024-001">
                    </div>
                    <div class="col-md-4">
                        <label for="time_record" class="form-label">Time Record (hh:mm:ss)</label>
                        <!-- Ràng buộc định dạng hh:mm:ss -->
                        <input 
                            type="text" 
                            class="form-control" 
                            id="time_record" 
                            name="time_record" 
                            placeholder="e.g., 02:15:30" 
                            pattern="^(?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$" 
                            title="Please enter time in hh:mm:ss format (e.g., 02:15:30)" 
                            required>
                    </div>
                    <div class="col-md-4">
                        <label for="standings" class="form-label">Standing</label>
                        <input type="number" class="form-control" id="standings" name="standings" placeholder="e.g., 5">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Register Now</button>
            </form>
        </div>
    </div>

    <!-- User Registrations Table -->
    <h3 class="text-center text-primary mb-4">Your Marathon Registrations</h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Race Name</th>
                    <th>Date</th>
                    <th>Entry Number</th>
                    <th>Hotel Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $registrations_query = "
                    SELECT r.race_name, r.date, p.entry_number, p.hotel_name
                    FROM Participants p
                    JOIN Races r ON p.race_id = r.race_id
                    WHERE p.user_id = ?
                ";
                $stmt = $conn->prepare($registrations_query);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $registrations = $stmt->get_result();

                if ($registrations->num_rows > 0) {
                    while ($row = $registrations->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['race_name']}</td>
                                <td>{$row['date']}</td>
                                <td>" . ($row['entry_number'] ? $row['entry_number'] : 'Pending') . "</td>
                                <td>" . htmlspecialchars($row['hotel_name'] ?? 'Not Provided') . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No registrations yet.</td></tr>";
                }
                $stmt->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
