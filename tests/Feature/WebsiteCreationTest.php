<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Template;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WebsiteCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_editorial_website_with_gallery_products_and_contacts(): void
    {
        Storage::fake('public');
        $admin = Admin::create(['nama_admin' => 'Admin Utama', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);
        $template = Template::create(['nama_template' => 'Editorial', 'jumlah_template' => 48]);

        $response = $this->actingAs($admin, 'admin')->post(route('websites.store'), [
            'id_template' => $template->id_template,
            'nama_website' => 'Studio Awan',
            'slug' => 'studio-awan',
            'bio' => 'Fotografi arsitektur dan ruang.',
            'logo' => UploadedFile::fake()->image('logo.png'),
            'foto_pribadi' => UploadedFile::fake()->image('profile.png'),
            'gallery' => array_map(fn (int $index): UploadedFile => UploadedFile::fake()->image("gallery-{$index}.jpg"), range(1, 5)),
            'products' => [
                ['nama_produk' => 'Paket Portfolio', 'harga' => 3500000, 'fasilitas' => '10 foto final'],
                ['nama_produk' => 'Paket Komersial', 'harga' => 7500000, 'fasilitas' => '25 foto final'],
                ['nama_produk' => 'Paket Premium', 'harga' => 18000000, 'fasilitas' => '50 foto final'],
            ],
            'whatsapp' => '628123456789',
            'instagram' => '@studioawan',
            'pinterest' => 'pinterest.com/studioawan',
        ]);

        $website = $admin->websites()->first();

        $response->assertRedirect(route('websites.show', $website));
        $this->get(route('websites.show', $website))->assertOk()->assertSee('Studio Awan');
        $this->assertDatabaseHas('websites', ['id_website' => $website->id_website, 'visit_count' => 1]);
        $this->assertDatabaseHas('websites', ['id_website' => $website->id_website, 'nama_website' => 'Studio Awan', 'status' => 'draft']);
        $this->assertDatabaseCount('website_galleries', 5);
        $this->assertDatabaseCount('produks', 3);
        $this->assertDatabaseCount('website_contacts', 3);
        $this->assertDatabaseHas('activity_logs', ['id_admin' => $admin->id_admin]);
    }
}
