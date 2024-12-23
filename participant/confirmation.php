<?php include('../includes/header.php'); include('../includes/db.php'); ?>

<?php
// Fetch user details
$user_id = $_GET['user_id'] ?? 1; // Replace with actual user session data
$query = "SELECT * FROM Users WHERE user_id = $user_id";
$user_result = $conn->query($query);
$user = $user_result->fetch_assoc();

// Fetch race participation details
$participation_query = "
    SELECT p.*, r.race_name, r.date 
    FROM Participants p
    JOIN Races r ON p.race_id = r.race_id
    WHERE p.user_id = $user_id";
$participation_result = $conn->query($participation_query);
?>

<h2>User Confirmation</h2>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">User Details</h5>
        <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Nationality:</strong> <?php echo $user['nationality']; ?></p>
    </div>
</div>

<h3>Participation Details</h3>
<?php if ($participation_result->num_rows > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Race Name</th>
                <th>Date</th>
                <th>Entry Number</th>
                <th>Race Bib</th>
                <th>Standings</th>
                <th>Time Record</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $participation_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['race_name']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['entry_number']; ?></td>
                    <td><?php echo $row['race_bib']; ?></td>
                    <td><?php echo $row['standings'] ?? 'Pending'; ?></td>
                    <td><?php echo $row['marathon_time_record'] ?? 'Pending'; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>You have not registered for any races yet.</p>
<?php endif; ?>

<?php include('../includes/footer.php'); ?>
