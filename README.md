# blog-server
A blog written in laravel

# Features
## Users
_Note that this blog api currently focuses on one author. Therfore, the author can should be seeded. After successfully adding the first user, the user can add other users. It would be nice to have a shellscript that allows you to seed a user during deployment_
### Create
 Seed user

### Login

#### Request And Response
##### Request
**url**
```
POST: http://{apiBaseUrl}/api/v1/users/auth/login
```
**body**

```
{
	"email": "jd@gmail.com",
	"password": "password"
}
```
#### Response
```
{
    "success": true,
    "message": "sign in successful",
    "accessToken": <token>
}
```
## Posts
### Create
 Only an authenticate user can create post
#### Request And Response

##### Request
**headers** <br/>
```
Authorization: Bearer <token>
Accept:        application/json
Content-Type:  application/json
```
**url**
```
POST http://{apiBaseUrl}/api/v1/posts
```
**body**
```
{
  "title": "my first blog",
  "body": "my first blog content"
}
```
##### Response
```
{
  "error": false,
  "message": "Post created successfully",
  "post": {
    "id": <number>,
    "title": "my first blog"
    "body": "my first blog content"
    "created-at": <timestamp>
    "updated-at": <timestamp>
  }
}
```

### Update
 Only an authenticate user can create post
#### Request And Response

##### Request
**headers** <br/>
```
Authorization: Bearer <token>
Accept:        application/json
Content-Type:  application/json
```
**url**
```
PUT http://{apiBaseUrl}/api/v1/posts
```
**body**
```
{
  "title": "my first body",
  "body": "my first blog body"
}
```
##### Response
```
{
  "error": false,
  "message": "Post created successfully",
  "post": {
    "id": <number>,
    "title": "my first blog"
    "body": "my first blog content"
    "created-at": <timestamp>
    "updated-at": <timestamp>
  }
}
```

### Read All Posts
 Athentication not needed
#### Request And Response

##### Request
**headers** <br/>
```
Accept:        application/json
Content-Type:  application/json
```
**url**
```
GET http://{apiBaseUrl}/api/v1/posts/
```
##### Response
```
[
  {
    "error": false,
    "message": "Post created successfully",
    "post": {
      "id": <number>,
      "title": "my first blog"
      "body": "my first blog content"
      "created-at": <timestamp>
      "updated-at": <timestamp>
    }
  },
  ...
]
```
### Paginate Posts
 Athentication needed
#### Request And Response

##### Request
**headers** <br/>
```
Authorization: Bearer <token>
Accept:        application/json
Content-Type:  application/json
```
**url**
```
GET http://{apiBaseUrl}/api/v1/posts/paginate/?page=<numer>
```
##### Response

```
{
    "error": false,
    "message": "Page data",
    "page": {
        "current_page": <number>,
        "data": [
            {
                "id": <number>,
                "title": <string>,
                "body": <string>,
                "author_id": <number>,
                "created_at": <timestamp>,
                "updated_at": <number>,
                "deleted_at": null
            }
        ],
        "first_page_url": "http://{apiBaseUrl}/api/v1/posts/paginate?page=<number>",
        "from": <number>,
        "last_page": <number>,
        "last_page_url": "http://{apiBaseUrl}/api/v1/posts/paginate?page=<number>",
        "next_page_url": null,
        "path": "http://{apiBaseUrl}/api/v1/posts/paginate",
        "per_page": 20,
        "prev_page_url": null,
        "to": <number>,
        "total": <number>
    }
}
```

### Read One Post
 Athentication not needed
#### Request And Response

##### Request
**headers** <br/>
```
Accept:        application/json
Content-Type:  application/json
```
**url**
```
GET http://{apiBaseUrl}/api/v1/posts/:postId
```
##### Response
```
{
  "error": false,
  "message": "Post created successfully",
  "post": {
    "id": <number>,
    "title": "my first blog"
    "body": "my first blog content"
    "created-at": <timestamp>
    "updated-at": <timestamp>
  }
},
```
### Get all trashed Posts
 Athentication needed
#### Request And Response

