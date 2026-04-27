<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
</head>
<body>
<div class="d-flex flex-column flex-column-fluid">
<div class="container-fluid mt-5 mb-5">

	<div class="text-center fw-bolder mb-6" style="font-size:25px;">
		Monitoring
		<a href="<?= base_url('dashboard') ?>" class="ms-2" data-bs-toggle="tooltip" title="Ke Dasbor">
			<span class="svg-icon svg-icon-muted svg-icon-2hx">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z" fill="currentColor"/>
				</svg>
			</span>
		</a>
	</div>

<?php
// ── Kabag Produksi (id_role=1): 2 tab — Menunggu & Selesai ─────────────────
if ($id_role === 1):
?>
	<div class="row g-5">
		<div class="col-12">
			<ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6 fw-bold">
				<li class="nav-item">
					<a class="nav-link active" data-bs-toggle="tab" href="#tab-menunggu">
						Menunggu <span class="badge badge-circle badge-light-warning ms-2" id="badge-menunggu">0</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="tab" href="#tab-selesai">
						Selesai <span class="badge badge-circle badge-light-success ms-2" id="badge-selesai">0</span>
					</a>
				</li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane fade show active" id="tab-menunggu">
					<div class="card bg-body">
						<div class="card-header border-0 pt-4">
							<h3 class="card-title fw-bold fs-4">SPK Sedang Dikerjakan</h3>
						</div>
						<div class="card-body py-3">
							<div class="table-responsive">
								<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer" id="table-menunggu">
									<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
									<tbody class="fw-bold text-gray-800"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="tab-selesai">
					<div class="card bg-body">
						<div class="card-header border-0 pt-4">
							<h3 class="card-title fw-bold fs-4">SPK Sudah Selesai</h3>
						</div>
						<div class="card-body py-3">
							<div class="table-responsive">
								<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer" id="table-selesai-kabag">
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

<?php
// ── Kabag Gudang (id_role=10): 2 tab — Disetujui & Dikirim ────────────────
elseif ($id_role === 10):
?>
	<div class="row g-5">
		<div class="col-12">
			<ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6 fw-bold">
				<li class="nav-item">
					<a class="nav-link active" data-bs-toggle="tab" href="#tab-disetujui">
						Disetujui <span class="badge badge-circle badge-light-warning ms-2" id="badge-disetujui">0</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="tab" href="#tab-dikirim">
						Dikirim <span class="badge badge-circle badge-light-success ms-2" id="badge-dikirim">0</span>
					</a>
				</li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane fade show active" id="tab-disetujui">
					<div class="card bg-body">
						<div class="card-header border-0 pt-4">
							<h3 class="card-title fw-bold fs-4">SPK Disetujui Kualitas</h3>
						</div>
						<div class="card-body py-3">
							<div class="table-responsive">
								<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer" id="table-disetujui">
									<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
									<tbody class="fw-bold text-gray-800"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="tab-dikirim">
					<div class="card bg-body">
						<div class="card-header border-0 pt-4">
							<h3 class="card-title fw-bold fs-4">SPK Sudah Dikirim</h3>
						</div>
						<div class="card-body py-3">
							<div class="table-responsive">
								<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer" id="table-dikirim">
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

