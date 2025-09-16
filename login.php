<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Account</title>
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

<form id="login-form" method="POST">
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
        </main>
    </div>
</body>
</html>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("login-form");

  loginForm.addEventListener("submit", async (e) => {
    e.preventDefault(); // stop refresh

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;

    try {
      const res = await fetch("http://127.0.0.1:8000/api/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json"
        },
        body: JSON.stringify({ email, password })
      });

      const data = await res.json();
      console.log("API response:", data);

      if (!res.ok || !data.token) {
        throw new Error(data.message || "Login failed");
      }

      // ✅ Save login session in sessionStorage
      sessionStorage.setItem("user_id", data.user.id);
      sessionStorage.setItem("user_name", data.user.name);
      sessionStorage.setItem("user_role", data.user.role);
      sessionStorage.setItem("api_token", data.token);

      // ✅ Debug check
      console.log("Stored in sessionStorage:", {
        id: sessionStorage.getItem("user_id"),
        name: sessionStorage.getItem("user_name"),
        role: sessionStorage.getItem("user_role"),
        token: sessionStorage.getItem("api_token")
      });

      // ✅ Redirect
      if (data.user.role === "employee") {
        window.location.href = "dashboard.php";
      } else if (data.user.role === "manager") {
        window.location.href = "manager_dashboard.php";
      } else {
        window.location.href = "index.html";
      }
    } catch (err) {
      alert(err.message);
    }
  });
});
</script>

