## API-CRUD app
- using laravel framework to implement RESTful API for login & registration of users using JWT,
  after login user can make all CRUD operations related to departments.

### about app
- using third-party libarary for "jwt" : https://github.com/tymondesigns/jwt-auth
- two main controllers AuthController & DepartmentConroller 
   AuthController : handling user authentication( registration,login,logout and user_info).
   DepartmentConroller : handling all CRUD operations related to departments(list,view,create,update and delete).
- using Request RegisterAuthRequest to validate registration data before processing.

#### end-points
- all end-points use prefix "api" => (../api/..).

##### accessible end-points
- registration => post(../register): register new user then redirect to login function.
- login        => post(../login): check of email and password, and return token.

##### protected end-points
- logout    => get(../logout): invalidate the current token and unset the authenticated user.
- user Info => get(../user): Get the currently authenticated user and return his info.
- list      => get(../departments): list all departments with name and id.
- view      => get(../departments/{id}): get spasific depaartment by id.
- create    => post(../departments): store new "unique" department ('name'=>value).
- update    => put(../departments/{id}): update spasific department by id to new unique name ('name'=>value).
-delete     => delete(../departments): delete spasific department by id.

#### install-localy
- use php & mysql server ex.(xampp).
- using composer to install all dependances:

		$ composer insatll

- create new database and connect it to env file.
- migrate app tables to database:

		$ php artisan migrate

- for jwt-package Publish the config & Generate secret key:

		$ php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

		$ php artisan jwt:secret
 
  jwt-package installation details: https://jwt-auth.readthedocs.io/en/develop/laravel-installation/

