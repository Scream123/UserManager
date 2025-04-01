@extends('layouts.app')
@section('content')
    <h1>Users List</h1>
    <table class="table" id="users-table">
        <button id="generate-token-btn" class="btn btn-success mb-3">Generate Token</button>
        <div id="token-message" class="alert alert-info d-none"></div>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <button id="load-more-btn" class="btn btn-primary">Show more
@endsection
