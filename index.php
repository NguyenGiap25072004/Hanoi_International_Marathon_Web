<?php include('includes/header1.php'); ?>

<!-- Hero Section -->
<div class="container-fluid p-0 mb-5">
    <div class="position-relative text-center text-white bg-dark" style="background: url('images/bg2.jpg') no-repeat center center/cover; height: 80vh;">
        <div class="position-absolute top-50 start-50 translate-middle w-75" style="background-color: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 10px;">
            <h1 class="display-3 fw-bold" style="color: white;">Welcome to Hanoi Marathon</h1>
            <p class="lead fs-4" style="color: white;">Your journey to an unforgettable marathon starts here!</p>
            <div class="mt-4">
                <a href="participant/register.php" class="btn btn-primary btn-lg px-4 me-3">Join Now</a>
                <a href="login.php" class="btn btn-outline-light btn-lg px-4">Login</a>
            </div>
        </div>
    </div>
</div>



<!-- About Section -->
<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="images/marathon_banner.jpg" alt="Marathon About" class="img-fluid rounded shadow-lg" width="400" height="400">
        </div>
        <div class="col-md-6">
            <h2 class="fw-bold text-primary mb-3">About the Hanoi Marathon</h2>
            <p class="text-muted fs-5">
                The Hanoi Marathon is one of the most exciting events of the year, bringing together runners from around the globe. Experience the vibrant culture of Hanoi while running through its historic landmarks and scenic routes.
            </p>
            <a href="about.php" class="btn btn-outline-primary btn-lg mt-3">Learn More</a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container my-5">
    <h2 class="fw-bold text-center text-secondary mb-4">Why Join Us?</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-lg text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="bi bi-map fs-1 text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold text-secondary">Scenic Routes</h5>
                    <p class="card-text text-muted">Run through Hanoi's most iconic locations, including Hoan Kiem Lake, West Lake, and Long Bien Bridge.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-lg text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="bi bi-people fs-1 text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold text-secondary">Global Community</h5>
                    <p class="card-text text-muted">Join runners from all over the world and make unforgettable memories together.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-lg text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="bi bi-trophy fs-1 text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold text-secondary">Unmatched Experience</h5>
                    <p class="card-text text-muted">Enjoy a well-organized event with water stations, live music, and post-race celebrations.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Call-to-Action Section -->
<div class="container-fluid bg-primary text-white py-5 text-center">
    <h2 class="fw-bold display-5">Ready to Start Your Marathon Journey?</h2>
    <p class="fs-5 mt-3">Register now and become a part of this amazing experience!</p>
    <a href="participant/register.php" class="btn btn-light btn-lg mt-3 px-5">Register Now</a>
</div>

<?php include('includes/footer.php'); ?>
