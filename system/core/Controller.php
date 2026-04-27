<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2019 - 2022, CodeIgniter Foundation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @copyright	Copyright (c) 2019 - 2022, CodeIgniter Foundation (https://codeigniter.com/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/userguide3/general/controllers.html
 */
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * CI_Loader
	 *
	 * @var	CI_Loader
	 */
	public $load;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		// CI3 + HMVC + PHP 8 compatibility:
		// When a non-MX controller (e.g. REST API, extends CI_Controller directly)
		// is instantiated after the HMVC base "CI" object, the framework has already
		// loaded all autoloaded libraries (db, session, etc.) onto the prior instance.
		// We must:
		//   1. Copy all existing properties from the prior instance instead of
		//      calling load_class() which would fail for subdirectory libraries (Session)
		//      or create a second active session.
		//   2. Skip load->initialize() re-run to prevent double-autoloading.
		$_prior_instance = self::$instance;

		self::$instance =& $this;

		if ($_prior_instance !== NULL)
		{
			// Second (or later) controller instantiation: copy super-object properties
			// from prior instance so we inherit db, session, load, etc. without
			// re-running the full autoloader.
			foreach (get_object_vars($_prior_instance) as $_prop => $_val)
			{
				if (!isset($this->$_prop))
				{
					$this->$_prop = $_val;
				}
			}

			// Re-point load_class-cached core classes to this instance
			foreach (is_loaded() as $_var => $_class)
			{
				if (!isset($this->$_var))
				{
					$this->$_var =& load_class($_class);
				}
			}

			// Assign a fresh Loader scoped to this controller, but share library state
			$this->load =& load_class('Loader', 'core');
		}
		else
		{
			// First instantiation (the HMVC base CI object): standard CI3 bootstrap
			foreach (is_loaded() as $var => $class)
			{
				$this->$var =& load_class($class);
			}

			$this->load =& load_class('Loader', 'core');
			$this->load->initialize();
		}

		log_message('info', 'Controller Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}

}
