<style>
.filter-tab {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 7px 14px; border-radius: 8px;
  font-size: 0.85rem; font-weight: 500; cursor: pointer;
  transition: filter 0.15s, opacity 0.15s; line-height: 1.4;
  border: none;
}
.filter-tab:hover { filter: brightness(0.93); }
.filter-tab-all      { border: 1.5px solid rgba(100,100,100,0.3); background: rgba(100,100,100,0.1); color: #444; }
.filter-tab-waiting  { border: 1.5px solid rgba(200,100,0,0.3);   background: rgba(200,100,0,0.08);  color: #a05500; }
.filter-tab-desain   { border: 1.5px solid rgba(200,0,0,0.28);    background: rgba(200,0,0,0.07);    color: #b00000; }
.filter-tab-cutting  { border: 1.5px solid rgba(30,30,30,0.28);   background: rgba(30,30,30,0.09);   color: #222; }
.filter-tab-printing { border: 1.5px solid rgba(11,26,189,0.28);  background: rgba(11,26,189,0.07);  color: #0b1abd; }
.filter-tab-packing  { border: 1.5px solid rgba(255,20,147,0.28); background: rgba(255,20,147,0.08); color: #b5186b; }
.filter-tab-done     { border: 1.5px solid rgba(13,110,253,0.28); background: rgba(13,110,253,0.07); color: #0a58ca; }
.filter-tab-approved { border: 1.5px solid rgba(180,160,0,0.35);  background: rgba(200,180,0,0.08);  color: #7a6800; }
.filter-tab-shipping { border: 1.5px solid rgba(64,47,29,0.3);    background: rgba(64,47,29,0.07);   color: #402f1d; }
.filter-tab-customer { border: 1.5px solid rgba(34,143,21,0.3);   background: rgba(34,143,21,0.07);  color: #1a6b0f; }
.filter-badge {
  border-radius: 12px; padding: 1px 8px;
  font-size: 0.78rem; font-weight: 600;
}
.filter-tab-all      .filter-badge { background: rgba(100,100,100,0.18); color: #444; }
.filter-tab-waiting  .filter-badge { background: rgba(200,100,0,0.15);   color: #a05500; }
.filter-tab-desain   .filter-badge { background: rgba(200,0,0,0.13);     color: #b00000; }
.filter-tab-cutting  .filter-badge { background: rgba(30,30,30,0.14);    color: #222; }
.filter-tab-printing .filter-badge { background: rgba(11,26,189,0.13);   color: #0b1abd; }
.filter-tab-packing  .filter-badge { background: rgba(255,20,147,0.14);  color: #b5186b; }
.filter-tab-done     .filter-badge { background: rgba(13,110,253,0.13);  color: #0a58ca; }
.filter-tab-approved .filter-badge { background: rgba(180,160,0,0.18);   color: #7a6800; }
.filter-tab-shipping .filter-badge { background: rgba(64,47,29,0.14);    color: #402f1d; }
.filter-tab-customer .filter-badge { background: rgba(34,143,21,0.13);   color: #1a6b0f; }

/* Tombol aksi: opacity rendah, penuh saat hover */
.action-column .btn-icon,
.btn-icon.toggle {
  opacity: 0.35;
  transition: opacity 0.15s;
}
.action-column .btn-icon:hover,
.btn-icon.toggle:hover {
  opacity: 1;
}
</style>
<div class="container-fluid" id="kt_content_container">
	<div class="row g-5 g-xl-8">
		<div class="card mb-10 bg-body">
			<div class="w-100 mw-300px d-none">
				<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-allow-clear="true" data-placeholder="Semua Status" id="status">
					<option value="">Semua Status</option>
					<option value="waiting">Menunggu Material/Alat</option>
					<option value="cutting">Cutting</option>
					<option value="packing">Finishing</option>
					<option value="printing">Printing</option>
					<option value="desain">Desain</option>
					<option value="done">Selesai</option>
					<option value="approved">Disetujui</option>
					<option value="approved-shipping">Disetujui Logistik</option>
					<option value="approved-customer">Dikirim</option>
				</select>
			</div>
			<div class="tab-content">
<?php if (can_see_filter($user['id_role'])): ?>
<div class="mb-5 mt-5 mb-sm-0 text-end">
<?php
$_tabs = get_role_filter_tabs($user['id_role']);
if ($_tabs !== null && is_simplified_filter_role($user['id_role'])):
    foreach ($_tabs as $_tab):
    $tab_icons = [
        'filter-tab-all'      => 'bi-grid-3x3-gap',
        'filter-tab-waiting'  => 'bi-clock-history',
        'filter-tab-desain'   => 'bi-vector-pen',
        'filter-tab-cutting'  => 'bi-scissors',
        'filter-tab-printing' => 'bi-printer',
        'filter-tab-packing'  => 'bi-box-seam',
        'filter-tab-done'     => 'bi-check-circle',
        'filter-tab-approved' => 'bi-star-fill',
        'filter-tab-shipping' => 'bi-truck',
        'filter-tab-customer' => 'bi-send-fill',
    ];
    $tab_icon = isset($tab_icons[$_tab['class']]) ? $tab_icons[$_tab['class']] : 'bi-circle';
    ?>
    <button class="btn filter-tab <?= $_tab['class'] ?> me-2 mb-2">
        <i class="bi <?= $tab_icon ?>"></i> <?= $_tab['label'] ?>
        <span data-status="<?= $_tab['status'] ?>" class="count filter-badge">.</span>
    </button>
    <?php endforeach;
else: ?>
    <button class="btn filter-tab filter-tab-all me-2 mb-2">
        <i class="bi bi-grid-3x3-gap"></i> Semua Proses <span data-status="" class="count filter-badge">.</span>
    </button>
    <button class="btn filter-tab filter-tab-waiting me-2 mb-2">
        <i class="bi bi-clock-history"></i> Menunggu Material/Alat <span data-status="waiting" class="count filter-badge">.</span>
    </button>
    <button class="btn filter-tab filter-tab-desain me-2 mb-2">
        <i class="bi bi-vector-pen"></i> Desain <span data-status="desain" class="count filter-badge">.</span>
    </button>
    <button class="btn filter-tab filter-tab-cutting me-2 mb-2">
        <i class="bi bi-scissors"></i> Cutting <span data-status="cutting" class="count filter-badge">.</span>
    </button>
    <button class="btn filter-tab filter-tab-printing me-2 mb-2">
        <i class="bi bi-printer"></i> Printing <span data-status="printing" class="count filter-badge">.</span>
    </button>
    <button class="btn filter-tab filter-tab-packing me-2 mb-2">
        <i class="bi bi-box-seam"></i> Finishing <span data-status="packing" class="count filter-badge">.</span>
    </button>
    <button class="btn filter-tab filter-tab-done me-2 mb-2">
        <i class="bi bi-check-circle"></i> Selesai <span data-status="done" class="count filter-badge">.</span>
    </button>
    <button class="btn filter-tab filter-tab-approved me-2 mb-2">
        <i class="bi bi-star-fill"></i> Disetujui QC <span data-status="approved" class="count filter-badge">.</span>
    </button>
    <button class="btn filter-tab filter-tab-shipping me-2 mb-2">
        <i class="bi bi-truck"></i> Disetujui Logistik <span data-status="approved-shipping" class="count filter-badge">.</span>
    </button>
    <button class="btn filter-tab filter-tab-customer mb-2">
        <i class="bi bi-send-fill"></i> Dikirim <span data-status="approved-customer" class="count filter-badge">.</span>
    </button>
<?php endif; ?>
</div>
<?php endif; ?>
			</div>

			<table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
			id="table">
			<thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
			<tbody class="fw-bold text-gray-800" id="tbody"></tbody>
		</table>

		<table id="table-placeholder">
			<tbody>
				<tr data-kt-subtable="subtable_template" class="d-none">
					<td></td>
					<td colspan="3">
						<div class="d-flex align-items-center gap-3">
							<div data-kt-subtable="template_image"></div>
							<div class="d-flex flex-column text-muted">
								<label class="form-label">Produk</label>
								<span class="text-dark fw-bolder" data-kt-subtable="template_name">Nama Produk</span>
							</div>
						</div>
					</td>
					<td colspan="2">
						<label class="form-label">Spesifikasi</label>
						<div class="fs-7" data-kt-subtable="template_description">Deskripsi Produk</div>
					</td>
					<td>
						<div class="text-dark fs-7">Qty</div>
						<div class="text-muted fs-7 fw-bolder" data-kt-subtable="template_qty">0</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</div>
