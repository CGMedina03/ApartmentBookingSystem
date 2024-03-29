<?php
session_start();
require 'components/retrieve.php';
require 'components/retrieveRenters.php';
require 'components/layout.php';
require 'components/retrieveRooms.php';

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
    }
  }
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
    if (isset($_SESSION['successPaymentMessage'])) {
      $successPaymentMessage = $_SESSION['successPaymentMessage'];

      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>' . $successPaymentMessage . ' </strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
    ?>
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
                    Your rent is due. Plesase pay now through here or cash. Thank you!
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
                <form action="payment.php" method="GET">
                  <!-- Hidden input field to pass userId -->
                  <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                  <button type="submit" class="btn btn-light rounded-pill mt-3">Payment</button>
                </form>
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
          Thank you for joining our community. We strive to provide the best experience for our users.
          Feel free to explore and engage with our platform.
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