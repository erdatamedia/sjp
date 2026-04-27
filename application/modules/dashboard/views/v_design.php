<div class="container-fluid" id="kt_content_container">
	<table class="table">
		<?php foreach ($x['detail_pekerjaan'] as $key => $line): ?>
			<tr>
				<td>
					<div class="fs-1 text-end mt-5">
						No. MC
						<span class="mx-3 px-3" style="border: 4px solid #6d1f09;border-radius: 6px;"><?= $line['barang']['no_mc'] ?></span>
					</div>
					<div class="border mt-1 align-self-end">
						<div class="row text-center">
							<?php if ($line['barang']['outside']): ?>
								<div class="h-550px">
									<img class="h-100" src="<?= $line['barang']['outside'] ?  base_url('assets/uploads/barang/'.$line['barang']['outside']) : $blank_product ?>" />
								</div>
								<div class="row mx-1 mb-1 h-5">
									<div class="col-3 border px-1">
										<table>
											<tbody>
												<tr>
													<td class="text-center">
														<img class="w-125px mb-5" src="<?= base_url('assets/media/logos/logo_sbti.png') ?>" />
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
											<div class="col-4 px-1">Nama Item Box</div>
											<div class="col-8 px-0">: <?= $line['barang']['item_box'] ?></div>
										</div>
										<div class="row border fs-9 py-1">
											<div class="col-4 px-1">Ukuran PK</div>
											<div class="col-8 px-0">: <?= $line['barang']['size'] ?></div>
										</div>
										<div class="row border fs-9 py-1">
											<div class="col-4 px-1">Model Box</div>
											<div class="col-8 px-0">: <?= $line['barang']['name_box'] ?></div>
										</div>
										<div class="row border fs-9 py-1">
											<div class="col-4 px-1">Subtance/Flute</div>
											<div class="col-8 px-0">: <?= $line['barang']['substance'] ?></div>
										</div>
									</div>
									<div class="col-3 border fs-8">
										<div class="row border">
											<div class="col-4 py-2 px-1">Papan Pisau</div>
											<div class="col-6 py-2 px-1">: <?= $line['barang']['name_papan'] ? $line['barang']['name_papan'] : "Kosong"  ?></div>
										</div>
										<div class="row border">
											<div class="col-4 py-2 px-1">Joint</div>
											<div class="col-6 py-2 px-1">: <?= $line['barang']['name_joint'] ?></div>
										</div>
										<div class="row border">
											<div class="col-5 py-1 px-1">Keterangan</div>
											<div class="col-1 py-1 px-1">:</div>
											<div class="col-6 py-1 px-1">
												<div class="d-flex">
													<div class="col-3">
														<span class="svg-icon">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
															</svg>
														</span>
														Color
													</div>
													
													<div class="col-3">
														<span class="svg-icon">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
															</svg>
														</span>
														Dalam
													</div>
													<div class="col-3">
														<span class="svg-icon">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
																<path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black" style="fill: black !important;"/>
															</svg>
														</span>
														Luar
													</div>
												</div>
											</div>
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
							<?php endif ?>
							<?php if ($line['barang']['inside']): ?>
								<div class="h-600px">
									<img class="h-100" src="<?= $line['barang']['inside'] ? base_url('assets/uploads/barang/'.$line['barang']['inside']) : $blank_product ?>" />
								</div>
								<div class="row mx-1 mb-1 h-5 align-self-end">
									<div class="col-3 border px-1">
										<table>
											<tbody>
												<tr>
													<td class="text-center">
														<img class="w-125px mb-5" src="<?= base_url('assets/media/logos/logo_sbti.png') ?>" />
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
											<div class="col-4 px-1">Nama Item Box</div>
											<div class="col-8 px-0">: <?= $line['barang']['item_box'] ?></div>
										</div>
										<div class="row border fs-9 py-1">
											<div class="col-4 px-1">Ukuran PK</div>
											<div class="col-8 px-0">: <?= $line['barang']['size'] ?></div>
										</div>
										<div class="row border fs-9 py-1">
											<div class="col-4 px-1">Model Box</div>
											<div class="col-8 px-0">: <?= $line['barang']['name_box'] ?></div>
										</div>
										<div class="row border fs-9 py-1">
											<div class="col-4 px-1">Subtance/Flute</div>
											<div class="col-8 px-0">: <?= $line['barang']['substance'] ?></div>
										</div>
									</div>
									<div class="col-3 border fs-8">
										<div class="row border">
											<div class="col-4 py-2 px-1">Papan Pisau</div>
											<div class="col-6 py-2 px-1">: <?= $line['barang']['name_papan'] ? $line['barang']['name_papan'] : "Kosong"  ?></div>
										</div>
										<div class="row border">
											<div class="col-4 py-2 px-1">Joint</div>
											<div class="col-6 py-2 px-1">: <?= $line['barang']['name_joint'] ?></div>
										</div>
										<div class="row border">
											<div class="col-5 py-1 px-1">Keterangan</div>
											<div class="col-1 py-1 px-1">:</div>
											<div class="col-6 py-1 px-1">
												<div class="d-flex">
													<div class="col-3">
														<span class="svg-icon">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
															</svg>
														</span>
														Color
													</div>
													<div class="col-3">
														<span class="svg-icon">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
															</svg>
														</span>
														Dalam
													</div>
													<div class="col-3">
														<span class="svg-icon">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black"/>
																<path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black" style="fill: black !important;"/>
															</svg>
														</span>
														Luar
													</div>
												</div>
											</div>
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
							<?php endif ?>
						</div>
						<div class="row text-center">
							<?php if ($line['barang']['color']): ?>
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
														<img class="h-100" src="<?= base_url('assets/uploads/barang/'.$line['barang']['color']) ?>" <?= $line['barang']['color']?'style="max-width: 50%;"':'style="max-width: 100%"' ?> />

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
															<span class="ms-2 text-nowrap">Nama Box</span>
														</td>
														<td>:</td>
														<td class="fw-bolder"><?= $line['barang']['item_box'] ?></td>
													</tr>
													<tr class="border border-2">
														<td>
															<span class="ms-2 text-nowrap">Ukuran PK</span>
														</td>
														<td>:</td>
														<td class="fw-bolder"><?= $line['barang']['size'] ?></td>
													</tr>
													<tr class="border border-2">
														<td>
															<span class="ms-2 text-nowrap">Model Box</span>
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
							<?php endif ?>
						</div>
						
						
					</div>
				</td>
			</tr>
			
		<?php endforeach ?>
	</table>
</div>