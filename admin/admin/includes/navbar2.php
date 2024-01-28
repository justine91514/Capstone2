<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Pharmacy App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    #accordionSidebar {
        width: 250px;
        border-right: 1px solid #ccc;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .nav-item.active {
        background-color: black !important;
    }

    .nav-item.active span,
    .nav-item.active i {
        color: white !important;
    }

    #inventory-tab #collapseTwo .collapse-inner a:hover,
    #settings-tab #collapseUtilities .collapse-inner a:hover {
        background-color: lightgray !important;
    }

    .sidebar-brand-icon {
            margin-top: 40px; /* Adjust the margin-top value according to your preference */
        }
</style>

</head>
<body>


<ul class="navbar-nav bg-white sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
        <img src="img/3GMED.png" alt="Pharmacy Logo" style="width: 159; height: 90px;">
        </div>
    </a>

    <div style="height: 45px;"></div>

    <hr class="sidebar-divider my-0">

    <li class="nav-item" id="dashboard-tab">
        <a class="nav-link" href="index.php" onclick="toggleTab('dashboard-tab')">
            <i class="fas fa-home" style="color: black;"></i>
            <span style="color: black;">Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider my-0">

    <li class="nav-item" id="inventory-tab">
        <a class="nav-link collapsed" href="#collapseTwo" data-toggle="collapse" onclick="toggleTab('inventory-tab')">
            <i class="fas fa-box" style="color: black;"></i>
            <span style="color: black;">Inventory</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="add_stocks.php" onclick="toggleTab('inventory-tab')">Add Stocks</a>
                <a class="collapse-item" href="buffer_stock.php" onclick="toggleTab('inventory-tab')">Buffer Stock</a>
                <a class="collapse-item" href="#" onclick="toggleTab('inventory-tab')">Expired Products</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider my-0">

    <li class="nav-item" id="sales-report-tab">
        <a class="nav-link" href="register.php" onclick="toggleTab('sales-report-tab')">
            <i class="fas fa-fw fa-chart-area" style="color: black;"></i>
            <span style="color: black;">Sales Report</span>
        </a>
    </li>

    <hr class="sidebar-divider my-0">

    <li class="nav-item" id="transaction-history-tab">
        <a class="nav-link" href="register.php" onclick="toggleTab('transaction-history-tab')">
            <i class="fas fa-history" style="color: black;"></i>
            <span style="color: black;">Transaction History</span>
        </a>
    </li>

    <div style="height: 250px;"></div>

    <li class="nav-item" id="settings-tab">
        <a class="nav-link collapsed" href="#collapseUtilities" data-toggle="collapse" onclick="toggleTab('settings-tab')">
            <i class="fas fa-cogs" style="color: black;"></i>
            <span style="color: black;">Settings</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="add_category.php" onclick="toggleTab('settings-tab')">Add Category</a>
                <a class="collapse-item" href="add_product_type.php" onclick="toggleTab('settings-tab')">Add type</a>
                <a class="collapse-item" href="product.php" onclick="toggleTab('settings-tab')">Create Product</a>
                <a class="collapse-item" href="#" onclick="toggleTab('settings-tab')">Discount</a>
                <a class="collapse-item" href="#" onclick="toggleTab('settings-tab')">Supplier List</a>
                <a class="collapse-item" href="#" onclick="toggleTab('settings-tab')">Product List</a>
                <a class="collapse-item" href="register.php" onclick="toggleTab('settings-tab')">User Management</a>
                <a class="collapse-item" href="#" onclick="toggleTab('settings-tab')">Back-up and Restore</a>
                <a class="collapse-item" href="archive.php" onclick="toggleTab('settings-tab')">Archive</a>
            </div>
        </div>
    </li>
</ul>

<!-- Include Bootstrap JS script -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyL/JYb6Ze72LATIcunF1+OfwGgmkHQs6"
        crossorigin="anonymous"></script>

<script>
    // Function to toggle active tab and store in sessionStorage
    function toggleTab(tabId) {
        var selectedTab = document.getElementById(tabId);
        var allTabs = document.querySelectorAll('.nav-item');

        allTabs.forEach(function (tab) {
            if (tab.id === tabId) {
                tab.classList.add('active');
            } else {
                tab.classList.remove('active');
            }
        });

        sessionStorage.setItem('activeTab', tabId);
    }

    // Function to set active tab based on sessionStorage
    function setActiveTab() {
        var activeTabId = sessionStorage.getItem('activeTab');
        if (activeTabId) {
            toggleTab(activeTabId);
        }
    }

    // Set active tab when the page loads
    document.addEventListener("DOMContentLoaded", setActiveTab);
</script>

</body>
</html>