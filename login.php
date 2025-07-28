<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// CSRF token setup
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$login_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF check
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $login_error = "Invalid request. Please try again.";
    } else {
        // DB config
        $host = 'localhost';
        $db   = 'smart_leave_db';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);

            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $stmt = $pdo->prepare("SELECT * FROM employee WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Successful login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                // ✅ FIX: No output before redirect
                header("Location: dashboard.php");
                exit();
            } else {
                $login_error = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            $login_error = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nixtio - Login Account</title>
    <link rel="stylesheet" href="css/login.css">
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
                    <h2>Welcome Back!</h2>
                    <p class="subtitle">Log in to your account</p>
                <?php if (!empty($login_error)): ?>
    <div style="color: red; text-align: center; margin-bottom: 15px; font-size: 0.9em;">
        <?= htmlspecialchars($login_error) ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['login_success'])): ?>
    <div style="color: green; text-align: center; margin-bottom: 15px; font-size: 0.9em;">
        <?= htmlspecialchars($_SESSION['login_success']) ?>
    </div>
    <?php unset($_SESSION['login_success']); ?>
<?php endif; ?>

<form action="login.php" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
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


                        <div class="form-options">
                            <div class="remember-me">
                                <input type="checkbox" id="rememberMe" name="rememberMe">
                                <label for="rememberMe">Remember me</label>
                            </div>
                            <a href="#" class="forgot-password">Forgot Password?</a>
                        </div>

                        <button type="submit" class="login-btn">Login</button>
                    </form>

                    <p class="signup-link">Don't have an account? <a href="register.php">Sign Up</a></p>
                </div>
            </section>
                        </div>
                    </div>
                </div>
        </main>
    </div>
    
</body>
</html>