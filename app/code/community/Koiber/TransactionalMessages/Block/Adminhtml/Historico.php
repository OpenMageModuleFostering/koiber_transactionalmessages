<?php
class Koiber_TransactionalMessages_Block_Adminhtml_Historico extends Mage_Adminhtml_Block_Widget_Grid_Container {
	public function __construct() {
		$this->_blockGroup = 'koiber_transactionalmessages';
		$this->_controller = 'adminhtml_historico';
		$this->_headerText = __('Histórico de Mensagens');
		$this->_removeButton('add');
		
		parent::__construct();
	}
}