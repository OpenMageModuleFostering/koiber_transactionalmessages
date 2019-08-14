    <?php
    require '../src/Koiber/Autoload.php';
    require 'config.php';
    $per_page = 1;
    $page = 1;

    $post = filter_input_array(INPUT_POST);
    if($post) {
        $per_page = (int)$post['per_page'];
        $page = (int)$post['page'];
    }
    
    $koiber = new Koiber(API_KEY);
    $response = $koiber->getTalks($page, $per_page);
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Listar conversas</title>
    </head>
    <body>
        <h1>Listar conversa</h1>
        <a href="./">Voltar</a><br><br>
        
        <form method="POST" action="">
            <label>Resultados por página</label>
            <input type="text" name="per_page" value="<?php echo $per_page; ?>" size="5">
            <label>Página</label>
            <input type="text" name="page" value="<?php echo $page; ?>" size="5">
            <input type="submit" value="buscar">
        </form>
        
        <h2>Resultado</h2>
        <p><strong>STATUS: </strong> <?php echo $response->getResponseCode(); ?> - <?php echo $response->isOk(); ?></p>
        
        <div style="max-height: 630px; overflow: auto; padding: 10px; border: 1px solid #ddd;">
            <pre><?php print_r(json_decode($response->getBody(), true));?></pre>
        </div>
    </body>
</html>