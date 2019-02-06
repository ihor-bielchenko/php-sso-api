* <a href="#secret keys">Secret keys</a>
* <a href="#api">API</a>
    * <a href="#user-registration">User registration</a>
    * <a href="#get-tokens">Get tokens</a>
    * <a href="#user-logout">User logout</a>
    * <a href="#update-tokens">Update tokens</a><br><br>
    * Roles
        * <a href="#get-one-role">Get one role</a>
        * <a href="#get-all-roles">Get all roles</a>
        * <a href="#create-one-role">Create one role</a>
        * <a href="#update-one-role">Update one role</a>
        * <a href="#delete-one-role">Delete one role</a>
    * Users
        * <a href="#get-one-user">Get one user</a>
        * <a href="#get-all-users">Get all users</a>
        * <a href="#create-one-user">Create one user</a>
        * <a href="#update-one-user">Update one user</a>
        * <a href="#delete-one-user">Delete one user</a>
    * Actions
        * <a href="#get-one-action">Get one action</a>
        * <a href="#get-all-actions">Get all actions</a>
        * <a href="#create-one-action">Create one action</a>
        * <a href="#update-one-action">Update one action</a>
        * <a href="#delete-one-action">Delete one action</a>
    * Settings
        * <a href="#get-one-setting">Get one setting</a>
        * <a href="#get-all-settings">Get all settings</a>
        * <a href="#create-one-setting">Create one setting</a>
        * <a href="#update-one-setting">Update one setting</a>
        * <a href="#delete-one-setting">Delete one setting</a>

# Secret keys

### In env file:

`JWT_SECRET_ACCESS_KEY` - string to generate a access_token<br>
`JWT_SECRET_REFRESH_KEY` - string to generate a refresh_token<br>
`JWT_ACCESS_TIMEOUT` - access token lifetime in milliseconds<br>
`JWT_REFRESH_TIMEOUT` - refresh token lifetime in milliseconds<br>

### example: 

    JWT_ACCESS_TIMEOUT=300000
    JWT_REFRESH_TIMEOUT=960000
    JWT_SECRET_ACCESS_KEY=ltl55BEm1Db3hasaq4VVmPaswncx0Omy
    JWT_SECRET_REFRESH_KEY=n4dfoEEerQlgg7gvzmet5pIIjei6acdd


# API

**User registration**
----
  Create new user in database with default role and then auth him

* **URL:**

    `/api/register`

* **Method:**

    `POST`
  
* **URL params**

    * **Required:**

        None

    * **Optional:**

        None
  
* **Data params:**

    * **Required:**
  
        `name=[string]` - unique user login in the system;<br>
        `email=[string]` - user email;<br>
        `password=[string]` - user password;<br>
        `confirm_password=[string]` - field to confirm the specified password;<br>
        `first_name=[string]` - user first name;<br>
        `last_name=[string]` - user last name;<br>

    * **Optional:**
  
        `birth_date=[date]` - user birth date (format: `Y-m-d H:i:s`);<br>
        `avatar=[string]` - link to avatar;<br>

* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
    
    ```json
    {
        "data": {
            "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjMwMDAwMCwibmFtZSI6ImFkbWluMSIsImlhdCI6MTU0ODM3MDIzOTA3MSwicm9sZXMiOltdfQ==.37ba966eda47d71f42ccfbfc65f5d7b34d25031a4a472d3391b1f1d7c3c04b0d",
            "refresh_token": "89bf221f61c881cd7859c61d7ae20a4dcf7ca9bfd6c8c2b55948da25ec39472d",
            "token_type": "bearer",
            "expires_in": "300000"
        }
    }
    ```
    
* **Error responses:**

    * **Code:** 422 Unprocessable Entity <br />
        **Description:** a user with this data already exists <br>
        **Content:**
    
    ```json
    {
        "message":"The given data was invalid.",
        "errors":{
            "name":[
                "The name has already been taken."
            ],
            "email":[
                "The email has already been taken."
            ]
        }
    }
    ```
    
    * **Code:** 401 Unauthorized <br />
        **Description:** `password` and `confirm_password` do not match <br>
        **Content:**
    
    ```json
    {
        "data":{
            "message":"Unauthorized"
        }
    }
    ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/register', {
        credentials: 'include',
        method: 'POST',
        body: 'name=admin&email=admin@example.com&password=qwe123&confirm_password=qwe123&first_name=aaa&last_name=bbb',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });
  ```
  
