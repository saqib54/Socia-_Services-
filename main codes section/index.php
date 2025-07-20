<?php
session_start();
$conn = new mysqli("localhost", "root", "", "social_services");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$donation_count = $conn->query("SELECT COUNT(*) as total FROM donations")->fetch_assoc()['total'];
$volunteer_count = $conn->query("SELECT COUNT(*) as total FROM volunteers")->fetch_assoc()['total'];
$event_count = $conn->query("SELECT COUNT(*) as total FROM events")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Services Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@300;500&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #e0e0e0;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://www.transparenttextures.com/patterns/digital-art.png');
            opacity: 0.05;
            z-index: -1;
        }
        .navbar-custom {
            background: rgba(46, 125, 50, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        .navbar-custom a {
            color: #e0e0e0 !important;
            font-family: 'Orbitron', sans-serif;
            font-weight: 500;
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }
        .navbar-custom a:hover {
            color: #00ff95 !important;
            text-shadow: 0 0 10px #00ff95, 0 0 20px #00ff95;
        }
        .hero-section {
            background: url('https://images.unsplash.com/photo-1506784365486-67783e105499?auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            color: #e0e0e0;
            padding: 6rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            animation: pulse 8s infinite;
        }
        @keyframes pulse {
            0% { opacity: 0.6; }
            50% { opacity: 0.8; }
            100% { opacity: 0.6; }
        }
        .hero-section h1, .hero-section p {
            position: relative;
            z-index: 1;
            font-family: 'Orbitron', sans-serif;
        }
        .hero-section h1 {
            color: #00ff95;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 3rem;
        }
        .hero-section p {
            font-size: 1.2rem;
            color: #e0e0e0;
        }
        .hero-section .btn {
            background: linear-gradient(45deg, #00ff95, #00cc66);
            border: none;
            padding: 0.75rem 1.5rem;
            font-family: 'Orbitron', sans-serif;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }
        .hero-section .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 255, 149, 0.6);
        }
        .stats-section {
            background: rgba(26, 26, 46, 0.9);
            backdrop-filter: blur(5px);
            padding: 4rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .stats-section::before {
            content: '';
            position: absolute;
            top: -20%;
            left: -20%;
            width: 140%;
            height: 140%;
            background: radial-gradient(circle, rgba(0, 255, 149, 0.1) 0%, rgba(0, 0, 0, 0) 70%);
            animation: rotate 20s linear infinite;
            z-index: -1;
        }
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .stat-number {
            font-size: 2.8rem;
            color: #00ff95;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }
        .stat-number:hover {
            color: #00cc66;
            text-shadow: 0 0 10px #00ff95;
        }
        .stats-section p {
            color: #e0e0e0;
            font-size: 1.1rem;
            font-weight: 500;
        }
        footer {
            background: #1a1a2e;
            color: #e0e0e0;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
            font-family: 'Orbitron', sans-serif;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="index.php">Social Services Hub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="donate.php">Donate</a></li>
                    <li class="nav-item"><a class="nav-link" href="volunteer.php">Volunteer</a></li>
                    <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $_SESSION['role'] == 'admin' ? 'admin.php' : 'profile.php'; ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <h1>Empowering Communities with Care</h1>
        <p>Join us in making a difference today!</p>
        <a href="donate.php" class="btn btn-lg mt-3">Donate Now</a>
    </div>

    <div class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="stat-number" id="donationCounter"><?php echo $donation_count; ?></h3>
                    <p>Donations Made</p>
                </div>
                <div class="col-md-4">
                    <h3 class="stat-number" id="volunteerCounter"><?php echo $volunteer_count; ?></h3>
                    <p>Volunteers Joined</p>
                </div>
                <div class="col-md-4">
                    <h3 class="stat-number" id="eventCounter"><?php echo $event_count; ?></h3>
                    <p>Events Organized</p>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>© 2025 Social Services Hub. All Rights Reserved.</p>
        <p>Current Time: <?php echo date('h:i A, l, F d, Y'); ?> PKT</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animated counter for stats
        function animateCounter(id, end) {
            let start = 0;
            let duration = 2000;
            let increment = end / (duration / 50);
            let counter = setInterval(() => {
                start += increment;
                if (start >= end) {
                    start = end;
                    clearInterval(counter);
                }
                document.getElementById(id).textContent = Math.round(start);
            }, 50);
        }

        animateCounter('donationCounter', <?php echo $donation_count; ?>);
        animateCounter('volunteerCounter', <?php echo $volunteer_count; ?>);
        animateCounter('eventCounter', <?php echo $event_count; ?>);
    </script>
</body>
</html>

<?php $conn->close(); ?>