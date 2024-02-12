<?php
session_start();
require 'components/retrieve.php';
require 'components/retrieveRenters.php';
require 'components/layout.php';
require 'components/retrieveRooms.php';

// Extract userId from the current URL parameters
$_SESSION['userId'] = isset($_GET['userId']) ? $_GET['userId'] : '';

// Debugging: Print userId to check if it's stored in the session
echo "User ID stored in session: " . $_SESSION['userId'];

// Check if the current user is a renter and get the rented title
$isRenter = false;
$title = "";
if (!empty($rented)) {
  foreach ($rented as $renter) {
    if ($renter['email'] == $email) {
      $isRenter = true;
      $advancePayment = $renter['advancePayment'];
      $title = $renter['title']; // Get the title from the rented item
      break;
    }
  }
}
// Fetch room data based on the rented title
$room = null; // Initialize as null
if ($isRenter && isset($title) && !empty($rented)) {
  // Create a query to retrieve room information based on the rented title
  $query = "SELECT * FROM rooms WHERE title = '$title'";

  // Execute the query
  $result = mysqli_query($conn, $query);

  // Check if the query was successful
  if ($result) {
    // Fetch the data from the result set and store it in the $room array
    $room = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
  } else {
    echo "Error executing the query: " . mysqli_error($conn);
  }
}
$daysRemaining = "0";
// Check if $renter is not null before accessing its elements
if ($isRenter && isset($title) && !empty($renter)) {
  // Calculate the due date one month from the dateMoved
  $dateMoved = strtotime($renter['dateMoved']);
  $dueDate = date('M d, Y', strtotime('+1 month', $dateMoved));

  // Calculate the number of days remaining until the due date
  $currentDate = time(); // Current timestamp
  $dueDateTimestamp = strtotime($dueDate);
  $daysRemaining = floor(($dueDateTimestamp - $currentDate) / (60 * 60 * 24));

  // Check if the due date has passed and update the advancePayment
  if ($daysRemaining <= 0) {
    // Add a check for $room to avoid accessing it if it's null
    if (!empty($room)) {
      $advancePayment = $room['price'];
      // Update the advancePayment in the rented table
      $updateQuery = "UPDATE rented SET advancePayment = '$advancePayment' WHERE title = '$title'";
      $updateResult = mysqli_query($conn, $updateQuery);
      if (!$updateResult) {
        echo "Error updating the advancePayment: " . mysqli_error($conn);
      }

      // Show the toast notification if advance payment is all used up
      if ($advancePayment <= 0) {
        echo "<script>$(document).ready(function(){ $('#paymentToast').toast('show'); });</script>";
      }
    }
  }
}

// Check if the form is submitted
if (isset($_POST['proceedButton'])) {
  // Extract userId from the current URL parameters
  $_SESSION['userId'] = isset($_GET['userId']) ? $_GET['userId'] : '';
  // Get the selected payment option
  $selectedPaymentOption = isset($_POST['paymentOption']) ? $_POST['paymentOption'] : '';

  // Determine the redirect page based on the selected payment option
  $redirectPage = '';
  switch ($selectedPaymentOption) {
    case 'gcash':
      $redirectPage = 'ePayment/gcash.php';
      break;
    case 'debitCard':
    case 'creditCard':
      $redirectPage = 'debitCreditCard.php';
      break;
    default:
      // Default redirect page if no valid option is selected
      $redirectPage = 'defaultRedirect.php';
      break;
  }
  echo $redirectUrl;
  // Redirect to the determined page with the userId from the session
  // Append userId as a query parameter to the redirectPage URL
  $redirectUrl = $redirectPage . '?userId=' . $_SESSION['userId'];
  header("Location: $redirectUrl");
  exit(); // Stop further execution
}
?>
<style>
  .danger-counter,
  small {
    color: red;
  }
</style>
<title>Profile Account</title>
</head>

