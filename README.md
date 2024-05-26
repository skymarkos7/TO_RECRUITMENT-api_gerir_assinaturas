## Oque você verá aqui? 🎥 👀
- ✅ CRUD no banco de dados com [mysql](https://www.mysql.com/)
- ✅ Criação das tabelas por migration.
- ✅ População das tabelas por seeder.
- ✅ Requisições a api laravel seguindo as regras para uma [api restful](https://www.dio.me/articles/entendendo-as-diferencas-entre-apis-rest-e-restful)
- ✅ job assincrono definido para ser executado 1 vez ao dia
- ✅ Uma [collection](docs/desafio-api-de-assinaturas-jobs-assincrôno.postman_collection.json) para acionar as rotas ou um [front em vue.js](https://github.com/skymarkos7/TO_RECRUITMENT-front_gerir_assinaturas-) para integragir com a api.
- ✅ Unit test - [testes de feature](tests/Feature/AssinaturaTest.php) aplicado as regras da api.
- ✅ Querys montadas com [eloquent](https://laravel.com/docs/11.x/eloquent) para facilitar a troca de banco.



## Rodar o projeto ⚡
1. Clone o projeto com `git clone`  
2. Adicione as dependencias do projeto com `composer install`
3. Com servidor de banco de dados rodando e configurado execute o comando  `php artisan migrate`  para rodar migrations.
    - OBS: Para essa api foi utilizado o banco de dados MYSQL entretanto é possível utilizar outros bancos, bastanto configurar o arquivo [.env](.env)
4. Popule as tabelas executando as seeds a baixo:
    1. `php artisan db:seed --class=UserSeeder`
    2. `php artisan db:seed --class=AssinaturaSeeder`
    3. `php artisan db:seed --class=FaturaSeeder`
    
5. Execute o servidor de API com `php artisan serve`   

## Task que converte assinatura com vencimento igual ou inferior a 10 dias em fatura  ⏳🕐
- Listar as tasks que podem ser agendadas `php artisan schedule:list`
- Iniciar o trabalho das tasks `php artisan schedule:work`
- Executar diretamente o command da task para testes `php artisan app:verificar-assinaturas`

## Rodar cenários de testes 🧑‍🔬🧪
 - Rodar todos os testes `php artisan test`

 - Rodar um cenário específico, exemplo: `php artisan test --filter test_donnot_creating_a_new_fatura_without_a_required_field`

## Front-end para mostrar informações do projeto 🖥️ 🌅
Siga as instruções no [reposiório](https://github.com/skymarkos7/front-assinatura-marcos-lourenco-desafio): `https://github.com/skymarkos7/front-assinatura-marcos-lourenco-desafio`

## Collection para o postman 🧑‍🚀
A colleciton está na pasta [docs](docs/desafio-api-de-assinaturas-jobs-assincrôno.postman_collection.json)

Na mesma pasta deixei um arquivo [swagger](docs/swagger.yaml) para uma conferência visual das rotas, fique a vontade para visualizar colando o conteúdo do arquivo no editor online [swagger.editor](https://editor.swagger.io/)


## Diretrizes do projeto 👨‍⚖️
 Para ver tudo que foi solicitado nesse projeto-desafio abra o arquivo [challenge](resources/Docs/challenge.md)


# Autor 
[Marcos Lourenço](https://www.linkedin.com/in/skymarkos7/)  
**FullStack developer**  
[(82) 996909200](https://wa.me/82996909200)