**Get tokens**
----
  Get tokens for a registered user

* **URL:**

    `/api/login`

* **Method:**

    `GET`
  
* **URL params**

    * **Required:**

        `email=[string]` - user email;<br>
        `password=[string]` - user password;<br>

    * **Optional:**

        None
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
    
    ```json
    {
        "data": {
            "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjMwMDAwMCwibmFtZSI6ImFkbWluMSIsImlhdCI6MTU0ODM3MDIzOTA3MSwicm9sZXMiOltdfQ==.37ba966eda47d71f42ccfbfc65f5d7b34d25031a4a472d3391b1f1d7c3c04b0d",
            "refresh_token": "89bf221f61c881cd7859c61d7ae20a4dcf7ca9bfd6c8c2b55948da25ec39472d",
            "token_type": "bearer",
            "expires_in": "300000"
        }
    }
    ```
    
* **Error responses:**

    * **Code:** 422 Unprocessable Entity <br />
        **Description:** if the data field is in the wrong format <br>
        **Content:**
    
    ```json
    {
        "message":"The given data was invalid.",
        "errors":{
            "email":[
                "The email must be a valid email address."
            ]
        }
    }
    ```
    
    * **Code:** 404 Not Found <br />
        **Description:** if the requested user is not in the database <br>
        **Content:**
    
    ```json
    {
        "message": "No query results for model [App\\Models\\User]."
    }
    ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/login?email=admin@example.com&password=qwe123');
  ```

**User logout**
----
  Delete refresh token from database. You need to delete tokens from service storage (for example from local storage in browser).

* **URL:**

    `/api/logout`

* **Method:**

    `DELETE`
  
* **URL params**

    * **Required:**

        None

    * **Optional:**

        None
  
* **Data params:**

    * **Required:**
  
        `refresh_token=[string]` - refresh token string that received while auth;<br>

    * **Optional:**
  
        None

* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
    
    ```json
    {
        "data":{
            "message":"Successfully logged out"
        }
    }
    ```
    
* **Error responses:**

    * **Code:** 404 Not Found <br />
        **Description:** if the specified token could not find the user in the database <br>
        **Content:**
    
    ```json
    {
        "message": "No query results for model [App\\Models\\User]."
    }
    ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/logout', {
        credentials: 'include',
        method: 'DELETE',
        body: 'refresh_token=eb09ed9b7151f6c3df9ef13eaac95d87b7a29199dc8abf2ea30a68bd797a9403',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });
  ```
  
**Recovery password**
----
  Attempt to change user password.

* **URL:**

    `/api/recovery`

* **Method:**

    `POST`
  
* **URL params**

    * **Required:**

        None

    * **Optional:**

        None
  
* **Data params:**

    * **Required:**
  
        `email=[string]` - user email to send a link to recover a password;<br>

    * **Optional:**
  
        None

* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
    
    ```json
    {
        "data":{
            "message":"Successful sending of the recovery link to the email"
        }
    }
    ```
    
* **Error responses:**

    * **Code:** 404 Not Found <br />
        **Description:** no users found at the specified email <br>
        **Content:**
    
    ```json
    {
        "message": "No query results for model [App\\Models\\User]."
    }
    ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/recovery', {
        credentials: 'include',
        method: 'POST',
        body: 'email=admin@example.com',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });
  ```

**Update tokens**
----
  Update access_token by refresh_token.

* **URL:**

    `/api/refresh`

* **Method:**

    `POST`
  
* **URL params**

    * **Required:**

        None

    * **Optional:**

        None
  
