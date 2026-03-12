---
name: markdown-repo-generator
description: "Generates detailed English Markdown documentation for code repositories, including installation, configuration, database setup, endpoints, execution instructions, and tests. Activates when users request markdown documentation, README generation, or project setup instructions."
license: MIT
metadata:
  author: opencode
---

# Markdown Repository Generator

## When to Apply

Activate this skill when:

- Users request markdown documentation for a repository
- Generating README.md or setup instructions
- Creating project documentation in English
- Writing technical documentation for APIs or systems

## Documentation Structure

The generated markdown must include these sections:

1. **Installation**: Steps to install and run the system.
2. **Configuration**: Required environment variables.
3. **Database**: How to execute migrations.
4. **Endpoints**: List of available endpoints.
5. **Execution**: How to start the server.
6. **Tests**: How to run tests (if they exist).

## Basic Usage

### Markdown Generation Process

1. Analyze the project structure (composer.json, package.json, etc.)
2. Identify the technology stack (Laravel, Node.js, Python, etc.)
3. Check for existing documentation
4. Generate comprehensive markdown with the required sections

### Required Sections

#### 1. Installation
- Prerequisites (PHP version, Node.js version, etc.)
- Clone repository
- Install dependencies (composer install, npm install, etc.)
- Copy environment file
- Set up environment variables

#### 2. Configuration
- List required environment variables
- Example `.env` configuration
- Database credentials
- API keys if applicable

#### 3. Database
- How to run migrations
- How to seed database
- Database requirements (MySQL, PostgreSQL, SQLite)

#### 4. Endpoints
- List all available API endpoints
- Include HTTP method, path, description
- Example request/response if applicable

#### 5. Execution
- How to start the development server
- How to run in production
- Port configuration

#### 6. Tests
- How to run test suites
- Test coverage if available
- Testing tools used (PHPUnit, Pest, Jest, etc.)

## Code Examples

### Installation Example

```bash
# Clone the repository
git clone https://github.com/username/repository.git
cd repository

# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Configuration Example

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### Database Migration Example

```bash
# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed
```

### Endpoints Example

```markdown
| Method | Path | Description |
|--------|------|-------------|
| GET | /api/users | List all users |
| POST | /api/users | Create a new user |
| GET | /api/users/{id} | Get user by ID |
| PUT | /api/users/{id} | Update user |
| DELETE | /api/users/{id} | Delete user |
```

### Execution Example

```bash
# Start development server
php artisan serve

# Or with Laravel Sail
./vendor/bin/sail up
```

### Tests Example

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=ExampleTest
```

## Best Practices

1. **Language**: Always generate documentation in English
2. **Clarity**: Use clear, concise language
3. **Completeness**: Include all required sections
4. **Examples**: Provide code examples where applicable
5. **Consistency**: Follow existing documentation patterns

## Common Pitfalls

- Forgetting to include all required sections
- Not providing code examples for commands
- Using non-English language
- Missing environment variable examples
- Not checking for existing documentation first

## Integration with OpenCode

This skill works with OpenCode's CLI to generate markdown files directly in repositories. The generated documentation should be saved as `README.md` or `SETUP.md` in the repository root.
