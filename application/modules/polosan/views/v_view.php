<style type="text/css">
	.ql-container {
		height: auto;
	}
</style>
<form class="container-fluid" id="content_container">
	<div class="card mb-5">
		<input type="hidden" name="id" value="<?= $x ? $x['id'] : '' ?>" />
		<input type="hidden" name="status" value="<?= $statusChange ?>">
		<div class="card-header align-items-center" id="card-header">
			<div class="btn-group btn-group-sm my-2 my-sm-0">
				<a href="<?= base_url($module) ?>" class="btn btn-light btn-sm"><i class="bi bi-chevron-left"></i></a>
				<?php if ($x['status'] == $status && $x['status'] != 'approved-shipping'): ?>
							<button type="button" class="btn btn-primary btn-sm indicator" onclick="statusChange(this)">
							<span class="indicator-label">
								Completed
							</span>
							<span class="indicator-progress">
								Please Wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
							</span>
						</button>
					<?php endif ?>
					<?php if ($x['status'] == 'approved-shipping' && $user['id_role'] == 7):  ?>
						<button type="button" class="btn btn-primary btn-sm indicator" onclick="statusChangeTerkirim(this)">
							<span class="indicator-label">
								Completed
							</span>
							<span class="indicator-progress">
								Please Wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
							</span>
						</button>
					<?php endif ?>
					
					<?php if ($user['id_role'] == 1 || $user['id_role'] == 10): ?>
						<a target="_blank" href="<?= base_url('prints/spkPolosan/'). $x['id'] ?>" class="btn btn-light">SPK</a>
					<?php endif ?>
			</div>

			<?php if ($x) { ?>
				<div class="btn-group btn-group-sm my-2 my-sm-0">
					<a href="<?= base_url($module.'/view/'.$prev) ?>" class="btn btn-light <?= $prev ? '' : 'disabled' ?>">Prev</a>
					<span class="btn border pe-none text-gray-600"><?= $i.' / '.$j ?></span>
					<a href="<?= base_url($module.'/view/'.$next) ?>" class="btn btn-light <?= $next ? '' : 'disabled' ?>">Next</a>
				</div>
			<?php } ?>
		</div>
		<div class="card-header ribbon ribbon-top ribbon-vertical">
			<div class="ribbon-label fw-bolder" style="background: <?= $bg ?>; color: <?= $statusRibbon == 'Approved QC' ? 'black' : 'white' ?>;">
				<?= $statusRibbon ?>
				<?php if ($x['status'] == 'approved-shipping'): ?>
					<dotlottie-player src="https://lottie.host/0d5e356a-930d-44bc-bdd1-ef81c6c335ef/pKdMbB9Rpb.json" background="transparent" speed="1" style="width: 60px; height: 60px;" direction="1" playMode="normal" loop autoplay></dotlottie-player>
				<?php endif ?>
				<?php if ($x['status'] == 'approved-customer'): ?>
					<dotlottie-player src="https://lottie.host/6623c85c-cbf7-4d06-a503-aa171b136109/dKtcGRHi6j.json" background="transparent" speed="1" style="width: 60px; height: 60px;" direction="1" playMode="normal" loop autoplay></dotlottie-player>
				<?php endif ?>
			</div>
			<div class="d-flex flex-column align-items-end px-3 py-2 gap-1">
				<?php if (!empty($x['completed_at'])): ?>
				<small class="text-muted"><span class="fw-bold">Selesai:</span> <?= date('d/m/Y H:i', strtotime($x['completed_at'])) ?></small>
				<?php endif ?>
				<?php if (!empty($x['shipped_at'])): ?>
				<small class="text-muted"><span class="fw-bold">Dikirim:</span> <?= date('d/m/Y H:i', strtotime($x['shipped_at'])) ?></small>
				<?php endif ?>
			</div>
			<div class="card-title">
				<?php if ($x['status'] == 'approved-shipping'): ?>
					<span class="badge badge-info" style="margin-right: 4px;">Delivery</span>
				<?php endif ?>
				<span id="kt_title" class="fs-2 fw-bolder"></span>
				
				 
			</div>
		</div>

		<div class="card-body row" id="div-info">
			<input type="hidden" name="id_user" value="<?= $user['id'] ?>">
			<div class="col-xl-4">
				<div class="card  mb-xl-8 mb-5" style="border: 5px solid <?= $setting_template['color_navbar'] ?>;">
					<div class="card-body d-flex align-items-center pt-3 pb-1">
					    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-6 me-2">
							<span class="fw-bolder text-dark fs-4 mb-2">Order Type</span>
							<?php if ($x['jenis_order'] == 'repeat-order'): ?>
								<span class="fw-bold text-muted fs-5">Repeat Order</span>
							<?php endif ?>
							<?php if ($x['jenis_order'] == 'new-order'): ?>
								<span class="fw-bold text-muted fs-5">New Order</span>
							<?php endif ?>
							<?php if ($x['jenis_order'] == 'lainnya'): ?>
								<span class="fw-bold text-muted fs-5">Other</span>
							<?php endif ?>
								
						</div>
						<img src="<?= base_url('assets/media/icon/shopping-list.png') ?>" alt="" class="align-self-end h-80px" />
					</div>
				</div>
			</div>
			<div class="col-xl-4">
				<div class="card  mb-xl-8 mb-5" style="border: 5px solid <?= $setting_template['color_navbar'] ?>;">
					<div class="card-body d-flex align-items-center pt-3 pb-1">
					    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-6 me-2">
							<span class="fw-bolder text-dark fs-4 mb-2">Sales</span>
								<span class="fw-bold text-muted fs-5"><?= $x?$x['name'] : '' ?></span>
								
						</div>
						<img src="<?= base_url('assets/media/icon/office-worker.png') ?>" alt="" class="align-self-end h-80px" />
					</div>
				</div>
			</div>
			<div class="col-xl-4">
				<div class="card  mb-xl-8 mb-5" style="border: 5px solid <?= $setting_template['color_navbar'] ?>;">
					<div class="card-body d-flex align-items-center pt-3 pb-1">
					    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-6 me-2">
							<span class="fw-bolder text-dark fs-4 mb-2">Date</span>
								<span class="fw-bold text-muted fs-5"><?= $x? date('d/m/Y', strtotime($x['created_at']))  : '' ?></span>
								
						</div>
						<img src="<?= base_url('assets/media/icon/calendar.png') ?>" alt="" class="align-self-end h-80px" />
					</div>
				</div>
			</div>
			<div class="col-xl-4">
				<div class="card  mb-xl-8 mb-5" style="border: 5px solid <?= $setting_template['color_navbar'] ?>;">
					<div class="card-body d-flex align-items-center pt-3 pb-1">
					    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-6 me-2">
							<span class="fw-bolder text-dark fs-4 mb-2">Due Date</span>
							<?php
								$due = $x['due_date'];
								$now = date('Y-m-d');
							?>
								<span class="fw-bold  fs-5 <?= (strtotime($due) < strtotime($now) && $x['status'] != 'approved-shipping' && $x['status'] != 'approved-customer') ? 'text-danger' : 'text-muted' ?>"><?= $x ? date('d/m/Y', strtotime($due)) : '' ?></span>
								
						</div>
						<img src="<?= base_url('assets/media/icon/wait.png') ?>" alt="" class="align-self-end h-80px" />
					</div>
				</div>
			</div>
			<div class="col-xl-4">
				<div class="card  mb-xl-8 mb-5" style="border: 5px solid <?= $setting_template['color_navbar'] ?>;">
					<div class="card-body d-flex align-items-center pt-3 pb-1">
					    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-6 me-2">
							<span class="fw-bolder text-dark fs-4 mb-2">Duration <?= (strtotime($due) < strtotime($now) && $x['status'] != 'approved-shipping' && $x['status'] != 'approved-customer') ? ' <span class="badge badge-danger">Late</span>': ''  ?></span>
								<span class="fw-bold fs-5 <?= (strtotime($due) < strtotime($now) && $x['status'] != 'approved-shipping' && $x['status'] != 'approved-customer') ? 'text-danger' : 'text-muted' ?>"><?= $x['durasi'] . " Day" ?></span>
								
						</div>
						<img src="<?= base_url('assets/media/icon/time.png') ?>" alt="" class="align-self-end h-80px" />
					</div>
				</div>
			</div>
			<div class="col-xl-4">
				<div class="card mb-xl-8 mb-5" style="border: 5px solid <?= $setting_template['color_navbar'] ?>;">
					<div class="card-body d-flex align-items-center pt-3 pb-1">
					    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-6 me-2">
							<span class="fw-bolder text-dark fs-4 mb-2">Delivery Date</span>
								<span class="fw-bold fs-5 text-muted"><?= $x['tgl_pengiriman']? date('d/m/Y', strtotime($x['tgl_pengiriman']))  : 'Empty' ?></span>
								
						</div>
						<img src="<?= base_url('assets/media/icon/delivery-time.png') ?>" alt="" class="align-self-end h-80px" />
					</div>
				</div>
			</div>

			<?php if ($user['id_role'] == 7): ?>
				<button id="kt_drawer_note" class="btn btn-primary btn-sm col-2" style="margin-left: 8px;">see note</button>
			<?php endif ?>
			
		</div>
	</div>
	<div class="card card-flush mb-5" id="card-line">
		<div class="card-header">
			<div class="card-title">
				<h3>Order Details</h3>
			</div>
		</div>
		<div class="card-body pt-0">
			<div class="d-flex flex-column">
				<div class="form-group">
					<table class="table table-responsive">
						<tbody>
							<?php foreach ($x['detail'] as $key => $line): ?>
								<?php if ($line['barang']): ?>
									<tr>
									<td>
										<div class="mb-2 col-md-10">
											<label class="form-label">Product &amp; Isian</label>
											<input type="hidden" name="id_detail" value="<?= $line['id'] ?>">
											<div class="fw-bolder" onclick="modalDetail(this, <?= $line['id_barang'] ?>)" style="color: blue; cursor: pointer;"><?= $line['barang']['no_mc'] . " ". $line['barang']['item_box'] ?></div>
											<div class="d-flex flex-column mt-1 gap-1">
												<small class="text-muted">
													<span class="fw-bold">Tgl Dibuat:</span>
													<?= $x['created_at'] ? date('d/m/Y', strtotime($x['created_at'])) : '-' ?>
												</small>
												<?php if (!empty($x['completed_at'])): ?>
												<small class="text-muted">
													<span class="fw-bold">Tgl Selesai:</span>
													<?= date('d/m/Y H:i', strtotime($x['completed_at'])) ?>
												</small>
												<?php endif ?>
												<?php if (!empty($x['shipped_at'])): ?>
												<small class="text-muted">
													<span class="fw-bold">Tgl Dikirim:</span>
													<?= date('d/m/Y H:i', strtotime($x['shipped_at'])) ?>
												</small>
												<?php endif ?>
											</div>
											<div class="mb-2"><?= $line['barang']['deskripsi'] ?></div>
											<div class="d-flex mt-2">
											    <a href="<?= base_url('polosan/upload/') . $line['id_barang'] . '/' . $x['id'] ?>"
											       class="btn btn-primary btn-sm">
											        Design Documents
											        <?php
											        $has_outside = !empty($line['barang']['outside']);
											        $has_inside  = !empty($line['barang']['inside']);
											        $count = ($has_outside ? 1 : 0) + ($has_inside ? 1 : 0);
											        echo $count . '/2';
											        ?>
											        <i class="bi bi-arrow-right-circle ms-1"></i>
											    </a>
											</div>
											<label class="form-label fw-bolder">Note</label>
											<?php
												$disabled = 'disabled';
												if ($x['status'] == $status) {
													$disabled = '';
												}  else if ($user['id_role'] == 7 && $x['status'] == 'approved-shipping'){
													$disabled = '';
												}
												?>
												

												<textarea class="form-control form-control-sm mb-2" name="deskripsi" <?= $disabled ?> data-kt-autosize="true" oninput="autoResize(this)" > <?= $line['deskripsi'] ? $line['deskripsi'] : 'Empty' ?>
												</textarea>

										</div>
									</td>
									<td>
										<label class="form-label">Qty</label>
										<div class="fw-bolder"><?= $line['qty'] ?></div>
									</td>
									<td>
										
										<?php if ($x['status'] == 'packing' && $user['id_role'] == 6): ?>
											<label class="form-label">Qty In</label>
											<input type="number" name="qty_masuk" class="form-control">
										<?php elseif($line['qty_masuk']): ?>
											<label class="form-label">Qty In</label>
											<div class="fw-bolder"><?= $line['qty_masuk'] ? $line['qty_masuk'] : "Empty" ?></div>
										<?php endif ?>
									</td>
									<td>
										
										<?php if ($x['status'] == 'approved' && $user['id_role'] == 7): ?>
											<label class="form-label">Qty Out</label>
											<input type="number" name="qty_keluar" class="form-control">
										<?php elseif($line['qty_keluar']): ?>
											<label class="form-label">Oty Out</label>
											<div class="fw-bolder"><?= $line['qty_keluar'] ?></div>
										<?php endif ?>
									</td>
								</tr>
								<?php endif ?>
								
							<?php endforeach ?>
							
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</form>


