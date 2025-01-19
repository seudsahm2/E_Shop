
// JavaScript to toggle the sidebar
const menuToggle = document.getElementById("menu-toggle");
const sidebar = document.getElementById("sidebar");

menuToggle.addEventListener("click", () => {
  sidebar.classList.toggle("open");
});

// Sales Chart
const salesCtx = document.getElementById("salesChart").getContext("2d");
new Chart(salesCtx, {
  type: "line",
  data: {
    labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
    datasets: [
      {
        label: "Sales ($)",
        data: [1200, 1500, 800, 1800, 2300],
        backgroundColor: "rgba(255, 204, 0, 0.2)",
        borderColor: "#000",
        borderWidth: 2,
      },
    ],
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
});

// Orders Chart
const ordersCtx = document.getElementById("ordersChart").getContext("2d");
new Chart(ordersCtx, {
  type: "bar",
  data: {
    labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
    datasets: [
      {
        label: "Orders",
        data: [50, 75, 60, 90, 100],
        backgroundColor: "#ffcc00",
        borderColor: "#000",
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
});

// Pie Chart
const pieCtx = document.getElementById("pieChart").getContext("2d");
new Chart(pieCtx, {
  type: "pie",
  data: {
    labels: ["Electronics", "Clothing", "Home Appliances", "Books"],
    datasets: [
      {
        data: [40, 30, 20, 10],
        backgroundColor: [
          "#000",
          "#ffcc00",
          "#ffffff",
          "rgba(255, 204, 0, 0.6)",
        ],
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true,
  },
});

// Growth Chart
const growthCtx = document.getElementById("growthChart").getContext("2d");
new Chart(growthCtx, {
  type: "line",
  data: {
    labels: ["January", "February", "March", "April", "May"],
    datasets: [
      {
        label: "User Growth",
        data: [50, 75, 150, 300, 450],
        backgroundColor: "rgba(255, 204, 0, 0.2)",
        borderColor: "#000",
        borderWidth: 2,
      },
    ],
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
});
