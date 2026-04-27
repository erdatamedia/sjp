<div class="container-fluid" id="content_container">
    <div class="card mb-5">
        <div class="card-header align-items-center" id="card-header">
            <div class="btn-group btn-group-sm my-2 my-sm-0">
                <a href="<?= base_url($module) ?>" class="btn btn-light btn-sm me-3"><i class="bi bi-chevron-left"></i></a>

            </div>
            <?php if ($x) { ?>
                <div class="btn-group btn-group-sm my-2 my-sm-0">
                    <a href="<?= base_url($module.'/view/'.$prev) ?>" class="btn btn-light <?= $prev ? '' : 'disabled' ?>">Prev</a>
                    <span class="btn border pe-none text-gray-600"><?= $i.' / '.$j ?></span>
                    <a href="<?= base_url($module.'/view/'.$next) ?>" class="btn btn-light <?= $next ? '' : 'disabled' ?>">Next</a>
                </div>
            <?php } ?>
        </div>
        <div class="card-header ribbon ribbon-top ribbon-vertical">
            <div class="ribbon-label " ><?= $x['name'] ?></div>
            <div class="card-title ">
             <div class="input-group flex-nowrap" id="year_filter">
                <span class="input-group-text"><i class="bi bi-calendar fs-4"></i></span>
                <div class="overflow-hidden flex-grow-1">
                    <select class="form-select rounded-start-0" data-control="select2" data-placeholder="Select a year"  id="year">
                        <?php foreach (range(2024, $year) as $tahun): ?>
                            <option value="<?= $tahun ?>" <?= $year== $tahun? 'selected' : '' ?> ><?= $tahun ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

        </div>
    </div>
    <div class="card-body row" id="div-info">
      <div class="mb-5 hover-scroll-x">
        <div class="d-grid">
            <ul class="nav nav-tabs flex-nowrap text-nowrap">
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_1">Januari</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_2">Februari</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_3">Maret</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_4">April</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_5">Mei</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_6">Juni</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_7">Juli</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_8">Agustus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_9">September</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_10">Oktober</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_11">November</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_12">Desember</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
         <div class="table-responsive">
            <table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
            id="januari">
            <thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
            <tbody class="fw-bold text-gray-800"></tbody>
        </table>
    </div>
</div>
<div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
    <div class="table-responsive">
        <table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
        id="februari">
        <thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
        <tbody class="fw-bold text-gray-800"></tbody>
    </table>
</div>
</div>
<div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
    <div class="table-responsive">
        <table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
        id="maret">
        <thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
        <tbody class="fw-bold text-gray-800"></tbody>
    </table>
</div>
</div>
<div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
 <div class="table-responsive">
    <table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
    id="april">
    <thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
    <tbody class="fw-bold text-gray-800"></tbody>
</table>
</div>
</div>
<div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">
 <div class="table-responsive">
    <table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
    id="mei">
    <thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
    <tbody class="fw-bold text-gray-800"></tbody>
</table>
</div>
</div>
<div class="tab-pane fade" id="kt_tab_pane_6" role="tabpanel">
    <div class="table-responsive">
        <table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
        id="juni">
        <thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
        <tbody class="fw-bold text-gray-800"></tbody>
    </table>
</div>
</div>
<div class="tab-pane fade" id="kt_tab_pane_7" role="tabpanel">
 <div class="table-responsive">
    <table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
    id="juli">
    <thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
    <tbody class="fw-bold text-gray-800"></tbody>
</table>
</div>
</div>
<div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
 <div class="table-responsive">
    <table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
    id="agustus">
    <thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
    <tbody class="fw-bold text-gray-800"></tbody>
</table>
</div>
</div>
<div class="tab-pane fade" id="kt_tab_pane_9" role="tabpanel">
    <div class="table-responsive">
        <table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
        id="september">
        <thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
        <tbody class="fw-bold text-gray-800"></tbody>
    </table>
</div>
</div>
<div class="tab-pane fade" id="kt_tab_pane_10" role="tabpanel">
 <div class="table-responsive">
    <table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
    id="oktober">
    <thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
    <tbody class="fw-bold text-gray-800"></tbody>
</table>
</div>
</div>
<div class="tab-pane fade" id="kt_tab_pane_11" role="tabpanel">
 <div class="table-responsive">
    <table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
    id="november">
    <thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
    <tbody class="fw-bold text-gray-800"></tbody>
</table>
</div>
</div>
<div class="tab-pane fade" id="kt_tab_pane_12" role="tabpanel">
 <div class="table-responsive">
    <table class="table align-middle table-row-bordered border rounded g-4 dataTable no-footer dtr-inline"
    id="desember">
    <thead class="text-start text-gray-500 fw-bolder fs-7"></thead>
    <tbody class="fw-bold text-gray-800"></tbody>
</table>
</div>
</div>
</div>
</div>

<div class="card card-flush h-lg-100" id="card_sale">
    <div class="card-header pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder text-dark">Tender in Year</span>
            <span class="text-gray-400 pt-2 fw-bold fs-6"></span>
        </h3>
    </div>
    <div class="card-body pt-0 px-0">
        <div id="sale_chart" class="min-h-auto ps-4 pe-6 mb-3" style="height: 350px"></div>
    </div>
</div>

</div>