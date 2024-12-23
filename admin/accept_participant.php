<?php include('../includes/header2.php'); ?>
<?php include('../includes/db.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Thu thập dữ liệu từ form
    $participant_id = $_POST['participant_id'];
    $entry_number = $_POST['entry_number'];
    $race_bib = $_POST['race_bib'];

    // Kiểm tra định dạng Race Bib bằng regex (ví dụ: HN2024-001)
    if (!preg_match("/^HN\d{4}-\d{3}$/", $race_bib)) {
        echo "<div class='alert alert-danger text-center'>Invalid Race Bib format. Example: HN2024-001</div>";
    } else {
        // Lấy race_id dựa trên participant_id
        $race_query = $conn->prepare("SELECT race_id FROM Participants WHERE participant_id = ?");
        $race_query->bind_param("i", $participant_id);
        $race_query->execute();
        $race_result = $race_query->get_result();

        if ($race_result->num_rows > 0) {
            $race_row = $race_result->fetch_assoc();
            $race_id = $race_row['race_id'];

            // Kiểm tra trùng lặp Entry Number và Race Bib trong cùng cuộc thi
            $check_stmt = $conn->prepare("
                SELECT * FROM Participants 
                WHERE race_id = ? AND (entry_number = ? OR race_bib = ?)
            ");
            $check_stmt->bind_param("iis", $race_id, $entry_number, $race_bib);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                echo "<div class='alert alert-danger text-center'>Error: Entry Number or Race Bib already exists for this race.</div>";
            } else {
                // Cập nhật entry_number và race_bib vào bảng Participants
                $update_stmt = $conn->prepare("UPDATE Participants SET entry_number = ?, race_bib = ? WHERE participant_id = ?");
                $update_stmt->bind_param("isi", $entry_number, $race_bib, $participant_id);

                if ($update_stmt->execute()) {
                    echo "<div class='alert alert-success text-center'>Entry number and race bib successfully assigned to the participant!</div>";
                } else {
                    echo "<div class='alert alert-danger text-center'>Error: " . $update_stmt->error . "</div>";
                }
                $update_stmt->close();
            }
            $check_stmt->close();
        } else {
            echo "<div class='alert alert-danger text-center'>Error: Participant not found.</div>";
        }
        $race_query->close();
    }
}
?>

<div class="container my-5">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-4">Assign Entry Numbers and Race Bibs</h1>
        <p class="lead">Easily manage race details for participants</p>
    </div>

    <!-- Form Assign Entry Number -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <form method="post" action="accept_participant.php">
                        <div class="mb-3">
                            <label for="participant_id" class="form-label">Select Participant</label>
                            <select id="participant_id" name="participant_id" class="form-select" required>
                                <option value="" disabled selected>Select a participant</option>
                                <?php
                                $query = "
                                    SELECT p.participant_id, u.name, r.race_name
                                    FROM Participants p
                                    INNER JOIN Users u ON p.user_id = u.user_id
                                    INNER JOIN Races r ON p.race_id = r.race_id
                                    WHERE p.entry_number IS NULL
                                    ORDER BY p.participant_id ASC
                                ";
                                $result = $conn->query($query);

                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='{$row['participant_id']}'>
                                                ID: {$row['participant_id']} | Name: {$row['name']} | Race: {$row['race_name']}
                                              </option>";
                                    }
                                } else {
                                    echo "<option disabled>No participants available for assignment</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="entry_number" class="form-label">Entry Number</label>
                            <input type="number" class="form-control" id="entry_number" name="entry_number" placeholder="Enter a unique entry number" required>
                        </div>
                        <div class="mb-3">
                            <label for="race_bib" class="form-label">Race Bib</label>
                            <input type="text" class="form-control" id="race_bib" name="race_bib" placeholder="Enter race bib (e.g., HN2024-001)" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Assign Entry Number and Race Bib</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Existing Assignments Table -->
    <div class="mt-5">
        <h3 class="text-center mb-4">Participants with Assigned Entry Numbers</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Participant ID</th>
                        <th>Name</th>
                        <th>Race</th>
                        <th>Entry Number</th>
                        <th>Race Bib</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "
                        SELECT p.participant_id, u.name, r.race_name, p.entry_number, p.race_bib
                        FROM Participants p
                        INNER JOIN Users u ON p.user_id = u.user_id
                        INNER JOIN Races r ON p.race_id = r.race_id
                        WHERE p.entry_number IS NOT NULL
                        ORDER BY p.participant_id ASC
                    ";
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['participant_id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['race_name']}</td>
                                    <td>{$row['entry_number']}</td>
                                    <td>{$row['race_bib']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No participants have been assigned entry numbers yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
