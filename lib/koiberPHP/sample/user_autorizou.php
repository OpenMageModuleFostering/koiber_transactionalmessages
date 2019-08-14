    <?php    
    require '../src/Koiber/Autoload.php';
    require 'config.php';
    $dado = null;
    $get = false;
    $post = filter_input_array(INPUT_POST);
    if($post) {
        $dado = $post['dado'];
        $get = $post['get'];
        $koiber = new Koiber(API_KEY);
        $response = $koiber->userIsAuthorized($dado, $get);
    }
    
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Verifica se usuário autorizou a empresa</title>
    </head>
    <body>
        <h1>Verifica se usuário autorizou a empresa</h1>
        <a href="./">Voltar</a><br><br>
        
        <form method="POST" action="">
            <label>Trazer dados?</label><br>
            <select name="get">
                <option value="true">SIM</option>
                <option value="false"<?php echo ($get == 'false' ? ' selected' : ''); ?>>Não</option>
            </select><br><br>
            
            <label>Telefone ou e-mail</label><br>
            <input type="text" name="dado" value="<?php echo $dado; ?>" size="50"><br><br>
            <input type="submit" value="Verificar">
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