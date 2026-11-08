# Northwind BMS

ระบบบริหารข้อมูล Northwind สำหรับสินค้า ลูกค้า ผู้จัดจำหน่าย พนักงาน คำสั่งซื้อ และรายงาน แยก Frontend แบบ HTML/CSS/JavaScript ออกจาก Backend REST API ที่พัฒนาด้วย PHP และ PDO เชื่อมต่อ MySQL

## ความสามารถหลัก

- Dashboard แสดงจำนวนข้อมูล ยอดขายประมาณการ คำสั่งซื้อล่าสุด และสินค้าขายดี
- จัดการสินค้า หมวดหมู่ ลูกค้า ผู้จัดจำหน่าย พนักงาน และบริษัทขนส่ง
- ค้นหาและกรองรายการสินค้า พร้อมเพิ่ม แก้ไข และลบข้อมูล
- ดูคำสั่งซื้อและรายการสินค้า พร้อมข้อมูลลูกค้า พนักงาน และการจัดส่ง
- รายงานคำสั่งซื้อและสินค้าขายดี พร้อมส่งออก CSV
- Responsive layout สำหรับ desktop และมือถือ พร้อมเมนู emoji และ favicon
- รองรับภาษา English และไทย โดยเริ่มต้นเป็น English และจำภาษาที่เลือกไว้
- API ใช้ JWT Bearer token และมีเอกสาร OpenAPI/Swagger

## โครงสร้างโปรเจกต์

```text
Web-app-II/
├── api/
│   ├── config.php                 # โหลดค่าฐานข้อมูลและ JWT จาก environment
│   ├── index.php                  # API entry point
│   └── src/
│       ├── Api.php                # Route, authentication และ API handlers
│       ├── Database.php           # การเชื่อมต่อ MySQL ผ่าน PDO
│       └── Models/Entity.php      # mapping ระหว่าง API กับ schema เดิม
├── docs/
│   ├── API.md                     # รายละเอียด endpoints และตัวอย่าง
│   ├── SETUP.md                   # ขั้นตอนติดตั้งและรัน local
│   ├── openapi.yaml               # OpenAPI 3.1 specification
│   └── swagger.html               # Swagger UI
├── public/
│   ├── index.html                 # หน้าเว็บและ layout หลัก
│   ├── favicon.svg                # ไอคอนเว็บ
│   └── assets/
│       ├── css/app.css            # รูปแบบและ responsive layout
│       ├── js/i18n.js             # สลับภาษา English/ไทย และบันทึกภาษาที่เลือก
│       └── js/app.js              # หน้าจอ การนำทาง และการเรียก API
├── scripts/
│   ├── dev.js                     # เริ่ม PHP development server
│   └── router.php                 # เส้นทางสำหรับ PHP built-in server
├── dbNorthwind.sql                # schema และข้อมูลตัวอย่างสำหรับติดตั้ง
├── index.php                      # หน้า entry point สำหรับ Apache
├── .env.example                   # ตัวอย่าง environment settings
└── package.json                   # คำสั่ง npm สำหรับรัน local
```

## API Endpoints

Base path: `/api/v1` · ส่งและรับข้อมูลในรูปแบบ JSON · ทุก endpoint ต้องใช้ `Authorization: Bearer <token>` ยกเว้น `POST /auth/login`

| Method | Endpoint | หน้าที่ |
|---|---|---|
| POST | `/auth/login` | เข้าสู่ระบบและรับ JWT |
| GET | `/auth/me` | ตรวจสอบผู้ใช้ปัจจุบัน |
| GET | `/dashboard` | KPI, ยอดขายประมาณการ, คำสั่งซื้อล่าสุด และสินค้าขายดี |
| GET | `/reports` | รายงานตามวัน รายการสั่งซื้อ และข้อมูลสินค้าขายดี |
| GET, POST | `/products` | แสดงรายการหรือเพิ่มสินค้า; รองรับ `page`, `limit`, `search`, `category_id` |
| GET, PUT, DELETE | `/products/{id}` | อ่าน แก้ไข หรือลบสินค้า |
| GET, POST | `/categories` | แสดงรายการหรือเพิ่มหมวดหมู่ |
| GET, PUT, DELETE | `/categories/{id}` | อ่าน แก้ไข หรือลบหมวดหมู่ |
| GET, POST | `/customers` | แสดงรายการหรือเพิ่มลูกค้า |
| GET, PUT, DELETE | `/customers/{id}` | อ่าน แก้ไข หรือลบลูกค้า |
| GET, POST | `/suppliers` | แสดงรายการหรือเพิ่มผู้จัดจำหน่าย |
| GET, PUT, DELETE | `/suppliers/{id}` | อ่าน แก้ไข หรือลบผู้จัดจำหน่าย |
| GET, POST | `/employees` | แสดงรายการหรือเพิ่มพนักงาน |
| GET, PUT, DELETE | `/employees/{id}` | อ่าน แก้ไข หรือลบพนักงาน |
| GET, POST | `/shippers` | แสดงรายการหรือเพิ่มบริษัทขนส่ง |
| GET, PUT, DELETE | `/shippers/{id}` | อ่าน แก้ไข หรือลบบริษัทขนส่ง |
| GET | `/orders` | แสดงรายการคำสั่งซื้อ พร้อมจำนวนรายการและยอดประมาณการ; รองรับ `page`, `limit` |
| GET | `/orders/{id}` | อ่านคำสั่งซื้อพร้อมรายการสินค้า |
| POST | `/orders` | สร้างคำสั่งซื้อ |
| DELETE | `/orders/{id}` | ลบคำสั่งซื้อและรายละเอียด |

ดู schema และตัวอย่าง request/response เพิ่มเติมใน [เอกสาร API](docs/API.md) หรือเปิด [Swagger UI](docs/swagger.html)

> **หมายเหตุยอดขาย:** ฐานข้อมูลเดิมไม่ได้เก็บราคาต่อหน่วยในแต่ละรายการสั่งซื้อ ยอดใน Dashboard, รายงาน และ CSV จึงคำนวณจากราคาสินค้าปัจจุบันและเป็นค่าประมาณ

## เริ่มใช้งานบนเครื่อง

ต้องมี Node.js, PHP 8.1+ พร้อม PDO MySQL และ MySQL 8:

1. สร้างฐานข้อมูล `db_northwind` แล้ว import `dbNorthwind.sql`.
2. คัดลอก `.env.example` เป็น `.env` และกำหนดค่าฐานข้อมูลกับ `JWT_SECRET`.
3. รัน `npm.cmd run dev` บน Windows หรือ `npm run dev` บน macOS/Linux.
4. เปิด `http://127.0.0.1:8000`.

ไม่มี `npm install` ที่ต้องทำสำหรับ development server นี้. ดูรายละเอียดเพิ่มเติมที่ [คู่มือติดตั้ง](docs/SETUP.md)

ข้อมูลตัวอย่างมีบัญชี `admin` / `admin1234`, `mango` / `magno123` และ `banana` / `banana` โดย SQL เก็บรหัสผ่านเป็น hash เปลี่ยนบัญชีตัวอย่างและใช้ `JWT_SECRET` ที่สุ่มใหม่ก่อน deploy

## Deploy

ใช้ hosting ที่รองรับ PHP และ MySQL ตั้ง document root ไปที่โฟลเดอร์โปรเจกต์ กำหนด environment variables ให้ครบ และ import schema จาก `dbNorthwind.sql` การเลือกและตั้งค่า hosting ทำแยกโดยเจ้าของโปรเจกต์
