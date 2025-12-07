-- =====================================================
-- BASE DE DATOS: Salinas Constructor
-- Fecha de exportación: 2025-12-04 07:51:11
-- Sistema: SQLite
-- =====================================================


-- =====================================================
-- Tabla: migrations
-- =====================================================

CREATE TABLE "migrations" ("id" integer primary key autoincrement not null, "migration" varchar not null, "batch" integer not null);

-- Datos de la tabla migrations
INSERT INTO migrations (id, migration, batch) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO migrations (id, migration, batch) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO migrations (id, migration, batch) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO migrations (id, migration, batch) VALUES ('4', '2025_11_24_000000_add_role_to_users_table', '2');
INSERT INTO migrations (id, migration, batch) VALUES ('5', '2025_11_24_create_categories_table', '3');
INSERT INTO migrations (id, migration, batch) VALUES ('6', '2025_11_24_create_news_table', '3');
INSERT INTO migrations (id, migration, batch) VALUES ('7', '2025_11_24_create_products_table', '3');
INSERT INTO migrations (id, migration, batch) VALUES ('8', '2025_11_24_create_quotation_items_table', '3');
INSERT INTO migrations (id, migration, batch) VALUES ('9', '2025_11_24_create_quotations_table', '3');
INSERT INTO migrations (id, migration, batch) VALUES ('10', '2025_11_24_000010_create_carts_table', '4');
INSERT INTO migrations (id, migration, batch) VALUES ('11', '2025_11_25_add_detailed_specs_to_products_table', '5');
INSERT INTO migrations (id, migration, batch) VALUES ('12', '2025_11_25_add_product_tech_specs_fields', '6');
INSERT INTO migrations (id, migration, batch) VALUES ('13', '2025_12_01_000000_create_messages_table', '7');
INSERT INTO migrations (id, migration, batch) VALUES ('14', '2025_12_03_000000_create_inventory_movements_table', '8');


-- =====================================================
-- Tabla: users
-- =====================================================

CREATE TABLE "users" ("id" integer primary key autoincrement not null, "name" varchar not null, "email" varchar not null, "email_verified_at" datetime, "password" varchar not null, "remember_token" varchar, "created_at" datetime, "updated_at" datetime, "role" varchar check ("role" in ('admin', 'client')) not null default 'client');

-- Datos de la tabla users
INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, role) VALUES ('1', 'Administrador', 'vfjunior117@gmail.com', NULL, '$2y$12$eBOtyDkc0fCC5I5WBodIbOzJ/5wUlnGwsoHjmtLIaHIsg/sfSlmDu', NULL, '2025-11-24 22:26:51', '2025-11-24 22:26:51', 'admin');
INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, role) VALUES ('2', 'Delfin', 'delfin1@gmail.com', NULL, '$2y$12$XlFCC13jbK79o9bMV.mgDuWoznzaDBhnubiXOquFPqg/hZ4aPuvSq', NULL, '2025-11-24 23:22:47', '2025-11-24 23:22:47', 'client');
INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, role) VALUES ('5', 'Jesus', 'jesus2@gmail.com', NULL, '$2y$12$77QEGH1WxiNg00jGteRKh.V0MTQjlVm8c/Kh8K93Aod7B.2.zzPp6', NULL, '2025-12-04 05:07:59', '2025-12-04 05:07:59', 'client');


-- =====================================================
-- Tabla: password_reset_tokens
-- =====================================================

CREATE TABLE "password_reset_tokens" ("email" varchar not null, "token" varchar not null, "created_at" datetime, primary key ("email"));


-- =====================================================
-- Tabla: sessions
-- =====================================================

CREATE TABLE "sessions" ("id" varchar not null, "user_id" integer, "ip_address" varchar, "user_agent" text, "payload" text not null, "last_activity" integer not null, primary key ("id"));

-- Datos de la tabla sessions
INSERT INTO sessions (id, user_id, ip_address, user_agent, payload, last_activity) VALUES ('I460N0NZco5RlFID21nRBxZO2sYgSsofpk3cSldI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSm5ZWjZ2bTE4MnBibGY2enpFcVFLWUhZYmFLaFJGYnF6QjQ0bmF3UCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==', '1764831569');
INSERT INTO sessions (id, user_id, ip_address, user_agent, payload, last_activity) VALUES ('pAHnHkohgqRvHTPCOiNaTuDIX3J6UMNEuHnb71RM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGl4SEVXSGU2MXBISkNEbk44R25VNlFWa295aktRQnBGQkhLU043NCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', '1764831590');


