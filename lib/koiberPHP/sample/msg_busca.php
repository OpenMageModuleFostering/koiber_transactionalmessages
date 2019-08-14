    <?php
    setlocale(LC_ALL, 'pt_BR.utf8', 'pt_br', 'pt_BR', 'ptb', 'ptb_ptb', 'brazilian', 'brazil', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    
    require '../src/Koiber/Autoload.php';
    require 'config.php';
    $id = null;
    $post = filter_input_array(INPUT_POST);
    if($post) {
        $id = $post['id'];
    }
    
    
    $koiber = new Koiber(API_KEY);
    $response = $koiber->getTalk($id);
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Buscar conversas</title>
    </head>
    <body>
        <h1>Buscar conversa</h1>
        <a href="./">Voltar</a><br><br>
        
        <form method="POST" action="">
            <label>ID conversa</label>
            <input type="text" name="id" value="<?php echo $id; ?>" size="30">
            <input type="submit" value="buscar">
        </form>
        
        <?php if($post) { ?>
        <h2>Resultado</h2>
        <p><strong>STATUS: </strong> <?php echo $response->getResponseCode(); ?> - <?php echo $response->isOk(); ?></p>
        
        <div style="max-height: 630px; overflow: auto; padding: 10px; border: 1px solid #ddd;">
            <?php $talk = $response->getTalk(); ?>
            <p>
                <strong>ID</strong>: <?php echo $talk->getId(); ?><br>
                <strong>Data criação</strong>: <?php echo $talk->getCreatedAt()->format('d-m-Y H:i:s'); ?><br>
                <strong>Title</strong>: <?php echo $talk->getTitle(); ?><br>
                <strong>Autor </strong>: <?php echo $talk->getAuthor(); ?><br>
                <strong>Uusuário id</strong>: <?php echo $talk->getUser()->getId(); ?><br>
                <strong>Canal id</strong>: <?php echo $talk->getChannel()->getId(); ?><br>
                <strong>Total de mensagens</strong>: <?php echo count($talk->getMsgs()); ?><br>
            </p>
            
            <h3>Mensagens</h3>
            <?php foreach($talk->getMsgs() as $msg ) { ?>
            <p>
                ------------------------<br>
                <strong>ID</strong>: <?php echo $msg->getId(); ?><br>
                <strong>Data criação</strong>: <?php echo $msg->getCreatedAt()->format('d-m-Y H:i:s'); ?><br>
                <strong>Autor </strong>: <?php echo $msg->getAuthor(); ?><br>
                <strong>Tipo </strong>: <?php echo $msg->getType(); ?><br>
                <strong>Conteúdo </strong>:
                <?php if($msg->getType() == Type::TEXT) echo $msg->getContent(); else { 
                    $fields = $msg->getContent()->getElements();
                    foreach ($fields as $field) {
                        echo $field->getId().' - ' . $field->getElement().' - ' . $field->getLabel();
                    }
                    ?>
                <?php } // end field ?>
                
            </p>
            <?php }// end msg ?>
        </div>
        <?php } ?>
    </body>
</html>