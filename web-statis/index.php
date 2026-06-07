<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inggar — Portfolio</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <style>
        :root {
            --maroon: #6B1A1A;
            --maroon-dark: #4A0F0F;
            --maroon-light: #8B2222;
            --cream: #F0E8D8;
            --cream-dark: #E0D4BE;
            --cream-mid: #C9BAA0;
            --text-dark: #2A1A1A;
            --text-mid: #5C3D3D;
            --gold: #C9A84C;
            --white: #FDFAF5;
        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* CUSTOM CURSOR — lightweight, direct */
        * {
            cursor: none !important;
        }

        #cursor-dot {
            position: fixed;
            width: 8px;
            height: 8px;
            background: var(--maroon);
            border-radius: 50%;
            pointer-events: none;
            z-index: 99999;
            transform: translate(-50%, -50%);
            transition: width 0.2s, height 0.2s, background 0.2s;
            will-change: left, top;
        }

        #cursor-ring {
            position: fixed;
            width: 32px;
            height: 32px;
            border: 1.5px solid var(--maroon);
            border-radius: 50%;
            pointer-events: none;
            z-index: 99998;
            transform: translate(-50%, -50%);
            transition: width 0.2s ease, height 0.2s ease, border-color 0.2s, opacity 0.2s;
            opacity: 0.5;
            will-change: left, top;
        }

        #cursor-ring.hovered {
            width: 48px;
            height: 48px;
            border-color: var(--gold);
            opacity: 0.9;
        }

        #cursor-dot.hovered {
            background: var(--gold);
        }

        #cursor-dot.clicked {
            width: 5px;
            height: 5px;
        }

        #cursor-ring.clicked {
            width: 22px;
            height: 22px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--cream);
            color: var(--text-dark);
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
        }

        /* NOISE TEXTURE */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.5;
        }

        /* NAV */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 48px;
            background: rgba(240, 232, 216, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(107, 26, 26, 0.12);
        }

        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--maroon);
            letter-spacing: -0.5px;
        }

        .nav-links {
            display: flex;
            gap: 36px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-mid);
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            position: relative;
            transition: color 0.3s;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1.5px;
            background: var(--maroon);
            transition: width 0.3s;
        }

        .nav-links a:hover {
            color: var(--maroon);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-social a {
            font-size: 0.8rem;
            color: var(--maroon);
            font-weight: 600;
            text-decoration: none;
            letter-spacing: 0.5px;
            border: 1.5px solid var(--maroon);
            padding: 6px 16px;
            border-radius: 100px;
            transition: all 0.3s;
        }

        .nav-social a:hover {
            background: var(--maroon);
            color: var(--cream);
        }

        /* HERO */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 48px 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-bg-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(107, 26, 26, 0.08) 0%, transparent 70%);
        }

        .hero-bg-circle:nth-child(1) {
            width: 700px;
            height: 700px;
            top: -200px;
            right: -200px;
        }

        .hero-bg-circle:nth-child(2) {
            width: 400px;
            height: 400px;
            bottom: -100px;
            left: 10%;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--maroon);
            color: var(--cream);
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 28px;
            animation: fadeUp 0.8s ease both;
        }

        .hero-tag::before {
            content: '●';
            font-size: 0.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        .hero-name {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3.5rem, 8vw, 7.5rem);
            font-weight: 900;
            line-height: 0.9;
            color: var(--maroon-dark);
            animation: fadeUp 0.8s 0.1s ease both;
        }

        .hero-name span {
            color: var(--maroon-light);
            font-style: italic;
        }

        .hero-subtitle {
            margin-top: 24px;
            font-size: 1.1rem;
            color: var(--text-mid);
            max-width: 480px;
            line-height: 1.6;
            font-weight: 300;
            animation: fadeUp 0.8s 0.2s ease both;
        }

        .hero-meta {
            margin-top: 32px;
            display: flex;
            gap: 32px;
            animation: fadeUp 0.8s 0.3s ease both;
        }

        .hero-meta-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .hero-meta-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--cream-mid);
            font-weight: 600;
        }

        .hero-meta-value {
            font-size: 0.95rem;
            color: var(--maroon);
            font-weight: 600;
        }

        .hero-cta {
            margin-top: 48px;
            display: flex;
            gap: 16px;
            animation: fadeUp 0.8s 0.4s ease both;
        }

        .btn-primary {
            background: var(--maroon);
            color: var(--cream);
            padding: 14px 32px;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            letter-spacing: 0.3px;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 8px 24px rgba(107, 26, 26, 0.3);
        }

        .btn-primary:hover {
            background: var(--maroon-dark);
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(107, 26, 26, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: var(--maroon);
            padding: 14px 32px;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            letter-spacing: 0.3px;
            border: 2px solid var(--maroon);
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: rgba(107, 26, 26, 0.06);
            transform: translateY(-2px);
        }

        .hero-image-wrap {
            flex: 0 0 420px;
            height: 520px;
            position: relative;
            animation: fadeLeft 1s 0.3s ease both;
        }

        .hero-img-main {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 24px 80px 24px 80px;
            border: 4px solid var(--maroon);
            box-shadow: 24px 24px 0 var(--maroon-dark);
        }

        .hero-img-floating {
            position: absolute;
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid var(--cream);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            bottom: -30px;
            left: -40px;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        /* SKILLS TICKER */
        .ticker {
            background: var(--maroon);
            padding: 14px 0;
            overflow: hidden;
            position: relative;
        }

        .ticker-track {
            display: flex;
            gap: 0;
            white-space: nowrap;
            animation: ticker 20s linear infinite;
        }

        .ticker-item {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 0 32px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--cream);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .ticker-dot {
            color: var(--gold);
            font-size: 1.2rem;
        }

        @keyframes ticker {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        /* SECTIONS */
        section {
            padding: 100px 48px;
            position: relative;
        }

        .section-header {
            margin-bottom: 64px;
        }

        .section-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--maroon);
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::before {
            content: '';
            width: 32px;
            height: 2px;
            background: var(--maroon);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 900;
            color: var(--maroon-dark);
            line-height: 1.1;
        }

        .section-title em {
            font-style: italic;
            color: var(--maroon-light);
        }

        /* ABOUT */
        .about {
            background: var(--white);
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
        }

        .about-images {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .about-img-wrap {
            border-radius: 16px;
            overflow: hidden;
            aspect-ratio: 3/4;
        }

        .about-img-wrap:first-child {
            grid-column: 1;
            grid-row: 1 / 3;
            border-radius: 80px 16px 16px 16px;
        }

        .about-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s;
        }

        .about-img-wrap:hover img {
            transform: scale(1.05);
        }

        .about-text p {
            font-size: 1rem;
            line-height: 1.8;
            color: var(--text-mid);
            margin-bottom: 20px;
        }

        .about-stats {
            display: flex;
            gap: 40px;
            margin-top: 32px;
            padding-top: 32px;
            border-top: 1px solid var(--cream-dark);
        }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--maroon);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--cream-mid);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        /* SKILLS */
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 16px;
        }

        .skill-card {
            background: var(--white);
            border-radius: 20px;
            padding: 28px 20px;
            text-align: center;
            border: 2px solid transparent;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .skill-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--maroon);
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform 0.4s ease;
            z-index: 0;
        }

        .skill-card:hover::before {
            transform: scaleY(1);
        }

        .skill-card:hover {
            border-color: var(--maroon);
            transform: translateY(-4px);
        }

        .skill-icon {
            width: 40px;
            height: 40px;
            margin: 0 auto 12px;
            color: var(--maroon);
            position: relative;
            z-index: 1;
            transition: color 0.3s;
        }

        .skill-icon svg {
            width: 100%;
            height: 100%;
        }

        .skill-card:hover .skill-icon {
            color: var(--cream);
        }

        .skill-name {
            font-weight: 700;
            font-size: 0.9rem;
            position: relative;
            z-index: 1;
            transition: color 0.3s;
        }

        .skill-level {
            font-size: 0.72rem;
            color: var(--cream-mid);
            margin-top: 4px;
            position: relative;
            z-index: 1;
            transition: color 0.3s;
        }

        .skill-card:hover .skill-name,
        .skill-card:hover .skill-level {
            color: var(--cream);
        }

        /* PROJECTS */
        .projects {
            background: var(--maroon-dark);
        }

        .projects .section-label {
            color: var(--gold);
        }

        .projects .section-label::before {
            background: var(--gold);
        }

        .projects .section-title {
            color: var(--cream);
        }

        .projects .section-title em {
            color: var(--gold);
        }

        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 24px;
        }

        .project-card {
            background: rgba(240, 232, 216, 0.06);
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(240, 232, 216, 0.12);
            transition: all 0.4s;
            cursor: pointer;
        }

        .project-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            background: rgba(240, 232, 216, 0.1);
        }

        .project-thumb {
            height: 200px;
            overflow: hidden;
            position: relative;
            background: rgba(107, 26, 26, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .project-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s;
        }

        .project-card:hover .project-thumb img {
            transform: scale(1.08);
        }

        .project-emoji {
            font-size: 3rem;
        }

        .project-overlay {
            position: absolute;
            inset: 0;
            background: rgba(74, 15, 15, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .project-card:hover .project-overlay {
            opacity: 1;
        }

        .project-overlay-btn {
            background: var(--gold);
            color: var(--maroon-dark);
            padding: 10px 24px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 0.85rem;
            border: none;
        }

        .project-body {
            padding: 24px;
        }

        .project-tag {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gold);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .project-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: var(--cream);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .project-desc {
            font-size: 0.85rem;
            color: rgba(240, 232, 216, 0.65);
            line-height: 1.6;
        }

        .project-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 16px;
        }

        .stack-badge {
            background: rgba(201, 168, 76, 0.15);
            color: var(--gold);
            border: 1px solid rgba(201, 168, 76, 0.3);
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* EXPERIENCE */
        .experience {
            background: var(--cream);
        }

        .exp-timeline {
            position: relative;
            padding-left: 32px;
        }

        .exp-timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, var(--maroon), transparent);
        }

        .exp-item {
            position: relative;
            margin-bottom: 48px;
        }

        .exp-dot {
            position: absolute;
            left: -28px;
            top: 4px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--maroon);
            border: 3px solid var(--cream);
            box-shadow: 0 0 0 2px var(--maroon);
        }

        .exp-period {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--maroon);
            font-weight: 700;
            margin-bottom: 6px;
        }

        .exp-role {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--maroon-dark);
            margin-bottom: 4px;
        }

        .exp-org {
            font-size: 0.9rem;
            color: var(--text-mid);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .exp-desc {
            font-size: 0.9rem;
            color: var(--text-mid);
            line-height: 1.7;
        }

        /* CONTACT */
        .contact {
            background: var(--maroon-dark);
            text-align: center;
            padding: 120px 48px;
        }

        .contact .section-title {
            color: var(--cream);
            font-size: clamp(2.5rem, 6vw, 5rem);
            margin-bottom: 20px;
        }

        .contact .section-label {
            justify-content: center;
            color: var(--gold);
        }

        .contact .section-label::before {
            background: var(--gold);
        }

        .contact p {
            color: rgba(240, 232, 216, 0.7);
            font-size: 1rem;
            max-width: 480px;
            margin: 0 auto 40px;
            line-height: 1.7;
        }

        .contact-links {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .contact-link {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(240, 232, 216, 0.08);
            color: var(--cream);
            padding: 12px 24px;
            border-radius: 100px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid rgba(240, 232, 216, 0.15);
            transition: all 0.3s;
        }

        .contact-link:hover {
            background: var(--gold);
            color: var(--maroon-dark);
            border-color: var(--gold);
            transform: translateY(-3px);
        }

        /* FOOTER */
        footer {
            background: var(--maroon-dark);
            padding: 24px 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid rgba(240, 232, 216, 0.1);
        }

        footer p {
            color: rgba(240, 232, 216, 0.4);
            font-size: 0.8rem;
        }

        /* MODAL */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 10000;
            background: rgba(74, 15, 15, 0.92);
            backdrop-filter: blur(16px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s;
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        .modal {
            background: var(--white);
            border-radius: 32px;
            max-width: 680px;
            width: 90%;
            max-height: 85vh;
            overflow-y: auto;
            padding: 48px;
            position: relative;
            transform: scale(0.85) translateY(40px);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .modal-overlay.active .modal {
            transform: scale(1) translateY(0);
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--cream-dark);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            color: var(--maroon);
        }

        .modal-close:hover {
            background: var(--maroon);
            color: var(--cream);
            transform: rotate(90deg);
        }

        .modal-tag {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--maroon);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            color: var(--maroon-dark);
            margin-bottom: 16px;
        }

        .modal-thumb {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--cream-dark), var(--cream));
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .proj-icon {
            width: 64px;
            height: 64px;
            color: rgba(240, 232, 216, 0.75);
        }

        .modal-thumb-icon {
            width: 80px;
            height: 80px;
            color: var(--maroon);
        }

        .modal-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-thumb-emoji {
            font-size: 4rem;
        }

        .modal-desc {
            font-size: 0.95rem;
            line-height: 1.8;
            color: var(--text-mid);
            margin-bottom: 20px;
        }

        .modal-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .modal-stack .stack-badge {
            background: rgba(107, 26, 26, 0.1);
            color: var(--maroon);
            border-color: rgba(107, 26, 26, 0.2);
            font-size: 0.8rem;
            padding: 5px 14px;
        }

        /* ANIMATIONS */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeLeft {
            from {
                opacity: 0;
                transform: translateX(40px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--cream);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--maroon);
            border-radius: 100px;
        }

        @media (max-width: 900px) {
            nav {
                padding: 16px 24px;
            }

            .nav-links {
                display: none;
            }

            section {
                padding: 80px 24px;
            }

            .hero {
                padding: 100px 24px 60px;
                flex-direction: column;
                gap: 40px;
            }

            .hero-image-wrap {
                flex: 0 0 auto;
                width: 100%;
                max-width: 360px;
                height: 400px;
            }

            .about-grid {
                grid-template-columns: 1fr;
            }

            .about-images {
                height: 320px;
            }
        }
    </style>
</head>

<body>

    <!-- CUSTOM CURSOR -->
    <div id="cursor-dot"></div>
    <div id="cursor-ring"></div>

    <!-- NAV -->
    <nav>
        <div class="nav-logo">Inggar.</div>
        <ul class="nav-links">
            <li><a href="#about">Tentang</a></li>
            <li><a href="#skills">Skill</a></li>
            <li><a href="#projects">Proyek</a></li>
            <li><a href="#experience">Pengalaman</a></li>
            <li><a href="#contact">Kontak</a></li>
        </ul>
        <div class="nav-social"><a href="https://instagram.com/inggar_dipukulinn_warga" target="_blank">@inggar</a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero" id="hero">
        <div class="hero-bg-circle"></div>
        <div class="hero-bg-circle"></div>
        <div class="hero-content">
            <div class="hero-tag">Open to Opportunities ✦</div>
            <h1 class="hero-name">
                Muhammad<br>
                <span>Inggar</span><br>
                Agus Sholihin
            </h1>
            <p class="hero-subtitle">Full-stack developer & machine learning enthusiast dari Informatika Semester 6,
                membangun solusi digital yang bermakna.</p>
            <div class="hero-meta">
                <div class="hero-meta-item">
                    <span class="hero-meta-label">NIM</span>
                    <span class="hero-meta-value">2388010052</span>
                </div>
                <div class="hero-meta-item">
                    <span class="hero-meta-label">Kelas</span>
                    <span class="hero-meta-value">Informatika 6B</span>
                </div>
                <div class="hero-meta-item">
                    <span class="hero-meta-label">Status</span>
                    <span class="hero-meta-value">GenBI Awardee</span>
                </div>
            </div>
            <div class="hero-cta">
                <a href="#projects" class="btn-primary">Lihat Proyek ↓</a>
                <a href="#contact" class="btn-secondary">Hubungi Saya</a>
            </div>
        </div>
        <div class="hero-image-wrap">
            <!-- Simpan foto di folder yang sama dengan index.html, nama file: inggar1.jpg -->
            <img src="inggar1.jpeg" alt="Inggar" class="hero-img-main"
                onerror="this.style.background='linear-gradient(135deg, #8B2222, #4A0F0F)'; this.removeAttribute('src')" />
            <img src="inggar2.jpeg" alt="Inggar" class="hero-img-floating"
                onerror="this.style.background='#6B1A1A'; this.removeAttribute('src')" />
        </div>
    </section>

    <!-- TICKER -->
    <div class="ticker">
        <div class="ticker-track" id="ticker">
            <span class="ticker-item"><span class="ticker-dot">✦</span> Python</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> JavaScript</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> PHP</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> CSS</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> HTML</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> Machine Learning</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> Web Development</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> GenBI Awardee</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> Python</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> JavaScript</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> PHP</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> CSS</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> HTML</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> Machine Learning</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> Web Development</span>
            <span class="ticker-item"><span class="ticker-dot">✦</span> GenBI Awardee</span>
        </div>
    </div>

    <!-- ABOUT -->
    <section class="about" id="about">
        <div class="about-grid">
            <div class="about-images reveal">
                <div class="about-img-wrap">
                    <!-- inggar2.jpg -->
                    <img src="inggar2.jpeg" alt="Inggar 2"
                        onerror="this.parentElement.style.background='linear-gradient(135deg,#8B2222,#6B1A1A)'" />
                </div>
                <div class="about-img-wrap" style="border-radius: 16px 80px 16px 16px;">
                    <!-- inggar3.jpg -->
                    <img src="inggar3.jpeg" alt="Inggar 3"
                        onerror="this.parentElement.style.background='linear-gradient(135deg,#4A0F0F,#6B1A1A)'" />
                </div>
                <div class="about-img-wrap" style="grid-column: 2;">
                    <!-- inggar4.jpg -->
                    <img src="inggar4.jpeg" alt="Inggar 4"
                        onerror="this.parentElement.style.background='linear-gradient(135deg,#8B2222,#4A0F0F)'" />
                </div>
            </div>
            <div class="about-text reveal">
                <div class="section-header">
                    <p class="section-label">Tentang Saya</p>
                    <h2 class="section-title">Mahasiswa yang <em>suka membangun</em> hal baru</h2>
                </div>
                <p>Halo! Saya Inggar, mahasiswa Informatika semester 6 yang passionate di bidang web development dan
                    machine learning. Saya percaya bahwa teknologi bisa memberi dampak nyata bagi masyarakat.</p>
                <p>Selain kuliah, saya aktif di komunitas GenBI (penerima beasiswa Bank Indonesia) dan pernah memimpin
                    Departemen Advokasi & Kaderisasi di organisasi. Pengalaman di bidang kredit perbankan juga memberi
                    perspektif bisnis yang kuat.</p>
                <div class="about-stats">
                    <div>
                        <div class="stat-num">5+</div>
                        <div class="stat-label">Proyek Besar</div>
                    </div>
                    <div>
                        <div class="stat-num">5</div>
                        <div class="stat-label">Bahasa Pemrograman</div>
                    </div>
                    <div>
                        <div class="stat-num">3+</div>
                        <div class="stat-label">Tahun Coding</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SKILLS -->
    <section id="skills" style="background: var(--cream);">
        <div class="section-header reveal">
            <p class="section-label">Keahlian</p>
            <h2 class="section-title">Tech <em>Stack</em> & Skills</h2>
        </div>
        <div class="skills-grid reveal">
            <div class="skill-card">
                <div class="skill-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 2L2 7l10 5 10-5-10-5z" />
                        <path d="M2 17l10 5 10-5" />
                        <path d="M2 12l10 5 10-5" />
                    </svg>
                </div>
                <div class="skill-name">Python</div>
                <div class="skill-level">Advanced</div>
            </div>
            <div class="skill-card">
                <div class="skill-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="16 18 22 12 16 6" />
                        <polyline points="8 6 2 12 8 18" />
                    </svg>
                </div>
                <div class="skill-name">JavaScript</div>
                <div class="skill-level">Intermediate</div>
            </div>
            <div class="skill-card">
                <div class="skill-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83" />
                    </svg>
                </div>
                <div class="skill-name">CSS</div>
                <div class="skill-level">Advanced</div>
            </div>
            <div class="skill-card">
                <div class="skill-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M4 4h16v2L12 20 4 6V4z" />
                        <path d="M4 4l8 8 8-8" />
                    </svg>
                </div>
                <div class="skill-name">HTML</div>
                <div class="skill-level">Advanced</div>
            </div>
            <div class="skill-card">
                <div class="skill-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z" />
                        <polyline points="13 2 13 9 20 9" />
                    </svg>
                </div>
                <div class="skill-name">PHP</div>
                <div class="skill-level">Intermediate</div>
            </div>
            <div class="skill-card">
                <div class="skill-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2" />
                        <path d="M8 21h8M12 17v4" />
                        <path d="M7 8h4m-2-2v4" />
                        <path d="M13 10l2-2 2 2" />
                    </svg>
                </div>
                <div class="skill-name">Machine Learning</div>
                <div class="skill-level">Intermediate</div>
            </div>
            <div class="skill-card">
                <div class="skill-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <ellipse cx="12" cy="5" rx="9" ry="3" />
                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" />
                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" />
                    </svg>
                </div>
                <div class="skill-name">Database</div>
                <div class="skill-level">Intermediate</div>
            </div>
            <div class="skill-card">
                <div class="skill-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="18" cy="18" r="3" />
                        <circle cx="6" cy="6" r="3" />
                        <path d="M13 6h3a2 2 0 012 2v7" />
                        <path d="M11 18H8a2 2 0 01-2-2V9" />
                    </svg>
                </div>
                <div class="skill-name">Git & GitHub</div>
                <div class="skill-level">Intermediate</div>
            </div>
        </div>
    </section>

    <!-- PROJECTS -->
    <section class="projects" id="projects">
        <div class="section-header reveal">
            <p class="section-label">Portfolio</p>
            <h2 class="section-title">Proyek <em>Pilihan</em></h2>
        </div>
        <div class="projects-grid">

            <div class="project-card reveal" onclick="openModal('fruit')">
                <div class="project-thumb">
                    <img src="inggar2.jpg" alt="Segmentasi Buah" onerror="this.style.display='none'" />
                    <svg class="proj-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a9 9 0 019 9c0 5.25-4.5 9-9 11-4.5-2-9-5.75-9-11a9 9 0 019-9z" />
                        <path d="M12 2c0 0 2-3 5-2" />
                        <circle cx="9" cy="10" r="1.5" fill="currentColor" stroke="none" />
                        <circle cx="14" cy="13" r="1" fill="currentColor" stroke="none" />
                    </svg>
                    <div class="project-overlay"><button class="project-overlay-btn">Lihat Detail →</button></div>
                </div>
                <div class="project-body">
                    <div class="project-tag">Machine Learning</div>
                    <div class="project-title">Segmentasi Buah</div>
                    <div class="project-desc">Sistem deteksi dan segmentasi buah otomatis menggunakan algoritma computer
                        vision dan deep learning.</div>
                    <div class="project-stack">
                        <span class="stack-badge">Python</span>
                        <span class="stack-badge">OpenCV</span>
                        <span class="stack-badge">TensorFlow</span>
                    </div>
                </div>
            </div>

            <div class="project-card reveal" onclick="openModal('komdis')">
                <div class="project-thumb">
                    <img src="inggar3.jpg" alt="Website Komdis" onerror="this.style.display='none'" />
                    <svg class="proj-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6l9-4 9 4v6c0 5.25-3.75 9-9 10.5C6.75 21 3 17.25 3 12V6z" />
                        <path d="M9 12l2 2 4-4" />
                    </svg>
                    <div class="project-overlay"><button class="project-overlay-btn">Lihat Detail →</button></div>
                </div>
                <div class="project-body">
                    <div class="project-tag">Web Development</div>
                    <div class="project-title">Website Komisi Disiplin</div>
                    <div class="project-desc">Platform digital untuk manajemen kasus dan pelaporan komisi disiplin
                        organisasi kampus secara terintegrasi.</div>
                    <div class="project-stack">
                        <span class="stack-badge">PHP</span>
                        <span class="stack-badge">MySQL</span>
                        <span class="stack-badge">Bootstrap</span>
                    </div>
                </div>
            </div>

            <div class="project-card reveal" onclick="openModal('gameketik')">
                <div class="project-thumb">
                    <svg class="proj-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="6" width="20" height="13" rx="2" />
                        <path d="M6 10h.01M10 10h.01M14 10h.01M18 10h.01M8 13h.01M12 13h.01M16 13h.01M6 16h12" />
                    </svg>
                    <div class="project-overlay"><button class="project-overlay-btn">Lihat Detail →</button></div>
                </div>
                <div class="project-body">
                    <div class="project-tag">Game Development</div>
                    <div class="project-title">Game Ketik</div>
                    <div class="project-desc">Game interaktif berbasis typing speed dengan sistem poin, leaderboard, dan
                        berbagai level kesulitan.</div>
                    <div class="project-stack">
                        <span class="stack-badge">JavaScript</span>
                        <span class="stack-badge">HTML5</span>
                        <span class="stack-badge">CSS3</span>
                    </div>
                </div>
            </div>

            <div class="project-card reveal" onclick="openModal('webgame')">
                <div class="project-thumb">
                    <svg class="proj-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="3" />
                        <path d="M8 11v4M6 13h4" />
                        <circle cx="15" cy="12" r="1" fill="currentColor" stroke="none" />
                        <circle cx="18" cy="14" r="1" fill="currentColor" stroke="none" />
                        <path d="M12 3l2-1 2 1 1 3H9l1-3z" />
                    </svg>
                    <div class="project-overlay"><button class="project-overlay-btn">Lihat Detail →</button></div>
                </div>
                <div class="project-body">
                    <div class="project-tag">Game Web</div>
                    <div class="project-title">Game Berbasis Web</div>
                    <div class="project-desc">Game interaktif browser-based dengan grafis menarik, animasi halus, dan
                        gameplay yang seru dan engaging.</div>
                    <div class="project-stack">
                        <span class="stack-badge">JavaScript</span>
                        <span class="stack-badge">Canvas API</span>
                        <span class="stack-badge">CSS Animation</span>
                    </div>
                </div>
            </div>

            <div class="project-card reveal" onclick="openModal('more')">
                <div class="project-thumb" style="background: rgba(201,168,76,0.15);">
                    <svg class="proj-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="8" height="8" rx="1.5" />
                        <rect x="14" y="3" width="8" height="8" rx="1.5" />
                        <rect x="2" y="13" width="8" height="8" rx="1.5" />
                        <rect x="14" y="13" width="8" height="8" rx="1.5" />
                    </svg>
                    <div class="project-overlay"><button class="project-overlay-btn">Lihat Detail →</button></div>
                </div>
                <div class="project-body">
                    <div class="project-tag">& Masih Banyak Lagi</div>
                    <div class="project-title">Proyek Lainnya</div>
                    <div class="project-desc">Berbagai proyek lain yang terus dikembangkan — dari aplikasi web, tools
                        automation, hingga analisis data.</div>
                    <div class="project-stack">
                        <span class="stack-badge">Python</span>
                        <span class="stack-badge">JS</span>
                        <span class="stack-badge">PHP</span>
                        <span class="stack-badge">+lainnya</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- EXPERIENCE -->
    <section class="experience" id="experience">
        <div class="section-header reveal">
            <p class="section-label">Perjalanan</p>
            <h2 class="section-title">Organisasi & <em>Pengalaman</em></h2>
        </div>
        <div class="exp-timeline">
            <div class="exp-item reveal">
                <div class="exp-dot"></div>
                <div class="exp-period">Sekarang</div>
                <div class="exp-role">Anggota Komunitas GenBI</div>
                <div class="exp-org">Generasi Baru Indonesia — Penerima Beasiswa Bank Indonesia</div>
                <div class="exp-desc">Tergabung dalam komunitas penerima beasiswa Bank Indonesia, berkolaborasi dengan
                    mahasiswa berprestasi se-Indonesia dalam program pengembangan diri, kepemimpinan, dan kontribusi
                    sosial.</div>
            </div>
            <div class="exp-item reveal">
                <div class="exp-dot"></div>
                <div class="exp-period">Pengalaman Kerja</div>
                <div class="exp-role">Admin Kredit</div>
                <div class="exp-org">Perbankan</div>
                <div class="exp-desc">Mengelola administrasi kredit perbankan, memproses dokumen pinjaman, verifikasi
                    data nasabah, dan memastikan kepatuhan prosedur operasional standar perbankan.</div>
            </div>
            <div class="exp-item reveal">
                <div class="exp-dot"></div>
                <div class="exp-period">Organisasi Kampus</div>
                <div class="exp-role">Ketua Departemen Advokasi & Kaderisasi</div>
                <div class="exp-org">Organisasi Kemahasiswaan</div>
                <div class="exp-desc">Memimpin departemen yang bertanggung jawab atas kaderisasi anggota baru, advokasi
                    hak mahasiswa, serta pengembangan potensi dan karakter anggota organisasi.</div>
            </div>
        </div>
    </section>

    <!-- CONTACT -->
    <section class="contact" id="contact">
        <div class="section-label reveal" style="justify-content: center; color: var(--gold);">Hubungi Saya</div>
        <h2 class="section-title reveal">Mari <em>Berkolaborasi!</em></h2>
        <p class="reveal">Punya ide proyek keren atau mau diskusi seputar tech? Jangan ragu untuk reach out — gue selalu
            terbuka untuk kolaborasi!</p>
        <div class="contact-links reveal">
            <a href="https://instagram.com/inggar_dipukulinn_warga" class="contact-link" target="_blank">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="5" />
                    <circle cx="12" cy="12" r="4" />
                    <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                </svg>
                Instagram
            </a>
            <a href="mailto:inggar@email.com" class="contact-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2" />
                    <path d="M2 7l10 7 10-7" />
                </svg>
                Email
            </a>
            <a href="https://github.com" class="contact-link" target="_blank">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22" />
                </svg>
                GitHub
            </a>
            <a href="https://linkedin.com" class="contact-link" target="_blank">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z" />
                    <rect x="2" y="9" width="4" height="12" />
                    <circle cx="4" cy="4" r="2" />
                </svg>
                LinkedIn
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>© 2025 Muhammad Inggar Agus Sholihin — Informatika 6B</p>
        <p>NIM: 2388010052</p>
    </footer>

    <!-- PROJECT MODALS -->
    <div class="modal-overlay" id="modal-overlay" onclick="closeModalOutside(event)">
        <div class="modal" id="modal">
            <button class="modal-close" onclick="closeModal()">✕</button>
            <div id="modal-content"></div>
        </div>
    </div>

    <script>
        // CURSOR — lightweight, direct follow, no lag
        const dot = document.getElementById('cursor-dot');
        const ring = document.getElementById('cursor-ring');
        let rx = 0, ry = 0;

        document.addEventListener('mousemove', e => {
            const x = e.clientX, y = e.clientY;
            // dot follows instantly
            dot.style.left = x + 'px'; dot.style.top = y + 'px';
            // ring follows with very slight smooth (just 1 frame delay)
            rx += (x - rx) * 0.35; ry += (y - ry) * 0.35;
        });

        // separate RAF only for ring
        (function loopRing() {
            ring.style.left = rx + 'px'; ring.style.top = ry + 'px';
            requestAnimationFrame(loopRing);
        })();

        document.querySelectorAll('a, button, .project-card, .skill-card').forEach(el => {
            el.addEventListener('mouseenter', () => { dot.classList.add('hovered'); ring.classList.add('hovered'); });
            el.addEventListener('mouseleave', () => { dot.classList.remove('hovered'); ring.classList.remove('hovered'); });
        });
        document.addEventListener('mousedown', () => { dot.classList.add('clicked'); ring.classList.add('clicked'); });
        document.addEventListener('mouseup', () => { dot.classList.remove('clicked'); ring.classList.remove('clicked'); });

        // SCROLL REVEAL
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver(entries => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), i * 80);
                }
            });
        }, { threshold: 0.1 });
        reveals.forEach(el => observer.observe(el));

        // MODALS
        const svgIcons = {
            fruit: `<svg class="modal-thumb-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a9 9 0 019 9c0 5.25-4.5 9-9 11-4.5-2-9-5.75-9-11a9 9 0 019-9z"/><path d="M12 2c0 0 2-3 5-2"/><circle cx="9" cy="10" r="1.5" fill="currentColor" stroke="none"/><circle cx="14" cy="13" r="1" fill="currentColor" stroke="none"/></svg>`,
            komdis: `<svg class="modal-thumb-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6l9-4 9 4v6c0 5.25-3.75 9-9 10.5C6.75 21 3 17.25 3 12V6z"/><path d="M9 12l2 2 4-4"/></svg>`,
            gameketik: `<svg class="modal-thumb-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="13" rx="2"/><path d="M6 10h.01M10 10h.01M14 10h.01M18 10h.01M8 13h.01M12 13h.01M16 13h.01M6 16h12"/></svg>`,
            webgame: `<svg class="modal-thumb-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="3"/><path d="M8 11v4M6 13h4"/><circle cx="15" cy="12" r="1" fill="currentColor" stroke="none"/><circle cx="18" cy="14" r="1" fill="currentColor" stroke="none"/><path d="M12 3l2-1 2 1 1 3H9l1-3z"/></svg>`,
            more: `<svg class="modal-thumb-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="8" height="8" rx="1.5"/><rect x="14" y="3" width="8" height="8" rx="1.5"/><rect x="2" y="13" width="8" height="8" rx="1.5"/><rect x="14" y="13" width="8" height="8" rx="1.5"/></svg>`
        };

        const projects = {
            fruit: {
                tag: 'Machine Learning / Computer Vision',
                title: 'Segmentasi Buah',
                desc: 'Proyek ini mengembangkan sistem segmentasi buah otomatis menggunakan algoritma computer vision dan deep learning. Model dilatih untuk mendeteksi, mengklasifikasikan, dan mensegmentasi berbagai jenis buah dari gambar input dengan akurasi tinggi. Sistem dapat membedakan buah berdasarkan warna, bentuk, dan tekstur. Proyek ini sangat berguna untuk aplikasi pertanian presisi, quality control produk, dan sistem otomasi industri pangan.',
                stack: ['Python', 'OpenCV', 'TensorFlow/Keras', 'NumPy', 'Matplotlib', 'Jupyter Notebook']
            },
            komdis: {
                tag: 'Web Development / Full Stack',
                title: 'Website Komisi Disiplin',
                desc: 'Platform web terintegrasi untuk mendukung kinerja Komisi Disiplin kampus. Fitur meliputi: sistem pelaporan kasus online, manajemen sidang dan persidangan, database pelanggaran terstruktur, dashboard admin, sistem notifikasi otomatis, dan laporan statistik. Website ini meningkatkan transparansi dan efisiensi penanganan kasus disiplin organisasi kemahasiswaan secara signifikan.',
                stack: ['PHP', 'MySQL', 'Bootstrap 5', 'JavaScript', 'HTML5', 'CSS3', 'AJAX']
            },
            gameketik: {
                tag: 'Game Development / Web',
                title: 'Game Ketik (Typing Game)',
                desc: 'Game berbasis browser yang menguji dan melatih kecepatan mengetik pengguna. Dilengkapi dengan berbagai fitur: timer countdown, level kesulitan bertingkat (easy/medium/hard), sistem scoring dan leaderboard, statistik WPM (Words Per Minute) dan akurasi, serta mode latihan vs kompetisi. Desain UI yang menarik dengan animasi yang responsif memberikan pengalaman gaming yang menyenangkan.',
                stack: ['JavaScript (Vanilla)', 'HTML5', 'CSS3 Animation', 'LocalStorage API']
            },
            webgame: {
                tag: 'Game Development / Web',
                title: 'Game Berbasis Web',
                desc: 'Game interaktif yang dibangun murni di browser tanpa plugin tambahan. Memanfaatkan Canvas API untuk rendering grafis yang mulus dan performatif. Gameplay yang engaging dengan sistem level, power-up, musuh dengan AI sederhana, efek suara, dan animasi partikel. Game ini menunjukkan kemampuan JavaScript tingkat lanjut dalam pengembangan game browser-based.',
                stack: ['JavaScript', 'HTML5 Canvas', 'CSS Animation', 'Web Audio API', 'RequestAnimationFrame']
            },
            more: {
                tag: 'Various Projects',
                title: 'Proyek Lainnya',
                desc: 'Selain proyek-proyek utama di atas, masih banyak lagi proyek yang sedang dan telah dikerjakan — termasuk tools otomasi Python, analisis data statistik, aplikasi web CRUD, REST API development, scraping & data processing, serta eksperimen deep learning lainnya. Setiap proyek adalah kesempatan belajar yang berharga dan menambah wawasan baru di dunia teknologi.',
                stack: ['Python', 'JavaScript', 'PHP', 'MySQL', 'REST API', 'Data Analysis', 'Automation']
            }
        };

        function openModal(key) {
            const p = projects[key];
            const overlay = document.getElementById('modal-overlay');
            document.getElementById('modal-content').innerHTML = `
        <div class="modal-tag">${p.tag}</div>
        <div class="modal-title">${p.title}</div>
        <div class="modal-thumb">${svgIcons[key]}</div>
        <div class="modal-desc">${p.desc}</div>
        <div class="modal-stack">${p.stack.map(s => `<span class="stack-badge">${s}</span>`).join('')}</div>
      `;
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('modal-overlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        function closeModalOutside(e) {
            if (e.target === document.getElementById('modal-overlay')) closeModal();
        }

        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
    </script>
</body>

</html>