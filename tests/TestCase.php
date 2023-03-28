<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withHeader('Accept','application/json');
        $this->withHeader('Content-Type','application/json');
    }

    public function add_a_new_admin_to_db($email_verified = 0) {
        User::create([
            'uuid'              => uuid(),
            'first_name'        => 'Mr.',
            'last_name'         => 'john',
            'is_admin'          => 1,
            'phone_number'      => '0000',
            'email'             => 'john@example.com',
            'email_verified_at' => $email_verified == 1 ? now() : NULL,
            'password'          => bcrypt(123456),
            'address'           => 'Khulna, Bangladesh',
        ]);
        $this->assertDatabaseHas('users',['email' => 'john@example.com']);
    }

    public function add_a_new_user_to_db($email_verified = 0) {
        User::create([
            'uuid'              => uuid(),
            'first_name'        => 'Mr.',
            'last_name'         => 'Doe',
            'is_admin'          => 0,
            'phone_number'      => '0000',
            'email'             => 'doe@example.com',
            'email_verified_at' => $email_verified == 1 ? now() : NULL,
            'password'          => bcrypt(123456),
            'address'           => 'Khulna, Bangladesh',
        ]);
        $this->assertDatabaseHas('users',['email' => 'doe@example.com']);
    }

    protected function loginAsAdmin()
    {
        $response = $this->postJson('/api/v1/admin/login',[
            'email'    => 'john@example.com',
            'password' => '123456',
        ]);
        $this->withHeader('Authorization', 'Bearer '.$response['data']['token']);
    }

    protected function loginAsUser()
    {
        $response = $this->postJson('/api/v1/user/login',[
            'email'    => 'doe@example.com',
            'password' => '123456',
        ]);
        $this->withHeader('Authorization', 'Bearer '.$response['data']['token']);
    }
}
