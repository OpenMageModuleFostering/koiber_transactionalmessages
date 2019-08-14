    <?php    
    require '../src/Koiber/Autoload.php';
    require 'config.php';

    $post = filter_input_array(INPUT_POST);
    $id = null;
    $content = null;
    if($post && isset($post['content'])) {
        $koiber = new Koiber(API_KEY);
        $id = $post['id'];
        $content = $post['content'];
        $response = $koiber->updateCannel($id, json_encode(json_decode($content)));
    }
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Atualiza Canal</title>
    </head>
    <body>
        <h1>Atualiza Canal</h1>
        <a href="./">Voltar</a><br><br>
        
        <form method="POST" action=""> 
            <label>ID do departamento</label><br>
            <input type="text" name="id" value="<?php echo $id; ?>" size="50"><br><br>
            
            <label>Conteúdo (OBJETO JSON)</label><br>
            <textarea name="content" cols="100" rows="15"><?php echo $content; ?></textarea><br>
            
            <input type="submit" value="Atualizar">
        </form>
        
        <?php if($post) { ?>
        <h2>Resultado</h2>
        <p><strong>STATUS: </strong> <?php echo $response->getResponseCode(); ?> - <?php echo $response->isOk(); ?></p>
        
        <div style="max-height: 630px; overflow: auto; padding: 10px; border: 1px solid #ddd;">
            <pre><?php print_r(json_decode($response->getBody(), true));?></pre>
        </div>
        <?php } ?>
    </body>
</html>