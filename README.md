# Projeto de Gerenciamento de Transações

## Sobre o Projeto
Este projeto é um sistema para gerenciamento de transações de compras e vendas, permitindo a exibição e manipulação de dados financeiros de forma intuitiva.

## Tecnologias Utilizadas
- **Front-end**:
  - HTML, CSS (com Bootstrap)
  - JavaScript (ES6+)
  - jQuery
  - SweetAlert2

- **Back-end**:
  - PHP com Laravel
  - MySQL/MariaDB
  - Arquitetura MVC

## Estrutura do Projeto

```
├── public/
│   ├── index.html
│   ├── css/
│   │   ├── custom_styles.css
│   ├── js/
│   │   ├── app.js
│   │   ├── services.js
│   ├── assets/
│
├── src/
│   ├── controllers/
│   ├── models/
│   ├── views/
│
├── routes/
│   ├── web.php
│
├── database/
│   ├── migrations/
│
├── README.md
```

## Instalação e Configuração

### 1. Clonar o repositório
```sh
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

### 2. Configurar o Back-end
Certifique-se de ter o Laravel instalado. Caso não tenha:
```sh
composer global require laravel/installer
```
Em seguida, copie o arquivo `.env.example` e configure as variáveis de ambiente:
```sh
cp .env.example .env
php artisan key:generate
```
Atualize o `.env` com as credenciais do banco de dados e rode as migrações:
```sh
php artisan migrate
```

### 3. Rodar o Servidor
```sh
php artisan serve
```
O servidor será iniciado em `http://127.0.0.1:8000`

## Como Funciona
### **API de Compras**
A API possui um endpoint que retorna uma lista de compras:
```sh
GET /transacoes/compras
```
Exemplo de resposta:
```json
[
    { "id": 1, "produto": "Teclado", "quantidade": 2, "preco": 150.00 },
    { "id": 2, "produto": "Mouse", "quantidade": 1, "preco": 75.50 }
]
```

### **Manipulação dos Dados no Front-end**
O arquivo `app.js` realiza a busca e manipula os dados:
```js
const ApiService = {
    async fetchBuys() {
        try {
            const response = await fetch(`transacoes/compras`);
            return await response.json();
        } catch (error) {
            console.error('Erro buscando as compras:', error);
            throw error;
        }
    }
};

document.addEventListener("DOMContentLoaded", async () => {
    const compras = await ApiService.fetchBuys();
    console.log(compras);
});
```

## Melhorias Futuras
- Implementar sistema de autenticação (Login/Registro)
- Criar funcionalidade de vendas
- Melhorar responsividade e design

## Licença
Este projeto está sob a licença MIT. Sinta-se livre para utilizá-lo e modificá-lo conforme necessário.

