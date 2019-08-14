<?php
class Koiber_TransactionalMessages_Block_Adminhtml_Mensagem_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {
	public function __construct() {
		parent::__construct();
		
		$this->setId('koiber_transactionalmessages_mensagem_form');
		$this->setTitle($this->__('Informações da Mensagem'));
	}
	
	protected function _prepareLayout() {		
        return parent::_prepareLayout();
	}
	
	protected function _prepareForm() {
		$model = Mage::registry('koiber_transactionalmessages_historico');
				
		$form = new Varien_Data_Form(array('id' => 'view_form'));
		
		$fieldset = $form->addFieldset('base_fieldset', array(
			'legend' => Mage::helper('checkout')->__('Dados da Mensagem'),
			'class' => 'fieldset-wide'
		));		
		
		$defaultTemplates = Mage::getModel('core/email_template')->getDefaultTemplates();
		
		foreach ($defaultTemplates as $code => $defaultTemplate) {
			if ($code == $model->getTemplate()) {
				$template = __($defaultTemplate['label']);
				
				break;
			} else {
				$template = "";
			}				
		}
        
        // inclui link para o PEDIDO
        if($model->getOrderId()) {
            $order = Mage::getModel('sales/order')->loadByIncrementId($model->getOrderId());
            $fieldset->addField('order', 'note', array(
                'label' => "Pedido", 
                'text' => "<a href='".Mage::helper('adminhtml')->getUrl("*/sales_order/view", array('order_id'=> $order->getId()))."'>".$model->getOrderId()."</a>"
            ));
        }
        
		$fieldset->addField('titulo', 'note', array(
            'label' => $this->__('Título'), 
			'text' => $model->getTitle()
        ));

		$fieldset->addField('template', 'note', array(
            'label' => $this->__('Template da Mensagem'), 
			'text' => $template
        ));
        
        //$modelEventos = Mage::getModel('koiber_transactionalmessages/eventos')->load($model->getCanal(), 'canal')->getData();
        $fieldset->addField('canal', 'note', array(
            'label' => $this->__('Canal koiber'), 
			'text' => $model->getCanalNome() ? $model->getCanalNome() : $this->__('Canal não localizado')
			//'text' => (isset($modelEventos) && array_key_exists('canal_nome', $modelEventos)) ? $modelEventos['canal_nome'] : $this->__('Canal não localizado')
        ));
		
		$texto_evento = array(
			'talk.created' => __('Conversa Criada'),
			'talk.msg.created' => __('Mensagem Adicionada'),
			'talk.close' => __('Conversa Encerrada'),
			'talk.rating' => __('Conversa Avaliada'),
		);
		
		$fieldset->addField('evento', 'note', array(
            'label' => $this->__('Último Evento'), 
			'text' => isset($texto_evento[$model->getKoiberLastMessageIdStatus()]) ? $texto_evento[$model->getKoiberLastMessageIdStatus()] : $model->getTipo()
        ));
		
		$fieldset->addField('data_inserido', 'note', array(
            'label' => $this->__('Data de Criação da Conversa'), 
			'text' => date('d/m/Y H:i:s', strtotime($model->getDataInserido()))
        ));
		
		$fieldset->addField('data_modificado', 'note', array(
            'label' => $this->__('Data da Última Modificação'), 
			'text' => date('d/m/Y H:i:s', strtotime($model->getDataModificado()))
        ));
		
		$mensagens = Mage::getModel('koiber_transactionalmessages/mensagem')->getCollection()->addFieldToFilter('historico_id', array('eq' => $model->getId()));
		
		$i = 1;
		
		foreach ($mensagens as $mensagem) {
			$message = unserialize($mensagem->getMensagem());
			
			if ($this->validate_json($message['content'])) {
				$message['content'] = (array)json_decode($message['content']);
			}
			
			if ($message['type'] == 'form') {
				$message_html = '';
				
				foreach ($message['content']['elements'] as $element) {
					$element = (object)$element;
					
					switch ($element->element) {
						case 'p': $message_html .= '<p>' . $element->content . '</p>'; break;
						case 'input': 
							$message_html .= '<p>' . $element->label . '</p><p> <input type="' . $element->type . '" name="' . $element->id . '" value="' . $element->response . '" disabled="disabled"></p>';
						break;
					}
				}
				
				$message['content'] = $message_html;
			} elseif ($message['type'] == 'form_resp') {
				$message_html = '';
				
				foreach ($message['content'] as $element) {
					switch ($element['element']) {
						case 'p': $message_html .= '<p>' . $element['content'] . '</p>'; break;
						case 'input': 
							$message_html .= '<p>' . $element['label'] . ': ' . $element['response'] . '</p>';
						break;
					}
				}
				
				$message['content'] = $message_html;
			} else {
				$message['content'] = nl2br(strip_tags($message['content']));
			}
			$message['content'] .="<br /><br />";
			$trajeto = (($i == 1) || ($message['author'] == 'company')) ? __('enviado') : __('recebido');
			
			$fieldset->addField('mensagem' . $mensagem->getId(), 'note', array(
				'label' => $this->__('Mensagem') . '# ' . $i . ' ' . $trajeto . ' ' . __('em') . ' ' . date('d/m/Y H:i:s', strtotime($mensagem->getDataInserido())), 
				'text' => $message['content']
			));
			
			$i++;
		}
		
		$form->setUseContainer(true);
		$this->setForm($form);
		
		return parent::_prepareForm();
	}
	
	protected function validate_json($str=NULL) {
		if (is_string($str)) {
			@json_decode($str);
			
			return !json_last_error() ? true : false;
		}
    
		return false;
	}
}