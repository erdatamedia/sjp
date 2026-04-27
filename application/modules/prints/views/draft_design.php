<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?= $title; ?></title>
	<meta name="description" content="Latest updates and statistic charts">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<link rel="shortcut icon" href="<?= base_url('assets/media/logos/favicon.png'); ?>" />
	<link href="<?= base_url('assets/plugins/global/plugins.bundle.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/css/style.bundle.css')?>" rel="stylesheet" type="text/css" />

	<style type="text/css">
		@media print{
			@page {
				size: landscape;
				margin: 10mm 0mm 0mm 0mm;
			}
			@page potret {
				size: portrait;
				margin: 10mm 0mm 0mm 0mm;
			}
			.page-break {
				page-break-after: always;
			}
		}
		#color {
			page: potret;
		}
		.bg-brown {
			background-color: #6d1f09 !important;
		}
		.text-brown {
			color: #6d1f09 !important;
		}

	</style>
</head>
<body class="bg-white container">
	<table class="table">
		<?php foreach ($x['detail_pekerjaan'] as $key => $line): ?>
			<?php if ($line['barang']['outside']): ?>
				<tr style="page-break-before: always;">
					<td>
						<div class="fs-1 text-end">
							No. MC
							<span class="mx-3 px-3" style="border: 4px solid #6d1f09;border-radius: 6px;"><?= $line['barang']['no_mc'] ?></span>
						</div>
						<div class="border mt-2">
							<div class="d-flex justify-content-center">
								<?php if ($line['barang']['outside']): ?>
									<div class="h-250px mt-2 p-5">
										<img class="h-200px img-fluid" src="<?= base_url('assets/uploads/barang/'.$line['barang']['outside']) ?>" />
									</div>

								<?php endif ?>
							</div>
							<div class="row mx-1 mb-1 h-5">
								<div class="col-3 border px-1">
									<table>
										<tbody>
											<tr>
												<td class="text-center">
													<img class="w-125px mb-5 text-center" src="<?= base_url('assets/media/logos/SATI.png') ?>" />
													<div class="text-start fs-10">
														<span>FACTORY/OFFICE</span><br/>
														<span>Jalan Rambutan No.9, Nganglang, Bangil, Pasuruan</span><br/>
														<span>PHONE: 081216690098</span><br/>
														<span>EMAIL: officialbillybox@gmail.com</span>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-3 border">
									<div class="row">
										<div class="col-12 text-center text-brown text-uppercase fs-5 py-1 fw-bolder">Gambar Kerja</div>
									</div>
									<div class="row border fs-10 py-1">
										<div class="col-4 px-1">Nama Produk</div>
										<div class="col-8 px-0">: <?= $line['barang']['item_box'] ?></div>
									</div>
									<div class="row border fs-10 py-1">
										<div class="col-4 px-1">Ukuran Produk</div>
										<div class="col-8 px-0">: <?= $line['barang']['size'] ?></div>
									</div>
									<div class="row border fs-10 py-1">
										<div class="col-4 px-1">Model Produk</div>
										<div class="col-8 px-0">: <?= $line['barang']['name_box'] ?></div>
									</div>
									<div class="row border fs-10 py-1">
										<div class="col-4 px-1">Subtance/Flute</div>
										<div class="col-8 px-0">: <?= $line['barang']['substance'] ?></div>
									</div>
									<div class="row border fs-10 py-1">
										<div class="col-4 px-1">Papan Pisau</div>
										<div class="col-6 px-0">: <?= $line['barang']['name_papan'] ? $line['barang']['name_papan'] : "Kosong"  ?></div>
									</div>
									<div class="row border fs-10 py-1">
										<div class="col-4 px-1">Joint</div>
										<div class="col-6 px-0">: <?= $line['barang']['name_joint'] ?></div>
									</div>
								</div>
								<div class="col-3 border fs-8">
									<div class="row border">
										
									</div>
									<div class="row border">
										<div class="col-4 py-1 px-1">Ket</div>
										<div class="col-1 py-1 px-1">:</div>
										<div class="col-6 py-1 px-1">
											<div class="d-flex">
												<div class="col-4" style="font-size: 8px; margin-right: 6px;">
													<span class="svg-icon">
														<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
														</svg>
													</span>
													Dalam
												</div>
												<div class="col-4" style="font-size: 8px;">
													<span class="svg-icon">
														<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
															<path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black" style="fill: black !important;"/>
														</svg>
													</span>
													Luar
												</div>
											</div>
										</div>
									</div>
									<div class="row border">
										<div class="col-4 py-2 px-1">Qty</div>
										<div class="col-6 py-2 px-1">: <?= $line['qty'] ?></div>
									</div>

								</div>
								<div class="col-3 border px-1">
									<table>
										<tbody>
											<tr style="border-top: 1px solid #eff2f5;">
												<td class="fs-10 text-center">
													<p class="text-brown m-0 fs-9 fw-bolder">PERHATIAN</p>
													<span class="fw-bolder text-brown" style="font-size: 7px;">
														WARNA PADA PRINT INI BUKAN STANDARD UNTUK PROSES PRODUKSI
														MOHON DIPERIKSAKEMBALI PRINT OUT INI DAN COLOR GUIDE YANG TERLAMPIR
														KESALAHAN SETELAH ACC, BUKAN MENJADI TANGGUNG JAWAB KAMI
													</span>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</td>
				</tr>
			<?php endif ?>
			
			<?php if ($line['barang']['inside']): ?>
				<tr>
					<td>
						<div class="fs-1 text-end mt-5">
							No. MC
							<span class="mx-3 px-3" style="border: 4px solid #6d1f09;border-radius: 6px;"><?= $line['barang']['no_mc'] ?></span>
						</div>
						<div class="border mt-2">
							<div class="d-flex justify-content-center">
								<?php if ($line['barang']['outside']): ?>
									<div class="h-250px mt-2 p-5">
										<img class="h-200px img-fluid" src="<?= base_url('assets/uploads/barang/'.$line['barang']['inside']) ?>" />
									</div>

								<?php endif ?>
							</div>
							<div class="row mx-1 mb-1 h-5">
								<div class="col-3 border px-1">
									<table>
										<tbody>
											<tr>
												<td class="text-center">
													<img class="w-125px mb-5 text-center" src="<?= base_url('assets/media/logos/SATI.png') ?>" />
													<div class="text-start fs-10">
														<span>FACTORY/OFFICE</span><br/>
														<span>Jalan Rambutan No.9, Nganglang, Bangil, Pasuruan</span><br/>
														<span>PHONE: 081216690098</span><br/>
														<span>EMAIL: officialbillybox@gmail.com</span>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-3 border">
									<div class="row">
										<div class="col-12 text-center text-brown text-uppercase fs-5 py-1 fw-bolder">Gambar Kerja</div>
									</div>
									<div class="row border fs-10 py-1">
										<div class="col-4 px-1">Nama Produk</div>
										<div class="col-8 px-0">: <?= $line['barang']['item_box'] ?></div>
									</div>
									<div class="row border fs-10 py-1">
										<div class="col-4 px-1">Ukuran Produk</div>
										<div class="col-8 px-0">: <?= $line['barang']['size'] ?></div>
									</div>
									<div class="row border fs-10 py-1">
										<div class="col-4 px-1">Model Produk</div>
										<div class="col-8 px-0">: <?= $line['barang']['name_box'] ?></div>
									</div>
									<div class="row border fs-10 py-1">
										<div class="col-4 px-1">Subtance/Flute</div>
										<div class="col-8 px-0">: <?= $line['barang']['substance'] ?></div>
									</div>
									<div class="row border fs-10 py-1">
										<div class="col-4 px-1">Papan Pisau</div>
										<div class="col-6 px-0">: <?= $line['barang']['name_papan'] ? $line['barang']['name_papan'] : "Kosong"  ?></div>
									</div>
									<div class="row border fs-10 py-1">
										<div class="col-4 px-1">Joint</div>
										<div class="col-6 px-0">: <?= $line['barang']['name_joint'] ?></div>
									</div>
								</div>
								<div class="col-3 border fs-8">
									<div class="row border">
										
									</div>
									<div class="row border">
										<div class="col-4 py-1 px-1">Ket</div>
										<div class="col-1 py-1 px-1">:</div>
										<div class="col-6 py-1 px-1">
											<div class="d-flex">
												<div class="col-4" style="font-size: 8px; margin-right: 6px;">
													<span class="svg-icon">
														<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
															<path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black" style="fill: black !important;"/>
														</svg>
													</span>
													Dalam
												</div>

												<div class="col-4" style="font-size: 8px;">
													<span class="svg-icon">
														<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
														</svg>
													</span>
													Luar
												</div>
											</div>
										</div>
									</div>
									<div class="row border">
										<div class="col-4 py-2 px-1">Qty</div>
										<div class="col-6 py-2 px-1">: <?= $line['qty'] ?></div>
									</div>

								</div>
								<div class="col-3 border px-1">
									<table>
										<tbody>
											<tr style="border-top: 1px solid #eff2f5;">
												<td class="fs-10 text-center">
													<p class="text-brown m-0 fs-9 fw-bolder">PERHATIAN</p>
													<span class="fw-bolder text-brown" style="font-size: 7px;">
														WARNA PADA PRINT INI BUKAN STANDARD UNTUK PROSES PRODUKSI
														MOHON DIPERIKSAKEMBALI PRINT OUT INI DAN COLOR GUIDE YANG TERLAMPIR
														KESALAHAN SETELAH ACC, BUKAN MENJADI TANGGUNG JAWAB KAMI
													</span>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</td>
				</tr>
			<?php endif ?>
			
		<?php endforeach ?>
	</table>
	<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
	<script type="text/javascript">
		
		window.print()

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