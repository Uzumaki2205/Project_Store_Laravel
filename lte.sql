#DROP database lte;
Create database webshop;
Use webshop;
# Tài khoản admin
-- create table admins (
-- 	id int unsigned NOT NULL auto_increment,
-- 	username varchar(50) NOT NULL,
--     name varchar(255) not null,
--     email varchar(255) not null,
--     email_verified_at timestamp,
--     remember_token varchar(100),
-- 	password varchar(255) not null,
--     created_at datetime default now(),
--     updated_at datetime default now(),
--     primary key(Id),
--     unique(username, email)
-- );

# Role
-- create table roles(
-- 	id int unsigned not null,
--     name varchar(20),
--     primary key(id)
-- );

# Tài khoản người dùng
create table users (
	id int unsigned not null auto_increment,
    username varchar(50) not null,
    name varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null,
    is_admin boolean default false not null,
    email_verified_at timestamp,
    remember_token varchar(100),
    address varchar(300),
    created_at datetime default now(),
    updated_at datetime default now(),
    primary key(Id),
    unique(username, email)
);

create table password_resets(
	email varchar(255) not null,
    token varchar(255),
    created_at timestamp
);

create table promotions(
	id int unsigned auto_increment,
    name_promotion varchar(200) not null,
    price_promotion decimal(15,2) not null,
    start_date date default now(),
    end_date date default now(),
    primary key(id)
);

# Loại sản phẩm
create table categories(
	id int unsigned not null auto_increment,
    name_category varchar(50) not null,
    slug_category varchar(50) not null,
    created_at datetime default now(),
    updated_at datetime default now(),
    primary key(Id)
);

# Galery
create table galeries(
	id int unsigned not null auto_increment,
    url_image varchar(200) not null,
    created_at datetime default now(),
    updated_at datetime default now(),
    primary key(id)
);

# Tất cả Hình ảnh sản phẩm
create table images(
	id int unsigned not null auto_increment,
    id_product int unsigned,
    id_galery int unsigned,
    -- url_image varchar(200) not null,
    created_at datetime default now(),
    updated_at datetime default now(),
    primary key(id)
);

# Sản phẩm
create table products(
	id int unsigned not null auto_increment,
    id_category int unsigned,
    id_promotion int unsigned default null,
    description_product varchar(1000),
    name_product varchar(200) not null,
    price_product decimal(15,2) not null,
    quantity_product int unsigned not null,
    image_product varchar(300),
    slug_product varchar(200),
    created_at datetime default now(),
    updated_at datetime default now(),
    primary key(id)
);

-- # SubImage Sản phẩm
-- create table product_images(
-- 	id int unsigned not null auto_increment,
--     id_product int unsigned,
--     id_image int unsigned,
--     primary key(id)
-- );

# Giỏ hàng
create table carts(
	id int unsigned not null auto_increment,
    id_user int unsigned,
    id_product int unsigned,
    quantity tinyint unsigned default 1,
    total_money decimal(15,2),
    created_at datetime default now(),
    updated_at datetime default now(),
    primary key(id)
);

# Đơn hàng
create table orders(
	id int unsigned not null auto_increment,
    id_user int unsigned,
    name varchar(200) not null,
    address varchar(500),
    name_product varchar(500) not null,
    quantity tinyint unsigned not null,
    code int unsigned not null,
    price decimal(15,2) not null,
    price_promotion decimal(15,2),
    total_money decimal(15,2),
    accept bool default 0,
    is_active bool default 0,
    created_at datetime default now(),
    updated_at datetime default now(),
    primary key(id)
);

# Tồn kho
-- create table inventories(
-- 	id int unsigned not null auto_increment,
--     id_product int unsigned,
--     quantity int unsigned,
--     primary key(id)
-- );

# Đơn hàng bị hủy
create table order_cancels(
	id int unsigned not null auto_increment,
    id_order int unsigned,
    created_at datetime default now(),
    updated_at datetime default now(),
    primary key(id)
);

