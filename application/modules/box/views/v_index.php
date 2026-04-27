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
				<h2 class="fw-bolder">Create</h2>
			</div>
			<div class="modal-body scroll-y mx-5 mx-xl-15">
				<form id="form">
					<div class="fv-row mb-7">
						<label class="required fw-bold fs-6 mb-2">Nama Box</label>
						<input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="Nama Box" />
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
				<h2 class="fw-bolder">Edit</h2>
			</div>
			<div class="modal-body scroll-y mx-5 mx-xl-15">
				<form id="form_edit">
					<input type="hidden" name="id" id="id-edit" />
					<div class="fv-row mb-7">
						<label class="required fw-bold fs-6 mb-2">Nama Box</label>
						<input type="text" name="name" id="name-edit" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="Nama Box" />
					</div>
					<div class="text-center pt-15">
						<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