<?php
// ── Role lain: tampilan monitor lengkap (semua tab) ────────────────────────
else:
?>
	<div class="row g-5 g-xl-8">
		<div class="col-xl-8">
			<div class="mb-10">
				<ul class="nav row mb-10">
					<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-5">
						<a style="background-color: wheat;" class="nav-link btn btn-flex btn-color-gray-700 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-lg-175px active" data-bs-toggle="tab" href="#kt_general_widget_1_7">
							<img src="<?= base_url('assets/media/icons/ICON ALL PROCESS.png') ?>" class="img-fluid mb-3" width="80" height="80">
							<span class="fs-6 fw-bold">Semua Proses</span>
							<span class="fs-6 fw-bold all"></span>
						</a>
					</li>
					<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
						<a style="background-color: wheat;" class="nav-link btn btn-flex btn-color-gray-700 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_1">
							<img src="<?= base_url('assets/media/icons/ICON-CUTTING.png') ?>" class="img-fluid mb-3" width="80" height="80">
							<span class="fs-6 fw-bold">Cutting</span>
							<span class="fs-6 fw-bold cutting"></span>
						</a>
					</li>
					<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
						<a style="background-color: wheat;" class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_2">
							<img src="<?= base_url('assets/media/icons/ICON-design.png') ?>" class="img-fluid mb-3" width="80" height="80">
							<span class="fs-6 fw-bold">Desain</span>
							<span class="fs-6 fw-bold desain"></span>
						</a>
					</li>
					<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
						<a style="background-color: wheat;" class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_3">
							<img src="<?= base_url('assets/media/icons/ICON PRINTING.png') ?>" class="img-fluid mb-3" width="80" height="80">
							<span class="fs-6 fw-bold">Printing / Sablon</span>
							<span class="fs-6 fw-bold printing"></span>
						</a>
					</li>
					<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
						<a style="background-color: wheat;" class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_4">
							<img src="<?= base_url('assets/media/icons/ICON-PACKING-MIN.png') ?>" class="img-fluid mb-3" width="80" height="80">
							<span class="fs-6 fw-bold">Finishing</span>
							<span class="fs-6 fw-bold packing"></span>
						</a>
					</li>
					<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
						<a style="background-color: wheat;" class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_selesai">
							<img src="<?= base_url('assets/media/icons/ICON-SELESAI.png') ?>" class="img-fluid mb-3" width="80" height="80">
							<span class="fs-6 fw-bold">Selesai</span>
							<span class="fs-6 fw-bold selesai"></span>
						</a>
					</li>
					<li class="nav-item col-12 col-lg-3 mb-5 mb-lg-0">
						<a style="background-color: wheat;" class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_approved_qc">
							<img src="<?= base_url('assets/media/icons/ICON-QC-MIN.png') ?>" class="img-fluid mb-3" width="80" height="80">
							<span class="fs-6 fw-bold">Disetujui Kualitas</span>
							<span class="fs-6 fw-bold approved_qc"></span>
						</a>
					</li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane fade show active" id="kt_general_widget_1_7">
						<div class="card card-body bg-body">
							<div class="card border-0 pt-5"><h3 class="card-title fw-bold fs-3 mb-1">Semua Proses</h3></div>
							<div class="card-body py-3"><div class="table-responsive">
								<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline" id="table-all">
									<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
									<tbody class="fw-bold text-gray-800"></tbody>
								</table>
							</div></div>
						</div>
					</div>
					<div class="tab-pane fade" id="kt_general_widget_1_1">
						<div class="card card-body bg-body">
							<div class="card border-0 pt-5"><h3 class="card-title fw-bold fs-3 mb-1">Proses Cutting</h3></div>
							<div class="card-body py-3"><div class="table-responsive">
								<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline" id="table-cutting">
									<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
									<tbody class="fw-bold text-gray-800"></tbody>
								</table>
							</div></div>
						</div>
					</div>
					<div class="tab-pane fade" id="kt_general_widget_1_2">
						<div class="card bg-body">
							<div class="card-header border-0 pt-5"><h3 class="card-title fw-bold fs-3 mb-1">Proses Desain</h3></div>
							<div class="card-body py-3"><div class="table-responsive">
								<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline" id="table-desain">
									<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
									<tbody class="fw-bold text-gray-800"></tbody>
								</table>
							</div></div>
						</div>
					</div>
					<div class="tab-pane fade" id="kt_general_widget_1_3">
						<div class="card bg-body">
							<div class="card-header border-0 pt-5"><h3 class="card-title fw-bold fs-3 mb-1">Proses Printing / Sablon</h3></div>
							<div class="card-body py-3"><div class="table-responsive">
								<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline" id="table-printing">
									<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
									<tbody class="fw-bold text-gray-800"></tbody>
								</table>
							</div></div>
						</div>
					</div>
					<div class="tab-pane fade" id="kt_general_widget_1_4">
						<div class="card bg-body">
							<div class="card-header border-0 pt-5"><h3 class="card-title fw-bold fs-3 mb-1">Proses Finishing</h3></div>
							<div class="card-body py-3"><div class="table-responsive">
								<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline" id="table-packing">
									<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
									<tbody class="fw-bold text-gray-800"></tbody>
								</table>
							</div></div>
						</div>
					</div>
					<div class="tab-pane fade" id="kt_general_widget_1_selesai">
						<div class="card bg-body">
							<div class="card-header border-0 pt-5"><h3 class="card-title fw-bold fs-3 mb-1">Proses Selesai</h3></div>
							<div class="card-body py-3"><div class="table-responsive">
								<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline" id="table-selesai">
									<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
									<tbody class="fw-bold text-gray-800"></tbody>
								</table>
							</div></div>
						</div>
					</div>
					<div class="tab-pane fade" id="kt_general_widget_1_approved_qc">
						<div class="card bg-body">
							<div class="card-header border-0 pt-5"><h3 class="card-title fw-bold fs-3 mb-1">Proses Disetujui Kualitas</h3></div>
							<div class="card-body py-3"><div class="table-responsive">
								<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline" id="table-approved-qc">
									<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
									<tbody class="fw-bold text-gray-800"></tbody>
								</table>
							</div></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

</div><!-- /container -->
</div><!-- /fluid -->

