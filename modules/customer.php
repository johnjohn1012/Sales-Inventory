<?php
    include 'connection.php';

    // Add customer
    if (isset($_POST['add_customer'])) {
        $first_name = mysqli_real_escape_string($db, $_POST['FIRST_NAME']);
        $last_name = mysqli_real_escape_string($db, $_POST['LAST_NAME']);
        $phone_number = mysqli_real_escape_string($db, $_POST['PHONE_NUMBER']);
        $date_created = date('Y-m-d H:i:s');

        $query = "INSERT INTO customer (FIRST_NAME, LAST_NAME, PHONE_NUMBER, DATE_CREATED) VALUES ('$first_name', '$last_name', '$phone_number', '$date_created')";
        if (mysqli_query($db, $query)) {
            echo "<script>alert('Customer Added Successfully!'); window.location='index_admin.php?page=customer';</script>";
        } else {
            echo "<script>alert('Error Adding Customer');</script>";
        }
    }

    // Update customer
    if (isset($_POST['update_customer'])) {
        $cust_id = intval($_POST['cust_id']);
        $first_name = mysqli_real_escape_string($db, $_POST['FIRST_NAME']);
        $last_name = mysqli_real_escape_string($db, $_POST['LAST_NAME']);
        $phone_number = mysqli_real_escape_string($db, $_POST['PHONE_NUMBER']);

        $query = "UPDATE customer SET FIRST_NAME = '$first_name', LAST_NAME = '$last_name', PHONE_NUMBER = '$phone_number' WHERE CUST_ID = $cust_id";
        if (mysqli_query($db, $query)) {
            echo "<script>alert('Customer Updated Successfully!'); window.location='index_admin.php?page=customer';</script>";
        } else {
            echo "<script>alert('Error Updating Customer');</script>";
        }
    }

    // Delete customer
    if (isset($_GET['delete'])) {
        $cust_id = intval($_GET['delete']);
        $query = "DELETE FROM customer WHERE CUST_ID = $cust_id";
        if (mysqli_query($db, $query)) {
            echo "<script>alert('Customer Deleted Successfully!'); window.location='index_admin.php?page=customer';</script>";
        } else {
            echo "<script>alert('Error Deleting Customer');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-primary">Customer Management</h2>
    
    <!-- Add Customer Form -->
    <form method="POST" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="FIRST_NAME" class="form-control" placeholder="First Name" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="LAST_NAME" class="form-control" placeholder="Last Name" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="PHONE_NUMBER" class="form-control" placeholder="Phone Number" required>
            </div>
            <div class="col-md-3">
                <button type="submit" name="add_customer" class="btn btn-success">Add Customer</button>
            </div>
        </div>
    </form>

    <!-- Customer Table -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Customer List</h5>
        </div>
        <div class="card-body">
            <table id="customerTable" class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Date Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM customer ORDER BY CUST_ID ASC";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['CUST_ID']}</td>
                                    <td>{$row['FIRST_NAME']}</td>
                                    <td>{$row['LAST_NAME']}</td>
                                    <td>{$row['PHONE_NUMBER']}</td>
                                    <td>{$row['DATE_CREATED']}</td>
                                    <td>
                                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal{$row['CUST_ID']}'>Edit</button>
                                        <a href='index_admin.php?page=customer&delete={$row['CUST_ID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                    </td>
                                  </tr>";

                            // Edit Modal
                            echo "<div class='modal fade' id='editModal{$row['CUST_ID']}' tabindex='-1'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title'>Edit Customer</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                            </div>
                                            <form method='POST'>
                                                <div class='modal-body'>
                                                    <input type='hidden' name='cust_id' value='{$row['CUST_ID']}'>
                                                    <input type='text' name='FIRST_NAME' class='form-control' value='{$row['FIRST_NAME']}' required>
                                                    <input type='text' name='LAST_NAME' class='form-control' value='{$row['LAST_NAME']}' required>
                                                    <input type='text' name='PHONE_NUMBER' class='form-control' value='{$row['PHONE_NUMBER']}' required>
                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                    <button type='submit' name='update_customer' class='btn btn-primary'>Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                  </div>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#customerTable').DataTable();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
