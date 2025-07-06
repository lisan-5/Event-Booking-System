@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Users</h1>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->getRoleNames()->first() ?? 'user' }}</td>
                <td>
                    <form action="{{ route('admin.users.assign-role', $user) }}" method="POST" class="form-inline">
                        @csrf
                        <select name="role" class="form-control form-control-sm mr-2">
                            <option value="user" {{ $user->hasRole('user') ? 'selected' : '' }}>User</option>
                            <option value="organizer" {{ $user->hasRole('organizer') ? 'selected' : '' }}>Organizer</option>
                            <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">Assign</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