<script src="<?= base_url('assets/plugins/global/plugins.bundle.js')?>"></script>
<script src="<?= base_url('assets/js/scripts.bundle.js')?>"></script>
<script src="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.js')?>"></script>

<?php
// ── Helper JS kolom tabel standar ──────────────────────────────────────────
$dtColumns = json_encode([
	['title' => 'Informasi',  'data' => 'id_pesanan', 'render' => '__info__'],
	['title' => 'Status',     'data' => 'status',     'render' => '__status__'],
	['title' => 'Durasi',     'data' => 'durasi'],
	['title' => 'Tanggal',    'data' => 'created_at', 'render' => '__date__'],
	['title' => 'Tenggat',    'data' => 'due_date',   'render' => '__due__'],
]);
?>

<script type="text/javascript">
const dtLang = {
	info: '_START_ - _END_ / _TOTAL_', infoFiltered: '(_MAX_)', infoEmpty: '0',
	paginate: {
		first: '<i class="fa fs-4 fa-angle-double-left"></i>',
		previous: '<i class="fa fs-4 fa-angle-left"></i>',
		next: '<i class="fa fs-4 fa-angle-right"></i>',
		last: '<i class="fa fs-4 fa-angle-double-right"></i>',
	}
}

const dtDom = "<'row'<'col-6 d-flex align-items-center justify-content-start'li><'col-6 d-flex align-items-center justify-content-end'p>><'table-responsive'tr>"

const statusBadge = (data) => {
	const map = {
		'approved':          '<span class="badge" style="background:yellow;color:black;">Disetujui Kualitas</span>',
		'approved-customer': '<span class="badge badge-success">Dikirim</span>',
		'approved-shipping': '<span class="badge" style="background:#402f1d;color:white;">Disetujui Logistik</span>',
		'done':              '<span class="badge badge-info">Selesai</span>',
		'desain':            '<span class="badge" style="color:black;background:red;">Desain</span>',
		'printing':          '<span class="badge" style="color:white;background:#0b1abd;">Printing / Sablon</span>',
		'cutting':           '<span class="badge" style="color:white;background:black;">Cutting</span>',
		'packing':           '<span class="badge" style="color:white;background:#ff1493;">Finishing</span>',
		'waiting':           '<span class="badge" style="background:orange;">Menunggu Material/Alat</span>',
	}
	return map[data] || `<span class="badge badge-secondary">${data}</span>`
}

const infoRender = (row) => {
	if (row.id_pesanan) return `<span>Order: ${row.id_pesanan} — ${row.user ? row.user.name : ''}</span>`
	return `<span>${row.user ? row.user.name : ''}</span>`
}

const dateRender = (val) => {
	const m = moment(val)
	return m.isValid() ? m.format('DD/MM/YYYY') : ''
}

const dueDateRender = (row) => {
	const m = moment(row.due_date)
	const now = moment().format('YYYY-MM-DD')
	const d = m.isValid() ? m.format('DD/MM/YYYY') : ''
	return m.isBefore(now, 'day') ? `<span style="color:red;">${d}</span>` : d
}

// ── Render timestamp badge (3C) ────────────────────────────────────────────
const tsBadge = (val, type) => {
	if (!val || val === '0000-00-00 00:00:00') return '<span style="color:#aaa;">—</span>'
	const m = moment(val)
	if (!m.isValid()) return '<span style="color:#aaa;">—</span>'
	const cls   = type === 'done'     ? 'timestamp-done'    : 'timestamp-shipped'
	const label = type === 'done'     ? '✓ Selesai'         : '✓ Dikirim'
	return `<span class="timestamp-badge ${cls}">${label}: ${m.format('DD/MM/YY HH:mm')}</span>`
}

// Kolom standar (untuk semua tab)
const dtColumns = [
	{ title: 'Informasi', data: 'id_pesanan', className: 'min-w-150px',
	  render: (d, t, row) => infoRender(row) },
	{ title: 'Status',    data: 'status',     className: 'min-w-125px',
	  render: (d) => statusBadge(d) },
	{ title: 'Tanggal',   data: 'created_at', className: 'min-w-100px',
	  render: (d) => dateRender(d) },
	{ title: 'Tenggat',   data: 'due_date',   className: 'min-w-100px',
	  render: (d, t, row) => dueDateRender(row) },
]

// Kolom dengan timestamp selesai — untuk tab Kabag Produksi "Selesai"
const dtColumnsSelesai = [
	{ title: 'Informasi', data: 'id_pesanan', className: 'min-w-150px',
	  render: (d, t, row) => infoRender(row) },
	{ title: 'Status',    data: 'status',     className: 'min-w-125px',
	  render: (d) => statusBadge(d) },
	{ title: 'Selesai',   data: 'completed_at', className: 'min-w-130px',
	  render: (d) => tsBadge(d, 'done') },
	{ title: 'Dikirim',   data: 'shipped_at',   className: 'min-w-130px',
	  render: (d) => tsBadge(d, 'shipped') },
]

