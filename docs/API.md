# Northwind BMS API

Base path: `/api/v1` · Content type: `application/json`

Interactive reference: open [`swagger.html`](swagger.html) or edit [`openapi.yaml`](openapi.yaml) in Swagger Editor.

## Authentication

`POST /auth/login` is public. All other endpoints require `Authorization: Bearer <token>`.

Request:

```json
{"username":"admin","password":"your-password"}
```

Success `200`:

```json
{"status":true,"data":{"token":"<jwt>","user":{"id":1,"username":"admin"}}}
```

## Endpoints

| Method | Endpoint | Purpose |
|---|---|---|
| POST | `/auth/login` | Sign in and receive a JWT |
| GET | `/auth/me` | Return the authenticated user |
| GET | `/dashboard` | KPI counts, estimated sales, recent orders, popular products |
| GET | `/reports` | Order lines, orders by date, popular products, estimated sales |
| GET | `/products?page=1&limit=25&search=&category_id=` | List products; optional name search and category filter |
| GET, POST | `/products` | List or create a product |
| GET, PUT, DELETE | `/products/{id}` | Read, update, or delete a product |
| GET, POST | `/categories` | List or create a category |
| GET, PUT, DELETE | `/categories/{id}` | Read, update, or delete a category |
| GET, POST | `/customers` | List or create a customer |
| GET, PUT, DELETE | `/customers/{id}` | Read, update, or delete a customer |
| GET, POST | `/suppliers` | List or create a supplier |
| GET, PUT, DELETE | `/suppliers/{id}` | Read, update, or delete a supplier |
| GET, POST | `/employees` | List or create an employee |
| GET, PUT, DELETE | `/employees/{id}` | Read, update, or delete an employee |
| GET, POST | `/shippers` | List or create a shipper |
| GET, PUT, DELETE | `/shippers/{id}` | Read, update, or delete a shipper |
| GET | `/orders?page=1&limit=25` | List orders with customer, employee, shipper, item count, and estimated total |
| GET | `/orders/{id}` | Read an order and its items |
| POST | `/orders` | Create an order |
| DELETE | `/orders/{id}` | Delete an order and its details |

Catalog create/update bodies use the API field names shown below. Primary IDs for legacy tables without auto-increment are assigned by the API when creating records.

Product:

```json
{"name":"Chai","supplier_id":1,"category_id":1,"unit":"10 boxes","price":18}
```

Order:

```json
{"customer_id":1,"employee_id":1,"shipper_id":1,"product_id":1,"quantity":2,"order_date":"8/11/2026"}
```

Product list response `200` includes category and supplier names:

```json
{"status":true,"data":[{"id":1,"name":"Chai","supplier_id":1,"supplier_name":"Exotic Liquids","category_id":1,"category_name":"Beverages","unit":"10 boxes","price":18}],"total":1,"page":1,"limit":25}
```

The reports response includes `order_lines` with order date, customer and country, employee, shipper, product and category, quantity, current unit price, and estimated line total. `popular_products` includes product ID, category, supplier, package unit, quantity, current unit price, and estimated sales. The dashboard and order list also include estimated totals. These totals use the product's **current** price because the legacy order detail table does not store the historical unit price; use them as estimates, not accounting records.

The Reports screen exports detailed order lines or popular product summaries as UTF-8 CSV files. The order detail CSV includes customer, country, employee, shipper, product and category, quantity, current unit price, and estimated line total. The popular products CSV also includes product ID, supplier, and package unit.

Errors return `{ "status": false, "error": "..." }`. Common HTTP codes: `401` missing/expired token or bad credentials, `404` unknown resource, `422` invalid request fields, `500` database/setup failure.
