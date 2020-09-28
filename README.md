# API - PHP + Slim + Mysql
## Subir o sistema
```make up```

## Derrubar o sitema
``` make down ```

## Ambiente
### O sistema carregará os seguintes Serviços:
- Webserver (PHP) na porta 8001
- Banco de Dados (Mysql) na porta 3306
- PhpMyAdmin na pota 8002


### Tecnologias
- php 7.4
- Slim Framewokr
- Mysql 8

### Autenticação
- jwt

### Configuração
Os arquivos de configuração encontram-se na pasta:

``` App/config ```

## Rotas
### healthcheck
- Url: ```localhost:8001/restwecont/ ```
- Verbo: ```GET```

### Login / Refresh Token
#### Login
O Login adiciona um token para o usuário, com  esse token será possível fazer as requisições para as demais rotas

- Url: ```localhost:8001/restwecont/login ```
- Verbo: ```POST```
- Body Exemplo: (Raw Json) :
```
{
    "email": "usuario01@gmail.com",
    "password": "restwecont"
}

```
-Obs: Quando o sistema sobe ele cria um registro na tabela users com a senha restwecont.  Esta senha é gravada no banco usando o ``` password_hash ``` do PHP, caso queira gerar uma outra senha para testar, use o comando no terminal:
```
make genPass password=restwecont
```
substituindo a string restwecont pela senha nova e grave na tabela ```users``` coluna ```password```

Essa rota não possui autenticação

#### Refresh Token
O Token é criado com 5 dias de validade, caso um token perca a validade essa rota pode ser acionada para reativar o token.  Para isso é usado o RefreshToken
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ```localhost:8001/restwecont/refreshToken ```
- Verbo: ```POST```
- Body Exemplo: (Raw Json) :
```
{
    "refreshToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InVzdWFyaW8wMUBnbWFpbC5jb20iLCJyYW1kb20iOiI1ZjcxNGZhYjA0M2U0In0.39q0Zv7siAWzOeQGtRwVzxNqCbcCZucuthSuVLtSDOs"
}
```


### Usuários
Essas rotas podem ser acessadas por qualquer usuario com token válido

#### Listar usuários:
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ``` localhost:8001/restwecont/user/ ```
- Verbo: ``` GET  ```
- Body Exemplo: (Raw Json) :
```
Vazio
```
- QueryParameters
  - limit:3 (Opcional: Neste caso informa que deve retornar no máximo 3 registros, caso omitido o valor default será 5)
  - page:7 : (Opcional: Neste caso informa que deseja a pagina 7, caso seja omitida o valor default será 1)
  -




#### Visualizar um usuário específico
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ``` localhost:8001/restwecont/user/2  ``` (Neste exemplo retorna o usuário de id 2)
- Verbo: ```GET  ```
- Body Exemplo: (Raw Json) :
```
vazio
```

#### Adicionar um usuário
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ``` localhost:8001/restwecont/user/  ``` (Neste exemplo retorna o usuário de id 2)
- Verbo: ```POST  ```
- Body Exemplo: (Raw Json) :
```
{
    "name" : "joao Oliveira",
    "email": "joao@oliveira.com",
    "password" :"xpto"
}

```

#### Editar um usuario
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ``` localhost:8001/restwecont/user/3  ``` (Neste exemplo altera o usuário de id 3)
- Verbo: ```PUT  ```
- Body Exemplo: (Raw Json) :
```
{
    "password" :"restwecont2" (Neste caso altera a senha)
}

```

#### Remover um usuário
O Sistema não faz remoções físicas, somente lógica, para isso usa o campo situation que pode ser active ou removed
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ``` localhost:8001/restwecont/user/2  ``` (Neste exemplo remove o usuário de id 2)
- Verbo: ```DELETE  ```
- Body Exemplo: (Raw Json) :
```
vazio
```

#### Reativar um usuario
O Sistema não faz remoções físicas, somente lógica, para isso usa o campo situation que pode ser active ou removed
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ``` localhost:8001/restwecont/user/2  ``` (Neste exemplo reativa o usuário de id 2)
- Verbo: ```PUT  ```
- Body Exemplo: (Raw Json) :
```
vazio
```

### Fatura
Essas rotas só podem ser acessadas pelo usuário dono da fatura com token válido

#### Adicionar uma fatura
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ``` localhost:8001/restwecont/invoice/ ```
- Verbo: ```POST  ```
- Body Exemplo: (Raw Json) :
```
{
    "userId" : 2,
    "url": "http://wwww/fatura1.com",
    "expiration" :"2020-10-30"
}
```

#### Listar Faturas
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ``` localhost:8001/restwecont/invoice/ ```
- Verbo: ```GET  ```
- Body Exemplo: (Raw Json) :
```
{
    "userId" : 2,
    "url": "http://wwww/fatura1.com",
    "expiration" :"2020-10-30"
}
```
- QueryParameters
  - limit:3 (Opcional: Neste caso informa que deve retornar no máximo 3 registros, caso omitido o valor default será 5)
  - page:7 : (Opcional: Neste caso informa que deseja a pagina 7, caso seja omitida o valor default será 1)
  -

#### Visualizar uma Fatura especifica
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ``` localhost:8001/restwecont/invoice/1 ```
- Verbo: ```GET  ```
- Body Exemplo: (Raw Json) :
```
vazio
```

#### Editar Fatura
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ``` localhost:8001/restwecont/invoice/1 ```
- Verbo: ```PUT  ```
- Body Exemplo: (Raw Json) :
```
{
    "status" : "Paga"
}
```

#### Remover Fatura
O Sistema não faz remoções físicas, somente lógica, para isso usa o campo situation que pode ser active ou removed
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ``` localhost:8001/restwecont/invoice/2  ``` (Neste exemplo remove a fatura de id 2)
- Verbo: ```DELETE  ```
- Body Exemplo: (Raw Json) :
```
vazio
```


#### Reativar Fatura
O Sistema não faz remoções físicas, somente lógica, para isso usa o campo situation que pode ser active ou removed
- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ``` localhost:8001/restwecont/invoice/2  ``` (Neste exemplo reativa a fatura de id 2)
- Verbo: ```PUT  ```
- Body Exemplo: (Raw Json) :
```
vazio
```




- Autentication:
  - Bearer
  - Token Gerado pelo login ou atualizado pelo refresh
- Url: ```   ```
- Verbo: ```  ```
- Body Exemplo: (Raw Json) :
```
```