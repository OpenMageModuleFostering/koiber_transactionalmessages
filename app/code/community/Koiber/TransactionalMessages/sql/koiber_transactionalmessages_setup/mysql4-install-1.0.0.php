<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
 
/**
 * Create table 'koiber_transactionalmessages_eventos'
 */
$eventos = $installer->getTable('koiber_transactionalmessages/eventos');

if ($installer->getConnection()->isTableExists($eventos) != true) {
  $table = $installer->getConnection()
    ->newTable($installer->getTable('koiber_transactionalmessages/eventos'))
    ->addColumn('evento_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Evento_ID')
	->addColumn('evento', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
		'nullable' => false
		), 'Evento')
	->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'default' => 1
	), 'Status')
    ->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        ), 'E-mail')
	->addColumn('canal', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        ), 'Canal')
	->addColumn('tipo', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        ), 'Tipo')
	->addColumn('assunto', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        ), 'Assunto');
  $installer->getConnection()->createTable($table);
  
  $installer->run("INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (2,'sales_email_order_template',1,'{\r\n  \"elements\": [\r\n    {\r\n      \"element\": \"p\",\r\n      \"id\": \"p1\",\r\n      \"content\": \"Obrigado <b>{{htmlescape var=\$order.getCustomerName()}}</b> pela compra. Por favor confirme o endereço de entrega\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_city\",\r\n      \"label\": \"Cidade\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getCity()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_region\",\r\n      \"label\": \"Estado\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getRegion()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_street1\",\r\n      \"label\": \"Endereço\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getStreet1()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_street2\",\r\n      \"label\": \"Complemento\",\r\n      \"required\": false,\r\n      \"response\": \"{{var order.getShippingAddress().getStreet2()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"number\",\r\n      \"id\": \"Order_shipping_address_postcode\",\r\n      \"label\": \"CEP\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getPostcode()}}\"\r\n    }\r\n  ]\r\n}','5755822cf68af264192fc4df','form','Confirmação de pedido ({{var order.increment_id}})');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (3,'customer_password_forgot_email_template',1,'Houve recentemente um pedido para alterar a senha da sua conta.\r\n\r\nSe você solicitou esta alteração de senha, por favor redefinir sua senha aqui:\r\n\r\n<a href=\"{{store url=\"customer/account/resetpassword/\" _query_id=\$customer.id _query_token=\$customer.rp_token}}\">Redefinir senha</a>\r\n\r\n\r\nSe você não fez esta solicitação, você pode ignorar esta mensagem e sua senha permanecerá a mesma.','56feaca54c4fe96d457124f7','text','Nova senha');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (17,'sales_email_invoice_template',1,'Foi gerado uma nova fatura para o pedido {{var order.increment_id}}.\r\n\r\n{{if comment}}Nota:\r\n{{var comment}}{{/if}}','5755822cf68af264192fc4df','text','Nova fatura gerada - {{var invoice.increment_id}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (24,'customer_create_account_email_template',1,'Seu cadastro na loja {{config path=\"general/store_information/name\"}} foi efetuado com sucesso.\r\n\r\n','56feaca54c4fe96d457124f7','text','Bem-vindo a loja {{config path=\"general/store_information/name\"}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (25,'contacts_email_email_template',1,'Olá {{var data.name}},\r\n\r\nSua solicitação será atendida em breve. Aguarde.\r\n\r\n--\r\nMensagem original:\r\n{{var data.comment}}','56feaca54c4fe96d457124f7','text','Contato via site {{config path=\"general/store_information/name\"}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (26,'sales_email_order_comment_template',1,'Seu pedido {{var order.increment_id}} foi atualizado para: {{var order.getStatusLabel()}}\r\n\r\n{{if comment}} {{var comment}} {{/if}}','5755822cf68af264192fc4df','text','Pedido {{var order.increment_id}} atualizado');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (27,'sales_email_invoice_comment_template',1,'Seu pedido {{var order.increment_id}} foi atualizado para {{var order.getStatusLabel()}}\r\n\r\n{{if comment}} {{var comment}} {{/if}}','5755822cf68af264192fc4df','text','Fatura atualizada - pedido {{var order.increment_id}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (28,'sales_email_shipment_template',1,'Novo envio para o pedido #{{var order.increment_id}}\r\n{{if comment}}\r\n{{var comment}}\r\n{{/if}}\r\nEnviado para: \r\n{{var order.getShippingAddress().getStreet1()}}\r\n{{var order.getShippingAddress().getCity()}} - {{var order.getShippingAddress().getRegion()}}\r\n','5755822cf68af264192fc4df','text','{{var store.getFrontendName()}}: Envio #{{var shipment.increment_id}} para o pedido # {{var order.increment_id}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (29,'sales_email_shipment_comment_template',1,'Seu pedido #{{var order.increment_id}} foi atualizado para {{var order.getStatusLabel()}}\r\n\r\n{{if comment}} {{var comment}} {{/if}}','5755822cf68af264192fc4df','text','Envio# {{var shipment.increment_id}} atulizado');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (30,'checkout_payment_failed_template',1,'Falha no pagamento do pedido #{{var order.id}}\r\n\r\nMotivo:\r\n{{var reason}}','5755822cf68af264192fc4df','text','Falha no pagamento ');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (31,'newsletter_subscription_success_email_template',1,'Obrigado por se inscrever na nossa newsletter.','56feaca54c4fe96d457124f7','text','Confirmação de inscrição - newsletter');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (35,'customer_create_account_email_confirmed_template',1,'Olá {{htmlescape var=\$customer.name}},\r\n\r\npara acessar nossa loja você precisa confirmar seu e-mail através do link abaixo:\r\n<a href=\"{{store url=\"customer/account/confirm/\" _query_id=\$customer.id _query_key=\$customer.confirmation _query_back_url=\$back_url}}\">Confirmar e-mail</a>\r\n\r\nSe você tiver qualquer dúvida, não hesite em nos contactar.','56feaca54c4fe96d457124f7','text','Confirmação de e-mail');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (37,'sales_email_order_guest_template',0,'{\r\n  \"elements\": [\r\n    {\r\n      \"element\": \"p\",\r\n      \"id\": \"p1\",\r\n      \"content\": \"Obrigado <b>{{htmlescape var=\$order.getCustomerName()}}</b> pela compra. Por favor confirme o endereço de entrega\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_city\",\r\n      \"label\": \"Cidade\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getCity()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_region\",\r\n      \"label\": \"Estado\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getRegion()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_street1\",\r\n      \"label\": \"Endereço\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getStreet1()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_street2\",\r\n      \"label\": \"Complemento\",\r\n      \"required\": false,\r\n      \"response\": \"{{var order.getShippingAddress().getStreet2()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"number\",\r\n      \"id\": \"Order_shipping_address_postcode\",\r\n      \"label\": \"CEP\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getPostcode()}}\"\r\n    }\r\n  ]\r\n}','5755822cf68af264192fc4df','text','Confirmação de pedido ({{var order.increment_id}})');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (38,'sales_email_order_comment_guest_template',1,'Seu pedido {{var order.increment_id}} foi atualizado para: {{var order.getStatusLabel()}}\r\n\r\n{{if comment}} {{var comment}} {{/if}}','56feaca54c4fe96d457124f7','text','Pedido {{var order.increment_id}} atualizado');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (39,'sales_email_invoice_guest_template',1,'Foi gerado uma nova fatura para o pedido {{var order.increment_id}}.\r\n\r\n{{if comment}}Nota:\r\n{{var comment}}{{/if}}','56feaca54c4fe96d457124f7','text','Nova fatura gerada - {{var invoice.increment_id}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (40,'sales_email_invoice_comment_guest_template',1,'Seu pedido {{var order.increment_id}} foi atualizado para {{var order.getStatusLabel()}}\r\n\r\n{{if comment}} {{var comment}} {{/if}}','56feaca54c4fe96d457124f7','text','Fatura atualizada - pedido {{var order.increment_id}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (41,'sales_email_creditmemo_template',1,'Seu pedido {{var order.increment_id}} foi atualizado.\r\n\r\n{{if comment}}Nota:\r\n{{var comment}}{{/if}}','56feaca54c4fe96d457124f7','text','Reembolso ');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (42,'sales_email_creditmemo_comment_guest_template',1,'Seu pedido {{var order.increment_id}} foi atualizado.\r\n\r\n{{if comment}}Nota:\r\n{{var comment}}{{/if}}','56feaca54c4fe96d457124f7','text','Reembolso ');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (45,'sales_email_shipment_guest_template',1,'Novo envio para o pedido #{{var order.increment_id}}\r\n\r\n{{if comment}}Nota:\r\n{{var comment}}\r\n{{/if}}','56feaca54c4fe96d457124f7','text','Novo envio ({{var order.increment_id}})');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/eventos')}` (`evento_id`,`evento`,`status`,`email`,`canal`,`tipo`,`assunto`) VALUES (58,'newsletter_subscription_un_email_template',1,'A partir de agora você não receberá mais nossas promoções.\r\n','56feaca54c4fe96d457124f7','text','cancelado o envio de newsletter');");
}

