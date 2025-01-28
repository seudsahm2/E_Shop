@extends('layouts.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin/management.css') }}">
@section('content')

<div class="container">
    <h1>Manage Categories, Brands, and Colors</h1>

    @if(session('messages'))
    @if(session('messages.success'))
    <div class="alert alert-success">
        <ul>
            @foreach(session('messages.success') as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(session('messages.warning'))
    <div class="alert alert-warning">
        <ul>
            @foreach(session('messages.warning') as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @endif
    <form action="{{ route('admin.management.store') }}" method="POST">
        @csrf

        <!-- Category Name -->
        <div>
            <label for="category_name">Category Name:</label>
            <input type="text" id="category_name" name="category_name" placeholder="Enter category name">
        </div>

        <!-- Brand Name -->
        <div>
            <label for="brand_name">Brand Name:</label>
            <input type="text" id="brand_name" name="brand_name" placeholder="Enter brand name">
        </div>

        <!-- Colors Dropdown -->
        <div>
            <label for="color_name">Select Colors:</label>
            <select id="color_name" name="color_name[]" multiple>
                @php
                $colorMap = config('colors');
                @endphp
                @foreach ($colorMap as $hex => $name)
                <option value="{{ $hex }}:{{ $name }}" style="background-color: #{{ $hex }}; color: #fff;">
                    {{ $name }}
                </option>
                @endforeach
            </select>

            <small>Hold Ctrl (Windows) or Command (Mac) to select multiple colors.</small>
        </div>

        <!-- Submit Button -->
        <button type="submit">Add</button>
    </form>
</div>

@endsection