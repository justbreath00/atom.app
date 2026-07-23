-- =========================
-- COURSES
-- =========================
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(20) NOT NULL UNIQUE,
    course_name VARCHAR(150) NOT NULL,
    status ENUM('active','archived') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO courses (course_code, course_name) VALUES
('BSIT', 'Bachelor of Science in Information Technology'),
('BSA', 'Bachelor of Science in Accountancy'),
('BSBA', 'Bachelor of Science in Business Administration'),
('BSED', 'Bachelor of Secondary Education'),
('BEED', 'Bachelor of Elementary Education'),
('BSHM', 'Bachelor of Science in Hospitality Management'),
('BSN', 'Bachelor of Science in Nursing'),
('BSCRIM', 'Bachelor of Science in Criminology'),
('BSCE', 'Bachelor of Science in Civil Engineering');

-- =========================
-- USERS
-- =========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    course_id INT NULL,
    last_login_at DATETIME NULL,
    last_login_ip VARCHAR(45) NULL,
    last_user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL
);

-- =========================
-- SUBJECTS
-- =========================
CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    subject_code VARCHAR(20) NOT NULL UNIQUE,
    subject_title VARCHAR(100) NOT NULL,
    subject_type ENUM('minor','major') NOT NULL,
    prerequisite INT NULL,
    unit INT NOT NULL,
    year ENUM('first year','second year','third year','fourth year') NOT NULL,
    semester ENUM('first semester','second semester') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (prerequisite) REFERENCES subjects(id) ON DELETE SET NULL
);

-- =========================
-- CLASSES (block/section container)
-- =========================
CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_code VARCHAR(30) NOT NULL UNIQUE,
    block VARCHAR(10) NOT NULL,
    year ENUM('first year','second year','third year','fourth year') NOT NULL,
    semester ENUM('first semester','second semester') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =========================
-- CLASS SUBJECTS (subjects added to a block)
-- =========================
CREATE TABLE class_subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    subject_id INT NOT NULL,
    subject_adviser VARCHAR(250) NOT NULL,
    status ENUM('active','dropped') DEFAULT 'active',
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (class_id, subject_id),
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- =========================
-- CLASS SCHEDULE (per subject in a block)
-- =========================
CREATE TABLE class_schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_subject_id INT NOT NULL,
    day_of_week TINYINT NOT NULL,       -- 1=Mon ... 7=Sun
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    meeting_type ENUM('onsite','online') NOT NULL,
    location VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (class_subject_id) REFERENCES class_subjects(id) ON DELETE CASCADE,
    UNIQUE (class_subject_id, day_of_week, start_time)
);

-- =========================
-- REQUEST STATUS (join requests)
-- =========================
CREATE TABLE request_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    user_id INT NOT NULL,
    status ENUM('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (class_id, user_id),
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =========================
-- CLASS MEMBERS
-- =========================
CREATE TABLE class_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    user_id INT NOT NULL,
    role ENUM('admin','editor','member') NOT NULL DEFAULT 'member',
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_membership (class_id, user_id),
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =========================
-- CLASS TASKS (tied to a class subject)
-- =========================
CREATE TABLE class_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    creator_id INT NOT NULL,
    class_id INT NOT NULL,
    class_subject_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    task_type ENUM(
        'module',
        'activity',
        'quiz',
        'assignment',
        'final-requirement',
        'other'
    ) DEFAULT 'other',
    deadline DATETIME NULL,
    priority ENUM('low','medium','high') DEFAULT 'medium',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creator_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (class_subject_id) REFERENCES class_subjects(id) ON DELETE CASCADE
);

-- =========================
-- CLASS TASK MEMBERS (progress per member)
-- =========================
CREATE TABLE class_task_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_task_id INT NOT NULL,
    user_id INT NOT NULL,
    status ENUM('todo','ongoing','finished','archived') DEFAULT 'todo',
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE (class_task_id, user_id),
    FOREIGN KEY (class_task_id) REFERENCES class_tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =========================
-- PERSONAL TASKS
-- =========================
CREATE TABLE personal_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    deadline DATETIME NULL,
    priority ENUM('low','medium','high') DEFAULT 'medium',
    status ENUM('todo','ongoing','finished','archived') DEFAULT 'todo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
