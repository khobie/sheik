CREATE DATABASE IF NOT EXISTS koforidua_artisans CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE koforidua_artisans;

CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  phone VARCHAR(40) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('client', 'artisan', 'admin') NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE service_categories (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE,
  description TEXT,
  icon VARCHAR(40),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE artisans (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  category_id BIGINT UNSIGNED NOT NULL,
  location VARCHAR(120) NOT NULL,
  bio TEXT,
  years_experience TINYINT UNSIGNED NOT NULL DEFAULT 0,
  hourly_rate DECIMAL(10,2) NOT NULL DEFAULT 0,
  verified BOOLEAN NOT NULL DEFAULT FALSE,
  rating DECIMAL(2,1) NOT NULL DEFAULT 0,
  review_count INT UNSIGNED NOT NULL DEFAULT 0,
  jobs_completed INT UNSIGNED NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_artisans_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_artisans_category FOREIGN KEY (category_id) REFERENCES service_categories(id)
);

CREATE TABLE artisan_skills (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  artisan_id BIGINT UNSIGNED NOT NULL,
  skill VARCHAR(80) NOT NULL,
  CONSTRAINT fk_skills_artisan FOREIGN KEY (artisan_id) REFERENCES artisans(id) ON DELETE CASCADE
);

CREATE TABLE availability_slots (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  artisan_id BIGINT UNSIGNED NOT NULL,
  available_date DATE NOT NULL,
  starts_at TIME NOT NULL,
  ends_at TIME NOT NULL,
  status ENUM('open', 'held', 'booked', 'unavailable') NOT NULL DEFAULT 'open',
  CONSTRAINT fk_availability_artisan FOREIGN KEY (artisan_id) REFERENCES artisans(id) ON DELETE CASCADE,
  INDEX idx_availability_lookup (artisan_id, available_date, status)
);

CREATE TABLE bookings (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_id BIGINT UNSIGNED NULL,
  artisan_id BIGINT UNSIGNED NOT NULL,
  service_category_id BIGINT UNSIGNED NOT NULL,
  client_name VARCHAR(120) NOT NULL,
  client_phone VARCHAR(40) NOT NULL,
  service_address VARCHAR(255) NOT NULL,
  preferred_date DATE NOT NULL,
  preferred_time TIME NOT NULL,
  description TEXT NOT NULL,
  status ENUM('pending', 'confirmed', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_bookings_client FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_bookings_artisan FOREIGN KEY (artisan_id) REFERENCES artisans(id),
  CONSTRAINT fk_bookings_category FOREIGN KEY (service_category_id) REFERENCES service_categories(id),
  INDEX idx_bookings_artisan_status (artisan_id, status),
  INDEX idx_bookings_client_status (client_id, status)
);

CREATE TABLE reviews (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  booking_id BIGINT UNSIGNED NULL,
  artisan_id BIGINT UNSIGNED NOT NULL,
  client_id BIGINT UNSIGNED NULL,
  client_name VARCHAR(120) NOT NULL,
  rating TINYINT UNSIGNED NOT NULL,
  comment TEXT,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT chk_review_rating CHECK (rating BETWEEN 1 AND 5),
  CONSTRAINT fk_reviews_booking FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE SET NULL,
  CONSTRAINT fk_reviews_artisan FOREIGN KEY (artisan_id) REFERENCES artisans(id) ON DELETE CASCADE,
  CONSTRAINT fk_reviews_client FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE notifications (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(140) NOT NULL,
  message TEXT NOT NULL,
  type ENUM('booking', 'status', 'review', 'system') NOT NULL DEFAULT 'system',
  is_read BOOLEAN NOT NULL DEFAULT FALSE,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_notifications_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_notifications_user_read (user_id, is_read)
);
