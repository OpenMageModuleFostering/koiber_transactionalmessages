# Biblioteca PHP da api do Koiber.com - 1.0

Biblioteca de integração com o [koiber.com](http://www.koiber.com). Acesse a [documentação](http://www.koiber.com/api) da api para saber mais.


## Sobre o koiber
O koiber é um aplicativo de atendimento ao consumidor (SAC) que usa as tecnologias atuais para conectar os clientes às empresas por meio de mensagens instantâneas.

## Instalação
Basta fazer [download da biblioteca ](https://github.com/natan88/koiberPHP/archive/master.zip) e fazer include do arquivo `src/Koiber/Autoload.php`

## Recursos desta versão
- Listar conversas
- Buscar uma conversa específica
- Criar conversa
- Adicionar mensagem a conversa
- Encerrar conversa
- Verificar se a conversa esta encerrada
- Listar usuários
- Buscar um usuário
- Verificar se um usuário portador de um telefone ou e-mail autorizou a empresa

## Credenciais de acesso
Para usar a API ter um TOKEN, o token é gerado no painel da empresa. Para mais informações acesse a [documentação](http://www.koiber.com/api) da api



## Uso básico


```php
<?php
require 'src/Koiber/Autoload.php';
$koiber = new Koiber("API TOKEN");
```

## Lista conversas

```php
<?php
require 'src/Koiber/Autoload.php';
$koiber = new Koiber("API KEY");
$response = $koiber->getTalks();
$talks = $response->getBody();
```


## Buscando uma conversa específica
``` php
<?php
require 'src/Koiber/Autoload.php';
$koiber = new Koiber("API KEY");
$response = $koiber->getTalk("TALK ID");
$talk = $response->getBody();
```


# Usuários


## Listar usuários
``` php
<?php
require 'src/Koiber/Autoload.php';
$koiber = new Koiber("API KEY");
$page = 1;
$per_page = 10;
$response = $koiber->getUsers($page, $per_page);
$talk = $response->getBody();
```

## Buscar um usuário
``` php
<?php
require 'src/Koiber/Autoload.php';
$koiber = new Koiber("API KEY");
$response = $koiber->getUser("USER ID");
$talk = $response->getBody();
```


## Verifica se um usuário autorizou a empresa
``` php
<?php
require 'src/Koiber/Autoload.php';
$koiber = new Koiber("API KEY");
$dado = "";
$retornaDados = true;
$response = $koiber->userIsAuthorized($dado, $retornaDados);
$talk = $response->getBody();
```

**$dado** é o telefone (sem o DDI) ou um e-mail. **$retornaDados** indica se deve retornar os dados do usuário


---

# Retorno



## Checando o status da requisição

Para verificar se a requisição teve sucesso ou falha, basta chamar `$response->isOk()`, se a resposta for **TRUE** a requisição foi válida.

Para verificar o status HTTP da requisição chame `$response->getResponseCode()`.


## Retornando o erro

Se obetem o erro chamando o método `$response->getError()`.


## Corpo da requisição

`$response->getBody()` retorna um json em formato string com a resposta da requisição que pode ser um erro em caso de falha ou a resposta do 

A resposta pode ser convertido para array chamando `$array = json_decode($response->getBody(), true);`



# Licença

Esta biblioteca utiliza a licença [MIT](https://opensource.org/licenses/MIT)
