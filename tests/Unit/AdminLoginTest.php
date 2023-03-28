<?php

namespace Tests\Unit;

use Tests\TestCase;

class AdminLoginTest extends TestCase {
    /** @test */
    public function login_requires_validation() {
        $response = $this->post('api/v1/admin/login');
        $response->assertStatus(422);
    }

    /** @test */
    public function admin_user_exists_or_not_by_email() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db();
        }
        $response = $this->postJson('/api/v1/admin/login', [
            'email'    => 'admin@example.com',
            'password' => '123456',
        ]);
        $response->assertStatus(400);
        $response->assertJson(errorReturn(__('not_found', ['key' => 'User']), []));
    }

    /** @test */
    public function admin_email_is_verified_or_not() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db();
        }
        $response = $this->postJson('/api/v1/admin/login', [
            'email'    => 'john@example.com',
            'password' => '123456',
        ]);
        $response->assertStatus(400);
        $response->assertJson(errorReturn(__('not_verified', ['key' => 'User email']), []));
    }

    /** @test */
    public function admin_user_password_matched_or_not() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db(1);
        }
        $response = $this->postJson('/api/v1/admin/login', [
            'email'    => 'john@example.com',
            'password' => '12346',
        ]);
        $response->assertStatus(400);
        $response->assertJson(errorReturn(__('not_matched', ['key' => 'User email or password'])));
    }

    /** @test */
    public function an_admin_can_login_with_email_and_password() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db(1);
        }
        $response = $this->postJson('/api/v1/admin/login', [
            'email'    => 'john@example.com',
            'password' => '123456',
        ]);

        $response->assertStatus(200);
        $response->assertJson(successReturn(__('Logged in successfully')));
    }
}
