# Projeto Estoque

Este projeto é um sistema de gerenciamento de estoque desenvolvido em Laravel e Vue.js. Ele permite a administração de produtos, controle de entrada e saída, além de outras funcionalidades essenciais para o gerenciamento de um estoque.

## Tecnologias Utilizadas

- **Back-end:** PHP 8+, Laravel
- **Banco de Dados:** MySQL/MariaDB
- **Front-end:** Vue.js, Bootstrap
- **Gerenciador de Pacotes:** Composer, NPM
- **Controle de Versão:** Git/GitHub

## Requisitos

Antes de instalar e rodar o projeto, certifique-se de ter os seguintes requisitos instalados:

- PHP 8+
- Composer
- Node.js e NPM
- MySQL ou MariaDB
- Laravel 9+
- Git
- Docker (opcional, caso queira rodar o projeto em contêineres)

## Instalação

Siga os passos abaixo para instalar e rodar o projeto:

### 1. Clone o repositório
```bash
git clone https://github.com/MiguelPoleto/Projeto-Estoque.git
cd Projeto-Estoque
```

### 2. Instale as dependências do Laravel
```bash
composer install
```

### 3. Instale as dependências do front-end
```bash
npm install
```

### 4. Configure o arquivo `.env`

Copie o arquivo de exemplo e configure as variáveis de ambiente:
```bash
cp .env.example .env
```
Abra o arquivo `.env` e configure as credenciais do banco de dados:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Gere a chave do aplicativo
```bash
php artisan key:generate
```

### 6. Execute as migrações e seeders
```bash
php artisan migrate --seed
```
Isso criará as tabelas no banco de dados e adicionará alguns dados iniciais.

### 7. Inicie o servidor Laravel
```bash
php artisan serve
```
O servidor estará rodando em `http://127.0.0.1:8000`.

### 8. Compilar os assets do front-end
```bash
npm run dev
```
Caso queira gerar os arquivos otimizados para produção:
```bash
npm run build
```

## Funcionalidades Principais

- Cadastro, edição e remoção de produtos
- Controle de entrada e saída de estoque
- Dashboard com informações essenciais
- Relatórios sobre movimentação de produtos
- Autenticação de usuários e controle de permissões

## Estrutura do Projeto

```
Projeto-Estoque/
├── app/                # Lógica do back-end (Laravel)
├── bootstrap/          # Inicialização do framework
├── config/             # Configurações do sistema
├── database/           # Migrations e seeders
├── public/             # Arquivos públicos
├── resources/          # Views e assets do front-end
├── routes/             # Definição de rotas
├── storage/            # Arquivos temporários e logs
├── .env.example        # Modelo de configuração do ambiente
├── composer.json       # Dependências do PHP
├── package.json        # Dependências do JavaScript
├── webpack.mix.js      # Configuração do Laravel Mix
```

## Docker (Opcional)

Se preferir rodar o projeto usando Docker, siga os passos:

```bash
docker-compose up -d --build
```
Isso inicializará os serviços necessários, incluindo um container para o Laravel e outro para o banco de dados.

## Contribuição

Caso queira contribuir com o projeto:
1. Faça um fork do repositório.
2. Crie uma branch com sua feature (`git checkout -b minha-feature`).
3. Faça commit das suas mudanças (`git commit -m 'Adicionei uma nova feature'`).
4. Envie para o repositório (`git push origin minha-feature`).
5. Abra um Pull Request.

## Contato

Caso tenha dúvidas ou sugestões, entre em contato:
- GitHub: [MiguelPoleto](https://github.com/MiguelPoleto)
- LinkedIn: [miguelpoleto](https://www.linkedin.com/in/miguelpoleto/)
- E-mail: *miguelpoleto5@gmail.com*
- Instagram: [@miguelsantuchi](https://www.instagram.com/miguelsantuchi/)



