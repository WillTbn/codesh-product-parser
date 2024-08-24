
# Codesh Product Parser

Este projeto foi criado utilizando Laravel Sail, uma stack que tenho utilizado em meus últimos projetos devido à sua facilidade de configuração e integração com Docker. Este guia irá orientá-lo no setup do ambiente de desenvolvimento, focado em ambiente linux/ubuntu/WSL2.

## Pré-requisitos

- Docker Desktop instalado e em execução (**opcional**)
- Composer instalado para gerenciar dependências do PHP(**obrigatório se não usar o docker**)
- PHP 8.2(minimo) / Laravel 11x

## Tecnologias Utilizadas
- MySQL: escolir por ter maior familiaridade e conforto na configuração, mas utilizei Repository com DTO, para possivelmente integrar outros se necessario, ou até mesmo leva codigo para outra patlaforma.
- Mailpit: só por custumer e teste locais de e-mail, como redefine senha.

## Instalação
- Se assim como eu deseja portas personalizadas para seu mysql e laravel, altere no .env os arquivos a seguir:
```
# portas de configurações para o docker-composer.yml,
# troque aqui se quiser portas especificas ex.:
APP_PORT=8085
FORWARD_DB_PORT=3325

```

- Se deseja roda com sail utilize o comando a seguir:
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
_REF: https://laravel.com/docs/11.x/sail#executing-composer-commands_

- CONTINUA


## Processo Investigativo

Analisando os pre-requisitos DESIGN PARTTERNS, SOLID e DDD, e a citação inicial do uso do banco MongoDB, tomei a desição de usar a seguinte estrutura no laravel:

- Services: Para cada funcionalidade da aplicação, por exemplo, Service/Product/CreateProductService.php. Isso promove a responsabilidade única, podendo ser utilizado tanto no Controller quanto nos schedules de CRONJOB, que são necessários neste projeto.

- Repository: Para isolar a configuração da comunicação com o banco de dados, aplicando interfaces para garantir que os métodos sejam os mesmos. Caso decidamos mudar o banco de dados, como para o MongoDB, basta criar um repository específico e fazer as devidas adaptações.

- DTOs: Para tratar de forma unificada as entradas de dados, independentemente do Laravel, proporcionando mais flexibilidade ao código.

- CONTINUA