$historico = $installer->getTable('koiber_transactionalmessages/historico');

if ($installer->getConnection()->isTableExists($historico) != true) {
  $table = $installer->getConnection()
    ->newTable($installer->getTable('koiber_transactionalmessages/historico'))
    ->addColumn('historico_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'historico_id')
	->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
		'nullable' => false
		), 'Order Id')
	->addColumn('koiber_parent_talk_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
		'nullable' => false
	), 'Parent talk id')
	->addColumn('koiber_last_message_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
		'nullable' => false
	), 'Last talk id')
    ->addColumn('data_modificado', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default'  => '',
        ), 'Data Modificado')
	->addColumn('data_inserido', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        ), 'Data Inserido')
	->addColumn('koiber_last_message_id_status', Varien_Db_Ddl_Table::TYPE_VARCHAR, 45, array(
        'nullable'  => false,
        ), 'Last talk id status')
	->addColumn('canal', Varien_Db_Ddl_Table::TYPE_VARCHAR, 45, array(
        'nullable'  => false,
        ), 'Canal')
	->addColumn('template', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        ), 'Template')
	->addColumn('email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        ), 'E-mail');
		
  $installer->getConnection()->createTable($table);
}

$mensagem = $installer->getTable('koiber_transactionalmessages/mensagem');

