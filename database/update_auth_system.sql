-- Update authentication system
-- Add role column to users table
ALTER TABLE `users` ADD COLUMN `role` VARCHAR(50) NOT NULL DEFAULT 'user' AFTER `address`;

-- Update existing user to admin (based on your current data)
UPDATE `users` SET `role` = 'admin' WHERE `email` = 'vudevweb@gmail.com';

-- Create admin user if needed
INSERT IGNORE INTO `users` (`name`, `email`, `phone`, `password`, `address`, `role`, `email_verified_at`, `created_at`, `updated_at`) VALUES
('Administrator', 'admin@fitzone.com', '0123456789', '$2y$12$LfMUg1RhmgkGF.wwGxGq5OVYLey54UemUObETdAVHVJ/u6bYAXmza', 'FitZone Headquarters', 'admin', NOW(), NOW(), NOW());

-- Drop employees table as it's no longer needed
DROP TABLE IF EXISTS `employees`;
