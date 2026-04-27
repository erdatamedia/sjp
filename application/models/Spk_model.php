<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Spk_model — operasional tabel pekerjaan (nama tabel SPK di sjp_local).
 *
 * Catatan DB (terverifikasi pre-flight Sprint 3):
 *   - Tabel: pekerjaan
 *   - Kolom kapasitas: tidak ada kolom jam; pakai count SPK per due_date
 *   - Limit kapasitas: operational_settings.max_same_day_quantity (default 10)
 *   - Timestamp selesai: completed_at (datetime, sudah ada)
 *   - Timestamp dikirim: shipped_at (datetime, sudah ada)
 */
class Spk_model extends CI_Model
{
    private $table = 'pekerjaan';

    // ── Kapasitas harian ───────────────────────────────────────────────────

    /**
     * Baca batas kapasitas harian dari operational_settings.
     * Jika tidak ada → default 10.
     */
    public function get_kapasitas_max()
    {
        $row = $this->db
            ->where('setting_key', 'max_same_day_quantity')
            ->get('operational_settings')
            ->row();
        return $row ? (int) $row->setting_value : 10;
    }

    /**
     * Hitung jumlah SPK yang sudah terjadwal (due_date = $tgl).
     * Exclude status yang sudah selesai/dikirim karena tidak pakai kapasitas lagi.
     */
    public function get_total_spk_by_date($tgl)
    {
        return (int) $this->db
            ->where('due_date', $tgl)
            ->where_not_in('status', ['approved-customer'])
            ->count_all_results($this->table);
    }

    /**
     * Ringkasan kapasitas untuk satu tanggal — dipakai AJAX endpoint.
     */
    public function get_kapasitas_info($tgl)
    {
        $max   = $this->get_kapasitas_max();
        $total = $this->get_total_spk_by_date($tgl);
        $sisa  = max(0, $max - $total);
        return [
            'total'  => $total,
            'max'    => $max,
            'sisa'   => $sisa,
            'penuh'  => $total >= $max,
            'persen' => min(100, (int) round(($total / $max) * 100)),
        ];
    }

    // ── Timestamp status ───────────────────────────────────────────────────

    /**
     * Set completed_at saat status berubah ke 'done'.
     * Kolom completed_at sudah ada di tabel pekerjaan.
     */
    public function set_completed_at($spk_id, $datetime = null)
    {
        $this->db->where('id', $spk_id)
                 ->update($this->table, [
                     'completed_at' => $datetime ?: date('Y-m-d H:i:s'),
                 ]);
    }

    /**
     * Set shipped_at saat status berubah ke 'approved-customer'.
     * Kolom shipped_at sudah ada di tabel pekerjaan.
     */
    public function set_shipped_at($spk_id, $datetime = null)
    {
        $this->db->where('id', $spk_id)
                 ->update($this->table, [
                     'shipped_at' => $datetime ?: date('Y-m-d H:i:s'),
                 ]);
    }

    /**
     * Ambil satu row pekerjaan dengan timestamp.
     */
    public function get_by_id($spk_id)
    {
        return $this->db->where('id', $spk_id)
                        ->get($this->table)
                        ->row_array();
    }

    // ── Setting helper ─────────────────────────────────────────────────────

    public function get_setting($key, $default = null)
    {
        $row = $this->db->where('setting_key', $key)
                        ->get('operational_settings')
                        ->row();
        return $row ? $row->setting_value : $default;
    }

    public function prevent_backdate()
    {
        return (int) $this->get_setting('prevent_backdate_production_date', 1) === 1;
    }
}
