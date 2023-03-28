<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\TestCase;

class UserDeleteTest extends TestCase {
    /** @test */
    public function delete_user_test() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db(1);
        }
        $this->loginAsAdmin();
        $this->add_a_new_user_to_db(1);
        $user = User::where('is_admin', 0)->first();
        $response = $this->deleteJson('api/v1/admin/user-delete/' . $user->uuid);
        $response->assertStatus(200);
        $response->assertJson(successReturn(__('user deleted successfully.')));
    }
}
