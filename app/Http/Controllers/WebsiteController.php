<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebsiteRequest;
use App\Models\ActivityLog;
use App\Models\Template;
use App\Models\Website;
use App\Models\WebsiteContact;
use App\Models\WebsiteGallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    public function create(): View
    {
        return view('templates.editorial', ['template' => Template::where('nama_template', 'Editorial')->firstOrFail()]);
    }

    public function store(StoreWebsiteRequest $request): RedirectResponse
    {
        $admin = $request->user('admin');
        $validated = $request->validated();

        $website = DB::transaction(function () use ($request, $admin, $validated): Website {
            $website = Website::create([
                'id_admin' => $admin->id_admin,
                'id_template' => $validated['id_template'],
                'nama_website' => $validated['nama_website'],
                'bio' => $validated['bio'],
                'slug' => $validated['slug'],
                'logo' => $request->file('logo')->store('websites/logos', 'public'),
                'foto_pribadi' => $request->file('foto_pribadi')->store('websites/profiles', 'public'),
                'status' => 'draft',
            ]);

            foreach ($validated['gallery'] as $index => $photo) {
                WebsiteGallery::create(['id_website' => $website->id_website, 'foto' => $photo->store('websites/gallery', 'public'), 'urutan' => $index + 1]);
            }

            foreach ($validated['products'] as $product) {
                $website->produks()->create(['nama_produk' => $product['nama_produk'], 'harga' => $product['harga'], 'deskripsi_produk' => $product['fasilitas'], 'jumlah_produk' => 0]);
            }

            foreach (['whatsapp', 'instagram', 'pinterest'] as $platform) {
                WebsiteContact::create(['id_website' => $website->id_website, 'platform' => $platform, 'value' => $validated[$platform]]);
            }

            ActivityLog::create(['id_admin' => $admin->id_admin, 'action' => 'Membuat website '.$website->nama_website]);

            return $website;
        });

        return redirect()->route('websites.show', $website)->with('success', 'Website berhasil dibuat sebagai draft.');
    }

    public function show(Website $website): View
    {
        $website->increment('visit_count');
        $website->update(['last_visited_at' => now()]);
        $website->load(['template', 'produks', 'galleries', 'contacts']);

        return view('templates.sites.editorial', compact('website'));
    }
}
