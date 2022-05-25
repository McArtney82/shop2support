<?php

namespace s2sLinkHealth;

require ABSPATH.'vendor/autoload.php';

use WP_Query;
use App\Utils\affiliateLinks;
/**
 *
 */
class admin
{

	private s2sListTable $LinkListTable;
	private affiliateLinks $affiliateLinks;

	/**
	 * @constructor
	 */
	public function __construct()
	{
		add_action('admin_menu',[$this,'registerAdminPage'],999);
		$this->affiliateLinks = new affiliateLinks();
		add_action("wp_ajax_get_s2slink_status", [$this,'getLinkStatus']);
		add_action("wp_ajax_nopriv_get_s2slink_status", [$this,'getLinkStatus']);
		add_action('wp',[$this,'registerCron']);
		add_action('checkS2SLinks',[$this,'cronCheckS2SLinks']);
	}

	public function registerCron():void
	{
		if (! wp_next_scheduled ( 'checkS2SLinks' )) {
			wp_schedule_event(time(), 'hourly', 'checkS2SLinks');
		}
	}

	public function cronCheckS2SLinks($debug = false):void
	{
		// WP_Query arguments
		$args = array(
			'post_type'              => 'offer',
			'post_status'            => 'publish',
			'posts_per_page' => 10,
			'meta_query' => [
				'relation' => 'OR',
				[
					'key' => 'link_status',
					'compare' => '=',
					'value' =>	''
				],
				[
					'key' => 'link_status',
					'compare' => 'NOT EXISTS'
				]
			]
		);

		// The Query
		$links = new WP_Query( $args );
		// The Loop
		if ($links->have_posts()) {
			$i = 0;
			while ($links->have_posts()) {
				$i++;
				$links->the_post();
				error_log($i);
				$status = $this->getLinkStatus(get_the_ID(), get_field('code_') . $this->affiliateLinks->get_link_suffix(get_field('affiliate_manager'),'s2s'));
				if($debug){
					echo '<p>'.$i.':'.get_the_title().' status: '.$status.'</p>';
				}
			}
		}
		// Restore original Post Data
		wp_reset_postdata();
	}

	public function registerAdminPage():void
	{
		add_menu_page('Shop2Support Link Affliate Health Check','Shop2Support Link Check','edit_posts','s2s_links',[$this,'showAdminPage'],'dashicons-analytics',2);
	}

	public function showAdminPage():void
	{
		//add javascript
		wp_register_script( 's2sLink_plugin_script', plugins_url('../js/main.js', __FILE__), array('jquery'));
		wp_localize_script( 's2sLink_plugin_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
		wp_enqueue_script( 's2sLink_plugin_script' );
		$row_data = [];
		// WP_Query arguments
		$args = array(
			'post_type'              => 'offer',
			'post_status'            => 'publish',
			'nopaging'				 => 'true',
			'posts_per_page'		=> '-1',
			'meta_query' => [
				'relation' => 'AND',
				[
					'key' => 'link_status',
					'compare' => '!=',
					'value' =>	''
				],
				[
					'key' => 'link_status',
					'compare' => 'EXISTS'
				]
			]
		);

		// The Query
		$links = new WP_Query( $args );

		// The Loop
		if ($links->have_posts()) {
			while ($links->have_posts()) {
				$links->the_post();
				$url = get_field('code_') . $this->affiliateLinks->get_link_suffix(get_field('affiliate_manager'),'s2s');
				$row_data[] = [
					'ID' => get_the_ID(),
					'retailer' => get_the_title(),
					'link' => $url,
					'network' => get_field('affiliate_manager'),
					'status' => get_field('link_status')
				];
			}
		}
		// Restore original Post Data
		wp_reset_postdata();
		$today = date('Y-m-d',strtotime("-2 days"));
		// WP_Query arguments
		$args = array(
			'post_type'              => 'offer',
			'post_status'            => 'publish',
			'nopaging'				 => 'true',
			'posts_per_page'		=> '-1',
			'meta_query' => [
				'relation' => 'OR',
				[
					'key' => 'link_status',
					'compare' => 'NOT EXISTS'
				],
				[
					'key' => 'link_status',
					'compare' => '=',
					'value' => ''
				]
			]
		);

		// The Query
		$links = new WP_Query( $args );

		// The Loop
		if ($links->have_posts()) {
			while ($links->have_posts()) {
				$links->the_post();
				update_field('link_status','');
				$url = get_field('code_') . $this->affiliateLinks->get_link_suffix(get_field('affiliate_manager'),'s2s');
				$row_data[] = [
					'ID' => get_the_ID(),
					'retailer' => get_the_title(),
					'link' => $url,
					'network' => get_field('affiliate_manager'),
					'status' => 'waiting'
				];
			}
		}
		// Restore original Post Data
		wp_reset_postdata();

		$this->LinkListTable = new s2sListTable($row_data);
		//error_log(print_r($this->LinkListTable->tableData,true));
		?>
		<div class="wrap">
			<h1>Shop2Support Affliate Link Check</h1>
			<?php if($_REQUEST['del']){
				echo '<div class="updated"><p>'.$_REQUEST['count'].' link(s) deleted</p></div>';
			}?>
			<form method="post">
				<input type="hidden" name="page" value="s2s_links" />
		<?php
		$this->LinkListTable->prepare_items();
		$this->LinkListTable->display();
		?>
			</form>
		</div>
		<?php
	}
	function getLinkStatus($id = '', $url = ''){
		$return = true;
		if(!$id || !$url){ //TODO tidy up to handle one or the other
			$url = $_REQUEST['link'];
			$id = $_REQUEST['id'];
			$return = false;
		}
		$handle = curl_init($url);
		curl_setopt($handle,CURLOPT_HEADER,0);
		curl_setopt($handle,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($handle, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($handle);
		$currentCode = get_field('link_status',$id);
		$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		error_log($currentCode);
		error_log($httpCode);
		if(!$currentCode || $currentCode != $httpCode)
			update_field('link_last_checked',date('d/m/Y H:i:s'),$id);
		update_field('link_status',$httpCode,$id);
		if(!$return){
			echo json_encode($httpCode);
			die();
		}
		return $httpCode;
	}
}