* **Data params:**

    * **Required:**
  
        `refresh_token=[string]` - refresh token string that received while auth;<br>
        `access_token=[string]` - access token string that received while auth;<br>

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```

* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjMwMDAwMCwibmFtZSI6ImthdGUiLCJpYXQiOjE1NDg2NzEyNzgwNTQsInJvbGVzIjpbeyJuYW1lIjoiYWRtaW4iLCJwaXZvdCI6eyJ1c2VyX2lkIjoxLCJyb2xlX2lkIjoxfX0seyJuYW1lIjoibWFuYWdlciIsInBpdm90Ijp7InVzZXJfaWQiOjEsInJvbGVfaWQiOjJ9fSx7Im5hbWUiOiJtZW1iZXIiLCJwaXZvdCI6eyJ1c2VyX2lkIjoxLCJyb2xlX2lkIjozfX1dfQ==.f1b03f5815f259ed3e6c699e08574a986da7f31d4eac42dbf57d6867a8c9628b",
                "refresh_token": "fd71eff11a0d2b3c8056693e9b4a48e44296a319ca73ebc9a3a585aae7dc6b74",
                "token_type": "bearer",
                "expires_in": "300000"
            }
        }
        ```
        
    * **Error responses:**

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** refresh_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No refresh_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/refresh', {
        credentials: 'include',
        method: 'POST',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN',
            'refresh_token': 'REFRESH_TOKEN'
        }
    });
  ```
  
**Get one role**
----
  Return JSON data about one role by id.

* **URL:**

    `/api/roles/{id}`

* **Method:**

    `GET`
  
* **URL params**

    * **Required:**

        `id=[integer]` - role's id;<br>

    * **Optional:**

        `query=[string]` - search by specified value;<br>
        `limit=[integer]` - limit of entries on one page;<br>
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "id": 1,
                "name": "admin",
                "description": "Full access to models",
                "created_at": "2019-01-24 11:06:43",
                "updated_at": "2019-01-24 11:06:43"
            }
        }
        ```
        
    * **Error responses:**
    
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/roles/{id}', {
        credentials: 'include',
        method: 'GET',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN',
        }
    });
  ```
  
**Get all roles**
----
  Return JSON data about all roles for users.

* **URL:**

    `/api/roles/`

* **Method:**

    `GET`
  
* **URL params**

    * **Required:**

        None

    * **Optional:**
        
        `query=[string]` - search by specified value;<br>
        `limit=[integer]` - limit of entries on one page;<br>
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": [
                {
                    "id": 1,
                    "name": "admin",
                    "description": "Full access to models",
                    "created_at": "2019-01-24 11:06:43",
                    "updated_at": "2019-01-24 11:06:43"
                },
                {
                    "id": 2,
                    "name": "manager",
                    "description": "Access to manage models",
                    "created_at": "2019-01-24 11:06:43",
                    "updated_at": "2019-01-24 11:06:43"
                },
                {
                    "id": 3,
                    "name": "member",
                    "description": "Access to view models",
                    "created_at": "2019-01-24 11:06:43",
                    "updated_at": "2019-01-24 11:06:43"
                }
            ],
            "links": {
                "first": "http://EXAMPLE_HOST/api/roles?page=1",
                "last": "http://EXAMPLE_HOST/api/roles?page=1",
                "prev": null,
                "next": null
            },
            "meta": {
                "current_page": 1,
                "from": 1,
                "last_page": 1,
                "path": "http://EXAMPLE_HOST/api/roles",
                "per_page": 15,
                "to": 3,
                "total": 3
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/roles', {
        credentials: 'include',
        method: 'GET',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN',
        }
    });
  ```
  
**Create one role**
----
  Create new role in database and returns json data about successful creating.

* **URL:**

    `/api/roles/`

* **Method:**

    `POST`
  
* **URL params**

    * **Required:**

        None

    * **Optional:**
        
        None
  
* **Data params:**

    * **Required:**
  
        `name=[string]` - unique role name;<br>

    * **Optional:**
  
        `description=[string]` - role description;<br>
        `actions=[string]` - available actions for current role;<br>
        `users=[string]` - users which have current role;<br>

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "id": 4,
                "name": "manager",
                "description": null,
                "created_at": "2019-01-29 14:48:17",
                "updated_at": "2019-01-29 14:48:17"
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/roles', {
        credentials: 'include',
        method: 'POST',
        body: 'name=ROLE&description=EXAMPLE&actions=[1,2,3]&users=[6,7]',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN'
        }
    });
  ```
  
**Update one role**
----
  Update role properties in database by id and returns json data about successful editing.

* **URL:**

    `/api/roles/{id}`

* **Method:**

    `PATCH`
  
* **URL params**

    * **Required:**

        `id=[integer]` - role's id;<br>

    * **Optional:**
        
        None
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        `name=[string]` - unique role name;<br>
        `description=[string]` - role description;<br>
        `actions=[string]` - available actions for current role;<br>
        `users=[string]` - users which have current role;<br>

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "id": 5,
                "name": "role",
                "description": "example",
                "created_at": "2019-01-29 14:57:49",
                "updated_at": "2019-01-29 17:14:13"
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/roles/{id}', {
        credentials: 'include',
        method: 'PATCH',
        body: 'name=ROLE&description=EXAMPLE&actions=[1,2,3]&users=[6,7]',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN'
        }
    });
  ```

