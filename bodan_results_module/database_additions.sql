-- Add results table (if not present)
CREATE TABLE IF NOT EXISTS `results` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT NOT NULL,
  `subject` VARCHAR(100) NOT NULL,
  `score` INT NOT NULL,
  `grade` VARCHAR(5) NOT NULL,
  `term` VARCHAR(20) NOT NULL,
  `session` VARCHAR(20) NOT NULL,
  `remark` TEXT NULL,
  `teacher_id` INT NULL,
  `date_uploaded` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE SET NULL
);
