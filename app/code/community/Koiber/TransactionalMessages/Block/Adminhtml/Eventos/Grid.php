<?php
class Koiber_TransactionalMessages_Block_Adminhtml_Eventos_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function __construct() {
		parent::__construct();
		
		$this->setDefaultSort('evento_id');
		$this->setId('koiber_transactionalmessages_eventos_grid');
		$this->setDefaultDir('asc');
		$this->setSaveParametersInSession(true);
	}
	
	protected function _getCollectionClass() {
		return 'koiber_transactionalmessages/eventos_collection';
	}
	
	protected function _prepareCollection() {
		$collection = Mage::getResourceModel($this->_getCollectionClass());
		
		$this->setCollection($collection);
		
		return parent::_prepareCollection();
	}
	
	protected function _prepareColumns() {
		 $this->addColumn('evento_id',
            array(
                'header'=> $this->__('ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'evento_id'				
            )
        );
		
		$this->addColumn('evento',
			array(
				'header' => $this->__('Mensagem'),
				'align' => 'left',
				'index' => 'evento',
				'renderer' => 'Koiber_TransactionalMessages_Block_Adminhtml_Eventos_Renderer_Template'
			)
		);
		
		$this->addColumn('status',
			array(
				'header' => $this->__('Status'),
				'align' => 'center',
				'index' => 'status',
				'renderer' => 'Koiber_TransactionalMessages_Block_Adminhtml_Eventos_Renderer_Status'
			)
		);
		
		return parent::_prepareColumns();
	}
	
	public function getRowUrl($row) {
		return $this->getUrl('*/*/edit', array('evento_id' => $row->getId()));
	}
}