**Delete one role**
----
  Delete role from database by id and returns json data about successful deleting.

* **URL:**

    `/api/roles/{id}`

* **Method:**

    `DELETE`
  
* **URL params**

    * **Required:**

        `id=[integer]` - role's id;<br>

    * **Optional:**
        
        None
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "message": "Model successfully deleted"
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/roles/{id}', {
        credentials: 'include',
        method: 'DELETE',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN'
        }
    });
  ```

**Get one user**
----
  Return JSON data about one user by id.

* **URL:**

    `/api/users/{id}`

* **Method:**

    `GET`
  
* **URL params**

    * **Required:**

        `id=[integer]` - user's id;<br>

    * **Optional:**

        `query=[string]` - search by specified value;<br>
        `limit=[integer]` - limit of entries on one page;<br>
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "id": 1,
                "name": "kate",
                "first_name": "mike",
                "last_name": "Smith",
                "birth_date": null,
                "avatar": null,
                "email": "mike@gmail.com",
                "email_verified_at": null,
                "refresh_token": "95dd24a048b390fb0f64d299d56487169b4513fb9bfb2762104136615c727759",
                "created_at": "2019-01-25 15:21:30",
                "updated_at": "2019-01-29 16:41:07"
            }
        }
        ```
        
    * **Error responses:**
    
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/users/{id}', {
        credentials: 'include',
        method: 'GET',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN',
        }
    });
  ```

**Get all users**
----
  Return JSON data about all users.

* **URL:**

    `/api/users/`

* **Method:**

    `GET`
  
* **URL params**

    * **Required:**

        None

    * **Optional:**
        
        `query=[string]` - search by specified value;<br>
        `limit=[integer]` - limit of entries on one page;<br>
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": [
                {
                    "id": 1,
                    "name": "kate",
                    "first_name": "kate",
                    "last_name": "michaelson",
                    "birth_date": null,
                    "avatar": null,
                    "email": "aaa@gmail.com",
                    "email_verified_at": null,
                    "refresh_token": "18e3aea3687d624fd4831b96d4177b62f5afd0bd3108db14cb189ccc347d2abc",
                    "created_at": "2019-01-25 15:21:30",
                    "updated_at": "2019-01-29 16:56:30"
                },
                {
                    "id": 2,
                    "name": "mike",
                    "first_name": "mike",
                    "last_name": "stark",
                    "birth_date": null,
                    "avatar": null,
                    "email": "bbbb@gmail.com",
                    "email_verified_at": null,
                    "refresh_token": "ba093f381e30387e8206f1cf61a5e760de0b8f5926696a9077e642a39319908b",
                    "created_at": "2019-01-25 15:39:52",
                    "updated_at": "2019-01-28 19:29:40"
                },
                {
                    "id": 3,
                    "name": "lisa",
                    "first_name": "lisa",
                    "last_name": "stewart",
                    "birth_date": null,
                    "avatar": null,
                    "email": "nnnnnn@gmail.com",
                    "email_verified_at": null,
                    "refresh_token": "fe317065b109b792728f1d3697a069bd6291f9d615aa0080b0e7cf4549b55b0c",
                    "created_at": "2019-01-28 16:40:42",
                    "updated_at": "2019-01-28 16:40:42"
                }
                .........
            ],
            "links": {
                "first": "http://EXAMPLE_HOST/api/users?page=1",
                "last": "http://EXAMPLE_HOST/api/users?page=6",
                "prev": null,
                "next": "http://EXAMPLE_HOST/api/users?page=2"
            },
            "meta": {
                "current_page": 1,
                "from": 1,
                "last_page": 6,
                "path": "http://EXAMPLE_HOST/api/users",
                "per_page": 15,
                "to": 15,
                "total": 77
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/users', {
        credentials: 'include',
        method: 'GET',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN',
        }
    });
  ```

