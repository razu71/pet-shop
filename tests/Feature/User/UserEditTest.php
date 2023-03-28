<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\TestCase;

class UserEditTest extends TestCase {
    /** @test */
    public function create_user_test() {
        if ($this->assertDatabaseCount('users', 0)) {
            $this->add_a_new_admin_to_db(1);
        }
        $this->loginAsAdmin();
        $this->add_a_new_user_to_db(1);
        $user = User::where('is_admin', 0)->first();
        $response = $this->putJson('api/v1/admin/user-edit/' . $user->uuid, [
            'first_name'            => 'Admin',
            'last_name'             => 'Admin',
            'email'                 => 'doe1@example.com',
            'phone_number'          => '1234567890',
            'password'              => '',
            'password_confirmation' => '',
            'address'               => 'Khulna',
            'uuid'                  => $user->uuid,
            'avatar'                => ''
        ]);
        $response->assertStatus(200);
        $response->assertJson(successReturn(__('User updated successfully.')));
    }
}
