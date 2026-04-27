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
				size: portrait;
				margin: 10mm 0mm 10mm 0mm;
			}
			.page-break {
				page-break-after: always;
			}
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
	<?php foreach ($x['detail_pekerjaan'] as $key => $line): ?>
		<section class="page-break mt-20">
				<div class="row mt-20">
					<div class="col-12">
						<div class="d-flex justify-content-center">

							<span class="text-brown fs-2qx fw-boldest my-auto">PANTONE PRINTING COLOR</span>
						</div>
					</div>
					<div class="col-12">
						<div class="fs-2x">
							<span class="fw-bolder">No. MC</span>
							<br>
							<span class="px-3" style="border: 4px solid #6d1f09;border-radius: 6px;"><?= $line['barang']['no_mc'] ?></span>
						</div>
						<table class="agency h3 mt-5" style="border: 1px solid #cccccc; width: 100%">
							<tr>
								<td colspan="6" class="content text-center p-4 bg-brown text-white" width="25%" >COLOR PRINTING</td>
							</tr>
							<tr>
								<td class="d-flex justify-content-center p-5" style="border-right: 1px solid #CCCCCC;">
									<?php if ($line['barang']['color']): ?>
										<img class="h-100" src="<?= base_url('assets/uploads/barang/'.$line['barang']['color']) ?>" <?= $line['barang']['color']?'style="max-width: 50%;"':'style="max-width: 100%"' ?> />
									<?php endif ?>
									

								</td>
							</tr>
						</table>
						<table class="agency h3 mt-5" style="border: 1px solid #cccccc; width: 100%">
							<tr>
								<td class="content w-50 text-center p-4">Tanggal <span class="mx-1">:</span> <?= $x['created_at'] ?></td>
								<td class="content w-50 text-center p-4" style="border-left: 1px solid #cccccc">Tanggal Pengiriman <span class="mx-1">:</span> <?= $x['tgl_pengiriman'] ? $x['tgl_pengiriman'] : 'Kosong' ?></td>
							</tr>
						</table>
					</div>
					<div class="col-12 d-flex justify-content-center mt-4">
						<div class="w-100 me-5">
							<table class="w-100 h-100 border border-2">
								<tr class="border border-2">
									<td colspan="6" class="content text-center p-4 bg-brown text-white" width="25%" >DETAIL KERJA</td>
								</tr>
								<tr class="border border-2">
									<td>
										<span class="ms-2 text-nowrap">Nama Produk</span>
									</td>
									<td>:</td>
									<td class="fw-bolder"><?= $line['barang']['item_box'] ?></td>
								</tr>
								<tr class="border border-2">
									<td>
										<span class="ms-2 text-nowrap">Ukuran Produk</span>
									</td>
									<td>:</td>
									<td class="fw-bolder"><?= $line['barang']['size'] ?></td>
								</tr>
								<tr class="border border-2">
									<td>
										<span class="ms-2 text-nowrap">Model Produk</span>
									</td>
									<td>:</td>
									<td class="fw-bolder"><?= $line['barang']['name_box'] ?></td>
								</tr>
								<tr class="border border-2">
									<td>
										<span class="ms-2 text-nowrap">Papan Pisau</span>
									</td>
									<td>:</td>
									<td class="fw-bolder"><?= $line['barang']['name_papan'] ? $line['barang']['name_papan'] : 'Kosong'  ?></td>
								</tr>
								<tr class="border border-2">
									<td>
										<span class="ms-2 text-nowrap">Joint</span>
									</td>
									<td>:</td>
									<td class="fw-bolder"><?= $line['barang']['name_joint']?></td>
								</tr>
								<tr class="border border-2">
									<td>
										<span class="ms-2 text-nowrap">Keterangan</span>
									</td>
									<td>:</td>
									<td class="fw-bolder">
										<div class="d-flex">
											<div class="col-3">
												<span class="svg-icon">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
													</svg>
												</span>
												Warna Dalam
											</div>
											<div class="col-3">
												<span class="svg-icon">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
													</svg>
												</span>
												Warna Luar
											</div>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="w-20 ms-5">
							<table class="w-100 h-100">
								<tr>
									<td width="50%" class="text-center">
										<img src="<?= base_url('assets/media/logos/logo8.png') ?>" class="h-80px mx-5">
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</section>
		
	<?php endforeach ?>
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