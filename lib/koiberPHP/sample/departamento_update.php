    <?php    
    require '../src/Koiber/Autoload.php';
    require 'config.php';

    $post = filter_input_array(INPUT_POST);
    $id = null;
    $name = null;
    if($post && isset($post['name'])) {
        $koiber = new Koiber(API_KEY);
        $id = $post['id'];
        $name = $post['name'];
        $response = $koiber->updateDepartment($id, $name);
    }
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Atualizar Departamento</title>
    </head>
    <body>
        <h1>Atualizar Departamento</h1>
        <a href="./">Voltar</a><br><br>
        
        <form method="POST" action="">
            <label>ID do departamento</label><br>
            <input type="text" name="id" value="<?php echo $id; ?>" size="50"><br><br>
            <label>Nome do departamento</label><br>
            <input type="text" name="name" value="<?php echo $name; ?>" size="50"><br><br>
            <input type="submit" value="atualizar">
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