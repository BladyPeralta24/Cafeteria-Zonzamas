<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }
    table{
        width: 100%;
        font-size: 20px;
    }
</style>
<table>
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>email</th>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
            </tr>
        @endforeach
    </tr>
</table>
