<?php
class Koiber_TransactionalMessages_IndexController extends Mage_Core_Controller_Front_Action {        
    public function indexAction() {
		date_default_timezone_set(Mage::getStoreConfig('general/locale/timezone'));
			//file_put_contents('teste_cell.txt', http_build_query($this->getRequest()->getPost()));
		
		if (!$this->getRequest()->isPost() && !$this->getRequest()->getParam('debug')) {
			$this->getResponse()->setBody("Por enquanto, apenas para mostrar que eu existo, estou mostrando esta mensagem. Porém muito breve eu irei desaparecer e qualquer acesso que não seja via POST até mim será enviado para a loja de quem eu pertenço =).");
		} elseif ($this->getRequest()->getParam('debug') || $this->getRequest()->isPost())  {
			$postData = !$this->getRequest()->getParam('debug')  ? $this->getRequest()->getPost() : $this->getRequest()->getParams();

			if (isset($postData['event']) && (isset($postData['data']['id']) || isset($postData['data']['talk_id']))) {
				$talk_id = isset($postData['data']['talk_id']) ? $postData['data']['talk_id'] : $postData['data']['id'];
				
				$msg_id = '';
				$msg_data = array();
				
				if (isset($postData['data']['msg_id'])) {					
					if (is_array($postData['data']['msg_id'])) {
						foreach ($postData['data']['msg_id'] as $data_msg_id) {
							$msg_id = $data_msg_id;
							$msg_data = $this->obterMsgData($data_msg_id);
						}
					} else {
						$msg_id = $postData['data']['msg_id'];
						$msg_data = $this->obterMsgData($postData['data']['msg_id']);
					}
				} 
				
				$model = Mage::getSingleton('koiber_transactionalmessages/historico')->load($talk_id, 'koiber_parent_talk_id');
				
				$id = $model->getId();
				
				if ($id) {
					$model->addData(array(
						'koiber_last_message_id' => $msg_id ? $msg_id : $model->getKoiberLastMessageId(),
						'koiber_last_message_id_status' => $postData['event'],
						'data_modificado' => date('Y-m-d H:i:s'),
						'tipo' => $msg_data ? $msg_data['type'] : 'text',
					));
				
					$model->setId($id)->save();
					
					if ($msg_data && $msg_data['content']) {
						$modelMensagem = Mage::getSingleton('koiber_transactionalmessages/mensagem')->load($msg_id, 'tipo');
						
						if (!$modelMensagem->getId()) {
							$modelMensagem->setData(array(
								'historico_id' => $id,
								'mensagem' => serialize($msg_data),
								'tipo' => $msg_id,
								'data_inserido' => date('Y-m-d H:i:s')
							));
						
							$modelMensagem->save();
						}
					}
					
					if ($msg_data && ($msg_data['type'] == 'form_resp')) {	
						$data = array();
						
						foreach ($msg_data['content'] as $content) {
							switch ($content['element']) {
								case 'input':
									$data[$content['id']] = $content['response'];
								break;
							}
						}
						
						$order = Mage::getModel('sales/order')->load($model->getOrderId(), 'increment_id');
						
						foreach ($data as $campo => $valor) {							
							if (strpos(strtolower($campo), 'order_shipping') !== false) {
								$shippingAddress = Mage::getModel('sales/order_address')->load($order->getShippingAddress()->getId());
						
								if ($campo_filtrado = $this->obterCampoFiltrado($campo)) {
									$shippingAddress->addData(array($campo_filtrado => $valor))->save();
								}
							}
							
							if (strpos(strtolower($campo), 'order_billing') !== false) {
								$billingAddress = Mage::getModel('sales/order_address')->load($order->getBillingAddress()->getId());
						
								if ($campo_filtrado = $this->obterCampoFiltrado($campo)) {
									$billingAddress->addData(array($campo_filtrado => $valor))->save();
								}
							}
						}
					}
				}
			}
		}
    }
	
	public function obterTemplatePadraoAction() {
		if(!$this->getRequest()->getParam('template_code')) {
			return array();
		} else {
			$template_code = $this->getRequest()->getParam('template_code');
		}
		
		$koiberDefault = Mage::getModel('koiber_transactionalmessages/padrao')->load($template_code, 'evento');
		
		if ($koiberDefault->getId()) {
			$templateData['text'] = trim($koiberDefault->getMensagem(), "\n");
			$templateData['subject'] = trim($koiberDefault->getAssunto(), "\n");
		} else {
            return array();// Eu (natanael), incluir essa linha pois a variavel $storeId não existe e gera um erro
			//$localeCode = Mage::getStoreConfig('general/locale/code', $storeId);
			//$templateData['text'] = trim(Mage::getModel('core/email_template')->loadDefault($template_code, $localeCode)->getTemplateText(), "\n");
			//$templateData['subject'] = trim(Mage::getModel('core/email_template')->loadDefault($template_code, $localeCode)->getTemplateSubject(), "\n");
		}
		
		$this->getResponse()->setBody(Zend_Json::encode($templateData));
	}
	
	public function variaveisPluginAction() {
        $storeContactVariabls = Mage::getModel('core/source_email_variables')->toOptionArray(true);
                
		if ($this->getRequest()->getParam('template_code')) {
			$customVariables = Mage::getModel('core/email_template')->loadDefault($this->getRequest()->getParam('template_code'))->getVariablesOptionArray(true);			
		} else {
			$customVariables = array();
		}
		
		$variables = array($storeContactVariabls, $customVariables);
		
		$this->getResponse()->setBody(Zend_Json::encode($variables));
    }
	
	protected function obterCampoFiltrado($campo) {
		$filtro = array(
			'order_shipping_address_street1' => 'street',
			'order_shipping_address_country' => 'country_id',
			'order_shipping_address_city' => 'city',
			'order_shipping_address_region' => 'region',
			'order_shipping_address_postcode' => 'postcode',
			'order_billing_address_street1' => 'street',
			'order_billing_address_country' => 'country_id',
			'order_billing_address_city' => 'city',
			'order_billing_address_region' => 'region',
			'order_billing_address_postcode' => 'postcode'
		);
		
		return isset($filtro[strtolower($campo)]) ? $filtro[strtolower($campo)] : '';
	}
	
	protected function obterMsgData($msg_id) {
		require_once(Mage::getBaseDir('lib') . '/koiberPHP/src/Koiber/Autoload.php');

		$koiberConfig = Mage::getStoreConfig('koiber_options/koiber_configs');
		
		$koiberApi = new Koiber($koiberConfig['koiber_api']);
				
		$response = $koiberApi->getMsg($msg_id);			
		$response = $response->isOk() ? $response->getBody(true) : '';
				
		//if (($response['type']) && ($response['type'] == 'form_resp')) {
		if ($response) {
			$msg_data = $response;
		} else {
			$msg_data = array();
		}
		
		return $msg_data;
	}
}