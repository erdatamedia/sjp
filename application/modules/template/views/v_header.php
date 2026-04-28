<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?= $title; ?></title>
	<meta name="description" content="Latest updates and statistic charts">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<link rel="shortcut icon" href="<?= base_url('assets/media/logos/favicon.png'); ?>" />

	<?php if ($dark_mode) { ?>
		<link href="<?= base_url('assets/plugins/custom/datatables/datatables.dark.bundle.css')?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/plugins/global/plugins.dark.bundle.css')?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/css/style.dark.bundle.css')?>" rel="stylesheet" type="text/css" />
	<?php } else { ?>
		<link href="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.css')?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/plugins/global/plugins.bundle.css')?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/css/style.bundle.css')?>" rel="stylesheet" type="text/css" />
	<?php } ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/5.0.0/introjs.min.css" integrity="sha512-B5BOsh3/c3Lg0FOPf3k+DASjK21v5SpLy7IlLg3fdGnbilmT1gR2QzELRp0gvCDSG+bptATmQDNtwHyLQxnKzg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="<?= base_url('assets/css/mobile.css') ?>" rel="stylesheet" type="text/css" />

	<style type="text/css">
		.page-item.active .page-link {
			z-index: 1 !important;
		}
		.menu-item .menu-link .menu-icon2 {
			flex-shrink: 0;
			display: flex;
			align-items: center;
			justify-content: center;
			width: 2rem;
			margin-right: 0.5rem;
		}
		.page-item.first .page-link i, 
		.page-item.last .page-link i, 
		.page-item.next .page-link i, 
		.page-item.previous .page-link i {
			color: #5e6278;
		}
		.page-item.first .page-link, 
		.page-item.last .page-link, 
		.page-item.next .page-link, 
		.page-item.previous .page-link {
			background-color: transparent;
		}
		.add-dt {
			border-top-left-radius: 0.65rem !important;
			border-bottom-left-radius: 0.65rem !important;
		}
		.input-group .btn {
			position: relative;
			z-index: 1;
		}
		.introjs-button {
			display: inline-block;
			font-weight: 500;
			line-height: 1.5;
			text-align: center;
			vertical-align: middle;
			cursor: pointer;
			user-select: none;
			border: 1px solid transparent;
			transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;

			background-color: #009ef7;
			color: white;
			text-shadow: 0 0 black;
			padding: 0.65rem 1.25rem;
			font-size: .925rem;
			border-radius: 0.65rem;
		}

		.introjs-button:active,
		.introjs-button:hover,
		.introjs-button:focus {
			color: #fff;
			border-color: #0095e8;
			background-color: #0095e8!important;
		}

		.introjs-disabled {
			pointer-events: none;
			opacity: .6;
		}

		<?php if (!$dark_mode) { ?>
			.select2-selection__rendered {
				color: #181c32 !important;
			}
		<?php } ?>

		<?php if ($setting_template && !$dark_mode) { ?>
			#kt_aside {
				background-color: <?= $setting_template['color_navbar'] ?>;
			}
			#logout_txt {
				color: <?= $setting_template['color_text'] ?>;
			}
			#setting_icon [fill]:not(.permanent):not(g) {
				fill: <?= $setting_template['color_icon'] ?>;
			}
			#logout_icon [fill]:not(.permanent):not(g) {
				fill: <?= $setting_template['color_icon'] ?>;
			}
			.aside .aside-menu .menu .menu-item .menu-link .menu-title {
				color: <?= $setting_template['color_text'] ?>;
			}

			.menu-icon .svg-icon svg [fill]:not(.permanent):not(g) {
				fill: <?= $setting_template['color_icon'] ?> !important;
			}
			.menu-icon2 .svg-icon svg [fill]:not(.permanent):not(g) {
				fill: <?= $setting_template['color_icon'] ?> !important;
			}
		<?php } ?>

		body.aside-minimize #kt_aside {
			width: 75px !important;
			transition: width 0.3s ease;
		}
		body.aside-minimize #kt_aside .menu-title,
		body.aside-minimize #kt_aside .aside-user,
		body.aside-minimize #kt_aside .menu-arrow {
			display: none !important;
		}
		body.aside-minimize #kt_aside .menu-link {
			justify-content: center;
		}
		body.aside-minimize #kt_aside_minimize_toggle .svg-icon {
			transform: rotate(0deg);
		}
		#kt_aside_minimize_toggle .svg-icon {
			transform: rotate(180deg);
			transition: transform 0.3s ease;
		}
	</style>

	<script type="text/javascript">
		function imgError(image) {
			image.onerror = ""
			image.src = "<?= base_url('assets/img/not_found.png') ?>"
			return true
		}
	</script>
