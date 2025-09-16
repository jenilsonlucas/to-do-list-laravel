<h1 align="center">TO DO LIST</h1>

## SOBRE APLICAÇÃO

Desenvolvi um projeto de gerenciamento de tarefas com foco em usabilidade, escalabilidade e boas práticas de desenvolvimento.

O sistema permite que os usuários criem listas de tarefas personalizadas, nas quais podem adicionar, editar, excluir e visualizar tarefas em tempo real. Para garantir uma experiência fluida e eficiente, utilizei as seguintes tecnologias:

- Frontend: HTML, CSS e Blade (Laravel) para criação de interfaces dinâmicas e bem estruturadas.
- Backend: Laravel para implementação da lógica de negócio, organização de camadas e integração com banco de dados.
- Funcionalidades dinâmicas: JavaScript (Vanilla) para manipulação em tempo real da interface e atualização instantânea das tarefas.
- Autenticação: Integração com OAuth 2.0 do Google, permitindo que os usuários realizem cadastro e login de forma rápida e segura utilizando suas contas Google.

Além disso, implementei recursos avançados do ecossistema Laravel, como:

- Jobs, Eventos e Listeners: para processar tarefas assíncronas e manter a aplicação performática.
- Factories, Migrations e Seeders: para garantir a consistência e facilidade na criação e manutenção do banco de dados.
- Middleware: para controle de acesso e segurança nas rotas da aplicação.
- Padrão Adapter: para integração com a API do Google, garantindo desacoplamento da regra de negócio.
- Testes automatizados: implementados com o framework de testes do Laravel, garantindo confiabilidade e qualidade contínua do sistema.
- CI (Integração Contínua): configuração de pipeline no GitHub Actions, permitindo que os testes sejam executados automaticamente a cada push ou pull request, garantindo qualidade do código e evitando regressões.

Também apliquei princípios de boas práticas de arquitetura, como o uso do padrão Adapter para integração com APIs externas (neste caso, a API do Google). Isso permite flexibilidade para futuras alterações sem impactar diretamente a regra de negócio.

<h4>Destaques técnicos</h4>

- Aplicação full stack com Laravel no backend e JavaScript Vanilla no frontend.
- Arquitetura escalável, focada em boas práticas de manutenção e evolução do código.
- Segurança com autenticação integrada ao Google.
- Cobertura de testes e integração contínua para garantir robustez e qualidade de entrega.

Esse projeto demonstra experiência em desenvolvimento full stack com Laravel, integração com serviços externos, implementação de autenticação segura e aplicação de padrões de design, sempre visando escalabilidade e manutenção do código.

<h4>Arquivos para veres</h4>

- /app/Events/

- /app/Http/Controllers/

- /app/Http/Controllers/Auth/

- /app/Jobs/

- /app/Listeners/

- /app/Mail/

- /app/Models/

- /app/Providers/

- /routes/

- /resources/

- /public/

- /tests/feature/

Analíse cada arquivo destes directórios para poderes entender bem como funcionan o projecto

## INSTALAÇÃO DO PROJECTO

Para fazer a instalação do projeto, é necessário ter alguns softwares instalados no seu sistema operacional para que ele funcione corretamente. Eu deixarei os links para cada ferramenta.

Baixe de acordo com o seu sistema operacional (no meu caso, utilizei Linux).

- [GIT](https://git-scm.com/downloads).
- [COMPOSER](https://getcomposer.org/download/)
- [PHP](https://www.php.net/downloads.php)
- [POSTGRES](https://www.postgresql.org/download/) caso utilizes o banco de dados que utilizei.

Agora, para continuar:

1. Baixe o código do repositório. Abra o terminal e rode: **git clone https://github.com/jenilsonlucas/to-do-list-laravel.git**
2. Entre na pasta to-do-list-laravel. **cd to-do-list-laravel**
3. Copie o arquivo .env.example para .env e faça as configurações de acordo com o seu ambiente. **cp .env.example .env**
4. No terminal, rode o seguinte comando: **composer install  && php artisan key:generate && php artisan migrate**

A aplicação possui integração com a API do Google para login com conta Google.
Para que funcione corretamente, configure as credenciais da API (Client ID e Client Secret) no arquivo .env.

E entre no arquivo config/services.php e configure de acordo as tuas credencias do google 
para sabares mais vai em: **https://laravel.com/docs/12.x/socialite**

5. Para iniciar aplicação localmente, rode: **php artisan serve**

## AMBIENTE DE TEST

Esta aplicação possui uma suíte de testes automatizados para garantir a qualidade e o funcionamento correto das funcionalidades.

Para rodar os testes:

1. Abra o arquivo .env.
2. Altere a variável de ambiente APP_ENV para testing. **APP_ENV=testing**
3. No terminal, execute o seguinte comando: **php artisan test**

## PLANEJAMENTO DE CONTINUIDADE

Além das funcionalidades já implementadas, o projeto possui um planejamento de evolução que contempla novas features e integrações para aumentar o valor do sistema e sua escalabilidade:

- Integração com múltiplas APIs de autenticação social: além do Google (já implementado com OAuth 2.0), está previsto o suporte a outras redes sociais, como Facebook, GitHub e LinkedIn, permitindo maior flexibilidade no cadastro e login de usuários.
- Tarefas recorrentes: adição da funcionalidade para criação de tarefas repetitivas, que poderão ser configuradas com base em períodos (diários, semanais, mensais), facilitando o gerenciamento de atividades frequentes.
- Controle de prazos e conclusão: implementação de um sistema de tarefas com deadlines (prazos de horário), permitindo que o usuário defina metas temporais para suas tarefas, com possibilidade de marcar como concluídas e acompanhar o histórico.

Essas melhorias fazem parte do roadmap de desenvolvimento do projeto, reforçando a preocupação com usabilidade, escalabilidade e integração com diferentes serviços externos, além de demonstrar visão de continuidade e amadurecimento do produto.

### AUTOR: JENILSON DOMINGOS DA COSTA LUCAS
**email: jenilsonllucas@gmail.com**
