<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\TestCase;

class UserListTest extends TestCase {

    /** @test */
    public function get_user_list_test() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db(1);
        }
        $this->loginAsAdmin();
        $response = $this->getJson('api/v1/admin/user-listing?page=1&limit=5');
        $response->assertStatus(200);
        $response->assertJson(successReturn(__('User retrieved successfully.')));
    }
}
