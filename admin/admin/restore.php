<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <!-- Add your CSS styles and DataTables CSS CDN link here -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="need.css">
    <style>
        .container-fluid {
            margin-top: 100px;
        }
        .card {
            margin-top: 20px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #259E9E;
            color: #259E9E;
            padding: 15px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            padding: 20px;
        }
        .form-section {
            margin-bottom: 30px;
        }
        .form-section h2 {
            margin-bottom: 10px;
            color: #259E9E;
        }
        .form-section form {
            display: flex;
            align-items: center;
        }
        .form-section input[type="file"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }
        .form-section button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #259E9E;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-section button:hover {
            background-color: #207a7a;
        }
    </style>
</head>
<body>
    <?php 
    session_start();
    include('includes/header.php');
    include('includes/navbar2.php');
    ?>

    <div class="container-fluid">
        <!-- DataTables Example -->
        <div class="card shadow nb-4">
            <div class="card-header py-3">
                <h1>Back-up and Restore</h1>
            </div>
            <div class="card-body">
                <div class="form-section">
                    <h2>Import Data</h2>
                    <form action="import.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" accept=".sql" required>
                        <button type="submit" name="import_submit">Import</button>
                    </form>
                </div>

                <div class="form-section">
                    <h2>Export Data</h2>
                    <form action="export.php" method="post">
                        <button type="submit" name="export_submit">Export</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>

    <script>
        var ascending = true;

        function sortTable(columnIndex) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("dataTable");
            switching = true;
            var icon = document.getElementById("sortIcon");
            if (ascending) {
                icon.classList.remove("fa-sort");
                icon.classList.add("fa-sort-up");
            } else {
                icon.classList.remove("fa-sort-up");
                icon.classList.add("fa-sort-down");
            }
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[columnIndex];
                    y = rows[i + 1].getElementsByTagName("TD")[columnIndex];
                    if (ascending) {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
            ascending = !ascending;
        }
    </script>

    <!-- DataTables JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "pageLength": 10, // Display 10 entries per page
                "searching": true,
                "ordering": false, // Disable ordering/sorting
                "info": true,
                "autoWidth": false,
                "language": {
                    "paginate": {
                        "previous": "<i class='fas fa-arrow-left'></i>", // Use arrow-left icon for previous button
                        "next": "<i class='fas fa-arrow-right'></i>" // Use arrow-right icon for next button
                    }
                },
                "pagingType": "simple" // Set the pagination type to simple
            });
        });
    </script>
</body>
</html>
