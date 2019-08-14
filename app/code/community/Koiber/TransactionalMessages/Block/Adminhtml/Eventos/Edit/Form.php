<?php
class Koiber_TransactionalMessages_Block_Adminhtml_Eventos_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {
	public function __construct() {
		parent::__construct();
		
		$this->setId('koiber_transactionalmessages_eventos_form');
		$this->setTitle($this->__('Informações da Mensagem'));
	}
	
	protected function _prepareLayout() {
        if ($head = $this->getLayout()->getBlock('head')) {
            $head->addItem('js', 'prototype/window.js')
                ->addItem('js_css', 'prototype/windows/themes/default.css')
                ->addCss('lib/prototype/windows/themes/magento.css')
                ->addItem('js', 'mage/adminhtml/variables.js');
        }
		
        return parent::_prepareLayout();
    }
	
	protected function _prepareForm() {
		$model = Mage::registry('koiber_transactionalmessages');
				
		$form = new Varien_Data_Form(array(
			'id' => 'edit_form',
			'action' => $this->getUrl('*/*/save', array('evento_id' => $this->getRequest()->getParam('evento_id'))),
			'method' => 'post'
		));
		
		$fieldset = $form->addFieldset('base_fieldset', array(
			'legend' => Mage::helper('checkout')->__('Dados da Mensagem'),
			'class' => 'fieldset-wide'
		));
		
		if ($model->getId()) {
			$fieldset->addFieldset('evento_id', 'hidden', array(
				'name' => 'evento_id'
			));
		}
		
		$defaultTemplates = Mage::getModel('core/email_template')->getDefaultTemplatesAsOptionsArray();
		
		$eventoOptions = array(
			1 => array(
				'value' => 0,
				'label' => $this->__('-- Selecione uma template --')
			)
		);

		foreach ($defaultTemplates as $defaultTemplate) {
			if ((strpos($defaultTemplate['value'], 'design') !== false) || !$defaultTemplate['value']) {
				continue;
			}
			
			$eventoOptions[] = array(
				'value' => $defaultTemplate['value'],
				'label' => $defaultTemplate['label']
			);
		}
		
		$insertVariableButton = $this->getLayout()
            ->createBlock('adminhtml/widget_button', '', array(
			    'type' => 'button',
                'label' => Mage::helper('adminhtml')->__('Inserir Variável...'),
                'onclick' => 'MagentovariablePlugin.loadChooser(\'' . $this->getUrl('*/*/variaveisPlugin', array('template_code' => $model->getEvento())) . '\', \'email\');'
            ));
		
		$fieldset->addField('evento', 'select', array(
			'name' => 'evento',
			'class'     => 'required-entry',
			'label' => $this->__('Template da Mensagem'),
			'title' => $this->__('Template da Mensagem'),
			'required' => true,
			'values' => $eventoOptions,
			'after_element_html' => (Mage::getSingleton('adminhtml/session')->getEventoErro() ? '<br><span style="color:red">' . Mage::getSingleton('adminhtml/session')->getEventoErro() . '</span>' : '') . $this->resetarJanelaVariaveis($insertVariableButton->getId()) . $this->obterAjaxTemplatePadraoKoiber(),
			'onchange' => 'trocarVariaveisCustom(this.value);'
		));
				
		require_once(Mage::getBaseDir('lib') . '/koiberPHP/src/Koiber/Autoload.php');
		
		$koiberConfig = Mage::getStoreConfig('koiber_options/koiber_configs');
		
		$koiberApi = new Koiber($koiberConfig['koiber_api']);
		$response = $koiberApi->getCannels();
		
		$canaisKoiber = $response->getBody(true);
		
		$canalOptions = array(
			1 => array(
				'value' => 0,
				'label' => $this->__('-- Selecione um canal --')
			)
		);
        $arrayCanais = array();
		foreach ($canaisKoiber as $canalKoiber) {			
			$canalOptions[] = array(
				'value' => $canalKoiber['id'],
				'label' => $canalKoiber['name']
			);
            $arrayCanais[$canalKoiber['id']] = $canalKoiber['name'];
		}
		
		$fieldset->addField('canal', 'select', array(
			'name' => 'canal',
			'class'     => 'required-entry',
			'label' => $this->__('Canal koiber'),
			'title' => $this->__('Canal koiber'),
			'required' => true,
			'values' => $canalOptions,
			'after_element_html' => Mage::getSingleton('adminhtml/session')->getCanalErro() ? '<br><span style="color:red">' . Mage::getSingleton('adminhtml/session')->getCanalErro() . '</span>' : $this->atualizaNomeCanal(json_encode($arrayCanais)),
            'onchange' => 'atualizaNomeCanal(this.value);',
		));
        
		$fieldset->addField('canal_nome', 'hidden', array(
			'name' => 'canal_nome'
		));
		
		$fieldset->addField('status', 'select', array(
			'name' => 'status',
			'class' => 'required-entry',
			'label' => $this->__('Status da Mensagem'),
			'title' => $this->__('Status da Mensagem'),
			'required' => true,
			'tabindex' => 1,
			'values' => array(1 => __('Ativo'), 0 => __('Inativo'))
			//'after_element_html' => '<br><small>' . __('Ativado, na template selecionada, será enviado esta menssagem para o koiber ao invez do e-mail (apenas se o usuário tiver cadastro no koiber).') . '</small>'
		));
		
		$fieldset->addField('tipo', 'select', array(
			'name' => 'tipo',
			'class' => 'required-entry',
			'label' => $this->__('Tipo de Mensagem'),
			'title' => $this->__('Tipo de Mensagem'),
			'required' => true,
			'tabindex' => 1,
			'values' => array('text' => 'Texto', 'form' => 'Formulário'),
			'after_element_html' => '<br><small>' . __('Caso seja formulário, observar os nomes do campos para que tenham os mesmo nomes no magento para atualização no callback.') . '</small>'
		));
		
		$fieldset->addField('assunto', 'text', array(
			'name' => 'assunto',
			'label' => $this->__('Assunto da Mensagem'),
			'title' => $this->__('Assunto da Mensagem'),
			'after_element_html' => '<br><small>' . __('Pode-se usar as variáveis normalmente.') . '</small>'
		));
		
        $fieldset->addField('insert_variable', 'note', array(
            'text' => $insertVariableButton->toHtml()
        ));
		
		$fieldset->addField('email', 'textarea', array(
			'name' => 'email',
			'label' => $this->__('Mensagem'),
			'title' => $this->__('Mensagem')
			//'after_element_html' => '<br><small>' . __('Caso preenchido, irá trocar a template padrão do e-mail para o conteudo deste campo.') . '</small>'
		));
		
		Mage::getSingleton('adminhtml/session')->unsEventoErro();
		Mage::getSingleton('adminhtml/session')->unsCanalErro();
		
		$form->setValues($model->getData());
		$form->setUseContainer(true);
		$this->setForm($form);
		
		return parent::_prepareForm();
	}
	
