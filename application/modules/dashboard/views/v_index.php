<div class="container-fluid" id="kt_content_container">
	<div class="row g-5 g-xl-8">
		<div class="col-xl-8">

			<?php if ($user['id_role'] == 1 || $user['id_role'] == 2 || $user['id_role'] == 8): ?>
				<div class="mb-10">
					<ul class="nav row mb-10">
						<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-5">
							<a style="background-color: wheat;"
							class="nav-link btn btn-flex btn-color-gray-700 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px  active"
							data-bs-toggle="tab" href="#kt_general_widget_1_7">
							<span class="svg-icon svg-icon-3x mb-5 mx-0">
								<img src="<?= base_url('assets/media/icons/ICON ALL PROCESS.png') ?>" class="img-fluid" width="100"
								height="100">
							</span>
							<span class="fs-8 fw-bold">All Process</span> 
							<span class="fs-6 fw-bold all"></span>
						</a>
					</li>
					<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
						<a style="background-color: wheat;"
						class="nav-link btn btn-flex btn-color-gray-700 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px"
						data-bs-toggle="tab" href="#kt_general_widget_1_waiting">
						<span class="svg-icon svg-icon-3x mb-5 mx-0">
							<img src="<?= base_url('assets/media/icons/ICON WAITING.png') ?>" class="img-fluid" width="100"
							height="100">
						</span>
						<span class="fs-8 fw-bold">Waiting Material/Tool</span>
						<span class="fs-6 fw-bold waiting"></span>
					</a>
				</li>
				<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
					<a style="background-color: wheat;"
					class="nav-link btn btn-flex btn-color-gray-700 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px"
					data-bs-toggle="tab" href="#kt_general_widget_1_1">
					<span class="svg-icon svg-icon-3x mb-5 mx-0">
						<img src="<?= base_url('assets/media/icons/ICON-CUTTING.png') ?>" class="img-fluid" width="100"
						height="100">
					</span>
					<span class="fs-8 fw-bold">Cutting</span>
					<span class="fs-6 fw-bold cutting"></span>
				</a>
			</li>
			<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
				<a style="background-color: wheat;"
				class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px"
				data-bs-toggle="tab" href="#kt_general_widget_1_2">
				<span class="svg-icon svg-icon-3x mb-5 mx-0">
					<img src="<?= base_url('assets/media/icons/ICON-design.png') ?>" class="img-fluid"
					width="100" height="100">
				</span>
				<span class="fs-8 fw-bold">Design</span>
				<span class="fs-6 fw-bold desain"></span>
			</a>
		</li>
		<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
			<a style="background-color: wheat;"
			class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px"
			data-bs-toggle="tab" href="#kt_general_widget_1_3">
			<span class="svg-icon svg-icon-3x mb-5 mx-0">
				<img src="<?= base_url('assets/media/icons/ICON PRINTING.png') ?>" class="img-fluid" width="100"
				height="100">
			</span>
			<span class="fs-8 fw-bold">Printing</span>
			<span class="fs-6 fw-bold printing"></span>
		</a>
	</li>
	<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
		<a style="background-color: wheat;"
		class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px"
		data-bs-toggle="tab" href="#kt_general_widget_1_4">
		<span class="svg-icon svg-icon-3x mb-5 mx-0">
			<img src="<?= base_url('assets/media/icons/ICON-PACKING-MIN.png') ?>" class="img-fluid" width="100"
			height="100">
		</span>
		<span class="fs-8 fw-bold">Finishing</span>
		<span class="fs-6 fw-bold packing"></span>
	</a>
</li>
<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
	<a style="background-color: wheat;"
	class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px"
	data-bs-toggle="tab" href="#kt_general_widget_1_selesai">
	<span class="svg-icon svg-icon-3x mb-5 mx-0">
		<img src="<?= base_url('assets/media/icons/ICON-SELESAI.png') ?>" class="img-fluid" width="100"
		height="100">
	</span>
	<span class="fs-8 fw-bold">Selesai</span>
	<span class="fs-6 fw-bold selesai"></span>
</a>
</li>
<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
	<a style="background-color: wheat;"
	class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px"
	data-bs-toggle="tab" href="#kt_general_widget_1_approved_qc">
	<span class="svg-icon svg-icon-3x mb-5 mx-0">
		<img src="<?= base_url('assets/media/icons/ICON-QC-MIN.png') ?>" class="img-fluid" width="100"
		height="100">
	</span>
	<span class="fs-8 fw-bold">Disetujui Kualitas</span>
	<span class="fs-6 fw-bold approved_qc"></span>
