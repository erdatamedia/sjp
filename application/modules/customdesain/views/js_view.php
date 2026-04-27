
<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
<script type="text/javascript">

	var typed = new Typed("#kt_title", {
	    strings: ["<?= isset($x['id_pesanan']) ? addslashes($x['id_pesanan']) : '' ?>"],
	    typeSpeed: 40,
	    showCursor: false
	});



	const id_pekerjaan = $('input[name=id]')
	const id_rule = $('input[name=id_rule]')
	const status = $('input[name=status]')
	const id_detail_pekerjaan = $('input[name=id_detail]')
	const id_barang = $('input[name=id_barang]')
	const qty_masuk = $('input[name=qty_masuk]')
	const qty_keluar = $('input[name=qty_keluar]')
	const inside = $('input[name=inside]')
	const outside = $('input[name=outside]')
	const note = $('.note')
	const modalNote = $('#modal_note')
	const noteIsian = $('textarea[name=deskripsi]')
	const indicator = $('.indicator')
	const indicator_1 = $('.indicator_1')
	const indicator_2 = $('.indicator_2')

	$('[data-kt-autosize="false"]').each((i,j)=>{
			autosize($(j));
	})

	function statusChangeTerkirim(el) {
		indicator.attr("data-kt-indicator", "on")
		let valid = true
		Swal.fire({
			title: "Perhatian <?= $user['role'] . " " . $user['name'] . " !" ?>",
			html: '<?= $kalimat ?>',
			icon: 'warning',
			allowOutsideClick: false,
			allowEscapeKey: false,
			buttonsStyling: false,
			showCancelButton: true,
			cancelmButtonText: 'Cancel',
			confirmButtonText: 'Ok',
			customClass: {
				cancelButton: 'btn btn-light-danger',
				confirmButton: 'btn btn-info',
			}
		}).then((res)=>{
			if (res.isConfirmed) {
				var formData = new FormData()
				if (status.val() == 'approved-customer') {
					formData.append('id', id_pekerjaan.val())
					formData.append('status', status.val())
					formData.append('id_rule', id_rule.val())
					id_detail_pekerjaan.each((index, item) => {
						formData.append('id_detail[]', id_detail_pekerjaan[index].value)
						formData.append('deskripsi[]', noteIsian[index].value)
					})
					saveChange(formData)
				}
			} else {
				indicator.removeAttr("data-kt-indicator")
			}
		})
	}

	function statusChange(el) {
		indicator.attr("data-kt-indicator", "on")
		let valid = true
		qty_masuk.each((index, item) => {
			if (qty_masuk[index].value == '') {
				valid = false
				$(qty_masuk[index]).css('background-color', 'red').css('color', 'white')
				toastr.error('Qty Lebih wajib di isi')
				indicator.removeAttr("data-kt-indicator")
			}else{
				$(qty_masuk[index]).css('color', '').css('background-color', '')
			}
		})
		qty_keluar.each((index, item) => {
			if (qty_keluar[index].value == '') {
				valid = false
				$(qty_keluar[index]).css('background-color', 'red').css('color', 'white')
				toastr.error('Qty Keluar wajib di isi')
				indicator.removeAttr("data-kt-indicator")
			}else{
				$(qty_keluar[index]).css('color', '').css('background-color', '')
			}
		})
		if (valid) {
			Swal.fire({
			    title: "Perhatian <?= $user['role'] . " " . $user['name'] . " !" ?>",
				html: '<?= $kalimat ?>',
				icon: 'warning',
				allowOutsideClick: false,
				allowEscapeKey: false,
				buttonsStyling: false,
				showCancelButton: true,
				cancelmButtonText: 'Cancel',
				confirmButtonText: 'Ok',
				customClass: {
					cancelButton: 'btn btn-light-danger',
					confirmButton: 'btn btn-info',
				}
			}).then((res)=>{
				if (res.isConfirmed) {
					var formData = new FormData()
					if (status.val() == 'cutting' && id_rule.val() == 1) {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						formData.append('id_rule', id_rule.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)
						})
						saveChange(formData)
					}
					if (status.val() == 'printing' && id_rule.val() == 1) {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						formData.append('id_rule', id_rule.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)
						})
						saveChange(formData)
					}
					if (status.val() == 'packing' && id_rule.val() == 1) {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						formData.append('id_rule', id_rule.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)
						})
						saveChange(formData)
					}
					if (status.val() == 'desain' && id_rule.val() == 2) {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						formData.append('id_rule', id_rule.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)
						})
						saveChange(formData)
					}
					if (status.val() == 'printing' && id_rule.val() == 2) {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						formData.append('id_rule', id_rule.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)
						})
						saveChange(formData)
					}
					if (status.val() == 'packing' && id_rule.val() == 2) {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						formData.append('id_rule', id_rule.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)
						})
						saveChange(formData)
					}
					if (status.val() == 'done') {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						formData.append('id_rule', id_rule.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('qty_masuk[]', qty_masuk[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)
						})
						saveChange(formData)
					}
					if (status.val() == 'approved') {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)
						})
						showModalAndSaveChanges();

					}
					if (status.val() == 'approved-shipping') {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('qty_keluar[]', qty_keluar[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)
						})
						saveChange(formData)
					}
				} else {
					indicator.removeAttr("data-kt-indicator")
				}
			})
		}

	}


	function statusChangeRule(el, statusRule, id_ruleStatus) {
		if (statusRule == 'desain') {
			text = 'Desain?'
			indicator_1.attr("data-kt-indicator", "on")
		}
		if (statusRule == 'cutting') {
			text = 'Cutting?'
			indicator_2.attr("data-kt-indicator", "on")
		}
		Swal.fire({
			title: "Perhatian <?= $user['role'] . " " . $user['name'] . " !" ?>",
			html: '<?= $kalimat ?>',
			icon: 'warning',
			allowOutsideClick: false,
			allowEscapeKey: false,
			buttonsStyling: false,
			showCancelButton: true,
			cancelmButtonText: 'Cancel',
			confirmButtonText: 'Ok',
			customClass: {
				cancelButton: 'btn btn-light-danger',
				confirmButton: 'btn btn-info',
			}
		}).then((res)=>{
			if (res.isConfirmed) {
				var formData = new FormData()
				formData.append('id', id_pekerjaan.val())
				formData.append('status', statusRule)
				formData.append('id_rule', id_ruleStatus)
				id_detail_pekerjaan.each((index, item) => {
					formData.append('id_detail[]', id_detail_pekerjaan[index].value)
					formData.append('deskripsi[]', noteIsian[index].value)
				})
				saveChange(formData)
				indicator_1.removeAttr("data-kt-indicator")
				indicator_2.removeAttr("data-kt-indicator")
			} else {
				indicator.removeAttr("data-kt-indicator")
				indicator_1.removeAttr("data-kt-indicator")
				indicator_2.removeAttr("data-kt-indicator")
			}
		})
	}

	function statusChangeCallback(el, statusRule, id_ruleStatus) {
		indicator_2.attr("data-kt-indicator", "on")
		Swal.fire({
			title: "Perhatian <?= $user['role'] . " " . $user['name'] . " !" ?>",
			html: 'Harap pastikan bahwa pekerjaan ada revisi sebelum menekan tombol <span class="badge badge-info">Ok</span> untuk pekerjaan <?= $x['id_pesanan'] ?>',
			icon: 'warning',
			allowOutsideClick: false,
			allowEscapeKey: false,
			buttonsStyling: false,
			showCancelButton: true,
			cancelmButtonText: 'Cancel',
			confirmButtonText: 'Ok',
			customClass: {
				cancelButton: 'btn btn-light-danger',
				confirmButton: 'btn btn-info',
			}
		}).then((res)=>{
			if (res.isConfirmed) {
				var formData = new FormData()
				formData.append('id', id_pekerjaan.val())
				formData.append('status', statusRule)
				formData.append('id_rule', id_ruleStatus)
				id_detail_pekerjaan.each((index, item) => {
					formData.append('id_detail[]', id_detail_pekerjaan[index].value)
					formData.append('deskripsi[]', noteIsian[index].value)
				})
				saveChange(formData)
				indicator_2.removeAttr("data-kt-indicator")
			} else {
				indicator_2.removeAttr("data-kt-indicator")
			}
		})
	}

	function showModalAndSaveChanges() {
		modalNote.modal('show');
	}


	function saveChange(formData) {
		$.ajax({
			url: '<?= base_url('api/'.$module.'/changeStatus') ?>',
			data: formData,
			contentType: false,
			processData: false,
			type: 'POST',
			success: function(response) {
				if (response.status == true) {
					window.location.href = '<?= base_url('customdesain/view/') ?>' + id_pekerjaan.val()
					toastr.success(response['msg'])
					indicator.removeAttr("data-kt-indicator")
				}

				if (response.status == false) {
					toastr.warning(response['msg'])
					indicator.removeAttr("data-kt-indicator")
				}
			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	}


	function saveNote(e) {
		let payload = {
			id_pekerjaan: id_pekerjaan.val(),
			note: note.val(),
		}
		$.ajax({
			url: '<?= base_url('api/note/save') ?>',
			data: payload,
			type: 'POST',
			success: function(response) {
				if (response['code'] == 201) {
					modalNote.modal('hide')
					var formData = new FormData()
					if (status.val() == 'approved') {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)
						})
						saveChange(formData);

					}
				}

			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	}

	function saveCancelNote(el) {
		modalNote.modal('hide')
		var formData = new FormData()
		if (status.val() == 'approved') {
			formData.append('id', id_pekerjaan.val())
			formData.append('status', status.val())
			id_detail_pekerjaan.each((index, item) => {
				formData.append('id_detail[]', id_detail_pekerjaan[index].value)
				formData.append('deskripsi[]', noteIsian[index].value)
			})
			saveChange(formData);

		}
	}

	function modalDetail(el,id) {
		$.ajax({
			url: '<?= base_url('api/'.$module.'/barang') ?>',
			data: {id:id},
			type: 'GET',
			success: function(response) {
				$('#modal_produk').modal('show')
				$('.no-mc').text(response.no_mc)
				$('.item-box').text(response.item_box)
				$('.size').text(response.size)
				$('.spesifikasi-mc').text(response.substance)
				$('.model-box').text(response.name_box)
				$('.joint').text(response.name_joint  ? response.name_joint : "Empty")
				$('.papan-pisau').text(response.name_papan ? response.name_papan : "Empty")
				$('.isian').text(response.deskripsi)
			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	}
</script>
