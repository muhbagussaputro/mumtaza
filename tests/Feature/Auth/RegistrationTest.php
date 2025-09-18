<?php

// Registration tests disabled because public registration is disabled for security
// Only admin can create users through admin panel

test('registration route is disabled', function () {
    $response = $this->get('/register');
    $response->assertStatus(404);
});

test('registration post is disabled', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'siswa',
    ]);

    $response->assertStatus(404);
});
