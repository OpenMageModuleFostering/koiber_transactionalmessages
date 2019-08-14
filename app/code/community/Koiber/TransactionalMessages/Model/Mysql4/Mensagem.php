<?php
class Koiber_TransactionalMessages_Model_Mysql4_Mensagem extends Mage_Core_Model_Mysql4_Abstract {
	protected function _construct() {
		$this->_init('koiber_transactionalmessages/mensagem', 'mensagem_historico_id');
	}
}