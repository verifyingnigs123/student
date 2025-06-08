<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register & Log In</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="style.css">

  <!-- Google Sign-In -->
<meta name="google-signin-client_id" content="268643386697-364udp9bfc4mafis94kd74ctp23iraqm.apps.googleusercontent.com">

  <script src="https://accounts.google.com/gsi/client" async defer></script>
  <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/build/jwt-decode.min.js"></script>
</head>
<body>
  <div class="container1">
    <div class="welcome-section">
      <img src="log1.jpg" alt="Lathougs Univ." class="logo">
      <h1>Welcome to <br> Lathoug's University</h1>
    </div>

    <!-- Login Form -->
    <div class="container box" id="signIn">
      <h1 class="form-title">Lathoug's University!</h1>
      <form method="post" action="login.php">
        <div class="input-group">
          <i class="fas fa-id-card"></i>
          <input type="text" name="studentID" id="studentIDLogin" placeholder="Username" required>
          <label for="studentIDLogin">Username</label>
        </div>

        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" id="passwordLogin" placeholder="Password" required>
          <label for="passwordLogin">Password</label>
        </div>

        <div class="forgot-password">
          <a href="forgot_password.php" id="ForgotPasswordButton">Forgot Password?</a>
        </div>

        <input type="submit" class="btn" value="Log In" name="submit">
      </form>



      <div class="Links">
        <p>Don't have an account?</p>
        <div class="link-buttons">
          <button id="signUpButton">Enroll</button>
        </div>
      </div>
            <!-- Google Sign-In -->
      <div style="text-align:center; margin: 20px 0;">
        <div id="g_id_onload"
             data-client_id="268643386697-364udp9bfc4mafis94kd74ctp23iraqm.apps.googleusercontent.com"
             data-callback="handleCredentialResponse"
             data-auto_prompt="false">
        </div>

        <div class="g_id_signin"
             data-type="icon"
             data-shape="pill"
             data-theme="outline"
             data-text="sign_in_with"
             data-size="large"
             data-logo_alignment="left">
        </div>
      </div>

      <footer style="text-align: center; padding: 2px 0; background-color: #f8f9fa; color: #555; font-size: 14px; margin-top: 5px;">
        <p>&copy; 2025 Lathoug's University. All rights reserved.</p>
      </footer>
    </div>
  </div>

  <script>
    // Enroll and Forgot Password Redirects
    document.getElementById("signUpButton").addEventListener("click", function () {
      window.location.href = "loading.php?redirect=enroll.php";
    });

    document.getElementById("ForgotPasswordButton").addEventListener("click", function (e) {
      e.preventDefault();
      window.location.href = "loading.php?redirect=forgot_password.php";
    });

    // Google Sign-In Handler
    function handleCredentialResponse(response) {
      const data = jwt_decode(response.credential);

      fetch('google_login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          email: data.email
        })
      })
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success') {
          window.location.href = res.redirect;
        } else {
          alert("Unauthorized Google account.");
        }
      })
      .catch(error => {
        console.error("Login error:", error);
      });
    }
  </script>
</body>
</html>