// Kolom untuk Kabag Gudang "Disetujui"
const dtColumnsGudang = [
	{ title: 'Informasi', data: 'id_pesanan', className: 'min-w-150px',
	  render: (d, t, row) => infoRender(row) },
	{ title: 'Status',    data: 'status',     className: 'min-w-125px',
	  render: (d) => statusBadge(d) },
	{ title: 'Tanggal',   data: 'created_at', className: 'min-w-100px',
	  render: (d) => dateRender(d) },
	{ title: 'Selesai',   data: 'completed_at', className: 'min-w-130px',
	  render: (d) => tsBadge(d, 'done') },
	{ title: 'Dikirim',   data: 'shipped_at',   className: 'min-w-130px',
	  render: (d) => tsBadge(d, 'shipped') },
]

const makeDT = (selector, url, cols) => $(selector).DataTable({
	order: [], serverSide: true, processing: true,
	pageLength: 10, pagingType: 'full_numbers',
	ajax: url, columns: cols || dtColumns, language: dtLang, dom: dtDom,
})

<?php if ($id_role === 1): ?>
// ── Kabag Produksi ─────────────────────────────────────────────────────────
const tMenunggu = makeDT('#table-menunggu',      '<?= base_url('api/dashboard/menunggu') ?>',      dtColumns)
const tSelesai  = makeDT('#table-selesai-kabag', '<?= base_url('api/dashboard/selesai_kabag') ?>', dtColumnsSelesai)

const loadCountKabagProduksi = () => {
	$.get('<?= base_url('api/dashboard/countKabagProduksi') ?>', (r) => {
		$('#badge-menunggu').text(r.menunggu)
		$('#badge-selesai').text(r.selesai)
	})
}
loadCountKabagProduksi()
setInterval(() => {
	loadCountKabagProduksi()
	tMenunggu.ajax.reload(null, false)
	tSelesai.ajax.reload(null, false)
}, 15000)

<?php elseif ($id_role === 10): ?>
// ── Kabag Gudang ───────────────────────────────────────────────────────────
const tDisetujui = makeDT('#table-disetujui', '<?= base_url('api/dashboard/approved') ?>', dtColumnsGudang)
const tDikirim   = makeDT('#table-dikirim',   '<?= base_url('api/dashboard/dikirim') ?>',  dtColumnsGudang)

const loadCountKabagGudang = () => {
	$.get('<?= base_url('api/dashboard/countKabagGudang') ?>', (r) => {
		$('#badge-disetujui').text(r.disetujui)
		$('#badge-dikirim').text(r.dikirim)
	})
}
loadCountKabagGudang()
setInterval(() => {
	loadCountKabagGudang()
	tDisetujui.ajax.reload(null, false)
	tDikirim.ajax.reload(null, false)
}, 15000)

<?php else: ?>
// ── Role lain: semua tab ───────────────────────────────────────────────────
const tAll      = makeDT('#table-all',        '<?= base_url('api/dashboard/all') ?>')
const tCutting  = makeDT('#table-cutting',    '<?= base_url('api/dashboard/cutting') ?>')
const tDesain   = makeDT('#table-desain',     '<?= base_url('api/dashboard/desain') ?>')
const tPrinting = makeDT('#table-printing',   '<?= base_url('api/dashboard/printing') ?>')
const tPacking  = makeDT('#table-packing',    '<?= base_url('api/dashboard/packing') ?>')
const tSelesai2 = makeDT('#table-selesai',    '<?= base_url('api/dashboard/done') ?>')
const tApproved = makeDT('#table-approved-qc','<?= base_url('api/dashboard/approved') ?>')

const loadCount = () => {
	$.get('<?= base_url('api/dashboard/countProses') ?>', (r) => {
		$('.all').text(r.all)
		$('.cutting').text(r.cutting)
		$('.desain').text(r.desain)
		$('.printing').text(r.printing)
		$('.packing').text(r.packing)
		$('.selesai').text(r.done)
		$('.approved_qc').text(r.approved)
	})
}
loadCount()
setInterval(() => {
	loadCount()
	tAll.ajax.reload(null, false)
	tCutting.ajax.reload(null, false)
	tDesain.ajax.reload(null, false)
	tPrinting.ajax.reload(null, false)
	tPacking.ajax.reload(null, false)
	tSelesai2.ajax.reload(null, false)
	tApproved.ajax.reload(null, false)
}, 15000)
<?php endif; ?>
</script>

</body>
</html>
