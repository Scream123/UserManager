@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Create New User</h1>
        <div id="error-message" class="alert alert-danger" style="display: none;"></div>
        <div id="success-message" class="alert alert-success d-none"></div>
        <form id="create-user-form" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="position_id">Position</label>
                <select class="form-control" id="position_id" name="position_id" required>
                </select>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
