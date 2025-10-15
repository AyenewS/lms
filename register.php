
<?php
include 'includes/header.php';

// Include database configuration
include 'config/db_config.php';

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $firstname = trim($_POST["firstname"]);
    $lastname  = trim($_POST["lastname"]);
    $email     = trim($_POST["email"]);
    $password  = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $gender    = $_POST["gender"];
    $dob       = $_POST["dob"];
    
    // Validate required fields
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password) || empty($gender) || empty($dob)) {
        die("All fields are required.");
    }

    // Check password match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }
    
    // Check if email already exists
    $check_email = "SELECT sid FROM students WHERE email = ?";
    $stmt = $conn->prepare($check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        die("Email already exists. Please use a different email.");
    }
    $stmt->close();
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare and bind
    $sql = "INSERT INTO students (firstname, lastname, email, password, gender, dob) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstname, $lastname, $email, $hashed_password, $gender, $dob);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Registration Successful</title>
            <link rel='stylesheet' href='assets/css/styles.css'>
        </head>
        <body>
            <div class='container'>
                <div class='form-container' style='text-align: center;'>
                    <h2 style='color: #2ecc71;'>Registration Successful!</h2>
                    <p>Your account has been created successfully.</p>
                    <a href='login.html' class='btn btn-primary'>Login Now</a>
                </div>
            </div>
        </body>
        </html>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();

} else {
    // Display the registration form when accessed via GET request
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body>
        <!-- Registration Form -->
        <div class="container">
            <div class="form-container">
                <h2 class="form-title">Create Student Account</h2>
                <form id="registrationForm" action="register.php" method="POST">
                    
                    <!-- First Name & Last Name -->
                    <div class="form-row firstname-lastname">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" id="firstname" name="firstname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" id="lastname" name="lastname" class="form-control" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <!-- Password & Confirm Password -->
                    <div class="form-row password-confirm">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                        </div>
                    </div>

                    <!-- Gender & Date of Birth -->
                    <div class="form-row gender-dob">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="" disabled selected>Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob" class="form-control" required>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
                    </div>

                    <!-- Footer Link -->
                    <div class="form-footer">
                        <p>Already have an account? <a href="login.html">Login here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </body>
    </html>
    <?php
}
include 'includes/footer.php';
?>
