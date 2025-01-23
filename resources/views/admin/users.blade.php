<!-- filepath: /C:/xampp/htdocs/E_Shop/resources/views/admin/users.blade.php -->
@extends('layouts.admin')
<link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@section('title', 'Admin - Manage Users')

@section('content')
<div class="container">
    <header class="page-header">
        <h2>User Management</h2>
    </header>

    <!-- User Table Section -->
    <section class="users-table-section">
        <table class="users-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/users.js') }}"></script>
@endsection