**Create one user**
----
  Create new user in database and returns json data about successful creating.

* **URL:**

    `/api/users/`

* **Method:**

    `POST`
  
* **URL params**

    * **Required:**

        None

    * **Optional:**
        
        None
  
* **Data params:**

    * **Required:**
  
        `name=[string]` - unique user login in the system;<br>
        `email=[string]` - user email;<br>
        `password=[string]` - user password;<br>
        `first_name=[string]` - user first name;<br>
        `last_name=[string]` - user last name;<br>

    * **Optional:**
  
        `birth_date=[string]` - user's birthday (format: `Y-m-d H:i:s`);<br>
        `avatar=[string]` - link to user's avatar;<br>
        `roles=[string]` - roles which can have current user;<br>

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "id": 78,
                "name": "example",
                "first_name": "mister",
                "last_name": "inkognito",
                "birth_date": null,
                "avatar": null,
                "email": "inkognito@dfv.ru",
                "email_verified_at": null,
                "refresh_token": null,
                "created_at": "2019-01-29 17:18:51",
                "updated_at": "2019-01-29 17:18:51"
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/users', {
        credentials: 'include',
        method: 'POST',
        body: 'name=example123&email=ex@gmail.com&password=1111&first_name=peter&last_name=peterson&roles=[2]',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN'
        }
    });
  ```
  
**Update one user**
----
  Update user properties in database by id and returns json data about successful editing.

* **URL:**

    `/api/users/{id}`

* **Method:**

    `PATCH`
  
* **URL params**

    * **Required:**

        `id=[integer]` - user's id;<br>

    * **Optional:**
        
        None
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        `name=[string]` - unique user login in the system;<br>
        `email=[string]` - user email;<br>
        `password=[string]` - user password;<br>
        `first_name=[string]` - user first name;<br>
        `last_name=[string]` - user last name;<br>
        `birth_date=[string]` - user's birthday (format: `Y-m-d H:i:s`);<br>
        `avatar=[string]` - link to user's avatar;<br>
        `roles=[string]` - roles which can have current user;<br>

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "id": 6,
                "name": "peterwalter",
                "first_name": "peter",
                "last_name": "wallter",
                "birth_date": null,
                "avatar": null,
                "email": "peter@gmail.com",
                "email_verified_at": null,
                "refresh_token": "3485eae6f60b55119ba40ee48ad86c3b5071f6ea5d974a5c499cb2551bf7b606",
                "created_at": "2019-01-28 16:43:30",
                "updated_at": "2019-01-28 17:30:10"
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/users/{id}', {
        credentials: 'include',
        method: 'PATCH',
        body: 'name=example321&email=ex111@gmail.com&password=1111&first_name=peter&last_name=peterson&roles=[2]',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN'
        }
    });
  ```

**Delete one user**
----
  Delete user from database by id and returns json data about successful deleting.

* **URL:**

    `/api/users/{id}`

* **Method:**

    `DELETE`
  
