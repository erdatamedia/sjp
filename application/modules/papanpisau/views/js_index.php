<script type="text/javascript">
	var table = null
	const form_modal_create = $('#modal_form')

	form_modal_create.on('hidden.bs.modal', function(e) {
		$('input[name=no_mp]').val('')
		$('input[name=name_size]').val('')
		$('select.model_mp').val(null).trigger('change')
		$('select.uom').val(null).trigger('change')
	})

	function fileExample() {
		fetch('<?= base_url('assets/file/') ?>') 
		.then(response => response.text())
		.then(fileContent => {
			var blob = new Blob([fileContent], { type: 'text/plain' });
			var blobUrl = URL.createObjectURL(blob);
			var downloadLink = document.createElement('a');
			downloadLink.href = blobUrl;
			downloadLink.download = 'format_papan_pisau.xlsx';
			document.body.appendChild(downloadLink);
			downloadLink.click();
			document.body.removeChild(downloadLink);
		})
		.catch(error => console.error('Error fetching file:', error));
	}

	function formatRecord(record) {
		if (record.loading) return record.text
			return record.name
	}

	function formatRecordSelection(record) {
		return record.name || record.text
	}

	function select2(id, url, placeholder){
		const res = $(id).select2({
			placeholder: placeholder,
			allowClear: true,
			ajax: {
				url: url,
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						q: params.term, 
						page: params.page
					}
				},
				processResults: function(data, params) {
					params.page = params.page || 1;

					return {
						results: data.items,
						pagination: {
							more: (params.page * 30) < data.total_count
						}
					}
				},
				cache: false
			},
			templateResult: formatRecord,
			templateSelection: formatRecordSelection
		})
		return res
	}

	$('#form').submit((e) => {
		e.preventDefault()
		let data = {
			no_mp: $('input[name=no_mp]').val(),
			name_size:  $('input[name=name_size]').val(),
			id_box: $('select.model_mp').val(),
			id_uom: $('select.uom').val(),
		}

		$.ajax({
			url: '<?= base_url('api/' . $module . '/save') ?>',
			data: data,
			type: 'POST',
			success: function (response) {
				if (response['status']) {
					toastr.success(response['msg'])
					form_modal_create.modal('hide')
				}
				table.ajax.reload(null, false)

			},
			error: function (error) {
				toastr.error(error.responseText)
			}
		})

	})

	$('#form_import').submit((e) => {
		e.preventDefault()
		Swal.fire({
			title: 'Loading...',
			text: 'Please wait',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false,
			onBeforeOpen: () => {
				Swal.showLoading();
			}
		});

		var data = new FormData();
		let input = $('.file_import')
		const file = input[0].files[0];
		data.append(`file`, file, file.name);
		$.ajax({
			type: 'POST',
			url: "<?= base_url('api/papanpisau/import') ?>",
			data: data,
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			success: function(result) {
				if (result) {
					Swal.close();
					Swal.fire({
						title: 'Success',
						text: 'Data imported successfully',
						icon: 'success',
						confirmButtonText: 'OK'
					});
					$('#modal_form_import').modal('hide')
					table.ajax.reload(null, false)
				} 
			},
			error: function(error){
				toastr.error(error.responseText)
				Swal.close();
			}
		});
	})

	$('#form_edit').submit((e) => {
		e.preventDefault()
		let data = {
			id : $('#id-edit').val(),
			no_mp: $('input[name=no_mp-edit]').val(),
			name_size:  $('input[name=name_size-edit]').val(),
			id_box: $('select.model_mp-edit').val(),
			id_uom: $('select.uom-edit').val(),
		}
		console.log(data);
		$.ajax({
			url: '<?= base_url('api/'.$module.'/update') ?>',
			data: data,
			type: 'POST',
			success: function(response) {
				$('#modal_form_edit').modal('hide')
				$('input[name=no_mp-edit]').val('')
				$('input[name=name_size-edit]').val('')
				$('#id-edit').val('')
				toastr.success(response['msg'])
				table.ajax.reload(null, false)
			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	})


	const uom = select2('.uom-edit', '<?= base_url('api/uom/select2') ?>', 'Select an Unit of Measure')
	const model = select2('.model_mp-edit', '<?= base_url('api/box/select2') ?>', 'Select an Model')
	function edit(el, id) {
		$.ajax({
			url: '<?= base_url('api/'.$module.'/edit') ?>',
			data: {id:id},
			type: 'GET',
			success: function(response) {
				$('#modal_form_edit').modal('show')
				$('input[name=no_mp-edit]').val(response.no_mp)
				$('input[name=name_size-edit]').val(response.name_size)
				$('input[name=model_mp-edit]').val(response.model_mp)
				$('#id-edit').val(response.id)
				const selected = new Option(response.uom_name, response.id_uom, true, true)
				uom.append(selected).trigger('change')
				const selected_model = new Option(response.box_name, response.id_box, true, true)
				model.append(selected_model).trigger('change')

			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	}

	function reset() {
		$('input[name=name]').val('')
	}

	function del(el,id) {
		Swal.fire({
			title: 'Perhatian !',
			text: 'Apakah anda ingin menghapus Cutting Board ini ?',
			icon: 'warning',
			allowOutsideClick: false,
			allowEscapeKey: false,
			buttonsStyling: false,
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonText: 'Hapus',
			customClass: {
				cancelButton: 'btn btn-light-danger',
				confirmButton: 'btn btn-danger',
			}
		}).then((res)=>{
			if (res.isConfirmed) {
				$.ajax({
					url: '<?= base_url('api/'.$module.'/delete') ?>',
					data: {id:id},
					type: 'POST',
					success: function(response) {
						if (response['status'] ==1) {
							toastr.success(response['msg'])
						} else if(response.status == 2) {
							toastr.warning(response['msg'])
						}
						table.ajax.reload(null, false)

					},
					error: function(error){
						toastr.error(error.responseText)
					}
				})
			}
		})
	}


	$(document).ready(function () {
		select2('.uom', '<?= base_url('api/uom/select2') ?>', 'Select an Model')
		select2('.model_mp', '<?= base_url('api/box/select2') ?>', 'Select an Unit of Measure')
		var table = $('#table').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module) ?>',
			columns: [{
				title: 'No.MP', data: 'no_mp', className: 'min-w-125px',
			},{
				title: 'Name Size', data: 'name_size', className: 'min-w-125px',
			},{
				title: 'Model', data: 'box_name', className: 'min-w-125px',
				render : function (data, type, row) {
					return data? data : 'Kosong'
				}
			},{
				title: 'Spesifikasi MP', data: 'spesifikasi_mp', className: 'min-w-125px',
			}, {
				title: 'Action', data: 'id', className: 'text-end action-column', sortable: false,
				render: function (data, type, row) {
					return `
					<div class="btn-group btn-group-sm">
					<button onclick="edit(this, ${data})" class="btn btn-icon btn-light btn-active-light-success"><i class="bi bi-pencil"></i></button>
					<button class="btn btn-icon btn-light btn-active-light-danger" onclick="del(this,${data})"><i class="bi bi-trash3"></i></button>
					</div>`
				},
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'No. MP Or Name Size',
				paginate: {
					first: '<i class="fa fs-4 fa-angle-double-left"></i>',
					previous: '<i class="fa fs-4 fa-angle-left"></i>',
					next: '<i class="fa fs-4 fa-angle-right"></i>',
					last: '<i class="fa fs-4 fa-angle-double-right"></i>',
				},
			},
			buttons: {
				buttons: [{
					text: 'Create',
					className: 'btn-primary d-none d-sm-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, {
					text: '<i class="bi bi-plus"></i>',
					className: 'btn-primary d-sm-none add-dt',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, {
					text: '<i class="bi bi-arrow-clockwise"></i>',
					className: 'btn-light',
					action: function (e, dt, node, config) {
						table.ajax.reload(null, false)
					}
				},{
					text: '<i class="las la-file-upload fs-2"></i> Import',
					className: 'btn-light',
					action: function (e, dt, node, config) {
						$('#modal_form_import').modal('show')
					}
				}],
				dom: {
					button: {
						className: 'btn btn-sm'
					}
				}
			},
			dom:
			"<'row'" +
			"<'col-12 col-sm-6 d-flex align-items-center justify-content-start'B>" +
			"<'col-12 col-sm-6 d-flex align-items-center justify-content-end'f>" +
			"<'col-6 d-flex align-items-center justify-content-start'li>" +
			"<'col-6 d-flex align-items-center justify-content-end'p>" +
			">" +
			"<'table-responsive'tr>"
		})
	})
</script>
