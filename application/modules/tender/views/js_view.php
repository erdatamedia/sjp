<script type="text/javascript">
	var sale_chart_el=document.getElementById("sale_chart");
	var sale_chart = null;
	function update(year) {
		$.ajax({
			url: "<?= base_url('api/tender/chart/'. $x['id'] . '/' ) ?>" + year ,
			type: "GET",
			success: function(response) {

				sale_chart.updateSeries([{
					data: response
				}])
			}
		}) 
	}
	
	$(document).ready(function () {
		$('#year').change((e) => {
			const value = $('#year').val()
			januari.columns(1).search(value).draw()
			februari.columns(1).search(value).draw()
			maret.columns(1).search(value).draw()
			april.columns(1).search(value).draw()
			mei.columns(1).search(value).draw()
			juni.columns(1).search(value).draw()
			juli.columns(1).search(value).draw()
			agustus.columns(1).search(value).draw()
			september.columns(1).search(value).draw()
			oktober.columns(1).search(value).draw()
			november.columns(1).search(value).draw()
			desember.columns(1).search(value).draw()
			update(value)
		})
		var januari = $('#januari').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/tender/' . $x['id'] .'/'. 1 ) ?>',
			columns: [{
				title: 'Tanggal', data: 'name', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'ID PESANAN', data: 'id_pesanan', className: 'min-w-125px',
				render: function(data, type, row) {
					if (row.jenis_pekerjaan == 'polosan') {
						return `<a href="<?= base_url('polosan/view/') ?>${row.id}">${data}</a>`
					} else {
						return `<a href="<?= base_url('customdesain/view/') ?>${row.id}">${data}</a>`
					}
				},
			}, {
				title: 'Total Product', data: 'total_barang', className: 'text-end action-column',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Search',
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, ],
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

		var februari = $('#februari').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/tender/' . $x['id'] .'/'. 2 ) ?>',
			columns: [{
				title: 'Tanggal', data: 'name', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'ID PESANAN', data: 'id_pesanan', className: 'min-w-125px',
				render: function(data, type, row) {
					if (row.jenis_pekerjaan == 'polosan') {
						return `<a href="<?= base_url('polosan/view/') ?>${row.id}">${data}</a>`
					} else {
						return `<a href="<?= base_url('customdesain/view/') ?>${row.id}">${data}</a>`
					}
				},
			}, {
				title: 'Total Product', data: 'total_barang', className: 'text-end action-column',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Search',
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, ],
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

		var maret = $('#maret').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/tender/' . $x['id'] .'/'. 3 ) ?>',
			columns: [{
				title: 'Tanggal', data: 'name', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'ID PESANAN', data: 'id_pesanan', className: 'min-w-125px',
				render: function(data, type, row) {
					if (row.jenis_pekerjaan == 'polosan') {
						return `<a href="<?= base_url('polosan/view/') ?>${row.id}">${data}</a>`
					} else {
						return `<a href="<?= base_url('customdesain/view/') ?>${row.id}">${data}</a>`
					}
				},
			}, {
				title: 'Total Product', data: 'total_barang', className: 'text-end action-column',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Search',
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, ],
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

		var april = $('#april').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/tender/' . $x['id'] .'/'. 4 ) ?>',
			columns: [{
				title: 'Tanggal', data: 'name', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'ID PESANAN', data: 'id_pesanan', className: 'min-w-125px',
				render: function(data, type, row) {
					if (row.jenis_pekerjaan == 'polosan') {
						return `<a href="<?= base_url('polosan/view/') ?>${row.id}">${data}</a>`
					} else {
						return `<a href="<?= base_url('customdesain/view/') ?>${row.id}">${data}</a>`
					}
				},
			}, {
				title: 'Total Product', data: 'total_barang', className: 'text-end action-column',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Search',
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, ],
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

		var mei = $('#mei').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/tender/' . $x['id'] .'/'. 5 ) ?>',
			columns: [{
				title: 'Tanggal', data: 'name', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'ID PESANAN', data: 'id_pesanan', className: 'min-w-125px',
				render: function(data, type, row) {
					if (row.jenis_pekerjaan == 'polosan') {
						return `<a href="<?= base_url('polosan/view/') ?>${row.id}">${data}</a>`
					} else {
						return `<a href="<?= base_url('customdesain/view/') ?>${row.id}">${data}</a>`
					}
				},
			}, {
				title: 'Total Product', data: 'total_barang', className: 'text-end action-column',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Search',
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, ],
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

		var juni = $('#juni').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/tender/' . $x['id'] .'/'. 6 ) ?>',
			columns: [{
				title: 'Tanggal', data: 'name', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'ID PESANAN', data: 'id_pesanan', className: 'min-w-125px',
				render: function(data, type, row) {
					if (row.jenis_pekerjaan == 'polosan') {
						return `<a href="<?= base_url('polosan/view/') ?>${row.id}">${data}</a>`
					} else {
						return `<a href="<?= base_url('customdesain/view/') ?>${row.id}">${data}</a>`
					}
				},
			}, {
				title: 'Total Product', data: 'total_barang', className: 'text-end action-column',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Search',
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, ],
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

		var juli = $('#juli').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/tender/' . $x['id'] .'/'. 7 ) ?>',
			columns: [{
				title: 'Tanggal', data: 'name', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'ID PESANAN', data: 'id_pesanan', className: 'min-w-125px',
				render: function(data, type, row) {
					if (row.jenis_pekerjaan == 'polosan') {
						return `<a href="<?= base_url('polosan/view/') ?>${row.id}">${data}</a>`
					} else {
						return `<a href="<?= base_url('customdesain/view/') ?>${row.id}">${data}</a>`
					}
				},
			}, {
				title: 'Total Product', data: 'total_barang', className: 'text-end action-column',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Search',
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, ],
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

		var agustus = $('#agustus').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/tender/' . $x['id'] .'/' . 8 ) ?>',
			columns: [{
				title: 'Tanggal', data: 'name', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'ID PESANAN', data: 'id_pesanan', className: 'min-w-125px',
				render: function(data, type, row) {
					if (row.jenis_pekerjaan == 'polosan') {
						return `<a href="<?= base_url('polosan/view/') ?>${row.id}">${data}</a>`
					} else {
						return `<a href="<?= base_url('customdesain/view/') ?>${row.id}">${data}</a>`
					}
				},
			}, {
				title: 'Total Product', data: 'total_barang', className: 'text-end action-column',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Search',
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, ],
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

		var september = $('#september').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/tender/' . $x['id'] .'/'. 9 ) ?>',
			columns: [{
				title: 'Tanggal', data: 'name', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'ID PESANAN', data: 'id_pesanan', className: 'min-w-125px',
				render: function(data, type, row) {
					if (row.jenis_pekerjaan == 'polosan') {
						return `<a href="<?= base_url('polosan/view/') ?>${row.id}">${data}</a>`
					} else {
						return `<a href="<?= base_url('customdesain/view/') ?>${row.id}">${data}</a>`
					}
				},
			}, {
				title: 'Total Product', data: 'total_barang', className: 'text-end action-column',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Search',
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, ],
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

		var oktober = $('#oktober').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/tender/' . $x['id'] .'/' . 10 ) ?>',
			columns: [{
				title: 'Tanggal', data: 'name', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'ID PESANAN', data: 'id_pesanan', className: 'min-w-125px',
				render: function(data, type, row) {
					if (row.jenis_pekerjaan == 'polosan') {
						return `<a href="<?= base_url('polosan/view/') ?>${row.id}">${data}</a>`
					} else {
						return `<a href="<?= base_url('customdesain/view/') ?>${row.id}">${data}</a>`
					}
				},
			}, {
				title: 'Total Product', data: 'total_barang', className: 'text-end action-column',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Search',
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, ],
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

		var november = $('#november').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/tender/' . $x['id'] .'/' . 11 ) ?>',
			columns: [{
				title: 'Tanggal', data: 'name', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'ID PESANAN', data: 'id_pesanan', className: 'min-w-125px',
				render: function(data, type, row) {
					if (row.jenis_pekerjaan == 'polosan') {
						return `<a href="<?= base_url('polosan/view/') ?>${row.id}">${data}</a>`
					} else {
						return `<a href="<?= base_url('customdesain/view/') ?>${row.id}">${data}</a>`
					}
				},
			}, {
				title: 'Total Product', data: 'total_barang', className: 'text-end action-column',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Search',
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, ],
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

		var desember = $('#desember').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/tender/' . $x['id'] .'/' . 12 ) ?>',
			columns: [{
				title: 'Tanggal', data: 'name', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'ID PESANAN', data: 'id_pesanan', className: 'min-w-125px',
				render: function(data, type, row) {
					if (row.jenis_pekerjaan == 'polosan') {
						return `<a href="<?= base_url('polosan/view/') ?>${row.id}">${data}</a>`
					} else {
						return `<a href="<?= base_url('customdesain/view/') ?>${row.id}">${data}</a>`
					}
				},
			}, {
				title: 'Total Product', data: 'total_barang', className: 'text-end action-column',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Search',
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
					}
				}, ],
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




		
		const month 	= ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
		const golden 	= '#eaa121'
		if (sale_chart_el) {
	        $.ajax({
	            url: "<?= base_url('api/tender/chart/'. $x['id'] . '/' .$year ) ?>",
	            type: "GET",
	            success: function (response) {
	                var chartOptions = {
	                    series: [
	                        {
	                            name: 'Total Item Product',
	                            data: response
	                        }
	                    ],
	                    chart: {
	                        type: 'bar',
	                        height: parseInt(KTUtil.css(sale_chart_el, 'height')),
	                        toolbar: { show: false }
	                    },
	                    plotOptions: {
	                        bar: {
	                            columnWidth: '35%',
	                            barHeight: '70%',
	                            borderRadius: 10
	                        }
	                    },
	                    dataLabels: { enabled: false },
	                    xaxis: {
	                        categories: month,
	                        axisBorder: { show: false },
	                        axisTicks: { show: false },
	                        tickAmount: 10,
	                        labels: {
	                            style: {
	                                colors: KTUtil.getCssVariableValue('--bs-gray-500')
	                            }
	                        },
	                        crosshairs: { show: false }
	                    },
	                    yaxis: { show: true },
	                    states: {
	                        hover: { filter: false },
	                        active: { filter: false }
	                    },
	                    tooltip: {
	                        y: {
	                            formatter: function (val) {
	                                return val;
	                            }
	                        }
	                    },
	                    colors: [golden],
	                    grid: {
	                        borderColor: KTUtil.getCssVariableValue("--bs-border-dashed-color"),
	                        strokeDashArray: 4
	                    }
	                };

	                sale_chart = new ApexCharts(sale_chart_el, chartOptions);
	                sale_chart.render();
	            },
	            error: function () {
	                console.error("Failed to initialize the chart.");
	            }
	        });
	    }
	})
</script>
