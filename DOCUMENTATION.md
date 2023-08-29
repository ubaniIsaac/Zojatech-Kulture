# Kulture App API Documentation

Welcome to the documentation for the Kulture App API. This document provides information about the available routes, endpoints, and functionality of the API.

## Authentication

Before using the API, you need to authenticate. Here are the authentication routes:

### REGISTER

Endpoint: `POST /api/v1/register`

Register a new user. Requires providing a unique email and password.

Request Body:

```json
{
  "username": "required | unique",
  "first_name": " required | unique",
  "last_name": " required | unique",
  "email": "required | unique",
  "profile_profile": "required| mimes:jpeg,png,jpg,gif,svg|max:2048",
  "password": "required| min:8",
  "confirm_password": "required| min:8",
  "user_type": "requried|in:producer,artiste"
}
```

Response Body:

```json
{
    "status": true,
    "message": "User created successfully",
    "data": {
        "user": {
            "id": "01h8cba0b0bdf7c28yr245c8vy",
            "type": "users",
            "attributes": {
                "username": "@Christy_Fisher99",
                "first_name": "Dina",
                "last_name": "Asia",
                "email": "produc@gmail.com",
                "profile_picture": "https://res.cloudinary.com/dvn1eznus/image/upload/v1692631628/profileImages/bdompoxhgoqbgsc0g3z4.jpg",
                "user_type": "producer",
                "created_at": "2023-08-21T15:27:10.000000Z",
                "updated_at": "2023-08-21T15:27:10.000000Z"
            }
        }
    }
}
```

### LOGIN

Endpoint: `POST /api/v1/signin`

Request Body:

```json
{
  "email": "reequired | unique",
  "password": "required| min:8",
}
```
Response Body

```json
{
    "status": true,
    "message": "User logged in successfully",
    "data": {
        "token": "token",
        "user": {
            "id": "01h8cbbpmnxent1cys6wbtrc6y",
            "type": "users",
            "attributes": {
                "username": "@okeeey",
                "first_name": "Felipe",
                "last_name": "Alysson",
                "email": "abisoye@gmail.com",
                "profile_picture": "https://res.cloudinary.com/dvn1eznus/image/upload/v1692631684/profileImages/acqn3droaneqmfecb5gk.jpg",
                "user_type": "producer",
                "created_at": "2023-08-21T15:28:05.000000Z",
                "updated_at": "2023-08-21T15:28:05.000000Z"
            }
        }
    }
}
```
### TRENDING

Endpoint: `GET /api/v1/trending/beats`

Response Body:

```json
{
    "status": true,
    "message": "Trending beats retrieved successfully",
    "data": [
        {
            "id": "01h8em8rgtf8r0dt9s8wg13fdx",
            "attributes": {
                "name": "haptic",
                "price": 582,
                "genre": "Afro Pop",
                "image_url": "https://res.cloudinary.com/dvn1eznus/image/upload/v1692708124/beatsImages/htgyamojwfpe3xevpoxo.jpg",
                "file_url": "https://res.cloudinary.com/dvn1eznus/video/upload/v1692708134/beatsAudios/norrmwqnbb8h1zieypag.mp3",
                "duration": "00:51",
                "size": 1635056,
                "type": "audio/mpeg",
                "user_id": "01h8e8nycg52axpj85ty4jcrr1",
                "total_sales": 0,
                "plays": 0,
                "views": 0,
                "likes": 0,
                "downloads": 0
            },
            "producer": {
                "id": "01h8e8nz80gapv1ck2ts0zysr7",
                "user_id": "01h8e8nycg52axpj85ty4jcrr1",
                "total_revenue": 0,
                "total_sales": 0,
                "total_beats": 22,
                "profile_views": 9,
                "total_beats_sold": 0,
                "created_at": "2023-08-22T09:19:45.000000Z",
                "updated_at": "2023-08-22T14:04:10.000000Z"
            }
        }
    ]
}
```


Endpoint: `GET /api/v1/trending/producers`

Response Body:

```json

{
    "status": true,
    "message": "Trending producers retrieved successfully",
    "data": {
        "data": [
            {
                "id": "01h875k9xznv3qzt5pbzte4h2k",
                "user_id": "01h875k9wyqa89jwxfa9w9b3az",
                "total_revenue": 0,
                "total_sales": 0,
                "total_beats": 0,
                "profile_views": 0,
                "total_beats_sold": 0,
                "created_at": "2023-08-19T15:11:11.000000Z",
                "updated_at": "2023-08-19T15:11:11.000000Z",
                "user": {
                    "id": "01h875k9wyqa89jwxfa9w9b3az",
                    "username": "Ryan",
                    "first_name": "Armstrong",
                    "last_name": "Anjali",
                    "email": "lucas@gmail.com",
                    "user_type": "producer",
                    "profile_picture": "C:\\xampp\\tmp\\php1C4E.tmp",
                    "created_at": "2023-08-19T15:11:11.000000Z",
                    "updated_at": "2023-08-19T15:11:11.000000Z"
                }
            }
        ]
    }
}
```

### UPLOAD BEAT

Endpoint: `POST /api/v1/beats/upload`

Post a new beat.

Request Body:

```json
{
    "name": "required|string",
    "audio": "required|mimes:mpga,wav,mp3,octet-stream",
    "price": "required|numeric",
    "genre": "required|exists:genres,name",
    "image": "required|file|mimes:jpeg,png,jpg,gif,svg|max:2048",
}
```

Response Body:

