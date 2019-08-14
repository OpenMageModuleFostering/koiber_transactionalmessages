<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
 
/**
 * Update table 'koiber_transactionalmessages_eventos'
 */

$installer->run("
    ALTER TABLE {$this->getTable('koiber_transactionalmessages/eventos')}
    ADD COLUMN `canal_nome` VARCHAR(255) NOT NULL AFTER `canal`;
");


/**
 * Update table 'koiber_transactionalmessages_historico'
 */
$installer->run("
    ALTER TABLE {$this->getTable('koiber_transactionalmessages/historico')}
    ADD COLUMN `canal_nome` VARCHAR(255) NOT NULL AFTER `canal`,
    ADD COLUMN `title` VARCHAR(255) NOT NULL AFTER `email`;
");


$installer->endSetup();