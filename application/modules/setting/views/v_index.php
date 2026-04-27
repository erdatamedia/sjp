<style type="text/css">
	.ql-container {
		height: auto;
	}
</style>
<div class="container-fluid" id="kt_content_container">
	<div class="card mb-5">
		<div class="card-header border-0 collapsible cursor-pointer collapsed" role="button" data-bs-toggle="collapse" data-bs-target="#card_company" aria-expanded="true" aria-controls="card_company">
			<div class="card-title m-0">
				<h3 class="fw-bolder m-0">Company Setting</h3>
			</div>
			<div class="card-toolbar rotate-180">
				<span class="svg-icon svg-icon-1">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="black"></rect>
						<path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="black"></path>
					</svg>
				</span>
			</div>
		</div>
		<div id="card_company" class="collapse">
			<form class="form" action="<?= base_url('setting/save') ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?= $setting ? $setting['id'] : '' ?>" />
				<div class="card-body border-top p-9">
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-bold fs-6">Logo</label>
						<div class="col-lg-8">
							<div class="image-input image-input-empty image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
								<div class="image-input-wrapper w-125px h-125px" style="background-image: url('<?= $setting ? base_url('assets/uploads/company/'.$setting['logo']) : '' ?>')"></div>
								<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
									<i class="bi bi-pencil-fill fs-7"></i>
									<input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
									<input type="hidden" name="avatar_remove" />
								</label>
								<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
									<i class="bi bi-x fs-2"></i>
								</span>
								<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
									<i class="bi bi-x fs-2"></i>
								</span>
							</div>
							<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label required fw-bold fs-6">Company Name</label>
						<div class="col-lg-8 fv-row">
							<input type="text" name="company" class="form-control" placeholder="Company name" value="<?= $setting ? $setting['company'] : '' ?>" />
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-bold fs-6">
							<span class="required">Contact Phone</span>
							<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i>
						</label>
						<div class="col-lg-8 fv-row">
							<input type="tel" name="phone" class="form-control" placeholder="Phone number" value="<?= $setting ? $setting['phone'] : '' ?>" />
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-bold fs-6">
							<span class="required">Company Email</span>
							<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Email must be valid and active"></i>
						</label>
						<div class="col-lg-8 fv-row">
							<input type="tel" name="email" class="form-control" placeholder="Company Email" value="<?= $setting ? $setting['email'] : '' ?>" />
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-bold fs-6">Company Site</label>
						<div class="col-lg-8 fv-row">
							<input type="text" name="website" class="form-control" placeholder="Company website" value="<?= $setting ? $setting['website'] : '' ?>" />
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-bold fs-6">Address</label>
						<div class="col-lg-8 fv-row">
							<textarea name="address" class="form-control" placeholder="Company Address"><?= $setting ? $setting['address'] : '' ?></textarea>
						</div>
					</div>
				</div>
				<div class="card-footer d-flex justify-content-end py-6 px-9">
					<button type="reset" class="btn btn-light btn-active-light-primary me-2">Batal</button>
					<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Simpan Perubahan</button>
				</div>
			</form>
		</div>
	</div>
	<div class="card mb-5">
		<div class="card-header border-0 collapsible cursor-pointer collapsed" role="button" data-bs-toggle="collapse" data-bs-target="#card_styling" aria-expanded="true" aria-controls="card_styling">
			<div class="card-title m-0">
				<h3 class="fw-bolder m-0">Web Styling (for light only)</h3>
			</div>
			<div class="card-toolbar rotate-180">
				<span class="svg-icon svg-icon-1">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="black"></rect>
						<path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="black"></path>
					</svg>
				</span>
			</div>
		</div>
		<div id="card_styling" class="collapse">
			<form class="form" action="<?= base_url('setting/style') ?>" method="post">
				<div class="card-body border-top p-9">
				<input type="hidden" name="id" value="<?= $setting ? $setting['id'] : '' ?>" />
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label required fw-bold fs-6">Navbar Color</label>
						<div class="col-lg-8 fv-row">
							<div class="input-group mb-5">
								<input name="color_navbar" type="color" class="form-control form-control-lg form-control-solid" placeholder="Color" aria-label="Color" value="<?= $setting['color_navbar']  ?>">
								<input name="color_navbar_hex" type="text" class="form-control" placeholder="Hex" aria-label="Hex" value="<?= $setting['color_navbar']  ?>">
								<span class="input-group-text cursor-pointer" id="color_navbar_reset"><i class="fa fa-sync-alt"></i></span>
							</div>
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label required fw-bold fs-6">Menu Text Color</label>
						<div class="col-lg-8 fv-row">
							<div class="input-group mb-5">
								<input name="color_text" type="color" class="form-control form-control-lg form-control-solid" placeholder="Color" aria-label="Color" value="<?= $setting['color_text']  ?>">
								<input name="color_text_hex" type="text" class="form-control" placeholder="Hex" aria-label="Hex" value="<?= $setting['color_text']  ?>">
								<span class="input-group-text cursor-pointer" id="color_text_reset"><i class="fa fa-sync-alt"></i></span>
							</div>
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label required fw-bold fs-6">Menu Icon Color</label>
						<div class="col-lg-8 fv-row">
							<div class="input-group mb-5">
								<input name="color_icon" type="color" class="form-control form-control-lg form-control-solid" placeholder="Color" aria-label="Color" value="<?= $setting['color_icon']  ?>">
								<input name="color_icon_hex" type="text" class="form-control" placeholder="Hex" aria-label="Hex" value="<?= $setting['color_icon']  ?>">
								<span class="input-group-text cursor-pointer" id="color_icon_reset"><i class="fa fa-sync-alt"></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer d-flex justify-content-end py-6 px-9">
					<button type="reset" class="btn btn-light btn-active-light-primary me-2">Batal</button>
					<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Simpan Perubahan</button>
				</div>
			</form>
		</div>
	</div>

	<div class="card mb-10">
		<div class="card-header border-0 collapsible cursor-pointer collapsed" role="button" data-bs-toggle="collapse" data-bs-target="#card_spk" aria-expanded="true" aria-controls="card_spk">
			<div class="card-title m-0">
				<h3 class="fw-bolder m-0">SPK Setting</h3>
			</div>
			<div class="card-toolbar rotate-180">
				<span class="svg-icon svg-icon-1">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="black"></rect>
						<path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="black"></path>
					</svg>
				</span>
			</div>
		</div>
		<div id="card_spk" class="collapse">
				<form class="form" action="<?= base_url('setting/spkSetting') ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?= $setting ? $setting['id'] : '' ?>" />
				<div class="card-body border-top p-9">
					
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-bold fs-6">Cutting</label>
						<div class="col-lg-8 fv-row">
							<input type="text" name="nama_dibuat" class="form-control" placeholder="Cutting" value="<?= $setting ? $setting['nama_dibuat'] : '' ?>" />
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-bold fs-6">
							<span >Printing</span>
						</label>
						<div class="col-lg-8 fv-row">
							<input type="text" name="nama_periksa" class="form-control" placeholder="Printing" value="<?= $setting ? $setting['nama_periksa'] : '' ?>" />
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-bold fs-6">
							<span >Kepala Bagian Gudang</span>
						</label>
						<div class="col-lg-8 fv-row">
							<input type="text" name="nama_disetujui" class="form-control" placeholder="Kepala Bagian Gudang" value="<?= $setting ? $setting['nama_disetujui'] : '' ?>" />
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-bold fs-6">Finishing</label>
						<div class="col-lg-8 fv-row">
							<input type="text" name="nama_periksa" class="form-control" placeholder="Finishing" value="<?= $setting ? $setting['nama_periksa'] : '' ?>" />
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-bold fs-6">Kepala Bagian Produksi</label>
						<div class="col-lg-8 fv-row">
							<input type="text" name="nama_pengawas" class="form-control" placeholder="Kepala Bagian Produksi" value="<?= $setting ? $setting['nama_pengawas'] : '' ?>" />
						</div>
					</div>
					
				</div>
				<div class="card-footer d-flex justify-content-end py-6 px-9">
					<button type="reset" class="btn btn-light btn-active-light-primary me-2">Batal</button>
					<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Simpan Perubahan</button>
				</div>
			</form>
		</div>
	</div>
</div>
