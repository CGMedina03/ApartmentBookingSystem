<?php
require '../components/retrieveComplete.php';

// Pagination settings
$rowsPerPage = 10; // Change this to the desired number of rows per page
$totalRows = count($completeUser);
$totalPages = ceil($totalRows / $rowsPerPage);

// Get the current page from the URL query parameter 'page'
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages)); // Make sure the current page is within valid range

// Calculate the starting index and ending index of data to display on the current page
$startIndex = ($currentPage - 1) * $rowsPerPage;
$endIndex = min($startIndex + $rowsPerPage, $totalRows);

// Get the data for the current page
$currentPageData = array_slice($completeUser, $startIndex, $endIndex - $startIndex);

// Counter for displaying row numbers
$counter = $startIndex + 1;
?>

<?php if (empty($currentPageData)): ?>
    <p>No data available.</p>
<?php else: ?>
    <form action="admin-dashboard.php" method="post" onsubmit="return validateForm()">
        <table class="table table-dark table-striped table-hover table-bordered shadow rounded-5">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="selectAllCheckboxComplete" onclick="toggleCheckboxesComplete()">
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
                <?php foreach ($currentPageData as $user): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="selectedRowComplete[]" value="<?php echo $user['id']; ?>">
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
                        <button type="button" class="btn btn-warning rounded-pill btn-sm m-2" data-bs-toggle="modal"
                            data-bs-target="#deleteConfirmationModal<?php echo $user['id']; ?>">
                            Delete
                        </button>
                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade " id="deleteConfirmationModal<?php echo $user['id']; ?>" tabindex="-1"
                            aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content text-black">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm
                                            Deletion
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this row?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn btn-warning"
                                            name="deleteFromComplete">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

            </tfoot>
        </table>
    </form>
    <!-- Pagination links -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link bg-warning text-black" href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                    <a class="page-link bg-warning text-black" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link bg-warning text-black" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <script>
        function validateForm() {
            // Get all the checkboxes with the name "selectedRowComplete[]"
            const checkboxes = document.querySelectorAll('input[name="selectedRowComplete[]"]');

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

        function toggleCheckboxesComplete() {
            const checkboxes = document.querySelectorAll('input[name="selectedRowComplete[]"]');
            const selectAllCheckbox = document.getElementById('selectAllCheckboxComplete');

            checkboxes.forEach((checkbox) => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }
    </script>
<?php endif; ?>