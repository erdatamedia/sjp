<script type="text/javascript">
	$(document).ready(function() {
		$('[name="color_navbar"]').on('input',e=>{
			$('[name="color_navbar_hex"]').val($(e.currentTarget).val())
			$('#kt_aside').css('backgroundColor',$(e.currentTarget).val())
		})
		$('[name="color_navbar_hex"]').on('input',e=>{
			$('[name="color_navbar"]').val($(e.currentTarget).val())
			$('#kt_aside').css('backgroundColor',$(e.currentTarget).val())
		})

		$('[name="color_text"]').on('input',e=>{
			$('[name="color_text_hex"]').val($(e.currentTarget).val())
			$('.menu-title').css('color',$(e.currentTarget).val())
			$('#logout_txt').css('color',$(e.currentTarget).val())
		})
		$('[name="color_text_hex"]').on('input',e=>{
			$('[name="color_text"]').val($(e.currentTarget).val())
			$('.menu-title').css('color',$(e.currentTarget).val())
			$('#logout_txt').css('color',$(e.currentTarget).val())
		})

		$('[name="color_icon"]').on('input',e=>{
			$('[name="color_icon_hex"]').val($(e.currentTarget).val())
			$('.menu-icon').children().children().children().attr('style','fill: '+$(e.currentTarget).val()+' !important')
			$('.menu-icon2').children().children().children().attr('style','fill: '+$(e.currentTarget).val()+' !important')
			$('#logout_icon').children().css('fill',$(e.currentTarget).val())
			$('#setting_icon').children().css('fill',$(e.currentTarget).val())
		})
		$('[name="color_icon_hex"]').on('input',e=>{
			$('[name="color_icon"]').val($(e.currentTarget).val())
			$('.menu-icon').children().children().children().attr('style','fill: '+$(e.currentTarget).val()+' !important')
			$('.menu-icon2').children().children().children().attr('style','fill: '+$(e.currentTarget).val()+' !important')
			$('#logout_icon').children().css('fill',$(e.currentTarget).val())
			$('#setting_icon').children().css('fill',$(e.currentTarget).val())
		})

		$('#color_navbar_reset').click(e=>{
			$('[name="color_navbar"]').val('#efe9e1').trigger('input')
		})
		$('#color_text_reset').click(e=>{
			$('[name="color_text"]').val('#5e6278').trigger('input')
		})
		$('#color_icon_reset').click(e=>{
			$('[name="color_icon"]').val('#7e8299').trigger('input')
		})

		const note = new Quill('#note', {
			modules: {
				toolbar: true
			},
			placeholder: 'Special instruction or message to the client',
			theme: 'snow'
		})
		note.on('text-change', function() {
			$('[name=note]').html(note.root.innerHTML)
		})

		const term = new Quill('#term', {
			modules: {
				toolbar: true
			},
			placeholder: 'Terms of payment, warranty, etc.',
			theme: 'snow'
		})
		term.on('text-change', function() {
			$('[name=term]').html(term.root.innerHTML)
		})

	})
</script>
