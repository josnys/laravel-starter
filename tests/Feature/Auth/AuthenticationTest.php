<?php

use Domains\User\Models\User;
use App\Providers\RouteServiceProvider;

test('login screen can be rendered', function () {    
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen with username', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->username,
        'password' => 'password',
        'remember' => fake()->boolean()
    ]);
    
    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

test('users can authenticate using the login screen with email', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'remember' => fake()->boolean()
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
        'remember' => fake()->boolean()
    ]);

    $this->assertGuest();
});
