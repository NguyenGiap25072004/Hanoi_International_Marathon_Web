<?php include('../includes/header2.php'); ?> 
<?php include('../includes/db.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $race_name = $_POST['race_name'];
    $date = $_POST['date'];

    // Insert into Races table
    $stmt = $conn->prepare("INSERT INTO Races (race_name, date) VALUES (?, ?)");
    $stmt->bind_param("ss", $race_name, $date);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Race created successfully!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
?>

<div class="container my-5">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-4">Create a New Marathon</h1>
        <p class="lead">Add a new race to the Hanoi Marathon system</p>
    </div>

    <!-- Race Creation Form -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <form method="post" action="create_race.php">
                        <div class="mb-3">
                            <label for="race_name" class="form-label">Race Name</label>
                            <input type="text" class="form-control" id="race_name" name="race_name" placeholder="Enter race name" required>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Create Race</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Existing Races -->
    <div class="mt-5">
        <h3 class="text-center mb-4">Existing Races</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Race Name</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch and display existing races
                    $result = $conn->query("SELECT * FROM Races ORDER BY date ASC");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['race_id']}</td>
                                <td>{$row['race_name']}</td>
                                <td>{$row['date']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
