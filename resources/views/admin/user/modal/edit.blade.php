<!-- Modal -->
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">
                    Edit User <strong>({{ $user->username }})</strong>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-card text-start">
                        <div class="row g-3">
                            <!-- Username -->
                            <div class="col-md-6">
                                <label class="form-label">Username:</label>
                                <input type="text" class="form-control" name="username" value="{{ $user->username }}">
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label">Phone:</label>
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                            </div>

                            <!-- Role -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role:</label>
                                <select class="form-select" name="role_id" required>
                                    <option disabled value="">-- pilih role --</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Verified -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Verified status:</label>
                                <select class="form-select" name="verified" required>
                                    <option value="0" {{ !$user->verified ? 'selected' : '' }}>Non Verified</option>
                                    <option value="1" {{ $user->verified ? 'selected' : '' }}>Verified</option>
                                </select>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <label class="form-label">Password:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="passwordInput{{ $user->id }}" placeholder="Kosongkan jika tidak ganti">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('passwordInput{{ $user->id }}', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password_confirmation" id="passwordConfirm{{ $user->id }}" placeholder="Kosongkan jika tidak ganti">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('passwordConfirm{{ $user->id }}', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>


                            <!-- Foto Upload -->
                            <div class="col-md-6">
                                <label class="form-label">Profil Photo:</label>
                                <input type="file" class="form-control" name="foto">
                            </div>

                            <!-- Foto Preview -->
                            <div class="col-md-6">
                                <div class="user-profile text-center">
                                    @if($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}" alt="profile-img" class="rounded-pill avatar-130 img-fluid">
                                    @else
                                    <img src="./assets/images/avatars/01.png" alt="profile-img" class="rounded-pill avatar-130 img-fluid">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn rounded btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn rounded btn-secondary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector("i");
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }
</script>