
<!-- resources/views/users/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
</head>
<body>
    <h1>Create User</h1>
    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <label>Name</label><br>
        <input type="text" name="name"required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>


        <label>Username:</label><br>
        <input type="text" name="username" value="{{ old('username')}}" required><br><br>

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

