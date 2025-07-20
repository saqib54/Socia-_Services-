<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hardcoded credentials check
    if ($email === "admin@gmail.com" && $password === "1234") {
        $_SESSION['user_id'] = 1; // Dummy user ID
        $_SESSION['role'] = 'admin'; // Set role as admin
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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
        .login-container {
            position: relative;
            z-index: 1;
        }
        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5), 0 0 15px rgba(0, 255, 149, 0.3);
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .card-title {
            color: #00ff95;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1.5rem;
            position: relative;
            animation: neonGlow 2s infinite alternate;
        }
        @keyframes neonGlow {
            from { text-shadow: 0 0 5px #00ff95, 0 0 10px #00ff95; }
            to { text-shadow: 0 0 10px #00ff95, 0 0 20px #00ff95, 0 0 30px #00ff95; }
        }
        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 8px;
            padding: 0.75rem;
            text-align: center;
            margin-bottom: 1rem;
        }
        .form-label {
            color: #e0e0e0;
            font-weight: 500;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(0, 255, 149, 0.2);
            border-radius: 10px;
            color: #e0e0e0;
            padding: 0.75rem 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }
        .form-control:focus {
            border-color: #00ff95;
            box-shadow: 0 0 15px rgba(0, 255, 149, 0.5);
            background: rgba(255, 255, 255, 0.15);
            outline: none;
        }
        .form-control::placeholder {
            color: rgba(224, 224, 224, 0.7);
        }
        .btn-primary {
            background: linear-gradient(45deg, #00ff95, #00cc66);
            border: none;
            color: #1a1a2e;
            font-family: 'Orbitron', sans-serif;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 10px;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 255, 149, 0.6);
        }
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(0, 255, 149, 0.4);
        }
        footer {
            background: #1a1a2e;
            color: #e0e0e0;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
            font-family: 'Orbitron', sans-serif;
            font-size: 0.9rem;
            position: fixed;
            bottom: 0;
            width: 100%;
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card login-container">
                    <h3 class="card-title">Login</h3>
                    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5">
        <p>© 2025 Social Services Hub. All Rights Reserved.</p>
        <p>Current Time: <?php echo date('h:i A, l, F d, Y'); ?> PKT</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>