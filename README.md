## About test-filament

Laravel filament 是基於 TALL stack 發展的套件。

使用此套件可以快速開發後台，基本的 CURD 都可以透過套件內建完成。

像是 form (表單), table (表格), info-view(詳細資訊) 都可以輕鬆完成。


## install 

安裝
- php 8.2
- mysql 
- composer

套件版本
- laravel 10.x
- filament v3

專案初始化
```bash
composer install
npm install
npm run build

cp .env.example .env
```

設置 .env IOT_API_URL
```bash
IOT_API_URL='iot api url'
```


設置 .env 資料庫 ，預設建立 database 名稱為 laravel ，帳號為 root 。依照需求修改

```javascript
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

執行資料庫建立表格、異動
```bash
php artisan migrate
```

註冊 admin 帳號
```bash
php artisan make:filament-user
```

啟動!
```bash
php artisan serve
```
查看 localhost:8000/admin


## 自動根據 Resource 建立 CRUD 頁面

```bash
php artisan make:filament-resource User --generate
```

## 動態更新畫面

```bash
npm run dev
```

打包成 production 環境的靜態頁面
```bash
npm run build
```
