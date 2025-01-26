<!-- filepath: /C:/xampp/htdocs/E_Shop/resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>E_Shop Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <h3 class="text-center">E_Shop Admin</h3>
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            <a href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Products</a>
            <a href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart"></i> Orders</a>
            <a href="{{ route('admin.insights') }}"><i class="fas fa-chart-line"></i> Sales Insights</a>
            <a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> Users</a>
            <a href="{{ route('admin.notifications.index') }}">
                <i class="fas fa-bell"></i> Notifications
                <span id="notification-count" class="badge bg-danger"></span>
            </a>
        </div>

        <div class="container-fluid p-4">
            <button class="btn btn-light d-md-none" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin/dashboard.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/admin/notifications/count')
                .then(response => response.json())
                .then(data => {
                    if (data.count > 0) {
                        document.getElementById('notification-count').textContent = data.count;
                    }
                })
                .catch(error => {
                    console.error('Error fetching notification count:', error);
                });

                document.addEventListener('click', function(event) {
                if (event.target.classList.contains('mark-as-read')) {
                    var notificationId = event.target.getAttribute('data-id');
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', `/admin/notifications/${notificationId}/read`, true);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                event.target.parentElement.remove();
                                updateNotificationCount();
                            }
                        } else if (xhr.readyState === 4) {
                            console.error('Error marking notification as read:', xhr.responseText);
                        }
                    };

                    xhr.send();
                }
            });

            function updateNotificationCount() {
                fetch('/admin/notifications/count')
                    .then(response => response.json())
                    .then(data => {
                        var notificationCountElement = document.getElementById('notification-count');
                        if (data.count > 0) {
                            notificationCountElement.textContent = data.count;
                        } else {
                            notificationCountElement.textContent = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching notification count:', error);
                    });
            }
        });
    </script>
    @yield('scripts')
</body>

</html>