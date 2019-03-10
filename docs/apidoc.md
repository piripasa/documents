#Document API

#Table of Contents <a name="toc"></a>

1. [Document](#Document)
	- [Create User](#cu)
	- [User Auth](#ua)
	- [Create Document](#cn)
	- [Update Document](#un)
	- [List Documents](#gnl)
	- [Get Document](#gnd)
	- [Delete Document](#dn)
9. [Error response](#er)

### Create User <a name="cu"></a> ([Top](#toc))
#### [http://127.0.0.1/api/v1/users](http://127.0.0.1/api/v1/users)
#### Request type - POST
##### POST Parameters
form-data |Data Type | Description | Required
--- | --- | --- | ---
name | string | Text content | YES
email | email | Email | YES
password | password | Password | YES
confirm_password | password | Password | YES

```


```
```


```
```


```

### User Auth <a name="ua"></a> ([Top](#toc))
#### [http://127.0.0.1/api/v1/auth/tokens](http://127.0.0.1/api/v1/auth/tokens)
#### Request type - POST
##### POST Parameters
form-data |Data Type | Description | Required
--- | --- | --- | ---
email | email | Email | YES
password | password | Password | YES

```


```
```


```

## Document <a name="Document"></a>
### Create Document <a name="cn"></a> ([Top](#toc))
#### [http://127.0.0.1/api/v1/documents](http://127.0.0.1/api/v1/documents)
#### Request type - POST
##### Headers
header-data |Data Type | Description | Required
--- | --- | --- | ---
Authorization | string | JWT token | YES
##### POST Parameters
form-data |Data Type | Description | Required
--- | --- | --- | ---
file | file | File content | YES

```


```
```


```

### Update Document <a name="un"></a> ([Top](#toc))
#### [http://127.0.0.1/api/v1/documents/{id}](http://127.0.0.1/api/v1/documents/1)
#### Request type - PATCH
##### Headers
header-data |Data Type | Description | Required
--- | --- | --- | ---
Authorization | string | JWT token | YES
##### PATCH Parameters
form-data |Data Type | Description | Required
--- | --- | --- | ---
field | string/bool/numeric | Various data | YES

```


```
```


```

### Get Documents <a name="gnl"></a> ([Top](#toc))
#### [http://127.0.0.1/api/v1/documents](http://127.0.0.1/api/v1/documents)
#### Request type - GET

```


```

### Get Document Details<a name="gnd"></a> ([Top](#toc))
#### [http://127.0.0.1/api/v1/documents/{id}](http://127.0.0.1/api/v1/documents/{id})
#### Request type - GET
##### Query Parameters
Query params | Data Type | Description | Required
--- | --- | --- | ---
id | int| Document ID | YES

```


```
```


```

### Delete Document <a name="dn"></a> ([Top](#toc))
#### [http://127.0.0.1/api/v1/document/{id}](http://127.0.0.1/api/v1/documents/{id})
#### Request type - DELETE
##### Headers
header-data |Data Type | Description | Required
--- | --- | --- | ---
Authorization | string | JWT token | YES
##### DELETE Parameters
form-data |Data Type | Description | Required
--- | --- | --- | ---
id | int| Document ID | YES

```


```
```


```

### Error response <a name="er"></a> ([Top](#toc))

```


```
