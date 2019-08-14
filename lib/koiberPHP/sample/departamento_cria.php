    <?php    
    require '../src/Koiber/Autoload.php';
    require 'config.php';

    $post = filter_input_array(INPUT_POST);
    if($post && isset($post['name'])) {
        $koiber = new Koiber(API_KEY);
        $response = $koiber->createDepartment($post['name']);
    }
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Criar Departamento</title>
    </head>
    <body>
        <h1>Criar Departamento</h1>
        <a href="./">Voltar</a><br><br>
        
        <form method="POST" action="">
            <label>Nome do departamento</label>
            <input type="text" name="name" size="30">
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