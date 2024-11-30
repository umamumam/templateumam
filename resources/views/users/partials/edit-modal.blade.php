<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="/users/{{ $user->id }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="userName{{ $user->id }}" class="form-label">Name</label>
                        <input type="text" class="form-control" id="userName{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail{{ $user->id }}" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="userRole{{ $user->id }}" class="form-label">Role</label>
                        <select class="form-control" name="role_id" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
