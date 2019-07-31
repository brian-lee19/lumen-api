---
## Lumen API with Laravel Passport

simple lumen api with passport framework.
see [demo host](https://lumen-api-0719.herokuapp.com)
---

## Endpoint

1.  Register user

    - Endpoint: `{{url}}/api/register`
    - Params:
      - email
      - password
      - password_confirmation
      - fullname

2.  Login user

    - Endpoint: `{{url}}/api/login`
    - Params:
      - email
      - password

3.  Get user details

    - Endpoint: `{{url}}/api/users/{{user_id}}`
      [demo](https://lumen-api-0719.herokuapp.com/api/users/1)
    - Auth: `Bearer {{auth_token}}`
