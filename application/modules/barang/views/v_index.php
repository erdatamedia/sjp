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

				<div class="w-100 mw-300px d-none">
					<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-allow-clear="true" data-placeholder="All Status" id="status">
						<option value="">All Status</option>
						<option value="stok_total">Stok Total</option>
						<option value="stok_habis">Stok Habis</option>
						<option value="stok_tersisa">Stok Tersisa</option>
					</select>
				</div>
				<a class="btn btn-sm btn-secondary me-2 mb-2" href="<?= base_url('assets/file/format.xlsx') ?>" download><i class="las la-file-download fs-2"></i>File</a>
				<button class="btn btn-sm btn-secondary me-2 mb-2 text-dark">
					<img style="width: 30px; height: 30px; background-color: white; padding: 3px; border-radius: 8px;" src="<?= base_url('assets/media/icons/box.png')?>"/>
					ALL
					<span data-status="" class="count_all badge badge-circle badge-light-secondary ms-2 text-dark">.</span>
				</button>
				<button class="btn btn-sm btn-success me-2 mb-2 text-dark">
					<img style="width: 30px; height: 30px; background-color: white; padding: 3px; border-radius: 8px;" src="<?= base_url('assets/media/icons/ready-stock.png')?>"/>
					Available Stock Product
					<span data-status="stok_tersisa" class="count_sisa badge badge-circle badge-light-warning ms-2 text-dark">.</span>
				</button>
				<button class="btn btn-sm btn-danger me-2 mb-2 text-dark">
					<img style="width: 30px; height: 30px; background-color: white; padding: 3px; border-radius: 8px;" src="<?= base_url('assets/media/icons/out-of-stock.png')?>"/>
					Out of Stock Product
					<span data-status="stok_habis" class="count_habis badge badge-circle badge-light-warning ms-2 text-dark">.</span>
				</button>
				<button class="btn btn-sm btn-info me-2 mb-2 text-dark">
					<img style="width: 30px; height: 30px; background-color: white; padding: 3px; border-radius: 8px;" src="<?= base_url('assets/media/icons/product.png')?>"/>
					Total Stock Product
					<span data-status="stok_total" class="count_total badge badge-circle badge-light-warning ms-2 text-dark">.</span>
				</button>
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
							<label class="required fw-bold fs-6 mb-2">No.MC</label>
							<input type="text" name="no_mc" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="No.MC" />
						</div>
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Nama Produk</label>
							<input type="text" name="item_box" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="Nama Produk" />
						</div>
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Ukuran Produk</label>
							<input type="text" name="size" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="L x W x H" />
						</div>
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Model Produk</label>
							<select type="text" required class="form-select box" name="model_box" data-dropdown-parent="#modal_form"></select>
						</div>
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Joint</label>
							<select type="text" required class="form-select joint" name="joint" data-dropdown-parent="#modal_form"></select>
						</div>
						<div class="fv-row mb-7">
							<label class="fw-bold fs-6 mb-2 required">Cutting Board</label>
							<select type="text" class="form-select papan_pisau" required name="papan_pisau" data-dropdown-parent="#modal_form"></select>
						</div>
						
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Substance/Flute</label>
							<input type="text" name="substance" class="form-control form-control mb-3 mb-lg-0" required placeholder="Substance/Flute" />
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
					<input type="hidden" name="id" id="id-edit" />
					<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">No.MC</label>
							<input type="text" name="no_mc-edit" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="No.MC" />
						</div>
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Item Box</label>
							<input type="text" name="item_box-edit" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="Item Box" />
						</div>
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Size</label>
							<input type="text" name="size-edit" class="form-control form-control-solid mb-3 mb-lg-0" required placeholder="L x W x H" />
						</div>
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Model Box</label>
							<select type="text" required class="form-select box-edit" name="model_box-edit" data-dropdown-parent="#modal_form_edit"></select>
						</div>
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Joint</label>
							<select type="text" required class="form-select joint-edit" name="joint-edit" data-dropdown-parent="#modal_form_edit"></select>
						</div>
						<div class="fv-row mb-7">
							<label class=" fw-bold fs-6 mb-2">Cutting Board</label>
							<select type="text" class="form-select papan_pisau-edit" name="papan_pisau-edit" data-dropdown-parent="#modal_form_edit"></select>
						</div>
						
						<div class="fv-row mb-7">
							<label class="required fw-bold fs-6 mb-2">Substance/Flute</label>
							<input type="text" name="substance-edit" class="form-control form-control mb-3 mb-lg-0" required placeholder="Substance/Flute" />
						</div>
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


<div class="modal fade" id="modal_form_import" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="kt_modal_add_user_header">
				<h2 class="fw-bolder">Import Barang</h2>
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
