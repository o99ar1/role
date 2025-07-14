<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
</head>

<body>

    <ul>
        ROLES:
        @foreach($roles as $role)
        <li>{{$role->name}}</li>
        @endforeach
    </ul>

    <ul>
        Permissions:
        @foreach($permissions as $permission)
        <li>{{$permission->name}}</li>
        @endforeach
    </ul>
    --------------------------------------------------------------------
    <div>
        <h4>ADD ROLE & Permissions</h4>
        <form action="{{route('roles.store')}}" method="post" style="padding: 20px;">
            @csrf
            <label for="role">Role:</label>
            <br>
            <input type="text" name="role">
            <br><br>
            <label for="permission">Permission:</label>
            <br>
            <select name="permissions[]" id="permission" multiple>
                @foreach($permissions as $permission)
                <option value="{{$permission->name}}">{{$permission->name}}</option>
                @endforeach
            </select>
            <br><br>
            <button type="submit">Add</button>
        </form>
    </div>
    --------------------------------------------------------------------
    <h1>Users</h1>
    <ul>
        @foreach($users as $user)
        <li>{{$user->name}}</li>
        @endforeach
    </ul>
    <div>
        <h4>ADD User</h4>
        <form action="{{route('users.store')}}" method="post" style="padding: 20px;">
            @csrf
            <label for="name">Name:</label>
            <br>
            <input type="text" name="name">
            <br><br>
            <label for="email">email:</label>
            <br>
            <input type="email" name="email">
            <br><br>
            <label for="password">password:</label>
            <br>
            <input type="password" name="password">
            <br><br>
            <label for="password">password:</label>
            <br>
            <select name="role" id="role">
                @foreach($roles as $role)
                <option value="{{$role->name}}">{{$role->name}}</option>
                @endforeach
            </select>
            <br><br>
            <button type="submit">Add</button>
        </form>
    </div>
</body>

</html>
