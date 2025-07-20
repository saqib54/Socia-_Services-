=<?php
session_start();
$conn = new mysqli("localhost", "root", "", "social_services");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];

    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
    } else {
        $password = password_hash("defaultpass", PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);
        $stmt->execute();
        $user_id = $conn->insert_id;
    }

    $transaction_id = "TXN_" . time();
    $sql = "INSERT INTO donations (user_id, name, email, amount, transaction_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issds", $user_id, $name, $email, $amount, $transaction_id);
    $stmt->execute();

    echo "<script>alert('Donation of PKR $amount recorded! Transaction ID: $transaction_id'); window.location='donate.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate - Social Services Hub</title>
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
        .donation-section {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
            position: relative;
            overflow: hidden;
        }
        .donation-section::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 255, 149, 0.1) 0%, rgba(0, 0, 0, 0) 70%);
            animation: rotate 20s linear infinite;
            z-index: -1;
        }
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .donation-form {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 3rem;
            max-width: 550px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(0, 255, 149, 0.3);
            position: relative;
            z-index: 1;
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .donation-form h3 {
            color: #00ff95;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .form-group i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #00ff95;
            font-size: 1.3rem;
            transition: color 0.3s ease;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(0, 255, 149, 0.2);
            border-radius: 10px;
            padding: 1rem 1rem 1rem 40px;
            color: #e0e0e0;
            font-size: 1rem;
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
        .donate-btn {
            background: linear-gradient(45deg, #00ff95, #00cc66);
            color: #1a1a2e;
            font-family: 'Orbitron', sans-serif;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            padding: 0.9rem;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }
        .donate-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 255, 149, 0.6);
        }
        .donate-btn:active {
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

    <div class="donation-section">
        <div class="donation-form">
            <h3>Make a Donation</h3>
            <form method="POST">
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" class="form-control" placeholder="Enter Your Name" required>
                </div>
                <div class="form-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email" required>
                </div>
                <div class="form-group">
                    <i class="fas fa-money-bill-wave"></i>
                    <input type="number" step="0.01" name="amount" class="form-control" placeholder="Enter Amount (PKR)" required>
                </div>
                <button type="submit" class="btn donate-btn">Donate Now</button>
            </form>
        </div>
    </div>

    <footer>
        <p>© 2025 Social Services Hub. All Rights Reserved.</p>
        <p>Current Time: <?php echo date('h:i A, l, F d, Y'); ?> PKT</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>