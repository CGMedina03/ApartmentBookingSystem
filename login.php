<?php
require 'components/connect.php';

// Initialize variables
$emailError = $passwordError = '';
$email = $password = '';
$loginError = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
  // Retrieve the form data
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Validate email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailError = "Invalid email format.";
  }

  // Prepare the login query using prepared statement
  $query = "SELECT id, password, 'userinfo' AS table_name FROM userinfo WHERE email = ?
          UNION
          SELECT id, password, 'rented' AS table_name FROM rented WHERE email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ss", $email, $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Loop through the results to find the correct user
    while ($row = $result->fetch_assoc()) {
      $hashed_password = $row['password'];

      // Verify the user's input password against the hashed password in the database
      if (password_verify($password, $hashed_password)) {
        // Passwords match, user is logged in
        $tableName = $row['table_name']; // Get the table name to identify the user's status
        header("Location: index.php?userId=" . urlencode($row['id']));
        exit; // Stop further execution
      }
    }
  } else {
    // Email not found in the database
    $loginError = "Invalid email or password.";
  }

  // Close the prepared statement
  $stmt->close();

}
require 'components/navbar.php';
?>

<title>Log In</title>
</head>


<div class="container pt-3 pt-lg-5 d-flex justify-content-center align-items-center mt-3 mt-lg-5 ">
  <div class="card shadow-lg bg-body-secondary text-black" style="max-width: 30rem; height: auto">
    <div class="row g-0">
      <div class="col-md-4">
        <img src="assets\raspberry-g45bba1097_1280.jpg"
          class="img-fluid rounded-start object-fit-cover h-100 d-none d-md-block" />
      </div>
      <div class="col-12 col-md-8">
        <div class="card-body">
          <?php
          // Display success message if applicable
          if (isset($success_message)) {
            echo '<div class="alert alert-success"  id="successMessage">' . $success_message . '</div>';
          }
          ?>
          <?php
          // Check if the success message exists in the URL parameters
          if (isset($_GET['successMessage'])) {
            // Retrieve the success message and display it
            $successMessage = $_GET['successMessage'];
            echo '<div class="alert alert-success" role="alert"  id="successMessage">' . htmlspecialchars($successMessage) . '</div>';
          }
          ?>
          <h5 class="card-title text-center p-lg-3">LOG IN</h5>
          <?php if (!empty($loginError)): ?>
            <div class="alert alert-danger">
              <?php echo $loginError; ?>
            </div>
          <?php endif; ?>
          <form action="login.php" method="POST" id="loginForm" novalidate>
            <div class="mb-3">
              <label for="email" class="form-label">Email address:</label>
              <input type="email" class="form-control <?php if (!empty($emailError))
                echo 'is-invalid'; ?>" id="email" name="email" placeholder="joserizal@gmail.com" required
                value="<?php echo htmlspecialchars($email); ?>">
              <div class="invalid-feedback">
                <?php echo $emailError; ?>
              </div>
            </div>
            <div class="mb-3">
              <label for="inputPassword5" class="form-label">Password</label>
              <div class="input-group">
                <input type="password" id="inputPassword" name="password" class="form-control <?php if (!empty($passwordError))
                  echo 'is-invalid'; ?>" aria-labelledby="passwordHelpBlock"
                  value="<?php echo htmlspecialchars($password); ?>">
                <!-- close eye -->
                <span class="input-group-text rounded-end toggle-icon" id="togglePassword"
                  onclick="togglePasswordVisibility()">
                  <i id="toggleIcon" class="fas fa-eye-slash"></i>
                </span>
                <div class="invalid-feedback">
                  <?php echo $passwordError; ?>
                </div>
                <div class="invalid-feedback">
                  <?php echo $passwordError; ?>
                </div>
              </div>
              <div>
                <a href="fPassword.php">Forgot Password?</a>
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn m-3 btn-outline-dark rounded-5">Log in</button>
            </div>
          </form>
          <div class="p-3">
            Doesn't have an account yet? Register
            <a href="create.php">here</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    // Function to hide the success message after 3 seconds
    function hideSuccessMessage() {
      var successMessage = document.getElementById('successMessage');
      if (successMessage) {
        setTimeout(function () {
          successMessage.style.opacity = '0';
          setTimeout(function () {
            successMessage.style.display = 'none';
          }, 1000);
        }, 3000); // 3000 milliseconds (3 seconds)
      }
    }
    // Call the hideSuccessMessage function when the page is loaded
    window.addEventListener('load', hideSuccessMessage);
  </script>
  <script>
    function togglePasswordVisibility() {
      var passwordInput = document.getElementById("inputPassword");
      var toggleIcon = document.getElementById("toggleIcon");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
      } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
      }
    }
  </script>