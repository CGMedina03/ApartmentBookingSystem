<?php
require 'retrieve.php';

// Check if userId exists in the URL
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    // Remove the login button and replace it with a logout button
    $logoutButton = '<a href="login.php" class="text-decoration-none text-white">Log out</a>';
} else {
    // Set userId to an empty value
    $userId = '';

    // Redirect the user to login.php if they clicked the account item
    if (isset($_GET['account'])) {
        header("Location: login.php");
        exit;
    }

    // Display the login button
    $logoutButton = '<a href="login.php" class="text-decoration-none text-white">Log in</a>';
}

// No other PHP code or output should be present before this point
require 'layout.php';
?>

<link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-body-secondary">
    <!-- navlist and title -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="index.php<?php echo $userId ? '?userId=' . $userId : ''; ?>">
                <img src="assets\LOGO-removebg-preview.png" alt="" class="img-logo me-2">
                Rizal Park's Apartment Booking System
            </a>
            <!-- Toggler for small screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- start of navbar -->
            <div class="collapse navbar-collapse" id="navbarNav" data-bs-theme="dark">
                <ul class="navbar-nav ms-auto m-3">
                    <li class="mx-3">
                        <?php if (!isset($_GET['userId'])): ?>
                            <a href="login.php" class="text-decoration-none text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                    class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                </svg>
                                Account
                            </a>
                        <?php elseif ($userId == 1): ?>
                            <a href="admin-dashboard.php?userId=1" class="text-decoration-none text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                    class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                </svg>
                                Account
                            </a>
                        <?php else: ?>
                            <a href="<?php echo 'account.php?userId=' . $userId; ?>"
                                class="text-decoration-none text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                    class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                </svg>
                                Account
                            </a>
                        <?php endif; ?>
                    </li>
                    <li class="mx-3">
                        <a href="index.php<?php echo $userId ? '?userId=' . $userId : ''; ?>#rooms"
                            class="text-decoration-none text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-door-open-fill" viewBox="0 0 16 16">
                                <path
                                    d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z" />
                            </svg>
                            Rooms
                        </a>
                    </li>
                    <li class="mx-3">
                        <a href="index.php<?php echo $userId ? '?userId=' . $userId : ''; ?>#addson"
                            class="text-decoration-none text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-heart-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                            </svg>
                            Adds-on
                        </a>
                    </li>
                    <li class="mx-3">
                        <a href="index.php<?php echo $userId ? '?userId=' . $userId : ''; ?>#reviews"
                            class="text-decoration-none text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            Reviews
                        </a>
                    </li>
                </ul>
                <!-- Log In button -->
                <div class="d-flex justify-content-center mt-3 mt-md-0">
                    <button class="btn btn-lg logIn text-white">
                        <?php echo $logoutButton; ?>
                    </button>
                </div>
            </div>
    </nav>
    <script>
        // Check if the current page is index.php
        if (window.location.pathname.includes("index.php")) {
            const navbar = document.getElementById('navbar');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 0) {
                    navbar.classList.add('bg-dark'); // Add Bootstrap class for dark background
                } else {
                    navbar.classList.remove('bg-dark'); // Remove Bootstrap class for transparent background
                }
            });
        }

    </script>

    <body>