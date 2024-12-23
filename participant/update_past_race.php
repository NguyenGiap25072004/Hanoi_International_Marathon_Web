<?php
include('../includes/header.php');
include('../includes/db.php');
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Kiểm tra tham số past_race_id
if (!isset($_GET['past_race_id'])) {
    echo "Invalid Request!";
    exit;
}

$past_race_id = $_GET['past_race_id'];

// Lấy dữ liệu hiện tại
$stmt = $conn->prepare("SELECT race_name, race_date, race_bib, marathon_time_record, standings FROM Past_Races WHERE past_race_id = ? AND user_id = ?");
$stmt->bind_param("ii", $past_race_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "No record found or you do not have permission!";
    exit;
}

$race = $result->fetch_assoc();
$stmt->close();

// Xử lý cập nhật dữ liệu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $race_bib = $_POST['race_bib'];
    $time_record = $_POST['time_record'];
    $standings = $_POST['standings'];

    $update_stmt = $conn->prepare("UPDATE Past_Races SET race_bib = ?, marathon_time_record = ?, standings = ? WHERE past_race_id = ? AND user_id = ?");
    $update_stmt->bind_param("ssiii", $race_bib, $time_record, $standings, $past_race_id, $user_id);

    if ($update_stmt->execute()) {
        echo "<div class='alert alert-success'>Update successful!</div>";
    } else {
        echo "<div class='alert alert-danger'>Update failed. Please try again.</div>";
    }
    $update_stmt->close();
}
?>

<div class="container mt-4">
    <h2>Update Past Marathon Result</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label>Race Bib</label>
            <input type="text" name="race_bib" class="form-control" value="<?php echo htmlspecialchars($race['race_bib']); ?>" required>
        </div>
        <div class="form-group">
            <label>Time Record</label>
            <input type="text" name="time_record" class="form-control" value="<?php echo htmlspecialchars($race['marathon_time_record']); ?>" required>
        </div>
        <div class="form-group">
            <label>Standing</label>
            <input type="number" name="standings" class="form-control" value="<?php echo htmlspecialchars($race['standings']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
