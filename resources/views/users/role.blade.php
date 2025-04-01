<form action="{{ route('users.update', $row->id) }}" method="POST">
    @csrf
    @method('PUT')
    <select name ="role" class="form-select" aria-label="Default select example">
        <option value="user" {{ $row->role == 'User' ? 'selected' : '' }}>User</option>
        <option value="admin"  {{ $row->role == 'Admin' ? 'selected' : '' }}>Admin</option>
    </select><button type="submit" class="btn btn-primary" value="Submit">Update</button>
</form>

