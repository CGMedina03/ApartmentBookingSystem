<?php
// Include the retrieveAppointment.php file if not included before
if (!isset($appointment)) {
    require '../components/retrieveAppointment.php';
}

// Check if the $appointment array is empty
if (empty($appointment)) {
    echo '<p>No data available.</p>';
} else {
    // Pagination settings
    $itemsPerPage = 10;
    $totalItems = count($appointment);
    $totalPages = ceil($totalItems / $itemsPerPage);

    // Validate and sanitize the user input for the current page
    $currentPage = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int) $_GET['page'] : 1;
    $currentPage = max(1, min($currentPage, $totalPages)); // Make sure the current page is within valid range

    // Calculate the starting index and ending index of data to display on the current page
    $startIndex = ($currentPage - 1) * $itemsPerPage;
    $endIndex = min($startIndex + $itemsPerPage, $totalItems);

    // Get the data for the current page
    $currentPageData = array_slice($appointment, $startIndex, $endIndex - $startIndex);

    // Counter for displaying row numbers
    $counter = ($currentPage - 1) * $itemsPerPage + 1;
    ?>

    <form action="admin-dashboard.php" method="post" onsubmit="return validateForm()">
        <table class="table table-dark table-striped table-hover table-bordered shadow rounded-5" id="userTable">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="selectAllCheckbox" onclick="toggleCheckboxes()">
                    </th>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Room Name</th>
                    <th>Schedule</th>
                    <th>Ammenities</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($currentPageData as $user): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="selectedRow[]" value="<?php echo $user['aID']; ?>">
                        </td>
                        <td>
                            <?php echo $counter++; ?>
                        </td>
                        <td>
                            <?php echo $user['fName']; ?>
                        </td>
                        <td>
                            <?php echo $user['lName']; ?>
                        </td>
                        <td>
                            <?php echo $user['email']; ?>
                        </td>
                        <td>
                            <?php echo $user['title']; ?>
                        </td>
                        <td>
                            <?php echo $user['date']; ?>
                        </td>
                        <td>
                            <?php echo $user['addOn']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" class="d-flex justify-content-end">
                        <form action="admin-dashboard.php" method="post">
                            <button type="submit" class="btn btn-secondary rounded-pill btn-sm p-2 mb-2 mb-lg-0"
                                name="moveToOngoing">Ongoing</button>
                            <input type="hidden" name="selectedRow[]" value="<?php echo $user['aID']; ?>">
                        </form>
                        <form action="admin-dashboard.php" method="post">
                            <button type="submit" class="btn btn-warning rounded-pill btn-sm p-2 mb-lg-0"
                                name="moveToCompleteFromUserInfo">Complete</button>
                            <input type="hidden" name="selectedRow[]" value="<?php echo $user['aID']; ?>">
                        </form>
                    </td>
                </tr>
            </tfoot>
        </table>
        <!-- Pagination links -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link  bg-warning text-black" href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link  bg-warning text-black" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link  bg-warning text-black" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </form>

    <script>
        function validateForm() {
            // Get all the checkboxes with the name "selectedRow[]"
            const checkboxes = document.querySelectorAll('input[name="selectedRow[]"]');

            // Check if at least one checkbox is checked
            let isChecked = false;
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    isChecked = true;
                    return; // Exit the loop if at least one checkbox is checked
                }
            });

            // Show an error message if no checkbox is checked
            if (!isChecked) {
                alert('Please select at least one row.');
                return false; // Prevent the form from submitting
            }

            // Allow the form to submit if at least one checkbox is checked
            return true;
        }
        function toggleCheckboxes() {
            const checkboxes = document.querySelectorAll('input[name="selectedRow[]"]');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');

            checkboxes.forEach((checkbox) => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }
    </script>
<?php } ?>