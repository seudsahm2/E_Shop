// Function to refresh the sales graph
function refreshGraph() {
    alert("Refreshing the sales graph...");
}

// Function to handle editing a sales record (example)
function editSalesRecord(productId) {
    alert("Editing sales record for product ID: " + productId);
}

// Function to handle deleting a sales record (example)
function deleteSalesRecord(productId) {
    if (confirm("Are you sure you want to delete the sales record for product ID: " + productId + "?")) {
        alert("Sales record for product ID " + productId + " has been deleted.");
    }
}
