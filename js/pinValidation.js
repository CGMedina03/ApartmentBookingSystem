function validateForm() {
  var otpFields = document.getElementsByClassName("otp-field");
  var otpValue = "";

  // Reset error style
  for (var i = 0; i < otpFields.length; i++) {
    otpFields[i].style.borderColor = "";
  }
  document.getElementById("otp-error").textContent = "";

  // Validate OTP fields
  var expectedDigits = ["1", "2", "3", "4", "5", "6"];
  for (var i = 0; i < otpFields.length; i++) {
    var otpField = otpFields[i];
    var digit = otpField.value.trim();

    // Check if the digit is empty or not a number
    if (digit === "" || isNaN(digit)) {
      otpField.style.borderColor = "red";
      document.getElementById("otp-error").textContent = "Invalid OTP";
      return; // Prevent form submission
    }

    // Check if the digit is correct
    if (digit !== expectedDigits[i]) {
      otpField.style.borderColor = "red";
      document.getElementById("otp-error").textContent = "Invalid OTP";
      return; // Prevent form submission
    }

    otpValue += digit;
  }

  // Store the OTP value in the hidden input field
  document.getElementById("otp").value = otpValue;

  // Submit the form
  document.getElementById("theme-login-otp-").submit();
}

var otpFields = document.getElementsByClassName("otp-field");

// Add event listeners to OTP fields to handle focus and input changes
for (var i = 0; i < otpFields.length; i++) {
  var otpField = otpFields[i];

  otpField.addEventListener("focus", function () {
    this.select();
  });

  otpField.addEventListener("input", function () {
    var nextFieldId = this.getAttribute("data-next");
    var previousFieldId = this.getAttribute("data-previous");
    var nextField = document.getElementById(nextFieldId);
    var previousField = document.getElementById(previousFieldId);

    if (this.value.length === 1) {
      this.blur();

      if (nextField) {
        nextField.focus();
      }
    } else if (this.value.length === 0 && previousField) {
      previousField.focus();
    }
  });
}
