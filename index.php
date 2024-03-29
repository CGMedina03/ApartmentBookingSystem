<?php
require 'components/retrieve.php';
require 'components/retrieveRooms.php';
require 'components/retrieveAddsOn.php';
require 'components/layout.php';
require 'components/retrieveReviews.php';
session_start();

// Function to truncate the text
function truncateText($text, $length = 100)
{
  if (mb_strlen($text) > $length) {
    $truncatedText = mb_substr($text, 0, $length) . '...';
    return $truncatedText;
  }
  return $text;
}

// Assuming $rooms contains the list of rooms
$filteredRooms = $rooms; // initially, all rooms are shown

// Handle search
if (isset($_GET['search']) && !empty($_GET['search'])) {
  $searchTerm = strtolower($_GET['search']);
  $filteredRooms = array_filter($rooms, function ($room) use ($searchTerm) {
    $title = strtolower($room['title']);
    $description = strtolower($room['description']);
    return strpos($title, $searchTerm) !== false || strpos($description, $searchTerm) !== false;
  });
}
// Handle filtering by room size
if (isset($_GET['roomSize']) && !empty($_GET['roomSize'])) {
  $roomSize = $_GET['roomSize']; // Assuming room size is passed as a parameter
  $filteredRooms = array_filter($filteredRooms, function ($room) use ($roomSize) {
    // Assuming room size is stored in the database as 'size'
    return $room['roomSize'] == $roomSize;
  });
}
?>
<link rel="stylesheet" href="css/style.css">
<title>RPABS</title>
</head>

