    <?php
    require '../src/Koiber/Autoload.php';
    require 'config.php';

    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    if($method == 'POST') {
        $post = filter_input_array(INPUT_POST);
        
        $talk = array(
            'type' =>       $post['type'],
            'content' =>    ($post['type'] == 'form' ? json_decode($post['content']) : $post['content'])
        );
        
        $koiber = new Koiber(API_KEY);
        $response = $koiber->addMsgTalk($post['conversa'], json_encode($talk));
    }
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Adicionar mensagem a conversa</title>
        <style>
            label{display: block; margin-top: 25px;}
            input{width: 400px; height: 30px;}
            textarea{width: 800px; height: 200px;}
            input:last-child{margin-top: 20px;width: auto}
        </style>
    </head>
    <body>
        <h1>Adicionar mensagem a conversa</h1>
        <a href="./" onclick="window.history.back()">Voltar</a><br><br>
        
        <?php if($method === 'GET') {?>
        <form method="POST" action="">
            <label>Conversa</label>
            <input type="text" name="conversa" value=""><br>
            
            <label>Tipo da mensagem</label>
            <select name="type">
                <option value="">--</option>
                <option value="text">Text</option>
                <option value="form">Formulário</option>
            </select><br>
            
            <label>Conteúdo</label>
            <textarea name="content"></textarea><br>
            
            <input type="submit" value="Adicionar mensagem">
        </form>
        <?php } else { ?>
        <h2>Resultado</h2>
        <p><strong>STATUS: </strong> <?php echo $response->getResponseCode(); ?> - <?php echo $response->isOk(); ?></p>
        
        <div style="max-height: 630px; overflow: auto; padding: 10px; border: 1px solid #ddd;">
            <pre><?php print_r(json_decode($response->getBody(), true));?></pre>
        </div>
        <?php } ?>
    </body>
</html>