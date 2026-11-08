(() => {
  'use strict';

  const translations = {
    'ข้อมูลสำคัญของธุรกิจ พร้อมให้คุณตัดสินใจได้อย่างมั่นใจ': 'Business insights to help you make confident decisions',
    'ติดตามข้อมูลสำคัญและความเคลื่อนไหวของ Northwind วันนี้.': "Track Northwind's key metrics and activity.",
    'ภาพรวมรายการสินค้า ลูกค้า คำสั่งซื้อ และยอดขายประมาณการ': 'An overview of products, customers, orders, and estimated sales',
    'จัดการรายการสินค้า ราคา และข้อมูลสต็อก': 'Manage products, pricing, and stock information',
    'จัดกลุ่มสินค้าให้ค้นหาและจัดการได้ง่ายขึ้น': 'Group products to make them easier to find and manage',
    'ข้อมูลลูกค้าและช่องทางติดต่อ': 'Customer information and contact details',
    'จัดการข้อมูลคู่ค้าและผู้จัดส่งสินค้า': 'Manage supplier information and product sourcing',
    'ข้อมูลทีมงานและประวัติพนักงาน': 'Team information and employee records',
    'จัดการบริษัทขนส่งและข้อมูลติดต่อ': 'Manage shipping companies and contact details',
    'ตรวจสอบลูกค้า รายการสินค้า และยอดประมาณการของแต่ละคำสั่งซื้อ.': 'Review customers, items, and estimated totals for each order.',
    'ติดตามคำสั่งซื้อและดูรายละเอียดการจัดส่ง.': 'Track orders and review shipping details.',
    'รายงานคำสั่งซื้อแบบเจาะรายการและสินค้าขายดี.': 'Order line details and best-selling products.',
    'ภาพรวมคำสั่งซื้อและสินค้ายอดนิยม.': 'An overview of orders and popular products.',
    'ยอดขายเป็นค่าประมาณจากราคาสินค้าปัจจุบัน เนื่องจากฐานข้อมูลต้นฉบับไม่ได้บันทึกราคาต่อหน่วยในแต่ละรายการสั่งซื้อ': 'Sales are estimated using current product prices because the source database does not store the unit price for each order line.',
    'คำนวณจากราคาสินค้าปัจจุบัน': 'Based on current product prices',
    'พร้อมจำนวนรายการและยอดประมาณการ': 'Including item count and estimated total',
    'จำนวนหน่วยที่สั่ง': 'Units ordered',
    'จำนวนรายการแยกตามวันที่': 'Order count by date',
    'จำนวนรายการแยกตามวันที่ในข้อมูล': 'Order count by date in the database',
    'สินค้าที่มีจำนวนรวมสูงสุด': 'Products with the highest total quantity',
    'รายละเอียดคำสั่งซื้อ': 'Order details',
    'เลือกรายการคำสั่งซื้อเพื่อดูรายละเอียด': 'Select an order to view its details',
    'หน้ารายงาน': 'Reports',
    'ภาพรวมธุรกิจ': 'Business Overview',
    'จัดการข้อมูล': 'MANAGE DATA',
    'ข้อมูลเชิงลึก': 'INSIGHTS',
    'ภาพรวม': 'Overview',
    'หมวดหมู่สินค้า': 'Categories',
    'คำสั่งซื้อ': 'Orders',
    'ผู้จัดจำหน่าย': 'Suppliers',
    'บริษัทขนส่ง': 'Shippers',
    'พนักงาน': 'Employees',
    'ลูกค้า': 'Customers',
    'สินค้า': 'Products',
    'รายงาน': 'Reports',
    'สินค้าขายดี': 'Best-selling products',
    'สินค้าตามจำนวนสั่งซื้อ': 'Products by quantity ordered',
    'คำสั่งซื้อตามวัน': 'Orders by date',
    'คำสั่งซื้อล่าสุด': 'Recent orders',
    'กิจกรรมคำสั่งซื้อ': 'Order activity',
    'ยอดขายประมาณการ': 'Estimated sales',
    'จำนวนวันในรายงาน': 'Days in report',
    'จำนวนรายการ': 'Items',
    'จำนวนสินค้า': 'Product count',
    'จำนวนสินค้าในคำสั่งซื้อ': 'Items in order',
    'จำนวนรายการสั่งซื้อ': 'Order line count',
    'จำนวนหน่วย': 'Units',
    'ยอดประมาณการ': 'Estimated total',
    'ยอดโดยประมาณ': 'Estimated amount',
    'มูลค่าโดยประมาณ': 'Estimated value',
    'ราคาต่อหน่วย': 'Unit price',
    'ราคาปัจจุบันต่อหน่วย': 'Current unit price',
    'บรรจุภัณฑ์': 'Package unit',
    'รหัสผู้จัดจำหน่าย': 'Supplier',
    'รหัสหมวดหมู่': 'Category',
    'รหัสคำสั่งซื้อ': 'Order ID',
    'เลขที่คำสั่งซื้อ': 'Order ID',
    'เลขที่ / วันที่': 'Order / Date',
    'เลขที่': 'ID',
    'รหัสไปรษณีย์': 'Postal code',
    'รหัสลูกค้า': 'Customer ID',
    'รหัสพนักงาน': 'Employee ID',
    'รหัสสินค้า': 'Product ID',
    'รหัสบริษัทขนส่ง': 'Shipper ID',
    'รหัส': 'ID',
    'ชื่อสินค้า': 'Product name',
    'ชื่อลูกค้า / บริษัท': 'Customer / Company name',
    'ชื่อหมวดหมู่': 'Category name',
    'ชื่อบริษัท': 'Company name',
    'ชื่อผู้ใช้': 'Username',
    'ผู้ติดต่อ': 'Contact',
    'บริษัทขนส่ง': 'Shipping company',
    'หมวดหมู่': 'Category',
    'ประเทศ': 'Country',
    'เมือง': 'City',
    'ที่อยู่': 'Address',
    'โทรศัพท์': 'Phone',
    'วันเกิด': 'Birth date',
    'ไฟล์รูป': 'Photo',
    'หมายเหตุ': 'Notes',
    'รายละเอียด': 'Description',
    'วันที่สั่งซื้อ': 'Order date',
    'วันที่': 'Date',
    'ลูกค้าทั้งหมด': 'Total customers',
    'บัญชีลูกค้า': 'Customer accounts',
    'รายการสินค้า': 'Products',
    'รายการในระบบ': 'Records in system',
    'คู่ค้าทั้งหมด': 'Total suppliers',
    'ทั้งหมด': 'Total',
    'ค้นหาชื่อสินค้า...': 'Search products...',
    'ทุกหมวดหมู่': 'All categories',
    'จัดการ': 'Actions',
    'บันทึกข้อมูล': 'Save changes',
    'บันทึกการแก้ไขแล้ว': 'Changes saved',
    'เพิ่มรายการเรียบร้อยแล้ว': 'Record added',
    'สร้างคำสั่งซื้อ': 'Create order',
    'เพิ่มสินค้า': 'Add product',
    'แก้ไขสินค้า': 'Edit product',
    'แก้ไข': 'Edit ',
    'ลบ': 'Delete',
    'เพิ่ม': 'Add ',
    'ยกเลิก': 'Cancel',
    'บันทึก': 'Save',
    'ดูทั้งหมด ↗': 'View all ↗',
    'ดูรายงาน ↗': 'View reports ↗',
    'ดูทั้งหมด': 'View all',
    'รีเฟรช': 'Refresh',
    'เปิดรายงาน ↗': 'Open reports ↗',
    'ส่งออกรายงาน CSV': 'Export report CSV',
    'CSV สินค้าขายดี': 'Best-selling products CSV',
    'CSV รายการสั่งซื้อ': 'Order details CSV',
    'จำนวนสั่งซื้อ': 'Quantity ordered',
    'รายการล่าสุด': 'Latest records',
    'บริษัท': 'Company',
    'ขนส่ง': 'Shipper',
    'สถานะ': 'Status',
    'การจัดการ': 'Actions',
    'ราคาปัจจุบัน': 'Current price',
    'ประเทศ / เมือง': 'Country / City',
    'รายละเอียดคำสั่งซื้อ': 'Order details',
    'เพิ่มรายการ': 'Add record',
    'เลือก': 'Select',
    'กรอกข้อมูล': 'Enter details',
    'ชื่อ': 'First name',
    'นามสกุล': 'Last name',
    'ประเทศ': 'Country',
    'ระบบออนไลน์': 'System online',
    'กำลังโหลดข้อมูล...': 'Loading data...',
    'กำลังโหลด...': 'Loading...',
    'ต้องการความช่วยเหลือ?': 'Need help?',
    'ดูคู่มือ API และเอกสารระบบ': 'View API guide and system documentation',
    'เปิด Swagger UI ↗': 'Open Swagger UI ↗',
    'เปิด Swagger UI': 'Open Swagger UI',
    'ผู้ดูแลระบบ': 'Administrator',
    'ออกจากระบบ': 'Sign out',
    'เปิดเมนู': 'Open menu',
    'ปิด': 'Close',
    'ยินดีต้อนรับกลับ': 'Welcome back',
    'เข้าสู่ระบบ': 'Sign in',
    'ลงชื่อเข้าใช้เพื่อจัดการธุรกิจของคุณ': 'Sign in to manage your business',
    'เช่น admin': 'e.g. admin',
    'กรอกรหัสผ่าน': 'Enter your password',
    'การเชื่อมต่อของคุณได้รับการปกป้อง': 'Your connection is protected',
    'รายงานตามวัน': 'Orders by date',
    'ลูกค้า / ประเทศ': 'Customer / Country',
    'สินค้า / หมวดหมู่': 'Product / Category',
    'จำนวน': 'Quantity',
    'ผู้จัดส่ง': 'Shipper',
    'พนักงาน': 'Employee',
    'หน่วย': 'Unit',
    'ราคา': 'Price',
    'ชื่อบริษัท': 'Company name',
    'บริษัท / ผู้จัดจำหน่าย': 'Company / Supplier',
    'ยอดรวม': 'Total',
    'เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่': 'Your session expired. Please sign in again.',
    'เชื่อมต่อระบบไม่ได้ กรุณาตรวจสอบการเชื่อมต่อและการตั้งค่าฐานข้อมูล': 'Unable to connect. Check your network and database settings.',
    'เกิดข้อผิดพลาด กรุณาลองอีกครั้ง': 'Something went wrong. Please try again.',
    'ยืนยันการลบรายการนี้?': 'Delete this record?',
    'ลบรายการเรียบร้อยแล้ว': 'Record deleted',
    'ลบคำสั่งซื้อเรียบร้อยแล้ว': 'Order deleted',
    'ต้องเลือกสินค้าและระบุจำนวน': 'Select a product and enter a quantity',
    'ข้อมูลไม่ครบถ้วน': 'Please complete all required fields',
    'จำนวนคำสั่งซื้อตามวันที่ในข้อมูล': 'Orders by date in the database',
    'รายละเอียดคำสั่งซื้อพร้อมลูกค้า สินค้า และการจัดส่ง': 'Order details with customer, product, and shipping information',
    'แสดงตัวอย่างรายการล่าสุด พร้อมลูกค้า สินค้า และการจัดส่ง': 'Showing recent order lines with customer, product, and shipping details',
    'รายการสั่งซื้อและสินค้ายอดนิยม': 'Orders and popular products',
    'สรุปคำสั่งซื้อและสินค้าขายดี': 'Order and best-selling product summary',
    'สินค้าขายดี CSV': 'Best-selling products CSV',
    'รายการสั่งซื้อ CSV': 'Order details CSV',
    'เพิ่มหมวดหมู่สินค้า': 'Add category',
    'แก้ไขหมวดหมู่สินค้า': 'Edit category',
    'เพิ่มผู้จัดจำหน่าย': 'Add supplier',
    'แก้ไขผู้จัดจำหน่าย': 'Edit supplier',
    'เพิ่มลูกค้า': 'Add customer',
    'แก้ไขลูกค้า': 'Edit customer',
    'เพิ่มพนักงาน': 'Add employee',
    'แก้ไขพนักงาน': 'Edit employee',
    'เพิ่มบริษัทขนส่ง': 'Add shipper',
    'แก้ไขบริษัทขนส่ง': 'Edit shipper',
    'เพิ่มสินค้า': 'Add product',
    'แก้ไขสินค้า': 'Edit product',
    'เลือกสินค้า': 'Select product',
    'เลือกหมวดหมู่': 'Select category',
    'เลือกผู้จัดจำหน่าย': 'Select supplier',
    'รายละเอียดคำสั่งซื้อ': 'Order details',
    'เพิ่มรายการสินค้า': 'Add item',
    'เพิ่มรายการเรียบร้อยแล้ว': 'Record added successfully',
    'บันทึกการแก้ไขแล้ว': 'Changes saved successfully',
    'ยืนยันการลบรายการนี้?': 'Are you sure you want to delete this record?',
    'ลบรายการนี้ใช่หรือไม่?': 'Are you sure you want to delete this record?',
    'เลือกสินค้าและระบุจำนวน': 'Select a product and enter a quantity',
    'บันทึกข้อมูล': 'Save changes',
    'ชื่อหมวดหมู่': 'Category name',
    'ชื่อลูกค้า / บริษัท': 'Customer / Company name',
    'ชื่อบริษัท': 'Company name',
    'ที่อยู่': 'Address',
    'ชื่อผู้จัดจำหน่าย': 'Supplier name',
    'เลือกสินค้าและจำนวน': 'Select a product and quantity',
    'ไม่พบข้อมูล': 'No records found',
    'ยังไม่มีคำสั่งซื้อ': 'No orders yet',
    'ยังไม่มีข้อมูลสินค้า': 'No product data yet',
    'ดูรายละเอียด': 'View details',
    'เพิ่มคำสั่งซื้อ': 'Create order',
    'มูลค่ารวม': 'Estimated total',
    'ยอดรวมโดยประมาณ': 'Estimated total',
    'ราคาสินค้าปัจจุบัน': 'Current product price',
    'ราคาปัจจุบันต่อหน่วย': 'Current unit price',
    'ประมาณการจากราคาปัจจุบัน': 'Estimated using current prices',
    'ผู้ดูแลระบบ': 'Administrator',
    'จัดการข้อมูลธุรกิจ': 'Manage business data',
    'รายการล่าสุด': 'Latest records',
    'รายการในระบบ': 'Records in the system',
    'ทั้งหมด ': 'Total ',
    'กำลังค้นหา': 'Searching',
    'ค้นหาชื่อสินค้า': 'Search products',
    'ชื่อบริษัท / ผู้ติดต่อ': 'Company / Contact name',
    'ชื่อผู้ติดต่อ': 'Contact name',
    'ประเทศ / เมือง': 'Country / City',
    'เรียงตามจำนวนสั่งซื้อ': 'Sorted by quantity ordered',
    'หน่วยที่สั่งซื้อ': 'Units ordered',
    'ชื่อสินค้า / บริษัท': 'Product / Company name',
    'สต็อก': 'Stock',
    'รายงานคำสั่งซื้อ': 'Order reports',
    'ข้อมูลคำสั่งซื้อ': 'Order information',
    'คำสั่งซื้อทั้งหมด': 'All orders',
    'สินค้าทั้งหมด': 'Total products',
    'ข้อมูลสินค้า': 'Product information',
    'ข้อมูลผู้จัดจำหน่าย': 'Supplier information',
    'ข้อมูลพนักงาน': 'Employee information',
    'ข้อมูลบริษัทขนส่ง': 'Shipper information',
    'เพิ่มรายการใหม่': 'Add new record',
    'บันทึกแล้ว': 'Saved',
    'สินค้าในคำสั่งซื้อ': 'Order items',
    'ราคาต่อหน่วยปัจจุบัน': 'Current unit price',
    'ยอดรายการประมาณการ': 'Estimated line total',
    'จำนวนรายการสั่งซื้อ': 'Order line count',
    'แสดงรายละเอียด': 'View details',
    'คำสั่งซื้อ #': 'Order #',
    'ไม่มีข้อมูล': 'No data available',
    'ทั้งหมด': 'Total',
    'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง': 'Invalid username or password',
    'ต้องเข้าสู่ระบบก่อนใช้งาน': 'Authentication required',
    'ไม่พบข้อมูลที่ร้องขอ': 'Not found',
    'ไม่สามารถประมวลผลคำขอได้': 'Request failed'
  };

  const originals = new WeakMap();
  const thaiErrors = {
    'Invalid username or password':'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
    'Authentication required':'ต้องเข้าสู่ระบบก่อนใช้งาน',
    'Not found':'ไม่พบข้อมูลที่ร้องขอ',
    'Request failed':'ไม่สามารถประมวลผลคำขอได้'
  };
  const getLanguage = () => localStorage.getItem('nw_language') === 'th' ? 'th' : 'en';

  function translate(value, language) {
    const leading=value.match(/^\s*/)?.[0]||'';
    const trailing=value.match(/\s*$/)?.[0]||'';
    const source=value.slice(leading.length,value.length-trailing.length||value.length);
    if (language === 'th') {
      return leading+(thaiErrors[source]||source)+trailing;
    }
    let result=translations[source];
    let match;
    if(!result&&(match=source.match(/^ทั้งหมด\s+([\d,]+)\s+รายการ$/)))result=`${match[1]} records total`;
    if(!result&&(match=source.match(/^แสดง\s+([\d,–-]+)\s+จาก\s+([\d,]+)\s+รายการ$/)))result=`Showing ${match[1]} of ${match[2]} records`;
    if(!result&&(match=source.match(/^([\d,]+)\s+รายการล่าสุด$/)))result=`${match[1]} latest records`;
    if(!result&&(match=source.match(/^ส่งออก\s+([\d,]+)\s+รายการแล้ว$/)))result=`Exported ${match[1]} records`;
    if(!result&&(match=source.match(/^NORTHWIND\s*\/\s*(.+)$/)))result=`NORTHWIND / ${translations[match[1]]||match[1]}`;
    if(!result&&(match=source.match(/^＋\s*(เพิ่ม|แก้ไข)(.+)$/))){const action=match[1]==='เพิ่ม'?'Add':'Edit';result=`＋ ${action} ${translations[match[2]]||match[2]}`;}
    if(!result&&(match=source.match(/^(เพิ่ม|แก้ไข)(.+)$/))){const action=match[1]==='เพิ่ม'?'Add':'Edit';result=`${action} ${translations[match[2]]||match[2]}`;}
    if(!result&&(match=source.match(/^เลือก(.+)$/)))result=`Select ${translations[match[1]]||match[1]}`;
    return leading+(result||source)+trailing;
  }

  function localizeTextNode(node, language) {
    if (!originals.has(node)) originals.set(node, node.nodeValue);
    const source = originals.get(node);
    const result = translate(source, language);
    if (node.nodeValue !== result) node.nodeValue = result;
  }

  function localizeElement(root, language) {
    if (!root) return;
    const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT);
    let node;
    while ((node = walker.nextNode())) localizeTextNode(node, language);
    const attrs = ['placeholder','title','aria-label'];
    const elements = [root, ...root.querySelectorAll('*')];
    for (const element of elements) {
      for (const attr of attrs) {
        if (!element.hasAttribute?.(attr)) continue;
        const key = `${attr}`;
        let saved = element.__nwOriginalAttrs;
        if (!saved) Object.defineProperty(element, '__nwOriginalAttrs', {value:(saved={}), configurable:true});
        if (!(key in saved)) saved[key] = element.getAttribute(attr);
        const result = translate(saved[key], language);
        if (element.getAttribute(attr) !== result) element.setAttribute(attr, result);
      }
    }
  }

  function paintToggles(language) {
    document.querySelectorAll('[data-language-toggle]').forEach(button => {
      button.textContent = language === 'en' ? 'ไทย' : 'English';
      button.setAttribute('aria-label', language === 'en' ? 'Switch to Thai' : 'Switch to English');
      button.title = language === 'en' ? 'Switch to Thai' : 'Switch to English';
    });
  }

  function setLanguage(language) {
    const selected = language === 'th' ? 'th' : 'en';
    localStorage.setItem('nw_language', selected);
    document.documentElement.lang = selected;
    document.body.dataset.language = selected;
    localizeElement(document.body, selected);
    paintToggles(selected);
    window.dispatchEvent(new CustomEvent('nw-language-change', {detail:{language:selected}}));
  }

  document.addEventListener('click', event => {
    if (!event.target.closest('[data-language-toggle]')) return;
    setLanguage(getLanguage() === 'en' ? 'th' : 'en');
  });

  const observer = new MutationObserver(records => {
    const language = getLanguage();
    for (const record of records) {
      for (const node of record.addedNodes) {
        if (node.nodeType === Node.TEXT_NODE) localizeTextNode(node, language);
        else if (node.nodeType === Node.ELEMENT_NODE) localizeElement(node, language);
      }
    }
  });

  document.documentElement.lang = getLanguage();
  document.body.dataset.language = getLanguage();
  localizeElement(document.body, getLanguage());
  paintToggles(getLanguage());
  observer.observe(document.body, {childList:true, subtree:true});
  window.nwI18n = {language:getLanguage, setLanguage, translate:value=>translate(value,getLanguage())};
})();