if ($installer->getConnection()->isTableExists($mensagem) != true) {
	$table = $installer->getConnection()
    ->newTable($installer->getTable('koiber_transactionalmessages/mensagem'))
	->addColumn('mensagem_historico_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'mensagem_historico_id')
	->addColumn('historico_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
		'nullable' => false
		), 'Historico Id')
	->addColumn('mensagem', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        ), 'Mensagem')
	->addColumn('tipo', Varien_Db_Ddl_Table::TYPE_VARCHAR, 45, array(
        'nullable'  => false,
        ), 'Tipo de Mensagem')
	->addColumn('data_inserido', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        ), 'Data Inserido');

	$installer->getConnection()->createTable($table);
}

$padrao = $installer->getTable('koiber_transactionalmessages/padrao');

if ($installer->getConnection()->isTableExists($padrao) != true) {
	$table = $installer->getConnection()
    ->newTable($installer->getTable('koiber_transactionalmessages/padrao'))
	->addColumn('padrao_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'padrao_id')
	->addColumn('evento', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
		'nullable' => false
		), 'Evento')
	->addColumn('mensagem', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        ), 'Mensagem')
	->addColumn('assunto', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        ), 'Assunto');

	$installer->getConnection()->createTable($table);
	
	$installer->run("INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (1, 'sales_email_order_template', '{\r\n  \"elements\": [\r\n    {\r\n      \"element\": \"p\",\r\n      \"id\": \"p1\",\r\n      \"content\": \"Obrigado <b>{{htmlescape var=\$order.getCustomerName()}}</b> pela compra. Por favor confirme o endereço de entrega\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_city\",\r\n      \"label\": \"Cidade\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getCity()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_region\",\r\n      \"label\": \"Estado\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getRegion()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_street1\",\r\n      \"label\": \"Endereço\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getStreet1()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_street2\",\r\n      \"label\": \"Complemento\",\r\n      \"required\": false,\r\n      \"response\": \"{{var order.getShippingAddress().getStreet2()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"number\",\r\n      \"id\": \"Order_shipping_address_postcode\",\r\n      \"label\": \"CEP\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getPostcode()}}\"\r\n    }\r\n  ]\r\n}','Confirmação de pedido ({{var order.increment_id}})');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (3,'customer_password_forgot_email_template','Houve recentemente um pedido para alterar a senha da sua conta.\r\n\r\nSe você solicitou esta alteração de senha, por favor redefinir sua senha aqui:\r\n\r\n<a href=\"{{store url=\"customer/account/resetpassword/\" _query_id=\$customer.id _query_token=\$customer.rp_token}}\">Redefinir senha</a>\r\n\r\n\r\nSe você não fez esta solicitação, você pode ignorar esta mensagem e sua senha permanecerá a mesma.','Nova senha');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (17,'sales_email_invoice_template','Foi gerado uma nova fatura para o pedido {{var order.increment_id}}.\r\n\r\n{{if comment}}Nota:\r\n{{var comment}}{{/if}}','Nova fatura gerada - {{var invoice.increment_id}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (24,'customer_create_account_email_template','Seu cadastro na loja {{config path=\"general/store_information/name\"}} foi efetuado com sucesso.\r\n\r\n','Bem-vindo a loja {{config path=\"general/store_information/name\"}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (25,'contacts_email_email_template','Olá {{var data.name}},\r\n\r\nSua solicitação será atendida em breve. Aguarde.\r\n\r\n--\r\nMensagem original:\r\n{{var data.comment}}','Contato via site {{config path=\"general/store_information/name\"}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (26,'sales_email_order_comment_template','Seu pedido {{var order.increment_id}} foi atualizado para: {{var order.getStatusLabel()}}\r\n\r\n{{if comment}} {{var comment}} {{/if}}','Pedido {{var order.increment_id}} atualizado');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (27,'sales_email_invoice_comment_template','Seu pedido {{var order.increment_id}} foi atualizado para {{var order.getStatusLabel()}}\r\n\r\n{{if comment}} {{var comment}} {{/if}}','Fatura atualizada - pedido {{var order.increment_id}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (28,'sales_email_shipment_template','Novo envio para o pedido #{{var order.increment_id}}\r\n{{if comment}}\r\n{{var comment}}\r\n{{/if}}\r\nEnviado para: \r\n{{var order.getShippingAddress().getStreet1()}}\r\n{{var order.getShippingAddress().getCity()}} - {{var order.getShippingAddress().getRegion()}}\r\n','{{var store.getFrontendName()}}: Envio #{{var shipment.increment_id}} para o pedido # {{var order.increment_id}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (29,'sales_email_shipment_comment_template','Seu pedido #{{var order.increment_id}} foi atualizado para {{var order.getStatusLabel()}}\r\n\r\n{{if comment}} {{var comment}} {{/if}}','Envio# {{var shipment.increment_id}} atulizado');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (30,'checkout_payment_failed_template','Falha no pagamento do pedido #{{var order.id}}\r\n\r\nMotivo:\r\n{{var reason}}','Falha no pagamento ');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (31,'newsletter_subscription_success_email_template','Obrigado por se inscrever na nossa newsletter.','Confirmação de inscrição - newsletter');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (35,'customer_create_account_email_confirmed_template','Olá {{htmlescape var=\$customer.name}},\r\n\r\npara acessar nossa loja você precisa confirmar seu e-mail através do link abaixo:\r\n<a href=\"{{store url=\"customer/account/confirm/\" _query_id=\$customer.id _query_key=\$customer.confirmation _query_back_url=\$back_url}}\">Confirmar e-mail</a>\r\n\r\nSe você tiver qualquer dúvida, não hesite em nos contactar.','Confirmação de e-mail');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (37,'sales_email_order_guest_template','{\r\n  \"elements\": [\r\n    {\r\n      \"element\": \"p\",\r\n      \"id\": \"p1\",\r\n      \"content\": \"Obrigado <b>{{htmlescape var=\$order.getCustomerName()}}</b> pela compra. Por favor confirme o endereço de entrega\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_city\",\r\n      \"label\": \"Cidade\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getCity()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_region\",\r\n      \"label\": \"Estado\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getRegion()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_street1\",\r\n      \"label\": \"Endereço\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getStreet1()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"text\",\r\n      \"id\": \"Order_shipping_address_street2\",\r\n      \"label\": \"Complemento\",\r\n      \"required\": false,\r\n      \"response\": \"{{var order.getShippingAddress().getStreet2()}}\"\r\n    },\r\n    {\r\n      \"element\": \"input\",\r\n      \"type\": \"number\",\r\n      \"id\": \"Order_shipping_address_postcode\",\r\n      \"label\": \"CEP\",\r\n      \"required\": true,\r\n      \"response\": \"{{var order.getShippingAddress().getPostcode()}}\"\r\n    }\r\n  ]\r\n}','Confirmação de pedido ({{var order.increment_id}})');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (38,'sales_email_order_comment_guest_template','Seu pedido {{var order.increment_id}} foi atualizado para: {{var order.getStatusLabel()}}\r\n\r\n{{if comment}} {{var comment}} {{/if}}','Pedido {{var order.increment_id}} atualizado');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (39,'sales_email_invoice_guest_template','Foi gerado uma nova fatura para o pedido {{var order.increment_id}}.\r\n\r\n{{if comment}}Nota:\r\n{{var comment}}{{/if}}','Nova fatura gerada - {{var invoice.increment_id}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (40,'sales_email_invoice_comment_guest_template','Seu pedido {{var order.increment_id}} foi atualizado para {{var order.getStatusLabel()}}\r\n\r\n{{if comment}} {{var comment}} {{/if}}','Fatura atualizada - pedido {{var order.increment_id}}');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (41,'sales_email_creditmemo_template','Seu pedido {{var order.increment_id}} foi atualizado.\r\n\r\n{{if comment}}Nota:\r\n{{var comment}}{{/if}}','Reembolso ');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (42,'sales_email_creditmemo_comment_guest_template','Seu pedido {{var order.increment_id}} foi atualizado.\r\n\r\n{{if comment}}Nota:\r\n{{var comment}}{{/if}}','Reembolso ');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (45,'sales_email_shipment_guest_template','Novo envio para o pedido #{{var order.increment_id}}\r\n\r\n{{if comment}}Nota:\r\n{{var comment}}\r\n{{/if}}','Novo envio ({{var order.increment_id}})');
INSERT INTO `{$installer->getTable('koiber_transactionalmessages/padrao')}` (`padrao_id`,`evento`,`mensagem`,`assunto`) VALUES (58,'newsletter_subscription_un_email_template','A partir de agora você não receberá mais nossas promoções.\r\n','Cancelado o envio de newsletter');");
}

$installer->endSetup();