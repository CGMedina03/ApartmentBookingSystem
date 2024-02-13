<?php
// Get the selected payment option from the form
$paymentOption = $_POST['paymentOption'];

// Retrieve userId from session
$userId = $_POST['userId'];

// Function to determine redirect page based on payment option
function getRedirectPage($paymentOption)
{
    switch ($paymentOption) {
        case 'gcash':
            return 'ePayment/gcash.php'; // Update with your actual URL
        case 'debitCard':
            return 'debitCreditCard.php'; // Update with your actual URL
        case 'creditCard':
            return 'debitCreditCard.php'; // Update with your actual URL
        default:
            return ''; // Default redirect page
    }
}

// Get the redirect page based on the selected payment option
$redirectPage = getRedirectPage($paymentOption);

// Append userId to the redirect page URL if it's not empty
if (!empty($redirectPage)) {
    $redirectURL = $redirectPage . '?userId=' . $userId;
    header('Location: ' . $redirectURL);
    exit;
} else {
    // Handle invalid payment option
    echo 'Invalid payment option.';
}
?>