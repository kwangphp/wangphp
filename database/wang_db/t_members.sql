-- Table t_members of database wang_db
-- 7 parameter
-- 1 primary key
-- 6 variables

CREATE TABLE t_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_auth_token VARCHAR(255) DEFAULT NULL,
    m_email VARCHAR(50) NOT NULL UNIQUE,
    m_password VARCHAR(255) NOT NULL,
    m_account_state VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);
