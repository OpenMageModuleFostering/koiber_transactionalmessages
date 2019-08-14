<?php
class Koiber_TransactionalMessages_Model_Mysql4_Historico_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
	protected function _construct() {
		$this->_init('koiber_transactionalmessages/historico');
	}
}