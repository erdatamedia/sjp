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
				margin: 10mm 10mm 10mm 10mm;
			}
			.page-break {
				page-break-after: always;
			}
			.watermark {
            display: block;
        }
		}
		.bg-brown {
			background-color: #6d1f09 !important;
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
			<div class="pb-20">
				<div class="d-flex flex-column gap-20 gap-md-10" style="margin-bottom: 20px;">
					<div class="d-flex justify-content-between flex-column">
						<h1 class="text-center">Surat Perintah Kerja </h1>
					</div>
					<div class="d-flex justify-content-between flex-column">
						<table class="table table-bordered " style="border: 1px solid black;">
							<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
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


					</div>
					<div class="d-flex justify-content-between flex-column table-responsive gap-10 gap-md-10">
						<table class="table align-middle" style="border: 1px solid black;">
							<thead>
								<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
									<th class="min-w-20px text-center p-3" colspan="5">Order Detail</th>
								</tr>
							</thead>
							<tbody class="fw-bold text-gray-600" >
								<thead>
									<tr class="fw-bolder text-center" style="border: 1px solid black;">
										<th>No</th>
										<td>No Mc</td>
										<th>Order Item</th>
										<th>Qty</th>
										<th>Unit</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($x['detail_pekerjaan'] as $key => $item): ?>
										<tr class="" style="border: 1px solid black;">
											<td class="text-center">
												<?= $key+1 ?>
											</td>
											<td>
												<?= $item['barang']['no_mc_label'] ?>
											</td>
											<td>
												<?= $item['barang']['nama_dgp'] . ", " . $item['finishing'] . ", " . $item['barang']['size']  ?>
											</td>
											<td class="text-center">
												<?= $item['qty'] ?>
											</td>
											<td class="text-center">
												Lbr
											</td>
										</tr>
										<tr style="border: 1px solid black;">
											<th colspan="5" style="padding-left:4px">Note : <?= $item['deskripsi'] ? $item['deskripsi'] : 'Empty' ?></th>
										</tr>

									<?php endforeach ?>
								</tbody>
							</tbody>
						</table>


					</div>

					<div class="row">
						<div class="col text-center">
							<span class="fw-bold">Dibuat Oleh</span>
							<br/>
							<br/>
							<br/>
							<br/>
							<span class=" fs-5">(................................)</span>
						</div>
						<div class="col text-center">
							<span class="fw-bold">Diperiksa Oleh</span>
							<br/>
							<br/>
							<br/>
							<br/>
							<span class=" fs-5">(................................)</span>
						</div>
						<div class="col text-center">
							<span class="fw-bold">Disetujui Oleh</span>
							<br/>
							<br/>
							<br/>
							<br/>
							<span class=" fs-5">(................................)</span>
						</div>
						<div class="col text-center">
							<span class="fw-bold">Diterima Oleh</span>
							<br/>
							<br/>
							<br/>
							<br/>
							<span class=" fs-5">(................................)</span>
						</div>
					</div>
				</div>
			</div>


		</div>

		<table class="table " style="page-break-inside:avoid;">
			<?php foreach ($x['detail_pekerjaan'] as $key => $line): ?>
				<?php if ($line['barang']['image']): ?>
				<tr style="page-break-before: always;">
					<td>
						<div class="fs-3 text-end">
							<span class="mx-3 px-3" style="border: 4px solid #6d1f09;border-radius: 6px;"><?= $line['barang']['no_mc_label'] ?></span>
						</div>
						<div class="border mt-2">
							<div class="d-flex justify-content-center">
								<?php if ($line['barang']['image']): ?>
									<div class="h-250px mt-2 p-5">
										<img class="h-200px img-fluid" src="<?= base_url('assets/uploads/digital/'.$line['barang']['image']) ?>" />
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
									<div class="row border fs-9 py-1">
										<div class="col-4 px-1">Nama Produk</div>
										<div class="col-8 px-0">: <?= $line['barang']['nama_dgp'] ?></div>
									</div>
									<div class="row border fs-9 py-1">
										<div class="col-4 px-1">Ukuran Produk</div>
										<div class="col-8 px-0">: <?= $line['barang']['size'] ?></div>
									</div>
									<div class="row border fs-9 py-1">
										<div class="col-4 px-1">Material</div>
										<div class="col-8 px-0">: <?= $line['barang']['name'] ?></div>
									</div>
									<div class="row border fs-9 py-1">
										<div class="col-4 px-1">Finishing</div>
										<div class="col-8 px-0">: <?= $line['finishing'] ?></div>
									</div>
								</div>
								<div class="col-3 border fs-8">
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
