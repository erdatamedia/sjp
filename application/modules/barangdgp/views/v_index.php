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
			<div class="mb-5 mb-sm-0 text-end" style="margin-top:30px" id="filter-status">
				<a class="btn btn-sm btn-secondary me-2 mb-2" href="<?= base_url('assets/file/format_label.xlsx') ?>" download><i class="las la-file-download fs-2"></i>File</a>
			</div>
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
					<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">No.MC Label/ Sticker</label>
							<input type="text" name="no_mc" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="No.MC" />
						</div>
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Nama Produk Label</label>
							<input type="text" name="nama_produk" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="Nama Produk Label" />
						</div>
						<div class="fv-row mb-7">
							<label class="fw-bold fs-6 mb-2 required">Material</label>
							<select type="text" class="form-select id_material" required name="id_material" data-dropdown-parent="#modal_form"></select>
						</div>
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Ukuran Object</label>
							<input type="text" name="size" class="form-control form-control mb-3 mb-lg-0" required placeholder="Ukuran Object" />
						</div>
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

<div class="modal fade" id="modal_form_edit" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="kt_modal_add_user_header">
				<h2 class="fw-bolder">Edit</h2>
			</div>
			<div class="modal-body scroll-y mx-5 mx-xl-15">
				<form id="form_edit">
					<input type="hidden" name="id_barang_dgp">
					<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">No.MC Label/ Sticker</label>
							<input type="text" name="no_mc_edit" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="No.MC" />
						</div>
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Nama Produk Label</label>
							<input type="text" name="nama_produk_edit" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="Nama Produk Label" />
						</div>
						<div class="fv-row mb-7">
							<label class="fw-bold fs-6 mb-2 required">Material</label>
							<select type="text" class="form-select id_material_edit" required name="id_material_edit" data-dropdown-parent="#modal_form_edit"></select>
						</div>
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Ukuran Object</label>
							<input type="text" name="size_edit" class="form-control form-control mb-3 mb-lg-0" required placeholder="Ukuran Object" />
						</div>
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


<div class="modal fade" id="modal_form_import" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="kt_modal_add_user_header">
				<h2 class="fw-bolder">Import Barang Digital Printing</h2>
			</div>
			<div class="modal-body scroll-y mx-5 mx-xl-15">
				<form id="form_import">
					<div class="mb-3">
						<label for="formFile" class="form-label">File</label>
						<input class="form-control file_import" type="file" name="file" >
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

<div class="modal fade" id="modal_produk" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="kt_modal_add_user_header">
				<h2 class="fw-bolder">Product Digital Printing Information</h2>
			</div>
			<div class="modal-body">
				<div class="row mb-7">
					<label class="col-lg-4 fw-bold text-muted">No MC Label</label>
					<div class="col-lg-8">
						<span class="fw-bolder fs-6 text-gray-800 no_mc"></span>
					</div>
				</div>
				<div class="row mb-7">
					<label class="col-lg-4 fw-bold text-muted">Nama Produk</label>
					<div class="col-lg-8">
						<span class="fw-bolder fs-6 text-gray-800 nama_produk"></span>
					</div>
				</div>
				<div class="row mb-7">
					<label class="col-lg-4 fw-bold text-muted">Material</label>
					<div class="col-lg-8">
						<span class="fw-bolder fs-6 text-gray-800 material"></span>
					</div>
				</div>
				<div class="row mb-7">
					<label class="col-lg-4 fw-bold text-muted">Ukuran Produk</label>
					<div class="col-lg-8">
						<span class="fw-bolder fs-6 text-gray-800 size"></span>
					</div>
				</div>
				<div class="row mb-7">
					<div class="card card-dashed">
					    <div class="card-body">
					        <div id="image"></div>
					    </div>
				    
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
