# 🏫 School Management System

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Pusher](https://img.shields.io/badge/Pusher-300D4F?style=for-the-badge&logo=pusher&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

**نظام إدارة مدرسي متكامل مع نظام رسائل فورية**

[المميزات](#-المميزات) • [التثبيت](#-التثبيت) • [الاستخدام](#-الاستخدام) • [API](#-api-documentation) • [المساهمة](#-المساهمة)

</div>

---

## 📋 نظرة عامة

نظام إدارة مدرسي شامل مبني بـ Laravel 10 يوفر:
- **إدارة الطلاب والمواد الدراسية**
- **نظام رسائل فورية متقدم**
- **نظام أدوار وصلاحيات**
- **لوحة تحكم إدارية**
- **تتبع الدرجات والحضور**

## ✨ المميزات

### 🎓 إدارة أكاديمية
- ✅ إدارة الطلاب والمدرسين
- ✅ إدارة المواد الدراسية
- ✅ نظام الدرجات والتقييم
- ✅ تتبع الأداء الأكاديمي

### 💬 نظام الرسائل الفورية
- ✅ محادثات فورية بين المستخدمين
- ✅ إشعارات فورية
- ✅ تتبع حالة المستخدم (متصل/غير متصل)
- ✅ إرسال إشعارات بالبريد الإلكتروني

### 🔐 الأمان والمصادقة
- ✅ نظام مصادقة متقدم
- ✅ أدوار وصلاحيات (Admin/User)
- ✅ تأكيد البريد الإلكتروني
- ✅ إدارة الجلسات

### 🎨 واجهة المستخدم
- ✅ تصميم متجاوب (Responsive)
- ✅ واجهة حديثة مع TailwindCSS
- ✅ تجربة مستخدم سلسة
- ✅ لوحة تحكم إدارية

## 🛠️ التقنيات المستخدمة

| التقنية | الإصدار | الغرض |
|---------|---------|-------|
| **Laravel** | 10.x | إطار العمل الرئيسي |
| **PHP** | 8.1+ | لغة البرمجة |
| **MySQL** | 8.0+ | قاعدة البيانات |
| **TailwindCSS** | 3.4+ | تنسيق الواجهة |
| **Pusher** | 7.2+ | الرسائل الفورية |
| **jQuery** | 3.x | التفاعل مع الواجهة |
| **DataTables** | - | جداول البيانات |

## 📦 التثبيت

### المتطلبات الأساسية
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL >= 8.0
- حساب Pusher (للرسائل الفورية)

### خطوات التثبيت

1. **استنساخ المشروع**
```bash
git clone https://github.com/your-username/SchoolProject10.git
cd SchoolProject10
```

2. **تثبيت التبعيات**
```bash
# تثبيت تبعيات PHP
composer install

# تثبيت تبعيات JavaScript
npm install
```

3. **إعداد البيئة**
```bash
# نسخ ملف البيئة
cp .env.example .env

# توليد مفتاح التطبيق
php artisan key:generate
```

4. **إعداد قاعدة البيانات**
```bash
# إنشاء قاعدة البيانات وتشغيل الهجرات
php artisan migrate

# تشغيل البذور (البيانات الأولية)
php artisan db:seed
```

5. **إعداد Pusher**
```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=your_cluster
```

6. **بناء الأصول**
```bash
npm run build
# أو للتطوير
npm run dev
```

7. **تشغيل الخادم**
```bash
php artisan serve
```
# School_project_10
