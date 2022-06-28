<?php

namespace s2sLinkHealth;

if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


/**
 * Class s2SListTable
 */
use App\Utils\affiliateLinks;

/**
 *
 */
class s2sListTable extends \WP_List_Table
{
	/**
	 * @var array
	 */
	public $tableData;
	/**
	 * @var array
	 */
	public $statusArr;

	/**
	 * @var affiliateLinks
	 */
	private $affiliateLinks;

	/**
	 * @param array $tableData
	 */
	public function __construct()
	{
		$this->setStatusArr([
			'200'=>'success',
			'400'=>'failed',
			'403'=>'failed',
			'404'=>'failed',
			'503'=>'failed'
		]);
		$this->affiliateLinks = new affiliateLinks();
		parent::__construct( [
			'singular' => 'Link', //singular name of the listed records
			'plural'   => 'Links', //plural name of the listed records
			'ajax'     => false //does this table support ajax?
		] );
	}

	/**
	 * @param array $tableData
	 */
	public function setTableData(array $tableData): void
	{
		$this->tableData = $tableData;
	}

	/**
	 * @return string
	 */
	public function getStatus(string $statusCode): string
	{
		if(!array_key_exists($statusCode,$this->statusArr))
			return 'check';
		return $this->statusArr[$statusCode];
	}

	/**
	 * @return array
	 */
	public function getStatusArr(): array
	{
		return $this->statusArr;
	}



	/**
	 * @param array $statusArr
	 */
	public function setStatusArr($statusArr): void
	{
		$this->statusArr = $statusArr;
	}


	/**
	 * @param $which
	 * @return void
	 */
	protected function extra_tablenav($which ): void
	{
		switch ( $which )
		{
			case 'top':
				$link_status = isset( $_GET['link_status'] ) ? $_GET['link_status'] : 0;
				$link = '/wp-admin/admin.php?page='.$_REQUEST['page'];
				?>
				<div class="alignleft actions">
					<select name="link_status" id="link_status">
						<option value="all" <?php selected($link_status,0) ?> data-rc="<?php echo $link ?>">All</option>
						<option value="failed" <?php selected($link_status,'failed') ?> data-rc="<?php echo $link ?>&link_status=failed">Failed</option>
						<option value="check" <?php selected($link_status,'check') ?> data-rc="<?php echo $link ?>&link_status=check">Check</option>
						<option value="unknown" <?php selected($link_status,'unknown') ?> data-rc="<?php echo $link ?>&link_status=unknown">Status Unknown</option>
					</select>
				<a href="javascript:void(0)" class="button" onclick="window.location.href = jQuery('#link_status option:selected').data('rc');">Filter</a>
				</div>
				<?php
				break;
		}
	}

	/**
	 * @return array
	 */
	public function get_columns():array{
		$columns = array(
			'cb'            => '<input type="checkbox" />',
			'ID' => 'ID',
			'retailer' => 'Retailer',
			'link'    => 'Link',
			'network'      => 'Network',
			'status'	=> 'Status',
		);
		return $columns;
	}


	/**
	 * @return array[]
	 */
	protected function get_sortable_columns(): array
	{
		$sortable_columns = array(
			'ID' => array('ID',false),
			'retailer'  => array('retailer', false),
			'network' => array('network', false),
			'status'   => array('status', true)
		);
		return $sortable_columns;
	}


	/**
	 * @return array[]
	 */
	protected function get_hidden_columns(): array
	{
		$hidden_columns = array(
			'ID'  => array('ID', false),
		);
		return $hidden_columns;
	}

	/**
	 * @param $item
	 * @param $column_name
	 * @param $primary
	 * @return string
	 */
	protected function handle_row_actions($item, $column_name, $primary ) {
		return '';
	}


	/**
	 * @param $item
	 * @return string|void
	 */
	protected function column_cb($item): string
	{
		return sprintf(
			'<input type="checkbox" name="link[]" value="%s" />', $item['ID']
		);
	}


