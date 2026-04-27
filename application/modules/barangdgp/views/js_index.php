<script src="<?= base_url('assets/plugins/custom/fslightbox/fslightbox.bundle.js')?>"></script>
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
			no_mc_label: $('input[name=no_mc]').val(),
			name_dgp: $('input[name=nama_produk]').val(),
			id_material: $('select.id_material').val(),
			size: $('input[name=size]').val(),
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
			url: "<?= base_url('api/barangdgp/import') ?>",
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
			id : $('input[name=id_barang_dgp]').val(),
			no_mc_label: $('input[name=no_mc_edit]').val(),
			name_dgp: $('input[name=nama_produk_edit]').val(),
			id_material: $('select.id_material_edit').val(),
			size: $('input[name=size_edit]').val(),
		}
		console.log(data)
		$.ajax({
			url: '<?= base_url('api/'.$module.'/update') ?>',
			data: data,
			type: 'POST',
			success: function(response) {
				$('#modal_form_edit').modal('hide')
				$('input[name=no_mc_edit]').val('')
				$('input[name=nama_produk_edit]').val('')
				$('input[name=size_edit]').val('')
				$('#id_barang_dgp').val('')
				toastr.success(response['msg'])
				table.ajax.reload(null, false)
			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	})


	const material = select2('.id_material_edit', '<?= base_url('api/material/select2') ?>', 'Select an Material')
	function edit(el, id) {
		$.ajax({
			url: '<?= base_url('api/'.$module.'/edit') ?>',
			data: {id:id},
			type: 'GET',
			success: function(response) {
				$('#modal_form_edit').modal('show')
				$('input[name=no_mc_edit]').val(response.no_mc_label)
				$('input[name=nama_produk_edit]').val(response.nama_dgp)
				$('input[name=size_edit]').val(response.size)
				$('input[name=id_barang_dgp]').val(response.id)
				const selected_material = new Option(response.name_material, response.id_material, true, true)
				material.append(selected_material).trigger('change')

			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	}

	function view(el, id) {
		$.ajax({
			url: '<?= base_url('api/'.$module.'/view') ?>',
			data: {id:id},
			type: 'GET',
			success: function(response) {
				const defaultImage = "<?= $blank_product ?>";
				const image = response.image || defaultImage;

				$('#modal_produk').modal('show')
				$('.no_mc').text(response.no_mc_label)
				$('.nama_produk').text(response.nama_dgp)
				$('.size').text(response.size)
				$('.material').text(response.name_material)
				$('#image').html(`
				    <div class="d-flex flex-column align-items-center">
				        <a class="overlay symbol symbol-200px bg-secondary bg-opacity-25 rounded" data-fslightbox="lightbox-basic" href="${image}">
				            <div class="symbol-label" style="background-image:url('${image}'); background-size: cover; background-position: center;"></div>
				            <div class="overlay-layer bg-dark bg-opacity-25">
				                <i class="bi bi-zoom-in text-white"></i>
				            </div>
				        </a>
				    </div>
				`);

				refreshFsLightbox()

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
		select2('.id_material', '<?= base_url('api/material/select2') ?>', 'Select an Material')


		table = $('#table').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module) ?>',
			columns: [{
				title: 'No.MC Label', data: 'no_mc_label', className: 'min-w-125px',
			},{
				title: 'Nama Produk', data: 'nama_dgp', className: 'min-w-125px',
			},{
				title: 'Ukuran Produk', data: 'size', className: 'min-w-125px',
			},{
				title: 'Material', data: 'material.name', className: 'min-w-30px',
				render : function (data, type, row) {
					return data? data : 'Empty'
				}
			}, {
				title: 'Action', data: 'id', className: 'text-end action-column', sortable: false,
				render: function (data, type, row) {
					return `
					<div class="btn-group btn-group-sm">
					<button onclick="edit(this, ${data})" class="btn btn-icon btn-light btn-active-light-success"><i class="bi bi-pencil"></i></button>
					<button class="btn btn-icon btn-light btn-active-light-success" onclick="view(this, ${data} )"><i class="bi bi-eye"></i></button>
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
