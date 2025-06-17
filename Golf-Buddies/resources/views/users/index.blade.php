<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
</head>
<body>
    <h1>All Users</h1>

    <a href="{{ route('users.create') }}">Create New User</a>

    <table border="1" cellpadding="5" cellspacing="0" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Zipcode</th>
                <th>Profile</th>
                <th>Handicap</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->zipcode }}</td>
                <td>{{ $user->profile }}</td>
                <td>{{ $user->handicap }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