</a>
</li>
</ul>
<div class="tab-content">
	<div class="tab-pane fade show active" id="kt_general_widget_1_7">
		<div class="card card-body bg-body">
			<div class="card border-0 pt-5">
				<h3 class="card-title align-items-start flex-column">
					<span class="card-label fw-bold fs-3 mb-1">All Process</span>
				</h3>
			</div>
			<div class="card-body py-3">
				<div class="table-responsive">
					<table
					class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
					id="table-all">
					<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
					<tbody class="fw-bold text-gray-800"></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="tab-pane fade" id="kt_general_widget_1_1">
	<div class="card card-body bg-body">
		<div class="card border-0 pt-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold fs-3 mb-1">Cutting Process</span>
			</h3>
		</div>
		<div class="card-body py-3">
			<div class="table-responsive">
				<table
				class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
				id="table-cutting">
				<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
				<tbody class="fw-bold text-gray-800"></tbody>
			</table>
		</div>
	</div>
</div>
</div>
<div class="tab-pane fade" id="kt_general_widget_1_2">
	<div class="card bg-body">
		<div class="card-header border-0 pt-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold fs-3 mb-1">Design Process</span>
			</h3>
		</div>
		<div class="card-body py-3">
			<div class="table-responsive">
				<table
				class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
				id="table-desain">
				<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
				<tbody class="fw-bold text-gray-800" id="tbody"></tbody>
			</table>
			<table id="table-placeholder">
					<tbody>
						<tr data-kt-subtable="subtable_template" class="d-none">
							<td></td>
							<td colspan="2">
								<div class="d-flex flex-column text-muted">
									<span class="text-dark fw-bolder" data-kt-subtable="template_name">Product name</span>
									<div class="fs-7" data-kt-subtable="template_description">Product description</div>
								</div>
							</td>
							<td>
								<div class="d-flex align-items-center gap-3">
									<a data-fslightbox="lightbox-basic" href="#" class="d-block overlay symbol symbol-50px bg-secondary bg-opacity-25 rounded">
										<img class="symbol symbol-50px bg-secondary bg-opacity-25 rounded" src="<?= $blank_product ?>" alt="" data-kt-subtable="template_outside" />
									</a>
								</div>
							</td>
							<td>
								<div class="d-flex align-items-center gap-3">
									<a data-fslightbox="lightbox-basic" href="#" class="d-block overlay symbol symbol-50px bg-secondary bg-opacity-25 rounded">
										<img class="symbol symbol-50px bg-secondary bg-opacity-25 rounded" src="<?= $blank_product ?>" alt="" data-kt-subtable="template_inside" />
									</a>
								</div>
							</td>
							<td>
								<div class="d-flex align-items-center gap-3">
									<a data-fslightbox="lightbox-basic" href="#" class="d-block overlay symbol symbol-50px bg-secondary bg-opacity-25 rounded">
										<img class="symbol symbol-50px bg-secondary bg-opacity-25 rounded" src="<?= $blank_product ?>" alt="" data-kt-subtable="template_color" />
									</a>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
		</div>
	</div>
</div>
</div>
<div class="tab-pane fade " id="kt_general_widget_1_3">
	<div class="card bg-body">
		<div class="card-header border-0 pt-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold fs-3 mb-1">Printing Process</span>
			</h3>
		</div>
		<div class="card-body py-3">
			<div class="tab-content">
				<div class="tab-pane fade show active" id="kt_table_widget_5_tab_1">
					<div class="table-responsive">
						<table
						class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
						id="table-printing">
						<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
						<tbody class="fw-bold text-gray-800"></tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane fade" id="kt_table_widget_5_tab_3">
				<div class="table-responsive">
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="tab-pane fade" id="kt_general_widget_1_4">
	<div class="card bg-body">
		<div class="card-header border-0 pt-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold fs-3 mb-1">Proses Finishing</span>
			</h3>
		</div>
		<div class="card-body py-3">
			<div class="tab-content">
				<div class="tab-pane fade show active" id="kt_table_widget_4_tab_1">
					<div class="table-responsive">
						<table
						class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
						id="table-packing">
						<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
						<tbody class="fw-bold text-gray-800"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<div class="tab-pane fade" id="kt_general_widget_1_selesai">
	<div class="card bg-body">
		<div class="card-header border-0 pt-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold fs-3 mb-1">Proses Selesai</span>
			</h3>
		</div>
		<div class="card-body py-3">
			<div class="tab-content">
				<div class="tab-pane fade show active" id="kt_table_widget_1_selesai">
					<div class="table-responsive">
						<table
						class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
						id="table-selesai">
						<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
						<tbody class="fw-bold text-gray-800"></tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</div>
</div>

