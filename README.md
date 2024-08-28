
# Codesh Product Parser

Este projeto foi criado utilizando Laravel Sail, uma stack que tenho utilizado em meus últimos projetos devido à sua facilidade de configuração e integração com Docker. Este guia irá orientá-lo no setup do ambiente de desenvolvimento, focado em ambiente linux/ubuntu/WSL2.

## Pré- requisitos

- Docker Desktop instalado e em execução (**opcional**)
- Composer instalado para gerenciar dependências do PHP(**obrigatório se não usar o docker**)
- PHP 8.2(minimo) / Laravel 11x

## Tecnologias utilizadas

- MySQL: escolhe por ter maior familiaridade e conforto na configuração, mas utilizei Repository com DTO, para possivelmente integrar outros se necessario, ou até mesmo leva codigo para outra patlaforma;
- Mailpit: para testa disparo de e-mail quando tem falha no CRON em ambiente de desenvolvimento;
- Laravel 11x;
- Laravel Sactum;

## Instalação

- Como todo projeto laravel, logo apos clona repositorio copia env.exemple para .env

```
cp env.example .env
```

- Se deseja portas personalizadas para seu mysql e laravel, altere no .env os arquivos a seguir:

```
# portas de configurações para o docker-composer.yml,
# troque aqui se quiser portas especificas ex.:
APP_PORT=8085
FORWARD_DB_PORT=3325

```

- User o comando a seguir para cria os container junto com tudo que precisamos:
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
_REF: https://laravel.com/docs/11.x/sail#executing-composer-commands_

 - Apos sube nosso container voce pode tando roda o "docker compose up -d" como o "./vendor/bin/sail up -d" eu uso o sail pois criei um alias, veja com no link: https://laravel.com/docs/11.x/sail#configuring-a-shell-alias.

  - Proximo passo é roda nossa migration, aqui eu criei uma migration para popular usuário padrão, assim evitamos roda seed, uma vez que a arquitetura não pede inicalmente. Olhe as variaveis ADMIN_EMAIL e ADMIN_PASSWORD, use as para se autentica na api.

  ```
  sail art migrate
  ``` 

Pronto agora é só se diverte.
    
## Documentação
 | todo processo investigativo

**- inicio**

Para chegar o mais próximo possível do Design Patterns com S.O.L.I.D e DDD, conforme solicitado no enunciado, utilizei services, repositories e DTOs para auxiliar nessa tarefa.

**import produtos**

No coração da nossa aplicação, que é a importação de dados da Open Food Facts, criei três services para lidar com esse desafio, cada um com uma função específica. O principal, o ImportOFFService, ficou com a tarefa, ao meu ver, mais pesada: abrir o arquivo .gz e processá-lo linha por linha. Utilize a técnica de buffer para armazenar as informações até que o JSON esteja completo, e então apliquei o json_decode() para podermos trabalhar com os dados na nossa classe de objeto SetOFFService. Com a classe montada, passamos para o CreateProductService, onde o armazenamento no banco de dados acontece. Acredito que essa classe ainda pode ser melhorada.

**- semantica - escrita**

Para melhorar a leitura do código, abreviei Open Food Facts para OFF nos nomes dos services.

**- authentificação**

Em seguida, parti para a autenticação da API com o Sanctum, que tem se mostrado uma biblioteca cada vez mais completa para o Laravel. Apesar de ser um recurso extra, achei melhor implementá-lo desde o início, pois testar e implementar com a autenticação pronta seria mais rápido do que fazer tudo no final.

**-persistencia de dados default**

Optei por criar uma migration em vez de uma seed para criar o usuário administrativo, por se tratar de algo não genérico, até mesmo em ambiente de teste.

**-test**

Configurei também o ambiente de teste para evitar que os testes afetassem o banco de dados real. Veja meu arquivo phpunit.xml.

Realizei testes em todas as rotas da aplicação, embora não tenha realizado testes de falha devido ao tempo limitado. No entanto, após os testes, validei cada rota com o Postman.

**-finalização**

Durante esses testes, busquei tornar a aplicação o mais escalável possível e seguir à risca os princípios de Design Patterns com S.O.L.I.D. Não me atentei muito a detalhes como o gerenciamento de trash. Acredito que poderia ter implementado o modelo com softDeletes, para ao alterar o status de um item para trash, também fosse adicionada a data de exclusão em deleted_at. Outras funcionalidades também poderiam ser melhoradas, mas como isso não estava explicitado no enunciado, em um cenário de equipe ou relação de trabalho abordaria esses pontos com time ou responsavel por cada cenario.

**-documentação open API 3.0**

Comecei mais não terei tempo para finalizar infelizmente.

**consideração final**

Obrigado pela seleção para participar desse teste, oque mais gosto na programação e essa superação a cada novo projeto que temos que realizar e essa aqui deu para trabalha bem minhas abilidades e evoluir.

## Extra

**Diferencial 2** usei docker com sail no laravel

**Diferencial 3** chamei o ->emailOutputOnFailure() para dispara quando falha o erro por e-mail, para ver o erro acontece, procure "PROVOQUE ERRO COMENTANDO" e comenta a linha logo abaixo, disparo o cron e vá na porta localhost:8025 para ver o e-mail pelo mailpit.

**Diferencial 4** iniciei esta incompleto.

**Diferencial 5** fiz teste de todas as routas.

**Diferencial 5** usei em todas url's laravel sactum para autentificação.

