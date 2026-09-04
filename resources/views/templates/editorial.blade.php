<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Website Editorial | Innova.Web</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="builder-page">
    <main class="builder-shell">
        <header class="builder-header"><a href="{{ route('admin.dashboard') }}" class="brand"><span class="brand-mark">I</span><span>Innova.Web</span></a><div><span class="template-badge">Template Editorial</span><a href="{{ route('admin.dashboard') }}" class="text-button">Kembali ke dashboard</a></div></header>
        <section class="builder-heading"><p class="eyebrow">Website baru / Template 01</p><h1>Isi detail karya kamu.</h1><p>Lengkapi konten di bawah ini. Semua perubahan akan disimpan sebagai draft website.</p></section>
        @if ($errors->any())<div class="builder-alert">Periksa kembali field yang bertanda merah sebelum menyimpan.</div>@endif
        <form method="POST" action="{{ route('websites.store') }}" enctype="multipart/form-data" class="builder-form">
            @csrf
            <input type="hidden" name="id_template" value="{{ $template->id_template }}">
            <section class="builder-section"><div class="section-number">01</div><div class="section-content"><h2>Identitas visual</h2><p>Perkenalkan fotografer dan gaya visual utama.</p><div class="field-grid"><label class="upload-field">Logo kamu<input type="file" name="logo" accept="image/*" required><small data-file-name>Pilih file logo</small></label><label>Nama kamu<input type="text" name="nama_website" value="{{ old('nama_website') }}" placeholder="Contoh: John Doe Photography" required></label><label>Slug website<input type="text" name="slug" value="{{ old('slug') }}" placeholder="contoh: john-doe-photography" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" required><small>URL: Innova.Web/<span>slug-website</span></small></label><label class="field-wide">Deskripsi kamu<textarea name="bio" rows="4" placeholder="Ceritakan gaya fotografi dan ruang yang kamu abadikan..." required>{{ old('bio') }}</textarea></label><label class="upload-field">Foto pribadi<input type="file" name="foto_pribadi" accept="image/*" required><small data-file-name>Pilih foto profil</small></label></div></div></section>
            <section class="builder-section"><div class="section-number">02</div><div class="section-content"><h2>Galeri foto</h2><p>Pilih tepat 5 foto terbaik yang telah kamu tangkap.</p><div class="photo-grid">@for ($index = 0; $index < 5; $index++)<label class="photo-field"><span>{{ $index + 1 }}</span><input type="file" name="gallery[]" accept="image/*" required><small data-file-name>Pilih foto {{ $index + 1 }}</small></label>@endfor</div></div></section>
            <section class="builder-section"><div class="section-number">03</div><div class="section-content"><h2>Paket fotografi</h2><p>Tambahkan 3 produk atau layanan beserta harga dan fasilitas.</p><div class="product-grid">@for ($index = 0; $index < 3; $index++)<div class="product-card"><span class="product-label">Paket {{ $index + 1 }}</span><label>Nama paket<input type="text" name="products[{{ $index }}][nama_produk]" placeholder="Contoh: Paket Portfolio" required></label><label>Harga per proyek<input type="number" name="products[{{ $index }}][harga]" placeholder="3500000" min="0" required></label><label>Fasilitas<textarea name="products[{{ $index }}][fasilitas]" rows="4" placeholder="Durasi, jumlah foto, hak penggunaan..." required></textarea></label></div>@endfor</div></div></section>
            <section class="builder-section"><div class="section-number">04</div><div class="section-content"><h2>Kontak kamu</h2><p>Berikan jalur komunikasi agar calon klien mudah menghubungi.</p><div class="field-grid contact-grid"><label>WhatsApp<input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="628123456789" required></label><label>Instagram<input type="text" name="instagram" value="{{ old('instagram') }}" placeholder="@namakamu" required></label><label>Pinterest<input type="text" name="pinterest" value="{{ old('pinterest') }}" placeholder="pinterest.com/namakamu" required></label></div></div></section>
            <div class="builder-actions"><small class="upload-status" data-upload-status></small><a href="{{ route('admin.dashboard') }}" class="button button-quiet">Batal</a><button class="button button-primary" type="submit">Simpan sebagai draft <span>→</span></button></div>
        </form>
    </main>
</body>
</html>
