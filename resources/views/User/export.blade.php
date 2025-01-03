<table>
    <thead>
    <tr>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Department</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user as $index => $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                {{-- <td>{{ $user->roleid == 1 ? 'Super Admin' : 'Admin' }}</td> --}}
                <td>{{ $user->role ? $user->role->name : 'N/A' }}</td>
                <td>{{ $user->department->name ?? 'N/A' }}</td>
                <td>
            </tr>
    @endforeach
    </tbody>
</table>