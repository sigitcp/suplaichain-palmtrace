<!-- Modal -->
<div class="modal fade" id="userAddModal" tabindex="-1" aria-labelledby="userAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- tambahkan modal-lg -->
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="userAddModalLabel">Tambah User Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <fieldset>
          <div class="form-card text-start">
            <div class="row g-3"> <!-- pakai g-3 biar jarak antar field rapi -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Email: <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" name="email" placeholder="Email Id">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Username: <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="uname" placeholder="UserName">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Password: <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" name="pwd" placeholder="Password">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Confirm Password: <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" name="cpwd" placeholder="Confirm Password">
                </div>
              </div>
              <div class="col-md-12">
              <div class="form-group mb-0">
                <label class="form-label">Profil Photo:</label>
                <input type="file" class="form-control" aria-label="file example" required="">
                <div class="invalid-feedback">Example invalid form file feedback</div>
              </div>
              </div>
            </div>
          </div>
        </fieldset>
      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button type="button" class="btn rounded btn-danger" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn rounded btn-secondary">Simpan</button>
      </div>
    </div>
  </div>
</div>