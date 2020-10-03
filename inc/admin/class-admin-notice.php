<?php


namespace KitchenRun\Inc\Admin;

/**
 * Class AdminNotice
 *
 * Helper Class to create notices in the Kitchen Run Session
 * @TODO: Add Notices to all admin functionalities!
 *
 * @package KitchenRun\Inc\Admin
 */
class Admin_Notice {

	/**
	 * Creates a message in the Kitchen Run Session
	 *
	 * @param string $type 'error', 'success', 'warning', 'info'
	 * @param string $message
	 */
	public static function create($type, $message) {
		if (isset($_SESSION['kr_notice'][$type])) {
			array_push($_SESSION['kr_notice'][$type], $message);
		} else {
			$_SESSION['kr_notice'][$type][] = $message;
		}
	}

	/**
	 * Deletes messages in the Kitchen Run Session
	 *
	 * @param string $type 'error', 'success', 'warning', 'info'
	 * @param string $message
	 */
	public static function delete($type, $message) {
		if (isset($_SESSION['kr_notice'][$type])) {
			foreach ($_SESSION['kr_notice'][$type] as $key => $msg) {
				if ($msg === $message) unset($_SESSION['kr_notice'][$type][$key]);
			}
		}
	}

}