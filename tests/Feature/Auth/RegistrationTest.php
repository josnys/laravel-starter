<?php

use App\Providers\RouteServiceProvider;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
   $response = $this->post('/register', [
        'firstname' => 'The New',
        'lastname' => 'User',
        'username' => 'the_new_username',
        'email' => 'the_new_username@app.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});
