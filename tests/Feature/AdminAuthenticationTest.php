<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_admin_can_login_and_access_dashboard(): void
    {
        $admin = Admin::create(['nama_admin' => 'Admin Utama', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);

        $this->post('/login', ['email' => $admin->email, 'password' => 'password'])->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
        $this->get('/')->assertOk();
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        Admin::create(['nama_admin' => 'Admin Utama', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);

        $this->from('/login')->post('/login', ['email' => 'admin@example.com', 'password' => 'wrong'])->assertRedirect('/login')->assertSessionHasErrors('email');
        $this->assertGuest('admin');
    }

    public function test_admin_can_logout(): void
    {
        $admin = Admin::create(['nama_admin' => 'Admin Utama', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);

        $this->actingAs($admin, 'admin')->post('/logout')->assertRedirect('/login');
        $this->assertGuest('admin');
    }
}
