document.addEventListener("DOMContentLoaded", () => {
    const menuToggle = document.getElementById("menu-toggle");
    const sidebar = document.getElementById("sidebar");
  
    menuToggle.addEventListener("click", () => {
      // Toggle the sidebar's "open" class
      sidebar.classList.toggle("open");
  
      // Update the toggle button icon
      if (sidebar.classList.contains("open")) {
        menuToggle.innerHTML = '<i class="fas fa-times"></i>'; // Close icon
      } else {
        menuToggle.innerHTML = '<i class="fas fa-bars"></i>'; // Menu icon
      }
    });
  
    // Track chart instances
    let salesChartInstance, ordersChartInstance, pieChartInstance, growthChartInstance;
  
    // Read the data from the JSON script tag
    const chartDataElement = document.getElementById('chart-data');
    if (chartDataElement) {
      const chartData = JSON.parse(chartDataElement.textContent);
  

      // Sales Chart
      try {
        const salesCtx = document.getElementById("salesChart").getContext("2d");
        if (salesChartInstance) {
          salesChartInstance.destroy();
        }
        salesChartInstance = new Chart(salesCtx, {
          type: "line",
          data: {
            labels: chartData.salesChartData.labels,
            datasets: [{
              label: "Sales ($)",
              data: chartData.salesChartData.data,
              backgroundColor: "rgba(255, 204, 0, 0.2)",
              borderColor: "#000",
              borderWidth: 2,
            }],
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
      } catch (error) {
        console.error('Error initializing Sales Chart:', error);
      }
  
      // Orders Chart
      try {
        const ordersCtx = document.getElementById("ordersChart").getContext("2d");
        if (ordersChartInstance) {
          ordersChartInstance.destroy();
        }
        ordersChartInstance = new Chart(ordersCtx, {
          type: "bar",
          data: {
            labels: chartData.ordersChartData.labels,
            datasets: [{
              label: "Orders",
              data: chartData.ordersChartData.data,
              backgroundColor: "#ffcc00",
              borderColor: "#000",
              borderWidth: 1,
            }],
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
      } catch (error) {
        console.error('Error initializing Orders Chart:', error);
      }
  
      // Pie Chart
      try {
        const pieCtx = document.getElementById("pieChart").getContext("2d");
        if (pieChartInstance) {
          pieChartInstance.destroy();
        }
        pieChartInstance = new Chart(pieCtx, {
          type: "pie",
          data: {
            labels: chartData.pieChartData.labels,
            datasets: [{
              data: chartData.pieChartData.data,
              backgroundColor: ['#000', '#ffcc00', '#ffffff', 'rgba(255, 204, 0, 0.6)'],
              borderWidth: 1,
            }],
          },
          options: {
            responsive: true,
          },
        });
      } catch (error) {
        console.error('Error initializing Pie Chart:', error);
      }
      
  
      // Growth Chart
      try {
        const growthCtx = document.getElementById("growthChart").getContext("2d");
        if (growthChartInstance) {
          growthChartInstance.destroy();
        }
        growthChartInstance = new Chart(growthCtx, {
          type: "line",
          data: {
            labels: chartData.growthChartData.labels,
            datasets: [{
              label: "User Growth",
              data: chartData.growthChartData.data,
              borderColor: "rgba(75, 192, 192, 1)",
              borderWidth: 1,
              fill: false,
            }],
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
      } catch (error) {
        console.error('Error initializing Growth Chart:', error);
      }
    } else {
      console.error('Chart data element not found');
    }
  });