<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'localhost';
    $db   = 'smart_leave_db';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        // Password match check
        if ($password !== $confirmPassword) {
            $error = "Passwords do not match.";
        } else {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM employee WHERE email = ?");
            $stmt->execute([$email]);
            $emailExists = $stmt->fetchColumn();

            if ($emailExists) {
                $error = "Email already registered. Please use a different one or log in.";
            } else {
                // Hash password and insert
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO employee (name, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $hashedPassword]);

                // Redirect to login
                header("Location: login.php");
                exit();
            }
        }

    } catch (PDOException $e) {
        $error = "Database Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nixtio - Register Account</title>
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <header class="navbar">
            <div class="nav-left">
                <span class="logo">SMART LEAVE</span>
                <span class="status">Leave Application Automated</span>
            </div>
            <div class="nav-right">
                <span class="nav-icon"><i class="far fa-bookmark"></i></span>
                <span class="nav-icon"><i class="far fa-heart"></i></span>
                <span class="nav-icon"><i class="fas fa-link"></i></span>
            </div>
        </header>

        <main class="content-area">
            <section class="left-panel">
                <div class="form-card">
                    <h2>Create an account</h2>

                    <form action="register.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">

                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                          <input type="text" id="name" name="name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email">
                        </div>

                        <div class="form-group password-group">
                            <label for="password">Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="password" name="password" required>
                                <span class="password-toggle" id="passwordToggle">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group password-group">
                            <label for="confirmPassword">Confirm Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="confirmPassword" name="confirmPassword" required>
                                <span class="password-toggle" id="confirmPasswordToggle">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="register-btn">Register</button>
                    </form>
                </div>
            </section>
            <?php if (!empty($error)): ?>
    <div class="error-message" style="color: red; margin-bottom: 1rem;">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordField = document.getElementById('password');
            const passwordToggle = document.getElementById('passwordToggle');
            const confirmPasswordField = document.getElementById('confirmPassword');
            const confirmPasswordToggle = document.getElementById('confirmPasswordToggle');

            function setupPasswordToggle(field, toggle) {
                toggle.addEventListener('click', function () {
                    const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
                    field.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('fa-eye');
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }

            setupPasswordToggle(passwordField, passwordToggle);
            setupPasswordToggle(confirmPasswordField, confirmPasswordToggle);
        });
    </script>

</body>
</html>