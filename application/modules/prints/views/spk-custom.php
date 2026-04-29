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
	<link href="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.css')?>" rel="stylesheet" type="text/css" />

	<style type="text/css">
	.watermark {
		 position: fixed;
		 top: 50%;
		 left: 50%;
		 transform: translate(-50%, -50%);
		 opacity: 0.10;
		 z-index: -1;
		 pointer-events: none;
		 user-select: none;
	 }

	 .watermark img {
		 max-width: 600px;
		 width: 100%;
		 height: auto;
	 }
		@media print{
			@page {
				size: landscape;
				margin: 8mm 5mm 8mm 5mm;
			}
			.page-break {
				page-break-after: always;
			}
			.watermark {
            display: block;
        }
		}
		.text-brown {
			color: #6d1f09 !important;
		}
		.text-gold {
			color: #eaa121 !important;
		}

	</style>
</head>
<body class="bg-white container">
	<div class="watermark">
		<img alt="Logo" src="<?= base_url('assets/media/logos/logo8.png') ?>" />
	</div>
	<div class="card-body">
		<div class="mw-lg-950px mx-auto w-100">
			<div class="d-flex justify-content-between align-items-center mb-10 ribbon ribbon-start">
			    <div>
			        <img alt="Logo" src="<?= base_url('assets/media/logos/SATI.png') ?>" class="h-60px" />
			    </div>
			    <div>
			        <span class="fs-3 p-2" style="border: 4px solid black; border-radius: 6px;">
			            <?= $x['id_pesanan'] ?>
			        </span>
			    </div>
			</div>
			<div class="pb-12">
				<div class="d-flex flex-column gap-20 gap-md-10">
					<div class="d-flex justify-content-between flex-column">
						<h1 class="text-center">Surat Perintah Kerja </h1>
					</div>
					<div>
						<table class="table table-bordered" style="border: 1px solid black;">
							<tr class=" fs-6 fw-bolder" style="border: 1px solid black;">
								<th class="p-3">Id Production</th>
								<td><?= str_replace('/', '', substr($x['id_pesanan'], 0, 7)) ."/". date('Ymd', strtotime($x['created_at'])) . "/" . $x['id'] ;?></td>
							</tr>
							<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
								<th class="p-3">Order Id</th>
								<td><?= $x['id_pesanan']?></td>
							</tr>
							<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
								<th class="p-3">Sales</th>
								<td><?= $x['user']['name']?></td>
							</tr>
							<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
								<th class="p-3">Date</th>
								<td><?= date('d/m/Y', strtotime($x['created_at'])) ?></td>
							</tr>
							<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
								<th class="p-3">Due Date</th>
								<td><?= date('d/m/Y', strtotime($x['due_date'])) ?></td>
							</tr>
							<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
								<th class="p-3">Duration</th>
								<td><?= $x['durasi'] ?> Day</td>
							</tr>

						</table>
					</div>

					<div>
						<table class="table" style="border: 1px solid black;">
							<thead>
								<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
									<th class=" text-center p-1" colspan="2">Order Detail</th>

								</tr>
							</thead>
							<?php foreach ($x['detail_pekerjaan'] as $key => $item): ?>
								<?php if ($item['barang']): ?>
									<tr class="fw-bolder" style="border: 1px solid black;">
										<th class="text-black" style="padding-left: 5px;">No. Mc</th>
										<td class="text-strat" ><?= $item['barang']['no_mc'] ?></td>
										<td>
											<small class="text-muted d-block">Dibuat: <?= date('d/m/Y', strtotime($x['created_at'])) ?></small>
											<?php if (!empty($x['completed_at'])): ?>
											<small class="text-muted d-block">Selesai: <?= date('d/m/Y', strtotime($x['completed_at'])) ?></small>
											<?php endif ?>
											<?php if (!empty($x['shipped_at'])): ?>
											<small class="text-muted d-block">Dikirim: <?= date('d/m/Y', strtotime($x['shipped_at'])) ?></small>
											<?php endif ?>
										</td>
									</tr>
									<tr class="fw-bolder" style="border: 1px solid black;">
										<th class="text-black" style="padding-left: 5px; color: blue;">Product Name</th>
										<td class="text-strat" style="color: blue;"><?= $item['barang']['item_box'] ?></td>
									</tr>


													<tr class="fw-bolder" style="border: 1px solid black;">
														<th class="text-black" style="padding-left: 5px;">Substance/Flute</th>
														<td class="text-start" ><?= $item['barang']['substance'] ?></td>
													</tr>
													<tr class="fw-bolder" style="border: 1px solid black;">
														<th class="text-black" style="padding-left: 5px;">Product Model</th>
														<td class="text-start" ><?= $item['barang']['name_box'] ?></td>
													</tr>
													<tr class="fw-bolder" style="border: 1px solid black;">
														<th class="text-black" style="padding-left: 5px;">Joint</th>
														<td class="text-start" ><?= $item['barang']['name_joint'] ? $item['barang']['name_joint'] : "Empty" ?></td>
													</tr>
													<tr class="fw-bolder" style="border: 1px solid black;">
														<th class="text-black" style="padding-left: 5px;">Cutting Board</th>
														<td class="text-start" ><?=  $item['barang']['name_papan'] ? $item['barang']['name_papan'] : "Empty" ?></td>
													</tr>
													<tr class="fw-bolder" style="border: 1px solid black;">
														<th class="text-black" style="padding-left: 5px;">Qty</th>
														<td class="text-start"><?= $item['qty'] ?></td>
													</tr>
													<tr class="fw-bolder" style="border: 1px solid black;">
														<th class="text-black" style="padding-left: 5px;">Note</th>
														<td >
															<pre><?= $item['deskripsi'] ? $item['deskripsi'] : 'Empty' ?></pre>
														</td>

													</tr>
								<?php endif ?>

								<?php endforeach ?>


						</table>
					</div>
					<div class="row">
						<div class="col text-center">
							<span class="fw-bold">Cutting</span>
							<br/>
							<br/>
							<br/>
							<br/>
							<span class=" fs-5">(<?= $setting['nama_dibuat'] ? $setting['nama_dibuat'] : ' ................................ ' ?>)</span>
						</div>
						<div class="col text-center">
							<span class="fw-bold">Printing</span>
							<br/>
							<br/>
							<br/>
							<br/>
							<span class=" fs-5">(<?= $setting['nama_periksa'] ? $setting['nama_periksa'] : ' ................................ ' ?>)</span>
						</div>
						<div class="col text-center">
							<span class="fw-bold">Kepala Bagian Gudang</span>
							<br/>
							<br/>
							<br/>
							<br/>
							<span class=" fs-5">(<?= $setting['nama_disetujui'] ? $setting['nama_disetujui'] : ' ................................ ' ?>)</span>
						</div>
						<div class="col text-center">
							<span class="fw-bold">Finishing</span>
							<br/>
							<br/>
							<br/>
							<br/>
							<span class=" fs-5">(<?= $setting['nama_diterima'] ? $setting['nama_diterima'] : ' ................................ ' ?>)</span>
						</div>
						<div class="col text-center">
							<span class="fw-bold">Kepala Bagian Produksi</span>
							<br/>
							<br/>
							<br/>
							<br/>
							<span class=" fs-5">(<?= $setting['nama_pengawas'] ? $setting['nama_pengawas'] : ' ................................ ' ?>)</span>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
	<script src="<?= base_url('assets/plugins/global/plugins.bundle.js')?>"></script>
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