* **URL params**

    * **Required:**

        `id=[integer]` - user's id;<br>

    * **Optional:**
        
        None
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "message": "Model successfully deleted"
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/users/{id}', {
        credentials: 'include',
        method: 'DELETE',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN'
        }
    });
  ```

**Get one action**
----
  Return JSON data about one action by id.

* **URL:**

    `/api/actions/{id}`

* **Method:**

    `GET`
  
* **URL params**

    * **Required:**

        `id=[integer]` - action's id;<br>

    * **Optional:**

        `query=[string]` - search by specified value;<br>
        `limit=[integer]` - limit of entries on one page;<br>
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "id": 1,
                "name": "RoleGetModel",
                "description": "Show role model",
                "created_at": "2019-01-24 11:06:43",
                "updated_at": "2019-01-24 11:06:43"
            }
        }
        ```
        
    * **Error responses:**
    
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/actions/{id}', {
        credentials: 'include',
        method: 'GET',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN',
        }
    });
  ```

**Get all actions**
----
  Return JSON data about all actions.

* **URL:**

    `/api/actions/`

* **Method:**

    `GET`
  
* **URL params**

    * **Required:**

        None

    * **Optional:**
        
        `query=[string]` - search by specified value;<br>
        `limit=[integer]` - limit of entries on one page;<br>
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": [
                {
                    "id": 1,
                    "name": "RoleGetModel",
                    "description": "Show role model",
                    "created_at": "2019-01-24 11:06:43",
                    "updated_at": "2019-01-24 11:06:43"
                },
                {
                    "id": 2,
                    "name": "RoleGetCollection",
                    "description": "Show role collection",
                    "created_at": "2019-01-24 11:06:43",
                    "updated_at": "2019-01-24 11:06:43"
                },
                {
                    "id": 3,
                    "name": "RoleCreateModel",
                    "description": "Create role model",
                    "created_at": "2019-01-24 11:06:43",
                    "updated_at": "2019-01-24 11:06:43"
                },
                .........
            ],
            "links": {
                "first": "http://EXAMPLE_HOST/api/actions?page=1",
                "last": "http://EXAMPLE_HOST/api/actions?page=2",
                "prev": null,
                "next": "http://EXAMPLE_HOST/api/actions?page=2"
            },
            "meta": {
                "current_page": 1,
                "from": 1,
                "last_page": 2,
                "path": "http://EXAMPLE_HOST/api/actions",
                "per_page": 15,
                "to": 15,
                "total": 20
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/actions', {
        credentials: 'include',
        method: 'GET',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN',
        }
    });
  ```

**Create one action**
----
  Create new action in database and returns json data about successful creating.

* **URL:**

    `/api/actions/`

* **Method:**

    `POST`
  
* **URL params**

    * **Required:**

        None

    * **Optional:**
        
        None
  
* **Data params:**

    * **Required:**
  
        `name=[string]` - unique action name;<br>

    * **Optional:**
  
        `description=[string]` - action's description;<br>
        `roles=[string]` - roles where current action are available;<br>

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "id": 21,
                "name": "ActionExample",
                "description": "exampleexample",
                "created_at": "2019-01-30 07:32:16",
                "updated_at": "2019-01-30 07:32:16"
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/actions', {
        credentials: 'include',
        method: 'POST',
        body: 'name=ActionExample2&description=EXAMPLE&roles=[2]',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN'
        }
    });
  ```
  
**Update one action**
----
  Update action properties in database by id and returns json data about successful editing.

* **URL:**

    `/api/actions/{id}`

* **Method:**

    `PATCH`
  
* **URL params**

    * **Required:**

        `id=[integer]` - action's id;<br>

    * **Optional:**
        
        None
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        `name=[string]` - unique action name;<br>
        `description=[string]` - action's description;<br>
        `roles=[string]` - roles where current action are available;<br>

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "id": 21,
                "name": "ActionExample",
                "description": "exampleexample",
                "created_at": "2019-01-30 07:32:16",
                "updated_at": "2019-01-30 07:45:19"
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/actions/{id}', {
        credentials: 'include',
        method: 'PATCH',
        body: 'name=ActionExample22&description=EXAMPLE&roles=[2]',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN'
        }
    });
  ```

**Delete one user**
----
  Delete user from database by id and returns json data about successful deleting.

* **URL:**

    `/api/actions/{id}`

* **Method:**

    `DELETE`
  
* **URL params**

    * **Required:**

        `id=[integer]` - action's id;<br>

    * **Optional:**
        
        None
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "message": "Model successfully deleted"
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/actions/{id}', {
        credentials: 'include',
        method: 'DELETE',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN'
        }
    });
  ```

  **Get one setting**
----
  Return JSON data about one setting by id.

* **URL:**

    `/api/settings/{id}`

* **Method:**

    `GET`
  
* **URL params**

    * **Required:**

        `id=[integer]` - setting's id;<br>

    * **Optional:**

        `query=[string]` - search by specified value;<br>
        `limit=[integer]` - limit of entries on one page;<br>
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "id": 1,
                "name": "multi_roles",
                "description": "Binding multiple roles to user",
                "value": "0",
                "namespace_id": 0,
                "created_at": "2019-01-24 11:06:43",
                "updated_at": "2019-01-24 11:06:43"
            }
        }
        ```
        
    * **Error responses:**
    
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/settings/{id}', {
        credentials: 'include',
        method: 'GET',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN',
        }
    });
  ```

**Get all settings**
----
  Return JSON data about all settings.

* **URL:**

    `/api/settings/`

* **Method:**

    `GET`
  
* **URL params**

    * **Required:**

        None

    * **Optional:**
        
        `query=[string]` - search by specified value;<br>
        `limit=[integer]` - limit of entries on one page;<br>
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": [
                {
                    "id": 1,
                    "name": "multi_roles",
                    "description": "Binding multiple roles to user",
                    "value": "0",
                    "namespace_id": 0,
                    "created_at": "2019-01-24 11:06:43",
                    "updated_at": "2019-01-24 11:06:43"
                }
            ],
            "links": {
                "first": "http://EXAMPLE_HOST/api/settings?page=1",
                "last": "http://EXAMPLE_HOST/api/settings?page=1",
                "prev": null,
                "next": null
            },
            "meta": {
                "current_page": 1,
                "from": 1,
                "last_page": 1,
                "path": "http://EXAMPLE_HOST/api/settings",
                "per_page": 15,
                "to": 1,
                "total": 1
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/settings', {
        credentials: 'include',
        method: 'GET',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN',
        }
    });
  ```

