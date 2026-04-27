<script type="text/javascript">
	const id_role_user = <?php echo $user['id_role']; ?>;
	const id_user = <?php echo $user['id']; ?>;
	let table = null
	
	const subtable = document.querySelector('[data-kt-subtable="subtable_template"]')
	template = subtable.cloneNode(true)
	template.classList.remove('d-none')
	subtable.parentNode.removeChild(subtable)
	$('#table-placeholder').remove()

	const handleActionButton = () => {
		const buttons = document.querySelectorAll('[data-kt-subtable="expand_row"]')

		buttons.forEach((button, index) => {
			button.addEventListener('click', e => {
				e.stopImmediatePropagation()
				e.preventDefault()

				const row = button.closest('tr')
				const rowClasses = ['isOpen', 'border-bottom-0']

				if (row.classList.contains('isOpen')) {
					while (row.nextSibling && row.nextSibling.getAttribute('data-kt-subtable') === 'subtable_template') {
						row.nextSibling.parentNode.removeChild(row.nextSibling)
					}
					row.classList.remove(...rowClasses)
					button.classList.remove('active')
				} else {
					populateTemplate(table.row(index).data()['detail'], row)
					row.classList.add(...rowClasses)
					button.classList.add('active')
				}
				
			})
		})
	}

	const populateTemplate = (data, target) => {
		data.forEach((d, index) => {
			const newTemplate = template.cloneNode(true)

			const name = newTemplate.querySelector('[data-kt-subtable="template_name"]')
			const description = newTemplate.querySelector('[data-kt-subtable="template_description"]')
			const qty = newTemplate.querySelector('[data-kt-subtable="template_qty"]')

		
			name.innerText = (d['no_mc'] ? d['no_mc'] : "Product not found") + " " + (d['item_box'] ? d['item_box'] : "");
            description.innerText = d['deskripsi'] ? d['deskripsi'] : "Description not available";
			qty.innerText = d['qty']

			const tbody = document.querySelector('#tbody')
			tbody.insertBefore(newTemplate, target.nextSibling)
		})
	}

	const resetSubtable = () => {
		const subtables = $('[data-kt-subtable="subtable_template"]')
		subtables.each((i,st) => {
			st.parentNode.removeChild(st)
		})

		const rows = $('tbody tr')
		rows.each((i,r) => {
			r.classList.remove('isOpen')
			if (r.querySelector('[data-kt-subtable="expand_row"]')) {
				r.querySelector('[data-kt-subtable="expand_row"]').classList.remove('active')
			}
		})
	}
	

	function del(el,id) {
		Swal.fire({
			text: 'Hapus?',
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
						} else {
							toastr.error(response['msg'] + '<br/>' + response['data'].slice(0,5).join('<br/>') + (response['data'].length-5 > 0 ? '<br/>and '+(response['data'].length-5) + ' more. Click view for details' : ''))
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

		$('#status').change((e) => {
			const value = $('#status').val()
			table.columns(5).search(value).draw()
		})

		$('.count').each((i, j) => {
			const status = $(j).data('status')
			$(j).parent().click(e => {
				$('#status').val(status).trigger('change')
			})
		})

		$('[data-status]').on('click', function() {
			table.columns.adjust().draw();
		})

		table = $('#table').DataTable({
			order: [],
			drawCallback: function(settings) {
				resetSubtable()
				handleActionButton();
				// settings.json is null on initial empty draw (before AJAX) — guard before access
				const countData = settings['json'] && settings['json']['count']
				if (!countData) return
				let total_count = 0
				$('.count').each((i, j) => {
					if (i > 0) {
						const statuss = $(j).data('status')
						const count = countData[statuss]
						$(j).text(count ? count : 0)
						total_count += count ? count : 0
					}
				})
				$('.count').each((i, j) => {
					if (i == 0) {
						$(j).text(total_count)
					}
				})
			},
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= $user['id_role'] == 2? base_url('api/' . $module . '/sales?id_user='. $user['id'])  : base_url('api/' . $module) ?>',
			columns: [{
				render : function (data, type, row) {
					return ` <button class="btn btn-icon btn-sm btn-light btn-active-light-success toggle" data-kt-subtable="expand_row">
					<i class="bi bi-plus toggle-off"></i>
					<i class="bi bi-dash toggle-on"></i>
					</button>`
				}
			},{
				title: 'Order ID', data: 'id_pesanan', className: 'min-w-125px',
			},{
				title: 'Tanggal', data: 'created_at', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.created_at)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'Tenggat', data: 'due_date', className: 'min-w-125px',
				render : function (data, type, row){
					const m = moment(row.due_date)
					return m.isValid()?m.format('DD/MM/YYYY') : ''
				}
			},{
				title: 'Jenis Order', data: 'jenis_order', className: 'min-w-125px',
				render : function (data, type, row) {
					if (data == 'lainnya') {
						return "Other"
					}
					if (data == 'new-order') {
						return "New Order"
					}
					if (data == 'repeat-order') {
						return "Repeat Order"
					}
				}
			},{
				title: 'Status', data: 'status', className: 'min-w-125px',
				render : function (data, type, row) {
				const map = {
					'waiting':           ['Menunggu Material/Alat', 'rgba(200,100,0,0.1)',    '#a05500', 'rgba(200,100,0,0.3)'],
					'cutting':           ['Cutting',                'rgba(30,30,30,0.09)',    '#222',    'rgba(30,30,30,0.28)'],
					'printing':          ['Printing',               'rgba(11,26,189,0.07)',   '#0b1abd', 'rgba(11,26,189,0.28)'],
					'desain':            ['Desain',                 'rgba(200,0,0,0.07)',     '#b00000', 'rgba(200,0,0,0.28)'],
					'packing':           ['Finishing',              'rgba(255,20,147,0.08)',  '#b5186b', 'rgba(255,20,147,0.28)'],
					'done':              ['Selesai',                'rgba(13,110,253,0.07)',  '#0a58ca', 'rgba(13,110,253,0.28)'],
					'approved':          ['Disetujui QC',     'rgba(200,180,0,0.08)',   '#7a6800', 'rgba(180,160,0,0.35)'],
					'approved-shipping': ['Disetujui Logistik',     'rgba(64,47,29,0.07)',    '#402f1d', 'rgba(64,47,29,0.3)'],
					'approved-customer': ['Dikirim',                'rgba(34,143,21,0.07)',   '#1a6b0f', 'rgba(34,143,21,0.3)'],
				};
				if (!data || !map[data]) return '<span class="badge badge-secondary">-</span>';
				const [label, bg, color, border] = map[data];
				return `<span class="badge" style="background:${bg};color:${color};border:1.5px solid ${border};font-weight:600;padding:4px 10px;border-radius:8px;">${label}</span>`;
				}
			},{
				title: 'Sales', data: 'name', className: 'min-w-125px',
				render : function (data, type, row) {
					return data? data : 'Kosong'
				}
			},{
				title: 'Aksi', data: 'id', className: 'text-end action-column', sortable: false,
				render: function (data, type, row) {

					if (id_role_user == 2) {
						return `
						<div class="btn-group btn-group-sm">
						<a href="<?= base_url('polosan/form/') ?>${data}" class="btn btn-icon btn-light btn-active-light-success"><i class="bi bi-pencil"></i></a>
						<a href="<?= base_url('polosan/view/') ?>${data}" class="btn btn-icon btn-light btn-active-light-success"><i class="bi bi-eye"></i></a>
						<button class="btn btn-icon btn-light btn-active-light-danger" onclick="del(this,${data})"><i class="bi bi-trash3"></i></button>
						</div>`
					} else {
						return `
						<div class="btn-group btn-group-sm">
						<a href="<?= base_url('polosan/view/') ?>${data}" class="btn btn-icon btn-light btn-active-light-success"><i class="bi bi-eye"></i></a> 
						</div>`
					}

				},
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'Order ID',
				paginate: {
					first: '<i class="fa fs-4 fa-angle-double-left"></i>',
					previous: '<i class="fa fs-4 fa-angle-left"></i>',
					next: '<i class="fa fs-4 fa-angle-right"></i>',
					last: '<i class="fa fs-4 fa-angle-double-right"></i>',
				},
			},
			buttons: {
				buttons: [
				{
					text: 'Create',
					className: `btn-primary ${id_role_user !=2? 'disabled' : ''}`,
					action: function (e, dt, node, config) {
						window.location = '<?= base_url('polosan/form') ?>'
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
	table.columns.adjust().draw();
})
</script>