<body class="bg-body-secondary">
  <?php require 'components/navbar.php';
  ?>

  <!-- Hero section -->
  <section class="hero-section">
    <div class="tinted-overlay"></div>
    <img src="assets\received_1827848727664560.png" alt="" class="heroImg">
    <!-- scroll down button -->
    <button class="floatingButton p-3" onclick="scrollDown()">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-down"
        viewBox="0 0 20 20">
        <path fill-rule="evenodd"
          d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1" />
      </svg>Scroll down
    </button>
  </section>
  <div class="advertImg">
    <img src="assets\20240128_095737_0000.png" alt="">
  </div>
  <div class="advertImg2">
    <img src="assets\Grey Real State Apartment For Rent Instagram Story_20240127_195254_0000.png" alt="">
  </div>
  <hr />
  <!-- rooms -->
  <section id="rooms">
    <div class="container-sm py-3">
      <div class="findRooms">
        <!-- Filter form -->
        <form action="" method="GET">
          <div class="filterBar">
            <input class="inputFilter form-control" type="text" name="userId"
              value="<?php echo isset($_GET['userId']) ? $_GET['userId'] : ''; ?>" style="display: none;">
            <select name="roomSize" class="inputFilter form-control">
              <option value="">Select Room Size</option>
              <option value="1">1 person</option>
              <option value="2">2 people</option>
              <option value="3">3 people</option>
            </select>
            <button class="filterBtn" type="submit" role="button"><span class="text">Filter</span></button>
          </div>
        </form>
        <!-- Search bar -->
        <form method="GET" action="">
          <div class="searchBar">
            <input class="inputSearch form-control" type="text" name="userId"
              value="<?php echo isset($_GET['userId']) ? $_GET['userId'] : ''; ?>" style="display: none;">
            <input class="inputSearch form-control" type="text" name="search" placeholder="Search rooms..."
              value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button class="searchBtn" type="submit" role="button"><span class="text">Search</span></button>
          </div>
        </form>
      </div>
      <?php
      $hiddenRoomCount = 0; // Initialize a counter for hidden rooms
      foreach ($filteredRooms as $index => $room):
        if ($room['status'] === 'Available' || $room['status'] === 'Undecided'):
          $hiddenClass = ($index >= 3 && $hiddenRoomCount < 9) ? 'hidden-room' : ''; // Add hidden-room class for the first 3 hidden rooms
          if ($hiddenClass === 'hidden-room') {
            $hiddenRoomCount++; // Increment the counter for hidden rooms
          }
          ?>
          <div class="room mb-3 mx-lg-5 px-lg-5 <?php echo $hiddenClass; ?>">
            <div class="d-lg-flex <?php echo $room['rID'] % 2 == 0 ? 'flex-row-reverse' : ''; ?>">
              <div class="pt-3 p-lg-3">
                <?php if (isset($room['picture']) && !empty(trim($room['picture']))): ?>
                  <?php
                  // Split the picture URLs into an array using line breaks as delimiters
                  $pictureUrls = explode("\n", $room['picture']);
                  // Take the first URL from the array
                  $firstPictureUrl = isset($pictureUrls[0]) ? trim($pictureUrls[0]) : null;
                  ?>
                  <!-- Wrap the room content inside an anchor tag with a link to roomDetails page -->
                  <a class="text-decoration-none text-reset"
                    href="<?php echo $userId && !empty($userId) ? 'roomDetails.php?userId=' . $userId . '&rID=' . $room['rID'] : 'roomDetails.php?rID=' . $room['rID']; ?>">
                    <img src="<?php echo $firstPictureUrl; ?>" alt="" class="card-img rounded rounded-3"
                      style="width: 300px; height: 200px; object-fit: cover;" />
                  </a>
                <?php endif; ?>
              </div>
              <div class="pt-2 mt-3 mt-lg-5">
                <?php if (isset($room['title'])): ?>
                  <!-- Wrap the room title inside an anchor tag with a link to roomDetails page -->
                  <a class="text-decoration-none text-reset"
                    href="<?php echo $userId && !empty($userId) ? 'roomDetails.php?userId=' . $userId . '&rID=' . $room['rID'] : 'roomDetails.php?rID=' . $room['rID']; ?>">
                    <h2 class="<?php echo $room['rID'] % 2 === 0 ? 'text-lg-end' : ''; ?>">
                      <?php echo $room['title']; ?>
                    </h2>
                  </a>
                <?php endif; ?>
                <?php if (isset($room['description'])): ?>
                  <p class="<?php echo $room['rID'] % 2 === 0 ? 'text-lg-end' : ''; ?>">
                    <?php echo truncateText($room['description'], 150); ?>
                  </p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
      <!-- Add a button at the bottom -->
      <button id="seeMoreButton" class="btn btn-primary mt-3 seeBtn">See more</button>
    </div>
  </section>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const seeMoreButton = document.getElementById("seeMoreButton");

      seeMoreButton.addEventListener("click", function () {
        const hiddenRooms = document.querySelectorAll(".hidden-room");
        const roomsToShow = 2;

        console.log("Button clicked");
        console.log("Initial hidden rooms count: " + hiddenRooms.length);

        let count = 0;
        // Show the next set of hidden rooms
        hiddenRooms.forEach(function (room) {
          if (count < roomsToShow && room.classList.contains("hidden-room")) {
            room.style.display = "block";
            room.classList.remove("hidden-room");
            count++;
          }
        });

        console.log("Current hidden rooms count: " + hiddenRooms.length);

        // Hide the "See more" button when all rooms are visible
        if (hiddenRooms.length === 0) {
          seeMoreButton.style.display = "none";
        }
      });
    });
  </script>
  <!-- adds on -->
  <section id="addson">
    <div class="container-fluid bg-dark text-white pt-3">
      <h1 class="text-center">Adds on</h1>
      <p class="text-center">
        Our ammenities in Rizal Parks' Apartment
      </p>
      <div class="addson d-flex justify-content-between overflow-x-scroll m-3 m-lg-5">
        <?php
        foreach ($addsons as $index => $addon) {
          $imageUrl = $addon['picture'];
          $title = $addon['title'];
          $description = $addon['description'];
          $availability = $addon['availability'];
          $price = $addon['price'];
          ?>
          <img src="<?php echo $imageUrl; ?>" alt="addson" style="
              width: 15rem;
              height: 25rem;
              object-fit: cover;
              border-radius: 15px;
              cursor: pointer; /* Add this line to show the pointer cursor on the images */
            " class="me-4" data-bs-toggle="modal" data-bs-target="#exampleModal" data-title="<?php echo $title; ?>"
            data-description="<?php echo $description; ?>" data-availability="<?php echo $availability; ?>"
            data-price="<?php echo $price; ?>" />
        <?php } ?>
      </div>
    </div>
    <!-- Add the following code anywhere in your HTML, preferably after the addson section -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-title"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p id="modal-description"></p>
            <img src="" id="modal-image" style="width: 100%; max-height: 300px;" class="object-fit-contain"
              alt="addson" />
            <p>Availability: <span id="modal-availability"></span></p>
            <p>Price: <span id="modal-price"></span></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- review -->
  <section id="reviews">
    <div class="container-fluid mb-5">
      <h1 class="text-center">Rate Us</h1>
      <h2 class="text-center">
        Leave us a review. Thank you!
      </h2>
      <div>
        <?php
        // Fetch reviews from the database
        $reviewsQuery = "SELECT fName, lName, star, content FROM reviews";
        $reviewsResult = $conn->query($reviewsQuery);

        if ($reviewsResult->num_rows > 0) {
          while ($row = $reviewsResult->fetch_assoc()) {
            $fName = $row['fName'];
            $lName = $row['lName'];
            $star = $row['star'];
            $content = $row['content'];
            ?>
            <div class="card mx-lg-5 mx-3 mt-3" style="width: auto">
              <div class="card-body">
                <div class="d-flex">
                  <h5 class="card-title pe-3">
                    <?php echo $fName . ' ' . $lName; ?>
                  </h5>
                  <?php
                  // Display star rating based on the value of $star
                  for ($i = 1; $i <= $star; $i++) {
                    $starClass = ($i <= $star) ? 'bi-star-fill' : 'bi-star';
                    ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                      class="bi <?php echo $starClass; ?> mt-1 me-1" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <?php
                  }
                  ?>
                </div>
                <p class="card-text">
                  <?php echo $content; ?>
                </p>
              </div>
            </div>
            <?php
          }
        } else {
          // Display a message if no reviews are found
          echo "<p>No reviews found.</p>";
        }
        ?>
      </div>

    </div>
  </section>
  <!-- footer -->
  <footer>
    <div class="bg-dark pb-1 sticky-bottom">
      <p class="text-center text-white text-black align-bottom">
        Read all Terms and Conditions. All rights reseve 2023 ©
      </p>
    </div>
  </footer>
  <script>
    // modal funtion
    document.addEventListener("DOMContentLoaded", function () {
      const modalTitleElement = document.getElementById("modal-title");
      const modalDescriptionElement = document.getElementById("modal-description");
      const modalImageElement = document.getElementById("modal-image");
      const modalAvailabilityElement = document.getElementById("modal-availability");
      const modalPriceElement = document.getElementById("modal-price");

      // Attach an event listener to each image with the class "me-4" (this class is set on the images in the loop)
      const images = document.querySelectorAll(".me-4");
      images.forEach((image) => {
        image.addEventListener("click", function () {
          // Get the data from the data attributes
          const title = this.getAttribute("data-title");
          const description = this.getAttribute("data-description");
          const imageUrl = this.getAttribute("src");
          const availability = this.getAttribute("data-availability");
          const price = this.getAttribute("data-price");

          // Populate the modal content with the fetched data
          modalTitleElement.textContent = title;
          modalDescriptionElement.textContent = description;
          modalImageElement.src = imageUrl;
          modalAvailabilityElement.textContent = availability;
          modalPriceElement.textContent = price;
        });
      });
    });
  </script>

  <script>
    // JavaScript code to handle smooth scrolling when clicking navigation links
    document.addEventListener('DOMContentLoaded', function () {
      var navLinks = document.querySelectorAll('#offcanvas a');

      navLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          var targetId = this.getAttribute('href').substring(1);
          var targetSection = document.getElementById(targetId);

          if (targetSection) {
            // Use smooth scrolling behavior
            targetSection.scrollIntoView({ behavior: 'smooth' });
          }
        });
      });
    });
    function scrollDown() {
      const scrollOffset = 700;
      window.scrollBy({
        top: scrollOffset,
        behavior: 'smooth'
      });
    }
  </script>