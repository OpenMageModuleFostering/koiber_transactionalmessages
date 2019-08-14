    <?php    
    require '../src/Koiber/Autoload.php';
    require 'config.php';
    $id = null;
    $post = filter_input_array(INPUT_POST);
    if($post) {
        $id = $post['id'];
    }
    
    $koiber = new Koiber(API_KEY);
    $response = $koiber->getCannel($id);
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Buscar Canal</title>
    </head>
    <body>
        <h1>Buscar Canal</h1>
        <a href="./">Voltar</a><br><br>
        
        <form method="POST" action="">
            <label>ID canal</label>
            <input type="text" name="id" value="<?php echo $id; ?>" size="30">
            <input type="submit" value="buscar">
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