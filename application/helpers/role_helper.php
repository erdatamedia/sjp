<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_role_label')) {
    function get_role_label($role) {
        $CI =& get_instance();
        $CI->config->load('role_labels', TRUE);
        $labels = $CI->config->item('role_labels', 'role_labels');

        $key = strtolower(trim((string) $role));
        return isset($labels[$key]) ? $labels[$key] : $role;
    }
}

if (!function_exists('can_see_filter')) {
    /*
     * Roles yang TIDAK melihat filter status (disembunyikan):
     *   1 = Kepala Bagian Produksi
     *   2 = Marketing
     *   8 = Superadmin
     *
     * Roles yang MELIHAT filter (worker roles):
     *   3  = Design
     *   4  = Printing / Sablon
     *   5  = Cutting
     *   6  = Finishing
     *   7  = Logistik
     *   9  = Printing / Sablon (digital)
     *   10 = Kepala Bagian Gudang
     *   11 = Designer
     */
    function can_see_filter($id_role) {
        $hidden = [2, 8];
        return !in_array((int) $id_role, $hidden);
    }
}

if (!function_exists('is_simplified_filter_role')) {
    /*
     * Worker roles yang mendapat filter 2-opsi (Mau Dikerjakan / Sudah Selesai di Cutting)
     * alih-alih tombol filter lengkap.
     */
    function is_simplified_filter_role($id_role) {
        $simplified = [1, 3, 4, 5, 6, 7, 9, 10, 11];
        return in_array((int) $id_role, $simplified);
    }
}

if (!function_exists('get_role_filter_tabs')) {
    function get_role_filter_tabs($id_role) {
        $map = [
            5  => [ // Cutting
                ['status'=>'',       'label'=>'Semua Proses',           'class'=>'filter-tab-all'],
                ['status'=>'cutting','label'=>'Mau Dikerjakan',          'class'=>'filter-tab-cutting'],
                ['status'=>'packing','label'=>'Sudah Selesai di Cutting','class'=>'filter-tab-packing'],
            ],
            6  => [ // Finishing
                ['status'=>'',      'label'=>'Semua Proses',            'class'=>'filter-tab-all'],
                ['status'=>'packing','label'=>'Mau Dikerjakan',         'class'=>'filter-tab-packing'],
                ['status'=>'done',  'label'=>'Sudah Selesai',           'class'=>'filter-tab-done'],
            ],
            4  => [ // Printing/Sablon
                ['status'=>'',        'label'=>'Semua Proses',          'class'=>'filter-tab-all'],
                ['status'=>'printing','label'=>'Mau Dikerjakan',        'class'=>'filter-tab-printing'],
                ['status'=>'packing', 'label'=>'Sudah Selesai',         'class'=>'filter-tab-packing'],
            ],
            9  => [ // Printing digital
                ['status'=>'',        'label'=>'Semua Proses',          'class'=>'filter-tab-all'],
                ['status'=>'printing','label'=>'Mau Dikerjakan',        'class'=>'filter-tab-printing'],
                ['status'=>'packing', 'label'=>'Sudah Selesai',         'class'=>'filter-tab-packing'],
            ],
            3  => [ // Design
                ['status'=>'',       'label'=>'Semua Proses',  'class'=>'filter-tab-all'],
                ['status'=>'desain', 'label'=>'Mau Dikerjakan','class'=>'filter-tab-desain'],
                ['status'=>'cutting','label'=>'Sudah Selesai', 'class'=>'filter-tab-cutting'],
            ],
            11 => [ // Designer
                ['status'=>'',       'label'=>'Semua Proses',  'class'=>'filter-tab-all'],
                ['status'=>'desain', 'label'=>'Mau Dikerjakan','class'=>'filter-tab-desain'],
                ['status'=>'cutting','label'=>'Sudah Selesai', 'class'=>'filter-tab-cutting'],
            ],
            1  => [ // Kabag Produksi
                ['status'=>'',        'label'=>'Semua Proses',          'class'=>'filter-tab-all'],
                ['status'=>'waiting', 'label'=>'Menunggu Material/Alat','class'=>'filter-tab-waiting'],
                ['status'=>'cutting', 'label'=>'Cutting',               'class'=>'filter-tab-cutting'],
                ['status'=>'printing','label'=>'Printing',              'class'=>'filter-tab-printing'],
                ['status'=>'packing', 'label'=>'Finishing',             'class'=>'filter-tab-packing'],
                ['status'=>'done',    'label'=>'Selesai',               'class'=>'filter-tab-done'],
            ],
            7  => [ // Logistik
                ['status'=>'',                 'label'=>'Semua Proses',       'class'=>'filter-tab-all'],
                ['status'=>'approved',         'label'=>'Disetujui QC',       'class'=>'filter-tab-approved'],
                ['status'=>'approved-shipping','label'=>'Disetujui Logistik', 'class'=>'filter-tab-shipping'],
                ['status'=>'approved-customer','label'=>'Dikirim',            'class'=>'filter-tab-customer'],
            ],
            10 => [ // Kabag Gudang
                ['status'=>'',                  'label'=>'Semua Proses',       'class'=>'filter-tab-all'],
                ['status'=>'done',              'label'=>'Selesai',            'class'=>'filter-tab-done'],
                ['status'=>'approved',          'label'=>'Disetujui QC',      'class'=>'filter-tab-approved'],
                ['status'=>'approved-shipping', 'label'=>'Disetujui Logistik','class'=>'filter-tab-shipping'],
                ['status'=>'approved-customer', 'label'=>'Dikirim',           'class'=>'filter-tab-customer'],
            ],
        ];
        return isset($map[(int)$id_role]) ? $map[(int)$id_role] : null;
    }
}

if (!function_exists('get_role_name_by_id')) {
    /*
     * Lookup cepat: id_role → label tampilan, tanpa query ke DB.
     * Sesuai data aktual tabel role di sjp_local.
     */
    function get_role_name_by_id($id_role) {
        $map = [
            1  => 'Kepala Bagian Produksi',
            2  => 'Marketing',
            3  => 'Design',
            4  => 'Printing / Sablon',
            5  => 'Cutting',
            6  => 'Finishing',
            7  => 'Logistik',
            8  => 'Superadmin',
            9  => 'Printing / Sablon',
            10 => 'Kepala Bagian Gudang',
            11 => 'Designer',
        ];
        return isset($map[(int) $id_role]) ? $map[(int) $id_role] : 'Unknown';
    }
}
