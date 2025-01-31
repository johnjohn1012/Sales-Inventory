<div class="order-container">
  <h2>List of Orders</h2>

  <!-- Controls -->
  <div class="order-controls">
    <div>
      <label for="entries">Show</label>
      <select id="entries" onchange="updateOrderPagination()">
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
      </select>
      entries
    </div>
    <div>
      <input type="text" id="searchOrder" placeholder="Search..." oninput="filterOrders()">
    </div>
  </div>

  <!-- Order Table -->
  <table class="order-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Date Ordered</th>
        <th>Order ID</th>
        <th>Customer Name</th>
        <th>Total Items</th>
        <th>Total Price</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="orderList">
      <!-- Rows will be generated dynamically -->
    </tbody>
  </table>

  <!-- Pagination -->
  <div class="pagination">
    <p id="orderPaginationInfo"></p>
    <div id="orderPaginationControls" class="pagination-controls"></div>
  </div>
</div>

<style>
.order-container {
  font-family: Arial, sans-serif;
  margin: 20px;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h2 {
  margin-bottom: 20px;
}

.order-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.order-controls input {
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.order-table {
  width: 100%;
  border-collapse: collapse;
}

.order-table th,
.order-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.order-table th {
  background-color: #f2f2f2;
}

.order-table tr:nth-child(even) {
  background-color: #f9f9f9;
}

.order-table tr:hover {
  background-color: #f1f1f1;
}

.status {
  display: inline-block;
  padding: 5px 10px;
  border-radius: 12px;
  font-size: 12px;
}

.status.completed {
  background-color: #28a745;
  color: white;
}

.status.pending {
  background-color: #ffc107;
  color: black;
}

.status.canceled {
  background-color: #dc3545;
  color: white;
}

.pagination {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 10px;
}

.pagination-controls button {
  padding: 5px 10px;
  border: 1px solid #ccc;
  background-color: white;
  cursor: pointer;
  margin-right: 5px;
}

.pagination-controls button.active {
  background-color: #007bff;
  color: white;
}

.pagination-controls button:disabled {
  cursor: not-allowed;
  color: #ccc;
}
</style>

<script>
const orders = [
  {
    id: 1,
    date: "2024-11-26 10:35",
    orderId: "ORD-1001",
    customerName: "John Doe",
    totalItems: 3,
    totalPrice: 450.0,
    status: "Completed",
  },
  {
    id: 2,
    date: "2024-11-26 11:00",
    orderId: "ORD-1002",
    customerName: "Jane Smith",
    totalItems: 5,
    totalPrice: 675.0,
    status: "Pending",
  },
  {
    id: 3,
    date: "2024-11-27 12:15",
    orderId: "ORD-1003",
    customerName: "Mike Ross",
    totalItems: 2,
    totalPrice: 200.0,
    status: "Canceled",
  },
  // Add more orders as needed
];

let currentOrderPage = 1;
let rowsPerOrderPage = 10;

function displayOrders() {
  const orderList = document.getElementById("orderList");
  orderList.innerHTML = "";
  const start = (currentOrderPage - 1) * rowsPerOrderPage;
  const end = start + rowsPerOrderPage;
  const paginatedOrders = orders.slice(start, end);

  paginatedOrders.forEach((order) => {
    const row = `
      <tr>
        <td>${order.id}</td>
        <td>${order.date}</td>
        <td>${order.orderId}</td>
        <td>${order.customerName}</td>
        <td>${order.totalItems}</td>
        <td>${order.totalPrice.toFixed(2)}</td>
        <td><span class="status ${order.status.toLowerCase()}">${order.status}</span></td>
        <td>
          <select>
            <option value="">Action</option>
            <option value="view">View</option>
            <option value="cancel">Cancel</option>
          </select>
        </td>
      </tr>
    `;
    orderList.innerHTML += row;
  });

  updateOrderPaginationInfo();
}

function updateOrderPaginationInfo() {
  const paginationInfo = document.getElementById("orderPaginationInfo");
  const totalEntries = orders.length;
  const start = (currentOrderPage - 1) * rowsPerOrderPage + 1;
  const end = Math.min(start + rowsPerOrderPage - 1, totalEntries);

  paginationInfo.textContent = `Showing ${start} to ${end} of ${totalEntries} entries`;

  const paginationControls = document.getElementById("orderPaginationControls");
  paginationControls.innerHTML = "";

  const totalPages = Math.ceil(totalEntries / rowsPerOrderPage);

  for (let i = 1; i <= totalPages; i++) {
    const button = document.createElement("button");
    button.textContent = i;
    button.className = i === currentOrderPage ? "active" : "";
    button.onclick = () => {
      currentOrderPage = i;
      displayOrders();
    };
    paginationControls.appendChild(button);
  }
}

function filterOrders() {
  const query = document.getElementById("searchOrder").value.toLowerCase();
  const filteredOrders = orders.filter((order) =>
    order.customerName.toLowerCase().includes(query)
  );

  displayOrders(filteredOrders);
}

function updateOrderPagination() {
  rowsPerOrderPage = parseInt(document.getElementById("entries").value);
  currentOrderPage = 1;
  displayOrders();
}

document.addEventListener("DOMContentLoaded", () => {
  displayOrders();
});
</script>