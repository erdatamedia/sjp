<style>.ql-container { height: auto; }</style>
<form class="container-fluid" id="content_container" method="post"
      action="<?= base_url('polosan/saveGambar') ?>" enctype="multipart/form-data">
    <div class="card mb-5">
        <input type="hidden" name="id" value="<?= $x ? $x['id'] : '' ?>" />
        <input type="hidden" name="id_pekerjaan" value="<?= $pekerjaan['id'] ?>">
        <div class="card-header align-items-center" id="card-header">
            <div class="btn-group btn-group-sm my-2 my-sm-0">
                <a href="<?= base_url('polosan/view/') . $pekerjaan['id'] ?>"
                   class="btn btn-light btn-sm me-3"><i class="bi bi-chevron-left"></i></a>
            </div>
            <div class="my-2 my-sm-0">
                <div class="btn-group btn-group-sm">
                    <?php if ($user['id_role'] == 3 && $pekerjaan['status'] == 'desain'): ?>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="card-body row justify-content-center">
            <div class="col d-flex flex-column align-items-center">
                <h2>Outside</h2>
                <div class="image-input image-input-empty image-input-outline mb-3"
                     data-kt-image-input="true"
                     style="background-image: url('<?= ($x && !empty($x['outside'])) ? base_url('assets/uploads/barang/'.$x['outside']) : $blank_product ?>')">
                    <div class="image-input-wrapper w-150px h-150px"></div>
                    <?php if ($pekerjaan['status'] == 'desain' && $user['id_role'] == 3): ?>
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                               data-kt-image-input-action="change">
                            <i class="bi bi-pencil-fill fs-7"></i>
                            <input type="file" name="outside" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="avatar_remove" />
                        </label>
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                              data-kt-image-input-action="cancel">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                    <?php endif ?>
                </div>
                <?php if ($x && !empty($x['outside'])): ?>
                    <a data-fslightbox="lightbox-basic"
                       href="<?= base_url('assets/uploads/barang/'.$x['outside']) ?>">View</a>
                <?php endif ?>
                <div class="form-text mb-5">Allowed file types: png, jpg, jpeg.</div>
            </div>
            <div class="col d-flex flex-column align-items-center">
                <h2>Inside</h2>
                <div class="image-input image-input-empty image-input-outline mb-3"
                     data-kt-image-input="true"
                     style="background-image: url('<?= ($x && !empty($x['inside'])) ? base_url('assets/uploads/barang/'.$x['inside']) : $blank_product ?>')">
                    <div class="image-input-wrapper w-150px h-150px"></div>
                    <?php if ($pekerjaan['status'] == 'desain' && $user['id_role'] == 3): ?>
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                               data-kt-image-input-action="change">
                            <i class="bi bi-pencil-fill fs-7"></i>
                            <input type="file" name="inside" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="avatar_remove" />
                        </label>
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                              data-kt-image-input-action="cancel">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                    <?php endif ?>
                </div>
                <?php if ($x && !empty($x['inside'])): ?>
                    <a data-fslightbox="lightbox-basic"
                       href="<?= base_url('assets/uploads/barang/'.$x['inside']) ?>">View</a>
                <?php endif ?>
                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
            </div>
        </div>
    </div>
</form>
