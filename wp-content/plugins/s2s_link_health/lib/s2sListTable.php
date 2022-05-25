<?php

namespace s2sLinkHealth;

if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


/**
 * Class s2SListTable
 */
class s2sListTable extends \WP_List_Table
{
	/**
	 * @var array
	 */
	public $tableData;

	/**
	 * @param array $tableData
	 */
	public function __construct(array $tableData)
	{
		$this->tableData = $tableData;
		parent::__construct( [
			'singular' => 'Link', //singular name of the listed records
			'plural'   => 'Links', //plural name of the listed records
			'ajax'     => false //does this table support ajax?
		] );
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

	protected function get_hidden_columns(): array
	{
		$hidden_columns = array(
			'ID'  => array('ID', false),
		);
		return $hidden_columns;
	}

	protected function handle_row_actions( $item, $column_name, $primary ) {
		return '';
	}

	protected function column_cb($item) {
		return sprintf(
			'<input type="checkbox" name="link[]" value="%s" />', $item['ID']
		);
	}

	protected function usort_reorder( $a, $b ) {
		// If no sort, default to title
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'ID';
		// If no order, default to asc
		$order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
		// Determine sort order
		$result = strcmp( $a[$orderby], $b[$orderby] );
		// Send final sort direction to usort
		return ( $order === 'asc' ) ? $result : -$result;
	}

	protected function get_bulk_actions() {
		return array(
			'delete' => 'Delete'
		);
	}

	public function process_bulk_action() {

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
				foreach($links as $link){
					wp_delete_post($link);
					$count++;
				}
				wp_redirect($_REQUEST['_wp_http_referer'].'&del=1&count='.$count);
				break;

			default:
				// do nothing or something else
				return;
				break;
		}

		return;
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
				if($item[$column_name] == 'waiting'){
					return '<span class="status-span spinner is-active" style="float:left" data-status="loading"></span>';
				} elseif ($item[$column_name] == '200') {
					return '<span class="status-span" style="color:green" data-status="200">Passed</span>';
				} elseif($item[$column_name] == '404' || $item[$column_name] == '400' || $item[$column_name] == '503' || $item[$column_name] == '403'){
					return '<span class="status-span" style="color:orangered" data-status="'.$item[$column_name].'">Failed '.$item[$column_name].'</span>';
				} else {
					return '<span class="status-span" style="color:orange" data-status="'.$item[$column_name].'">Check</span>';
				}

			default:
				return print_r($item, true); //Show the whole array for troubleshooting purposes
		}
	}
}
