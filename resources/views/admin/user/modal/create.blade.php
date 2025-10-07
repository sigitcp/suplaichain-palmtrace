<!-- Modal -->
<div class="modal fade" id="userAddModal" tabindex="-1" aria-labelledby="userAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- tambahkan modal-lg -->
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="userAddModalLabel">Tambah User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-card text-start">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Username: <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Phone:</label>
                <input type="text" name="phone" class="form-control">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Role: <span class="text-danger">*</span></label>
                <select class="form-select" name="role_id" required>
                  <option selected disabled value="">Pilih Role</option>
                  @foreach($roles as $role)
                  <option value="{{ $role->id }}">{{ $role->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
              <input type="hidden" name="verified" value="0">
              </div>

              <div class="col-md-6">
                <label class="form-label">Password: <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Confirm Password: <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" required>
              </div>

              <div class="col-md-12">
                <label class="form-label">Profil Photo:</label>
                <input type="file" name="foto" class="form-control">
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn rounded btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn rounded btn-secondary">Simpan</button>
          </div>
        </form>

      </div>


    </div>
  </div>
</div>