<?php

use Domains\User\Models\Permission;
use Domains\User\Models\Role;
use Illuminate\Support\Str;

test('user can access role page', function () {
    $user = createUserAdmin();

    $response = $this->actingAs($user)
        ->get(route('admin.role.index'));

    $response->assertOk();
});

test('user can not access role page', function () {
    $user = createUser();

    $response = $this->actingAs($user)
        ->get(route('admin.role.index'));

    $response->assertForbidden();
});

test('user can create a new role', function(){
    $user = createUserAdmin();
    $name = implode(' ', fake()->words(2));
    $data = ['display_name' => $name, 'slug' => Str::slug($name), 'is_active' => fake()->boolean()];

    $response = $this->actingAs($user)
        ->post(route('admin.role.store'), $data);

    $response->assertSessionHasNoErrors()
        ->assertRedirect('/admin/role');
});

test('user is not authorized to create a new role', function () {
    $user = createUser();
    $name = implode(' ', fake()->words(2));
    $data = ['display_name' => $name, 'slug' => Str::slug($name), 'is_active' => fake()->boolean()];

    $response = $this->actingAs($user)
        ->post(route('admin.role.store'), $data);

    $response->assertSessionHasNoErrors()
        ->assertForbidden();
});

test('user can update a new role', function () {
    $user = createUserAdmin();
    $role = Role::factory()->createOne();

    $response = $this->actingAs($user)
        ->patch(route('admin.role.update', $role->slug), [
            'display_name' => 'Updated Role',
            'is_active' => fake()->boolean()
        ]);

    $role->refresh();

    $response->assertSessionHasNoErrors()
        ->assertRedirect('/admin/role');
    $this->assertSame('Updated Role', $role->display_name);
});

test('user can assign permissions to role', function(){
    $user = createUserAdmin();
    $permissions = Permission::factory(5)->create()->map(function($permission){
        return ['id' => $permission->id, 'slug' => $permission->slug, 'is_checked' => fake()->boolean()];
    })->toArray();

    $role = Role::factory()->createOne();

    $response = $this->actingAs($user)
        ->post(route('admin.role.permission.store', $role->slug), [
            'permissions' => $permissions
        ]);
    
    $response->assertSessionHasNoErrors()
        ->assertRedirect('admin/role');
    
    $this->assertSame($role->permissions()->pluck('id')->toArray(), collect($permissions)->where('is_checked', true)->pluck('id')->toArray());
    expect($role->permissions()->pluck('id')->toArray())->toEqual(collect($permissions)->where('is_checked', true)->pluck('id')->toArray());
});
