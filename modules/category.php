<?php
    include 'connection.php';

    // Add Category
    if (isset($_POST['add_category'])) {
        $cname = mysqli_real_escape_string($db, $_POST['cname']);
        $query = "INSERT INTO category (CNAME) VALUES ('$cname')";
        if (mysqli_query($db, $query)) {
            echo "<script>alert('Category Added Successfully!'); window.location='index_admin.php?page=category';</script>";
        } else {
            echo "<script>alert('Error Adding Category');</script>";
        }
    }

    // Update Category
    if (isset($_POST['update_category'])) {
        $category_id = intval($_POST['category_id']);
        $cname = mysqli_real_escape_string($db, $_POST['cname']);
        $query = "UPDATE category SET CNAME = '$cname' WHERE CATEGORY_ID = $category_id";
        if (mysqli_query($db, $query)) {
            echo "<script>alert('Category Updated Successfully!'); window.location='index_admin.php?page=category';</script>";
        } else {
            echo "<script>alert('Error Updating Category');</script>";
        }
    }

    // Delete Category
    if (isset($_GET['delete'])) {
        $category_id = intval($_GET['delete']);
        $query = "DELETE FROM category WHERE CATEGORY_ID = $category_id";
        if (mysqli_query($db, $query)) {
            echo "<script>alert('Category Deleted Successfully!'); window.location='index_admin.php?page=category';</script>";
        } else {
            echo "<script>alert('Error Deleting Category');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- JSZip (For Excel Export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- PDFMake (For PDF Export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-primary">Category Management</h2>
    
    <!-- Add Category Form -->
    <form method="POST" class="mb-3">
        <div class="input-group">
            <input type="text" name="cname" class="form-control" placeholder="Enter Category Name" required>
            <button type="submit" name="add_category" class="btn btn-success ms-2">Add Category</button>
        </div>
    </form>
    <div class="d-flex justify-content-end mb-3">
      <button id="exportExcel" class="btn btn-success me-2"><i class="fas fa-file-excel"></i> Export to Excel</button>
      <button id="exportPDF" class="btn btn-danger me-2"><i class="fas fa-file-pdf"></i> Export to PDF</button>
      <button id="printTable" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
    </div>
    <!-- Category Table -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Category List</h5>
        </div>


        <div class="card-body">
            <table id="categoryTable" class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Date Created</th> <!-- New Column -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM category ORDER BY CATEGORY_ID ASC";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['CATEGORY_ID']}</td>
                                    <td>{$row['CNAME']}</td>
                                    <td>{$row['DATE_CREATED']}</td> <!-- Display the Date Created -->
                                    <td>
                                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal{$row['CATEGORY_ID']}'>Edit</button>
                                        <a href='index_admin.php?page=category&delete={$row['CATEGORY_ID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                    </td>
                                  </tr>";

                            // Edit Modal
                            echo "<div class='modal fade' id='editModal{$row['CATEGORY_ID']}' tabindex='-1' aria-labelledby='editModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title'>Edit Category</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <form method='POST'>
                                                <div class='modal-body'>
                                                    <input type='hidden' name='category_id' value='{$row['CATEGORY_ID']}'>
                                                    <div class='mb-3'>
                                                        <label class='form-label'>Category Name</label>
                                                        <input type='text' name='cname' class='form-control' value='{$row['CNAME']}' required>
                                                    </div>
                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                    <button type='submit' name='update_category' class='btn btn-primary'>Save Changes</button>
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

<!-- DataTables Initialization -->
<script>
    $(document).ready(function() {
        $('#categoryTable').DataTable({
            "paging": true,        // Enable pagination
            "searching": true,     // Enable search box
            "ordering": true,      // Enable column sorting
            "info": true,          // Show "Showing X to Y of Z entries"
            "lengthMenu": [10, 25, 50, 100], // Dropdown for entries per page
            "language": {
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                },
                "info": "Showing _START_ to _END_ of _TOTAL_ entries"
            }
        });
    });





    $('#exportExcel').on('click', function() {
    $('#categoryTable').DataTable().buttons(0, 0).trigger();
    });

    $('#exportPDF').on('click', function() {
        $('#categoryTable').DataTable().buttons(0, 1).trigger();
    });

    $('#printTable').on('click', function() {
        $('#categoryTable').DataTable().buttons(0, 2).trigger();
    });



</script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
