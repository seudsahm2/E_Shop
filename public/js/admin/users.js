// Function to handle editing a user
function editUser(userId) {
    alert("Editing user with ID: " + userId);
}

// Function to handle deleting a user
function deleteUser(userId) {
    if (confirm("Are you sure you want to delete user with ID: " + userId + "?")) {
        alert("User with ID " + userId + " has been deleted.");
    }
}

// Function to handle adding a new user
function addUser() {
    alert("Redirecting to add new user form...");
}
