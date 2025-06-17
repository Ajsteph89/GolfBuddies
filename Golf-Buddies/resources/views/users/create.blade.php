
<!-- resources/views/users/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
</head>
<body>
    <h1>Create User</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Zipcode:</label><br>
        <input type="text" name="zipcode" required><br><br>

        <label>Profile:</label><br>
        <textarea name="profile"></textarea><br><br>

        <label>Handicap:</label><br>
        <input type="number" name="handicap" step="0.1"><br><br>

        <button type="submit">Create User</button>
    </form>
</body>
</html>

