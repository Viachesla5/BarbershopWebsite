-- Insert a new customer
INSERT INTO users (
    email, username, password, phone_number, address, profile_picture
) VALUES (
    'john@example.com',
    'john_doe',
    'hashedPassword123',
    '123-456-7890',
    '123 Cherry Lane, Springfield',
    'profile_pics/john.png'
);

-- Insert a new hairdresser (staff)
INSERT INTO hairdressers (
    email, name, password, phone_number, address, profile_picture, specialization
) VALUES (
    'daniel@example.com',
    'Daniel',
    'anotherHashedPassword456',
    '555-111-2222',
    '99 Salon Street, Springfield',
    'profile_pics/daniel.png',
    'Cutting & Styling'
);

-- Update a hairdresser's phone_number, address, specialization
UPDATE hairdressers
SET 
    phone_number = '555-123-4567',
    address = '100 Main St, Springfield',
    specialization = 'Coloring & Styling'
WHERE id = 1;
