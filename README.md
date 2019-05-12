# Hướng dẫn cài đặt
Đồ án hệ thống thông tin xay dựng một trang web bán hàng dựa trên nền tảng framework laravel 
## Môi trường:
- PHP7
- Cài composer: https://getcomposer.org/
- Cài Laravel: composer global require "laravel/installer"
- Cài XAMPP
## Các bước thiết lập:
- Mở cmd tại thư mục project, chạy lệnh composer install để tải về các package cần thiết cho project
- Mở XAMPP, bật dịch vụ MySQL
- Vào phpMyAdmin, tạo mới 1 database.
- Di chuyển tới thư mục project,  đổi tên file .env.example thành .env. Sau đó mở file .env này lên và chỉnh sửa các thông số config database như sau:
```DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306 <Cổng của dịch vụ MySQL>
DB_DATABASE=<Tên database vừa tạo>
DB_USERNAME=<Tên username để truy cập database, mặc định là root>
DB_PASSWORD=<Password để truy cập database, mặc định để trống>
```
- Mở cmd tại thư mục project, chạy lệnh php artisan migrate để sinh các bảng trong database
- Sau khi chạy xong lệnh trên chạy lệnh php artisan key:generate (sinh key cho ứng dụng)
- Cuối cùng chạy lệnh php artisan serve  để khởi chạy server 
- Truy cập http://127.0.0.1:8000 để vào trang web
