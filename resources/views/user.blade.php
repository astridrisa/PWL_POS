<!DOCTYPE html>
<html>
    <head>
        <title>Data User</title>
    </head>
    <body>
        <h1>Data User</h1>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>Jumlah Pengguna</th>
                {{-- <th>ID</th>
                <th>Usernama</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th> --}}
            </tr>
            <tr>
                <td>{{ count($data) }}</td>
                {{-- <td>{{ $user->user_id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->level_id }}</td> --}}
            </tr>
        </table>
    </body>
</html>