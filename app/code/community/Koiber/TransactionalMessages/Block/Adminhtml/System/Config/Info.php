<?php
class Koiber_TransactionalMessages_Block_Adminhtml_System_Config_Info extends Mage_Adminhtml_Block_Abstract {
	public function render(Varien_Data_Form_Element_Abstract $element) {
		$apiUrl = Mage::getBaseUrl() . 'koiber';
		
		$html = '<big><b>' . __('INSTRUÇÕES') . '</b></big><br><br>' . __('O koiber é um aplicativo de envio de mensagens instantânea. Envie mensagens em tempo real para seu cliente com integração total com o magento.') . '<br>' . __('Para gerar o TOKEN você terá que ter cadastro no site www.koiber.com (cadastro gratuito) e acessar o Painel -> Integração -> API') . '<br><br>' . __('Para habilitar as notificações para fins de comunicação do Koiber com o Magento, cadastre a seguinte url no Koiber') . '<br> <a href="' . $apiUrl . '">' . $apiUrl . '</a><br><br>' . __('Para saber mais acesse o site www.koiber.com') . '<br><br>';
		
		return $html;
	}
}
?>