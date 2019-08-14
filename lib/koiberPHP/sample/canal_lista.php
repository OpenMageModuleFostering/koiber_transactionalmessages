    <?php
    require '../src/Koiber/Autoload.php';
    require 'config.php';
    
    $koiber = new Koiber(API_KEY);
    $response = $koiber->getCannels();
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Listar Canais</title>
    </head>
    <body>
        <h1>Canais Canais</h1>
        <a href="./">Voltar</a><br><br>
        
        <h2>Resultado</h2>
        <p><strong>STATUS: </strong> <?php echo $response->getResponseCode(); ?> - <?php echo $response->isOk(); ?></p>
        
        <div style="max-height: 630px; overflow: auto; padding: 10px; border: 1px solid #ddd;">
            <pre><?php print_r(json_decode($response->getBody(), true));?></pre>
        </div>
    </body>
</html>