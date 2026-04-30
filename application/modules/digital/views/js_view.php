
<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
<script type="text/javascript">

	var typed = new Typed("#kt_title", {
	    strings: ["<?= isset($x['id_pesanan']) ? addslashes($x['id_pesanan']) : '' ?>"],
	    typeSpeed: 40,
	    showCursor: false
	});

	
	const id_pekerjaan = $('input[name=id]')
	const status = $('input[name=status]')
	const id_detail_pekerjaan = $('input[name=id_detail]')
	const material = $('input[name=material]')
	const inside = $('input[name=inside]')
	const outside = $('input[name=outside]')
	const pcs     = $('input[name=qty_object]')
	const reject_pcs     = $('input[name=reject_object]')
	const note = $('.note')
	const modalNote = $('#modal_note')
	const indicator = $('.indicator')
	const noteIsian = $('textarea[name=deskripsi]')
	const indicator_1 = $('.indicator_1')
	const indicator_2 = $('.indicator_2')

	$('[data-kt-autosize="false"]').each((i,j)=>{
			autosize($(j));
	})


	function statusChange(el) {
		indicator.attr("data-kt-indicator", "on")
		let valid = true
		pcs.each((index, item) => {
			if (pcs[index].value == '') {
				valid = false
				$(pcs[index]).css('background-color', 'red').css('color', 'white')
				toastr.error('Pcs per Lembar Lebih wajib di isi')
				indicator.removeAttr("data-kt-indicator")
			}else{
				$(pcs[index]).css('color', '').css('background-color', '')
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
				cancelButtonText: 'Cancel',
				confirmButtonText: 'Ok',
				customClass: {
					cancelButton: 'btn btn-light-danger',
					confirmButton: 'btn btn-info',
				}
			}).then((res)=>{
				if (res.isConfirmed) {
					var formData = new FormData()
					if (status.val() == 'printing') {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)
						})
						saveChange(formData)
					}
					if (status.val() == 'packing') {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)

						})
						saveChange(formData)
					}

					if (status.val() == 'approved-customer') {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
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
		
	}

	function statusChangeShipping(el) {
		indicator.attr("data-kt-indicator", "on")
		let valid = true
		pcs.each((index, item) => {
			if (pcs[index].value == '') {
				valid = false
				$(pcs[index]).css('background-color', 'red').css('color', 'white')
				toastr.error('Qty/Object wajib di isi')
				indicator.removeAttr("data-kt-indicator")
			}else{
				$(pcs[index]).css('color', '').css('background-color', '')
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
				cancelButtonText: 'Cancel',
				confirmButtonText: 'Ok',
				customClass: {
					cancelButton: 'btn btn-light-danger',
					confirmButton: 'btn btn-info',
				}
			}).then((res)=>{
				if (res.isConfirmed) {
					var formData = new FormData()
					if (status.val() == 'packing') {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('qty_object[]', pcs[index].value)
							formData.append('reject_object[]', reject_pcs[index].value)
							formData.append('deskripsi[]', noteIsian[index].value)
						})
						saveChange(formData)
					}
					if (status.val() == 'approved-shipping') {
						formData.append('id', id_pekerjaan.val())
						formData.append('status', status.val())
						id_detail_pekerjaan.each((index, item) => {
							formData.append('id_detail[]', id_detail_pekerjaan[index].value)
							formData.append('qty_object[]', pcs[index].value)
							formData.append('reject_object[]', reject_pcs[index].value)
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



	function showModalAndSaveChanges(formData) {
		modalNote.modal('show');

		modalNote.on('hidden.bs.modal', function () {
			saveChange(formData);

		});
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
					window.location.href = '<?= base_url('digital/view/') ?>' + id_pekerjaan.val()
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


	function saveNote(el) {
		let payload = {
			id_pekerjaan: id_pekerjaan.val(),
			note: note.val(),
		}
		$.ajax({
			url: '<?= base_url('api/note/save') ?>',
			data: payload,
			type: 'POST',
			success: function(response) {
				if (response['status']) {
					modalNote.modal('hide')
				}

			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	}

	function modalDetail(el,id) {
		$.ajax({
			url: '<?= base_url('api/'.$module.'/info') ?>',
			data: {id:id},
			type: 'GET',
			success: function(response) {
				$('#modal_produk').modal('show')
				$('.material').text(response.name)
				$('.no_mc').text(response.no_mc_label)
				$('.nama_produk').text(response.nama_dgp)
				$('.size').text(response.size)
			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	}
</script>
