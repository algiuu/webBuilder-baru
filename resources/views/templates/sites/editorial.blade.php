<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $website->nama_website }} | Innova.Web</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="site-page">
    <header class="site-header"><a class="site-logo" href="#top"><img src="{{ $website->logo ? Storage::url($website->logo) : '' }}" alt="Logo {{ $website->nama_website }}"><span>{{ $website->nama_website }}</span></a><nav><a href="#top">Home</a><a href="#gallery">Gallery</a><a href="#pricing">Pricing</a><a href="#contact">Contact</a></nav></header>
    <main id="top">
        <section class="site-hero"><div class="site-profile-photo">@if ($website->foto_pribadi)<img src="{{ Storage::url($website->foto_pribadi) }}" alt="Foto {{ $website->nama_website }}">@else<span>Foto pribadi</span>@endif</div><div class="site-intro"><p class="site-kicker">Photography portfolio</p><h1>Hi, I Am<br>{{ $website->nama_website }}</h1><p>{{ $website->bio }}</p></div></section>
        <section class="site-section" id="gallery"><h2>Gallery</h2><div class="site-gallery">@foreach ($website->galleries as $gallery)<img src="{{ Storage::url($gallery->foto) }}" alt="Foto karya {{ $website->nama_website }}">@endforeach</div></section>
        <section class="site-section" id="pricing"><h2>Pricing</h2><div class="site-pricing">@foreach ($website->produks as $product)<article><h3>{{ $product->nama_produk }}</h3><strong>Rp{{ number_format($product->harga, 0, ',', '.') }} / Proyek</strong><p>Fasilitas:</p><div>{{ $product->deskripsi_produk }}</div></article>@endforeach</div></section>
        <section class="site-section site-contact" id="contact"><h2>Contact</h2><div>@foreach ($website->contacts as $contact)<a class="contact-{{ $contact->platform }}" href="{{ str_starts_with($contact->value, 'http') ? $contact->value : '#' }}" target="_blank" rel="noreferrer">{{ ucfirst($contact->platform) }}</a>@endforeach</div></section>
    </main>
    <footer class="site-footer"><div><strong>{{ $website->nama_website }}</strong><p>{{ $website->bio }}</p></div><div><strong>Site Map</strong><a href="#top">Home</a><a href="#gallery">Gallery</a><a href="#pricing">Pricing</a><a href="#contact">Contact</a></div></footer><div class="site-copyright">© {{ date('Y') }} {{ $website->nama_website }}. All Rights Reserved.</div>
</body>
</html>
