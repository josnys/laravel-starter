<?php

use Domains\User\Models\Permission;
use Domains\User\Models\Role;
use Domains\User\Models\User;
use Illuminate\Support\Facades\Hash;

test('admin user can edit a user', function () {
    $admin = createUserAdmin();
    $user = createUser();
    $firstname = fake()->firstName();
    $lastname = fake()->lastName();
    $suspended = fake()->boolean();
    $banned = fake()->boolean();

    $response = $this->actingAs($admin)
        ->patch(route('admin.user.update', $user->username), [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'suspended' => $suspended,
            'banned' => $banned
        ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect('/admin/user');
    
    $user->refresh();
    $user = User::with('person')->find($user->id);

    $this->assertSame($firstname, $user->person->firstname);
    $this->assertSame($lastname, $user->person->lastname);
});

test('user can assign role to a user', function(){
    $admin = createUserAdmin();
    $user = createUser();
    $role = Role::factory()->createOne();

    $response = $this->actingAs($admin)
        ->post(route('admin.user.role.store', $user->username), [
            'roles' => [['id' => $role->id, 'slug' => $role->slug, 'is_checked' => true]]
        ]);
    $user->refresh();
    $user = $user->with('roles')->find($user->id);
    
    $this->assertTrue($user->roles->contains('slug', $role->slug));    
    $response->assertSessionHasNoErrors()
        ->assertRedirect('/admin/user');
});

test('user can assign permission to a user', function(){
    $admin = createUserAdmin();
    $user = createUser();
    $permissions = Permission::factory(3)->create()->map(function($permission){
        return ['id' => $permission->id, 'slug' => $permission->slug, 'is_checked' => true];
    });

    $response = $this->actingAs($admin)
        ->post(route('admin.user.permission.store', $user->username), [
            'permissions' => $permissions->toArray()
        ]);
    $permission = Permission::where('slug', $permissions[0]['slug'])->first();

    $this->assertTrue($user->hasPermissionTo($permission));
    $response->assertSessionHasNoErrors()
        ->assertRedirect('/admin/user');
});

test('user can update a user\'s password', function(){
    $admin = createUserAdmin();
    $user = createUser();
    $new_password = 'new_password';

    $response = $this->actingAs($admin)
        ->patch(route('admin.user.password.update', $user->username), [
            'password' => $new_password,
            'password_confirmation' => $new_password
        ]);
    $user->refresh();

    $response->assertSessionHasNoErrors()
        ->assertRedirect('/admin/user');
    $this->assertTrue(Hash::check($new_password, $user->password));
});
