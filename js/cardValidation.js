const validCardNumbers = [
  {
    cardType: "MASTERCARD",
    number: "5123456789012346",
    expiryMonth: "12",
    expiryYear: "2025",
    csc: "111",
    securePassword: "Not enabled",
  },
  {
    cardType: "MASTERCARD",
    number: "5453010000064154",
    expiryMonth: "12",
    expiryYear: "2025",
    csc: "111",
    securePassword: "secbarry1",
  },
  {
    cardType: "VISA",
    number: "4123450131001381",
    expiryMonth: "12",
    expiryYear: "2025",
    csc: "123",
    securePassword: "mctest1",
  },
  {
    cardType: "VISA",
    number: "4123450131001522",
    expiryMonth: "12",
    expiryYear: "2025",
    csc: "123",
    securePassword: "mctest1",
  },
  {
    cardType: "VISA",
    number: "4123450131004443",
    expiryMonth: "12",
    expiryYear: "2025",
    csc: "123",
    securePassword: "mctest1",
  },
  {
    cardType: "VISA",
    number: "4123450131000508",
    expiryMonth: "12",
    expiryYear: "2025",
    csc: "111",
    securePassword: "Not enabled",
  },
];

function validateForm() {
  var cardNameInput = document.getElementById("cname");
  var cardNumberInput = document.getElementById("ccnum");
  var cardTypeDisplay = document.getElementById("cardtype-display");
  var expirationMonthInput = document.getElementById("expmonth");
  var expirationYearInput = document.getElementById("expyear");
  var cvvInput = document.getElementById("cvv");
  var passwordInput = document.getElementById("password");

  var cardName = cardNameInput.value;
  var cardNumber = cardNumberInput.value;
  var expirationMonth = expirationMonthInput.value;
  var expirationYear = expirationYearInput.value;
  var cvv = cvvInput.value;
  var password = passwordInput.value;

  // Clear error messages
  clearError();

  // Validate card name (Title case)
  if (!/^[A-Z][a-z]+(?: [A-Z][a-z]+)*$/.test(cardName)) {
    showError(cardNameInput, "Name should be in Title case.");
    return false;
  }

  // Validate card number (only numbers)
  if (!/^\d+$/.test(cardNumber)) {
    showError(cardNumberInput, "Card number should contain only numbers.");
    return false;
  }

  // Validate expiration month (numbers between 1 and 12)
  if (!/^(0?[1-9]|1[0-2])$/.test(expirationMonth)) {
    showError(expirationMonthInput, "Invalid month.");
    return false;
  }

  // Validate expiration year (2 or 4 digits)
  if (!/^\d{2}(\d{2})?$/.test(expirationYear)) {
    showError(expirationYearInput, "Invalid year.");
    return false;
  }

  // Validate CVV (3 digits)
  if (!/^\d{3}$/.test(cvv)) {
    showError(cvvInput, "Invalid CVV.");
    return false;
  }

  // Check if password is required and validate password
  var validCard = validCardNumbers.find(function (card) {
    return (
      card.number === cardNumber &&
      card.expiryMonth === expirationMonth &&
      card.expiryYear === expirationYear &&
      card.csc === cvv
    );
  });

  if (!validCard) {
    showError(null, "Invalid card account.");
    return false;
  }

  if (validCard.securePassword !== "Not enabled") {
    // Password is enabled, validate the password
    if (password !== validCard.securePassword) {
      showError(passwordInput, "Invalid password.");
      return false;
    }
  } else {
    // Password is not enabled, allow "NA" or empty input
    if (password !== "" && password.toLowerCase() !== "na") {
      showError(passwordInput, "Password is not required.");
      return false;
    }
  }

  // Update the card type display
  cardTypeDisplay.textContent = validCard.cardType;

  return true;
}

function showError(element, message) {
  if (element) {
    var errorElementId = element.id + "-error";
    var errorElement = document.getElementById(errorElementId);
    errorElement.textContent = message;
  } else {
    var generalErrorElement = document.getElementById("general-error");
    generalErrorElement.textContent = message;
  }
}

function clearError() {
  var errorElements = document.getElementsByClassName("error-message");
  for (var i = 0; i < errorElements.length; i++) {
    errorElements[i].textContent = "";
  }
  var generalErrorElement = document.getElementById("general-error");
  generalErrorElement.textContent = "";
}

function updateCardTypeDisplay() {
  var cardNumberInput = document.getElementById("ccnum");
  var cardTypeDisplay = document.getElementById("cardtype-display");
  var cardNumber = cardNumberInput.value;

  var matchedCard = validCardNumbers.find(function (card) {
    return card.number === cardNumber;
  });

  if (matchedCard) {
    cardTypeDisplay.textContent = matchedCard.cardType;
  } else {
    cardTypeDisplay.textContent = "";
  }
}

document.addEventListener("DOMContentLoaded", function () {
  var cardNumberInput = document.getElementById("ccnum");
  cardNumberInput.addEventListener("input", updateCardTypeDisplay);
});

function togglePasswordVisibility() {
  var passwordInput = document.getElementById("password");
  var toggleIcon = document.getElementById("toggle-icon");

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
