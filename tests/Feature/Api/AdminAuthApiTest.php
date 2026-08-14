<?php

namespace Tests\Feature\Api;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_receive_token(): void
    {
        Admin::create([
            'name' => 'Nova Admin',
            'email' => 'admin@nova.test',
            'phone' => '09123456789',
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/admin/login', [
            'email' => 'admin@nova.test',
            'password' => 'password123',
            'device_name' => 'test-device',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.admin.email', 'admin@nova.test')
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'admin' => [
                        'id',
                        'name',
                        'email',
                        'phone',
                    ],
                    'token',
                    'token_type',
                ],
            ]);

        $this->assertNotEmpty(
            $response->json('data.token')
        );
    }

    public function test_admin_cannot_login_with_wrong_password(): void
    {
        Admin::create([
            'name' => 'Nova Admin',
            'email' => 'admin@nova.test',
            'phone' => '09123456789',
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/admin/login', [
            'email' => 'admin@nova.test',
            'password' => 'wrong-password',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonPath('success', false);
    }

    public function test_authenticated_admin_can_get_profile(): void
    {
        $admin = Admin::create([
            'name' => 'Nova Admin',
            'email' => 'admin@nova.test',
            'phone' => '09123456789',
            'password' => 'password123',
        ]);

        $token = $admin
            ->createToken('test-device')
            ->plainTextToken;

        $response = $this
            ->withToken($token)
            ->getJson('/api/admin/me');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath(
                'data.email',
                'admin@nova.test'
            );
    }

    public function test_unauthenticated_user_cannot_get_admin_profile(): void
    {
        $this->getJson('/api/admin/me')
            ->assertUnauthorized();
    }
public function test_admin_can_logout(): void
{
    $admin = Admin::create([
        'name' => 'Nova Admin',
        'email' => 'admin@nova.test',
        'phone' => '09123456789',
        'password' => 'password123',
    ]);

    $token = $admin
        ->createToken('test-device')
        ->plainTextToken;

    $this
        ->withToken($token)
        ->postJson('/api/admin/logout')
        ->assertOk()
        ->assertJsonPath('success', true);

    // Confirm the token was actually revoked from the database.
    $this->assertDatabaseCount('personal_access_tokens', 0);

    // Sanctum may cache the authenticated user between requests
    // inside the same feature test, so reset Laravel's auth guards.
    $this->app['auth']->forgetGuards();

    $this
        ->withToken($token)
        ->getJson('/api/admin/me')
        ->assertUnauthorized();
}
    public function test_authenticated_admin_can_register_another_admin(): void
    {
        $admin = Admin::create([
            'name' => 'Main Admin',
            'email' => 'main@nova.test',
            'phone' => '09111111111',
            'password' => 'password123',
        ]);

        $token = $admin
            ->createToken('test-device')
            ->plainTextToken;

        $response = $this
            ->withToken($token)
            ->postJson('/api/admin/register', [
                'name' => 'Second Admin',
                'email' => 'second@nova.test',
                'phone' => '09222222222',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

        $response
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath(
                'data.email',
                'second@nova.test'
            );

        $this->assertDatabaseHas('admins', [
            'email' => 'second@nova.test',
        ]);
    }
}