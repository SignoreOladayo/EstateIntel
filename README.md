# Technical Assessment Estate Intel (Backend Engineer)

## Setting Up The Project

1. Clone this repository
2. Generate an env file by running `copy .env.example .env`
3. Set up env with your database name, user and password
4. Run `php artisan key:generate`
5. Run `composer install`
6. After setting up the env, run `php artisan migrate` to migrate the database
7. Then finally run `php artisan serve` to start the server

## Testing the api's using an API tool like Postman

There are 7 end points which have been created, they are:

### 1. Fetch books from external api `/api/external-books`.

This api accepts a parameter `name` -> `/api/external-books?name=:nameOfABook`

The api can be called using the method GET -> `http://127.0.0.1:8000/api/external-books?name=A Game Of Thrones`

It returns a json response like in the example below

```json
{
    "status_code": 200,
    "status": "success",
    "data": [
        {
            "name": "A Game of Thrones",
            "isbn": "978-0553103540",
            "authors": [
                "George R. R. Martin"
            ],
            "publisher": "Bantam Books",
            "country": "United States",
            "number_of_pages": 694,
            "release_date": "1996-08-01T00:00:00"
        }
    ]
}
```

OR 

```json
{
    "status_code": 404,
    "status": "not found",
    "data": []
}
```

If no data response is not returned by the api

### 2. Create a book api -> `POST /api/v1/books`

This accepts a post request to create a book.

To get started, using the method POST -> `http://127.0.0.1:8000/api/v1/books`

with a json request like in the sample below

```json
{
    "name": "My First Book",
    "isbn": "893-7893021178993",
    "authors": [
        "Zack Me"
    ],
    "country": "Canada",
    "number_of_pages": 656,
    "publisher": "Mr Jones",
    "release_date": "2021-09-12"
}
```

This will return a json response like the sample below:

```json
{
    "status_code": 201,
    "status": "success",
    "data": {
        "book": {
            "name": "My First Book",
            "isbn": "893-7893021178993",
            "authors": [
                "Zack Me"
            ],
            "number_of_pages": 656,
            "publisher": "Mr Jones",
            "country": "Canada",
            "release_date": "2021-09-12"
        }
    }
}
```

The create a book api returns a 422 status code if all or any one of the required data is missing and returns a response
like below:

```json
{
    "status_code": 422,
    "status": "error",
    "error": {
        "{MissingField}": [
            "The {MissingField} field is required."
        ]
    },
    "reason": "Some data are missing"
}
```

### 3. Get all books api -> `GET /api/v1/books`

This accepts a get request to return all the available books in a local database.

To get started, using the method GET -> `http://127.0.0.1:8000/api/v1/books`

This will return a json response like the sample below

```json
{
    "status_code": 200,
    "status": "success",
    "data": [
        {
            "id": 1,
            "name": "My First Book",
            "isbn": "893-7893021178993",
            "authors": [
                "Zack Me"
            ],
            "number_of_pages": 656,
            "publisher": "Mr Jones",
            "country": "Canada",
            "release_date": "2021-09-12"
        }
    ]
}
```

OR a 404 status code response if no book record is found in the database:

```json
{
    "status_code": 200,
    "status": "success",
    "data": []
}
```

### 4. Search for a book api -> `GET /search`
This accepts a get request to search a book by name, country, publisher and release date.

To get started, using the method GET -> `http://127.0.0.1:8000/api/search`

with a json request like in the sample below

```json
{
    "search": "My Good Book"
}
```
This will return a json response like the sample below:
```json
{
    "status_code": 200,
    "status": "success",
    "data": [
        {
            "id": 1,
            "name": "My First Book",
            "isbn": "893-7893021178993",
            "authors": [
                "Zack Me"
            ],
            "number_of_pages": 656,
            "publisher": "Mr Jones",
            "country": "Canada",
            "release_date": "2021-09-12"
        }
    ]
}
```

OR a 404 status code response if no book record is found in the database:

```json
{
    "status_code": 404,
    "status": "not found",
    "data": []
}
```

### 5. Update a book api -> `PATCH /api/v1/books/:id`
This accepts a patch request to update a book.

To get started, using the method PATCH -> `http://127.0.0.1:8000/api/v1/books/1`

with a json request like in the sample below

```json
{
    "name": "My Good Book"
}
```

This will return a json response like the sample below

```json
{
  "status_code": 200,
  "status": "success",
  "message": "The Book My First Book was updated successfully",
  "data": {
    "id": 1,
    "name": "My Good Book",
    "isbn": "893-7893021178993",
    "authors": [
      "Zack Me"
    ],
    "number_of_pages": 656,
    "publisher": "Mr Jones",
    "country": "Canada",
    "release_date": "2021-09-12"
  }
}
```

### 6. Show a book api `GET /api/v1/books/:id`

This accepts a get request to show a book.

To get started, using the method GET -> `http://127.0.0.1:8000/api/v1/books/1`

This will return a json response like the sample below

```json
{
    "status_code": 200,
    "status": "success",
    "data": {
        "id": 1,
        "name": "My Good Book",
        "isbn": "893-7893021178993",
        "authors": [
            "Zack Me"
        ],
        "number_of_pages": 656,
        "publisher": "Mr Jones",
        "country": "Canada",
        "release_date": "2021-09-12"
    }
}
```

### 7. Delete a book api -> `DELETE /api/v1/books/:id`

This accepts a delete request to show a book.

To get started, using the method DELETE -> `http://127.0.0.1:8000/api/v1/books/1`

This will return a json response like the sample below

```json
{
    "status_code": 204,
    "status": "success",
    "message": "The Book My Good Book was deleted successfully",
    "data": []
}
```

## Running Unit Tests

Run `php artisan test -vvv --parallel`
