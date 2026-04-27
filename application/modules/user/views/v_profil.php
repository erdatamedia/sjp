
<div id="kt_content_container" class="container-xxl">
	<div class="card mb-5 mb-xl-10">
		<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
			<div class="card-title m-0">
				<h3 class="fw-bold m-0">Profile Details</h3>
			</div>
		</div>
		<div id="kt_account_settings_profile_details" class="collapse show">
			<form  class="form" method="post" action="<?= base_url('user/update/'. $x['id']) ?>" enctype="multipart/form-data">
				<div class="card-body border-top p-9">
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-semibold fs-6">Photo</label>
						<div class="col-lg-8">
							<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
								<div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?= $x['image']? base_url('assets/uploads/profil/' . $x['image']) : $blank_user ?>)"></div>
								<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change Photo">
									<i class="bi bi-pencil-fill fs-7"></i>
									<input type="file" name="image" accept=".png, .jpg, .jpeg" />
									<input type="hidden" name="avatar_remove" />
								</label>
								<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
									<i class="bi bi-x fs-2"></i>
								</span>
								<span onclick="removebg(<?= $x['id'] ?>)" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
									<i class="bi bi-x fs-2"></i>
								</span>
							</div>
							<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
							<div>
								<a data-fslightbox="lightbox-basic" href="<?= base_url('assets/uploads/profil/'.$x['image']) ?>">View</a>
							</div>
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>
						<div class="col-lg-8 fv-row">
							<input type="text" name="name" class="form-control form-control-lg form-control-solid" required placeholder="Full Name" value="<?= $x['name']? $x['name'] : '' ?>" />
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
						<div class="col-lg-8 fv-row">
							<input type="email" name="email" class="form-control form-control-lg form-control-solid" required placeholder="Email" value="<?= $x['email']? $x['email'] : '' ?>" />
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-semibold fs-6">
							<span class="required">Role</span>
						</label>
						<div class="col-lg-8 fv-row">
							<input type="hidden" name="id_role" value="<?= $x['id_role'] ?>">
							<input type="email" readonly class="form-control form-control-lg form-control-solid" required placeholder="Role" value="<?= $x['role']? $x['role'] : '' ?>" />
						</div>
					</div>
					<div class="row mb-6">
						<label class="col-lg-4 col-form-label fw-semibold fs-6">
							<span>Password</span>
							<i class="bi bi-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Password Tidak Wajib"></i>
						</label>
						<div class="col-lg-8 fv-row" data-kt-password-meter="true">
							<div class="position-relative mb-3">
								<input class="form-control form-control-lg form-control-solid" type="password" name="password"  />
								<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
									<i class="bi bi-eye-slash fs-2"></i>
									<i class="bi bi-eye fs-2 d-none"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer d-flex justify-content-end py-6 px-9">
					<button type="submit" class="btn btn-primary" >Simpan Perubahan</button>
				</div>
			</form>
		</div>
	</div>
</div>
