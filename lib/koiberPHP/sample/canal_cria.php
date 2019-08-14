    <?php    
    require '../src/Koiber/Autoload.php';
    require 'config.php';

    $post = filter_input_array(INPUT_POST);
    if($post && isset($post['content'])) {
        $koiber = new Koiber(API_KEY);
        $response = $koiber->createCannel(json_encode($post['content']));
    }
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Criar Canal</title>
    </head>
    <body>
        <h1>Criar Canal</h1>
        <a href="./">Voltar</a><br><br>
        
        <form method="POST" action="">            
            <label>Conteúdo (OBJETO JSON)</label><br>
            <textarea name="content" cols="100" rows="15"></textarea><br>
            
            <input type="submit" value="criar">
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