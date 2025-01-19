
<div class="container">
    <h2>URL Registration Result</h2>

    @if($status == 'success')
    <div class="alert alert-success">
        {{ $message }}
    </div>
    <pre>{{ print_r($data, true) }}</pre>
    @else
    <div class="alert alert-danger">
        {{ $message }}
    </div>
    
    @endif
</div>
