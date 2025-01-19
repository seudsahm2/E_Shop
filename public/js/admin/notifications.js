// Function to mark a notification as read
function markAsRead(button) {
    // Change the background color of the notification card when marked as read
    const notificationCard = button.parentElement;
    notificationCard.style.backgroundColor = '#dcdcdc'; // Light gray color for read notifications
    button.innerText = 'Read';
    button.disabled = true; // Disable the button after marking it as read
}
