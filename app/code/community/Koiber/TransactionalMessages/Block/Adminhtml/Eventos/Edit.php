<?php
class Koiber_TransactionalMessages_Block_Adminhtml_Eventos_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
	public function __construct() {
		$this->_objectId = 'evento_id';
		$this->_blockGroup = 'koiber_transactionalmessages';
		$this->_controller = 'adminhtml_eventos';
		
		parent::__construct();
		
		$this->_updateButton('save', 'label', $this->__('Salvar Mensagem'));
		$this->_updateButton('delete', 'label', $this->__('Excluir Mensagem'));		
	}
	
	public function getHeaderText() {
		if(Mage::registry('koiber_transactionalmessages')->getId()) {
			return $this->__('Editar Mensagem');
		} else {
			return $this->__('Nova Mensagem');
		}
	}
	
	protected function _prepareLayout() {
		parent::_prepareLayout();
		
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
		}
	}
}