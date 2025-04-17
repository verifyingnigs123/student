<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Log In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container1">
        
    <div class="welcome-section">
        <img src="log1.jpg" alt="Lathougs Univ." class="logo">
        <h1>Welcome to <br> Lathougs University</h1>
    </div>

    <!-- Login Form -->
    <div class="container box" id="signIn">
      <h1 class="form-title">Welcome To Lathoug's University!</h1>
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

        <input type="submit" class="btn" value="Log In" name="submit"> 

      </form>

      <div class="Links">
        <p>Don't have an account?</p>
        <button id="signUpButton">Enroll</button>  
      </div>
    </div>

    <script>
        // Redirect to enroll.php when "Enroll" button is clicked
        document.getElementById("signUpButton").addEventListener("click", function() {
            window.location.href = "Option.php";
        });
    </script>

</body>
</html>