<div class="tab-pane fade" id="kt_general_widget_1_approved_qc">
	<div class="card bg-body">
		<div class="card-header border-0 pt-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold fs-3 mb-1">Proses Disetujui Kualitas</span>
			</h3>
		</div>
		<div class="card-body py-3">
			<div class="tab-content">
				<div class="tab-pane fade show active" id="kt_table_widget_1_selesai">
					<div class="table-responsive">
						<table
						class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
						id="table-approved-qc">
						<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
						<tbody class="fw-bold text-gray-800"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<div class="tab-pane fade" id="kt_general_widget_1_waiting">
	<div class="card bg-body">
		<div class="card-header border-0 pt-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold fs-3 mb-1">Menunggu Material/Alat</span>
			</h3>
		</div>
		<div class="card-body py-3">
			<div class="tab-content">
				<div class="tab-pane fade show active" id="kt_table_widget_1_waiting">
					<div class="table-responsive">
						<table
						class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
						id="table-waiting">
						<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
						<tbody class="fw-bold text-gray-800"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>


</div>
</div>
<?php else: ?>

	<div class="mb-10">
		<ul class="nav row mb-10">
			<?php if ($user['id_role'] == 1 || $user['id_role'] == 2 || $user['id_role'] == 5 || $user['id_role'] == 6 || $user['id_role'] == 7 || $user['id_role'] == 8): ?>
				<li class="nav-item col-12 col-lg mb-5 mb-lg-0">
					<a style="background-color: wheat;" href="<?= base_url('polosan') ?>" 
						class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px">
						<span class="svg-icon svg-icon-3x mb-5 mx-0">
							<img src="<?= base_url('assets/media/icons/ICON-PACKING.png') ?>" class="img-fluid" width="100"
							height="100">
						</span>
						<span class="fs-6 fw-bold">Plain Work</span>
					</a>
				</li>
			<?php endif ?>
			
			<?php if ($user['id_role'] == 3): ?>
			<li class="nav-item col-12 col-lg mb-5 mb-lg-0">
				<a style="background-color: wheat;" href="<?= base_url('customdesain') ?>" 
					class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px">
					<span class="svg-icon svg-icon-3x mb-5 mx-0">
						<img src="<?= base_url('assets/media/icons/ICON-design.png') ?>" class="img-fluid"
						width="100" height="100">
					</span>
					<span class="fs-6 fw-bold">Design Work</span>
				</a>
			</li>
			<?php endif ?>
			
			<?php if ($user['id_role'] == 9): ?>
				<li class="nav-item col-12 col-lg mb-5 mb-lg-0">
				<a style="background-color: wheat;" href="<?= base_url('digital') ?>" 
					class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px">
					<span class="svg-icon svg-icon-3x mb-5 mx-0">
						<img src="<?= base_url('assets/media/icons/ICON-design.png') ?>" class="img-fluid"
						width="100" height="100">
					</span>
					<span class="fs-6 fw-bold">Digital Printing Work</span>
				</a>
			</li>
			<?php endif ?>


		</ul>
	</div>
<?php endif ?>

