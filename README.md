# api-laravel

Código-fonte dos estudos de criação de uma API REST utlizando Laravel 10.

## Como utilizar

### Configuração da conexão com o banco de dados

Copie o arquivo .env.example, renomeando-o para .env e configure seu banco de dados. Segue um exemplo caso você esteja utilizando MySQL:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api-laravel
DB_USERNAME=root
DB_PASSWORD=123456!@
```

Lembre-se de alterar os valores do host, database, username e password de acordo com sua instalação.

### Endpoints da API

Após executar o projeto, serão disponibilizadas as URLs listadas abaixo. Para facilitar, vou manter como "http://127.0.0.1:8000", mas fique à vontade para alterar de acordo com sua configuração.

### Endpoints de Usuários
1- Retornar todos os usuários
```
http://127.0.0.1:8000/api/v1/users
```

2- Retornar um usuário (por ID)
```
http://127.0.0.1:8000/api/v1/users/1
```

### Endpoints de Pagamentos
1- Retornar todos os pagamentos
```
http://127.0.0.1:8000/api/v1/invoices
```

2- Retornar todos os pagamentos (com filtros)
```
http://127.0.0.1:8000/api/v1/invoices?paid[eq]=1&type[in]=[C,B]&value[gte]=9000
```

3- Retornar um pagamento (por ID)
```
http://127.0.0.1:8000/api/v1/invoices/1
```

4- Inserir um pagamento
```
http://127.0.0.1:8000/api/v1/invoices
```

```
// Exemplo do corpo da requisição
{
	"user_id": 2,
	"type": "P",
	"paid": 1,
	"value": 100.58
}
```

5- Atualizar um pagamento (por ID)
http://127.0.0.1:8000/api/v1/invoices/1
```
// Exemplo do corpo da requisição
{
	"user_id": 2,
	"type": "C",
	"paid": 1,
	"value": 1011.58,
	"payment_date": "2024-01-01 03:06:41"
}
```

6- Excluir um pagamento (por ID)
```
http://127.0.0.1:8000/api/v1/invoices/99
```

Link da playlist dos vídeos (Clube Full-Stack): https://www.youtube.com/watch?v=9k5pJq3Oz8o&list=PLyugqHiq-SKdFqLIM3HgCAnG8_7wUqHMm&index=1