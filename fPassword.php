<?php
require 'components/navbar.php';
require 'components/retrieve.php';
require 'components/retrieveRenters.php';

// Initialize variables
$error_message = '';
$success_message = '';
$user = null; // Initialize $user variable to null

// Handle form submission for email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    // Get the submitted email
    $email = $_POST['email'];

    // Perform server-side validation (you can add more checks if necessary)
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        // Check if the email exists in the userinfo table using prepared statement
        $query = "SELECT * FROM userinfo WHERE email=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email exists, retrieve user data from the userinfo table
            $user = $result->fetch_assoc();
        } else {
            // If email not found in the userinfo table, check in the rented table
            $query_rented = "SELECT * FROM rented WHERE email=?";
            $stmt_rented = $conn->prepare($query_rented);
            $stmt_rented->bind_param("s", $email);
            $stmt_rented->execute();
            $result_rented = $stmt_rented->get_result();

            if ($result_rented->num_rows > 0) {
                // Email exists, retrieve user data from the rented table
                $user = $result_rented->fetch_assoc();
            } else {
                // Email not found in both tables
                $error_message = "Email not found.";
            }
        }
    }
}

// Handle form submission for updating password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password']) && isset($_POST['confirm_password']) && isset($_POST['email'])) {
    // Get the submitted new passwords and email
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];

    // Additional checks for new password and confirm password
    if (empty($new_password) || empty($confirm_password)) {
        $error_message = "Please enter both the new password and confirm password.";
    } elseif (strlen($new_password) < 12) {
        $error_message = "New password should have at least 12 characters.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "New password and confirm password do not match.";
    } else {
        // Use password_hash() to securely store the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the userinfo table using prepared statement
        $update_query_userinfo = "UPDATE userinfo SET password=?, cPassword=? WHERE email=?";
        $stmt_userinfo = $conn->prepare($update_query_userinfo);
        $stmt_userinfo->bind_param("sss", $hashed_password, $hashed_password, $email);
        $update_result_userinfo = $stmt_userinfo->execute();

        // Update the password in the rented table using prepared statement
        $update_query_rented = "UPDATE rented SET password=?, cPassword=? WHERE email=?";
        $stmt_rented = $conn->prepare($update_query_rented);
        $stmt_rented->bind_param("sss", $hashed_password, $hashed_password, $email);
        $update_result_rented = $stmt_rented->execute();

        // Perform the updates and check if they were successful
        if ($update_result_userinfo && $update_result_rented) {
            // Set the success message
            $successMessage = "Password reset successfully!";

            // Create the URL with the success message parameter
            $redirectUrl = "login.php?successMessage=" . urlencode($successMessage);

            // Use JavaScript to redirect to the login.php page after 3 seconds
            echo "<script>window.location.href = '$redirectUrl';</script>";
            exit; // Stop further processing
        } else {
            $error_message = "Password update failed. Please try again.";
        }
    }
}
?>
<title>Reset Password</title>
<div class="container mt-5 pt-5">
    <h2>Reset your password here</h2>
    <?php
    // Display error message if applicable
    if (!empty($error_message)) {
        echo '<div class="alert alert-danger">' . $error_message . '</div>';
    }
    ?>
    <?php if (isset($user)): // Show password fields if email exists in the database ?>
        <form class="needs-validation" novalidate method="POST">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <div class="form-group">
                <label for="new_password">New Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                    <div class="input-group-append">
                        <span class="input-group-text toggle-password" data-target="new_password">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                </div>
                <div class="invalid-feedback">Please enter your new password.</div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    <div class="input-group-append">
                        <span class="input-group-text toggle-password" data-target="confirm_password">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                </div>
                <div class="invalid-feedback">Please confirm your new password.</div>
            </div>
            <button type="submit" class="btn btn-dark rounded-pill mt-3">Update Password</button>
        </form>
    <?php else: ?>
        <form class="needs-validation" novalidate method="POST">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <button type="submit" class="btn btn-outline-dark mt-3">Submit</button>
        </form>
    <?php endif; ?>
</div>

<script>
    // Toggle password visibility
    const togglePassword = document.querySelectorAll('.toggle-password');

    togglePassword.forEach(function (element) {
        element.addEventListener('click', function () {
            const target = document.getElementById(element.dataset.target);

            if (target.type === 'password') {
                target.type = 'text';
                element.innerHTML = '<i class="fas fa-eye"></i>';
            } else {
                target.type = 'password';
                element.innerHTML = '<i class="fas fa-eye-slash"></i>';
            }
        });
    });
</script>