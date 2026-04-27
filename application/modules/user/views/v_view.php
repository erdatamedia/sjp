
<div id="kt_content_container" class="container-xxl">
	<div class="card mb-5 mb-xl-10">
		<div class="card-header align-items-center" id="card-header">
			<div class="btn-group btn-group-sm my-2 my-sm-0">
				<a href="<?= base_url($module) ?>" class="btn btn-light btn-sm me-3"><i class="bi bi-chevron-left"></i></a>
			</div>

			<?php if ($x) { ?>
				<div class="btn-group btn-group-sm my-2 my-sm-0">
					<a href="<?= base_url($module.'/view/'.$prev) ?>" class="btn btn-light <?= $prev ? '' : 'disabled' ?>">Prev</a>
					<span class="btn border pe-none text-gray-600"><?= $i.' / '.$j ?></span>
					<a href="<?= base_url($module.'/view/'.$next) ?>" class="btn btn-light <?= $next ? '' : 'disabled' ?>">Next</a>
				</div>
			<?php } ?>
		</div>

		<div id="kt_account_settings_profile_details" class="collapse show">
			<form  class="form" method="post" action="<?= base_url('user/updateUser/'. $x['id']) ?>" enctype="multipart/form-data">
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
								<span onclick="removebg(<?= $x['id'] ?>)" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove Photo">
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
							<select type="text" required data-control="select2" class="form-select role-edit" name="id_role">
								<?php foreach ($role as $key => $item): ?>
									<option value="<?= $item['id'] ?>" <?= ($item['id'] == $x['id_role']) ? 'selected' : '' ?> ><?= $item['name']?></option>
								<?php endforeach ?>
							</select>
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
					<button type="submit" class="btn btn-primary" >Save Changes</button>
				</div>
			</form>
		</div>
	</div>
</div>
