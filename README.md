<div style="display:flex; align-items: center">
  <h1 style="position:relative; top: -6px" >Social Media Project</h1>
</div>

---

This is a social media project where users can create, update, or delete their own posts, make comments and replies on posts, as well as like or save others' posts, among other various functionalities. This is the backend side of the application, which is written in Laravel. The application includes features such as a real-time voting system using Broadcasting and Pusher, and Google OAuth with Laravel Socialite. Additionally, users receive real-time notifications when someone likes or comments on their posts. The frontend side's GitHub repository can be found here: https://github.com/GeorgeKalandadze/Social-Media-Web-Front.git

#

### Features

- **Authentication**: User Authentications system.
  - **API Token Authentication**: Securing API endpoints with Laravel Sanctum.
  - **Manage Auth Functionality**: Managed with Laravel Fortify.
- **Google OAuth**: Users can sign in with their Google accounts.
- **Post Management**: Users can create, update, and delete their own posts, also users can like and save posts created by others,make comments and replays on posts.
- **Real-Time Features**: Real-time vote system implemented using Laravel Broadcasting and Pusher for immediate updates and interactions.
- **Event-Driven Architecture**: Used for decoupling complex processes. For instance, events are fired when posts are liked or commented on, and corresponding listeners handle the processing.
- **Form Request Validation**: Enhanced form request validation using Laravel form request Classes.
- **API Resources**: Used for transforming and formatting API responses, providing a consistent structure for the API endpoints.
- **Seeders and Factories**:  Provide initial data for testing and development environments, Generate realistic fake data for models.

  
#

### Used Packages And Docs
- [Sanctum](https://laravel.com/docs/11.x/sanctum): Securing API endpoints with Laravel Sanctum.
- [Laravel Fortify](https://laravel.com/docs/11.x/fortify): A minimalistic authentication scaffolding for Laravel applications.
- [Laravel Socialite](https://laravel.com/docs/11.x/socialite): A simple and fluent way to authenticate with OAuth providers in Laravel applications.
- [Broadcasting](https://laravel.com/docs/11.x/broadcasting):  Learn about broadcasting events in your Laravel application, allowing real-time communication between the server and connected clients.
- [Pusher Api](https://pusher.com/): A service that provides real-time communication APIs to enable seamless collaboration and interactive experiences
- [Laravel Vote](https://packagist.org/packages/overtrue/laravel-vote): A Laravel package for implementing a voting system in applications, allowing users to vote on content such as posts or comments
#

### Project setup
```bash
git clone https://github.com/GeorgeKalandadze/Social-Media-web-Backend.git
```
```bash
cp .env.example .env
```
```bash
composer install
```
```bash
php artisan key:generate
```
```bash
php artisan migrate:fresh --seed
```
```bash
php artisan serve
```

#

### And now you should provide **.env** file all the necessary environment variables:

**MYSQL:**

> DB_CONNECTION=mysql

> DB_HOST=127.0.0.1

> DB_PORT=3306

> DB_DATABASE=**\***

> DB_USERNAME=**\***

> DB_PASSWORD=**\***

#

**Pusher:**

> ROADCAST_DRIVER=pusher

> CACHE_DRIVER=file

> FILESYSTEM_DISK=public

> QUEUE_CONNECTION=sync

> SESSION_DRIVER=file

> PUSHER_APP_ID=*

> PUSHER_APP_KEY=*

> PUSHER_APP_SECRET=*

> PUSHER_PORT=443

> PUSHER_SCHEME=https

> PUSHER_APP_CLUSTER=*

#
### Frontend Side Github Project URL
https://github.com/GeorgeKalandadze/Social-Media-Web-Front
