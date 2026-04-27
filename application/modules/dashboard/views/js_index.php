<script src="<?= base_url('assets/plugins/custom/fslightbox/fslightbox.bundle.js')?>"></script>
<script type="text/javascript">
	var table_all = null
	var table_done = null
	var table_desain = null
	var table_cutting = null
	var table_packing = null
	var table_waiting = null
	var table_printing = null
	var table_approved = null
	var repeater = null
	var repeaterDgp = null

	getCountProses()
	activity()
	stok()

	
	function getCountProses() {
		$.ajax({
			type: "GET",
			url: "<?= $user['id_role'] == 2 ? base_url('api/dashboard/countProses/' . $user['id']) : base_url('api/dashboard/countProses/' . null) ?>",
			success: function(response) {
				$('.all').text(response.all)
				$('.waiting').text(response.waiting)
				$('.cutting').text(response.cutting)
				$('.printing').text(response.printing)
				$('.desain').text(response.desain)
				$('.packing').text(response.packing)
				$('.selesai').text(response.done)
				$('.approved_qc').text(response.approved)
			}
		});
	}

	function activity() {
		$.ajax({
			type: "GET",
			url: "<?= base_url('api/dashboard/countJenisPekerjaan') ?>",
			success: function(response) {
				$('.polosan').text(response.polosan + ' Works')
				$('.custom').text(response.custom + ' Works')
				$('.digital').text(response.digital + ' Works')
				$('.produk_box').text(response.box + ' Product')
				$('.produk_dgp').text(response.dgp + ' Product')
			},
		});
	}

	function stok() {
		$.ajax({
			type: "GET",
			url: "<?= base_url('api/dashboard/countStok') ?>",
			success: function(response) {
				$('.stok_ada').text(response.stok_ada + ' Product')
				$('.stok_habis').text(response.stok_habis + ' Product')
				$('.total_stok').text(response.total + ' Pcs')
			},
		});
	}

	function chartRepeateProduct() {
		$.ajax({
		    type: "GET",
		    url: "<?= base_url('api/barang/repeate') ?>",
		    success: function(response) {
		        const categories = response.map(item => item.y);
		        const seriesData = response.map(item => item.x);
		        repeater.updateOptions({
		            xaxis: { categories: categories }
		        });

		        repeater.updateSeries([{
		            name: 'Repeat Order',
		            data: seriesData
		        }]);
		    }
		});
	}

	function chartRepeateProductDigital() {
		$.ajax({
		    type: "GET",
		    url: "<?= base_url('api/barangdgp/repeate') ?>",
		    success: function(response) {
		        const categories = response.map(item => item.y);
		        const seriesData = response.map(item => item.x);
		        repeaterDgp.updateOptions({
		            xaxis: { categories: categories }
		        });

		        repeaterDgp.updateSeries([{
		            name: 'Repeat Order',
		            data: seriesData
		        }]);
		    }
		});
	}

	$(document).ready(function(){
		table_all = $('#table-all').DataTable({
		    order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 5,
			serverSide: true,
			pagingType: "full_numbers",
			ajax: '<?= $user['id_role'] ==2 ? base_url('api/' . $module .'/all/' . $user['id']) : base_url('api/' . $module .'/all/' . null)   ?>' ,
			columns: [{
				title: 'Information', data: 'id_pesanan', className: 'min-w-125px',
				render: function (data, type, row) {
					if (row.id_pesanan) {
						return `<span> Ordering: ${row.id_pesanan} - ${row.user.name}</span>`
					} else {
						return `<span> Stok: ${row.id_spk} - ${row.user.name}</span>`
					}
				}
			},{
				title: 'Status', data: 'status', className: 'min-w-125px',
				render : function (data, type, row) {
					if (data == 'approved') {
						return `<span class="badge" style="background: yellow;color:black;">Disetujui Kualitas</span>`
					}
					if (data == 'approved-shipping') {
						return `<span class="badge" style="background: #402f1d; color: white;">Approved Logistik</span>`
					}
					if (data == 'done') {
						return `<span class="badge badge-info">Selesai</span>`
					}
					if (data == 'desain') {
						return `<span class="badge" style="color:black; background: red;">Design</span>`
					}
					if (data == 'waiting-marketing') {
						return `<span class="badge" style="color:white; background: gray;">Menunggu Marketing</span>`
					}
					if (data == 'printing') {
						return `<span class="badge" style="color:white; background: #0b1abd">Printing</span>`
					}
					if (data == 'cutting') {
						return `<span class="badge" style="color:white; background: black;">Cutting</span>`
					}
					if (data == 'packing') {
						return `<span class="badge" style="color:white; background:#ff1493">Finishing</span>`
					}
					if (data == 'waiting') {
						return `<span class="badge" style="background: orange">Menunggu Material/Alat</span>`
					}
				}
			},{
				title: 'Duration', data: 'durasi', className: 'min-w-125px',
				render: function (data, type, row) {
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					if (m.isBefore(now, 'day')) {
						return row.durasi + `<span class="badge" style="color:white;background:red; margin-left:4px;">Late</span>`
					} else {
						return row.durasi
					}
				}
			},{
				title: 'Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'Due Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					const date = m.isValid()?m.format('DD/MM/YYYY') : ''
					if (m.isBefore(now, 'day')) {
						return `<span class="badge" style="color:red;">${date}</span>`
					} else {
						return date
					}
					
				}
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				paginate: {
					first: '<i class="fa fs-4 fa-angle-double-left"></i>',
					previous: '<i class="fa fs-4 fa-angle-left"></i>',
					next: '<i class="fa fs-4 fa-angle-right"></i>',
					last: '<i class="fa fs-4 fa-angle-double-right"></i>',
				},
			},
			dom:
			"<'row'" +
			"<'col-6 d-flex align-items-center justify-content-start'li>" +
			"<'col-6 d-flex align-items-center justify-content-end'p>" +
			">" +
			"<'table-responsive'tr>"
		})
		table_cutting = $('#table-cutting').DataTable({
		    order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 5,
			serverSide: true,
			pagingType: "full_numbers",
			ajax: '<?= $user['id_role'] ==2 ? base_url('api/' . $module .'/cutting/' . $user['id']) : base_url('api/' . $module .'/cutting/' . null)   ?>' ,
			columns: [{
				title: 'Information', data: 'id_pesanan', className: 'min-w-125px',
				render: function (data, type, row) {
					if (row.id_pesanan) {
						return `<span> Ordering: ${row.id_pesanan} - ${row.user.name}</span>`
					} else {
						return `<span> Stok: ${row.id_spk} - ${row.user.name}</span>`
					}
				}
			},{
				title: 'Status', data: 'status', className: 'min-w-125px',
				render : function (data, type, row) {
					if (data == 'approved') {
						return `<span class="badge" style="background: yellow">Disetujui Kualitas</span>`
					}
					if (data == 'approved-shipping') {
						return `<span class="badge" style="background: #402f1d; color: white;">Approved Logistik</span>`
					}
					if (data == 'done') {
						return `<span class="badge badge-info">Selesai</span>`
					}
					if (data == 'desain') {
						return `<span class="badge" style="color:black; background: red;">Design</span>`
					}
					if (data == 'printing') {
						return `<span class="badge" style="color:white; background: #000035">Printing</span>`
					}
					if (data == 'cutting') {
						return `<span class="badge" style="color:white; background: black;">Cutting</span>`
					}
					if (data == 'packing') {
						return `<span class="badge" style="color:white; background:#ff1493">Finishing</span>`
					}
					if (data == 'waiting') {
						return `<span class="badge" style="background: orange">Menunggu Material/Alat</span>`
					}
				}
			},{
				title: 'Duration', data: 'durasi', className: 'min-w-125px',
				render: function (data, type, row) {
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					if (m.isBefore(now, 'day')) {
						return row.durasi + `<span class="badge" style="color:white;background:red; margin-left:4px;">Late</span>`
					} else {
						return row.durasi
					}
				}
			},{
				title: 'Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			}, {
				title: 'Due Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					const date = m.isValid()?m.format('DD/MM/YYYY') : ''
					if (m.isBefore(now, 'day')) {
						return `<span class="badge" style="color:red;">${date}</span>`
					} else {
						return date
					}
				}
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				paginate: {
					first: '<i class="fa fs-4 fa-angle-double-left"></i>',
					previous: '<i class="fa fs-4 fa-angle-left"></i>',
					next: '<i class="fa fs-4 fa-angle-right"></i>',
					last: '<i class="fa fs-4 fa-angle-double-right"></i>',
				},
			},
			dom:
			"<'row'" +
			"<'col-6 d-flex align-items-center justify-content-start'li>" +
			"<'col-6 d-flex align-items-center justify-content-end'p>" +
			">" +
			"<'table-responsive'tr>"
		})

		table_desain = $('#table-desain').DataTable({
		    order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 5,
			serverSide : true,
			pagingType: "full_numbers",
			ajax: '<?= $user['id_role'] ==2 ? base_url('api/' . $module .'/desain/' . $user['id']) : base_url('api/' . $module .'/desain/' . null)   ?>' ,
			columns: [{
				render : function (data, type, row) {
					return ` <a href="<?= base_url('dashboard/design/') ?>${row.id}" class="btn btn-icon btn-sm btn-light btn-active-light-success">
					<i class="bi bi-eye"></i>
					</a>`
				}
			}, {
				title: 'Information', data: 'id_pesanan', className: 'min-w-125px',
				render: function (data, type, row) {
					if (row.id_pesanan) {
						return `<span> Ordering: ${row.id_pesanan} - ${row.user.name}</span>`
					} else {
						return `<span> Stok: ${row.id_spk} - ${row.user.name}</span>`
					}
				}
			},{
				title: 'Status', data: 'status', className: 'min-w-125px',
				render : function (data, type, row) {
					if (data == 'approved') {
						return `<span class="badge" style="background: yellow">Disetujui Kualitas</span>`
					}
					if (data == 'approved-shipping') {
						return `<span class="badge" style="background: #402f1d; color: white;">Approved Logistik</span>`
					}
					if (data == 'done') {
						return `<span class="badge badge-info">Selesai</span>`
					}
					if (data == 'desain') {
						return `<span class="badge" style="color:black; background: red;">Design</span>`
					}
					if (data == 'printing') {
						return `<span class="badge" style="color:white; background: #000035">Printing</span>`
					}
					if (data == 'cutting') {
						return `<span class="badge" style="color:white; background: black;">Cutting</span>`
					}
					if (data == 'packing') {
						return `<span class="badge" style="color:white; background:#ff1493">Finishing</span>`
					}
					if (data == 'waiting') {
						return `<span class="badge" style="background: orange">Menunggu Material/Alat</span>`
					}
				}
			},{
				title: 'Duration', data: 'durasi', className: 'min-w-125px',
				render: function (data, type, row) {
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					if (m.isBefore(now, 'day')) {
						return row.durasi + `<span class="badge" style="color:white;background:red; margin-left:4px;">Late</span>`
					} else {
						return row.durasi
					}
				}
			},{
				title: 'Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'Due Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					const date = m.isValid()?m.format('DD/MM/YYYY') : ''
					if (m.isBefore(now, 'day')) {
						return `<span class="badge" style="color:red;">${date}</span>`
					} else {
						return date
					}
				}
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				paginate: {
					first: '<i class="fa fs-4 fa-angle-double-left"></i>',
					previous: '<i class="fa fs-4 fa-angle-left"></i>',
					next: '<i class="fa fs-4 fa-angle-right"></i>',
					last: '<i class="fa fs-4 fa-angle-double-right"></i>',
				},
			},
			dom:
			"<'row'" +
			"<'col-6 d-flex align-items-center justify-content-start'li>" +
			"<'col-6 d-flex align-items-center justify-content-end'p>" +
			">" +
			"<'table-responsive'tr>"
		})

		table_printing = $('#table-printing').DataTable({
		    order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 5,
			serverSide: true,
			pagingType: "full_numbers",
			ajax: '<?= $user['id_role'] ==2 ? base_url('api/' . $module .'/printing/' . $user['id']) : base_url('api/' . $module .'/printing/' . null)   ?>' ,
			columns: [{
				title: 'Information', data: 'id_pesanan', className: 'min-w-125px',
				render: function (data, type, row) {
					if (row.id_pesanan) {
						return `<span> Ordering: ${row.id_pesanan} - ${row.user.name}</span>`
					} else {
						return `<span> Stok: ${row.id_spk} - ${row.user.name}</span>`
					}
				}
			},{
				title: 'Status', data: 'status', className: 'min-w-125px',
				render : function (data, type, row) {
					if (data == 'approved') {
						return `<span class="badge" style="background: yellow">Disetujui Kualitas</span>`
					}
					if (data == 'approved-shipping') {
						return `<span class="badge" style="background: #402f1d; color: white;">Approved Logistik</span>`
					}
					if (data == 'done') {
						return `<span class="badge badge-info">Selesai</span>`
					}
					if (data == 'desain') {
						return `<span class="badge" style="color:black; background: red;">Design</span>`
					}
					if (data == 'printing') {
						return `<span class="badge" style="color:white; background: #0b1abd">Printing</span>`
					}
					if (data == 'cutting') {
						return `<span class="badge" style="color:white; background: black;">Cutting</span>`
					}
					if (data == 'packing') {
						return `<span class="badge" style="color:white; background:#ff1493">Finishing</span>`
					}
					if (data == 'waiting') {
						return `<span class="badge" style="background: orange">Menunggu Material/Alat</span>`
					}
				}
			},{
				title: 'Duration', data: 'durasi', className: 'min-w-125px',
				render: function (data, type, row) {
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					if (m.isBefore(now, 'day')) {
						return row.durasi + `<span class="badge" style="color:white;background:red; margin-left:4px;">Late</span>`
					} else {
						return row.durasi
					}
				}
			},{
				title: 'Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			}, {
				title: 'Due Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					const date = m.isValid()?m.format('DD/MM/YYYY') : ''
					if (m.isBefore(now, 'day')) {
						return `<span class="badge" style="color:red;">${date}</span>`
					} else {
						return date
					}
				}
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				paginate: {
					first: '<i class="fa fs-4 fa-angle-double-left"></i>',
					previous: '<i class="fa fs-4 fa-angle-left"></i>',
					next: '<i class="fa fs-4 fa-angle-right"></i>',
					last: '<i class="fa fs-4 fa-angle-double-right"></i>',
				},
			},
			dom:
			"<'row'" +
			"<'col-6 d-flex align-items-center justify-content-start'li>" +
			"<'col-6 d-flex align-items-center justify-content-end'p>" +
			">" +
			"<'table-responsive'tr>"
		})

		table_packing = $('#table-packing').DataTable({
		    order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 5,
			serverSide: true,
			pagingType: "full_numbers",
			ajax: '<?= $user['id_role'] ==2 ? base_url('api/' . $module .'/packing/' . $user['id']) : base_url('api/' . $module .'/packing/' . null)   ?>' ,
			columns: [
			{
				title: 'Information', data: 'id_pesanan', className: 'min-w-125px',
				render: function (data, type, row) {
					if (row.id_pesanan) {
						return `<span> Ordering: ${row.id_pesanan} - ${row.user.name}</span>`
					} else {
						return `<span> Stok: ${row.id_spk} - ${row.user.name}</span>`
					}
				}
			},{
				title: 'Status', data: 'status', className: 'min-w-125px',
				render : function (data, type, row) {
					if (data == 'approved') {
						return `<span class="badge" style="background: yellow">Disetujui Kualitas</span>`
					}
					if (data == 'approved-shipping') {
						return `<span class="badge" style="background: #402f1d; color: white;">Approved Logistik</span>`
					}
					if (data == 'done') {
						return `<span class="badge badge-info">Selesai</span>`
					}
					if (data == 'desain') {
						return `<span class="badge" style="color:black; background: red;">Design</span>`
					}
					if (data == 'printing') {
						return `<span class="badge" style="color:white; background: #000035">Printing</span>`
					}
					if (data == 'cutting') {
						return `<span class="badge" style="color:white; background: black;">Cutting</span>`
					}
					if (data == 'packing') {
						return `<span class="badge" style="color:white; background:#ff1493">Finishing</span>`
					}
					if (data == 'waiting') {
						return `<span class="badge" style="background: orange">Menunggu Material/Alat</span>`
					}
				}
			},{
				title: 'Duration', data: 'durasi', className: 'min-w-125px',
				render: function (data, type, row) {
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					if (m.isBefore(now, 'day')) {
						return row.durasi + `<span class="badge" style="color:white;background:red; margin-left:4px;">Late</span>`
					} else {
						return row.durasi
					}
				}
			},{
				title: 'Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			}, {
				title: 'Due Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					const date = m.isValid()?m.format('DD/MM/YYYY') : ''
					if (m.isBefore(now, 'day')) {
						return `<span class="badge" style="color:red;">${date}</span>`
					} else {
						return date
					}
				}
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				paginate: {
					first: '<i class="fa fs-4 fa-angle-double-left"></i>',
					previous: '<i class="fa fs-4 fa-angle-left"></i>',
					next: '<i class="fa fs-4 fa-angle-right"></i>',
					last: '<i class="fa fs-4 fa-angle-double-right"></i>',
				},
			},
			dom:
			"<'row'" +
			"<'col-6 d-flex align-items-center justify-content-start'li>" +
			"<'col-6 d-flex align-items-center justify-content-end'p>" +
			">" +
			"<'table-responsive'tr>"
		})

		table_waiting = $('#table-waiting').DataTable({
		    order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 5,
			serverSide: true,
			pagingType: "full_numbers",
			ajax: '<?= $user['id_role'] ==2 ? base_url('api/' . $module .'/waiting/' . $user['id']) : base_url('api/' . $module .'/waiting/' . null)   ?>' ,
			columns: [
			{
				title: 'Information', data: 'id_pesanan', className: 'min-w-125px',
				render: function (data, type, row) {
					if (row.id_pesanan) {
						return `<span> Ordering: ${row.id_pesanan} - ${row.user.name}</span>`
					} else {
						return `<span> Stok: ${row.id_spk} - ${row.user.name}</span>`
					}
				}
			},{
				title: 'Status', data: 'status', className: 'min-w-125px',
				render : function (data, type, row) {
					if (data == 'approved') {
						return `<span class="badge" style="background: yellow">Disetujui Kualitas</span>`
					}
					if (data == 'approved-shipping') {
						return `<span class="badge" style="background: #402f1d; color: white;">Approved Logistik</span>`
					}
					if (data == 'done') {
						return `<span class="badge badge-info">Selesai</span>`
					}
					if (data == 'desain') {
						return `<span class="badge" style="color:black; background: red;">Design</span>`
					}
					if (data == 'printing') {
						return `<span class="badge" style="color:white; background: #000035">Printing</span>`
					}
					if (data == 'cutting') {
						return `<span class="badge" style="color:white; background: black;">Cutting</span>`
					}
					if (data == 'packing') {
						return `<span class="badge" style="color:white; background:#ff1493">Finishing</span>`
					}
					if (data == 'waiting') {
						return `<span class="badge" style="background: orange">Menunggu Material/Alat</span>`
					}
				}
			},{
				title: 'Duration', data: 'durasi', className: 'min-w-125px',
				render: function (data, type, row) {
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					if (m.isBefore(now, 'day')) {
						return row.durasi + `<span class="badge" style="color:white;background:red; margin-left:4px;">Late</span>`
					} else {
						return row.durasi
					}
				}
			},{
				title: 'Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			}, {
				title: 'Due Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					const date = m.isValid()?m.format('DD/MM/YYYY') : ''
					if (m.isBefore(now, 'day')) {
						return `<span class="badge" style="color:red;">${date}</span>`
					} else {
						return date
					}
				}
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				paginate: {
					first: '<i class="fa fs-4 fa-angle-double-left"></i>',
					previous: '<i class="fa fs-4 fa-angle-left"></i>',
					next: '<i class="fa fs-4 fa-angle-right"></i>',
					last: '<i class="fa fs-4 fa-angle-double-right"></i>',
				},
			},
			dom:
			"<'row'" +
			"<'col-6 d-flex align-items-center justify-content-start'li>" +
			"<'col-6 d-flex align-items-center justify-content-end'p>" +
			">" +
			"<'table-responsive'tr>"
		})

		table_done = $('#table-selesai').DataTable({
		    order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 5,
			serverSide: true,
			pagingType: "full_numbers",
			ajax: '<?= $user['id_role'] ==2 ? base_url('api/' . $module .'/done/' . $user['id']) : base_url('api/' . $module .'/done/' . null)   ?>' ,
			columns: [
			{
				title: 'Information', data: 'id_pesanan', className: 'min-w-125px',
				render: function (data, type, row) {
					if (row.id_pesanan) {
						return `<span> Ordering: ${row.id_pesanan} - ${row.user.name}</span>`
					} else {
						return `<span> Stok: ${row.id_spk} - ${row.user.name}</span>`
					}
				}
			},{
				title: 'Status', data: 'status', className: 'min-w-125px',
				render : function (data, type, row) {
					if (data == 'approved') {
						return `<span class="badge" style="background: yellow">Disetujui Kualitas</span>`
					}
					if (data == 'approved-shipping') {
						return `<span class="badge" style="background: #402f1d; color: white;">Approved Logistik</span>`
					}
					if (data == 'done') {
						return `<span class="badge badge-info">Selesai</span>`
					}
					if (data == 'desain') {
						return `<span class="badge" style="color:black; background: red;">Desain</span>`
					}
					if (data == 'printing') {
						return `<span class="badge" style="color:white; background: #000035">Printing</span>`
					}
					if (data == 'cutting') {
						return `<span class="badge" style="color:white; background: black;">Cutting</span>`
					}
					if (data == 'packing') {
						return `<span class="badge" style="color:white; background:#ff1493">Finishing</span>`
					}
					if (data == 'waiting') {
						return `<span class="badge" style="background: orange">Menunggu Material/Alat</span>`
					}
				}
			},{
				title: 'Duration', data: 'durasi', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					if (m.isBefore(now, 'day')) {
						return row.durasi + `<span class="badge" style="color:white;background:red; margin-left:4px;">Late</span>`
					} else {
						return row.durasi
					}
				}
			},{
				title: 'Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			}, {
				title: 'Due Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					const date = m.isValid()?m.format('DD/MM/YYYY') : ''
					if (m.isBefore(now, 'day')) {
						return `<span class="badge" style="color:red;">${date}</span>`
					} else {
						return date
					}
				}
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				paginate: {
					first: '<i class="fa fs-4 fa-angle-double-left"></i>',
					previous: '<i class="fa fs-4 fa-angle-left"></i>',
					next: '<i class="fa fs-4 fa-angle-right"></i>',
					last: '<i class="fa fs-4 fa-angle-double-right"></i>',
				},
			},
			dom:
			"<'row'" +
			"<'col-6 d-flex align-items-center justify-content-start'li>" +
			"<'col-6 d-flex align-items-center justify-content-end'p>" +
			">" +
			"<'table-responsive'tr>"
		})

		table_approved = $('#table-approved-qc').DataTable({
		    order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 5,
			serverSide: true,
			pagingType: "full_numbers",
			ajax: '<?= $user['id_role'] ==2 ? base_url('api/' . $module .'/approved/' . $user['id']) : base_url('api/' . $module .'/approved/' . null)   ?>' ,
			columns: [
			{
				title: 'Information', data: 'id_pesanan', className: 'min-w-125px',
				render: function (data, type, row) {
					if (row.id_pesanan) {
						return `<span> Ordering: ${row.id_pesanan} - ${row.user.name}</span>`
					} else {
						return `<span> Stok: ${row.id_spk} - ${row.user.name}</span>`
					}
				}
			},{
				title: 'Status', data: 'status', className: 'min-w-125px',
				render : function (data, type, row) {
					if (data == 'approved') {
						return `<span class="badge" style="background: yellow;color:black;">Disetujui Kualitas</span>`
					}
					if (data == 'approved-shipping') {
						return `<span class="badge" style="background: #402f1d; color: white;">Approved Logistik</span>`
					}
					if (data == 'done') {
						return `<span class="badge badge-info">Selesai</span>`
					}
					if (data == 'desain') {
						return `<span class="badge" style="color:black; background: red;">Design</span>`
					}
					if (data == 'printing') {
						return `<span class="badge" style="color:white; background: #000035">Printing</span>`
					}
					if (data == 'cutting') {
						return `<span class="badge" style="color:white; background: black;">Cutting</span>`
					}
					if (data == 'packing') {
						return `<span class="badge" style="color:white; background:#ff1493">Finishing</span>`
					}
					if (data == 'waiting') {
						return `<span class="badge" style="background: orange">Menunggu Material/Alat</span>`
					}
				}
			},{
				title: 'Duration', data: 'durasi', className: 'min-w-125px',
				render: function(data, type, row) {
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					if (m.isBefore(now, 'day')) {
						return row.durasi + `<span class="badge" style="color:white;background:red; margin-left:4px;">Late</span>`
					} else {
						return row.durasi
					}
				}
			},{
				title: 'Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			}, {
				title: 'Due Date', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.due_date)
					const now = moment().format('YYYY-MM-DD')
					const date = m.isValid()?m.format('DD/MM/YYYY') : ''
					if (m.isBefore(now, 'day')) {
						return `<span class="badge" style="color:red;">${date}</span>`
					} else {
						return date
					}
				}
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				paginate: {
					first: '<i class="fa fs-4 fa-angle-double-left"></i>',
					previous: '<i class="fa fs-4 fa-angle-left"></i>',
					next: '<i class="fa fs-4 fa-angle-right"></i>',
					last: '<i class="fa fs-4 fa-angle-double-right"></i>',
				},
			},
			dom:
			"<'row'" +
			"<'col-6 d-flex align-items-center justify-content-start'li>" +
			"<'col-6 d-flex align-items-center justify-content-end'p>" +
			">" +
			"<'table-responsive'tr>"
		})

		var chart_repeter = document.getElementById('kt_charts_repeate');
		var chart_repeter_dgp = document.getElementById('kt_charts_repeate_dgp');

		var height = parseInt(KTUtil.css(chart_repeter, 'height'));
		var heightDgp = parseInt(KTUtil.css(chart_repeter_dgp, 'height'));

		var labelColor = KTUtil.getCssVariableValue('--bs-dark');
		var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
		var baseColor = KTUtil.getCssVariableValue('--bs-primary');
		var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');

		if (!chart_repeter) {
		    return;
		}

		if (!chart_repeter_dgp) {
		    return;
		}

		var options = {
		    series: [{
		        name: 'Repeat Order',
		        data: []
		    }],
		    chart: {
		        fontFamily: 'inherit',
		        type: 'bar',
		        height: height,
		        toolbar: {
		            show: false
		        }
		    },
		    plotOptions: {
		        bar: {
		            horizontal: true,
		            columnWidth: '5%',
		            endingShape: 'rounded',
		            borderRadius: 10
		        }
		    },
		    legend: {
		        show: false
		    },
		    dataLabels: {
		        enabled: false
		    },
		    stroke: {
		        show: true,
		        width: 2,
		        colors: ['transparent']
		    },
		    xaxis: {
		        categories: [],
		        axisBorder: {
		            show: false
		        },
		        axisTicks: {
		            show: false
		        },
		        labels: {
		            style: {
		                colors: labelColor,
		                fontSize: '12px'
		            }
		        }
		    },
		    yaxis: {
		        labels: {
		            style: {
		                colors: labelColor,
		                fontSize: '10px'
		            }
		        }
		    },
		    fill: {
		        opacity: 1
		    },
		    states: {
		        normal: {
		            filter: {
		                type: 'none',
		                value: 0
		            }
		        },
		        hover: {
		            filter: {
		                type: 'none',
		                value: 0
		            }
		        },
		        active: {
		            allowMultipleDataPointsSelection: false,
		            filter: {
		                type: 'none',
		                value: 0
		            }
		        }
		    },
		    tooltip: {
		        style: {
		            fontSize: '12px'
		        },
		        y: {
		            formatter: function (val) {
		                return val + ' orders';
		            }
		        }
		    },
		    colors: [baseColor, secondaryColor],
		    grid: {
		        borderColor: borderColor,
		        strokeDashArray: 4,
		        yaxis: {
		            lines: {
		                show: true
		            }
		        }
		    }
		};
		repeater = new ApexCharts(chart_repeter, options);
		repeater.render();

		repeaterDgp = new ApexCharts(chart_repeter_dgp, options);
		repeaterDgp.render();

		$.ajax({
		    type: "GET",
		    url: "<?= base_url('api/barang/repeate') ?>",
		    success: function(response) {
		        const categories = response.map(item => item.y);
		        const seriesData = response.map(item => item.x);
		        repeater.updateOptions({
		            xaxis: { categories: categories }
		        });

		        repeater.updateSeries([{
		            name: 'Repeat Order',
		            data: seriesData
		        }]);
		    }
		});

		$.ajax({
		    type: "GET",
		    url: "<?= base_url('api/barangdgp/repeate') ?>",
		    success: function(response) {
		        const categories = response.map(item => item.y);
		        const seriesData = response.map(item => item.x);
		        repeaterDgp.updateOptions({
		            xaxis: { categories: categories }
		        });

		        repeaterDgp.updateSeries([{
		            name: 'Repeat Order',
		            data: seriesData
		        }]);
		    }
		});


		
	})

	
	var pusher = new Pusher('4d33ba8d1be6bb870f00', {
    		cluster: 'ap1',
    		encrypted: true
		});

	var channel = pusher.subscribe("real-dashboard");
	channel.bind('acttivity', function(data) {
		activity()
		chartRepeateProduct()
		chartRepeateProductDigital()
		console.log(data)
	});

	channel.bind('proses', function(data) {
		console.log(data)
		getCountProses()
		table_all.ajax.reload(null, false)
		table_cutting.ajax.reload(null, false)
		table_desain.ajax.reload(null, false)
		table_printing.ajax.reload(null, false)
		table_packing.ajax.reload(null, false)
		table_waiting.ajax.reload(null, false)
		table_done.ajax.reload(null, false)
		table_approved.ajax.reload(null, false)
	});



</script>
