USE koforidua_artisans;

INSERT INTO service_categories (id, name, description, icon) VALUES
  (1, 'Plumbing', 'Leak repairs, bathroom fittings, and water systems', 'Pipe'),
  (2, 'Electrical', 'Wiring, appliance repair, and lighting installation', 'Bolt'),
  (3, 'Carpentry', 'Furniture, doors, roofing, and cabinetry', 'Plane'),
  (4, 'Masonry', 'Blocks, plastering, tiling, and concrete work', 'Brick'),
  (5, 'Painting', 'Interior and exterior painting services', 'Brush'),
  (6, 'Welding', 'Metal gates, burglar proofing, and fabrication', 'Spark'),
  (7, 'Tiling', 'Floor and wall tile installation', 'Grid')
ON DUPLICATE KEY UPDATE
  description = VALUES(description),
  icon = VALUES(icon);

INSERT INTO users (id, full_name, email, phone, password_hash, role) VALUES
  (1, 'Akua Mensah', 'akua.client@example.com', '+233 24 555 0101', '$2b$10$replaceWithRealHash', 'client'),
  (2, 'Kwame Boateng', 'kwame.electric@example.com', '+233 27 555 0142', '$2b$10$replaceWithRealHash', 'artisan'),
  (3, 'Esi Darko', 'esi.plumbing@example.com', '+233 20 555 0188', '$2b$10$replaceWithRealHash', 'artisan')
ON DUPLICATE KEY UPDATE
  full_name = VALUES(full_name),
  phone = VALUES(phone),
  role = VALUES(role);

INSERT INTO artisans
  (id, user_id, category_id, location, bio, years_experience, hourly_rate, verified, rating, review_count, jobs_completed)
VALUES
  (1, 2, 2, 'Srodae', 'Certified electrician serving homes and shops around Koforidua.', 8, 95.00, TRUE, 4.9, 42, 128),
  (2, 3, 1, 'Adweso', 'Reliable plumber focused on fast diagnosis and transparent pricing.', 6, 80.00, TRUE, 4.8, 35, 96)
ON DUPLICATE KEY UPDATE
  location = VALUES(location),
  bio = VALUES(bio),
  verified = VALUES(verified),
  rating = VALUES(rating),
  review_count = VALUES(review_count),
  jobs_completed = VALUES(jobs_completed);

INSERT INTO artisan_skills (artisan_id, skill) VALUES
  (1, 'House wiring'),
  (1, 'Fan installation'),
  (1, 'Fault tracing'),
  (2, 'Leak repair'),
  (2, 'Water tanks'),
  (2, 'Bathroom fittings');

INSERT INTO availability_slots (artisan_id, available_date, starts_at, ends_at, status) VALUES
  (1, '2026-06-08', '10:00:00', '12:00:00', 'open'),
  (1, '2026-06-08', '14:00:00', '16:00:00', 'open'),
  (2, '2026-06-09', '09:30:00', '11:30:00', 'open');

INSERT INTO bookings
  (client_id, artisan_id, service_category_id, client_name, client_phone, service_address, preferred_date, preferred_time, description, status)
VALUES
  (1, 1, 2, 'Akua Mensah', '+233 24 555 0101', 'Srodae, near central mosque', '2026-06-08', '10:00:00', 'Install ceiling fan and inspect two faulty sockets.', 'confirmed');

INSERT INTO reviews (booking_id, artisan_id, client_id, client_name, rating, comment) VALUES
  (1, 1, 1, 'Akua Mensah', 5, 'Arrived on time and explained the repair clearly.');

INSERT INTO notifications (user_id, title, message, type, is_read) VALUES
  (2, 'New booking request', 'Akua Mensah requested electrical service for Jun 8 at 10:00.', 'booking', FALSE),
  (1, 'Booking confirmed', 'Kwame Boateng confirmed your fan installation request.', 'status', TRUE);