##### Request
**headers** <br/>
```
Authorization: Bearer <token>
Accept:        application/json
Content-Type:  application/json
```
**url**
```
GET http://{apiBaseUrl}/api/v1/posts/trash/
```
##### Response

```
{
  "error": false,
  "message": <string>,
  "postId": <number>localhost:8000/api/v1/posts/trash/5
}
```


### Delete(Trash) One Post
 Athentication needed
#### Request And Response

##### Request
**headers** <br/>
```
Authorization: Bearer <token>
Accept:        application/json
Content-Type:  application/json
```
**url**
```
DELETE http://{apiBaseUrl}/api/v1/posts/trash/:postId
```
##### Response
```
{
  "error": false,
  "message": <string>,
  "postId": <number>
}
```
# Restore One Post From Trash
 Athentication needed
#### Request And Response

##### Request
**headers** <br/>
```
Authorization: Bearer <token>
Accept:        application/json
Content-Type:  application/json
```
**url**
```
GET http://{apiBaseUrl}/api/v1/posts/trash/:postId
```
##### Response
```
{
  "error": false,
  "message": "restored",
  "postId": <number>
}
```

## Categories
### Create
 Only an authenticate user can create post
#### Request And Response

##### Request
**headers** <br/>
```
Authorization: Bearer <token>
Accept:        application/json
Content-Type:  application/json
```
**url**
```
POST http://{apiBaseUrl}/api/v1/categories
```
**body**
```
{
  "name": "tech",
}
```
##### Response
```
{
  "error": false,
  "message": "category created successfully",
  "post": {
    "id": <number>,
    "name": "tech"
    "created-at": <timestamp>
    "updated-at": <timestamp>
  }
}
```

### Update
 Only an authenticate user can create post
#### Request And Response

##### Request
**headers** <br/>
```
Authorization: Bearer <token>
Accept:        application/json
Content-Type:  application/json
```
**url**
```
PUT http://{apiBaseUrl}/api/v1/categories/:categoryId
```
**body**
```
{
  "name": "technology"
}
```
##### Response
```
{
  "error": false,
  "message": "Category updated successfully",
  "category": {
    "id": <number>,
    "name": "technology"
    "created-at": <timestamp>
    "updated-at": <timestamp>
  }
}
```

### Read All Categories
 Athentication not needed
#### Request And Response

##### Request
**headers** <br/>
```
Accept:        application/json
Content-Type:  application/json
```
**url**
```
GET http://{apiBaseUrl}/api/v1/posts/
```
##### Response
```
[
  {
    "error": false,
    "message": "Category created successfully",
    "categories": {
      "id": <number>,
      "name": "technology"
      "created-at": <timestamp>
      "updated-at": <timestamp>
    }
  },
  ...
]
```

### Read One category
 Athentication not needed
#### Request And Response

##### Request
**headers** <br/>
```
Accept:        application/json
Content-Type:  application/json
```
**url**
```
GET http://{apiBaseUrl}/api/v1/categories/:categoryId
```
##### Response
```
{
  "error": false,
  "message": "Category created successfully",
  "category": {
    "id": <number>,
    "name": "technology"
    "created-at": <timestamp>
    "updated-at": <timestamp>
  }
},
```



### Get All Categories
 Athentication not needed
#### Request And Response

##### Request
**headers** <br/>
```
Accept:        application/json
Content-Type:  application/json
```
**url**
```
GET http://{apiBaseUrl}/api/v1/categories/
```
##### Response
```
{
  "error": false,
  "message": <string>,
  "categories": [
    {
      "id": <number>,
      "name": "technology",
      "created-at": <timestamp>,
      "updated-at": <timestamp>
    }
  ]
}
```

### Get Category's posts
 Athentication not needed
#### Request And Response

##### Request
**headers** <br/>
```
Accept:        application/json
Content-Type:  application/json
```
**url**
```
GET http://{apiBaseUrl}/api/v1/posts/categories/:categoryId
```
##### Response
```
{
  "error": false,
  "message": "Found some related posts",
  "categoryPosts": {
    "id": <number>,
    "name": "category name",
    "created_at": <datetime>,
    "updated_at": <datetime>,
    "posts": [
      {
        "id": 3,
        "title": <string>,
        "body": <category>,
        "author_id": <number>,
        "created_at": <datetime>,
        "updated_at": <datetime>,
        "deleted_at": null,
        "pivot": {
            "category_id": <number>,
            "post_id": <number>
        }
      }
    ]
  }
}
```