-- =====================================================
-- Tabla: cache
-- =====================================================

CREATE TABLE "cache" ("key" varchar not null, "value" text not null, "expiration" integer not null, primary key ("key"));


-- =====================================================
-- Tabla: cache_locks
-- =====================================================

CREATE TABLE "cache_locks" ("key" varchar not null, "owner" varchar not null, "expiration" integer not null, primary key ("key"));


-- =====================================================
-- Tabla: jobs
-- =====================================================

CREATE TABLE "jobs" ("id" integer primary key autoincrement not null, "queue" varchar not null, "payload" text not null, "attempts" integer not null, "reserved_at" integer, "available_at" integer not null, "created_at" integer not null);


-- =====================================================
-- Tabla: job_batches
-- =====================================================

CREATE TABLE "job_batches" ("id" varchar not null, "name" varchar not null, "total_jobs" integer not null, "pending_jobs" integer not null, "failed_jobs" integer not null, "failed_job_ids" text not null, "options" text, "cancelled_at" integer, "created_at" integer not null, "finished_at" integer, primary key ("id"));


-- =====================================================
-- Tabla: failed_jobs
-- =====================================================

CREATE TABLE "failed_jobs" ("id" integer primary key autoincrement not null, "uuid" varchar not null, "connection" text not null, "queue" text not null, "payload" text not null, "exception" text not null, "failed_at" datetime not null default CURRENT_TIMESTAMP);


-- =====================================================
-- Tabla: categories
-- =====================================================

