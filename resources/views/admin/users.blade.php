@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="row">
        
        
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-3">
                <h2 class="mb-4">Users List</h2>
                <a href="{{ route('users.create') }}" class="btn btn-success ">Add User</a>
            </div>

            @if(session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
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
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->user_type == 1 ? 'Admin' : 'User' }}</td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
