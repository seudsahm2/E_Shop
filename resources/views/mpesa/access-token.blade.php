<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Pesa Access Token</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>M-Pesa Access Token</h1>

        <!-- Display success or error messages -->
        @if(session('status') === 'success')
        <div class="alert alert-success">
            <strong>Access Token Generated Successfully!</strong>
            <p><strong>Token:</strong> {{ session('access_token') }}</p>
            <p><strong>Expires In:</strong> {{ session('expires_in') }} seconds</p>
        </div>
        @elseif(session('status') === 'error')
        <div class="alert alert-danger">
            <strong>Error:</strong> {{ session('message') }}
            @if(session('error'))
            <p><strong>Details:</strong> {{ json_encode(session('error')) }}</p>
            @endif
        </div>
        @endif

        <!-- Form to trigger token generation -->
        <form action="{{ route('mpesa.token.generate') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Generate Access Token</button>
        </form>
    </div>
</body>

</html>