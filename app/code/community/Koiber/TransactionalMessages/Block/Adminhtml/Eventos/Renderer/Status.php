<?php
class Koiber_TransactionalMessages_Block_Adminhtml_Eventos_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
	public function render(Varien_Object $row) {
		$value =  $row->getData($this->getColumn()->getIndex());
			
		return $value ? __('Ativo') : __('Inativo');
	}
}
?>