<div class="container-fluid" id="kt_content_container">
	<div class="card mb-5">
		<div class="card-header align-items-center">
			<div class="btn-group btn-group-sm my-2 my-sm-0">
				<a href="<?= base_url('barang') ?>" class="btn btn-light btn-sm"><i class="bi bi-chevron-left"></i></a>
			</div>
			<?php if ($x) { ?>
				<div class="btn-group btn-group-sm my-2 my-sm-0">
					<a href="<?= base_url('barang/view/'.$prev) ?>" class="btn btn-light <?= $prev ? '' : 'disabled' ?>">Prev</a>
					<span class="btn border pe-none text-gray-600"><?= $i.' / '.$j ?></span>
					<a href="<?= base_url('barang/view/'.$next) ?>" class="btn btn-light <?= $next ? '' : 'disabled' ?>">Next</a>
				</div>
			<?php } ?>
		</div>
		<div class="card-body">
			<div class="d-flex flex-wrap flex-sm-nowrap">
				<div class="flex-grow-1">
					<div class="d-flex justify-content-between align-items-start flex-wrap">
						<div class="d-flex flex-column">
							<div class="d-flex align-items-center mb-2">
								<span class="svg-icon svg-icon-1 svg-icon-primary me-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path opacity="0.3" d="M3 13H10C10.6 13 11 13.4 11 14V21C11 21.6 10.6 22 10 22H3C2.4 22 2 21.6 2 21V14C2 13.4 2.4 13 3 13Z" fill="black"/>
										<path d="M7 16H6C5.4 16 5 15.6 5 15V13H8V15C8 15.6 7.6 16 7 16Z" fill="black"/>
										<path opacity="0.3" d="M14 13H21C21.6 13 22 13.4 22 14V21C22 21.6 21.6 22 21 22H14C13.4 22 13 21.6 13 21V14C13 13.4 13.4 13 14 13Z" fill="black"/>
										<path d="M18 16H17C16.4 16 16 15.6 16 15V13H19V15C19 15.6 18.6 16 18 16Z" fill="black"/>
										<path opacity="0.3" d="M3 2H10C10.6 2 11 2.4 11 3V10C11 10.6 10.6 11 10 11H3C2.4 11 2 10.6 2 10V3C2 2.4 2.4 2 3 2Z" fill="black"/>
										<path d="M7 5H6C5.4 5 5 4.6 5 4V2H8V4C8 4.6 7.6 5 7 5Z" fill="black"/>
										<path opacity="0.3" d="M14 2H21C21.6 2 22 2.4 22 3V10C22 10.6 21.6 11 21 11H14C13.4 11 13 10.6 13 10V3C13 2.4 13.4 2 14 2Z" fill="black"/>
										<path d="M18 5H17C16.4 5 16 4.6 16 4V2H19V4C19 4.6 18.6 5 18 5Z" fill="black"/>
									</svg>
								</span>
								<span class="text-gray-900 fs-2 fw-bolder"><?= $x['item_box'] ?></span>
							</div>
						</div>
					</div>
					<div class="d-flex flex-wrap flex-stack">
						<div class="d-flex flex-column flex-grow-1 pe-8">
							<div class="d-flex flex-wrap">
								<div class="border border-gray-300 border-dashed rounded min-w-125px p-3 me-6 mb-3 mb-sm-0">
									<div class="d-flex align-items-center">
										<div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="<?= $x['stok'] ?>">0</div>
									</div>
									<div class="fw-bold fs-6 text-gray-400">Qty Stock</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="me-7 mb-4 mb-sm-0">
					<h1 class="text-center">Inside</h1>
					<a data-fslightbox="lightbox-basic" class="symbol symbol-100px symbol-lg-160px symbol-fixed overlay" href="<?= $x['inside'] ? base_url('assets/uploads/barang/'.$x['inside']) : $blank_product ?>">
						<img src="<?= $x['inside'] ? base_url('assets/uploads/barang/'.$x['inside']) : $blank_product ?>" alt="image" />
					</a>
				</div>
				<div class="me-7 mb-4 mb-sm-0">
					<h1 class="text-center">Outside</h1>
					<a data-fslightbox="lightbox-basic" class="symbol symbol-100px symbol-lg-160px symbol-fixed overlay" href="<?= $x['outside'] ? base_url('assets/uploads/barang/'.$x['outside']) : $blank_product ?>">
						<img src="<?= $x['outside'] ? base_url('assets/uploads/barang/'.$x['outside']) : $blank_product ?>" alt="image" />
					</a>
				</div>
				<div class="me-7 mb-4 mb-sm-0">
					<h1 class="text-center">Color</h1>
					<a data-fslightbox="lightbox-basic" class="symbol symbol-100px symbol-lg-160px symbol-fixed overlay" href="<?= $x['color'] ? base_url('assets/uploads/barang/'.$x['color']) : $blank_product ?>">
						<img src="<?= $x['color'] ? base_url('assets/uploads/barang/'.$x['color']) : $blank_product ?>" alt="image" />
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="card mb-5">
		<div class="card-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="row mb-7">
						<label class="col-lg-4 fw-bold text-muted">No MC</label>
						<div class="col-lg-8">
							<span class="fw-bolder fs-6 text-gray-800"><?= $x['no_mc'] ?></span>
						</div>
					</div>
					<div class="row mb-7">
						<label class="col-lg-4 fw-bold text-muted">Nama Produk</label>
						<div class="col-lg-8">
							<span class="fw-bolder fs-6 text-gray-800 "><?= $x['item_box'] ?></span>
						</div>
					</div>
					<div class="row mb-7">
						<label class="col-lg-4 fw-bold text-muted">Box</label>
						<div class="col-lg-8">
							<span class="fw-bolder fs-6 text-gray-800 "><?= $x['box'] ?></span>
						</div>
					</div>
					<div class="row mb-7">
						<label class="col-lg-4 fw-bold text-muted">Joint</label>
						<div class="col-lg-8">
							<span class="fw-bolder fs-6 text-gray-800 "><?= $x['joint'] ? $x['joint'] : 'Empty' ?></span>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="row mb-7">
						<label class="col-lg-4 fw-bold text-muted">Substance/Flute</label>
						<div class="col-lg-8">
							<span class="fw-bolder fs-6 text-gray-800 "><?= $x['substance'] ?></span>
						</div>
					</div>
					<div class="row mb-7">
						<label class="col-lg-4 fw-bold text-muted">Ukuran Produk</label>
						<div class="col-lg-8">
							<span class="fw-bolder fs-6 text-gray-800 "><?= $x['size'] ?></span>
						</div>
					</div>
					<div class="row mb-7">
						<label class="col-lg-4 fw-bold text-muted">Papan Pisau</label>
						<div class="col-lg-8">
							<span class="fw-bolder fs-6 text-gray-800 "><?= $x['papan_pisau'] ? $x['papan_pisau'] : 'Empty'  ?></span>
						</div>
					</div>
					
					<div class="row mb-7">
						<label class="col-lg-4 fw-bold text-muted">Spesifikasi</label>
						<div class="col-lg-8">
							<span class="fw-bolder fs-6 text-gray-800 "><?= $x['deskripsi'] ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>