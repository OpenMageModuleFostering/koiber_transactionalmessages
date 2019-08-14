<?php
class Koiber_TransactionalMessages_KoiberController extends Mage_Adminhtml_Controller_Action {
	private $pageData = array(
		'action' => 'koiber/index',
		'title' => 'Mensagens'
	);
	
	private function verificaStatusKoiber($index = false) {
		$koiberConfig = Mage::getStoreConfig('koiber_options/koiber_configs');
		
		if (!$koiberConfig['koiber_api'] || !$koiberConfig['koiber_status']) {
			Mage::getSingleton('adminhtml/session')->addError($this->__('Para o correto funcionamento é necessário o módulo está ativo nas configurações e com uma chave API válida.'));
			
			if (!$index) {
				$this->_redirect('*/*');
			}
		}
	}
	
	public function indexAction() {
		$this->verificaStatusKoiber(true);
		$this->_initAction()->renderLayout();	
	}
	
	public function historicoAction() {
		$this->verificaStatusKoiber();
		$this->pageData = array(
			'action' => 'koiber/historico',
			'title' => 'Histórico de Mensagens'
		);
		
		$this->_initAction()->renderLayout();
	}
	
	public function mensagemAction() {
		$this->verificaStatusKoiber();
		$this->pageData = array(
			'action' => 'koiber/mensagem',
			'title' => 'Mensagem'
		);
		
		$historico_id = $this->getRequest()->getParam('historico_id');
		$model = Mage::getModel('koiber_transactionalmessages/historico');
		
		$model->load((int)$historico_id);
		
		if (!$model->getId()) {
			Mage::getSingleton('adminhtml/session')->addError($this->__('Esta mensagem não existe no histórico.'));
			$this->_redirect('*/*/historico');
				
			return;
		}
		
		Mage::register('koiber_transactionalmessages_historico', $model);
		
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('koiber_transactionalmessages/adminhtml_mensagem_edit'))
			->renderLayout();
	}
	
	public function newAction() {
		$this->verificaStatusKoiber();
		$this->_forward('edit');
	}
	
	public function editAction() {
		$this->verificaStatusKoiber();
		$this->_initAction();
		
		$evento_id = $this->getRequest()->getParam('evento_id');
		$model = Mage::getModel('koiber_transactionalmessages/eventos');
		
		if ($evento_id) {
			$model->load($evento_id);
			
			if (!$model->getId()) {
				Mage::getSingleton('adminhtml/session')->addError($this->__('Esta mensagem não existe mais.'));
				$this->_redirect('*/*/');
				
				return;
			}
		}
		
		$this->_title($model->getId() ? $model->getName() : $this->__('Nova Mensagem'));
		
		$data = Mage::getSingleton('adminhtml/session')->getEventosData(true);
		if (!empty($data)) {
			$model->setData($data);
		}
		
		Mage::register('koiber_transactionalmessages', $model);
		
		$this->_initAction()
			->_addBreadcrumb($evento_id ? $this->__('Editar Mensagem') : $this->__('Nova Mensagem'), $evento_id ? $this->__('Editar Mensagem') : $this->__('Nova Mensagem'))
			->_addContent($this->getLayout()->createBlock('koiber_transactionalmessages/adminhtml_eventos_edit')->setData('action', $this->getUrl('*/*/save')))
			->renderLayout();
	}
	
	public function saveAction() {
		$this->verificaStatusKoiber();
		$postData = $this->getRequest()->getPost();
		
		if ($postData && !$this->validateForm($postData)) {
			$model = Mage::getSingleton('koiber_transactionalmessages/eventos');
			$model->setData(array_merge(array('evento_id' => $this->getRequest()->getParam('evento_id')), $postData));
			
			try {
				$model->save();
				
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('A mensagem foi salva com sucesso.'));
				$this->_redirect('*/*/');
				
				return;
			} catch (Mage_Core_Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($this->__('Um erro ocorreu ao salvar a mensagem.'));
			}
		}
		
		Mage::getSingleton('adminhtml/session')->setEventosData($postData);
		
		$this->_redirectReferer();
	}
	
	public function deleteAction() {
		$this->verificaStatusKoiber();
		if($this->getRequest()->getParam('evento_id')) {
			try {
				$model = Mage::getModel('koiber_transactionalmessages/eventos');
				$model->setId($this->getRequest()->getParam('evento_id'))->delete();
                    
				Mage::getSingleton('adminhtml/session')->addSuccess('Mensagem excluido com sucesso.');
				
				$this->_redirect('*/*/');
				
				return;
            } catch (Mage_Core_Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($this->__('Um erro ocorreu ao excluir a mensagem.'));
			}
            
            $this->_redirectReferer();
       }
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
	
	public function messageAction() {
        $data = Mage::getModel('koiber_transactionalmessages/eventos')->load($this->getRequest()->getParam('evento_id'));
		
        echo $data->getContent();
    }
	
	protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu($this->pageData['action'])
            ->_title($this->__('Koiber'))->_title($this->__($this->pageData['title']))
            ->_addBreadcrumb($this->__('Koiber'), $this->__('Koiber'))
            ->_addBreadcrumb($this->__($this->pageData['title']), $this->__($this->pageData['title']));
         
        return $this;
    }
	
	protected function validateForm($data) {
		$error = false;
		
		if (!$data['evento']) {
			$error = true;
			
			Mage::getSingleton('adminhtml/session')->setEventoErro($this->__('A seleção da template da mensagem é obrigatória.'));
		}
		
		if (!$data['canal']) {
			$error = true;
			
			Mage::getSingleton('adminhtml/session')->setCanalErro($this->__('A seleção do canal é obrigatória.'));
		}
		
		return $error;
	}
}