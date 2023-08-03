<?php
require 'components/layout.php';
require 'components/retrieveUserInfo.php';
require 'components/retrieveAppointment.php';
require 'components/retrieveCopy.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the form was submitted
    $title = $_POST["roomTitle"];
    $addson = $_POST["roomAddson"];

    if (empty($title) || empty($addson)) {
        // If either title or addson is empty, show an error message
        echo "<p style='color: red;'>Please enter the title and addson before moving.</p>";
    }
}
?>

<h1>User Table</h1>
<?php if (empty($userinfocopy)): ?>
    <p>No data available in this table.</p>
<?php else: ?>
    <table class="table table-dark table-striped table-hover table-bordered shadow rounded-5" id="bookAppointment">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            foreach ($userinfocopy as $user):
                ?>
                <tr>
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
                        <button type="button" class="btn btn-secondary text-white rounded-pill btn-sm m-2"
                            data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal<?php echo $user['id']; ?>">
                            Delete
                        </button>
                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteConfirmationModal<?php echo $user['id']; ?>" tabindex="-1"
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
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="admin-dashboard.php" method="post">
                                            <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn btn-danger"
                                                name="deleteFromUserTable">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="admin-dashboard.php" method="post">
                            <input type="hidden" name="userinfocopyEmail" value="<?php echo $user['email']; ?>">
                            <input type="hidden" name="operation" value="move">
                            <button type="button" class="btn btn-warning rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#moveConfirmationModal<?php echo $user['id']; ?>">Rented</button>
                        </form>
                        <div class="modal fade" id="moveConfirmationModal<?php echo $user['id']; ?>" tabindex="-1"
                            aria-labelledby="moveConfirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content  bg-dark text-white">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="moveConfirmationModalLabel">Additional Information</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="moveConfirmationForm<?php echo $user['id']; ?>" action="admin-dashboard.php"
                                            method="post">
                                            <input type="hidden" name="userinfocopyEmail" value="<?php echo $user['email']; ?>">
                                            <input type="hidden" name="operation" value="move">
                                            <div class="form-group mb-3">
                                                <label for="advancePay">Advance Payment?</label>
                                                <input type="number" class="form-control" name="advancePay" id="advancePay"
                                                    placeholder="Enter advance payment">
                                                <?php if (isset($_SESSION['formErrors']['advancePay'])) { ?>
                                                    <p class="text-danger">
                                                        <?php echo $_SESSION['formErrors']['advancePay']; ?>
                                                    </p>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="dateToMove">When will they be moved?</label>
                                                <input type="date" class="form-control" name="dateToMove" id="dateToMove"
                                                    placeholder="Enter date to move">
                                                <?php if (isset($_SESSION['formErrors']['dateToMove'])) { ?>
                                                    <p class="text-danger">
                                                        <?php echo $_SESSION['formErrors']['dateToMove']; ?>
                                                    </p>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group mb-3">
                                                <h4 for="rentAndExtra">Information</h4>
                                                <?php if (!empty($title)) { ?>
                                                    <p>Room Title:
                                                        <?php echo $title; ?>
                                                    </p>
                                                    <p>Ammenity(ies):
                                                        <?php echo $addOn; ?>
                                                    </p>
                                                <?php } else { ?>
                                                    <p>No title or addson available</p>
                                                <?php } ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary rounded-pill btn-sm"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <?php if (!empty($title)) { ?>
                                                    <button type="submit" class="btn btn-warning rounded-pill"
                                                        name="moveFromUserTable">Move</button>
                                                <?php } ?>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>