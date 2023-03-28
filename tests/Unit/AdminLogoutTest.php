<?php

namespace Tests\Unit;

use Tests\TestCase;

class AdminLogoutTest extends TestCase {

    /** @test */
    public function authentication_test() {
        $response = $this->getJson('api/v1/admin/logout');
        $response->assertStatus(401);
        $response->assertJson(errorReturn(__('Unauthenticated')));
    }

    /** @test */
    public function admin_logout() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db(1);
        }
        $this->loginAsAdmin();
        $response = $this->getJson('api/v1/admin/logout');
        $response->assertStatus(200);
        $response->assertJson(successReturn(__('Logged out successfully')));
    }
}