CREATE TABLE "categories" ("id" integer primary key autoincrement not null, "name" varchar not null, "slug" varchar not null, "description" text, "icon" varchar, "position" integer not null default '0', "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime);

-- Datos de la tabla categories
INSERT INTO categories (id, name, slug, description, icon, position, is_active, created_at, updated_at) VALUES ('1', 'Aceros', 'aceros', 'Barras, perfiles y estructuras de acero', NULL, '1', '1', '2025-11-24 22:59:48', '2025-11-24 22:59:48');
INSERT INTO categories (id, name, slug, description, icon, position, is_active, created_at, updated_at) VALUES ('2', 'Cementos', 'cementos', 'Cementos y mezclas para construcción', NULL, '2', '1', '2025-11-24 22:59:48', '2025-11-24 22:59:48');
INSERT INTO categories (id, name, slug, description, icon, position, is_active, created_at, updated_at) VALUES ('3', 'Carpintería', 'carpinteria', 'Maderas, puertas y marcos', NULL, '3', '1', '2025-11-24 22:59:48', '2025-11-24 22:59:48');
INSERT INTO categories (id, name, slug, description, icon, position, is_active, created_at, updated_at) VALUES ('4', 'Electricidad', 'electricidad', 'Cables, conductores y accesorios eléctricos', NULL, '4', '1', '2025-11-24 22:59:48', '2025-11-24 22:59:48');
INSERT INTO categories (id, name, slug, description, icon, position, is_active, created_at, updated_at) VALUES ('5', 'Pintura', 'pintura', 'Pinturas y recubrimientos', NULL, '5', '1', '2025-11-24 22:59:48', '2025-11-24 22:59:48');
INSERT INTO categories (id, name, slug, description, icon, position, is_active, created_at, updated_at) VALUES ('6', 'Plomería', 'plomeria', 'Tuberías, accesorios y sistemas de agua', NULL, '6', '1', '2025-11-24 22:59:48', '2025-11-24 22:59:48');
INSERT INTO categories (id, name, slug, description, icon, position, is_active, created_at, updated_at) VALUES ('7', 'Herramientas', 'herramientas', 'Herramientas manuales y eléctricas', NULL, '7', '1', '2025-11-24 22:59:48', '2025-11-24 22:59:48');
INSERT INTO categories (id, name, slug, description, icon, position, is_active, created_at, updated_at) VALUES ('8', 'Vidrios', 'vidrios', 'Vidrios planos y templados', NULL, '8', '1', '2025-11-24 22:59:48', '2025-11-24 22:59:48');
INSERT INTO categories (id, name, slug, description, icon, position, is_active, created_at, updated_at) VALUES ('9', 'Suelos Granulares', 'suelos-granulares', 'Arenas, gravas y materiales de relleno', NULL, '9', '1', '2025-11-24 22:59:48', '2025-11-24 22:59:48');


-- =====================================================
-- Tabla: news
-- =====================================================

CREATE TABLE "news" ("id" integer primary key autoincrement not null, "title" varchar not null, "slug" varchar not null, "excerpt" text, "content" text not null, "featured_image_url" varchar, "author_id" integer not null, "status" varchar check ("status" in ('draft', 'published')) not null default 'published', "is_featured" tinyint(1) not null default '0', "views_count" integer not null default '0', "published_at" datetime, "created_at" datetime, "updated_at" datetime, foreign key("author_id") references "users"("id") on delete cascade);

-- Datos de la tabla news
INSERT INTO news (id, title, slug, excerpt, content, featured_image_url, author_id, status, is_featured, views_count, published_at, created_at, updated_at) VALUES ('1', 'Nuevas técnicas de construcción sostenible', 'nuevas-tecnicas-construccion-sostenible', 'Descubre las últimas técnicas para construir de manera sostenible y eficiente.', '<p>Las técnicas de construcción sostenible están revolucionando la industria...</p>', 'https://imgs.search.brave.com/QTFV8bpP7KRpK0InalqKDT-9gks66yRP6xLw8hOgPP4/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9mYS5v/cnQuZWR1LnV5L2lu/bm92YXBvcnRhbC9m/aWxlLzEzNjcyMi8x/L2VmaWNpZW5jaWEt/ZW5lcmdldGljYS15/LXVzby1kZS1lbmVy/Z2lhcy1yZW5vdmFi/bGVzLmpwZw', '1', 'published', '1', '4', '2025-11-24 23:01:58', '2025-11-24 23:01:58', '2025-12-03 06:27:26');
INSERT INTO news (id, title, slug, excerpt, content, featured_image_url, author_id, status, is_featured, views_count, published_at, created_at, updated_at) VALUES ('2', 'Guía completa para elegir los mejores materiales', 'guia-elegir-mejores-materiales', 'Aprende cómo seleccionar los materiales correctos para tu proyecto.', '<p>La elección de materiales es fundamental para el éxito de cualquier proyecto...</p>', 'https://imgs.search.brave.com/iBpzTTI_NeVjgiuJH2EWNvqlawqgLtP1AiIsmRYolWc/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9iYWxu/ZWFyaWFuLmNvbS9t/b2R1bGVzL3BoX3Np/bXBsZWJsb2cvZmVh/dHVyZWQvMTAwLmpw/Zw', '1', 'published', '1', '3', '2025-11-19 23:01:58', '2025-11-24 23:01:58', '2025-12-03 06:27:32');
INSERT INTO news (id, title, slug, excerpt, content, featured_image_url, author_id, status, is_featured, views_count, published_at, created_at, updated_at) VALUES ('3', 'Novedades en aceros de construcción', 'novedades-aceros-construccion', 'Conoce los últimos avances en aceros para proyectos de construcción.', '<p>La industria del acero continúa innovando con nuevas aleaciones...</p>', 'https://imgs.search.brave.com/4HjDEoACM0uIaL1o6YKClY6KK8lUGOtE4W20ovRF380/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/YXV0b2Rlc2tqb3Vy/bmFsLmNvbS93cC1j/b250ZW50L3VwbG9h/ZHMvMjAyMi8wNC9U/YWJsYXMtZGUtdGlw/b3MtZGUtcGVyZmls/ZXMtQUlTQy1hY3R1/YWxpemFkYXMtYS1s/YS0xNWEtZWRpY2lv/JUNDJTgxbi5wbmc', '1', 'published', '0', '2', '2025-11-14 23:01:58', '2025-11-24 23:01:58', '2025-12-03 06:27:34');


-- =====================================================
-- Tabla: products
-- =====================================================

CREATE TABLE "products" ("id" integer primary key autoincrement not null, "category_id" integer not null, "name" varchar not null, "slug" varchar not null, "description" text, "technical_specs" text, "price" numeric not null, "unit" varchar not null default 'saco', "stock_quantity" integer not null default '0', "sku" varchar, "image_url" varchar, "images" text, "brand" varchar, "weight" numeric, "dimensions" varchar, "status" varchar check ("status" in ('disponible', 'agotado', 'descontinuado')) not null default 'disponible', "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime, "benefits" text, "materials" text, "intended_use" text, "other_qualities" text, "detailed_specs" text, "color" varchar, "performance" varchar, "material_type" varchar, "weight_spec" varchar, "accessories" varchar, "warranty" varchar, "package_content" varchar, "model_spec" varchar, "height_spec" varchar, "width_spec" varchar, "length_spec" varchar, "depth_spec" varchar, "capacity" varchar, "pieces_count" varchar, "stock_min" integer not null default '10', foreign key("category_id") references "categories"("id") on delete cascade);

-- Datos de la tabla products
INSERT INTO products (id, category_id, name, slug, description, technical_specs, price, unit, stock_quantity, sku, image_url, images, brand, weight, dimensions, status, is_active, created_at, updated_at, benefits, materials, intended_use, other_qualities, detailed_specs, color, performance, material_type, weight_spec, accessories, warranty, package_content, model_spec, height_spec, width_spec, length_spec, depth_spec, capacity, pieces_count, stock_min) VALUES ('1', '2', 'Cemento Portland 50kg', 'cemento-portland-50kg', 'Cemento de alta calidad para construcción', NULL, '120', 'saco', '50', 'CEP-50', 'https://toolstoremexico.com.mx/img/p/2/0/4/1/5/20415-large_default.jpg', NULL, NULL, NULL, NULL, 'disponible', '1', '2025-11-24 23:01:58', '2025-11-25 21:16:38', 'Cemento Extra color gris está fabricado especialmente para reducir las grietas de las superficies hasta en un 80%, mejora la integración con otros materiales y da resistencia a condiciones ambientales extremas', 'n una presentación de 50 kilogramos de polvo fino. Por su mezcla compuesta y su reacción ante la hidratación permite un uso sostenible que evita los costos del proceso tradicional de curado y mantenimiento. Se puede utilizar ampliamente en todos los segmentos de construcción, infraestructura residencial y pública', NULL, NULL, NULL, 'Gris', '300/cm2', 'Polvo', '50 Kg', 'No', '90 días en tienda', '1 bulto de 50 kg', 'Cpc 30r rs', '43 cm', '43 cm', '62 cm', '19 cm', 'Resistencia de hasta 300/cm2', '1', '10');
INSERT INTO products (id, category_id, name, slug, description, technical_specs, price, unit, stock_quantity, sku, image_url, images, brand, weight, dimensions, status, is_active, created_at, updated_at, benefits, materials, intended_use, other_qualities, detailed_specs, color, performance, material_type, weight_spec, accessories, warranty, package_content, model_spec, height_spec, width_spec, length_spec, depth_spec, capacity, pieces_count, stock_min) VALUES ('2', '1', 'Varilla Corrugada 1/2"', 'varilla-corrugada-1-2', 'Varilla de acero corrugado para refuerzo', NULL, '150', 'pieza', '30', 'VAC-12', 'https://imgs.search.brave.com/peLbvb_yTGT9SJ2CCIXrHEdUOsWpjb7qaA0wpfLEx8w/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tYXBj/by5jb20ubXgvY2Ru/L3Nob3AvZmlsZXMv/aW1hZ2VzXzk2MzFj/YTAxLThmYWItNDg3/OS04OTg4LWVkMjI0/Nzk1YmZlZF84MDB4/LmpwZz92PTE3NTE0/NzY1NDI', NULL, NULL, NULL, NULL, 'disponible', '1', '2025-11-24 23:01:58', '2025-11-26 06:50:50', 'Resistente para la concentración de concreto', 'Varilla corrugada recta 1/2'''' 9.15 metros 12.7 mm. Peso 0.994 kg/m. La cantidad de piezas por tonelada puede variar.', NULL, NULL, NULL, 'Gris', '9m', 'Acero', '1000 kg', 'No', '90 días en tienda', '1 varilla corrugada', 'R42', '-cm', '- cm', '9.15 m', '0.15', 'Resistencia de hasta 9/cm', '4', '10');
INSERT INTO products (id, category_id, name, slug, description, technical_specs, price, unit, stock_quantity, sku, image_url, images, brand, weight, dimensions, status, is_active, created_at, updated_at, benefits, materials, intended_use, other_qualities, detailed_specs, color, performance, material_type, weight_spec, accessories, warranty, package_content, model_spec, height_spec, width_spec, length_spec, depth_spec, capacity, pieces_count, stock_min) VALUES ('3', '8', 'Lámina Galvanizada R-101', 'lamina-galvanizada-r-101', 'Lámina de acero galvanizado para techumbre', NULL, '350', 'pieza', '15', 'LAM-101', 'https://imgs.search.brave.com/emR0jotixKDMfy1jhBIIPxTXwXJAgObEcScvyY4-cmg/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9odHRw/Mi5tbHN0YXRpYy5j/b20vRF9OUV9OUF84/NTEzMDgtTUxNNTQ3/ODI2Mjc4MjBfMDMy/MDIzLU8ud2VicA', NULL, NULL, NULL, NULL, 'disponible', '1', '2025-11-24 23:01:58', '2025-12-03 06:32:07', 'Resistente a la intemperie, durable, ligera', 'Acero galvanizado G-60 o G-90', NULL, NULL, NULL, 'Zinc / Plateado', '1.01 m de ancho efectivo por hoja', 'Acero galvanizado', '4–12 kg según largo', 'No incluye', '10 años contra corrosión (según fabricante)', 'Pieza individual', 'R-101', '-', '1.05 m (1.01 m útil)', '1.83–6.10 m', 'Canal 25–30 mm', 'Cubiertas y muros', '1', '10');
INSERT INTO products (id, category_id, name, slug, description, technical_specs, price, unit, stock_quantity, sku, image_url, images, brand, weight, dimensions, status, is_active, created_at, updated_at, benefits, materials, intended_use, other_qualities, detailed_specs, color, performance, material_type, weight_spec, accessories, warranty, package_content, model_spec, height_spec, width_spec, length_spec, depth_spec, capacity, pieces_count, stock_min) VALUES ('4', '8', 'Vidrio Templado 6mm', 'vidrio-templado-6mm', 'Vidrio templado de seguridad', NULL, '550', 'm2', '0', 'VID-6mm', 'https://imgs.search.brave.com/SCLxd8zWRfVL_pSqCXfGlT7KKzmhif141-6oGRGjjh8/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9xYW5n/ZXIucGUvd3AtY29u/dGVudC91cGxvYWRz/LzIwMjQvMDkvVmlk/cmlvLXRlbXBsYWRv/LTZtbS53ZWJw', NULL, NULL, NULL, NULL, 'agotado', '1', '2025-11-24 23:01:58', '2025-12-03 06:35:10', 'Soporta 5–6 veces más impacto que vidrio normal
Mayor seguridad, no se astilla en fragmentos peligrosos', 'Sílice, carbonato, componentes templados térmicamente', NULL, NULL, NULL, 'Transparente', 'N/A', 'Vidrio templado', '5 kg/m² aprox', 'No incluye', '1 año contra defectos', 'Protecciones de cartón o madera', '6 mm', 'Según corte', 'Según corte', 'Según corte', 'Según corte', '6 mm', '1', '10');
INSERT INTO products (id, category_id, name, slug, description, technical_specs, price, unit, stock_quantity, sku, image_url, images, brand, weight, dimensions, status, is_active, created_at, updated_at, benefits, materials, intended_use, other_qualities, detailed_specs, color, performance, material_type, weight_spec, accessories, warranty, package_content, model_spec, height_spec, width_spec, length_spec, depth_spec, capacity, pieces_count, stock_min) VALUES ('5', '3', 'Tabla de Pino 2x4', 'tabla-pino-2x4', 'Madera de pino tratado para construcción', NULL, '250', 'pieza', '100', 'TAP-2x4', 'https://imgs.search.brave.com/Eiqmcn2cpaXv9SRhckY_d7UiFv243QuJqVuGFPFaBgw/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9odHRw/Mi5tbHN0YXRpYy5j/b20vRF9OUV9OUF83/NTcxOTktTUxBMjk2/NjY2MTg4OTZfMDMy/MDE5LVYud2VicA', NULL, NULL, NULL, NULL, 'disponible', '1', '2025-11-24 23:01:58', '2025-12-03 06:37:44', 'Económica, fácil de cortar, ligera', 'Madera de pino seca al horno', NULL, NULL, NULL, 'Madera natural', 'N/A', 'Madera de pino', '4–6 kg por pieza', 'No incluye', 'N/A', 'Suelta', '2x4”', '2” (3.8 cm nominal)', '4” (8.9 cm nominal)', '2.44 m (8 pies) estándar', '-', 'Construcción estructural', '1', '10');
INSERT INTO products (id, category_id, name, slug, description, technical_specs, price, unit, stock_quantity, sku, image_url, images, brand, weight, dimensions, status, is_active, created_at, updated_at, benefits, materials, intended_use, other_qualities, detailed_specs, color, performance, material_type, weight_spec, accessories, warranty, package_content, model_spec, height_spec, width_spec, length_spec, depth_spec, capacity, pieces_count, stock_min) VALUES ('6', '4', 'Cable Eléctrico #12 AWG', 'cable-electrico-12awg', 'Cable de cobre para instalaciones', NULL, '850', 'metro', '500', 'CAB-12', 'https://imgs.search.brave.com/ckOLI5TDS6VH09iE294coqwIWOdyiwmh9B-6-55jQAU/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/ODFpQkw3bmdpZkwu/anBn', NULL, NULL, NULL, NULL, 'disponible', '1', '2025-11-24 23:01:58', '2025-12-03 06:40:39', 'Alta conductividad, flexible, resistente al calor', 'Cobre electrolítico, PVC o nylon', NULL, NULL, NULL, 'Negro', 'Para circuitos de hasta 20A', 'Cobre con aislamiento THHN / THW', '1.5–3 kg por rollo', 'No incluye', '5 años', 'Rollo de 100 m', '12 AWG', '-', '-', '-', '-', '600 V', '1 por rollo', '10');
INSERT INTO products (id, category_id, name, slug, description, technical_specs, price, unit, stock_quantity, sku, image_url, images, brand, weight, dimensions, status, is_active, created_at, updated_at, benefits, materials, intended_use, other_qualities, detailed_specs, color, performance, material_type, weight_spec, accessories, warranty, package_content, model_spec, height_spec, width_spec, length_spec, depth_spec, capacity, pieces_count, stock_min) VALUES ('7', '6', 'Tubería PVC 3/4"', 'tuberia-pvc-3-4', 'Tubería de PVC para agua', NULL, '220', 'metro', '200', 'TUB-34', 'https://imgs.search.brave.com/LvRAvzHpXdf3pVZgOSIdqnAVkxiOjb35IjzSDz_SKnQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pbWFn/ZXMtbmEuc3NsLWlt/YWdlcy1hbWF6b24u/Y29tL2ltYWdlcy9J/LzUxdy1PRWFTREVM/LmpwZw', NULL, NULL, NULL, NULL, 'disponible', '1', '2025-11-24 23:01:58', '2025-12-03 06:43:13', 'Ligera, económica, anticorrosiva', 'PVC grado hidráulico', NULL, NULL, NULL, 'Blanco', 'Apta para agua fría', 'PVC rígido', '200–400 g por metro', 'No incluye', '5 años', 'Tirajes de 6 m', '3/4”', 'Diámetro nominal 26 mm', 'Diámetro nominal 26 mm', 'Diámetro nominal 26 mm', '6 m', 'Presión 7–13 kg/cm² (según clase)', '1', '10');
INSERT INTO products (id, category_id, name, slug, description, technical_specs, price, unit, stock_quantity, sku, image_url, images, brand, weight, dimensions, status, is_active, created_at, updated_at, benefits, materials, intended_use, other_qualities, detailed_specs, color, performance, material_type, weight_spec, accessories, warranty, package_content, model_spec, height_spec, width_spec, length_spec, depth_spec, capacity, pieces_count, stock_min) VALUES ('8', '7', 'Martillo Stanley 16oz', 'martillo-stanley-16oz', 'Martillo de goma con mango', NULL, '45', 'pieza', '20', 'MAR-16', 'https://imgs.search.brave.com/RWGGTF2ExN4-l9S_byTKW5l0DfkmYHl9TqRyahaP1go/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9odHRw/Mi5tbHN0YXRpYy5j/b20vRF9RX05QXzJY/Xzg2NzI4NS1NTFU3/MDM1MjYyMTAwOV8w/NzIwMjMtRS53ZWJw', NULL, NULL, NULL, NULL, 'disponible', '1', '2025-11-24 23:01:58', '2025-12-03 06:45:42', 'Duradero, agarre antiderrapante, diseño balanceado', 'Acero templado, fibra de vidrio / goma', NULL, NULL, NULL, 'Amarillo con negro', 'Uso general en carpintería', 'Acero al carbono, mango de fibra', '16 oz (454 g)', 'No incluye', 'De por vida (Stanley)', 'Blíster', '16oz', '30-33', '3 cm cabeza', '-', '-', 'Clavado estándar', '1', '10');
INSERT INTO products (id, category_id, name, slug, description, technical_specs, price, unit, stock_quantity, sku, image_url, images, brand, weight, dimensions, status, is_active, created_at, updated_at, benefits, materials, intended_use, other_qualities, detailed_specs, color, performance, material_type, weight_spec, accessories, warranty, package_content, model_spec, height_spec, width_spec, length_spec, depth_spec, capacity, pieces_count, stock_min) VALUES ('9', '9', 'Arena Fina para Construcción', 'arena-fina', 'Arena tamizada para mezclas', NULL, '500', 'm3', '100', 'ARE-1', 'https://imgs.search.brave.com/RtCZjkLMXI1EU2BkhyVZVfOlIx1N0_odahSMDEOjHaM/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9wbG9t/ZXJpYXVuaXZlcnNh/bC5teC9jZG4vc2hv/cC9wcm9kdWN0cy9h/cmVuYV81MDB4NTAw/LmpwZz92PTE3NTcx/NzczMTM', NULL, NULL, NULL, NULL, 'disponible', '1', '2025-11-24 23:01:58', '2025-12-03 06:48:28', 'Textura fina, buena compactación', 'Sílice, minerales naturales', NULL, NULL, NULL, 'Beige / Gris', '0.016–0.020 m³', 'Arena silica / de río', '75 por m³', 'No incluye', 'N/A', '-', 'Fina', '-', '-', '-', '-', 'Mezclado para aplanados y colados', 'En m³', '10');
INSERT INTO products (id, category_id, name, slug, description, technical_specs, price, unit, stock_quantity, sku, image_url, images, brand, weight, dimensions, status, is_active, created_at, updated_at, benefits, materials, intended_use, other_qualities, detailed_specs, color, performance, material_type, weight_spec, accessories, warranty, package_content, model_spec, height_spec, width_spec, length_spec, depth_spec, capacity, pieces_count, stock_min) VALUES ('10', '5', 'Pintura Latex Blanca 5L', 'pintura-latex-blanca-5l', 'Pintura latex de buena cobertura', NULL, '55', 'galón', '63', 'PIN-LTX', 'https://imgs.search.brave.com/FoksS1pIp0ZcoZP02Tx02wvoVI3M9hmvRy1foPGG4As/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5ycy1vbmxpbmUu/Y29tL2ltYWdlL3Vw/bG9hZC9ib18xLjVw/eF9zb2xpZF93aGl0/ZSxiX2F1dG8sY19w/YWQsZHByXzIsZl9h/dXRvLGhfMzk5LHFf/YXV0byx3XzcxMC9j/X3BhZCxoXzM5OSx3/XzcxMC9ZMjMxMDcx/Mi0wMT9wZ3c9MQ', NULL, NULL, NULL, NULL, 'disponible', '1', '2025-11-24 23:01:58', '2025-12-04 05:06:16', 'Secado rápido, lavable, bajo olor', 'Resinas acrílicas, pigmentos, aditivos', NULL, NULL, NULL, 'Blanco', '6–10 m² por litro', 'Látex acrílico', '5 kg', 'No incluye', '1–3 años', 'Cubeta de 5 L', 'Cubeta de 5 L', '25–30 cm', '20–25 cm', '-', '-', '5 L', '1', '10');
INSERT INTO products (id, category_id, name, slug, description, technical_specs, price, unit, stock_quantity, sku, image_url, images, brand, weight, dimensions, status, is_active, created_at, updated_at, benefits, materials, intended_use, other_qualities, detailed_specs, color, performance, material_type, weight_spec, accessories, warranty, package_content, model_spec, height_spec, width_spec, length_spec, depth_spec, capacity, pieces_count, stock_min) VALUES ('11', '9', 'Grava', 'grava-1', 'Es el material ideal para aportar peso y solidez a tus mezclas de concreto', NULL, '600', 'm3', '0', NULL, 'https://www.todoparatucasa.mx/wp-content/uploads/2019/09/TRITU01-600x600.jpg', NULL, NULL, NULL, NULL, 'disponible', '1', '2025-11-25 07:19:53', '2025-12-03 06:55:05', 'Resistente, estable, durable', 'Piedra caliza o basalto triturado', NULL, NULL, NULL, 'Gris', '0.016–0.020 m³', 'Piedra triturada', '40 kg', 'No incluye', 'N/A', 'm³', 'N/A', '-', '-', '-', '-', 'Concreto, rellenos, drenaje', 'En m³', '10');


-- =====================================================
-- Tabla: quotation_items
-- =====================================================

CREATE TABLE "quotation_items" ("id" integer primary key autoincrement not null, "quotation_id" integer not null, "product_id" integer not null, "quantity" integer not null, "unit_price" numeric not null, "line_total" numeric not null, "created_at" datetime, "updated_at" datetime, foreign key("quotation_id") references "quotations"("id") on delete cascade, foreign key("product_id") references "products"("id") on delete cascade);

-- Datos de la tabla quotation_items
INSERT INTO quotation_items (id, quotation_id, product_id, quantity, unit_price, line_total, created_at, updated_at) VALUES ('1', '1', '1', '1', '120', '120', '2025-11-26 07:01:18', '2025-11-26 07:01:18');
INSERT INTO quotation_items (id, quotation_id, product_id, quantity, unit_price, line_total, created_at, updated_at) VALUES ('2', '1', '2', '1', '150', '150', '2025-11-26 07:01:18', '2025-11-26 07:01:18');
INSERT INTO quotation_items (id, quotation_id, product_id, quantity, unit_price, line_total, created_at, updated_at) VALUES ('3', '1', '9', '1', '500', '500', '2025-11-26 07:01:18', '2025-11-26 07:01:18');


-- =====================================================
-- Tabla: quotations
-- =====================================================

CREATE TABLE "quotations" ("id" integer primary key autoincrement not null, "user_id" integer not null, "reference_number" varchar not null, "subtotal" numeric not null default '0', "tax_amount" numeric not null default '0', "total_amount" numeric not null default '0', "discount_amount" numeric default '0', "status" varchar check ("status" in ('pendiente', 'aceptada', 'rechazada', 'expirada')) not null default 'pendiente', "notes" text, "valid_until" datetime, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete cascade);

-- Datos de la tabla quotations
INSERT INTO quotations (id, user_id, reference_number, subtotal, tax_amount, total_amount, discount_amount, status, notes, valid_until, created_at, updated_at) VALUES ('1', '2', 'COT-20251126-0001', '770', '146.3', '916.3', '0', 'aceptada', 'solamente esto', '2025-12-26 07:01:18', '2025-11-26 07:01:18', '2025-11-27 05:38:17');


-- =====================================================
-- Tabla: carts
-- =====================================================

CREATE TABLE "carts" ("id" integer primary key autoincrement not null, "user_id" integer not null, "product_id" integer not null, "quantity" integer not null default '1', "price" numeric not null, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete cascade, foreign key("product_id") references "products"("id") on delete cascade);

-- Datos de la tabla carts
INSERT INTO carts (id, user_id, product_id, quantity, price, created_at, updated_at) VALUES ('1', '2', '1', '1', '120', '2025-11-25 20:04:27', '2025-11-25 20:04:27');
INSERT INTO carts (id, user_id, product_id, quantity, price, created_at, updated_at) VALUES ('2', '2', '2', '1', '150', '2025-11-25 20:05:01', '2025-11-25 20:05:01');


-- =====================================================
-- Tabla: messages
-- =====================================================

CREATE TABLE "messages" ("id" integer primary key autoincrement not null, "name" varchar not null, "email" varchar not null, "message" text not null, "is_read" tinyint(1) not null default '0', "created_at" datetime, "updated_at" datetime);

-- Datos de la tabla messages
INSERT INTO messages (id, name, email, message, is_read, created_at, updated_at) VALUES ('1', 'Pipeline', 'torres@gmail.com', 'Quisiera saber como es su plan', '1', '2025-12-03 07:02:20', '2025-12-03 07:02:36');


-- =====================================================
-- Tabla: inventory_movements
-- =====================================================

CREATE TABLE "inventory_movements" ("id" integer primary key autoincrement not null, "product_id" integer not null, "user_id" integer not null, "type" varchar check ("type" in ('entrada', 'salida', 'ajuste')) not null, "quantity" integer not null, "stock_before" integer not null, "stock_after" integer not null, "reason" text, "reference" varchar, "created_at" datetime, "updated_at" datetime, foreign key("product_id") references "products"("id") on delete cascade, foreign key("user_id") references "users"("id") on delete cascade);

-- Datos de la tabla inventory_movements
INSERT INTO inventory_movements (id, product_id, user_id, type, quantity, stock_before, stock_after, reason, reference, created_at, updated_at) VALUES ('1', '10', '1', 'entrada', '23', '40', '63', 'añadir mas', '#123', '2025-12-04 05:06:16', '2025-12-04 05:06:16');

