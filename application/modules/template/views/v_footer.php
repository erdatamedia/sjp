<!-- end kt content -->
</div>

<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
	<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
		<div class="text-dark order-2 order-md-1">
			<span class="text-muted fw-bold me-1"><?= date('Y') ?> ©</span>
		</div>
		<ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
			<li class="menu-item">
				<span target="_blank" class="menu-link px-2">PT SENTRAL JAYA PERKASA</span>
			</li>
		</ul>
	</div>
</div>
<!-- end wrapper -->
</div>
<!-- end page -->
</div>
<!-- end root -->
</div>

<div id="kt_activities" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '900px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_activities_toggle" data-kt-drawer-close="#kt_activities_close">
	<div class="card shadow-none rounded-0 w-100">
		<div class="card-header" id="kt_activities_header">
			<h3 class="card-title fw-bolder text-dark">Activity Logs</h3>
			<div class="card-toolbar">
				<button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_activities_close">
					<span class="svg-icon svg-icon-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
							<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
						</svg>
					</span>
				</button>
			</div>
		</div>
		<div class="card-body position-relative" id="kt_activities_body">
			<div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body" data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer" data-kt-scroll-offset="5px">
				<div class="timeline" id="act-timeline"></div>
			</div>
		</div>
		<div class="card-footer py-5 text-center" id="kt_activities_footer">
			<a href="<?= base_url('activity') ?>" class="btn btn-bg-body text-primary">View All Activities
				<span class="svg-icon svg-icon-3 svg-icon-primary">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
						<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
					</svg>
				</span>
			</a>
		</div>
	</div>
</div>

<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
	<span class="svg-icon">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
			<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
			<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
		</svg>
	</span>
</div>


<script src="<?= base_url('assets/plugins/global/plugins.bundle.js')?>"></script>
<script src="<?= base_url('assets/js/scripts.bundle.js')?>"></script>
<script src="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.js')?>"></script>
<script src="<?= base_url('assets/js/custom/widgets.js')?>"></script>
<script src="<?= base_url('assets/plugins/custom/typedjs/typedjs.bundle.js')?>"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script type="text/javascript">
	var id_user_notif = <?php echo $user['id_role']; ?>;

	function countNotif() {
		$.ajax({
			type: "GET",
			url: "<?= base_url('api/notification/countNotif?id=') ?>" + id_user_notif,
			success: function(response) {
				if (response.count > 0) {
					$('#blink').show()
					$('#plush').show()
					$('.reports').text(response.count + " Works")
				} else {
					$('#blink').hide()
					$('#plush').hide()
					$('.reports').text(response.count + " Works")
				}
			},
		});
	}

	$(document).ready(function() {
		$('#blink').hide()
		$('#plush').hide()

		let notif_polosan_table = $('#tabel_notif_polosan').DataTable({
			paging: false,
			ordering: false,
			info: false,
			serverSide: true,
			ajax: '<?= base_url('api/notification/notifPolosan?id=') ?>' + id_user_notif,
			"language": {
				"zeroRecords": "No Notifications"
			},
			columns: [
			{
				data: null,
				render: function(data, type, row) {
					moment.locale('id')
					const waktu = moment(row.created_at)
					return `<div class="card bg-header p-4"><div class="flex-root d-flex flex-column">
					<span >Order : ${row.pekerjaan ? row.pekerjaan.id_pesanan : '' } - ${row.user ? row.user.name : ''} </span>
					<span >${row.count_barang} Product</span>
					</div><span class="text-end">${waktu.startOf('second').fromNow()}</span></div>`
				}

			},


			],
		});


		let notif_custom_table = $('#tabel_notif_custom').DataTable({
			paging: false,
			ordering: false,
			info: false,
			serverSide: true,
			ajax: '<?= base_url('api/notification/notifCustomDesain?id=') ?>' + id_user_notif,
			"language": {
				"zeroRecords": "No Notifications"
			},
			columns: [
			{
				data: null,
				render: function(data, type, row) {
					const waktu = moment(row.created_at)
					return `<div class="card bg-header p-4"><div class="flex-root d-flex flex-column">
					<span >Order : ${row.pekerjaan ? row.pekerjaan.id_pesanan : '' } - ${row.user ? row.user.name : ''} </span>
					<span >${row.count_barang} Product </span>
					</div><span class="text-end">${waktu.startOf('second').fromNow()}</span></div>`
				}

			},

			],
		});


		let notif_digital_table = $('#tabel_notif_digital').DataTable({
			paging: false,
			ordering: false,
			info: false,
			serverSide: true,
			ajax: '<?= base_url('api/notification/notifDigital?id=') ?>' + id_user_notif,
			"language": {
				"zeroRecords": "No Notifications"
			},
			columns: [
			{
				data: null,
				render: function(data, type, row) {
					const waktu = moment(row.created_at)
					return `<div class="card bg-header p-4"><div class="flex-root d-flex flex-column">
					<span >Order : ${row.pekerjaan.id_pesanan} - ${row.user.name} </span>
					<span >${row.count_barang} Product </span>
					</div><span class="text-end">${waktu.startOf('second').fromNow()}</span></div>`
				}

			},

			],
		});



		$.ajax({
			type: "GET",
			url: "<?= base_url('api/notification/countNotif?id=') ?>" + id_user_notif,
			success: function(response) {
				if (response.count > 0) {
					$('#blink').show()
					$('#plush').show()
					$('.reports').text(response.count + " Works")
				} else {
					$('#blink').hide()
					$('#plush').hide()
					$('.reports').text(response.count + " Works")
				}
			},
		});

		var pusher = new Pusher('4d33ba8d1be6bb870f00', {
    		cluster: 'ap1',
    		encrypted: true
		});

		var channel = pusher.subscribe("<?= $user['id_role'] ?>-role");
		channel.bind('polosan', function(data) {
		    notif_polosan_table.ajax.reload(null, false)
		    countNotif()
		    toastr.success(JSON.stringify(data.message));
		});

		channel.bind('custom', function(data) {
		    notif_custom_table.ajax.reload(null, false)
		    countNotif()
		    toastr.success(JSON.stringify(data.message));
		});

		channel.bind('digital', function(data) {
		    notif_digital_table.ajax.reload(null, false)
		    countNotif()
		    toastr.success(JSON.stringify(data.message));
		});
	})
</script>