**Create one setting**
----
  Create new setting in database and returns json data about successful creating.

* **URL:**

    `/api/settings/`

* **Method:**

    `POST`
  
* **URL params**

    * **Required:**

        None

    * **Optional:**
        
        None
  
* **Data params:**

    * **Required:**
  
        `name=[string]` - unique setting name;<br>

    * **Optional:**
  
        `description=[string]` - setting's description;<br>
        `value=[string]` - setting's value;<br>
        `namespace_id=[integer]` - setting's namespace;<br>

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "name": "settingExample",
                "description": "exampleexample",
                "value": "0",
                "namespace_id": "0",
                "updated_at": "2019-01-30 08:04:13",
                "created_at": "2019-01-30 08:04:13",
                "id": 2
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/settings', {
        credentials: 'include',
        method: 'POST',
        body: 'name=SettingExample22&description=EXAMPLE&value=0&namespace_id=0',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN'
        }
    });
  ```
  
**Update one setting**
----
  Update setting properties in database by id and returns json data about successful editing.

* **URL:**

    `/api/settings/{id}`

* **Method:**

    `PATCH`
  
* **URL params**

    * **Required:**

        `id=[integer]` - setting's id;<br>

    * **Optional:**
        
        None
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        `name=[string]` - unique setting name;<br>
        `description=[string]` - setting's description;<br>
        `value=[string]` - setting's value;<br>
        `namespace_id=[integer]` - setting's namespace;<br>

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "name": "settingExample2",
                "description": "exampleexample2",
                "value": "0",
                "namespace_id": "0",
                "updated_at": "2019-01-30 08:04:13",
                "created_at": "2019-01-30 08:09:56",
                "id": 2
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/settings/{id}', {
        credentials: 'include',
        method: 'PATCH',
        body: 'name=SettingExample333&description=EXAMPLE23&value=0&namespace_id=0',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN'
        }
    });
  ```

**Delete one setting**
----
  Delete setting from database by id and returns json data about successful deleting.

* **URL:**

    `/api/settings/{id}`

* **Method:**

    `DELETE`
  
* **URL params**

    * **Required:**

        `id=[integer]` - setting's id;<br>

    * **Optional:**
        
        None
  
* **Data params:**

    * **Required:**
  
        None

    * **Optional:**
  
        None

* **Header:**

    ```
    Authorization: Bearer ACCESS_TOKEN
    ```
    
* **Success response:**

    * **Code:** 200 OK <br />
        **Content:** 
        
        ```json
        {
            "data": {
                "message": "Model successfully deleted"
            }
        }
        ```
        
    * **Error responses:**
        
        * **Code:** 401 Unauthorized <br />
            **Description:** unauthorized user <br>
            **Content:**
            
        ```json
        {
            "data": {
                "message": "Unauthorized"
            }
        }
        ```

        * **Code:** 404 Not Found <br />
            **Description:** access_token is missing <br>
            **Content:**
        
        ```json
        {
            "data": {
                "message": "No access_token specified"
            }
        }
        ```

* **Sample call:**

  ```javascript
    fetch('http://EXAMPLE_HOST/api/settings/{id}', {
        credentials: 'include',
        method: 'DELETE',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ACCESS_TOKEN'
        }
    });
  ```