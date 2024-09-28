CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    email VARCHAR(100),
    phone_number VARCHAR(15),
    address TEXT,
    role ENUM('customer', 'staff', 'manager') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE bikes (
    bike_id INT AUTO_INCREMENT PRIMARY KEY,
    bike_type VARCHAR(50) NOT NULL,
    description TEXT,
    rental_price DECIMAL(10, 2) NOT NULL, -- Giá thuê mỗi giờ hoặc ngày
    deposit DECIMAL(10, 2) NOT NULL,      -- Số tiền đặt cọc
    availability BOOLEAN DEFAULT TRUE,    -- Trạng thái xe (true: có sẵn, false: đã thuê)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE rentals (
    rental_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    bike_id INT NOT NULL,
    document_type VARCHAR(50) NOT NULL, -- Loại giấy tờ (CMND, GPLX,...)
    document_number VARCHAR(50) NOT NULL,
    staff_id INT, -- Nhân viên xử lý giao dịch
    start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Thời điểm bắt đầu thuê
    end_time TIMESTAMP, -- Thời điểm trả xe
    total_price DECIMAL(10, 2), -- Tổng số tiền cho thuê
    deposit_paid DECIMAL(10, 2), -- Tiền đặt cọc đã thanh toán
    status ENUM('ongoing', 'completed') DEFAULT 'ongoing', -- Trạng thái thuê
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (bike_id) REFERENCES bikes(bike_id),
    FOREIGN KEY (staff_id) REFERENCES users(user_id)
);


CREATE TABLE invoices (
    invoice_id INT AUTO_INCREMENT PRIMARY KEY,
    rental_id INT NOT NULL,
    staff_id INT NOT NULL, -- Nhân viên lập hóa đơn
    total_price DECIMAL(10, 2) NOT NULL,
    deposit DECIMAL(10, 2) NOT NULL, -- Tiền đặt cọc
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rental_id) REFERENCES rentals(rental_id),
    FOREIGN KEY (staff_id) REFERENCES users(user_id)
);


-- CREATE TABLE documents (
--     document_id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT NOT NULL,
--     file_path VARCHAR(255) NOT NULL, -- Đường dẫn file giấy tờ
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (user_id) REFERENCES users(user_id)
-- );


CREATE TABLE reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    report_type ENUM('daily', 'monthly', 'yearly', 'bike_type') NOT NULL,
    total_revenue DECIMAL(10, 2) NOT NULL,
    total_rentals INT NOT NULL,
    report_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
