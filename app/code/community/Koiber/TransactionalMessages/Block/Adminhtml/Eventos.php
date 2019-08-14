<?php
class Koiber_TransactionalMessages_Block_Adminhtml_Eventos extends Mage_Adminhtml_Block_Widget_Grid_Container {
	public function __construct() {
		$this->_blockGroup = 'koiber_transactionalmessages';
		$this->_controller = 'adminhtml_eventos';
		$this->_headerText = $this->__('Mensagens');
		
		parent::__construct();
	}
}