-- Create database
CREATE DATABASE IF NOT EXISTS organ_donation;
USE organ_donation;

-- Create admin table
CREATE TABLE admin (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

-- Create alerts table
CREATE TABLE alerts (
    alert_id INT(11) NOT NULL AUTO_INCREMENT,
    recipient_id INT(11) DEFAULT NULL,
    donor_id INT(11) DEFAULT NULL,
    alert_message TEXT DEFAULT NULL,
    alert_type ENUM('organ_available', 'recipient_status_change', 'evaluation_needed') DEFAULT NULL,
    alert_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (alert_id),
    FOREIGN KEY (recipient_id) REFERENCES recipients(recipient_id) ON DELETE SET NULL,
    FOREIGN KEY (donor_id) REFERENCES donors(donor_id) ON DELETE SET NULL
);

-- Create donations table
CREATE TABLE donations (
    donation_id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    recipient_id INT(11) NOT NULL,
    organ_donated VARCHAR(255) DEFAULT NULL,
    blood_donated VARCHAR(10) DEFAULT NULL,
    donation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'completed', 'canceled') DEFAULT 'pending',
    PRIMARY KEY (donation_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipient_id) REFERENCES recipients(recipient_id) ON DELETE CASCADE
);

-- Create donors table
CREATE TABLE donors (
    donor_id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    blood_type VARCHAR(10) NOT NULL,
    organs_donated TEXT NOT NULL,
    health_status TEXT DEFAULT NULL,
    availability ENUM('available', 'unavailable') DEFAULT 'available',
    consent ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    registered_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (donor_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Create hospitals table
CREATE TABLE hospitals (
    hospital_id INT(11) NOT NULL AUTO_INCREMENT,
    hospital_name VARCHAR(200) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) DEFAULT NULL,
    address TEXT DEFAULT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    registered_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (hospital_id)
);

-- Create matches table
CREATE TABLE matches (
    match_id INT(11) NOT NULL AUTO_INCREMENT,
    donor_id INT(11) NOT NULL,
    recipient_id INT(11) NOT NULL,
    organ VARCHAR(50) NOT NULL,
    match_status ENUM('Pending', 'Confirmed', 'Transplanted', 'Cancelled') DEFAULT 'Pending',
    hospital VARCHAR(100) NOT NULL,
    transplant_date DATE DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (match_id),
    FOREIGN KEY (donor_id) REFERENCES donors(donor_id) ON DELETE CASCADE,
    FOREIGN KEY (recipient_id) REFERENCES recipients(recipient_id) ON DELETE CASCADE
);

-- Create messages table
CREATE TABLE messages (
    message_id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    sent_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    admin_reply TEXT DEFAULT NULL,
    PRIMARY KEY (message_id)
);

-- Create notifications table
CREATE TABLE notifications (
    notification_id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('unread', 'read') DEFAULT 'unread',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (notification_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Create organs table
CREATE TABLE organs (
    organ_id INT(11) NOT NULL AUTO_INCREMENT,
    donor_id INT(11) NOT NULL,
    organ_type VARCHAR(50) NOT NULL,
    blood_type VARCHAR(10) NOT NULL,
    status ENUM('available', 'matched', 'transplanted', 'expired') DEFAULT 'available',
    added_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (organ_id),
    FOREIGN KEY (donor_id) REFERENCES donors(donor_id) ON DELETE CASCADE
);

-- Create recipients table
CREATE TABLE recipients (
    recipient_id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    required_organ VARCHAR(50) NOT NULL,
    urgency_level ENUM('low', 'medium', 'high', 'critical') DEFAULT 'low',
    medical_condition TEXT DEFAULT NULL,
    doctor_notes TEXT DEFAULT NULL,
    registered_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (recipient_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Create reports table
CREATE TABLE reports (
    report_id INT(11) NOT NULL AUTO_INCREMENT,
    recipient_id INT(11) NOT NULL,
    doctor_name VARCHAR(100) NOT NULL,
    diagnosis TEXT NOT NULL,
    treatment_plan TEXT NOT NULL,
    additional_notes TEXT DEFAULT NULL,
    report_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (report_id),
    FOREIGN KEY (recipient_id) REFERENCES recipients(recipient_id) ON DELETE CASCADE
);

-- Create system_settings table
CREATE TABLE system_settings (
    id INT(11) NOT NULL AUTO_INCREMENT,
    site_name VARCHAR(255) DEFAULT NULL,
    logo VARCHAR(255) DEFAULT NULL,
    theme_color VARCHAR(50) DEFAULT NULL,
    contact_email VARCHAR(100) DEFAULT NULL,
    contact_phone VARCHAR(15) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

-- Create transplant_schedule table
CREATE TABLE transplant_schedule (
    schedule_id INT(11) NOT NULL AUTO_INCREMENT,
    recipient_id INT(11) DEFAULT NULL,
    surgery_date DATE DEFAULT NULL,
    surgery_time TIME DEFAULT NULL,
    assigned_doctor VARCHAR(255) DEFAULT NULL,
    status ENUM('Scheduled', 'Completed', 'Cancelled') DEFAULT 'Scheduled',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (schedule_id),
    FOREIGN KEY (recipient_id) REFERENCES recipients(recipient_id) ON DELETE SET NULL
);

-- Create transplants table
CREATE TABLE transplants (
    transplant_id INT(11) NOT NULL AUTO_INCREMENT,
    donor_id INT(11) DEFAULT NULL,
    recipient_id INT(11) DEFAULT NULL,
    organ_type VARCHAR(100) DEFAULT NULL,
    transplant_date DATE DEFAULT NULL,
    follow_up_date DATE DEFAULT NULL,
    status ENUM('scheduled', 'completed', 'failed') DEFAULT 'scheduled',
    date_added TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (transplant_id),
    FOREIGN KEY (donor_id) REFERENCES donors(donor_id) ON DELETE SET NULL,
    FOREIGN KEY (recipient_id) REFERENCES recipients(recipient_id) ON DELETE SET NULL
);

-- Create users table
CREATE TABLE users (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT DEFAULT NULL,
    role ENUM('donor', 'recipient', 'hospital') NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id)
);
