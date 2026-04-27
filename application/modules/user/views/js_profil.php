<script src="<?= base_url('assets/plugins/custom/fslightbox/fslightbox.bundle.js')?>"></script>
<script type="text/javascript">
    function removebg(id) {
        $.ajax({
            url: '<?= base_url('api/'.$module.'/delPhoto') ?>',
            data: {id:id},
            type: 'POST',
            success: function(response) {
                if (response['status']) {
                    toastr.success(response['msg'])
                }

            },
            error: function(error){
                toastr.error(error.responseText)
            }
        })
    }
</script>