</head>
<body id="kt_body" class="<?= $layout_class ?? 'layout-desktop' ?>">
	<div class="d-flex flex-column flex-root">
		<div class="page d-flex flex-row flex-column-fluid">
			<div id="kt_aside" class="aside pt-9 pb-4 pb-lg-7" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
				<div class="aside-logo flex-column-auto px-9 mb-9 mx-auto" id="kt_aside_logo">
					<img alt="Logo" src="<?= base_url('assets/media/logos/SATI.png') ?>" class="h-60px logo" />
				</div>
				<div class="aside-user mb-5 mx-auto" id="kt_aside_user">
					<div class="d-flex align-items-center">
						<div class="symbol symbol-50px mb-4 me-5">
							<div class="symbol-label" style="background-image: url(<?= $user['image'] ? base_url('assets/uploads/profil/' . $user['image']) : $blank_user ?>)"></div>
						</div>
						<div>
							<?php 
							$name = explode(" ", $user['name']);
							$partName = $name[0];
							 ?>
							 <?php if (strlen($partName) < 3 && isset($name[1])): ?>
							 	<span class="text-gray-900 fs-4 fw-boldest"><?= $name[1] ?></span>
							 <?php else: ?>
							 	<span class="text-gray-900 fs-4 fw-boldest"><?= $name[0]  ?></span>
							 <?php endif ?>
							
							<span class="text-gray-600 fw-bold d-block fs-7 mb-1"><?= get_role_label($user['role']) ?></span>
						</div>
					</div>
				</div>
				<div class="aside-menu flex-column-fluid ps-3 ps-lg-5 pe-1 mb-9" id="kt_aside_menu">
					<div class="w-100 hover-scroll-overlay-y pe-2 me-2" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_user, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu, #kt_aside_menu_wrapper" data-kt-scroll-offset="0">
						<div class="menu menu-column menu-rounded fw-bold" id="#kt_aside_menu" data-kt-menu="true">
							
							<div class="menu-item <?= $module=='dashboard' ? 'here' : '' ?>">
								<a class="menu-link" href="<?= base_url('dashboard') ?>">
									<span class="menu-icon">
										<span class="svg-icon svg-icon-1">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M3 7.19995H10C10.6 7.19995 11 6.79995 11 6.19995V3.19995C11 2.59995 10.6 2.19995 10 2.19995H3C2.4 2.19995 2 2.59995 2 3.19995V6.19995C2 6.69995 2.4 7.19995 3 7.19995Z" fill="black"/>
												<path opacity="0.3" d="M10.1 22H3.10001C2.50001 22 2.10001 21.6 2.10001 21V10C2.10001 9.4 2.50001 9 3.10001 9H10.1C10.7 9 11.1 9.4 11.1 9V20C11.1 21.6 10.7 22 10.1 22ZM13.1 18V21C13.1 21.6 13.5 22 14.1 22H21.1C21.7 22 22.1 21.6 22.1 21V18C22.1 17.4 21.7 17 21.1 17H14.1C13.5 17 13.1 17.4 13.1 18ZM21.1 2H14.1C13.5 2 13.1 2.4 13.1 3V14C13.1 14.6 13.5 15 14.1 15H21.1C21.7 15 22.1 14.6 22.1 14V3C22.1 2.4 21.7 2 21.1 2Z" fill="black"/>
											</svg>
										</span>
									</span>
									<span class="menu-title">Dasbor</span>
								</a>
							</div>
							
							
							<div data-kt-menu-trigger="click" class="menu-item menu-accordion <?= in_array($module, ['polosan','customdesain','stok']) ? 'hover show' : '' ?> menu-production">
								<span class="menu-link">
									<span class="menu-icon2">
										<span class="svg-icon svg-icon-1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M20.0381 4V10C20.0381 10.6 19.6381 11 19.0381 11H17.0381C16.4381 11 16.0381 10.6 16.0381 10V4C16.0381 2.9 16.9381 2 18.0381 2C19.1381 2 20.0381 2.9 20.0381 4ZM9.73808 18.9C10.7381 18.5 11.2381 17.3 10.8381 16.3L5.83808 3.29999C5.43808 2.29999 4.23808 1.80001 3.23808 2.20001C2.23808 2.60001 1.73809 3.79999 2.13809 4.79999L7.13809 17.8C7.43809 18.6 8.23808 19.1 9.03808 19.1C9.23808 19 9.53808 19 9.73808 18.9ZM19.0381 18H17.0381V20H19.0381V18Z" fill="black"/>
												<path d="M18.0381 6H4.03809C2.93809 6 2.03809 5.1 2.03809 4C2.03809 2.9 2.93809 2 4.03809 2H18.0381C19.1381 2 20.0381 2.9 20.0381 4C20.0381 5.1 19.1381 6 18.0381 6ZM4.03809 3C3.43809 3 3.03809 3.4 3.03809 4C3.03809 4.6 3.43809 5 4.03809 5C4.63809 5 5.03809 4.6 5.03809 4C5.03809 3.4 4.63809 3 4.03809 3ZM18.0381 3C17.4381 3 17.0381 3.4 17.0381 4C17.0381 4.6 17.4381 5 18.0381 5C18.6381 5 19.0381 4.6 19.0381 4C19.0381 3.4 18.6381 3 18.0381 3ZM12.0381 17V22H6.03809V17C6.03809 15.3 7.33809 14 9.03809 14C10.7381 14 12.0381 15.3 12.0381 17ZM9.03809 15.5C8.23809 15.5 7.53809 16.2 7.53809 17C7.53809 17.8 8.23809 18.5 9.03809 18.5C9.83809 18.5 10.5381 17.8 10.5381 17C10.5381 16.2 9.83809 15.5 9.03809 15.5ZM15.0381 15H17.0381V13H16.0381V8L14.0381 10V14C14.0381 14.6 14.4381 15 15.0381 15ZM19.0381 15H21.0381C21.6381 15 22.0381 14.6 22.0381 14V10L20.0381 8V13H19.0381V15ZM21.0381 20H15.0381V22H21.0381V20Z" fill="black"/>
											</svg>
										</span>
									</span>
									<span class="menu-title">Produksi</span>
									<span class="menu-arrow"></span>
								</span>
								<div class="menu-sub menu-sub-accordion <?= in_array($module, ['polosan','customdesain','digital']) ? 'show' : '' ?>">
									<?php if (in_array($user['id_role'], [1, 2, 3, 5, 6, 7, 8, 10])): ?>
										<div class="menu-item <?= $module=='polosan' ? 'here' : '' ?>">
											<a class="menu-link" href="<?= base_url('polosan') ?>">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">SPK Polosan</span>
											</a>
										</div>
									<?php endif ?>
									<?php if ($user['id_role'] != 9): ?>
									<div class="menu-item <?= $module=='customdesain' ? 'here' : '' ?>">
										<a class="menu-link" href="<?= base_url('customdesain') ?>">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">SPK Desain</span>
										</a>
									</div>
									<?php endif ?>
									
									<?php if (in_array($user['id_role'], [1, 2, 7, 8, 9, 10])): ?>
									<div class="menu-item <?= $module=='digital' ? 'here' : '' ?>">
										<a class="menu-link" href="<?= base_url('digital') ?>">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">SPK Digital Printing</span>
										</a>
									</div>
									<?php endif ?>
									
								</div>
							</div>
							<?php if ($user['id_role'] == 8): ?>
								<div class="menu-item <?= $module=='tender' ? 'here' : '' ?>">
									<a class="menu-link" href="<?= base_url('tender') ?>">
										<span class="menu-icon">
											<span class="svg-icon svg-icon-1">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="currentColor"/>
													<path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="currentColor"/>
												</svg>
											</span>
										</span>
										<span class="menu-title">Tender</span>
									</a>
								</div>
							<?php endif ?>
							
							<?php if ($user['id_role']== 2 || $user['id_role'] == 1 || $user['id_role'] == 8) { ?>
								
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion <?= in_array($module, ['barang','barangdigital']) ? 'hover show' : '' ?> menu-product">
									<span class="menu-link">
										<span class="menu-icon2">
											<span class="svg-icon svg-icon-1">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M5 8.04999L11.8 11.95V19.85L5 15.85V8.04999Z" fill="black"/>
													<path d="M20.1 6.65L12.3 2.15C12 1.95 11.6 1.95 11.3 2.15L3.5 6.65C3.2 6.85 3 7.15 3 7.45V16.45C3 16.75 3.2 17.15 3.5 17.25L11.3 21.75C11.5 21.85 11.6 21.85 11.8 21.85C12 21.85 12.1 21.85 12.3 21.75L20.1 17.25C20.4 17.05 20.6 16.75 20.6 16.45V7.45C20.6 7.15 20.4 6.75 20.1 6.65ZM5 15.85V7.95L11.8 4.05L18.6 7.95L11.8 11.95V19.85L5 15.85Z" fill="black"/>
												</svg>
											</span>
										</span>
										<span class="menu-title">Produk</span>
										<span class="menu-arrow"></span>
									</span>
									<div class="menu-sub menu-sub-accordion <?= in_array($module, ['barang','barangdgp']) ? 'show' : '' ?>">
										<div class="menu-item <?= $module=='barang' ? 'here' : '' ?>">
												<a class="menu-link" href="<?= base_url('barang') ?>">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Produk</span>
												</a>
										</div>
										<div class="menu-item <?= $module=='barangdgp' ? 'here' : '' ?>">
											<a class="menu-link" href="<?= base_url('barangdgp') ?>">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Produk Digital Printing</span>
											</a>
										</div>
										
									</div>
								</div>


								<?php if ($user['id_role'] == 8): ?>
									<div class="menu-item <?= $module=='user' ? 'here' : '' ?>">
										<a class="menu-link" href="<?= base_url('user') ?>">
											<span class="menu-icon">
												<span class="svg-icon svg-icon-1">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>
														<rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
													</svg>
												</span>
											</span>
											<span class="menu-title">Pengguna</span>
										</a>
									</div>
								<?php endif ?>

								<div class="menu-item <?= $module=='papanpisau' ? 'here' : '' ?>">
									<a class="menu-link" href="<?= base_url('papanpisau') ?>">
										<span class="menu-icon">
											<span class="svg-icon svg-icon-1">
												<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M8.9 21L7.19999 22.6999C6.79999 23.0999 6.2 23.0999 5.8 22.6999L4.1 21H8.9ZM4 16.0999L2.3 17.8C1.9 18.2 1.9 18.7999 2.3 19.1999L4 20.9V16.0999ZM19.3 9.1999L15.8 5.6999C15.4 5.2999 14.8 5.2999 14.4 5.6999L9 11.0999V21L19.3 10.6999C19.7 10.2999 19.7 9.5999 19.3 9.1999Z" fill="currentColor"/>
													<path d="M21 15V20C21 20.6 20.6 21 20 21H11.8L18.8 14H20C20.6 14 21 14.4 21 15ZM10 21V4C10 3.4 9.6 3 9 3H4C3.4 3 3 3.4 3 4V21C3 21.6 3.4 22 4 22H9C9.6 22 10 21.6 10 21ZM7.5 18.5C7.5 19.1 7.1 19.5 6.5 19.5C5.9 19.5 5.5 19.1 5.5 18.5C5.5 17.9 5.9 17.5 6.5 17.5C7.1 17.5 7.5 17.9 7.5 18.5Z" fill="currentColor"/>
												</svg>
											</span>
										</span>
										<span class="menu-title">Master Papan Pisau</span>
									</a>
								</div>

								<?php if ($user['id_role'] == 8): ?>
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion <?= in_array($module, ['category','uom','material','layer','kraft','box']) ? 'hover show' : '' ?>">
										<span class="menu-link">
											<span class="menu-icon2">
												<span class="svg-icon svg-icon-1">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor"/>
														<rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor"/>
														<rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor"/>
														<rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor"/>
													</svg>

												</span>
											</span>
											<span class="menu-title">Master</span>
											<span class="menu-arrow"></span>
										</span>
										<div class="menu-sub menu-sub-accordion <?= in_array($module, ['role','uom','joint','box']) ? 'show' : '' ?>">
											<div class="menu-item <?= $module=='role' ? 'here' : '' ?>">
												<a class="menu-link" href="<?= base_url('role') ?>">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Role</span>
												</a>
											</div>
											<div class="menu-item <?= $module=='joint' ? 'here' : '' ?>">
												<a class="menu-link" href="<?= base_url('joint') ?>">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Joint</span>
												</a>
											</div>
											<div class="menu-item <?= $module=='box' ? 'here' : '' ?>">
												<a class="menu-link" href="<?= base_url('box') ?>">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Box</span>
												</a>
											</div>
											<div class="menu-item <?= $module=='material' ? 'here' : '' ?>">
												<a class="menu-link" href="<?= base_url('material') ?>">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Material</span>
												</a>
											</div>
											<div class="menu-item <?= $module=='uom' ? 'here' : '' ?>">
												<a class="menu-link" href="<?= base_url('uom') ?>">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Unit of Measure</span>
												</a>
											</div>
										</div>
									</div>
								<?php endif ?>
								
							<?php } ?>
							<?php if ($user['id_role']=='8') { ?>
								<div class="menu-item <?= $module=='setting' ? 'here' : '' ?>">
									<a class="menu-link" href="<?= base_url('setting') ?>">
										<span class="menu-icon">
											<span class="svg-icon svg-icon-1">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path opacity="0.3" d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z" fill="black" />
													<path d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z" fill="black" />
												</svg>
											</span>
										</span>
										<span class="menu-title">Setting</span>
									</a>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>

				<div class="aside-footer flex-column-auto px-6 px-lg-9" id="kt_aside_footer">
					<div class="d-flex flex-stack ms-7">
						<a href="<?= base_url('auth/logout') ?>" class="btn btn-sm btn-icon btn-active-color-dark btn-icon-gray-600 btn-text-gray-600">
							<span class="svg-icon svg-icon-1 me-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" id="logout_icon">
									<rect opacity="0.3" width="12" height="2" rx="1" transform="matrix(-1 0 0 1 15.5 11)" fill="black" />
									<path d="M13.6313 11.6927L11.8756 10.2297C11.4054 9.83785 11.3732 9.12683 11.806 8.69401C12.1957 8.3043 12.8216 8.28591 13.2336 8.65206L16.1592 11.2526C16.6067 11.6504 16.6067 12.3496 16.1592 12.7474L13.2336 15.3479C12.8216 15.7141 12.1957 15.6957 11.806 15.306C11.3732 14.8732 11.4054 14.1621 11.8756 13.7703L13.6313 12.3073C13.8232 12.1474 13.8232 11.8526 13.6313 11.6927Z" fill="black" />
									<path d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z" fill="#C4C4C4" />
								</svg>
							</span>
							<span class="d-flex flex-shrink-0 fw-bolder" id="logout_txt">Keluar</span>
						</a>
						<div class="ms-1">
							<div class="btn btn-sm btn-icon btn-icon-gray-600 btn-active-color-dark position-relative me-n1" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start">
								<span class="svg-icon svg-icon-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" id="setting_icon">
										<path opacity="0.3" d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z" fill="black" />
										<path d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z" fill="black" />
									</svg>
								</span>
							</div>
							<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
								<div class="menu-item px-3">
									<div class="menu-content d-flex align-items-center px-3">
										<div class="symbol symbol-50px me-5 ">
											<div class="symbol-label" style="background-image:url('<?= $blank_user ?>')"></div>
										</div>
										<div class="d-flex flex-column">
											<div class="fw-bolder d-flex align-items-center fs-5"><?= $user['name'] ?></div>
											<span class="fw-bold text-muted fs-7"><?= $user['email'] ?></span>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<div id="kt_header" class="header">
					<div class="container-fluid d-flex align-items-center flex-wrap justify-content-between" id="kt_header_container">
						<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-2 pb-5 pb-lg-0 pt-7 pt-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
							<h1 class="d-flex flex-column text-dark fw-bolder my-0 fs-1">
								<span style="font-size:12px" class="mt-5"><?= $title ?></span>
								<span style="font-size: 20px; padding-top:5px;" class="fw-bolder">Hallo, <span style="color: <?= $setting_template['color_navbar'] ?>;" ><?= $user['name'] ?></span> </span>
								
							</h1>
						</div>
						<div class="d-none d-lg-flex align-items-center me-2">
							<div class="btn btn-icon btn-active-icon-primary" id="kt_aside_minimize_toggle">
								<span class="svg-icon svg-icon-1 rotate-180">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path opacity="0.3" d="M4.7 17.3V7.7C4.7 6.59543 5.59543 5.7 6.7 5.7H9.8C10.2694 5.7 10.65 5.3194 10.65 4.85C10.65 4.3806 10.2694 4 9.8 4H5C3.89543 4 3 4.89543 3 6V19C3 20.1046 3.89543 21 5 21H18C19.1046 21 20 20.1046 20 19V14.2C20 13.7306 19.6194 13.35 19.15 13.35C18.6806 13.35 18.3 13.7306 18.3 14.2V17.3C18.3 18.4046 17.4046 19.3 16.3 19.3H6.7C5.59543 19.3 4.7 18.4046 4.7 17.3Z" fill="currentColor"/>
										<path d="M13.9 4.45676L21.1 11.6568C21.4863 12.0431 21.4863 12.6726 21.1 13.0589L13.9 20.2589C13.5137 20.6452 12.8842 20.6452 12.4979 20.2589C12.1116 19.8726 12.1116 19.2431 12.4979 18.8568L18.0979 13.2568H4C3.44772 13.2568 3 12.8091 3 12.2568C3 11.7045 3.44772 11.2568 4 11.2568H18.0979L12.4979 5.65676C12.1116 5.27046 12.1116 4.64099 12.4979 4.25468C12.8842 3.86837 13.5137 3.86837 13.9 4.25468V4.45676Z" fill="currentColor"/>
									</svg>
								</span>
							</div>
						</div>
						<div class="d-flex d-lg-none align-items-center ms-n3 me-2">
							<div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
								<span class="svg-icon svg-icon-1 mt-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
										<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
									</svg>
								</span>
							</div>
							<a href="#" class="d-flex align-items-center">
								<img alt="Logo" src="<?= base_url('assets/media/logos/logo8.png') ?>" class="h-40px mx-5" />
							</a>
						</div>

						<div class="d-flex align-items-center flex-shrink-0">
							<?php if ($user['id_role'] == 1 || $user['id_role'] == 2 || $user['id_role'] == 8): ?>
								<div class="d-flex align-items-center">
									<a href="<?= base_url('monitor') ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Pergi Ke Halaman Monitoring">
										<span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path opacity="0.3" d="M4.7 17.3V7.7C4.7 6.59543 5.59543 5.7 6.7 5.7H9.8C10.2694 5.7 10.65 5.31944 10.65 4.85C10.65 4.38056 10.2694 4 9.8 4H5C3.89543 4 3 4.89543 3 6V19C3 20.1046 3.89543 21 5 21H18C19.1046 21 20 20.1046 20 19V14.2C20 13.7306 19.6194 13.35 19.15 13.35C18.6806 13.35 18.3 13.7306 18.3 14.2V17.3C18.3 18.4046 17.4046 19.3 16.3 19.3H6.7C5.59543 19.3 4.7 18.4046 4.7 17.3Z" fill="currentColor"/>
											<rect x="21.9497" y="3.46448" width="13" height="2" rx="1" transform="rotate(135 21.9497 3.46448)" fill="currentColor"/>
											<path d="M19.8284 4.97161L19.8284 9.93937C19.8284 10.5252 20.3033 11 20.8891 11C21.4749 11 21.9497 10.5252 21.9497 9.93937L21.9497 3.05029C21.9497 2.498 21.502 2.05028 20.9497 2.05028L14.0607 2.05027C13.4749 2.05027 13 2.52514 13 3.11094C13 3.69673 13.4749 4.17161 14.0607 4.17161L19.0284 4.17161C19.4702 4.17161 19.8284 4.52978 19.8284 4.97161Z" fill="currentColor"/>
										</svg>
									</span>
								</a>

							</div>
						<?php endif ?>
						<?php $this->load->view('partials/realtime_clock'); ?>

						<div class="d-flex align-items-center">
							<div class="btn btn-icon btn-custom w-30px h-30px w-md-40px h-md-40px position-relative" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
								<span id="blink" class="bullet bullet-dot bg-danger h-10px w-10px position-absolute translate-middle top-10 start-75 animation-blink"></span>
								<i class="bi bi-bell fs-2" style="color: blue"></i>
								<span id="plush" class="pulse-ring border-3"></span>
							</div>
							<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
								<div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url(<?= base_url('assets/media/misc/pattern-1.jpg') ?>)">
									<h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications
										<span class="fs-8 opacity-75 ps-3 reports"></span></h3>
										<ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
											<?php if ($user['id_role'] == 9): ?>
											<li class="nav-item">
												<a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" style="font-size: 11px;" href="#kt_topbar_notifications_3">Digital Printing Work</a>
											</li>

											<?php elseif($user['id_role'] == 2 || $user['id_role'] == 10 || $user['id_role'] == 7): ?>
											<li class="nav-item">
												<a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" style="font-size: 11px;" href="#kt_topbar_notifications_1">Plain Work</a>
											</li>
											<li class="nav-item">
												<a class="nav-link text-white opacity-75 opacity-state-100 pb-4" style="font-size: 11px;" data-bs-toggle="tab" href="#kt_topbar_notifications_2">Design Work</a>
											</li>
											<li class="nav-item">
												<a class="nav-link text-white opacity-75 opacity-state-100 pb-4" style="font-size: 11px;" data-bs-toggle="tab" href="#kt_topbar_notifications_3">Digital Printing Work</a>
											</li>
											<?php else: ?>
											<li class="nav-item">
												<a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" style="font-size: 11px;" href="#kt_topbar_notifications_1">Plain Work</a>
											</li>
											<li class="nav-item">
												<a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" style="font-size: 11px;" href="#kt_topbar_notifications_2">Design Work</a>
											</li>
											<?php endif ?>
											
										</ul>
									</div>
									<div class="tab-content">
										<div class="tab-pane fade show <?= $user['id_role'] == 9 ? '' : 'active'  ?>" id="kt_topbar_notifications_1" role="tabpanel">
											<div class="scroll-y mh-325px my-5 px-8">
												<table id="tabel_notif_polosan" class="table table-row-dashed gs-0 gy-4">
													<thead>
														<tr class="fw-bold text-muted">
															<th class="visually-hidden"></th>
															<th class="visually-hidden"></th>
															<th class="visually-hidden"></th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
										<div class="tab-pane fade show" id="kt_topbar_notifications_2" role="tabpanel">
											<!--begin::Wrapper-->
											<div class="scroll-y mh-325px my-5 px-8">
												<table id="tabel_notif_custom" class="table table-row-dashed gs-0 gy-4">
													<thead>
														<tr class="fw-bold text-muted">
															<th class="visually-hidden"></th>
															<th class="visually-hidden"></th>
															<th class="visually-hidden"></th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
										<div class="tab-pane fade show <?= $user['id_role'] == 9 ? 'active' : ''  ?>" id="kt_topbar_notifications_3" role="tabpanel">
											<!--begin::Wrapper-->
											<div class="scroll-y mh-325px my-5 px-8">
												<table id="tabel_notif_digital" class="table table-row-dashed gs-0 gy-4">
													<thead>
														<tr class="fw-bold text-muted">
															<th class="visually-hidden"></th>
															<th class="visually-hidden"></th>
															<th class="visually-hidden"></th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>


							<div class="d-flex align-items-center ms-3 ms-lg-4">
								<a class="btn btn-icon btn-color-gray-700 btn-active-color-warning btn-outline btn-outline-secondary w-40px h-40px" href="<?= base_url('template/dark') ?>">
									<?php if (!$dark_mode){ ?>
										<i class="fonticon-moon fs-2"></i>
									<?php } else { ?>
										<i class="fonticon-sun fs-2"></i>
									<?php } ?>
								</a>
							</div>

						</div>
					</div>

				</div>

				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
