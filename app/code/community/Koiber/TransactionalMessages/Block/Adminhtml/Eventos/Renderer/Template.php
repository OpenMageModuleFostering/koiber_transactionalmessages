<?php
class Koiber_TransactionalMessages_Block_Adminhtml_Eventos_Renderer_Template extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
	public function render(Varien_Object $row) {
		$value =  $row->getData($this->getColumn()->getIndex());
		
		$defaultTemplates = Mage::getModel('core/email_template')->getDefaultTemplatesAsOptionsArray();
		
		foreach ($defaultTemplates as $defaultTemplate) {
			if ($defaultTemplate['value'] == $value) {
				$value = $defaultTemplate['label'];
				
				break;
			}
		}
		
		return $value;
	}
}
?>