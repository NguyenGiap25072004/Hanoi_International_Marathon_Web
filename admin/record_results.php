<?php
include('../includes/header2.php');
include('../includes/db.php');
session_start();

// Kiểm tra nếu admin chưa đăng nhập
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Xử lý khi admin gửi form nhập kết quả
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $participant_id = $_POST['participant_id'];
    $marathon_time_record = $_POST['marathon_time_record'];
    $standings = $_POST['standings'];

    // Cập nhật kết quả vào bảng Participants
    $stmt = $conn->prepare("UPDATE Participants SET marathon_time_record = ?, standings = ? WHERE participant_id = ?");
    $stmt->bind_param("sii", $marathon_time_record, $standings, $participant_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>🎉 Results recorded successfully!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>❌ Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
?>

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">🏁 Hanoi Marathon - Record Results 🏁</h1>
        <p class="lead text-muted">Record the participants' finishing times and standings for the race.</p>
    </div>

    <!-- Form nhập kết quả -->
    <div class="card shadow-lg mb-5">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">📋 Enter Race Results</h3>
        </div>
        <div class="card-body">
            <form method="post" action="record_results.php">
                <div class="mb-3">
                    <label for="participant_id" class="form-label fw-semibold">Select Participant</label>
                    <select id="participant_id" name="participant_id" class="form-select" required>
                        <option value="" disabled selected>Select a participant</option>
                        <?php
                        // Lấy danh sách tất cả người tham gia từ bảng Participants
                        $result = $conn->query("
                            SELECT p.participant_id, u.name, r.race_name
                            FROM Participants p
                            JOIN Users u ON p.user_id = u.user_id
                            JOIN Races r ON p.race_id = r.race_id
                            WHERE p.marathon_time_record IS NULL
                        ");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['participant_id']}'>
                                    ID: {$row['participant_id']} | {$row['name']} | {$row['race_name']}
                                  </option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="marathon_time_record" class="form-label fw-semibold">Marathon Time (HH:MM:SS)</label>
                    <!-- Sử dụng pattern để ràng buộc định dạng hh:mm:ss -->
                    <input 
                        type="text" 
                        class="form-control" 
                        id="marathon_time_record" 
                        name="marathon_time_record" 
                        placeholder="e.g., 02:15:30" 
                        pattern="^(?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$" 
                        title="Please enter time in hh:mm:ss format (e.g., 02:15:30)" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="standings" class="form-label fw-semibold">Standing (Position)</label>
                    <input type="number" class="form-control" id="standings" name="standings" placeholder="Enter position (e.g., 1 for first place)" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success px-5">Submit Results ✅</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bảng hiển thị kết quả -->
    <div class="card shadow-lg">
        <div class="card-header bg-secondary text-white text-center">
            <h3 class="mb-0">🏆 Recorded Results 🏆</h3>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Participant ID</th>
                        <th>Participant Name</th>
                        <th>Race Name</th>
                        <th>Time Record</th>
                        <th>Standing</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Lấy danh sách người tham gia đã có kết quả
                    $result = $conn->query("
                        SELECT p.participant_id, u.name, r.race_name, p.marathon_time_record, p.standings
                        FROM Participants p
                        JOIN Users u ON p.user_id = u.user_id
                        JOIN Races r ON p.race_id = r.race_id
                        WHERE p.marathon_time_record IS NOT NULL
                    ");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['participant_id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['race_name']}</td>
                                    <td>{$row['marathon_time_record']}</td>
                                    <td>{$row['standings']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-muted text-center'>No results recorded yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
