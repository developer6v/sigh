# 🏥 SIGH - Sistema Integrado de Gestão Hospitalar

Este projeto é um sistema web desenvolvido em **Laravel** com o objetivo de gerenciar consultas médicas, diagnósticos e relatórios entre **gestores (médicos)** e **clientes (pacientes)**.

---

## 🚀 Tecnologias

- [Laravel 12.x](https://laravel.com/)
- [PHP 8.3+](https://www.php.net/)
- [SQLite](https://www.sqlite.org/) (ou MySQL)
- [TailwindCSS](https://tailwindcss.com/)
- [Vite](https://vitejs.dev/)

---

## ⚙️ Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/seuusuario/sigh.git
cd sigh
```

### 2. Instale as dependências do PHP e do Node

```bash
composer install
npm install && npm run build
```

### 3. Configure o arquivo `.env`

Crie o arquivo `.env` com base no `.env.example`:

```bash
cp .env.example .env
```

Edite o `.env` e configure:

```env
APP_NAME="SIGH - Sistema Integrado de Gestão Hospitalar"
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

> 💡 Se o arquivo `database/database.sqlite` não existir, crie-o manualmente:
> ```bash
> mkdir -p database
> touch database/database.sqlite
> ```

### 4. Gere a chave da aplicação

```bash
php artisan key:generate
```

### 5. Execute as migrações e seeds

```bash
php artisan migrate --seed
```

> Isso cria as tabelas e popula o banco com **usuários de exemplo**:
>
> - 👨‍⚕️ **Gestor (Médico)**
>   - Email: `gestor@demo.com`
>   - Senha: `password`
>
> - 👤 **Cliente (Paciente)**
>   - Email: `cliente@demo.com`
>   - Senha: `password`

---

## ▶️ Executando o projeto

```bash
php artisan serve
```

Acesse:  
👉 **[http://localhost:8000](http://localhost:8000)**

---

## 🔐 Login e Registro

| Função | URL | Descrição |
|--------|-----|-----------|
| Login Cliente | `/login/cliente` | Acesso do paciente |
| Login Gestor | `/login/gestor` | Acesso do médico |
| Registrar Cliente | `/register/cliente` | Criação de conta de paciente |
| Registrar Gestor | `/register/gestor` | Criação de conta de médico |

---

## 🩺 Funcionalidades

### 👤 Cliente (Paciente)
- Visualiza e agenda consultas;
- Lista suas consultas e status;
- Cancela ou verifica agendamentos futuros.

### 👨‍⚕️ Gestor (Médico)
- Visualiza todas as consultas;
- Atualiza status das consultas (Agendada, Concluída, Cancelada);
- Lança diagnósticos para cada paciente;
- Gera relatórios de consultas por paciente.

---

## 🧱 Estrutura de Pastas Importante

```
app/
 ├── Http/
 │   ├── Controllers/
 │   │   ├── Auth/
 │   │   │   ├── ClienteLoginController.php
 │   │   │   ├── GestorLoginController.php
 │   │   │   ├── RegisterClienteController.php
 │   │   │   └── RegisterGestorController.php
 │   │   ├── AppointmentController.php
 │   │   ├── DiagnosisController.php
 │   │   ├── ReportController.php
 │   │   └── ProfileController.php
 │   └── Middleware/
 │       ├── GestorMiddleware.php
 │       └── ClienteMiddleware.php
 ├── Models/
 │   ├── User.php
 │   ├── Appointment.php
 │   └── Diagnosis.php
resources/
 ├── views/
 │   ├── auth/
 │   ├── appointments/
 │   ├── diagnoses/
 │   ├── reports/
 │   └── layouts/
 └── css/, js/ (frontend)
```

---

## 🧠 Notas de Uso

- O layout muda automaticamente conforme o tipo de usuário (`gestor` ou `cliente`);
- O sistema utiliza **middleware** para proteger as rotas de cada perfil;
- As seeds iniciais já incluem relacionamentos entre médicos e pacientes;
- O campo `role` na tabela `users` define o tipo de usuário.

---

## 🧰 Comandos Úteis

| Ação | Comando |
|------|----------|
| Limpar cache da aplicação | `php artisan optimize:clear` |
| Recriar banco e seeds | `php artisan migrate:fresh --seed` |
| Compilar assets | `npm run build` |
| Rodar servidor local | `php artisan serve` |

---

## 📷 Preview

### Tela de Consultas do Paciente
![Minhas Consultas (Paciente)](docs/screenshot-consultas.png)

---

## 🧾 Licença

Este projeto é de uso educacional e está sob a licença MIT.

---

**Desenvolvido com ❤️ usando Laravel**
