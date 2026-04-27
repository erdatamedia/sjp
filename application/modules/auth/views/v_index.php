<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8" />
	<title>
		PT. SENTRAL ARTHA TRADEINDO
	</title>
	<meta name="description" content="Latest updates and statistic charts">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="assets/media/logos/logo8.png" />
	
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>
<body id="kt_body" class="bg-body">
	<div class="d-flex flex-column flex-root">
		<!--begin::Authentication - Sign-in -->
		<div class="d-flex flex-column flex-lg-row flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/dozzy-1/14.png)">
			<!--begin::Aside-->
			<div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative">
				<!--begin::Wrapper-->
				<div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px ">
					<!--begin::Content-->
					<div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
						<h1 class="fw-bolder" style="color: #986923;">Welcome to Production</h1>
						<a href="<?= base_url('auth') ?>" class="py-9 mb-5">
							<img alt="Logo" src="<?= base_url('assets/media/logos/SATI.png') ?>" class="h-100px" />
						</a>
					</div>
					<!--end::Content-->
					<!--begin::Illustration-->
					<div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"></div>
					<!--end::Illustration-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Aside-->
			<!--begin::Body-->
			<div class="d-flex flex-column flex-lg-row-fluid py-10">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid">
					<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
						<!-- 	<img alt="Logo" src="<?= base_url('assets/media/logos/logo_sbti.png') ?>" class="mb-12 w-250px " /> -->
						<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
							<h1 class="fw-bolder text-center" style="font-size:25px;color: #986923;">Sign In</h1>
							<form class="form w-100" novalidate="novalidate" action="<?= base_url('auth/login') ?>" method="post">
								<div class="fv-row mb-10">
									<label class="form-label fs-6 fw-bolder text-dark">Email</label>
									<input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" value="<?= $this->session->flashdata('email') ?>" />
								</div>
								<div class="fv-row mb-10" data-kt-password-meter="true">
									<label class="form-label fs-6 fw-bolder text-dark">Password</label>
									<div class="position-relative mb-3">

										<input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" required minlength="8" />
										<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
											<i class="bi bi-eye-slash fs-2"></i>
											<i class="bi bi-eye fs-2 d-none"></i>
										</span>
										<div class="d-flex d-none align-items-center mb-3" data-kt-password-meter-control="highlight">
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
										</div>
									</div>
								</div>
								<div class="text-center">
									<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
										<span class="indicator-label">
											Continue
										</span>
										<span class="indicator-progress">
											Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
										</span>
									</button>
									<?php if ($this->session->flashdata('error_msg')) { ?>
										<div class="m-alert m-alert--outline alert alert-danger alert-dismissible" role="alert">
											<span><?= $this->session->flashdata('error_msg'); ?></span>
										</div>
										<?php $this->session->set_flashdata('error_msg', ''); ?>
									<?php } ?>
								</div>
							</form>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
	<script src="<?= base_url('assets/plugins/global/plugins.bundle.js')?>" ></script>
	<script src="<?= base_url('assets/js/scripts.bundle.js')?>"></script>
	<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
	<script type="text/javascript">
		var button = document.querySelector("#kt_sign_in_submit");
		button.addEventListener("click", function() {
			button.setAttribute("data-kt-indicator", "on");
		});

		var pusher = new Pusher('4d33ba8d1be6bb870f00', {
		    cluster: 'ap1',
		    encrypted: true
		});

		pusher.unsubscribe('real-dashboard');
		for (let i = 1; i <= 10; i++) {
		    pusher.unsubscribe(i + '-role');
		}
		pusher.disconnect();

	</script>
</body>
</html>