<body class="text-black bg-body-secondary mt-5 pt-5">
  <?php require 'components/navbar.php'; ?>
  <div class="container-md">

    <?php
    // Check if there is a success message in the session
    if (isset($_SESSION['successMessage'])) {
      $successMessage = $_SESSION['successMessage'];
      unset($_SESSION['successMessage']); // Clear the session variable to show the message only once
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>' . $successMessage . ' </strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
    ?>
    <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 5">
      <div id="paymentToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
          <strong class="me-auto">Payment Due</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          Your advance payment balance is all used up. Please make the payment to avoid service disruption.
        </div>
      </div>
    </div>
    <div class="row row-cols-1 row-cols-md-3 d-flex justify-content-center align-items-center">
      <!-- Card on the left -->
      <?php if ($isRenter && isset($room)): ?>
        <div class="col d-flex flex-column align-items-center p-3 text-center vh-25 ">
          <div class="card bg-dark text-white shadow-lg" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Rent Payment</h5>
              <p class="card-text">
              <h3>Due Date</h3>
              <span class="text-white">
                <?php echo $dueDate; ?>
              </span>
              <p>
                <?php echo $room['price']; ?>/month
              </p>
              </p>
              <div class="card-footer card-text">
                <?php if ($daysRemaining == 1): ?>
                  <h5 class="danger-counter">
                    1 day remaining
                  </h5>
                <?php elseif ($daysRemaining <= 5): ?>
                  <h5 class="danger-counter">
                    <?php echo $daysRemaining; ?> days remaining
                  </h5>
                <?php else: ?>
                  <h5>
                    <?php echo $daysRemaining; ?> days remaining
                  </h5>
                <?php endif; ?>
                <?php if ($advancePayment <= 0): ?>
                  <small>0 advance payment balance
                  </small>
                <?php else: ?>
                  <p>Available payment: <strong>
                      <?php echo $advancePayment; ?>
                    </strong></p>
                <?php endif; ?>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-light rounded-pill" data-bs-toggle="modal" data-bs-target="#modal">
                  Payment
                </button>
                <!-- Modal -->
                <div class="modal fade text-black" id="modal" data-bs-backdrop="static" data-bs-keyboard="false"
                  tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Payment Method</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <!-- payment method -->
                      <form action="account.php" method="post">
                        <!-- Add a hidden input field to include the userId -->
                        <input type="hidden" name="userId" value="<?php echo $_SESSION['userId']; ?>">
                        <div class="modal-body">
                          <h4>Choose your payment</h4>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentOption" id="gcash" value="gcash">
                            <label class="form-check-label" for="gcash">
                              Gcash
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentOption" id="debitCard"
                              value="debitCard">
                            <label class="form-check-label" for="debitCard">
                              Debit Card
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentOption" id="creditCard"
                              value="creditCard">
                            <label class="form-check-label" for="creditCard">
                              Credit Card
                            </label>
                          </div>
                          <input type="hidden" name="redirectPage" value="">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary" name="proceedButton">Proceed</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Name, paragraph, and button in the center -->
      <div class="col d-flex flex-column align-items-center p-3 text-center vh-25">
        <h1 class="pt-5">Welcome
          <?php echo $fName; ?>!
        </h1>
        <p>
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae ex
          quos libero non quasi blanditiis veniam tempore. Eligendi, hic enim.
        </p>
        <a href="reviews.php?userId=<?php echo $userId; ?>"
          class="btn btn-outline-dark w-50 mt-5 rounded-pill d-none d-md-block">
          Leave us a Review!
        </a>
      </div>

      <!-- Picture on the right -->
      <div class="col d-flex flex-column align-items-center py-5 vh-25">
        <img id="profilePicture" src="<?php echo $pfPicture; ?>" alt="" style="width: 15rem; height: 15rem"
          class="rounded-circle object-fit-cover border border-5 border-dark-subtle" />
        <a href="update.php?userId=<?php echo $userId; ?>"
          class="btn btn-outline-dark w-25 my-3 rounded-pill text-decoration-none">Update</a>
      </div>
    </div>

  </div>
</body>