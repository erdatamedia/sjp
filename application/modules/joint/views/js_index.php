<script type="text/javascript">
	var table = null
	$('#form').submit((e) => {
		e.preventDefault()
		let data = {
			name: $('input[name=name]').val()
		}

		$.ajax({
			url: '<?= base_url('api/' . $module . '/save') ?>',
			data: data,
			type: 'POST',
			success: function (response) {
				if (response['status']) {
					toastr.success(response['msg'])
					$('#modal_form').modal('hide')
					$('input[name=name]').val('')
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
			name: $('#name-edit').val()
		}
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

	function edit(el, id) {
		$.ajax({
			url: '<?= base_url('api/'.$module.'/edit') ?>',
			data: {id:id},
			type: 'POST',
			success: function(response) {
				$('#modal_form_edit').modal('show')
				$('#name-edit').val(response.name)
				$('#id-edit').val(response.id)
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
			text: 'Apakah anda ingin menghapus joint ini ?',
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
							toastr.success(response['msg'])
						}else if(response['status'] == 2) {
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
		table = $('#table').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module) ?>',
			columns: [{
				title: 'Name', data: 'name', className: 'min-w-125px',
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
