<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Social Services Hub</title>
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
        .about-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 3rem;
            margin: 5rem auto;
            max-width: 800px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5), 0 0 15px rgba(0, 255, 149, 0.3);
            position: relative;
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .about-section h2 {
            color: #00ff95;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 2rem;
            position: relative;
            animation: neonGlow 2s infinite alternate;
        }
        @keyframes neonGlow {
            from { text-shadow: 0 0 5px #00ff95, 0 0 10px #00ff95; }
            to { text-shadow: 0 0 10px #00ff95, 0 0 20px #00ff95, 0 0 30px #00ff95; }
        }
        .about-section p {
            color: #e0e0e0;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        .about-section strong {
            color: #00ff95;
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

    <div class="container mt-5">
        <div class="about-section">
            <h2>About Us</h2>
            <p>We are a dedicated non-profit organization focused on empowering communities through education, health, and sustainable development. Our mission is to create a world where everyone has access to basic needs and opportunities to thrive.</p>
            <p><strong>Vision:</strong> A world where every individual can live with dignity and hope.</p>
            <p><strong>Mission:</strong> To provide resources, support, and opportunities to underprivileged communities through collaborative efforts.</p>
        </div>
    </div>

    <footer class="mt-5">
        <p>© 2025 Social Services Hub. All Rights Reserved.</p>
        <p>Current Time: <?php echo date('h:i A, l, F d, Y'); ?> PKT</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>