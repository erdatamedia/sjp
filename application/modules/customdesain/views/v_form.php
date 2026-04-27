<style type="text/css">
    .ql-container {
        height: auto;
    }

    /* Hari ini & sebelumnya ditampilkan merah di kalender flatpickr */
    .flatpickr-day.flatpickr-disabled,
    .flatpickr-day.flatpickr-disabled:hover {
        color: #dc3545 !important;
        background: rgba(220,53,69,.07) !important;
        text-decoration: line-through;
        opacity: 1 !important;
        cursor: not-allowed;
    }
</style>
<form class="container-fluid" id="content_container" action="<?= base_url('customdesain/save') ?>" method="post" enctype="multipart/form-data">
    <div class="card mb-5">
        <input type="hidden" name="id" value="<?= $x ? $x['id'] : '' ?>" />
        <div class="card-header align-items-center" id="card-header">
            <div class="btn-group btn-group-sm my-2 my-sm-0">
                <a href="<?= base_url($module) ?>" class="btn btn-light btn-sm me-3"><i class="fa fa-chevron-left"></i></a>
            </div>
            <div class="my-2 my-sm-0">
                <div class="btn-group btn-group-sm">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
        <div class="card-body row" id="div-info">
            <input type="hidden" name="id_user" value="<?= $user['id'] ?>">
            <div class="col-md-4">
                <label class="required form-label">Order ID</label>
                <div class="input-group input-group-sm flex-nowrap mb-2">
                    <input class="form-control" name="id_pesanan" value="<?= $x?$x['id_pesanan'] : '' ?>"/>
                </div>
            </div>
             <div class="col-md-4">
                    <label class="required form-label">Order Type</label>
                    <div class="input-group input-group-sm flex-nowrap mb-2">
                        <?php if (!empty($x['jenis_order'])): ?>
                            <select class="form-select jenis-order" name="jenis_order" onchange="handleTanggal(this)">
                            <option value="repeat-order" <?= ($x['jenis_order'] == 'repeat-order') ? 'selected' : '' ?> >Repeat Order</option>
                            <option value="new-order" <?= ($x['jenis_order'] == 'new-order') ? 'selected' : '' ?> >New Order</option>
                            <option value="lainnya" <?= ($x['jenis_order'] == 'lainnya') ? 'selected' : '' ?> >Other</option>
                        </select>
                        <?php endif ?>
                        <?php if (empty($x['jenis_order'])): ?>
                             <select class="form-select jenis-order" name="jenis_order" onchange="handleTanggal(this)">
                            <option value="repeat-order" >Repeat Order</option>
                            <option value="new-order" >New Order</option>
                            <option value="lainnya"  >Other</option>
                        </select>
                        <?php endif ?>
                    </div>
                </div>

            <div class="col-md-4">
				<label class="required form-label">Delivery Date</label>
				<small class="text-muted d-block">Minimal: <strong><?= date('d/m/Y', strtotime('+1 day')) ?></strong></small>
				<div class="input-group input-group-sm flex-nowrap mb-2">
					<input class="form-control" required name="tgl_pengiriman" value="<?= $x? $x['tgl_pengiriman'] : '' ?>"/>
				</div>
			</div>
			 <div class="col-md-4 group-tanggal">
                    <label class="required form-label">Due Date</label>
                    <div class="input-group input-group-sm flex-nowrap mb-2">
                        <input class="form-control" name="due_date" value="<?= $x?$x['due_date'] : '' ?>"/>
                    </div>
                </div>
        <div class="col-md-4">
            <label class="required form-label">Tipe Desain</label>
            <div class="input-group input-group-sm flex-nowrap mb-2">
                <select class="form-select" name="design_type" id="design_type_select"
                        onchange="toggleDesignUpload(this.value)" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="polos" <?= ($x && $x['design_type']=='polos') ? 'selected' : '' ?>>Polos</option>
                    <option value="bergambar" <?= ($x && $x['design_type']=='bergambar') ? 'selected' : '' ?>>Bergambar</option>
                    <option value="stiker" <?= ($x && $x['design_type']=='stiker') ? 'selected' : '' ?>>Stiker</option>
                </select>
            </div>
        </div>
        <div class="col-md-4" id="design_attachment_group" style="display:<?= ($x && in_array($x['design_type'], ['bergambar','stiker'])) ? 'block' : 'none' ?>;">
            <label class="form-label" id="design_attachment_label">Lampiran Desain</label>
            <small class="text-muted d-block">Wajib untuk tipe Bergambar/Stiker</small>
            <div class="input-group input-group-sm flex-nowrap mb-2">
                <input type="file" class="form-control" name="design_attachment"
                       id="design_attachment_input">
            </div>
            <?php if ($x && $x['design_attachment']): ?>
            <small class="text-success">File saat ini: <?= $x['design_attachment'] ?></small>
            <?php endif; ?>
        </div>
        </div>
    </div>
    <div class="card card-flush mb-5" id="card-line">
        <div class="card-header">
            <div class="card-title">
                <h3>Order Line</h3>
            </div>
        </div>
        <div class="card-body pt-0">
            <div id="kt_docs_repeater_basic">
                <?php if (!empty($x['detail'])): ?>
                    <div data-repeater-list="kt_docs_repeater_basic">
                        <?php foreach ($x['detail'] as $key => $line): ?>
                            <div data-repeater-item="">
                                <div class="form-group row mb-5">
                                    <input type="hidden" name="id_detail" data-field="id_detail" value="<?=$line['id'] ?>" />
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="required form-label">Product</label>
                                        <div class="input-group input-group-sm flex-nowrap mb-2">
                                            <span class="input-group-text cursor-pointer bg-hover-danger text-hover-white" href="javascript:;" data-repeater-delete="">
                                                <i class="la la-trash fs-3"></i>
                                            </span>
                                            <div class="overflow-hidden flex-grow-1">
                                                <select class="form-select form-select-sm rounded-0" data-placeholder="Select a product" name="id_barang" data-field="id_barang">
                                                    <?php foreach ($produk as $key => $product): ?>
                                                        <option value="<?= $product['id'] ?>" <?= ($line && isset($line['id'])) ? (($line['id_barang']==$product['id']) ? 'selected' : '') : '' ?>>
                                                            <?= ($product['no_mc'] ? $product['no_mc'].' - ' : '' ).$product['item_box'] ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <textarea name="deskripsi" data-field="deskripsi" class="form-control form-control-sm mb-2" data-kt-autosize="true"><?= $line['deskripsi'] ?></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="required form-label">Qty</label>
                                        <input type="number" step="any" name="qty" data-field="qty" class="form-control form-control-sm mb-2 mb-md-0" value="<?= $line['qty'] ?>" required />
                                    </div>
                                </div>
                                <div class="separator mb-5"></div>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
                <?php if (empty($x['detail'])) { ?>
                    <div data-repeater-list="kt_docs_repeater_basic">
                        <div data-repeater-item="">
                            <div class="form-group row mb-5">
                                <input type="hidden" name="id_detail_pekerjaan" data-field="id_detail_pekerjaan" />
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="required form-label">Product</label>
                                    <div class="input-group input-group-sm flex-nowrap mb-2">
                                        <span class="input-group-text cursor-pointer bg-hover-danger text-hover-white" href="javascript:;" data-repeater-delete="">
                                            <i class="la la-trash fs-3"></i>
                                        </span>
                                        <div class="overflow-hidden flex-grow-1">
                                            <select class="form-select form-select-sm rounded-0" name="id_barang" data-field="id_barang" required>
                                                <option value="">Select a product</option>
                                                <?php foreach ($produk as $key => $product): ?>
                                                    <option value="<?= $product['id'] ?>">
                                                        <?= ($product['no_mc'] ? $product['no_mc'].' - ' : '' ). $product['item_box'] ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <textarea name="deskripsi" data-field="deskripsi" class="form-control form-control-sm mb-2" placeholder="Note"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="required form-label">Qty</label>
                                    <input type="number" step="any" name="qty" data-field="qty" class="form-control form-control-sm mb-2 mb-md-0" value="0" required />
                                </div>
                            </div>
                            <div class="separator mb-5"></div>
                        </div>
                    </div>
                <?php } ?>
                <a href="javascript:;" data-repeater-create="" class="btn btn-light btn-active-light-primary my-5">
                    <i class="la la-plus"></i>Add
                </a>
            </div>
        </div>
    </div>
<script>
function toggleDesignUpload(val) {
    var group = document.getElementById('design_attachment_group');
    var input = document.getElementById('design_attachment_input');
    if (val === 'bergambar' || val === 'stiker') {
        group.style.display = 'block';
        input.setAttribute('required', 'required');
    } else {
        group.style.display = 'none';
        input.removeAttribute('required');
    }
}
document.addEventListener('DOMContentLoaded', function() {
    var sel = document.getElementById('design_type_select');
    if (sel) toggleDesignUpload(sel.value);
});
</script>
</form>
