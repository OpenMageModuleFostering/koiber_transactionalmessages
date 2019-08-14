<?php
class Koiber_TransactionalMessages_Model_Mysql4_Eventos extends Mage_Core_Model_Mysql4_Abstract {
	protected function _construct() {
		$this->_init('koiber_transactionalmessages/eventos', 'evento_id');
	}
}