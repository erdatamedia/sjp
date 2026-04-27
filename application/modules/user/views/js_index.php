<script src="<?= base_url('assets/plugins/custom/fslightbox/fslightbox.bundle.js')?>"></script>
<script type="text/javascript">
	var table = null
	const form_modal_create = $('#modal_form')

	form_modal_create.on('hidden.bs.modal', function(e) {
		$('input[name=name]').val('')
		$('input[name=email]').val('')
		$('input[name=password]').val('')
		$('select.role').val(null).trigger('change')
	})
	
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
			name: $('input[name=name]').val(),
			email: $('input[name=email]').val(),
			role: $('select.role').val(),
			password: $('input[name=password]').val(),
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


	$('#form_edit').submit((e) => {
		e.preventDefault()
		let data = {
			id : $('#id-edit').val(),
			name: $('input[name=name-edit]').val(),
			email: $('input[name=email-edit]').val(),
			role: $('select.role-edit').val(),
			password: $('input[name=password-edit]').val()? $('input[name=password-edit]').val(): null ,
		}
		console.log(data)
		$.ajax({
			url: '<?= base_url('api/'.$module.'/update') ?>',
			data: data,
			type: 'POST',
			success: function(response) {
				$('#modal_form_edit').modal('hide')
				$('#name-edit').val('')
				$('#id-edit').val('')
				toastr.success(response['msg'])
				table.ajax.reload(null, false)
			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	})

	function reset() {
		$('input[name=name]').val('')
		$('input[name=email]').val('')
		$('input[name=password]').val('')
		$('select.role').val(null).trigger('change')
	}

	const role = select2('#role-select', '<?= base_url('api/role/select2') ?>', 'Select an Role')
	function edit(el, id) {
		$.ajax({
			url: '<?= base_url('api/'.$module.'/edit') ?>',
			data: {id:id},
			type: 'GET',
			success: function(response) {
				$('#modal_form_edit').modal('show')
				$('input[name=name-edit]').val(response.name)
				$('input[name=email-edit]').val(response.email)
				$('#id-edit').val(response.id)
				const selected = new Option(response.role_name, response.id_role, true, true)
				role.append(selected).trigger('change')
				
			},
			error: function(error){
				toastr.error(error.responseText)
			}
		})
	}

	function del(el,id) {
		Swal.fire({
			title: 'Perhatian !',
			text: 'Apakah anda ingin menghapus user ini ?',
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
						if (response['status']) {
							toastr.success(response['msg'])
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
		select2('.role', '<?= base_url('api/role/select2') ?>', 'Select an Role')
		table = $('#table').DataTable({
			order: [],
			drawCallback: function(settings) {
				refreshFsLightbox()
			},
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module) ?>',
			columns: [{
				title: 'Name', data: 'name', className: 'min-w-125px',
			},{
				title: 'Email', data: 'email', className: 'min-w-125px',
			},{
				title: 'Role', data: 'role', className: 'min-w-125px',
				render : function (data, type, row) {
					return data? data : 'Kosong'
				}
			},{
				title: 'Photo', data: 'image', className: 'min-w-25px', sortable: false,
				render: function (data, type, row) {
					const photo = row['image'] ? row['image'] : '<?= $blank_user ?>'
					return `<a class="overlay symbol symbol-50px" data-fslightbox="lightbox-basic" href="${photo}">
					<div class="symbol-label" style="background-image:url('${photo}')"></div>
					<div class="overlay-layer bg-dark bg-opacity-25">
					<i class="bi bi-zoom-in text-white"></i>
					</div>
					</a>`
				},
			}, {
				title: 'Action', data: 'id', className: 'text-end action-column', sortable: false,
				render: function (data, type, row) {
					return `
					<div class="btn-group btn-group-sm">
					<a href="<?= base_url('user/view/') ?>${data}" class="btn btn-icon btn-light btn-active-light-success"><i class="bi bi-pencil"></i></a>
					<button class="btn btn-icon btn-light btn-active-light-danger" onclick="del(this,${data})"><i class="bi bi-trash3"></i></button>
					</div>`
				},
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Cari',
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
				},],
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