# Report
create table reports(
	id int unsigned not null auto_increment,
    id_inventory int unsigned,
    id_order int unsigned,
    id_order_cancel int unsigned,
    primary key(id)
);

ALTER TABLE products
ADD CONSTRAINT FK_product_category
FOREIGN KEY (id_category) REFERENCES categories(id);
ALTER TABLE products
ADD CONSTRAINT FK_product_promotion
FOREIGN KEY (id_promotion) REFERENCES promotions(id);

-- ALTER TABLE product_images
-- ADD CONSTRAINT FK_product_image
-- FOREIGN KEY (id_image) REFERENCES images(id);
-- ALTER TABLE product_images
-- ADD CONSTRAINT FK_product
-- FOREIGN KEY (id_product) REFERENCES products(id);

ALTER TABLE images
ADD CONSTRAINT FK_product_image
FOREIGN KEY (id_product) REFERENCES products(id);
ALTER TABLE images
ADD CONSTRAINT FK_product_galery
FOREIGN KEY (id_galery) REFERENCES galeries(id);

ALTER TABLE carts
ADD CONSTRAINT FK_cart_user
FOREIGN KEY (id_user) REFERENCES users(id);
ALTER TABLE carts
ADD CONSTRAINT FK_cart_product
FOREIGN KEY (id_product) REFERENCES products(id);

ALTER TABLE orders
ADD CONSTRAINT FK_order_user
FOREIGN KEY (id_user) REFERENCES users(id);

-- ALTER TABLE inventories
-- ADD CONSTRAINT FK_inventory_product
-- FOREIGN KEY (id_product) REFERENCES products(id);

ALTER TABLE order_cancels
ADD CONSTRAINT FK_oder_cancel_order
FOREIGN KEY (id_order) REFERENCES orders(id);

-- ALTER TABLE reports
-- ADD CONSTRAINT FK_report_inventory
-- FOREIGN KEY (id_inventory) REFERENCES inventories(id);
ALTER TABLE reports
ADD CONSTRAINT FK_report_order
FOREIGN KEY (id_order) REFERENCES orders(id);
ALTER TABLE reports
ADD CONSTRAINT FK_report_order_cancel
FOREIGN KEY (id_order_cancel) REFERENCES order_cancels(id);

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `is_admin`, `email_verified_at`, `remember_token`, `address`, `created_at`, `updated_at`) VALUES (NULL, 'admin', 'Le Ngoc Son', 'lengocson2204@gmail.com', '$2y$12$2SfvsTx8iE28AOgwcq3Cd.7sqVM31o8FJvLFJBssXWBwUTFYKfHBO', '1', current_timestamp(), NULL, NULL, current_timestamp(), current_timestamp()), (NULL, 'user1', 'User', 'lengocson1012@gmail.com', '$2y$12$2SfvsTx8iE28AOgwcq3Cd.7sqVM31o8FJvLFJBssXWBwUTFYKfHBO', '0', current_timestamp(), NULL, NULL, current_timestamp(), current_timestamp());
INSERT INTO `categories` (`id`, `name_category`, `slug_category`, `created_at`, `updated_at`) VALUES (NULL, 'Rau Củ', 'rau-cu', current_timestamp(), current_timestamp()), (NULL, 'Thực Phẩm', 'thuc-pham', current_timestamp(), current_timestamp());
INSERT INTO `categories` (`id`, `name_category`, `slug_category`, `created_at`, `updated_at`) VALUES (NULL, 'Hoa Quả', 'hoa-qua', current_timestamp(), current_timestamp());
INSERT INTO `promotions` (`id`, `name_promotion`, `price_promotion`, `start_date`, `end_date`) VALUES (NULL, 'Giảm giá bưởi da xanh', '7000', '2021-06-05', '2021-06-07'), (NULL, 'Giảm giá ổi da xanh', '400000', '2021-06-05', '2021-06-16');