</div>
<div class="col-xl-4">
	<div class="card bg-body mb-10">
		<div class="card-header align-items-center border-0 mt-4">
			<h3 class="card-title align-items-start flex-column">
				<span class="fw-bold mb-2 text-dark">Activities</span>
			</h3>
		</div>
		<div class="card-body pt-5">
			<div class="d-flex align-items-sm-center mb-7">
				<div class="symbol symbol-50px me-5">
					<span class="symbol-label">
						<img src="<?= base_url('assets/media/icons/box.png') ?>" class="h-50 align-self-center" alt="" />
					</span>
				</div>
				<div class="d-flex align-items-center flex-row-fluid flex-wrap">
					<div class="flex-grow-1 me-2">
						<span class="text-gray-800 text-hover-primary fs-6 fw-bold">Plain Work</span>
					</div>
					<span class="badge badge-light fw-bold my-2 polosan"></span>
				</div>
			</div>
			<div class="d-flex align-items-sm-center mb-7">
				<div class="symbol symbol-50px me-5">
					<span class="symbol-label">
						<img src="<?= base_url('assets/media/icons/package.png') ?>" class="h-50 align-self-center"
						alt="" />
					</span>
				</div>
				<div class="d-flex align-items-center flex-row-fluid flex-wrap">
					<div class="flex-grow-1 me-2">
						<span class="text-gray-800 text-hover-primary fs-6 fw-bold">Design Work</span>
					</div>
					<span class="badge badge-light fw-bold my-2 custom"></span>
				</div>
			</div>
			<div class="d-flex align-items-sm-center mb-7">
				<div class="symbol symbol-50px me-5">
					<span class="symbol-label">
						<img src="<?= base_url('assets/media/icons/print.png') ?>" class="h-50 align-self-center"
						alt="" />
					</span>
				</div>
				<div class="d-flex align-items-center flex-row-fluid flex-wrap">
					<div class="flex-grow-1 me-2">
						<span class="text-gray-800 text-hover-primary fs-6 fw-bold">Digital Printing Work</span>
					</div>
					<span class="badge badge-light fw-bold my-2 digital"></span>
				</div>
			</div>
		</div>
	</div>
	<div class="card bg-body mb-5">
		<div class="card-header border-0 pt-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold text-dark">Stock Information</span>
			</h3>
		</div>
		<div class="card-body pt-5">
			<div class="d-flex align-items-sm-center mb-7">
				<div class="symbol symbol-50px me-5">
					<span class="symbol-label">
						<img src="<?= base_url('assets/media/icons/ready-stock.png') ?>" class="h-50 align-self-center" alt="" />
					</span>
				</div>
				<div class="d-flex align-items-center flex-row-fluid flex-wrap">
					<div class="flex-grow-1 me-2">
						<span class="text-gray-800 text-hover-primary fs-6 fw-bold">Available Stock Product</span>
					</div>
					<span class="badge badge-light fw-bold my-2 stok_ada"></span>
				</div>
			</div>
			<div class="d-flex align-items-sm-center mb-7">
				<div class="symbol symbol-50px me-5">
					<span class="symbol-label">
						<img src="<?= base_url('assets/media/icons/out-of-stock.png') ?>" class="h-50 align-self-center"
						alt="" />
					</span>
				</div>
				<div class="d-flex align-items-center flex-row-fluid flex-wrap">
					<div class="flex-grow-1 me-2">
						<span class="text-gray-800 text-hover-primary fs-6 fw-bold">Out of Stock Product</span>
					</div>
					<span class="badge badge-light fw-bold my-2 stok_habis"></span>
				</div>
			</div>
			<div class="d-flex align-items-sm-center mb-7">
				<div class="symbol symbol-50px me-5">
					<span class="symbol-label">
						<img src="<?= base_url('assets/media/icons/inventory.png') ?>" class="h-50 align-self-center" alt="" />
					</span>
				</div>
				<div class="d-flex align-items-center flex-row-fluid flex-wrap">
					<div class="flex-grow-1 me-2">
						<span class="text-gray-800 text-hover-primary fs-6 fw-bold">Total Stock</span>
					</div>
					<span class="badge badge-light fw-bold my-2 total_stok"></span>
				</div>
			</div>
		</div>
	</div>

	<div class="card bg-body mb-5">
		<div class="card-header border-0 pt-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold text-dark">Total Product Information</span>
			</h3>
		</div>
		<div class="card-body pt-5">
			<div class="d-flex align-items-sm-center mb-7">
				<div class="symbol symbol-50px me-5">
					<span class="symbol-label">
						<img src="<?= base_url('assets/media/icons/box.png') ?>" class="h-50 align-self-center" alt="" />
					</span>
				</div>
				<div class="d-flex align-items-center flex-row-fluid flex-wrap">
					<div class="flex-grow-1 me-2">
						<span class="text-gray-800 text-hover-primary fs-6 fw-bold">Product</span>
					</div>
					<span class="badge badge-light fw-bold my-2 produk_box"></span>
				</div>
			</div>
			<div class="d-flex align-items-sm-center mb-7">
				<div class="symbol symbol-50px me-5">
					<span class="symbol-label">
						<img src="<?= base_url('assets/media/icons/print.png') ?>" class="h-50 align-self-center"
						alt="" />
					</span>
				</div>
				<div class="d-flex align-items-center flex-row-fluid flex-wrap">
					<div class="flex-grow-1 me-2">
						<span class="text-gray-800 text-hover-primary fs-6 fw-bold">Product Digital printing</span>
					</div>
					<span class="badge badge-light fw-bold my-2 produk_dgp"></span>
				</div>
			</div>
		</div>
	</div>
		
</div>
</div>

<div class="row">
	<div class="col-xl-6">
		<div class="card mb-5">
			<div class="card-header border-0 pt-5">
				<h3 class="card-title align-items-start flex-column">
					<span class="card-label fw-bolder fs-3 mb-1">5 Top Repeat Order Products</span>
					<a href="<?= base_url('barang/repeat') ?>" class="text-info fw-bold fs-7">View All</a>	
				</h3>
										
			</div>
			<div class="card-body">
				<div id="kt_charts_repeate" style="height: 350px"></div>
			</div>
			
		</div>
	</div>

	<div class="col-xl-6">
		<div class="card mb-5">
			<div class="card-header border-0 pt-5">
				<h3 class="card-title align-items-start flex-column">
					<span class="card-label fw-bolder fs-3 mb-1">5 Top Repeat Order Products Digital Printing</span>
					<a href="<?= base_url('barangdgp/repeat') ?>" class="text-info fw-bold fs-7">View All</a>	
				</h3>						
			</div>
			<div class="card-body">
				<div id="kt_charts_repeate_dgp" style="height: 350px"></div>
			</div>
			
		</div>
	</div>
	
</div>

	

</div>

