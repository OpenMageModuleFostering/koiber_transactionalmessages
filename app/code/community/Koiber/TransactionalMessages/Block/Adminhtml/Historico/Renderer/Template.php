<?php
class Koiber_TransactionalMessages_Block_Adminhtml_Historico_Renderer_Template extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
	public function render(Varien_Object $row) {
		$value =  $row->getData($this->getColumn()->getIndex());
			
		switch ($this->getColumn()->getId()) {
			case 'status':
				$texto = array(
					'talk.created' => __('Conversa Criada'),
					'talk.msg.created' => __('Mensagem Adicionada'),
					'talk.close' => __('Conversa Encerrada'),
					'talk.rating' => __('Conversa Avaliada'),
				);
				
				$value = isset($texto[$value]) ? $texto[$value] : $value;
			break;
			case 'canal':
				require_once(Mage::getBaseDir('lib') . '/koiberPHP/src/Koiber/Autoload.php');
		
				$koiberConfig = Mage::getStoreConfig('koiber_options/koiber_configs');
		
				$koiberApi = new Koiber($koiberConfig['koiber_api']);
				$response = $koiberApi->getCannels();
		
				$canaisKoiber = $response->getBody(true);
		
				foreach ($canaisKoiber as $canalKoiber) {			
					if ($canalKoiber['id'] == $value) {
						$value = $canalKoiber['name'];
						
						break;
					}
				}
			break;
			case 'cliente':				
				$customer = Mage::getModel('customer/customer')->setWebsiteId(1)->loadByEmail($value)->getData();
				
				$value = $customer ? $customer['firstname'] . ' ' . $customer['lastname'] : $value;
			break;
			case 'data':
				$value = date('d/m/Y H:i:s', strtotime($value));
			break;
			case 'titulo':
				require_once(Mage::getBaseDir('lib') . '/koiberPHP/src/Koiber/Autoload.php');
		
				$koiberConfig = Mage::getStoreConfig('koiber_options/koiber_configs');
		
				$koiberApi = new Koiber($koiberConfig['koiber_api']);
				$response = $koiberApi->getTalk($value);		
				$response = $response->getBody(true);
				
				$historico = Mage::getModel('koiber_transactionalmessages/historico')->load($response['id'], 'koiber_parent_talk_id');
				$mensagem = Mage::getModel('koiber_transactionalmessages/mensagem')->getCollection()->addFieldToFilter('historico_id', array('eq' => $historico->getId()))->count();
				
				$value = $response['title'] . ' (' . ($mensagem) . ')';
			break;
		}
		
		return $value;
	}
}
?>