@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>User Details</h1>
        <div id="user-error" class="alert alert-danger" style="display: none;">
            Error loading user data!
        </div>

        <div class="card">
            <div class="card-header">
                <h3 id="user-name">Loading...</h3>
            </div>
            <div class="card-body" style="display: none;">
                <p><strong>ID:</strong> <span id="user-id"></span></p>
                <p><strong>Email:</strong> <span id="user-email"></span></p>
                <p><strong>Phone:</strong> <span id="user-phone"></span></p>
                <p><strong>Position:</strong> <span id="user-position"></span></p>
                <p><strong>Photo:</strong></p>
                <img id="user-photo" src="" alt="User Photo" style="width: 150px; height: 150px; object-fit: cover;">
            </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users List</a>
            </div>
        </div>
    </div>
@endsection
