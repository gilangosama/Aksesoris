<?php
require 'bootstrap/app.php';
$app = app();

// Use Eloquent
use App\Models\User;

// Update or create admin user
User::updateOrCreate(
    ['email' => 'admin@example.com'],
    [
        'name' => 'Admin User',
        'password' => bcrypt('admin123'),
        'email_verified_at' => now(),
    ]
);

echo "✅ Admin user setup complete!\n";
echo "Email: admin@example.com\n";
echo "Password: admin123\n";
