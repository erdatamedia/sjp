<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__ . '/../../vendor/autoload.php';

use Pusher\Pusher;

class Pusher_library {
    protected $pusher;

    public function __construct() {
        $CI =& get_instance(); // CodeIgniter instance

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $this->pusher = new Pusher(
            '4d33ba8d1be6bb870f00', // Key
            '05823adb493740a8f1c1', // Secret
            '1842446', // App ID
            $options
        );
    }

    public function trigger($channel, $event, $data) {
        return $this->pusher->trigger($channel, $event, $data);
    }
}
