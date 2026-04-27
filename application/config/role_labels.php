<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Mapping role.name (dari DB) → label tampilan
 * Nama role di DB sudah dalam Bahasa Indonesia (per data aktual sjp_local).
 * Fallback di get_role_label(): jika key tidak ditemukan, nilai asli dikembalikan.
 *
 * id | name (DB aktual)
 *  1 | Kepala Bagian Produksi
 *  2 | Marketing
 *  3 | Design
 *  4 | Printing / Sablon
 *  5 | Cutting
 *  6 | Finishing
 *  7 | Logistik
 *  8 | Superadmin
 *  9 | Printing / Sablon
 * 10 | Kepala Bagian Gudang
 * 11 | Designer
 */
$config['role_labels'] = [

    // ── Nama role persis dari kolom role.name (lowercase) ──────────────────
    'kepala bagian produksi' => 'Kepala Bagian Produksi',
    'marketing'              => 'Marketing',
    'design'                 => 'Design',
    'printing / sablon'      => 'Printing / Sablon',
    'cutting'                => 'Cutting',
    'finishing'              => 'Finishing',
    'logistik'               => 'Logistik',
    'superadmin'             => 'Superadmin',
    'kepala bagian gudang'   => 'Kepala Bagian Gudang',
    'designer'               => 'Designer',

    // ── Slug / kode internal yang mungkin dipakai di kode lama ─────────────
    'spv'                    => 'Kepala Bagian Produksi',
    'kabag_prod'             => 'Kepala Bagian Produksi',
    'kabag_gudang'           => 'Kepala Bagian Gudang',
    'qc'                     => 'Kepala Bagian Gudang',
    'packing'                => 'Finishing',
    'printing'               => 'Printing / Sablon',
    'admin'                  => 'Superadmin',

    // ── Nama lama (sebelum rename di DB) — fallback agar tidak tampil kosong ─
    'kabag produksi'         => 'Kepala Bagian Produksi',
    'sales & marketing'      => 'Marketing',
    'leader design'          => 'Design',
    'dgp karton'             => 'Printing / Sablon',
    'leader cutting'         => 'Cutting',
    'leader packing'         => 'Finishing',
    'leader shipping'        => 'Logistik',
    'digital printing'       => 'Printing / Sablon',
];