```json
{
    "status": true,
    "message": "Beat uploaded successfully",
    "data": {
        "id": "01h8p58ngca2t1phv5rn6xa2hc",
        "attributes": {
            "name": "Amapiano ft Afro Trap",
            "price": "200",
            "genre": "Afro Pop",
            "image_url": "https://res.cloudinary.com/dvn1eznus/image/upload/v1692960836/beatsImages/mdhivlpi4t7ugid2agv1.jpg",
            "file_url": "https://res.cloudinary.com/dvn1eznus/video/upload/v1692960838/beatsAudios/peyyvm8umq2zvedukujl.mp3",
            "duration": "00:51",
            "size": 3869410,
            "type": "audio/mpeg",
            "user_id": "01h8hyjymbn3dswfge3mhhnq7q",
            "total_sales": null,
            "plays": null,
            "views": null,
            "likes": null,
            "downloads": null
        },
        "producer": {
            "id": "01h8hyjymz7t4fhwgqngemyvc6",
            "user_id": "01h8hyjymbn3dswfge3mhhnq7q",
            "total_revenue": 0,
            "total_sales": 0,
            "total_beats": 1,
            "profile_views": 0,
            "total_beats_sold": 0,
            "created_at": "2023-08-23T19:40:18.000000Z",
            "updated_at": "2023-08-25T10:53:59.000000Z"
        }
    }
}
```

### VIEW ALL BEATS

Endpoint: `GET /api/v1/beats`

view all beats with pagination.

Response Body

``` Json

{
    "status": true,
    "message": "Beats retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": "01h8p58ngca2t1phv5rn6xa2hc",
                "attributes": {
                    "name": "Amapiano ft Afro Trap",
                    "price": 200,
                    "genre": "Afro Pop",
                    "image_url": "https://res.cloudinary.com/dvn1eznus/image/upload/v1692960836/beatsImages/mdhivlpi4t7ugid2agv1.jpg",
                    "file_url": "https://res.cloudinary.com/dvn1eznus/video/upload/v1692960838/beatsAudios/peyyvm8umq2zvedukujl.mp3",
                    "duration": "00:51",
                    "size": 3869410,
                    "type": "audio/mpeg",
                    "user_id": "01h8hyjymbn3dswfge3mhhnq7q",
                    "total_sales": 0,
                    "plays": 0,
                    "views": 0,
                    "likes": 0,
                    "downloads": 0
                },
                "producer": {
                    "id": "01h8hyjymz7t4fhwgqngemyvc6",
                    "user_id": "01h8hyjymbn3dswfge3mhhnq7q",
                    "total_revenue": 0,
                    "total_sales": 0,
                    "total_beats": 1,
                    "profile_views": 0,
                    "total_beats_sold": 0,
                    "created_at": "2023-08-23T19:40:18.000000Z",
                    "updated_at": "2023-08-25T10:53:59.000000Z"
                }
            },
            {
                "id": "01h8eq1aaxvhqwnpfne03qvw01",
                "attributes": {
                    "name": "auxiliary",
                    "price": 388,
                    "genre": "Hip-Hop/Rap",
                    "image_url": "http://placeimg.com/640/480",
                    "file_url": "http://marisol.info",
                    "duration": "00:51",
                    "size": 0,
                    "type": "mp3",
                    "user_id": "01h8e8nycg52axpj85ty4jcrr1",
                    "total_sales": 0,
                    "plays": 0,
                    "views": 0,
                    "likes": 0,
                    "downloads": 0
                },
                "producer": {
                    "id": "01h8e8nz80gapv1ck2ts0zysr7",
                    "user_id": "01h8e8nycg52axpj85ty4jcrr1",
                    "total_revenue": 0,
                    "total_sales": 0,
                    "total_beats": 22,
                    "profile_views": 9,
                    "total_beats_sold": 0,
                    "created_at": "2023-08-22T09:19:45.000000Z",
                    "updated_at": "2023-08-22T14:04:10.000000Z"
                }
            }
        ]
    }
}
```


### FETCH BEAT BY ID

Endpoint: `GET /api/v1/beats/{id}`

```Json
{
    "status": true,
    "message": "Beat retrieved successfully",
    "data": {
        "id": "01h8p58ngca2t1phv5rn6xa2hc",
        "attributes": {
            "name": "Amapiano ft Afro Trap",
            "price": 200,
            "genre": "Afro Pop",
            "image_url": "https://res.cloudinary.com/dvn1eznus/image/upload/v1692960836/beatsImages/mdhivlpi4t7ugid2agv1.jpg",
            "file_url": "https://res.cloudinary.com/dvn1eznus/video/upload/v1692960838/beatsAudios/peyyvm8umq2zvedukujl.mp3",
            "duration": "00:51",
            "size": 3869410,
            "type": "audio/mpeg",
            "user_id": "01h8hyjymbn3dswfge3mhhnq7q",
            "total_sales": 0,
            "plays": 0,
            "views": 1,
            "likes": 0,
            "downloads": 0
        },
        "producer": {
            "id": "01h8hyjymz7t4fhwgqngemyvc6",
            "user_id": "01h8hyjymbn3dswfge3mhhnq7q",
            "total_revenue": 0,
            "total_sales": 0,
            "total_beats": 1,
            "profile_views": 0,
            "total_beats_sold": 0,
            "created_at": "2023-08-23T19:40:18.000000Z",
            "updated_at": "2023-08-25T10:53:59.000000Z"
        }
    }
}
```

### DASHBOARD

Endpoint: `GET /api/v1/dashboard/producer`

```Json

