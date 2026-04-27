<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('app', 'indonesian');
        $this->config->load('role_labels', TRUE);
        $this->set_device_context();
    }

    /**
     * Deteksi role mobile vs desktop dan inject variabel ke semua view.
     * Baca id_role dari session (disimpan saat login di Auth.php).
     *
     * Mobile roles (id_role): 4=Printing/Sablon, 5=Cutting, 6=Finishing,
     *                          9=Printing/Sablon(digital), 10=Kepala Bagian Gudang
     * Desktop roles: 1=Kabag Produksi, 2=Marketing, 3=Design, 7=Logistik, 8=Superadmin
     */
    protected function set_device_context()
    {
        $session = $this->session->userdata(COOKIE_USER);
        $id_role = isset($session['id_role']) ? (int) $session['id_role'] : 0;

        $mobile_roles = [];
        $is_mobile    = in_array($id_role, $mobile_roles);

        $this->load->vars([
            'is_mobile'    => $is_mobile,
            'layout_class' => $is_mobile ? 'layout-mobile' : 'layout-desktop',
            'session_role' => $id_role,
        ]);
    }

    /**
     * Helper: ambil id_role dari session tanpa query DB.
     */
    protected function get_session_role()
    {
        $session = $this->session->userdata(COOKIE_USER);
        return isset($session['id_role']) ? (int) $session['id_role'] : 0;
    }
}
