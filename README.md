## Rodar o projeto
- Clone o projeto com `git clone`  
- Adicione as dependencias do projeto com `composer install`
- Com servidor de banco de dados rodando e configurado execute as migrations com `php artisan migrate`
- Popule as tabelas executando as seeds a baixo:
    - `php artisan db:seed --class=CadastroSeeder`
    - `php artisan db:seed --class=AssinaturaSeeder`
    - `php artisan db:seed --class=FaturaSeeder`
- Execute o servidor de API com `php artisan serve`   

## Task que converte assinatura com vencimento igual ou inferior a 10 dias em fatura
- Listar as tasks que podem ser agendadas `php artisan schedule:list`
- Iniciar o trabalho das tasks `php artisan schedule:work`
- Executar diretamente o command da task para testes `php artisan app:verificar-assinaturas`

## Rodar cenários de testes
 - Rodar todos os testes `php artisan test`

 - Rodar um cenário específico, exemplo: `php artisan test --filter test_donnot_creating_a_new_fatura_without_a_required_field`

## Front-end para mostrar informações do projeto
Siga as instruções no [reposiório](https://github.com/skymarkos7/front-assinatura-marcos-lourenco-desafio): `https://github.com/skymarkos7/front-assinatura-marcos-lourenco-desafio`

## Collection para o postman
A colleciton está na pasta [docs](docs\desafio-api-de-assinaturas-jobs-assincrôno.postman_collection.json)

Na mesma pasta deixei um arquivo [swagger](docs\swagger.yaml) para uma conferência visual das rotas, fique a vontade para visualizar colando o conteúdo do arquivo no editor online [swagger.editor](https://editor.swagger.io/)


## Diretrizes do projeto
 Para ver tudo que foi solicitado nesse projeto-desafio abra o arquivo [challenge.md](resources\Docs\challenge.md)
