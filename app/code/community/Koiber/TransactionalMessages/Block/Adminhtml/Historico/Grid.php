<?php
class Koiber_TransactionalMessages_Block_Adminhtml_Historico_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function __construct() {
		parent::__construct();
		
		$this->setDefaultSort('historico_id');
		$this->setId('koiber_transactionalmessages_historico_grid');
		$this->setDefaultDir('desc');
		$this->setSaveParametersInSession(true);
	}
	
	protected function _getCollectionClass() {
		return 'koiber_transactionalmessages/historico_collection';
	}
	
	protected function _prepareCollection() {
		$collection = Mage::getResourceModel($this->_getCollectionClass());
		
		$this->setCollection($collection);
		
		return parent::_prepareCollection();
	}
	
	protected function _prepareColumns() {
		 $this->addColumn('historico_id',
            array(
                'header'=> $this->__('ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'historico_id'				
            )
        );
		
		$this->addColumn('titulo',
			array(
				'header' => $this->__('Título'),
				'align' => 'left',
				'index' => 'koiber_parent_talk_id',
				'renderer' => 'Koiber_TransactionalMessages_Block_Adminhtml_Historico_Renderer_Template'
			)
		);
		
		$this->addColumn('cliente',
			array(
				'header' => $this->__('Cliente'),
				'align' => 'left',
				'index' => 'email',
				'renderer' => 'Koiber_TransactionalMessages_Block_Adminhtml_Historico_Renderer_Template'
			)
		);
		
        /*
		$this->addColumn('status',
			array(
				'header' => $this->__('Nome do Evento'),
				'align' => 'left',
				'index' => 'koiber_last_message_id_status',
				'renderer' => 'Koiber_TransactionalMessages_Block_Adminhtml_Historico_Renderer_Template'
			)
		);*/
		
		$this->addColumn('canal',
			array(
				'header' => $this->__('Canal koiber'),
				'align' => 'left',
				'index' => 'canal_nome',
				'renderer' => 'Koiber_TransactionalMessages_Block_Adminhtml_Historico_Renderer_Template'
			)
		);
		
		$this->addColumn('data',
			array(
				'header' => $this->__('Data'),
				'align' => 'left',
				'index' => 'data_modificado',
				'renderer' => 'Koiber_TransactionalMessages_Block_Adminhtml_Historico_Renderer_Template'
			)
		);
		
		return parent::_prepareColumns();
	}
	
	public function getRowUrl($row) {
		return $this->getUrl('*/*/mensagem', array('historico_id' => $row->getId()));
	}
}