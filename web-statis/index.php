<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Komisi Disiplin</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet" />
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --navy: #0d1b2a;
            --navy-mid: #1b2e45;
            --gold: #c9a84c;
            --gold-light: #e8c97a;
            --cream: #f5f0e8;
            --white: #ffffff;
            --gray: #8a9ab0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--navy);
            overflow-x: hidden;
        }

        /* ── NAV ── */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: var(--navy);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            height: 64px;
            border-bottom: 2px solid var(--gold);
        }

        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            color: var(--gold);
            letter-spacing: 0.05em;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--cream);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--gold);
        }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            background: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 5% 80px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 60% 40%, rgba(201, 168, 76, 0.12) 0%, transparent 70%);
        }

        .hero-badge {
            display: inline-block;
            background: var(--gold);
            color: var(--navy);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 6px 20px;
            border-radius: 2px;
            margin-bottom: 2rem;
            animation: fadeUp 0.6s ease both;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.8rem, 7vw, 5.5rem);
            font-weight: 900;
            color: var(--white);
            line-height: 1.1;
            margin-bottom: 1rem;
            animation: fadeUp 0.7s 0.1s ease both;
        }

        .hero h1 span {
            color: var(--gold);
        }

        .hero p {
            font-size: 1.05rem;
            color: var(--gray);
            max-width: 520px;
            margin: 0 auto 2.5rem;
            line-height: 1.8;
            animation: fadeUp 0.7s 0.2s ease both;
        }

        .hero-cta {
            display: inline-block;
            background: var(--gold);
            color: var(--navy);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 14px 36px;
            border-radius: 3px;
            transition: background 0.2s, transform 0.2s;
            animation: fadeUp 0.7s 0.3s ease both;
        }

        .hero-cta:hover {
            background: var(--gold-light);
            transform: translateY(-2px);
        }

        /* ── SECTION BASE ── */
        section {
            padding: 90px 5%;
        }

        .section-label {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.6rem;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1rem;
        }

        .section-desc {
            color: #556;
            font-size: 0.98rem;
            line-height: 1.8;
            max-width: 560px;
        }

        .divider {
            width: 48px;
            height: 3px;
            background: var(--gold);
            border-radius: 2px;
            margin: 1rem 0 2.5rem;
        }

        /* ── TENTANG ── */
        #tentang {
            background: var(--white);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        .tentang-img {
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        .tentang-img img {
            width: 100%;
            display: block;
            aspect-ratio: 4/3;
            object-fit: cover;
            border-radius: 4px;
        }

        .tentang-img::after {
            content: '';
            position: absolute;
            bottom: -12px;
            right: -12px;
            width: 60%;
            height: 60%;
            border: 3px solid var(--gold);
            border-radius: 4px;
            z-index: -1;
        }

        /* ── TUGAS ── */
        #tugas {
            background: var(--cream);
        }

        .tugas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-top: 0.5rem;
        }

        .tugas-card {
            background: var(--white);
            border-radius: 6px;
            padding: 2rem 1.8rem;
            border-top: 3px solid var(--gold);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .tugas-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(13, 27, 42, 0.1);
        }

        .tugas-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .tugas-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            color: var(--navy);
            margin-bottom: 0.6rem;
        }

        .tugas-card p {
            font-size: 0.88rem;
            color: #667;
            line-height: 1.7;
        }

        /* ── STRUKTUR ── */
        #struktur {
            background: var(--navy);
        }

        #struktur .section-title {
            color: var(--white);
        }

        #struktur .section-desc {
            color: var(--gray);
        }

        .struktur-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 0.5rem;
        }

        .anggota-card {
            background: var(--navy-mid);
            border-radius: 6px;
            overflow: hidden;
            text-align: center;
            transition: transform 0.2s;
        }

        .anggota-card:hover {
            transform: translateY(-4px);
        }

        .anggota-foto {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            display: block;
            background: #1e3350;
        }

        .anggota-foto-placeholder {
            width: 100%;
            aspect-ratio: 1/1;
            background: linear-gradient(135deg, #1b2e45 0%, #243d58 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .anggota-info {
            padding: 1.2rem 1rem 1.4rem;
        }

        .anggota-info h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            color: var(--white);
            margin-bottom: 0.25rem;
        }

        .anggota-info p {
            font-size: 0.8rem;
            color: var(--gold);
            font-weight: 500;
            letter-spacing: 0.05em;
        }

        /* ── KONTAK ── */
        #kontak {
            background: var(--white);
            text-align: center;
        }

        #kontak .section-label,
        #kontak .section-title,
        #kontak .section-desc {
            margin-left: auto;
            margin-right: auto;
        }

        #kontak .divider {
            margin: 1rem auto 2.5rem;
        }

        .kontak-box {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .kontak-item {
            background: var(--cream);
            border-radius: 6px;
            padding: 1.5rem 2.2rem;
            min-width: 180px;
        }

        .kontak-item .ki-icon {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .kontak-item p {
            font-size: 0.85rem;
            color: #556;
        }

        .kontak-item strong {
            display: block;
            font-size: 0.95rem;
            color: var(--navy);
            margin-top: 0.2rem;
        }

        /* ── FOOTER ── */
        footer {
            background: var(--navy);
            text-align: center;
            padding: 2rem 5%;
            font-size: 0.82rem;
            color: var(--gray);
            border-top: 2px solid var(--gold);
        }

        footer span {
            color: var(--gold);
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            #tentang {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }

            .tentang-img::after {
                display: none;
            }

            .nav-links {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- NAV -->
    <nav>
        <div class="nav-logo">KOMDIS</div>
        <ul class="nav-links">
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#tugas">Tugas</a></li>
            <li><a href="#struktur">Struktur</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>
    </nav>

    <!-- HERO -->
    <section class="hero" id="beranda">
        <div>
            <div class="hero-badge">Organisasi Kemahasiswaan</div>
            <h1>Komisi <span>Disiplin</span></h1>
            <p>Menegakkan aturan, menjaga integritas, dan memastikan ketertiban demi lingkungan yang kondusif dan
                berkeadilan.</p>
            <a href="#tentang" class="hero-cta">Pelajari Lebih Lanjut</a>
        </div>
    </section>

    <!-- TENTANG -->
    <section id="tentang">
        <div class="tentang-img">
            <!-- Menggunakan foto ilustrasi rapat/sidang -->
            <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=800&q=80" alt="Rapat Komisi Disiplin"
                onerror="this.src='https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=800&q=80'" />
        </div>
        <div>
            <div class="section-label">Tentang Kami</div>
            <h2 class="section-title">Apa Itu Komisi Disiplin?</h2>
            <div class="divider"></div>
            <p class="section-desc">
                Komisi Disiplin (Komdis) adalah lembaga internal yang bertugas mengawasi, menyelidiki, dan menindak
                pelanggaran peraturan yang dilakukan oleh anggota organisasi.
            </p>
            <br />
            <p class="section-desc">
                Kami hadir sebagai lembaga independen yang menjunjung tinggi asas keadilan, transparansi, dan
                proporsionalitas dalam setiap proses pemeriksaan.
            </p>
        </div>
    </section>

    <!-- TUGAS -->
    <section id="tugas">
        <div class="section-label">Peran &amp; Fungsi</div>
        <h2 class="section-title">Tugas Pokok Komdis</h2>
        <div class="divider"></div>
        <div class="tugas-grid">
            <div class="tugas-card">
                <div class="tugas-icon">🔍</div>
                <h3>Investigasi</h3>
                <p>Menyelidiki laporan pelanggaran kode etik dan tata tertib secara objektif dan independen.</p>
            </div>
            <div class="tugas-card">
                <div class="tugas-icon">⚖️</div>
                <h3>Persidangan</h3>
                <p>Menggelar sidang disiplin dengan memastikan hak semua pihak terpenuhi secara adil.</p>
            </div>
            <div class="tugas-card">
                <div class="tugas-icon">📋</div>
                <h3>Regulasi</h3>
                <p>Menyusun dan memperbarui peraturan disiplin yang relevan dengan kondisi organisasi.</p>
            </div>
            <div class="tugas-card">
                <div class="tugas-icon">📢</div>
                <h3>Sosialisasi</h3>
                <p>Mengedukasi anggota tentang kode etik dan sanksi agar pelanggaran dapat dicegah sejak dini.</p>
            </div>
        </div>
    </section>

    <!-- STRUKTUR -->
    <section id="struktur">
        <div class="section-label">Tim Kami</div>
        <h2 class="section-title">Struktur Pengurus</h2>
        <div class="divider"></div>
        <p class="section-desc">Komdis dijalankan oleh pengurus terpilih yang berkomitmen menjaga integritas organisasi.
        </p>
        <br /><br />
        <div class="struktur-grid">

            <div class="anggota-card">
                <div class="anggota-foto-placeholder">👤</div>
                <div class="anggota-info">
                    <h3>Nama Ketua</h3>
                    <p>Ketua Komdis</p>
                </div>
            </div>

            <div class="anggota-card">
                <div class="anggota-foto-placeholder">👤</div>
                <div class="anggota-info">
                    <h3>Nama Wakil</h3>
                    <p>Wakil Ketua</p>
                </div>
            </div>

            <div class="anggota-card">
                <div class="anggota-foto-placeholder">👤</div>
                <div class="anggota-info">
                    <h3>Nama Sekretaris</h3>
                    <p>Sekretaris</p>
                </div>
            </div>

            <div class="anggota-card">
                <div class="anggota-foto-placeholder">👤</div>
                <div class="anggota-info">
                    <h3>Nama Anggota</h3>
                    <p>Anggota</p>
                </div>
            </div>

        </div>
    </section>

    <!-- KONTAK -->
    <section id="kontak">
        <div class="section-label">Hubungi Kami</div>
        <h2 class="section-title">Kontak Komdis</h2>
        <div class="divider"></div>
        <p class="section-desc">Ada pelanggaran yang ingin dilaporkan? Atau butuh konsultasi terkait peraturan? Hubungi
            kami.</p>
        <div class="kontak-box">
            <div class="kontak-item">
                <div class="ki-icon">📧</div>
                <p>Email</p>
                <strong>komdis@organisasi.ac.id</strong>
            </div>
            <div class="kontak-item">
                <div class="ki-icon">📱</div>
                <p>WhatsApp</p>
                <strong>+62 812-3456-7890</strong>
            </div>
            <div class="kontak-item">
                <div class="ki-icon">📍</div>
                <p>Sekretariat</p>
                <strong>Gedung A, Lantai 2</strong>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>© 2025 <span>Komisi Disiplin</span> — Menegakkan Keadilan, Menjaga Integritas</p>
    </footer>

</body>

</html>