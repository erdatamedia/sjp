<script type="text/javascript">

	var table = null
	const form_modal_create = $('#modal_form')
	const form_modal_import = $('#modal_form_import')

	form_modal_create.on('hidden.bs.modal', function(e) {
		$('input[name=no_mc]').val('')
		$('input[name=item_box]').val('')
		$('input[name=model_box]').val('')
		$('input[name=substance]').val('')
		$('input[name=size]').val('')
		$('input[name=papan_pisau]').val('')
		$('input[name=gramatur]').val('')

	})

	form_modal_import.on('hidden.bs.modal', function(e) {
		
		var inputFile = $('input[type=file][name=file]');
		inputFile.val('')
	})

	function fileExample() {
		fetch('<?= base_url('assets/file/') ?>') 
		.then(response => response.text())
		.then(fileContent => {
			var blob = new Blob([fileContent], { type: 'text/plain' });
			var blobUrl = URL.createObjectURL(blob);
			var downloadLink = document.createElement('a');
			downloadLink.href = blobUrl;
			downloadLink.download = 'format.xlsx';
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
			no_mc: $('input[name=no_mc]').val(),
			item_box: $('input[name=item_box]').val(),
			id_papan_pisau: $('select.papan_pisau').val(),
			id_box: $('select.box').val(),
			id_joint: $('select.joint').val(),
			size: $('input[name=size]').val(),
			substance: $('input[name=substance]').val(),
		}

		$.ajax({
			url: '<?= base_url('api/' . $module . '/save') ?>',
			data: data,
			type: 'POST',
			success: function (response) {
				if (response['status'] == 209) {
					toastr.success(response['msg'])
					$('#modal_form').modal('hide')
					table.ajax.reload(null, false)
				}
				if (response.status == 208) {
					toastr.warning(response['msg'])
					$('#modal_form').modal('hide')
				}


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
			url: "<?= base_url('api/barang/import') ?>",
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
			no_mc: $('input[name=no_mc-edit]').val(),
			item_box: $('input[name=item_box-edit]').val(),
			id_papan_pisau: $('select.papan_pisau-edit').val(),
			id_box: $('select.box-edit').val(),
			id_joint: $('select.joint-edit').val(),
			size: $('input[name=size-edit]').val(),
			substance: $('input[name=substance-edit]').val(),
		}
		console.log(data)
		$.ajax({
			url: '<?= base_url('api/'.$module.'/update') ?>',
			data: data,
			type: 'POST',
			success: function(response) {
				$('#modal_form_edit').modal('hide')
				$('input[name=no_mc-edit]').val('')
				$('input[name=item_box-edit]').val('')
				$('input[name=papan_pisau-edit]').val('')
				$('input[name=model_box-edit]').val('')
				$('input[name=substance-edit]').val('')
				$('input[name=gramatur-edit]').val('')
				$('input[name=deskripsi-edit]').val('')
				$('#id-edit').val('')
				toastr.success(response['msg'])
				table.ajax.reload(null, false)
			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	})


	const box = select2('.box-edit', '<?= base_url('api/box/select2') ?>', 'Select Model Produk')
	const joint = select2('.joint-edit', '<?= base_url('api/joint/select2') ?>', 'Select an Joint')
	const papan_pisau = select2('.papan_pisau-edit', '<?= base_url('api/papanpisau/select2') ?>', 'Select an Papan Pisau')
	function edit(el, id) {
		$.ajax({
			url: '<?= base_url('api/'.$module.'/edit') ?>',
			data: {id:id},
			type: 'GET',
			success: function(response) {
				$('#modal_form_edit').modal('show')
				$('input[name=no_mc-edit]').val(response.no_mc)
				$('input[name=item_box-edit]').val(response.item_box)
				$('input[name=substance-edit]').val(response.substance)
				$('input[name=size-edit]').val(response.size)
				$('#id-edit').val(response.id)
				const selected_box = new Option(response.name_box, response.id_box, true, true)
				box.append(selected_box).trigger('change')

				const selected_joint = new Option(response.name_joint, response.id_joint, true, true)
				joint.append(selected_joint).trigger('change')

				const selected_papan = new Option(response.name_papan, response.id_papan_pisau, true, true)
				papan_pisau.append(selected_papan).trigger('change')

			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	}

	function view(el, id) {
		$.ajax({
			url: '<?= base_url('api/'.$module.'/edit') ?>',
			data: {id:id},
			type: 'GET',
			success: function(response) {
				$('#modal_form_view').modal('show')
				$('.barang-title').text(response.item_box)
				$('.barang-title-info').text(response.item_box)
				$('.no-mc').text(response.no_mc)
				$('.model-box').text(response.name_box)
				$('.size').text(response.size)
				$('.substance').text(response.substance)
				$('.deskripsi').text(response.deskripsi)
				$('.joint').text(response.name_joint? response.name_joint : 'Kosong')
				$('.papan_pisau').text(response.name_papan? response.name_papan : 'Kosong')
				$('.qty-stok').text(response.stok? response.stok + ' Pcs' : 0 + ' Pcs')

			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	}

	function del(el,id) {
		Swal.fire({
			title: 'Perhatian !',
			text: 'Apakah anda ingin menghapus produk ini ?',
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
						if (response['status'] == 1) {
							toastr.warning(response['msg'])
						}
						if (response['status'] == 2) {
							toastr.success(response['msg'])
							table.ajax.reload(null, false)
						}
						if (response['status'] == 3) {
							toastr.warning(response['msg'])
						} 
					},
					error: function(error){
						toastr.error(error.responseText)
					}
				})
			}
		})
	}


	$(document).ready(function () {
		select2('.box', '<?= base_url('api/box/select2') ?>', 'Select an Model Produk')
		select2('.papan_pisau', '<?= base_url('api/papanpisau/select2') ?>', 'Select an Papan Pisau')
		select2('.joint', '<?= base_url('api/joint/select2') ?>', 'Select an Joint')


		$('#status').change((e) => {
			const value = $('#status').val()
			table.columns(8).search(value).draw()
		})

		$('.count_all').on('click', function() {
			$('#status').val('').trigger('change')
		});
		$('.count_sisa').on('click', function() {
			$('#status').val('stok_tersisa').trigger('change')
		});

		$('.count_total').on('click', function() {
			$('#status').val('stok_total').trigger('change')
		});

		$('.count_habis').on('click', function() {
			$('#status').val('stok_habis').trigger('change')
		});

		table = $('#table').DataTable({
			order: [],
			drawCallback: function(settings) {
				const count_total = settings['json']['count']['total']
				const count_sisa = settings['json']['count']['stok_ada']
				const count_habis = settings['json']['count']['stok_habis']
				const count_all = settings['json']['count']['total_barang']
				$('.count_total').text(count_total)
				$('.count_sisa').text(count_sisa)
				$('.count_habis').text(count_habis)
				$('.count_all').text(count_all)
			},
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module) ?>',
			columns: [{
				title: 'No.MC', data: 'no_mc', className: 'min-w-125px',
			},{
				title: 'Nama Produk', data: 'item_box', className: 'min-w-125px',
			},{
				title: 'Ukuran Produk', data: 'size', className: 'min-w-125px',
			},{
				title: 'Model Produk', data: 'box.name', className: 'min-w-30px',
				render : function (data, type, row) {
					return data? data : 'Kosong'
				}
			},{
				title: 'Cutting Board', data: 'papan_pisau.name', className: 'min-w-125px',
				render : function (data, type, row) {
					return data? data : 'Empty'
				}
			},{
				title: 'Substance/Flute', data: 'substance', className: 'min-w-125px',
			},{
				title: 'Joint', data: 'joint.name', className: 'min-w-125px',
				render: function (data, type, row) {
					return data? data : 'Empty'
				}
			},{
				title: 'Stock', data: 'stok', className: 'min-w-50px',
			}, {
				title: 'Action', data: 'id', className: 'text-end action-column', sortable: false,
				render: function (data, type, row) {
					return `
					<div class="btn-group btn-group-sm">
					<button onclick="edit(this, ${data})" class="btn btn-icon btn-light btn-active-light-success"><i class="bi bi-pencil"></i></button>
					<a href="<?= base_url('barang/view/') ?>${data}" class="btn btn-icon btn-light btn-active-light-success"><i class="bi bi-eye"></i></a>
					<button class="btn btn-icon btn-light btn-active-light-danger" onclick="del(this,${data})"><i class="bi bi-trash3"></i></button>
					</div>`
				},
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'No. MC Or Name',
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
				}, {
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