<div class="modal fade" id="modal_produk" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="kt_modal_add_user_header">
				<h2 class="fw-bolder">Product Information</h2>
				<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                    	<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path opacity="0.3" d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z" fill="black"/>
						<path d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z" fill="black"/>
						</svg></span>
                    </span>
                </div>
			</div>
			<div class="modal-body">
				<div class="row mb-7">
					<label class="col-lg-4 fw-bold text-muted">No MC</label>
					<div class="col-lg-8">
						<span class="fw-bolder fs-6 text-gray-800 no-mc"></span>
					</div>
				</div>
				<div class="row mb-7">
					<label class="col-lg-4 fw-bold text-muted">Nama Produk</label>
					<div class="col-lg-8">
						<span class="fw-bolder fs-6 text-gray-800 item-box"></span>
					</div>
				</div>
				<div class="row mb-7">
					<label class="col-lg-4 fw-bold text-muted">Ukuran Produk</label>
					<div class="col-lg-8">
						<span class="fw-bolder fs-6 text-gray-800 size"></span>
					</div>
				</div>
				<div class="row mb-7">
					<label class="col-lg-4 fw-bold text-muted">Substance/Flute</label>
					<div class="col-lg-8">
						<span class="fw-bolder fs-6 text-gray-800 spesifikasi-mc"></span>
					</div>
				</div>
				<div class="row mb-7">
					<label class="col-lg-4 fw-bold text-muted">Model Produk</label>
					<div class="col-lg-8">
						<span class="fw-bolder fs-6 text-gray-800 model-box"></span>
					</div>
				</div>
				<div class="row mb-7">
					<label class="col-lg-4 fw-bold text-muted">Joint</label>
					<div class="col-lg-8">
						<span class="fw-bolder fs-6 text-gray-800 joint"></span>
					</div>
				</div>
				<div class="row mb-7">
					<label class="col-lg-4 fw-bold text-muted">Cutting Board</label>
					<div class="col-lg-8">
						<span class="fw-bolder fs-6 text-gray-800 papan-pisau"></span>
					</div>
				</div>
				<div class="row mb-7">
					<label class="col-lg-4 fw-bold text-muted">Specifications</label>
					<div class="col-lg-8">
						<span class="fw-bolder fs-6 text-gray-800 isian"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_note" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="kt_modal_add_user_header">
				<h2 class="fw-bolder">Note</h2>
			</div>
			<div class="modal-body">
				<div class="text-center mb-5">
					<span>
						Please provide a description for the task <?= $x['id_pesanan'] ?>	
					</span>
					
				</div>
				<textarea class="form-control note"></textarea>
				<div class="text-center pt-15">
					<button type="button" onclick="saveCancelNote(this)" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
					<button type="button" onclick="saveNote(this)" class="btn btn-info">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div
    id="kt_drawer_note"

    class="bg-white"
    data-kt-drawer="true"
    data-kt-drawer-activate="true"
    data-kt-drawer-toggle="#kt_drawer_note"
    data-kt-drawer-close="#kt_drawer_example_basic_close"
    data-kt-drawer-permanent="true"
    data-kt-drawer-width="500px"
>
     <div class="card rounded-0 w-100">
        <div class="card-header pe-5">
            <div class="card-title">
                Note
            </div>
            <div class="card-toolbar">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_example_permanent_close">
                    <span class="svg-icon fs-1">
                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path opacity="0.3" d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z" fill="black"/>
						<path d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z" fill="black"/>
						</svg></span>
                    </span>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body hover-scroll-overlay-y">
        	<p><?= $note?  implode("\n", $note) : "Tidak Ada Pesan" ?></p>
        </div>
        <!--end::Card body-->
    </div>

</div>
