<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>About Hanoi Marathon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
        }
        .hero {
            background: url('images/about_hanoi_marathon.jpg') no-repeat center center/cover;
            height: 60vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .section {
            padding: 40px 20px;
        }
        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: #0d6efd;
        }
        .section-content {
            color: #6c757d;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        .footer a {
            color: #0d6efd;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero">
        <h1>About Hanoi Marathon</h1>
    </div>

    <!-- Introduction Section -->
    <div class="container section">
        <h2 class="section-title">What is Hanoi Marathon?</h2>
        <p class="section-content">
            The Hanoi Marathon is one of Vietnam's most anticipated events, attracting thousands of runners from all over the world. 
            Set in the vibrant capital city, this marathon offers a unique blend of scenic routes, historic landmarks, and the energy of Hanoi's dynamic streets.
        </p>
        <p class="section-content">
            Whether you're a seasoned marathoner or a first-time participant, the Hanoi Marathon promises an unforgettable experience. 
            It's not just a race; it's a journey through history, culture, and the spirit of community.
        </p>
    </div>

    <!-- Highlights Section -->
    <div class="container section bg-light rounded shadow">
        <h2 class="section-title">Highlights of the Hanoi Marathon</h2>
        <ul class="section-content">
            <li><strong>Scenic Routes:</strong> Run through Hanoi's iconic landmarks, including Hoan Kiem Lake, West Lake, and the historic Long Bien Bridge.</li>
            <li><strong>Global Community:</strong> Join runners from all over the world and celebrate the spirit of togetherness.</li>
            <li><strong>Unmatched Experience:</strong> Enjoy a well-organized event with hydration stations, live music, and vibrant post-race celebrations.</li>
        </ul>
    </div>

    <!-- Call to Action Section -->
    <div class="container section text-center">
        <h2 class="section-title">Ready to Join?</h2>
        <p class="section-content">
            Don't miss out on this incredible event! Whether you're aiming for a personal best or simply want to enjoy the journey, the Hanoi Marathon is the perfect opportunity.
        </p>
        <a href="participant/register.php" class="btn btn-primary btn-lg">Register Now</a>
        <a href="index.php" class="btn btn-primary btn-lg">Go Back</a>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>&copy; 2024 Hanoi Marathon. All Rights Reserved.</p>
        <p>Visit our <a href="contact.php">Contact Page</a> for more information.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