### Add Post To Category Category's
 Athentication needed
#### Request And Response

##### Request
**headers** <br/>
```
Authorization: Bearer <token>
Accept:        application/json
Content-Type:  application/json
```
**url**
```
Post http://{apiBaseUrl}/api/v1/posts/categories/:categoryId

```
**body**
```
{
	"postId": <number>,
	"categoryId": <number>
}
```
##### Response
```
{
  "error": false,
  "message": "Found some related posts",
  "categoryPosts": {
    "id": <number>,
    "name": "category name",
    "created_at": <datetime>,
    "updated_at": <datetime>,
    "categoryPosts": [
      {
        "id": <number>,
        "title": <string>,
        "body": <category>,
        "author_id": <number>,
        "created_at": <datetime>,
        "updated_at": <datetime>,
        "deleted_at": null,
        "pivot": {
            "category_id": <number>,
            "post_id": <number>
        }
      },
      ...
    ]
  }
}
```
### Remove post from category
 Athentication needed
#### Request And Response

##### Request
**headers** <br/>
```
Authorization: Bearer <token>
Accept:        application/json
Content-Type:  application/json
```
**url**
```
DELTE http://{apiBaseUrl}/api/v1/posts/:postId/categories/:categoryId

```
##### Response
```
{
  "error": false,
  "message": "Post removed from category",
  "categoryPosts": {
    "id": <number>,
    "name": "category name",
    "created_at": <datetime>,
    "updated_at": <datetime>,
    "categoryPosts": [
      {
        "id": <number>,
        "title": <string>,
        "body": <category>,
        "author_id": <number>,
        "created_at": <datetime>,
        "updated_at": <datetime>,
        "deleted_at": null,
        "pivot": {
            "category_id": <number>,
            "post_id": <number>
        }
      },
      ...
    ]
  }
}
```







## Tags
### Add Tag To Note
 Only an authenticate user can create post
#### Request And Response

##### Request
**headers** <br/>
```
Authorization: Bearer <token>
Accept:        application/json
Content-Type:  application/json
```
**url**
```
POST http://{apiBaseUrl}/api/v1/posts/tagss
```
**body**
```
{
  "postId": <number>
  "name": "microsoft",
}
```
##### Response
```
{
  "error": false,
  "message": <string>,
  "postCategories": {
    "postId": <number>,
    "categoryId": <number>
  }
}
```

### Delete Tag From Post
 Only an authenticate user can create post
#### Request And Response

##### Request
**headers** <br/>
```
Authorization: Bearer <token>
Accept:        application/json
Content-Type:  application/json
```
**url**
```
DELETE http://{apiBaseUrl}/api/v1/posts/:postId/tags/:tagId
```

##### Response
```
{
  "error": false,
  "message": "Category updated successfully",
  "tagPost": <tagPost>
}
```

### Read Tag Posts
 Athentication not needed
#### Request And Response

##### Request
**headers** <br/>
```
Accept:        application/json
Content-Type:  application/json
```

**url**
```
GET http//{apiBaseUrl}/api/v1/tags/{tagId}/posts
```
##### Response
```
{
  "error": false,
  "message": "Found some related posts",
  "tagPosts": {
      "id": <number>,
      "name": "second tag",
      "created_at": <datetime>,
      "updated_at": <datetime>,
      "posts": [
        {
          "id": <datetime>,
          "title": <string>,
          "body": <string>,
          "author_id": <number>,
          "created_at": <datetime>,
          "updated_at": <datetime>,
          "deleted_at": null,
          "pivot": {
              "tag_id": <number>,
              "post_id": <number>
          }
        }
      ]
  }
}
```
## How To Contribute
If you found a bug or want a feature, feel free to raise an issue. You can also write a fix and raise a pull request

## Licence
[BSD 3](./LICENSE.md)
