<?php

namespace Tests\Feature\User;

use Tests\TestCase;

class UserCreateTest extends TestCase {

    /** @test */
    public function unauthenticated_test() {
        $response = $this->postJson('api/v1/admin/create');
        $response->assertStatus(401);
        $response->assertJson(errorReturn(__('Unauthenticated')));
    }

    /** @test */
    public function create_user_validation_test() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db(1);
        }
        $this->loginAsAdmin();
        $response = $this->postJson('api/v1/admin/create');
        $response->assertStatus(422);
        $response->assertJson(errorReturn(__('The first name field is required.')));
    }

    /** @test */
    public function unique_email_validation_test() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db(1);
        }
        $this->loginAsAdmin();
        $response = $this->postJson('api/v1/admin/create', [
            'first_name' => 'Admin',
            'last_name'  => 'Admin',
            'email'      => 'john@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJson(errorReturn(__('The email has already been taken.')));
    }

    /** @test */
    public function unique_phone_number_validation_test() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db(1);
        }
        $this->loginAsAdmin();
        $response = $this->postJson('api/v1/admin/create', [
            'first_name'   => 'Admin',
            'last_name'    => 'Admin',
            'email'        => 'john1@example.com',
            'phone_number' => '0000'
        ]);
        $response->assertStatus(422);
        $response->assertJson(errorReturn(__('The phone number has already been taken.')));
    }

    /** @test */
    public function password_length_check() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db(1);
        }
        $this->loginAsAdmin();
        $response = $this->postJson('api/v1/admin/create', [
            'first_name'            => 'Admin',
            'last_name'             => 'Admin',
            'email'                 => 'john1@example.com',
            'phone_number'          => '1234567890',
            'password'              => '123456',
            'confirmation_password' => '001234',
        ]);
        $response->assertStatus(422);
        $response->assertJson(errorReturn(__('The password field must be at least 8 characters.')));
    }

    /** @test */
    public function password_and_confirmed_password_matched_or_not_test() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db(1);
        }
        $this->loginAsAdmin();
        $response = $this->postJson('api/v1/admin/create', [
            'first_name'            => 'Admin',
            'last_name'             => 'Admin',
            'email'                 => 'john1@example.com',
            'phone_number'          => '1234567890',
            'password'              => '12345678',
            'confirmation_password' => '001234345',
        ]);
        $response->assertStatus(422);
        $response->assertJson(errorReturn(__('The password field confirmation does not match.')));
    }

    /** @test */
    public function create_user_test() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db(1);
        }
        $this->loginAsAdmin();
        $response = $this->postJson('api/v1/admin/create', [
            'first_name'            => 'Admin',
            'last_name'             => 'Admin',
            'email'                 => 'john1@example.com',
            'phone_number'          => '1234567890',
            'password'              => '12345678',
            'password_confirmation' => '12345678',
            'address'               => 'Khulna',
        ]);
        $response->assertStatus(201);
        $response->assertJson(successReturn(__('User created successfully.')));
    }
}
