
# Teste da Paytour - Formulário de Currículo

Este é um projeto PHP criado como parte do processo seletivo da Paytour. A aplicação consiste em um formulário para envio de currículos, com validação de dados, upload de arquivos, armazenamento em banco de dados e notificação por e-mail.

## Funcionalidades

- Formulário de envio de currículo com os campos: Nome, E-mail, Telefone, Cargo Desejado, Escolaridade, Observações e Arquivo.
- Validação completa dos dados no lado do servidor.
- Restrição de upload para arquivos `.pdf`, `.doc`, `.docx` com no máximo 1MB.
- Armazenamento de todos os dados do formulário, mais IP do usuário e data/hora do envio em um banco de dados MySQL.
- Envio de e-mail de notificação com os dados do candidato para um endereço pré-definido.
- Código estruturado com padrão PSR-4.
- Dependências gerenciadas via Composer.
- Testes unitários utilizando PHPUnit.


## Como Configurar e Executar o Projeto

### Pré-requisitos

- PHP >= 7.4
- Composer
- Servidor Web (Apache, Nginx) ou o servidor embutido do PHP
- Banco de dados MySQL ou MariaDB

### 1. Clonar o Repositório

```bash
git clone <https://github.com/pedrodavi120/paytour-test>
cd paytour-test
````

### 2\. Instalar as Dependências

Execute o Composer para instalar as bibliotecas necessárias (PHPMailer, DotEnv, Rakit Validation, PHPUnit).

```bash
composer install
```

### 3\. Configurar o Ambiente

Copie o arquivo de exemplo `.env.example` para um novo arquivo chamado `.env`.

  * **Para Linux/macOS:**
    ```bash
    cp .env.example .env
    ```
  * **Para Windows:**
    ```bash
    copy .env.example .env
    ```

Agora, edite o arquivo `.env` com as suas configurações de banco de dados e servidor de e-mail (SMTP). Para XAMPP, a senha do banco (`DB_PASSWORD`) geralmente é vazia.

```ini
# Configuração do Banco de Dados
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=paytour_test
DB_USERNAME=root
DB_PASSWORD=

# Configuração do E-mail (use um serviço como Mailtrap.io para testes)
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu-usuario
MAIL_PASSWORD=sua-senha
MAIL_FROM_ADDRESS=nao-responda@paytour.com.br
MAIL_FROM_NAME="Formulário de Currículo"
MAIL_TO_ADDRESS=dev@paytour.com.br
```

### 4\. Configurar o Banco de Dados

Crie um banco de dados com o nome que você definiu em `DB_DATABASE`. A forma mais fácil é usar o phpMyAdmin que vem com o XAMPP.

1.  No painel do XAMPP, inicie o **Apache** e o **MySQL**.
2.  Clique no botão **Admin** ao lado do MySQL para abrir o phpMyAdmin.
3.  Crie um novo banco de dados chamado `paytour_test`.
4.  Selecione o banco criado e vá para a aba **Importar** para carregar o arquivo `schema.sql`.

### 5\. Configurar Permissões

Certifique-se de que o servidor web tenha permissão de escrita no diretório `public/uploads`. No Windows, isso geralmente já está configurado.

### 6\. Executar a Aplicação

Use o servidor embutido do PHP. No seu terminal, na pasta raiz do projeto, execute:

```bash
php -S localhost:8000 -t public
```

Acesse `http://localhost:8000` no seu navegador.

### 7\. Executar os Testes Unitários

Para rodar a suíte de testes, execute o PHPUnit:

```bash
./vendor/bin/phpunit
```

## Obrigado pela oportunidade\!
