function validateForm() {
  var mobileNumber = document.getElementById("identityValue").value;
  var password = document.getElementById("password").value;

  // Reset error messages and styles
  document.getElementById("identity-error-text").textContent = "";
  document.getElementById("password-error-text").textContent = "";
  document.getElementById("identityValue").style.borderColor = "";
  document.getElementById("password").style.borderColor = "";

  // Validate credentials
  if (
    mobileNumber.trim() !== "09193890579" ||
    password.trim() !== "Password@1"
  ) {
    document.getElementById("identityValue").style.borderColor = "red";
    document.getElementById("password").style.borderColor = "red";
    document.getElementById("identity-error-text").textContent =
      "Invalid credentials.";
    document.getElementById("password-error-text").textContent =
      "Invalid credentials.";
    return; // Prevent form submission
  }

  document.getElementById("login-form").submit(); // Submit the form
}