	/**
	 * @param $a
	 * @param $b
	 * @return float|int
	 */
	protected function usort_reorder($a, $b ) {
		// If no sort, default to title
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'ID';
		// If no order, default to asc
		$order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
		// Determine sort order
		$result = strcmp( $a[$orderby], $b[$orderby] );
		// Send final sort direction to usort
		return ( $order === 'asc' ) ? $result : -$result;
	}


	/**
	 * @return array[]
	 */
	protected function get_bulk_actions(): array {
		return array(
			'delete' => 'Delete',
			'unpublish' => 'Unpublish'
		);
	}


	/**
	 * @return void
	 */
	public function process_bulk_action(): void {

		// security check!
		if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

			$nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
			$action = 'bulk-' . $this->_args['plural'];

			if ( ! wp_verify_nonce( $nonce, $action ) )
				wp_die( 'Nope! Security check failed!' );

		}

		$action = $this->current_action();

		switch ( $action ) {

			case 'delete':
				$links = $_REQUEST['link'];
				$count = 0;
				foreach($links as $linkID){
					wp_delete_post($linkID);
					$count++;
				}
				wp_redirect($_REQUEST['_wp_http_referer'].'&del=1&count='.$count);
				break;

			case 'unpublish':
				$links = $_REQUEST['link'];
				$count = 0;
				foreach($links as $linkID){
					wp_update_post(
						['ID'=>$linkID,
							'post_status'=>'draft'
						]
					);
					$count++;
				}
				wp_redirect($_REQUEST['_wp_http_referer'].'&draft=1&count='.$count);
				break;
				break;
			default:
				// do nothing or something else
				return;
				break;
		}

		return;
	}

	/**
	 * @param array $links
	 * @return array
	 */
	public function getCSV(array $links): array
	{
		$csv = [];
		foreach($links as $linkID){
			$lineArr = [$linkID, get_the_title($linkID), get_field('code_', $linkID) . $this->affiliateLinks->get_link_suffix(get_field('affiliate_manager',$linkID),'s2s')];
		}
		return $csv;
	}


	/**
	 * @return void
	 */
	public function prepare_items(): void
	{
		$hidden = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($this->get_columns(), $hidden, $sortable);
		usort( $this->tableData, array( &$this, 'usort_reorder' ) );
		$this->items = $this->tableData;
		/* pagination */
		$per_page = 10;
		$current_page = $this->get_pagenum();
		$total_items = count($this->tableData);

		$this->tableData = array_slice($this->tableData, (($current_page - 1) * $per_page), $per_page);

		$this->set_pagination_args(array(
			'total_items' => $total_items, // total number of items
			'per_page'    => $per_page // items to show on a page
		));

		//usort($this->users_data, array(&$this, 'usort_reorder'));

		$this->items = $this->tableData;
		$this->process_bulk_action();
	}


	/**
	 * @param $item
	 * @param $column_name
	 */
	function column_default($item, $column_name)
	{
		switch ($column_name) {
			case 'ID':
				return '<a href="'.get_edit_post_link($item[$column_name]).'" target="_blank">'.$item[$column_name].'</a>';
			case 'retailer':
			case 'link':
			case 'network':
				return $item[$column_name];
			case 'status':
				$status = $this->getStatus($item[$column_name]);
				if($item[$column_name] == 'waiting'){
					return '<span class="status-span spinner is-active" style="float:left" data-status="loading"></span>';
				} elseif ($status == 'success') {
					return '<span class="status-span" style="color:green" data-status="200">Passed</span>';
				} elseif($status == 'failed'){
					return '<span class="status-span" style="color:orangered" data-status="'.$item[$column_name].'">Failed '.$item[$column_name].'</span>';
				} else {
					return '<span class="status-span" style="color:orange" data-status="'.$item[$column_name].'">Check</span>';
				}

			default:
				return print_r($item, true); //Show the whole array for troubleshooting purposes
		}
	}
}
