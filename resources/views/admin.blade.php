<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Innova.Web Admin</title>
        @if (file_exists(public_path('build/manifest.json')) ||
        file_exists(public_path('hot'))) @vite(['resources/css/app.css',
        'resources/js/app.js']) @endif
    </head>
    <body>
        <div class="admin-shell">
            <aside class="sidebar">
                <a class="brand" href="#"
                    ><span class="brand-mark">I</span><span>Innova.Web</span></a
                >
                <div class="workspace-switcher">
                    <span class="avatar avatar-mint">AM</span
                    ><span
                        ><strong>Admin utama</strong
                        ><small>Workspace platform</small></span
                    ><span class="chevron">⌄</span>
                </div>
                <nav class="side-nav" aria-label="Navigasi admin">
                    <p class="nav-label">Workspace</p>
                    <a
                        class="nav-item active"
                        href="#overview"
                        data-page="overview"
                        ><span class="nav-icon">◈</span> Home</a
                    >
                    <a
                        class="nav-item"
                        href="#templates-page"
                        data-page="templates-page"
                        ><span class="nav-icon">◇</span> Template</a
                    >
                    <a
                        class="nav-item"
                        href="#analytics-page"
                        data-page="analytics-page"
                        ><span class="nav-icon">▥</span> Analytics</a
                    >
                    <p class="nav-label nav-label-spaced">Pengaturan</p>
                    <a
                        class="nav-item"
                        href="#settings-page"
                        data-page="settings-page"
                        ><span class="nav-icon">⚙</span> Settings</a
                    >
                    <a class="nav-item" href="#help"
                        ><span class="nav-icon">?</span> Bantuan</a
                    >
                </nav>
                <div class="sidebar-footer">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-button" type="submit">Keluar <span>→</span></button>
                    </form>
                </div>
            </aside>
            <main class="main-content">
                <div
                    class="tree-easter-egg"
                    id="tree-easter-egg"
                    aria-hidden="true"
                >
                    <span class="tree-crown"></span
                    ><span class="tree-trunk"></span><small>you found it</small>
                </div>
                <header class="topbar">
                    <div class="breadcrumb">
                        <span>Admin</span><span>/</span
                        ><strong>Ringkasan</strong>
                    </div>
                    <div class="top-actions">
                        <button class="profile-button">
                            <span class="avatar avatar-lilac">AR</span
                            ><span>{{ auth('admin')->user()->nama_admin }}</span
                            ><span class="chevron">⌄</span>
                        </button>
                    </div>
                </header>
                <div class="page-content page-view" id="overview">
                    <section class="page-heading">
                        <div>
                            <p class="eyebrow">{{ date('l, d F Y') }}</p>
                            <h1>Selamat pagi, Arman.</h1>
                            <p class="heading-copy">
                                Pantau pertumbuhan platform dan bantu fotografer
                                tampil lebih profesional.
                            </p>
                        </div>
                        <a class="button button-primary" href="{{ route('websites.create') }}">
                            <span>＋</span> Tambah website
                        </a>
                    </section>
                    <section
                        class="metric-grid"
                        aria-label="Ringkasan statistik"
                    >
                        <article class="metric-card">
                            <div class="metric-top">
                                <span class="metric-icon blue">▣</span
                                ><span class="trend up">↗ 12.5%</span>
                            </div>
                            <p>Website aktif</p>
                            <strong>{{ $totalWebsites }}</strong
                            ><small>dibanding bulan lalu</small>
                        </article>
                        <article class="metric-card">
                            <div class="metric-top">
                                <span class="metric-icon mint">✦</span
                                ><span class="trend neutral">Stabil</span>
                            </div>
                            <p>Total kunjungan</p>
                            <strong>{{ $totalVisits }}</strong
                            ><small>total kunjungan seluruh website</small>
                        </article>
                    </section>
                    <section class="panel website-table-panel">
                        <div class="panel-heading">
                            <div><h2>Website yang dibuat</h2><p>Data aktual website dari web builder.</p></div>
                            <a class="text-button" href="{{ route('websites.create') }}">Tambah website <span>→</span></a>
                        </div>
                        <div class="table-wrap"><table><thead><tr><th>Website</th><th>Template</th><th>Slug</th><th>Status</th><th>Kunjungan</th></tr></thead><tbody>
                            @forelse ($websites as $website)
                                <tr><td><div class="website-name"><span class="site-thumb thumb-slate">{{ strtoupper(substr($website->nama_website, 0, 2)) }}</span><span><strong>{{ $website->nama_website }}</strong><small>{{ $website->last_visited_at?->diffForHumans() ?? 'Belum dikunjungi' }}</small></span></div></td><td>{{ $website->template->nama_template }}</td><td><a class="site-slug" href="{{ route('websites.show', $website) }}" target="_blank">Innova.Web/{{ $website->slug }}</a></td><td><span class="status {{ $website->status === 'aktif' ? 'published' : 'draft' }}">● {{ ucfirst($website->status) }}</span></td><td><strong class="visit-number">{{ number_format($website->visit_count) }}</strong></td></tr>
                            @empty
                                <tr><td colspan="5">Belum ada website yang dibuat.</td></tr>
                            @endforelse
                        </tbody></table></div>
                    </section>
                    <div class="content-grid">
                        <section class="panel activity-panel">
                            <div class="panel-heading">
                                <div>
                                    <h2>Aktivitas terbaru</h2>
                                    <p>Yang terjadi di platform hari ini.</p>
                                </div>
                                <button
                                    class="more-button"
                                    title="Opsi aktivitas"
                                >
                                    •••
                                </button>
                            </div>
                            <div class="activity-list">
                                <div class="activity">
                                    <span class="activity-dot mint-dot">✦</span
                                    ><span
                                        ><strong>Studio Senja</strong>
                                        menerbitkan website baru<small
                                            >12 menit lalu</small
                                        ></span
                                    >
                                </div>
                                <div class="activity">
                                    <span class="activity-dot blue-dot">↗</span
                                    ><span
                                        ><strong>Admin utama</strong> memperbarui
                                        konfigurasi template<small>1 jam lalu</small></span
                                    >
                                </div>
                                <div class="activity">
                                    <span class="activity-dot peach-dot"
                                        >＋</span
                                    ><span
                                        ><strong>Admin utama</strong>
                                        menerbitkan template Editorial<small
                                            >2 jam lalu</small
                                        ></span
                                    >
                                </div>
                                <div class="activity">
                                    <span class="activity-dot lilac-dot">◎</span
                                    ><span
                                        ><strong>Admin utama</strong> mengubah
                                        pengaturan platform<small>3 jam lalu</small></span
                                    >
                                </div>
                            </div>
                            <a class="activity-link" href="#reports"
                                >Buka log aktivitas <span>→</span></a
                            >
                        </section>
                    </div>
                    <section class="template-section" id="templates">
                        <div class="panel-heading">
                            <div>
                                <h2>Template pilihan</h2>
                                <p>
                                    Template yang paling banyak dipakai minggu
                                    ini.
                                </p>
                            </div>
                            <a href="#templates" class="text-button"
                                >Kelola template <span>→</span></a
                            >
                        </div>
                        <div class="template-grid">
                            <article class="template-card">
                                <div class="template-preview editorial">
                                    <span>NOIR</span
                                    ><small>visual stories</small>
                                </div>
                                <div class="template-info">
                                    <div>
                                        <strong>Editorial</strong
                                        ><small>Dipakai 48 website</small>
                                    </div>
                                    <button class="more-button">•••</button>
                                </div>
                            </article>
                            <article class="template-card">
                                <div class="template-preview folio">
                                    <span>folio</span
                                    ><small>moments & memories</small>
                                </div>
                                <div class="template-info">
                                    <div>
                                        <strong>Folio</strong
                                        ><small>Dipakai 36 website</small>
                                    </div>
                                    <button class="more-button">•••</button>
                                </div>
                            </article>
                            <article class="template-card">
                                <div class="template-preview monument">
                                    <span>MONUMENT</span
                                    ><small>stories in frame</small>
                                </div>
                                <div class="template-info">
                                    <div>
                                        <strong>Monument</strong
                                        ><small>Dipakai 29 website</small>
                                    </div>
                                    <button class="more-button">•••</button>
                                </div>
                            </article>
                        </div>
                    </section>
                </div>
                <div
                    class="page-content page-view hidden-view"
                    id="templates-page"
                >
                    <section class="page-heading">
                        <div>
                            <p class="eyebrow">Library visual</p>
                            <h1>Template</h1>
                            <p class="heading-copy">
                                Pilih fondasi visual untuk website fotografer
                                UMKM.
                            </p>
                        </div>
                        <a class="button button-primary" href="{{ route('websites.create') }}">
                            <span>＋</span> Tambah template
                        </a>
                    </section>
                    <section class="template-grid template-grid-large">
                        <article class="template-card">
                            <div class="template-preview editorial">
                                <span>NOIR</span><small>visual stories</small>
                            </div>
                            <div class="template-info">
                                <div>
                                    <strong>Editorial</strong
                                    ><small>48 website aktif</small>
                                </div>
                                <span class="status published"
                                    >● Published</span
                                >
                            </div>
                        </article>
                        <article class="template-card">
                            <div class="template-preview folio">
                                <span>folio</span
                                ><small>moments & memories</small>
                            </div>
                            <div class="template-info">
                                <div>
                                    <strong>Folio</strong
                                    ><small>36 website aktif</small>
                                </div>
                                <span class="status published"
                                    >● Published</span
                                >
                            </div>
                        </article>
                        <article class="template-card">
                            <div class="template-preview monument">
                                <span>MONUMENT</span
                                ><small>stories in frame</small>
                            </div>
                            <div class="template-info">
                                <div>
                                    <strong>Monument</strong
                                    ><small>29 website aktif</small>
                                </div>
                                <span class="status draft">● Draft</span>
                            </div>
                        </article>
                    </section>
                </div>
                <div
                    class="page-content page-view hidden-view"
                    id="analytics-page"
                >
                    <section class="page-heading">
                        <div>
                            <p class="eyebrow">Performance overview</p>
                            <h1>Analytics</h1>
                            <p class="heading-copy">
                                Lihat performa Framefolk dalam satu pandangan.
                            </p>
                        </div>
                        <span class="date-chip">Agustus 2026⌄</span>
                    </section>
                    <section class="analytics-grid">
                        <article class="panel chart-panel analytics-websites">
                            <div class="panel-heading">
                                <div>
                                    <h2>Kunjungan per website</h2>
                                    <p>
                                        Diperbarui setiap kali website publik dibuka.
                                    </p>
                                </div>
                                <strong class="chart-value">{{ number_format($totalVisits) }} total</strong>
                            </div>
                            <div class="analytics-rows">@forelse ($websites as $website)<div class="analytics-row"><span class="site-thumb thumb-slate">{{ strtoupper(substr($website->nama_website, 0, 2)) }}</span><span><strong>{{ $website->nama_website }}</strong><small>Innova.Web/{{ $website->slug }}</small></span><b>{{ number_format($website->visit_count) }} <small>kunjungan</small></b></div>@empty<p class="empty-state">Belum ada data kunjungan.</p>@endforelse</div>
                        </article>
                        <article class="panel donut-panel"><div class="panel-heading"><div><h2>Template yang dipakai</h2><p>Persentase dari website yang dibuat.</p></div></div><div class="template-usage">@forelse ($templateUsage as $usage)<div class="usage-row"><div><span>{{ $usage['name'] }}</span><b>{{ $usage['percentage'] }}%</b></div><div class="usage-bar"><i style="width: {{ $usage['percentage'] }}%"></i></div><small>{{ $usage['count'] }} website</small></div>@empty<p class="empty-state">Belum ada template digunakan.</p>@endforelse</div></article>
                    </section>
                </div>
                <div
                    class="page-content page-view hidden-view"
                    id="settings-page"
                >
                    <section class="page-heading">
                        <div>
                            <p class="eyebrow">Workspace control</p>
                            <h1>Settings</h1>
                            <p class="heading-copy">
                                Atur identitas dan perilaku platform.
                            </p>
                        </div>
                        <button class="button button-primary">
                            Simpan perubahan
                        </button>
                    </section>
                    <section class="panel settings-panel">
                        <div class="settings-avatar">
                            <span class="avatar avatar-lilac">AM</span>
                            <div>
                                <h2>Profil admin</h2>
                                <p>Informasi yang tampil di workspace.</p>
                            </div>
                            <button class="button button-quiet">
                                Ubah foto
                            </button>
                        </div>
                        <label>Nama workspace</label
                        ><input value="Framefolk Platform" /><label
                            >Email admin</label
                        ><input value="admin@framefolk.site" /><label
                            >Subdomain platform</label
                        >
                        <div class="input-prefix">
                            <span>framefolk.site/</span><input value="admin" />
                        </div>
                    </section>
                </div>
            </main>
        </div>
        <div class="modal-backdrop" id="website-modal" aria-hidden="true">
            <div
                class="modal"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-title"
            >
                <button class="modal-close" data-close-modal aria-label="Tutup">
                    ×
                </button>
                <p class="eyebrow">Website baru</p>
                <h2 id="modal-title">Mulai karya baru</h2>
                <p class="modal-copy">
                    Buat ruang digital untuk fotografer UMKM berikutnya.
                </p>
                <form id="website-form">
                    <label for="site-name">Nama website</label
                    ><input
                        id="site-name"
                        name="site-name"
                        placeholder="Contoh: Senja Visual"
                        required
                    /><label for="site-template">Pilih template</label
                    ><select id="site-template" name="site-template">
                        <option>Editorial</option>
                        <option>Folio</option>
                        <option>Monument</option>
                    </select>
                    <div class="modal-actions">
                        <button
                            type="button"
                            class="button button-quiet"
                            data-close-modal
                        >
                            Batal</button
                        ><button type="submit" class="button button-primary">
                            Buat website <span>→</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
    </body>
</html>
