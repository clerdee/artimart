<form action="{{ route('users.update_status', $row->id) }}" method="POST">
    @csrf
    @method('PUT')
    <select name="status" class="form-select">
        <option value="Active" {{ $row->status == 'Active' ? 'selected' : '' }}>Active</option>
        <option value="Deactivated" {{ $row->status == 'Deactivated' ? 'selected' : '' }}>Deactivated</option>
    </select>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
