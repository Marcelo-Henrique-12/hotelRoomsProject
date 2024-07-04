<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## Sobre o sistema

Sistema com uma implementação de autenticação simples do laravel e com  cadastro de hotéis e quartos.

Faça o seu registro ou login caso possua uma conta e cadastre os seus hotéis, para cadastro de um quarto é necessário haver registro de pelo menos um hotel para vincular.

Caso seja necessário para teste, rode o item 10° do passo a passo de instalação abaixo para preenchimento com dados de teste através de seeders e factories para o preenchimento de hotéis e quartos.

Implementado com o laravel 11  e php 8.2, utilizando o Vue.Js e Tailwind CSS para o front-end e conectando o front e back-end através do Inertia.

## Instalação

 - Requisitos:
        PHP >= 8.2
        Composer
        Banco de dados Mysql ou outro suportado pelo Laravel
        Extensões PHP necessárias (geralmente incluídas no Laravel)
        Node.js e npm

 - Passos para instalação:

    1° - Clone o repositório: 
    
        git clone https://github.com/Marcelo-Henrique-12/hotelRoomsProject.git
    
    2° - Navegue até a pasta do projeto:

        cd hotelRoomsProject

    3° - Instale as dependências do Composer:

        composer instal

    4° - Configure o ambiente:

        De o comando cp .env.example .env, e coloque o nome do usuário do banco de dados e senha, caso seja necessário, crie o banco com o mesmo nome hotelroomproject previamente.

    5° - Gere a chave de aplicativo do Laravel:

        php artisan key:generate

    6° - Instalação das Dependências JavaScript: 

        npm install

    7° - Compilação dos Ativos: 

        npm run dev
        

    8° - Execute as migrações do banco de dados

        php artisan migrate

    9° - Inicie o servidor de desenvolvimento (opcional)

        npm run dev
        php artisan serve


    10° - Alimente com dados de teste os hoteis e quartos com seeders e factories (OPCIONAL)

        php artisan db:seed;

        Para cada um separadamente:

        php artisan db:seed --class=HotelSeeder
        php artisan db:seed --class=RoomSeeder
 

    11° - Execute os testes (opcional)
        a - Crie um banco para testes com o nome hotelroomproject_testing, e coloque no campo DB_DATABASE do arquivo .env, para evitar conflitos    com o banco original;

        b - php artisan test


## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
