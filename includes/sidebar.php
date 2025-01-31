<br>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="index_admin.php?page=dashboard">
        <i class="mdi mdi-view-dashboard menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    
    <!-- Point of Sale -->
    <li class="nav-item">
      <a class="nav-link" href="index_admin.php?page=pos">
        <i class="mdi mdi-cash-register menu-icon"></i>
        <span class="menu-title">Point Of Sale</span>
      </a>
    </li>
    
    <!-- Order List -->
    <li class="nav-item">
      <a class="nav-link" href="index_admin.php?page=order">
        <i class="mdi mdi-clipboard-text menu-icon"></i>
        <span class="menu-title">Order List</span>
      </a>
    </li>
    
    <!-- Category List -->
    <li class="nav-item">
      <a class="nav-link" href="index_admin.php?page=category">
        <i class="mdi mdi-view-list menu-icon"></i>
        <span class="menu-title">Category List</span>
      </a>
    </li>
    
    <!-- Inventory List -->
    <li class="nav-item">
      <a class="nav-link" href="index_admin.php?page=inventory">
        <i class="mdi mdi-warehouse menu-icon"></i>
        <span class="menu-title">Inventory List</span>
      </a>
    </li>

    <li class="nav-item">
  <a class="nav-link" href="index_admin.php?page=supplier">
    <i class="mdi mdi-truck menu-icon"></i>
    <span class="menu-title">Supplier List</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="index_admin.php?page=customer">
    <i class="mdi mdi-account-group menu-icon"></i>
    <span class="menu-title">Customer List</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="index_admin.php?page=transaction">
    <i class="mdi mdi-swap-horizontal menu-icon"></i>
    <span class="menu-title">Transaction List</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="index_admin.php?page=employee">
    <i class="mdi mdi-account-tie menu-icon"></i>
    <span class="menu-title">Employee List</span>
  </a>
</li>





    <!-- Menu List -->
    <li class="nav-item">
      <a class="nav-link" href="index_admin.php?page=menu">
        <i class="mdi mdi-food menu-icon"></i>
        <span class="menu-title">Menu List</span>
      </a>
    </li>
    
    <!-- Reports -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="true" aria-controls="ui-basic">
        <i class="mdi mdi-chart-line menu-icon"></i>
        <span class="menu-title" style="font-weight: bold; font-size: 13px;">Reports</span>

        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column ">
          <li class="nav-item"> <a class="nav-link" href="index_admin.php?page=menu">Sales Report</a></li>
          <li class="nav-item"> <a class="nav-link" href="index_admin.php?page=menu">Analytical Report</a></li>
          <li class="nav-item"> <a class="nav-link" href="index_admin.php?page=menu">Historical Report</a></li>
        </ul>
      </div>
    </li>
    
    <!-- User List -->
    <li class="nav-item">
      <a class="nav-link" href="index_admin.php?page=users">
        <i class="mdi mdi-account-group menu-icon"></i>
        <span class="menu-title">User List</span>
      </a>
    </li>
    
    <!-- System Information -->
    <li class="nav-item">
      <a class="nav-link" href="index_admin.php?page=system_info">
        <i class="mdi mdi-information-outline menu-icon"></i>
        <span class="menu-title">System Information</span>
      </a>
    </li>
    
    <!-- Logout -->
    <li class="nav-item">
      <a class="nav-link" href="index_admin.php?page=logout">
        <i class="mdi mdi-logout menu-icon"></i>
        <span class="menu-title">Logout</span>
      </a>
    </li>
    
    

    <li class="nav-item" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%; text-align: center;">
      <div class="clock-wrapper" style="font-size: 29px; font-weight: bold; color: black; font-family: 'Arial', sans-serif; text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
        <span id="clockTime"></span>
      </div>
      <div class="date-wrapper" style="font-size: 16px; color: black; font-family: 'Arial', sans-serif; margin-top: 5px;">
        <span id="dateTime"></span>
      </div>
    </li>



  </ul>
</nav>

<style>

/* General styling for the nav item */
/* General styling for the nav item */
.nav-link {
    font-size: 16px; /* Increased font size for nav links */
}


.nav-link.clock-circle {
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    padding: 0;
    background: none;
    pointer-events: none; /* Disable clicking */
    cursor: default; /* Change the cursor to default */
}

/* Styling for the plain number clock */
.clock-wrapper {
    font-size: 24px; /* Adjust the font size as needed */
    font-weight: bold;
    color: black; /* Text color */
    font-family: 'Arial', sans-serif;
    text-shadow: 0 0 5px rgba(0, 0, 0, 0.5), /* Subtle shadow for contrast */
                 0 0 10px rgba(0, 0, 0, 0.3); 
}

/* Hover effect (optional, kept minimal) */
.clock-wrapper:hover {
    text-shadow: 0 0 7px rgba(0, 0, 0, 0.6); /* Slightly stronger shadow on hover */
}

/* Menu title styling */
.menu-title {
    font-size: 14px; /* Increased font size for menu titles */
}


</style>

<script>
function updateClock() {
    const clockElement = document.getElementById("clockTime");
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, "0");
    const minutes = now.getMinutes().toString().padStart(2, "0");
    const seconds = now.getSeconds().toString().padStart(2, "0");

    clockElement.textContent = `${hours}:${minutes}:${seconds}`;
}

// Update the clock every second
setInterval(updateClock, 1000);
updateClock(); // Initial call to display the time immediately

function updateClockAndDate() {
  const clockElement = document.getElementById("clockTime");
  const dateElement = document.getElementById("dateTime");

  const now = new Date();

  // Clock
  const hours = now.getHours().toString().padStart(2, "0");
  const minutes = now.getMinutes().toString().padStart(2, "0");
  const seconds = now.getSeconds().toString().padStart(2, "0");
  clockElement.textContent = `${hours}:${minutes}:${seconds}`;

  // Date
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const dateString = now.toLocaleDateString(undefined, options); // Uses local date format
  dateElement.textContent = dateString;
}

// Update every second
setInterval(updateClockAndDate, 1000);
updateClockAndDate(); // Initial call

</script>