	protected function resetarJanelaVariaveis($id) {
		$js_function = "<script type=\"text/javascript\"><!--
		function trocarVariaveisCustom(template_code) {
			Variables.variablesContent = null;
			MagentovariablePlugin.variables = null;
			

			document.getElementById('" . $id . "').setAttribute('onclick', 'MagentovariablePlugin.loadChooser(\'" . $this->getUrl('koiber/index/variaveisPlugin') . "template_code/' + template_code + '\', \'email\');');
			
			obterAjaxTemplatePadraoKoiber(template_code);
		}
		//--></script>";
		
		return $js_function;
	}
	
	protected function obterAjaxTemplatePadraoKoiber() {
		$js_function = "<script type=\"text/javascript\"><!--
		var obterJSON = function(url, successHandler, errorHandler) {
			var xhr = typeof XMLHttpRequest != 'undefined' ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			xhr.open('get', url, true);
			xhr.responseType = 'json';
			xhr.onreadystatechange = function() {
				var status;
				var data;
		
				if (xhr.readyState == 4) { // `DONE`
					status = xhr.status;
					
					if (status == 200) {
						successHandler && successHandler(xhr.response);
					} else {
						errorHandler && errorHandler(status);
					}
				}
			};
			
			xhr.send();
		};
		
		function obterAjaxTemplatePadraoKoiber(template_code) {
			obterJSON('" . $this->getUrl('koiber/index/obterTemplatePadrao') . "template_code/' + template_code, function(dados) {
				document.getElementById('email').value = dados.text;
				document.getElementById('assunto').value = dados.subject;
			}, function(status) {
				alert('Erro com status ' + status);
			});			
		}
		//--></script>";
		
		return $js_function;
	}
    
    /**
     * Atualiza o nome do canal sempre que 
     */
    protected function atualizaNomeCanal($canais) {
		$js_function = "<script type=\"text/javascript\"><!--
        var canais = ".$canais."
		function atualizaNomeCanal(nomeCanal) {
			document.getElementById('canal_nome').setAttribute('value', canais[nomeCanal]);
		}
		//--></script>";
		
		return $js_function;
    }
    
}