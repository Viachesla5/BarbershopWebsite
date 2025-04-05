-- Insert Admin User
INSERT INTO users (email, username, password, is_admin, profile_picture) VALUES
('admin@gmail.com', 'Sherlock', '$2y$12$Ry2Tuh42KfqH7/qVl8Nxoe/b68EDquFrKUSsWm9WPwS1LXfhvpVKu', TRUE, '/uploads/profile_pictures/profile_67f18e0b9d277.jpg'); -- password: Admin!123

-- Insert Regular Users (passwords should be hashed in real application)
INSERT INTO users (email, username, password, phone_number, address) VALUES
('bober@gmail.com', 'Bober', '$2y$12$krpOHbBIjHRcW9mpiuXztu5aqKG2oASAgb7qpz.VtlbZ2ArFQvT6O', '+31612345678', 'Amsterdam Street 1'), -- password: Bober!123
('eva@gmail.com', 'Eva', '$2y$12$ezn4aGg8O03zQ4QlqNfHLOv4FNyz9KmeOjHNg6rHPbVOOCmEjsLMC', '+31634567890', 'Utrecht Road 3'), -- password: EvaEva!123
('puss@gmail.com', 'Puss', '$2y$12$cebOsDfcfmO3ye6pNJPgCu7.UXtdSS3SUY67q9aQHWwaqeHczn8V.', '+31689012345', 'Breda Lane 8'); -- password: Puss!123

-- Insert Hairdressers
INSERT INTO hairdressers (email, name, password, phone_number, address, specialization, profile_picture) VALUES
('olenka@gmail.com', 'Olenka', '$2y$12$7AiTXwh3oy0u2F7UnjZJ7.IXZxv2.wU.pBdSZjoJspnSy1XAFkXHe', '+31690123456', 'Salon Street 1', 'Color Specialist', '/uploads/hairdressers/hairdresser_12_67f18ba89aff1.png'), -- password: Olenka!123
('rafal@gmail.com', 'Rafal', '$2y$12$RM/0qNCZlMa4THWqPNlgPOgfH5r.dT69avxneq8YJI0OONKdjuM.C', '+31601234567', 'Salon Avenue 2', 'Men''s Hair Specialist', '/uploads/hairdressers/hairdresser_13_67f18b8d759c4.png'), -- password: Rafal!123
('cezar@gmail.com', 'Cezar', '$2y$12$2SAuCvIguFqDwJOEcrx/qu6qS3qW/8B4kJCpiHKek.UidNbELZCyS', '+31612345678', 'Salon Road 3', 'Men''s Hair Specialist', '/uploads/hairdressers/hairdresser_14_67f18c86e0c1d.png'); -- password: Cezar!123
