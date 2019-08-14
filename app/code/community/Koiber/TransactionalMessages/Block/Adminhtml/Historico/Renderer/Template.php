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
                //$modelEventos = Mage::getModel('koiber_transactionalmessages/eventos')->load($value, 'canal')->getData();
                //$value = (isset($modelEventos) && array_key_exists('canal_nome', $modelEventos)) ? $modelEventos['canal_nome'] : __('Canal não localizado');
                $value = $value ? $value : __('Canal não localizado');
			break;
			case 'cliente':				
				$customer = Mage::getModel('customer/customer')->setWebsiteId(1)->loadByEmail($value)->getData();
				$value = $customer ? $customer['firstname'] . ' ' . $customer['lastname'] : $value;
			break;
			case 'data':
				$value = date('d/m/Y H:i:s', strtotime($value));
			break;
			case 'titulo':
				$historico = Mage::getModel('koiber_transactionalmessages/historico')->load($value, 'koiber_parent_talk_id');
				$mensagem = Mage::getModel('koiber_transactionalmessages/mensagem')->getCollection()->addFieldToFilter('historico_id', array('eq' => $historico->getId()))->count();
				$value = $historico->getTitle() . ' (' . ($mensagem) . ')';
                //$value = $value . ' (' . ($mensagem) . ')';
			break;
		}
		
		return $value;
	}
}
?>