<script type="text/javascript">
	let table = null;

	document.addEventListener("DOMContentLoaded", function () {
		const subtable = document.querySelector('[data-kt-subtable="subtable_template"]');
		const template = subtable.cloneNode(true);
		template.classList.remove('d-none');
		subtable.remove();

		const handleActionButton = () => {
			document.querySelector('tbody').addEventListener('click', function (event) {
				const button = event.target.closest('[data-kt-subtable="expand_row"]');
				if (!button) return;

				event.stopPropagation();
				event.preventDefault();

				const row = button.closest('tr');
				const isOpen = row.classList.contains('isOpen');

				document.querySelectorAll('tr.isOpen').forEach(openRow => {
					openRow.classList.remove('isOpen', 'border-bottom-0');
					openRow.querySelector('[data-kt-subtable="expand_row"]').classList.remove('active');

					let next = openRow.nextElementSibling;
					while (next && next.hasAttribute('data-kt-subtable')) {
						next.remove();
						next = openRow.nextElementSibling;
					}
				});

				if (!isOpen) {
					const data = table.row(row).data()?.pesanan_repeater || [];
					populateTemplate(data, row);
					row.classList.add('isOpen', 'border-bottom-0');
					button.classList.add('active');
				}
			});
		};

		const populateTemplate = (data, target) => {
			data.forEach(d => {
				const m = moment(d.date)
				const newTemplate = template.cloneNode(true);
				var link = "<?= base_url('digital/view/') ?>" + d.id

				newTemplate.querySelector('[data-kt-subtable="template_order"]').innerHTML = `
				<div class="d-flex flex-column text-muted">
				<label class="form-label">Order</label>
				<a href="${link}" class="text-primary fw-bolder" data-kt-subtable="template_order">${d.id_pesanan}</a></div>`;
				newTemplate.querySelector('[data-kt-subtable="template_sales"]').innerText = d.nama_sales;
				newTemplate.querySelector('[data-kt-subtable="template_date"]').innerText = m.isValid()?m.format('DD/MM/YYYY') : '';

				target.insertAdjacentElement('afterend', newTemplate);
			});
		};

		const resetSubtable = () => {
			document.querySelectorAll('[data-kt-subtable="subtable_template"]').forEach(st => st.remove());

			document.querySelectorAll('tbody tr.isOpen').forEach(row => {
				row.classList.remove('isOpen', 'border-bottom-0');
				const button = row.querySelector('[data-kt-subtable="expand_row"]');
				if (button) button.classList.remove('active');
			});
		};

		table = $('#table').DataTable({
			order: [],
			lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
			pageLength: 10,
			pagingType: "full_numbers",
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('api/' . $module . '/allRepeat') ?>',
			columns: [{
				render: function () {
					return `<button class="btn btn-icon btn-sm btn-light btn-active-light-success toggle" data-kt-subtable="expand_row">
						<i class="bi bi-plus toggle-off"></i>
						<i class="bi bi-dash toggle-on"></i>
					</button>`;
				}
			}, {
				title: 'No.MC', data: 'barang.no_mc_label', className: 'min-w-125px',
			}, {
				title: 'Product Name', data: 'barang.nama_dgp', className: 'min-w-125px',
			}, {
				title: 'Total Order', data: 'total_repeate', className: 'min-w-125px',
			}],
			language: {
				info: '_START_ - _END_ / _TOTAL_',
				infoFiltered: '(_MAX_)',
				infoEmpty: '0',
				search: '<img src="<?= base_url('assets/media/icons/duotune/general/gen004.svg') ?>" />',
				searchPlaceholder: 'No. MC',
				paginate: {
					first: '<i class="fa fs-4 fa-angle-double-left"></i>',
					previous: '<i class="fa fs-4 fa-angle-left"></i>',
					next: '<i class="fa fs-4 fa-angle-right"></i>',
					last: '<i class="fa fs-4 fa-angle-double-right"></i>',
				},
			},
			buttons: {
				buttons: [],
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
		});

		handleActionButton();
	});
</script>
