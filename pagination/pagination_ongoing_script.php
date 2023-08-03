<?php
// Validate and sanitize the user input for the current page
$currentPage = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int) $_GET['page'] : 1;
$itemsPerPage = 10;

// Include the retrieveOngoing.php file if not included before
if (!isset($ongoingUser)) {
    require '../components/retrieveOngoing.php';
}

// Check if the $ongoingUser array is empty
if (empty($ongoingUser)) {
    $totalItems = 0;
    $totalPages = 1;
    $paginatedData = [];
} else {
    // Calculate total number of items and pages
    $totalItems = count($ongoingUser);
    $totalPages = ceil($totalItems / $itemsPerPage);

    // Validate the current page to avoid going out of bounds
    if ($currentPage < 1) {
        $currentPage = 1;
    } elseif ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    // Calculate the offset to fetch the relevant data from the $ongoingUser array
    $offset = ($currentPage - 1) * $itemsPerPage;
    $paginatedData = array_slice($ongoingUser, $offset, $itemsPerPage);
}
?>

<!-- Display the table and pagination links -->
<?php if (empty($paginatedData)): ?>
    <p>No data available.</p>
<?php else: ?>
    <form action="admin-dashboard.php" method="post" onsubmit="return validateForm()">
        <table class="table table-dark table-striped table-hover table-bordered shadow rounded-5">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="selectAllCheckboxOngoing" onclick="toggleCheckboxesOngoing()">
                    </th>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Room Name</th>
                    <th>Schedule</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = $offset + 1; // Start counter from the correct value for the current page
                foreach ($paginatedData as $user):
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="selectedRowOngoing[]" value="<?php echo $user['id']; ?>">
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <!-- Buttons are now inside the form -->
                        <button type="submit" class="btn btn-warning rounded-pill btn-sm m-2"
                            name="moveToCompleteFromOngoing">Complete</button>
                        <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                    </td>
                </tr>
            </tfoot>
        </table>
        <!-- Pagination links -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link  bg-warning text-black"
                            href="<?= $_SERVER['PHP_SELF'] ?>?page=<?= $currentPage - 1 ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link  bg-warning text-black" href="<?= $_SERVER['PHP_SELF'] ?>?page=<?= $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link  bg-warning text-black"
                            href="<?= $_SERVER['PHP_SELF'] ?>?page=<?= $currentPage + 1 ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </form>
    <script>
        function validateForm() {
            // Get all the checkboxes with the name "selectedRowOngoing[]"
            const checkboxes = document.querySelectorAll('input[name="selectedRowOngoing[]"]');

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

        function toggleCheckboxesOngoing() {
            const checkboxes = document.querySelectorAll('input[name="selectedRowOngoing[]"]');
            const selectAllCheckbox = document.getElementById('selectAllCheckboxOngoing');

            checkboxes.forEach((checkbox) => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }
    </script>
<?php endif; ?>