<?php include('../includes/header2.php'); ?> 
<?php include('../includes/db.php'); ?>
<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<div class="container my-5">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-4">Admin Dashboard</h1>
        <p class="lead">Welcome to the Hanoi Marathon Management System</p>
    </div>

    <!-- Dashboard Options -->
    <div class="row g-4">
        <!-- Create Marathon -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-running fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Create a Marathon</h5>
                    <p class="card-text">Add new marathon events to the system.</p>
                    <a href="create_race.php" class="btn btn-outline-primary btn-block">Create Race</a>
                </div>
            </div>
        </div>

        <!-- Assign Participants -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Assign Participants</h5>
                    <p class="card-text">Assign entry numbers to participants who have registered.</p>
                    <a href="accept_participant.php" class="btn btn-outline-success btn-block">Assign Participants</a>
                </div>
            </div>
        </div>

        <!-- Record Results -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-clipboard-list fa-3x text-danger mb-3"></i>
                    <h5 class="card-title">Record Results</h5>
                    <p class="card-text">Record race results for each participant.</p>
                    <a href="record_results.php" class="btn btn-outline-danger btn-block">Record Results</a>
                </div>
            </div>
        </div>

        <!-- View Data -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-database fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">View Data</h5>
                    <p class="card-text">View and export data for users, participants, and races.</p>
                    <a href="view_data.php" class="btn btn-outline-warning btn-block">View Data</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
