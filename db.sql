-- Drop the table if it exists
DROP TABLE IF EXISTS core_hms_fields;

-- Create the table
CREATE TABLE core_hms_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    message TEXT,
    gender ENUM('Male', 'Female', 'Other'),
    uploaded_file VARCHAR(255),
    country VARCHAR(100),
    subscribe_newsletter BOOLEAN,
    birth_date DATE,
    age INT,
    email VARCHAR(100)
);

-- Insert sample data
INSERT INTO core_hms_fields (
    name, message, gender, uploaded_file, country,
    subscribe_newsletter, birth_date, age, email
)
VALUES
(
    'Alice Smith',
    'Hello, I am interested in your services.',
    'Female',
    'uploads/resume_alice.pdf',
    'USA',
    TRUE,
    '1990-05-12',
    34,
    'alice@example.com'
),
(
    'Bob Johnson',
    'Looking forward to hearing from you.',
    'Male',
    'uploads/photo_bob.png',
    'Canada',
    FALSE,
    '1985-11-23',
    39,
    'bob.j@example.com'
);
