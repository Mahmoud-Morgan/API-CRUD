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
- registration =>  (../register): register new user then redirect to login function.
- login        => (../login): check of email and password, and return token.

##### protected end-points
- logout => (../logout): invalidate the current token and unset the authenticated user.
- user Info => (../user): Get the currently authenticated user and return his info.
