<?php
class Koiber_TransactionalMessages_Block_Adminhtml_Mensagem_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
	public function __construct() {
		$this->_objectId = 'historico_id';
		$this->_blockGroup = 'koiber_transactionalmessages';
		$this->_controller = 'adminhtml_mensagem';
		
		parent::__construct();
		
		$this->_removeButton('save');
		$this->_removeButton('delete');
		$this->_removeButton('reset');
	}
	
	public function getHeaderText() {
		return $this->__('Visualizar a Mensagem');
	}
	
	protected function _prepareLayout() {
		parent::_prepareLayout();
	}
	
	public function getBackUrl() {
        parent::getBackUrl();
		
        return $this->getUrl('*/*/historico');
    }
}