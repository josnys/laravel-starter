<?php

use Domains\User\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/user/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();
    $username = 'my_new_username'; // fake()->userName();
    $email = fake()->email();

    $response = $this
        ->actingAs($user)
        ->patch('/user/profile', [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'dob' => null,
            'bio' => null,
            'username' => $username,
            'email' => $email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/user/profile');

    $user = User::find($user->id);

    $this->assertSame($username, $user->username);
    $this->assertSame($email, $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/user/profile', [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'dob' => null,
            'bio' => null,
            'username' => $user->username,
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/user/profile');
    $user = User::find($user->id);

    $this->assertNotNull($user->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/user/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');
    
    $user = User::find($user->id);

    $this->assertGuest();
    $this->assertNull($user);
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/user/profile')
        ->delete('/user/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('password')
        ->assertRedirect('/user/profile');

    $user = User::find($user->id);

    $this->assertNotNull($user->fresh());
});
