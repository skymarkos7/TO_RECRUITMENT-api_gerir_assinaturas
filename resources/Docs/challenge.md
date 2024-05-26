# Desafio Signatures

Desenvolvimento de uma API para cobrar assinaturas de seus users em **PHP**

## Deverá conter
**Users**: ID, Codigo, name, mail e phone

**Signatures**: ID, User, Descrição, Valor

**Invoices**: ID, User, Signature, Descrição, Vencimento, Valor.

## Instruções 🌄

1. Faça um fork do projeto para sua conta pessoal
2. Crie uma branch com o padrão: `desafio-seu-name`
3. Submeta seu código criando um Pull Request
4. Estão faltando alguns campos propositalmente, você deve criá-los

## Como o Sistema Deve Funcionar ⚙️
 - Deve possuir um CRUD Listagem/Inclusão/Edição/Exclusão de Users
 - Deve possuir um CRUD Listagem/Inclusão/Edição/Exclusão de Signatures
 - Deve possuir um CRUD Listagem/Inclusão/Edição/Exclusão de Invoices
 - Deve possuir uma Task que verifica uma vez ao dia todas as assinaturas que vencem daqui a 10 dias e converta elas em invoices.
 - A Task não pode converter invoices já convertidas hoje.
 
## Você deve 🧯
- Utilizar composer
- Utilizar qualquer Framework PHP. Caso opte por não utilizar, desenvolver nos padrões de projeto MVC.
- Utilizar o Postman para documentar a API. Exporte a documentação junto ao projeto na pasta docs.

## Não esqueça de 📆
- Criar as Migrations
- Criar os Seeds

## Pontos Extras ⏭️
- Criar os casos de testes utilizando PHPUnit
- Criar o frontend em um projeto separado com o framework de sua preferência.
