    <?php    
    require '../src/Koiber/Autoload.php';
    require 'config.php';

    $post = filter_input_array(INPUT_POST);
    if($post && isset($post['id'])) {
        $koiber = new Koiber(API_KEY);
        $response = $koiber->deleteCannel($post['id']);
    }
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Excluir Canal</title>
    </head>
    <body>
        <h1>Excluir Canal</h1>
        <a href="./">Voltar</a><br><br>
        
        <form method="POST" action="">
            <label>ID do Canal</label>
            <input type="text" name="id" size="30">
            <input type="submit" value="excluir">
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