Bodan International School - Portal (ZIP package)

Default database credentials (used in config.php):
  DB_HOST = localhost
  DB_USER = root
  DB_PASS = (empty string)
  DB_NAME = bodan_portal_db

Default seeded admin (for demo only):
  email: admin@bodan.edu
  password: 123  (MD5 seeded for quick demo) -> CHANGE IMMEDIATELY after install

How to install:
1. Upload all files to your PHP host or copy to htdocs in XAMPP/Laragon.
2. Import db.sql using phpMyAdmin or the mysql CLI.
3. Edit config.php and replace Paystack keys with your test/production keys.
4. Ensure 'uploads' folder is writable (if using file uploads).
5. If you want PDF report cards, install Dompdf via Composer: composer require dompdf/dompdf
6. For security, change seeded admin password and use password_hash/password_verify for real deployments.

Included modules:
- Public site (index, about, contact, admission form)
- School Portal (admin, teacher, student areas)
- Results Management (single upload + CSV bulk upload + view + PDF export fallback)
- Paystack payments (pay, verify, payment_history)
- Attendance tracking (attendance table + basic structure)
- Messaging (send/read messages between users)
- File uploads (upload and list files)

If you want me to install stronger authentication (session-based with password_hash, role middleware, and logout flows) before packaging, tell me.


AUTH NOTES:
- Use install_seed.php to create initial admin (visit and then delete the file).
- To create teachers and students, either use phpMyAdmin and insert password hashed with PHP's password_hash(), or add a small PHP script to register them.
- Example to create teacher via PHP CLI:
<?php require 'config.php'; $pass=password_hash('teacherpass',PASSWORD_DEFAULT); $stmt=$conn->prepare('INSERT INTO teachers (name,email,password) VALUES (?,?,?)'); $stmt->bind_param('sss','Mr Teacher','teacher@bodan.edu',$pass); $stmt->execute(); ?>
