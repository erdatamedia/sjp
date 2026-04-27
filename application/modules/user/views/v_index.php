<style>
.action-column .btn-icon,
.btn-icon.toggle {
  opacity: 0.35;
  transition: opacity 0.15s;
}
.action-column .btn-icon:hover,
.btn-icon.toggle:hover {
  opacity: 1;
}
</style>
<div class="container-fluid" id="kt_content_container">
	<div class="row g-5 g-xl-8">
	<div class="card mb-10 bg-body">
		<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
			id="table">
			<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
			<tbody class="fw-bold text-gray-800"></tbody>
		</table>
</div>
</div>
</div>


<div class="modal fade" id="modal_form" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="kt_modal_add_user_header">
				<h2 class="fw-bolder">Tambah</h2>
			</div>
			<div class="modal-body scroll-y mx-5 mx-xl-15">
				<form id="form">
					<div class="fv-row mb-7">
						<label class="required fw-bold fs-6 mb-2">Nama User</label>
						<input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="Nama User" />
					</div>
					<div class="fv-row mb-7">
						<label class="required fw-bold fs-6 mb-2">Email User</label>
						<input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="Email User" />
					</div>
					<div class="fv-row mb-7">
						<label class="required fw-bold fs-6 mb-2">Role User</label>
						<select type="text" required class="form-select role" name="role" data-dropdown-parent="#modal_form"></select>
					</div>
					<div class="fv-row mb-7">
						<label class="required fw-bold fs-6 mb-2">Password User</label>
						<input type="text" name="password" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="Password User" />
					</div>
					<div class="text-center pt-15">
						<button type="reset" class="btn btn-light me-3" onclick="reset()" data-bs-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_form_edit" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="kt_modal_add_user_header">
				<h2 class="fw-bolder">Ubah</h2>
			</div>
			<div class="modal-body scroll-y mx-5 mx-xl-15">
				<form id="form_edit">
					<input type="hidden" name="id" id="id-edit" />
					<div class="fv-row mb-7">
						<label class="required fw-bold fs-6 mb-2">Nama User</label>
						<input type="text" name="name-edit" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="Nama User" />
					</div>
					<div class="fv-row mb-7">
						<label class="required fw-bold fs-6 mb-2">Email User</label>
						<input type="email" name="email-edit" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="Email User" />
					</div>
					<div class="fv-row mb-7">
						<label class="required fw-bold fs-6 mb-2">Role User</label>
						<select type="text" required id="role-select"  class="form-select role-edit" name="role-edit" data-dropdown-parent="#modal_form_edit"></select>
					</div>
					<div class="fv-row mb-7">
						<label class="fw-bold fs-6 mb-2">Password User</label>
						<input type="text" name="password-edit" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Password User" />
					</div>
					<div class="text-center pt-15">
						<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
