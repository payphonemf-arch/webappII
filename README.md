# Northwind BMS

ระบบจัดการธุรกิจ Northwind สำหรับข้อมูลสินค้า ลูกค้า ผู้จัดจำหน่าย พนักงาน คำสั่งซื้อ และรายงาน พัฒนาด้วย Bootstrap 5, JavaScript, PHP 8.1+ และ MySQL 8 โดยแยกหน้าเว็บออกจาก REST API และใช้ PDO

## ฟีเจอร์

- เข้าสู่ระบบด้วย JWT และป้องกัน API ด้วย Bearer token
- Dashboard แสดง KPI ยอดขายประมาณการ คำสั่งซื้อล่าสุด และสินค้าขายดี
- รายการสินค้า ค้นหา เพิ่ม แก้ไข และลบ
- จัดการหมวดหมู่ ลูกค้า ผู้จัดจำหน่าย พนักงาน และบริษัทขนส่ง
- รายการคำสั่งซื้อและหน้ารายละเอียดสินค้าในคำสั่งซื้อ
- รายงานพร้อมรายละเอียดลูกค้า/สินค้า/การจัดส่ง และส่งออก CSV รายการสั่งซื้อหรือสินค้าขายดี
- Responsive UI สำหรับ desktop และมือถือ
- API Documentation และคู่มือติดตั้งใน `docs/`

## โครงสร้างโปรเจกต์

```text
api/
  config.php                 การตั้งค่าฐานข้อมูลและ JWT จาก environment
  index.php                  API front controller
  src/
    Api.php                  รับ route และประมวลผล HTTP request/response
    Database.php             PDO connection
    Models/Entity.php        mapping ระหว่าง API กับ schema ฐานข้อมูลเดิม
public/
  index.html                 หน้าเว็บแอป
  assets/css/app.css         รูปแบบและ responsive layout
  assets/js/app.js           การนำทางและเรียก API
docs/API.md                  รายการ endpoint และตัวอย่าง request/response
docs/SETUP.md                คู่มือติดตั้ง
docs/openapi.yaml            OpenAPI 3.1 specification
docs/swagger.html            Swagger UI สำหรับดูและเรียก API
scripts/dev.js               launcher สำหรับ PHP local server
scripts/router.php           router สำหรับ PHP built-in server
dbNorthwind.sql              โครงสร้างและข้อมูลตัวอย่าง Northwind
```

## เริ่มใช้งาน

ติดตั้ง Node.js, PHP 8.1 ขึ้นไปพร้อม PDO MySQL และ MySQL 8 จากนั้นสร้างฐานข้อมูล `db_northwind`, import `dbNorthwind.sql`, คัดลอก `.env.example` เป็น `.env` แล้วรัน `npm.cmd run dev` บน Windows เปิด `http://127.0.0.1:8000` ดูขั้นตอนเพิ่มเติมที่ [docs/SETUP.md](docs/SETUP.md).

ไฟล์ SQL เก็บรหัสผ่านบัญชีตัวอย่างเป็น hash: `admin` / `admin1234`, `mango` / `magno123`, `banana` / `banana` โปรดเปลี่ยนบัญชีตัวอย่างและตั้ง `JWT_SECRET` ใหม่ก่อน deploy

## API

ดู endpoint, วิธี authentication, รูปแบบข้อมูล และตัวอย่างที่ [docs/API.md](docs/API.md) หรือเปิด interactive docs ที่ [docs/swagger.html](docs/swagger.html). ทุก endpoint ยกเว้น `POST /api/v1/auth/login` ต้องส่ง `Authorization: Bearer <token>`.

SQL รับค่าจาก request ผ่าน PDO prepared statements และ mapping ตาราง/คอลัมน์จำกัดไว้ใน model เพื่อไม่รับชื่อตารางจากผู้ใช้

## ขอบเขตการส่งมอบ

โครงการนี้เตรียมแอปและคู่มือติดตั้งสำหรับ hosting ที่รองรับ PHP + MySQL การสร้าง hosting, import ฐานข้อมูลบนผู้ให้บริการ และส่ง Public URL ทำภายหลังโดยเจ้าของโปรเจกต์
