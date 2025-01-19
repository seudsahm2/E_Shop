<div class="container">
    <h2>Register M-Pesa URL</h2>

    <!-- Display any messages -->
    @if(session('status'))
    <div class="alert alert-{{ session('status') }}">
        {{ session('message') }}
    </div>
    @endif

    <!-- Form to register URL -->
    <form action="{{ route('mpesa.register-url') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="ShortCode">ShortCode</label>
            <input type="text" name="ShortCode" id="ShortCode" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="ResponseType">Response Type</label>
            <input type="text" name="ResponseType" id="ResponseType" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="CommandID">Command ID</label>
            <input type="text" name="CommandID" id="CommandID" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="ConfirmationURL">Confirmation URL:</label>
            <input type="url" name="ConfirmationURL" value="{{ old('ConfirmationURL', config('mpesa.confirmation_url')) }}" required>
        </div>

        <div class="form-group">
            <label for="ValidationURL">Validation URL:</label>
            <input type="url" name="ValidationURL" value="{{ old('ValidationURL', config('mpesa.validation_url')) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Generate URL</button>
    </form>
</div>