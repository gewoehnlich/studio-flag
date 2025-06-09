# studio-flag

## Стек
* PHP 8.4.6
* Nginx
* MySQL 9.3
* Laravel 12
* Docker
* Composer

## Как запустить (через Docker)
Можно запустить проект через Makefile

```
make build
```

или без Makefile

```
composer install
docker compose up --build

```

также для работы Job в Laravel нужно запустить команду 
```
php artisan queue:work
```

## Как запустить (без Docker)
```
composer run dev
php artisan queue:work
```

## Авторизация пользователя
```
POST /api/register
Headers => "Accept": "application/json"
{
    "name": "name",
    "email": "email@example.com",
    "password": "password"
}

Response:
{
    "success": true,
    "message": "Вы успешно зарегистрировались!",
    "user": {
        "id": 1,
        "name": "name",
        "email": "email@example.com"
    },
    "token": "1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132"
}
```
```
POST /api/login
Headers => "Accept": "application/json"
{
    "email": "email@example.com",
    "password": "password"
}

Response:
{
    "success": true,
    "message": "Вы успешно вошли в свой аккаунт!",
    "user": {
        "id": 1,
        "name": "name",
        "email": "email@example.com"
    },
    "token": "2|wkrC6t0xc9WVlds5EZ9woHWS3Ic3sfajOF8fYGLU66ca31a0"
}
```
```
POST /api/logout
Headers => "Accept": "application/json"
Authorization: Bearer Token (например, 1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132)

Response:
{
    "success": true,
    "message": "Вы успешно вышли со своего аккаунта!",
    "user": {
        "id": 1,
        "name": "name",
        "email": "email@example.com"
    }
}
```
## Добавить товар в корзину пользователя
```
POST /api/products
Headers => "Accept": "application/json"
Authorization: Bearer Token (например, 1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132)

{
    "title": "title",
    "description": "description",
    "price": "1000.00",
    "stock": 3
}

Response:
{
    "success": true,
    "message": "Успешно создан новый товар!",
    "result": {
        "id": 2,
        "title": "title",
        "description": "description",
        "price": "1000.00",
        "stock": 3
    }
}
```
## Удалить товар из корзины пользователя
```
DELETE /api/products/{id}/
Headers => "Accept": "application/json"
Authorization: Bearer Token (например, 1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132)

Response:
{
    "success": true,
    "message": "Успешно удален товар № {id}!"
}
```
## Получить товар по id
```
GET /api/products?id={id}
Headers => "Accept": "application/json"
Authorization: Bearer Token (например, 1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132)

Response:
{
    "success": true,
    "result": [
        {
            "id": {id},
            "title": "title",
            "description": "description",
            "price": "1000.00",
            "stock": 3
        }
    ]
}
```
## Получить список товаров
```
GET /api/products
Headers => "Accept": "application/json"
Authorization: Bearer Token (например, 1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132)

Filters:
    'lower_price' => 'nullable|numeric|between:0,99999.99',
    'upper_price' => 'nullable|numeric|between:0,99999.99',
    'order_by'    => 'nullable|string|in:asc,desc',
    'limit'       => 'nullable|integer',
    'id'          => 'nullable|integer'

Response:
{
    "success": true,
    "result": [
        {
            "id": 1,
            "title": "title",
            "description": null,
            "price": "1000.00",
            "stock": 3
        }
    ]
}
```
## Сортировка по цене
```
GET /api/products?lower_price={lower_price}&upper_price={upper_price}
Headers => "Accept": "application/json"
Authorization: Bearer Token (например, 1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132)

Filters:
    'lower_price' => 'nullable|numeric|between:0,99999.99',
    'upper_price' => 'nullable|numeric|between:0,99999.99',
    'order_by'    => 'nullable|string|in:asc,desc',
    'limit'       => 'nullable|integer',
    'id'          => 'nullable|integer'

Response:
{
    "success": true,
    "result": [
        {
            "id": 1,
            "title": "title",
            "description": "description",
            "price": "1000.00",
            "stock": 3
        },
        {
            "id": 2,
            "title": "title",
            "description": "description",
            "price": "1005.00",
            "stock": 3
        }
    ]
}
```
## Оплатить Корзину (создать заказ, получить ссылку на оплату)
```
POST /api/orders
Headers => "Accept": "application/json"
Authorization: Bearer Token (например, 1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132)

Response: 
{
    "success": true,
    "message": "Успешно создан новый заказ!\\nПерейдите по ссылке для оплаты: http://127.0.0.1:8000/api/payments/link?order_id=6&payment_method_id=1",
    "result": {
        "id": 6,
        "user_id": 1,
        "payment_method_id": 1,
        "status": "pending"
    }
}
```
## Обновить статус заказа на “Оплачен”
```
PUT /api/orders/{id}/
Headers => "Accept": "application/json"
Authorization: Bearer Token (например, 1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132)

{
    "status": "paid"
}

Response:
{
    "success": true,
    "message": "Успешно обновлен заказ № {id}!"
}
```
## Получить список заказов
```
GET /api/orders
Headers => "Accept": "application/json"
Authorization: Bearer Token (например, 1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132)

Filters:
    'start_date' => 'nullable|date|date_format:Y-m-d',
    'end_date'   => 'nullable|date|date_format:Y-m-d',
    'status'     => ['nullable', Rule::enum(OrderStatus::class)],

Response:
{
    "success": true,
    "result": [
        {
            "id": 1,
            "user_id": 1,
            "payment_method_id": 1,
            "status": "paid"
        },
        {
            "id": 2,
            "user_id": 1,
            "payment_method_id": 1,
            "status": "cancelled"
        }
    ]
}
```
## Сортировка по дате создания заказа
```
GET /api/orders
Headers => "Accept": "application/json"
Authorization: Bearer Token (например, 1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132)

Filters:
    'start_date' => 'nullable|date|date_format:Y-m-d',
    'end_date'   => 'nullable|date|date_format:Y-m-d',
    'status'     => ['nullable', Rule::enum(OrderStatus::class)],

Response:
{
    "success": true,
    "result": [
        {
            "id": 1,
            "user_id": 1,
            "payment_method_id": 1,
            "status": "paid"
        },
        {
            "id": 2,
            "user_id": 1,
            "payment_method_id": 1,
            "status": "cancelled"
        }
    ]
}
```
## Фильтрация по статусу заказа
```
GET /api/orders?status={status}
Headers => "Accept": "application/json"
Authorization: Bearer Token (например, 1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132)

Filters:
    'start_date' => 'nullable|date|date_format:Y-m-d',
    'end_date'   => 'nullable|date|date_format:Y-m-d',
    'status'     => ['nullable', Rule::enum(OrderStatus::class)],

Response:
{
    "success": true,
    "result": [
        {
            "id": 1,
            "user_id": 1,
            "payment_method_id": 1,
            "status": {status}
        },
        {
            "id": 2,
            "user_id": 1,
            "payment_method_id": 1,
            "status": {status}
        }
    ]
}
```
## Получить заказ по id
```
GET /api/orders?id={id}
Headers => "Accept": "application/json"
Authorization: Bearer Token (например, 1|FQK6NGt7B0edfbYDpBS60K97ABQp2mTVbQuIGydj01c5e132)

Response:
{
    "success": true,
    "result": [
        {
            "id": {id},
            "user_id": 1,
            "payment_method_id": 1,
            "status": {status}
        }
    ]
}
```
## Обновление статуса заказа с “На оплату” в “Отменен”, при неоплате его более 2 минут
При создании заказа создается Job
для его работы обязательно запустить 'php artisan queue:work'


## Удаление
Запускаем команду:
```
make delete
```

или

```
docker compose down -v
```
