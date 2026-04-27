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
				margin: 10mm 5mm 10mm 5mm;
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
	<div class="card-body">
		 <div class="mw-lg-950px mx-auto w-100">
	 	<?php foreach ($x['detail_pekerjaan'] as $key => $line): ?>
	 					<table class="table table-bordered " style="border: 1px solid black;">
							<tr class="fs-6 fw-bolder" style="border: 1px solid black; vertical-align: middle;">
							    <th class="p-3"><?= $line['barang']['nama_dgp'] ?></th>
							    <td rowspan="2" style="text-align: center; vertical-align: middle;">
							        <img alt="Logo" src="<?= base_url('assets/uploads/digital/'.$line['barang']['image']) ?>" class="h-100px w-100px " />
							    </td>
							</tr>

							<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
								<th style=" vertical-align: middle;" class="p-3"><?= "MC : ". $line['barang']['no_mc_label'] ?></th>
							</tr>
							<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
								<th colspan="2" class="p-3"><?= "Qty : ". $line['qty'] . " Lbr" ?></th>
							</tr>
							<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
								<th colspan="2" class="p-3"><?= "Finishing : ". "(". $line['finishing'] .")"  ?></th>
							</tr>
							<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
								<th colspan="2" class="p-3"><?= "Isi/Lbr : ".  $line['qty_object']  ?></th>
							</tr>
							<tr class="fs-6 fw-bolder" style="border: 1px solid black;">
								<th colspan="2" class="p-3"><?= "Total : ".  $line['qty_total'] . " Pcs" ?></th>
							</tr>

							
							
						</table>
			
			<?php endforeach ?>
		</div>
	</div>
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