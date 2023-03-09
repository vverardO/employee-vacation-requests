## Instalação

O Sistema de Gerenciamento de Férias de Empregados tem como requerimento [Laravel](https://laravel.com/docs/10.x) v10+ and [Laravel - Livewire](https://laravel-livewire.com/docs/2.x/installation) v2+ para rodar normalmente.

Instale as dependencias e inicie o server.

```sh
git clone https://github.com/vverardO/employee-vacation-requests.git
cd employee-vacation-requests
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

## Tests
Para rodar os testes basta executar o seguinte comando no console:

```sh
php artisan test
```

## Acesso
Será necessário acessar o banco e pegar algum email e na sequência abrir a url localhost/login, aplicação é default localhost ou depende da configuração do seu ambiente.

**As senhas geradas via seed são todas "password"**

## Objetivo

Contemplar a seguinte solicitação:

> Olá, busco profissional para construção de uma aplicação WEB a qual possa gerenciar a solicitação de férias de uma  empresa/município. 
Por que empresa município?
Quero deixar a aplicação aberta para que possa atender tanto empresas como prefeituras, o que mudaria seriam as nomenclaturas, exemplo: em vez de unidade, seria secretaria e assim por diante.

O que teríamos na aplicação:

- [X] Gerenciamento de usuários
- [X] Gerenciamento de empresa
- [X] Gerenciamento de funcionários
- [X] Níveis/tipos de usuários
- [ ] Gerenciamento de perfis
- [X] Solicitação de férias
- [X] Gerenciar solicitação
- [X] Aprovações/desaprovações de férias
