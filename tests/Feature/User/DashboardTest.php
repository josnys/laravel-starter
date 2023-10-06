<?php

test('user can access admin dashboard', function () {
    $admin = createUserAdmin();
    
    $response = $this->actingAs($admin)
        ->get('/admin/dashboard');

    $response->assertOk();
});

test('user can not access admin dashboard', function () {
    $user = createUser();

    $response = $this->actingAs($user)
        ->get('/admin/dashboard');

    $response->assertStatus(403);
});
