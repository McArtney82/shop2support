<?php
/**
 * Plugin Name:     S2s_link_health
 * Description:     Plugin to check the validity of affiliate links
 * Author:          Steve Macfarlane
 * Text Domain:     s2s_link_health
 * Version:         1.0.0
 *
 * @package         S2s_link_health
 */

// Your code starts here.
namespace s2sLinkHealth;

if( ! defined( 'ABSPATH' ) ) {
	return;
}

class s2sLinkHealth
{
	public function __construct()
	{
		require 'lib/admin.php';
		require 'lib/s2sListTable.php';
		$admin = new admin();
	}
}

$s2sLinkHealth = new s2sLinkHealth();

