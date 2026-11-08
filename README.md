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

## Deploy บน Render

โปรเจกต์มี `Dockerfile` สำหรับ Render แล้ว ให้สร้างบริการแบบ **Web Service** จาก repository นี้ และตั้งค่า:

```text
Language: Docker
Branch: main
Root Directory: เว้นว่าง
Build Command: เว้นว่าง
Start Command: เว้นว่าง
Compute: Free
```

เพิ่ม Environment Variables ใน Render:

```text
DB_HOST=<MySQL host ที่เปิด remote connection>
DB_PORT=3306
DB_NAME=<ชื่อฐานข้อมูลบน hosting>
DB_USER=<ชื่อผู้ใช้ฐานข้อมูล>
DB_PASS=<รหัสผ่านฐานข้อมูล>
JWT_SECRET=<สุ่มค่าใหม่อย่างน้อย 32 ตัวอักษร>
```

Render ไม่มี MySQL ในตัว จึงต้องใช้ MySQL จากผู้ให้บริการอื่นที่อนุญาตให้ Render เชื่อมต่อผ่าน port 3306 แล้ว import `dbNorthwind.sql` ก่อนเปิดเว็บ

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


