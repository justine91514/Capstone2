<?php include_once('notification_logic2.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard</title>

    <!-- Custom fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                
                <!-- Topbar Right Section -->
            <ul class="navbar-nav ml-auto">
                <!-- Nav Item - Alerts -->
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span style="display: inline-flex; align-items: center; justify-content: center; border: 2px solid lightgray; border-radius: 50%; padding: 5px; width: 35px; height: 35px; margin-right: -25px;">
                            <i class="fas fa-bell fa-fw"></i>
                        </span>


                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter" style="margin-right: -25px;"><?php echo $expiring_soon_count + $expiring_soon_buffer_count; ?></span>
                    

                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header mb-2 text-center">
                            Alerts Center
                        </h6>

                        <!-- Dropdown - For Low Stock Alerts -->
                        <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-capsules text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">January 15, 2022</div>
                            <span class="font-weight-bold">Low stock alert:</span> Some medications are running low.
                        </div>
                        </a>
                        
                        <?php
                            if ($expiring_soon_count > 0) {
                                // Display message for expiring soon products in stocks
                                echo '<a class="dropdown-item d-flex align-items-center" href="add_stocks.php">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-warning">
                                                <i class="fas fa-exclamation-triangle text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div id="notification-container"></div>
                                            <span class="font-weight-bold">Expiring Soon in Stocks:</span> ' . $expiring_soon_count . ' product(s) will expire soon in stocks.
                                        </div>
                                    </a>';
                            }

                            if ($expiring_soon_buffer_count > 0) {
                                // Display message for expiring soon products in buffer
                                echo '<a class="dropdown-item d-flex align-items-center" href="buffer_stock.php">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-warning">
                                                <i class="fas fa-exclamation-triangle text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div id="notification-container"></div>
                                            <span class="font-weight-bold">Expiring Soon in Buffer:</span> ' . $expiring_soon_buffer_count . ' product(s) will expire soon in buffer.
                                        </div>
                                    </a>';
                            }
                        ?>

                        <?php
                            // Check if there are expired products
                            $expired_count_query = "SELECT COUNT(*) as expired_count FROM expired_list";
                            $expired_count_result = mysqli_query($connection, $expired_count_query);
                            $expired_count_data = mysqli_fetch_assoc($expired_count_result);
                            $expired_count = $expired_count_data['expired_count'];

                            if ($expired_count > 0) {
                                echo '<a id="expiredLink" class="dropdown-item d-flex align-items-center" href="expired_products.php">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-danger">
                                                <i class="fas fa-calendar-times text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div id="notification-container"></div>
                                            <span class="font-weight-bold">Expired Products:</span> ' . $expired_count . ' product(s) are expired.
                                        </div>
                                    </a>';
                            }
                        ?>




                        <!-- Dropdown - Sales and Inventory Alerts -->
                        <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-success">
                                <i class="fas fa-chart-line text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">January 5, 2022</div>
                            <span class="font-weight-bold">Sales Report:</span> Monthly sales report is ready for review.
                        </div>
                        </a>

                        <!-- Dropdown - View All Alerts -->
                        <a class="dropdown-item text-center small text-gray-500" href="#">View All Pharmacy Alerts</a>




                        <!-- Add these links if not included -->
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


                        <!-- Nav Item - Calendar -->
                        <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="calendarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span style="display: inline-flex; align-items: center; justify-content: center; border: 2px solid lightgray; border-radius: 50%; padding: 5px; width: 35px; height: 35px; margin-left: 10px; margin-right: -10px;">
                        <i class="far fa-calendar-alt fa-fw"></i>
                        </span>

                            <!-- Counter - Calendar -->
                        </a>
                        <!-- Dropdown - Calendar -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="calendarDropdown">
                            <div class="text-center">
                                <h6 class="dropdown-header mb-2">
                                    Calendar
                                </h6>
                                <input type="text" id="datepicker" placeholder="2024-01-24">
                            </div>
                            <div id="anotherCalendar" class="text-center" style="max-width: 380px; margin: 0 auto;"></div>
                        </div>
                        </li>

                        <!-- Initialize flatpickr and Another Calendar -->
                        <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Initialize flatpickr
                            const datepicker = flatpickr("#datepicker", {
                                dateFormat: "Y-m-d",
                                onChange: function (selectedDates, dateStr, instance) {
                                    // Handle date selection here if needed
                                    updateSelectedDateText(dateStr);
                                }
                            });

                            $('#calendarDropdown').on('show.bs.dropdown', function () {
                                // Open the flatpickr datepicker when the dropdown is shown
                                datepicker.open();
                            });

                            // Initialize Another Calendar
                            $('#anotherCalendar').fullCalendar({
                                header: {
                                    left: 'prev,next today',
                                    center: 'title',
                                    right: 'month,agendaWeek,agendaDay'
                                },
                                defaultView: 'month',
                                events: [
                                    {
                                        title: 'Event 1',
                                        start: '2024-02-01'
                                    },
                                    {
                                        title: 'Event 2',
                                        start: '2024-02-10'
                                    },
                                    // Add more events as needed
                                ],
                                dayClick: function (date) {
                                    // Update the flatpickr datepicker when a day is clicked
                                    datepicker.setDate(date.toDate());
                                    updateSelectedDateText(datepicker.input.value);
                                }
                            });

                            // Update the text in the calendar dates dropdown
                            function updateSelectedDateText(dateStr) {
                                // You can handle the selected date here if needed
                            }
                        });
                        </script>

                        <div class="topbar-divider d-none d-sm-block"></div>



                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-profile rounded-circle"
                                src="img/undraw_profile.svg">
                                <span class="mr-2 d-none ml-3 d-lg-inline text-600 small" style="color: #44A6F1; font-weight: bold;">Douglas McGee<br><span style="color: #59B568; font-weight: normal; margin-left: 15px;">Admin</span></span>

                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="login.php" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

<!-- JavaScript Functions -->
<script>
function userFunction() {
    // User section logic goes here
    console.log('User section clicked');
}

function notificationFunction() {
    // Notification section logic goes here
    console.log('Notification section clicked');
}

function dateFunction() {
    // Date section logic goes here
    console.log('Date section clicked');
}
</script>
<?php include('notification_logic2.php'); ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    