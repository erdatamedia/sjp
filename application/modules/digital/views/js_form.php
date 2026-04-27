<script src="<?= base_url('assets/plugins/custom/formrepeater/formrepeater.bundle.js') ?>"></script>
<script type="text/javascript">

    const id_pesanan = 	$('input[name=id_pesanan]')
    const jenis_order = 	$('select.jenis-order')
    const delivery_date = 	$('input[name=tgl_pengiriman]')
    const due_date = $('input[name=due_date]')

    const tomorrow = new Date()
    tomorrow.setDate(tomorrow.getDate() + 1)
    tomorrow.setHours(0, 0, 0, 0)

    const flatpickrInstancePengiriman = delivery_date.flatpickr({
        altInput: true,
        altFormat: "d M Y",
        dateFormat: "Y-m-d",
        minDate: tomorrow,
        defaultDate: null
    });

    const flatpickrInstanceDueDate = due_date.flatpickr({
        altInput: true,
        altFormat: "d M Y",
        dateFormat: "Y-m-d",
        minDate: tomorrow,
        defaultDate: null
    });

    function handleTanggal(el) {
        if ($('select.jenis-order').val() == 'lainnya') {
            $('.group-tanggal').show()
        } else {
            $('.group-tanggal').hide()
        }
    }

    let products = []

    $(document).ready(function() {
        if ($('select.jenis-order').val() == 'lainnya') {
            $('.group-tanggal').show()
        } else {
            $('.group-tanggal').hide()
        }
        const is_edit = '<?= !empty($x['detail']) ? 1 : 0 ?>'



        $('#kt_docs_repeater_basic').repeater({
            initEmpty: (is_edit=='1') ? false : true,
            defaultValues: {
                'text-input': 'foo'
            },
            show: function () {
                $(this).slideDown()
                const material    = $(this).find('[data-field="material"]')
                const finishing   = $(this).find('[data-field="finishing"]')
                const description 	= $(this).find('[data-field="deskripsi"]')
                const ukuran       = $(this).find('[data-field="ukuran"]')
                const qty           = $(this).find('[data-field="qty"]')

                material.select2({
                    placeholder: 'Select a material',
                    allowClear: true
                })

                finishing.select2({
                    placeholder: 'Select a finishing',
                    allowClear: true
                })

                material.on('select2:clear', function (e) {
					description.val('')
				})
				id_product.change((e)=>{
					description.val('')
				})
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement)
            }
        })

        $('[data-field="material"]').each((i,j)=>{
            const material    = $(j)

            material.select2({
                placeholder: 'Select a material',
                allowClear: true
            })
        })

        $('[data-field="finishing"]').each((i,j)=>{
            const finishing    = $(j)

            finishing.select2({
                placeholder: 'Select a finishing',
                allowClear: true
            })
        })

        $("#content_container").submit(function(event) {
	        event.preventDefault();

          let valid = true
					const tgl_altInputPengiriman = $(delivery_date[0]._flatpickr.altInput);
					const tgl_altInputDueDate = $(due_date[0]._flatpickr.altInput);

					if (id_pesanan.val() == '') {
						valid = false
						id_pesanan.css('background-color', 'red').css('color', 'white')
						toastr.error('Order Id wajib di isi')
					}else{
						id_pesanan.css('color', '').css('background-color', '')
					}
					if (jenis_order.val() == '') {
						valid = false
						jenis_order.css('background-color', 'red').css('color', 'white')
						toastr.error('Order Type wajib di isi')
					}else{
						jenis_order.css('color', '').css('background-color', '')
					}
					if (delivery_date.val() == '') {
						valid = false
						tgl_altInputPengiriman.css('background-color', 'red').css('color', 'white')
						toastr.error('Delivery Date wajib di isi')
					} else {
						const selPengiriman = new Date(delivery_date.val())
						selPengiriman.setHours(0, 0, 0, 0)
						if (selPengiriman < tomorrow) {
							valid = false
							tgl_altInputPengiriman.css('background-color', 'red').css('color', 'white')
							toastr.error('Delivery Date minimal ' + tomorrow.toLocaleDateString('id-ID'))
						} else {
							tgl_altInputPengiriman.css('color', '').css('background-color', '')
						}
					}
					if (jenis_order.val() == 'lainnya') {
						if (due_date.val() == '') {
							valid = false
							tgl_altInputDueDate.css('background-color', 'red').css('color', 'white')
							toastr.error('Due Date wajib di isi')
						} else {
							const selDueDate = new Date(due_date.val())
							selDueDate.setHours(0, 0, 0, 0)
							if (selDueDate < tomorrow) {
								valid = false
								tgl_altInputDueDate.css('background-color', 'red').css('color', 'white')
								toastr.error('Due Date minimal ' + tomorrow.toLocaleDateString('id-ID'))
							} else {
								tgl_altInputDueDate.css('color', '').css('background-color', '')
							}
						}
					}

					if (valid) {
						Swal.fire({
							 title: "Perhatian <?= $user['role'] . " " . $user['name'] . " !" ?>",
							 text: "Pastikan semua data sudah benar sebelum disimpan.",
							 icon: "warning",
							 showCancelButton: true,
							 confirmButtonColor: "#3085d6",
							 cancelButtonColor: "#d33",
							 confirmButtonText: "Ya, simpan!",
							 cancelButtonText: "Batal"
					 }).then((result) => {
							 if (result.isConfirmed) {
									 $(this).unbind("submit").submit();
							 }
					 });
					}
	    });

    })

</script>
