<script src="<?= base_url('assets/plugins/custom/fslightbox/fslightbox.bundle.js')?>"></script>
<script type="text/javascript">
	$(document).ready(function () {
		var table = $('#table').DataTable({
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
			}, {
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
			},{
				title: 'Action', data: 'id', className: 'text-end action-column', sortable: false,
				render: function (data, type, row) {
					return `
					<div class="btn-group btn-group-sm">
					<a href="<?= base_url('tender/view/') ?>${data}" class="btn btn-icon btn-light btn-active-light-success"><i class="bi bi-eye"></i></a>
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
					className: 'btn-primary d-none d-block',
					action: function (e, dt, node, config) {
						$('#modal_form').modal('show')
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