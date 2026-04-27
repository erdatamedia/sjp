<script src="<?= base_url('assets/plugins/custom/formrepeater/formrepeater.bundle.js') ?>"></script>
<script type="text/javascript">

	const id_pesanan  = $('input[name=id_pesanan]')
	const jenis_order = $('select.jenis-order')
	const delivery_date = $('input[name=tgl_pengiriman]')

	// Besok sebagai tanggal minimum Delivery Date
	const tomorrow = new Date()
	tomorrow.setDate(tomorrow.getDate() + 1)
	tomorrow.setHours(0, 0, 0, 0)

	// minDate: besok — flatpickr otomatis tambahkan class flatpickr-disabled
	// ke hari ini & sebelumnya, lalu CSS di v_form.php warnai merah
	const flatpickrInstancePengiriman = delivery_date.flatpickr({
		altInput: true,
		altFormat: "d M Y",
		dateFormat: "Y-m-d",
		minDate: tomorrow,
		defaultDate: null
	})

	let products = []

	$(document).ready(function() {
		const is_edit = '<?= !empty($x['detail']) ? 1 : 0 ?>'

		$('#kt_docs_repeater_basic').repeater({
			initEmpty: (is_edit=='1') ? false : true,
			defaultValues: { 'text-input': 'foo' },
			show: function () {
				$(this).slideDown()
				const id_product  = $(this).find('[data-field="id_barang"]')
				const description = $(this).find('[data-field="deskripsi"]')
				const qty         = $(this).find('[data-field="qty"]')

				id_product.select2({ placeholder: 'Select a product', allowClear: true })
				id_product.on('select2:clear', function() { description.val('') })
				id_product.change(function() { description.val('') })
			},
			hide: function (deleteElement) {
				$(this).slideUp(deleteElement)
			}
		})

		$('[data-field="id_barang"]').each((i, j) => {
			$(j).select2({ placeholder: 'Select a product', allowClear: true })
		})

		$("#content_container").submit(function(event) {
			event.preventDefault()

			let valid = true
			const tgl_altInput = $(delivery_date[0]._flatpickr.altInput)

			if (id_pesanan.val() == '') {
				valid = false
				id_pesanan.css({ 'background-color': 'red', color: 'white' })
				toastr.error('Order ID wajib diisi')
			} else {
				id_pesanan.css({ 'background-color': '', color: '' })
			}

			if (jenis_order.val() == '') {
				valid = false
				jenis_order.css({ 'background-color': 'red', color: 'white' })
				toastr.error('Order Type wajib diisi')
			} else {
				jenis_order.css({ 'background-color': '', color: '' })
			}

			if (delivery_date.val() == '') {
				valid = false
				tgl_altInput.css({ 'background-color': 'red', color: 'white' })
				toastr.error('Delivery Date wajib diisi')
			} else {
				// Validasi minimum H+1
				const sel = new Date(delivery_date.val())
				sel.setHours(0, 0, 0, 0)
				if (sel < tomorrow) {
					valid = false
					tgl_altInput.css({ 'background-color': 'red', color: 'white' })
					toastr.error('Delivery Date minimal ' + tomorrow.toLocaleDateString('id-ID'))
				} else {
					tgl_altInput.css({ 'background-color': '', color: '' })
				}
			}

			if (valid) {
				Swal.fire({
					title: "Perhatian <?= $user['role'] . ' ' . $user['name'] . ' !' ?>",
					text: "Pastikan semua data sudah benar sebelum disimpan.",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Ya, simpan!",
					cancelButtonText: "Batal"
				}).then((result) => {
					if (result.isConfirmed) {
						$(this).unbind("submit").submit()
					}
				})
			}
		})
	})

</script>
