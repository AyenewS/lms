<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Portal</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar">
                <img src="assets/img/logo.png" alt="Abyssinia Tech Center" width="150" height="120">
                <ul class="nav-links">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php" class="btn btn-outline">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container dashboard">
        <div class="welcome-card">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['firstname']); ?>!</h2>
            <p>You have successfully logged into your student account.</p>
            
            <div class="user-info">
                <div class="info-item">
                    <div class="info-label">Student ID</div>
                    <div><?php echo $_SESSION['user_id']; ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Full Name</div>
                    <div><?php echo htmlspecialchars($_SESSION['firstname'] . ' ' . $_SESSION['lastname']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div><?php echo htmlspecialchars($_SESSION['email']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Account Status</div>
                    <div>Active</div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-content">
                <a href="dashboard.php" class="logo" style="color: white; margin-bottom: 5px;">AbyssiniaTechCenter</a>
                <ul class="footer-links">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Settings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                <p class="copyright">&copy; 2025 Abyssinia Tech Center. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>