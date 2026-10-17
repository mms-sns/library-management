<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#101d35" />
  <title>{{ $landingPage?->seo_meta_title ?: ($library->name . ' — Quiet Study Center & Reading Room') }}</title>
  <meta name="description" content="{{ $landingPage?->seo_meta_description ?: ('Join ' . $library->name . ' for high-speed Wi-Fi, comfortable air-conditioned seating, and a distraction-free study environment.') }}" />
  <meta property="og:title" content="{{ $landingPage?->seo_meta_title ?: $library->name }}" />
  <meta property="og:description" content="{{ $landingPage?->seo_meta_description ?: ($library->name . ' — Modern study space and reading room.') }}" />
  <meta property="og:url" content="{{ url()->current() }}" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --navy: #0f1c34;
      --navy-dark: #0a1324;
      --primary: #465fff;
      --primary-hover: #3750eb;
      --ink: #17233a;
      --muted: #64748b;
      --line: #e2e8f0;
      --paper: #ffffff;
      --soft: #f8fafc;
      --green: #10b981;
      --amber: #f59e0b;
      --font: 'DM Sans', sans-serif;
      --display: 'Manrope', sans-serif;
      --radius: 16px;
      --shadow-sm: 0 4px 12px rgba(15, 28, 52, 0.04);
      --shadow-md: 0 12px 30px rgba(15, 28, 52, 0.07);
      --shadow-lg: 0 25px 60px rgba(15, 28, 52, 0.12);
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; scroll-padding-top: 86px; }
    body {
      font-family: var(--font);
      color: var(--ink);
      background: #ffffff;
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
    }
    a { color: inherit; text-decoration: none; }
    button { font: inherit; }

    .container {
      width: min(1180px, calc(100% - 40px));
      margin: 0 auto;
    }

    /* Announcement Bar */
    .announcement {
      background: var(--navy);
      color: #cbd5e1;
      padding: 10px 16px;
      text-align: center;
      font-size: 12px;
      font-weight: 500;
      letter-spacing: 0.2px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .announcement-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: var(--green);
      display: inline-block;
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
    }

    /* Admin Preview Bar */
    .preview-bar {
      background: #fef3c7;
      border-bottom: 1px solid #fde68a;
      color: #92400e;
      padding: 8px 16px;
      font-size: 12px;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }
    .preview-bar a {
      background: #b45309;
      color: #fff;
      padding: 4px 12px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 700;
    }

    /* Site Header */
    .header {
      position: sticky;
      top: 0;
      z-index: 50;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid #edf2f7;
      height: 76px;
      display: flex;
      align-items: center;
    }
    .nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
    }
    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .brand-logo {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: linear-gradient(135deg, var(--primary), #6366f1);
      color: white;
      display: grid;
      place-items: center;
      font-family: var(--display);
      font-weight: 800;
      font-size: 18px;
      box-shadow: 0 4px 14px rgba(70, 95, 255, 0.25);
    }
    .brand-info strong {
      font-family: var(--display);
      font-size: 16px;
      font-weight: 800;
      color: var(--navy);
      display: block;
      line-height: 1.2;
    }
    .brand-info small {
      font-size: 11px;
      color: var(--muted);
      display: block;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 28px;
      font-size: 13px;
      font-weight: 600;
      color: #475569;
    }
    .nav-links a:hover {
      color: var(--primary);
    }

    .nav-cta {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 18px;
      background: var(--navy);
      color: white;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      transition: all 0.2s;
      box-shadow: 0 4px 14px rgba(15, 28, 52, 0.15);
    }
    .nav-cta:hover {
      background: #1e293b;
      transform: translateY(-1px);
      color: white;
    }
    .nav-cta-whatsapp {
      background: #059669;
    }
    .nav-cta-whatsapp:hover {
      background: #047857;
    }

    /* Hero Section */
    .hero {
      position: relative;
      overflow: hidden;
      padding: 72px 0 60px;
      background: radial-gradient(ellipse at 80% 20%, rgba(70, 95, 255, 0.08) 0%, rgba(255, 255, 255, 0) 65%),
                  radial-gradient(ellipse at 15% 70%, rgba(16, 185, 129, 0.06) 0%, rgba(255, 255, 255, 0) 55%),
                  linear-gradient(180deg, #ffffff 0%, #f9fafb 100%);
      border-bottom: 1px solid #edf2f7;
    }
    .hero-grid {
      display: grid;
      grid-template-columns: 1.15fr 0.85fr;
      align-items: center;
      gap: 48px;
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #eef2ff;
      border: 1px solid #e0e7ff;
      color: var(--primary);
      padding: 6px 14px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 700;
      margin-bottom: 20px;
    }
    .hero h1 {
      font-family: var(--display);
      font-size: clamp(34px, 4.2vw, 54px);
      font-weight: 800;
      line-height: 1.15;
      letter-spacing: -1.5px;
      color: var(--navy);
      margin-bottom: 18px;
    }
    .hero h1 span {
      background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .hero p {
      font-size: 16px;
      line-height: 1.75;
      color: var(--muted);
      max-width: 540px;
      margin-bottom: 32px;
    }
    .hero-actions {
      display: flex;
      align-items: center;
      gap: 14px;
      flex-wrap: wrap;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 13px 24px;
      border-radius: 12px;
      font-size: 14px;
      font-weight: 700;
      transition: all 0.2s ease;
      cursor: pointer;
      border: 1px solid transparent;
    }
    .btn-primary {
      background: var(--navy);
      color: #fff;
      box-shadow: 0 8px 20px rgba(15, 28, 52, 0.15);
    }
    .btn-primary:hover {
      background: #1e293b;
      transform: translateY(-2px);
      box-shadow: 0 12px 25px rgba(15, 28, 52, 0.2);
    }
    .btn-whatsapp {
      background: #10b981;
      color: #ffffff;
      box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);
    }
    .btn-whatsapp:hover {
      background: #059669;
      transform: translateY(-2px);
      box-shadow: 0 12px 25px rgba(16, 185, 129, 0.25);
    }
    .btn-outline {
      background: #ffffff;
      border-color: #cbd5e1;
      color: #334155;
    }
    .btn-outline:hover {
      border-color: var(--primary);
      color: var(--primary);
      transform: translateY(-2px);
    }

    /* Hero Card / Live Seat Snapshot */
    .hero-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 20px;
      padding: 28px;
      box-shadow: var(--shadow-lg);
      position: relative;
    }
    .hero-card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid #f1f5f9;
      padding-bottom: 18px;
      margin-bottom: 20px;
    }
    .hero-card-title {
      font-family: var(--display);
      font-size: 15px;
      font-weight: 800;
      color: var(--navy);
    }
    .hero-card-title small {
      display: block;
      font-size: 11px;
      color: var(--muted);
      font-weight: 500;
      margin-top: 2px;
    }
    .live-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #ecfdf5;
      color: #065f46;
      border: 1px solid #a7f3d0;
      padding: 4px 10px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
    }

    .hero-stats {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 14px;
      margin-bottom: 20px;
    }
    .hero-stat-box {
      background: #f8fafc;
      border: 1px solid #f1f5f9;
      border-radius: 14px;
      padding: 16px;
    }
    .hero-stat-box span {
      display: block;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--muted);
      margin-bottom: 4px;
    }
    .hero-stat-box strong {
      display: block;
      font-family: var(--display);
      font-size: 24px;
      font-weight: 800;
      color: var(--navy);
    }
    .hero-stat-box small {
      font-size: 11px;
      color: var(--green);
      font-weight: 600;
    }

    .hero-perk-row {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 0;
      border-top: 1px solid #f1f5f9;
      font-size: 12px;
      color: #334155;
    }
    .hero-perk-row span:first-child {
      width: 22px;
      height: 22px;
      border-radius: 50%;
      background: #eef2ff;
      color: var(--primary);
      display: grid;
      place-items: center;
      font-size: 12px;
      font-weight: 700;
    }

    /* Section Headings */
    .section {
      padding: 80px 0;
    }
    .section-soft {
      background: var(--soft);
    }
    .section-head {
      text-align: center;
      max-width: 620px;
      margin: 0 auto 52px;
    }
    .section-eyebrow {
      display: inline-block;
      font-size: 11px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: var(--primary);
      margin-bottom: 10px;
    }
    .section-head h2 {
      font-family: var(--display);
      font-size: clamp(28px, 3.2vw, 40px);
      font-weight: 800;
      letter-spacing: -1px;
      color: var(--navy);
      line-height: 1.2;
      margin-bottom: 12px;
    }
    .section-head p {
      font-size: 15px;
      color: var(--muted);
      line-height: 1.7;
    }

    /* Amenities Grid */
    .amenities-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
    }
    .amenity-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      padding: 24px;
      transition: all 0.25s ease;
      box-shadow: var(--shadow-sm);
    }
    .amenity-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-md);
      border-color: #cbd5e1;
    }
    .amenity-icon {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      background: #eff2fe;
      color: var(--primary);
      display: grid;
      place-items: center;
      font-size: 20px;
      margin-bottom: 16px;
    }
    .amenity-card h3 {
      font-family: var(--display);
      font-size: 16px;
      font-weight: 800;
      color: var(--navy);
      margin-bottom: 8px;
    }
    .amenity-card p {
      font-size: 13px;
      color: var(--muted);
      line-height: 1.6;
    }

    /* About Section */
    .about-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 24px;
      padding: 48px;
      box-shadow: var(--shadow-md);
      display: grid;
      grid-template-columns: 1.2fr 0.8fr;
      gap: 48px;
      align-items: center;
    }
    .about-copy h3 {
      font-family: var(--display);
      font-size: 28px;
      font-weight: 800;
      color: var(--navy);
      letter-spacing: -0.5px;
      margin-bottom: 16px;
      line-height: 1.3;
    }
    .about-copy p {
      font-size: 15px;
      color: #475569;
      line-height: 1.8;
      margin-bottom: 24px;
      white-space: pre-line;
    }
    .about-highlights {
      display: grid;
      gap: 16px;
    }
    .about-highlight-item {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      background: #f8fafc;
      border: 1px solid #edf2f7;
      border-radius: 14px;
      padding: 16px;
    }
    .about-highlight-item span {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: #eff2fe;
      color: var(--primary);
      display: grid;
      place-items: center;
      font-size: 16px;
      flex-shrink: 0;
    }
    .about-highlight-item strong {
      font-size: 14px;
      color: var(--navy);
      display: block;
    }
    .about-highlight-item small {
      font-size: 12px;
      color: var(--muted);
      line-height: 1.5;
      display: block;
      margin-top: 2px;
    }

    /* Membership Plans Section */
    .plans-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
      gap: 24px;
      align-items: stretch;
    }
    .plan-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 20px;
      padding: 32px 28px;
      display: flex;
      flex-direction: column;
      position: relative;
      transition: all 0.25s ease;
      box-shadow: var(--shadow-sm);
    }
    .plan-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
      border-color: #cbd5e1;
    }
    .plan-card.featured {
      border: 2px solid var(--primary);
      background: linear-gradient(180deg, #ffffff 0%, #fcfdff 100%);
      box-shadow: 0 15px 40px rgba(70, 95, 255, 0.12);
    }
    .plan-badge {
      position: absolute;
      top: -12px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--primary);
      color: #fff;
      font-size: 11px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1px;
      padding: 4px 14px;
      border-radius: 999px;
    }
    .plan-name {
      font-family: var(--display);
      font-size: 18px;
      font-weight: 800;
      color: var(--navy);
      margin-bottom: 6px;
    }
    .plan-duration {
      font-size: 12px;
      color: var(--muted);
      margin-bottom: 20px;
      display: block;
    }
    .plan-price {
      margin-bottom: 24px;
      padding-bottom: 20px;
      border-bottom: 1px solid #f1f5f9;
    }
    .plan-price strong {
      font-family: var(--display);
      font-size: 36px;
      font-weight: 800;
      color: var(--navy);
      letter-spacing: -1px;
    }
    .plan-price span {
      font-size: 13px;
      color: var(--muted);
      font-weight: 500;
    }
    .plan-features {
      list-style: none;
      display: grid;
      gap: 12px;
      margin-bottom: 28px;
      flex: 1;
    }
    .plan-features li {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 13px;
      color: #334155;
    }
    .plan-features li span {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: #ecfdf5;
      color: var(--green);
      display: grid;
      place-items: center;
      font-size: 11px;
      font-weight: 800;
      flex-shrink: 0;
    }

    /* Schedule / Hours Card */
    .hours-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 20px;
      padding: 36px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 32px;
      box-shadow: var(--shadow-sm);
    }
    .hours-block {
      display: flex;
      align-items: flex-start;
      gap: 16px;
    }
    .hours-icon {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      background: #f8fafc;
      border: 1px solid #edf2f7;
      color: var(--primary);
      display: grid;
      place-items: center;
      font-size: 22px;
      flex-shrink: 0;
    }
    .hours-block strong {
      font-family: var(--display);
      font-size: 17px;
      font-weight: 800;
      color: var(--navy);
      display: block;
      margin-bottom: 4px;
    }
    .hours-block p {
      font-size: 14px;
      color: #475569;
      line-height: 1.6;
    }

    /* Contact Section */
    .contact-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 40px;
    }
    .contact-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      padding: 24px;
      text-align: center;
      transition: all 0.2s;
      box-shadow: var(--shadow-sm);
    }
    .contact-card:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-md);
      border-color: #cbd5e1;
    }
    .contact-card-icon {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      background: #eff2fe;
      color: var(--primary);
      display: grid;
      place-items: center;
      font-size: 22px;
      margin: 0 auto 14px;
    }
    .contact-card.whatsapp-card .contact-card-icon {
      background: #ecfdf5;
      color: var(--green);
    }
    .contact-card h4 {
      font-family: var(--display);
      font-size: 15px;
      font-weight: 800;
      color: var(--navy);
      margin-bottom: 6px;
    }
    .contact-card p {
      font-size: 13px;
      color: var(--muted);
      margin-bottom: 14px;
    }
    .contact-action {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 12px;
      font-weight: 700;
      color: var(--primary);
    }

    /* Map & Directions Banner */
    .location-banner {
      background: var(--navy);
      color: #ffffff;
      border-radius: 20px;
      padding: 40px 48px;
      display: flex;
      flex-direction: column;
      md-flex-direction: row;
      align-items: center;
      justify-content: space-between;
      gap: 24px;
      box-shadow: var(--shadow-lg);
    }
    .location-banner h3 {
      font-family: var(--display);
      font-size: 22px;
      font-weight: 800;
      color: #ffffff;
      margin-bottom: 6px;
    }
    .location-banner p {
      font-size: 14px;
      color: #cbd5e1;
      max-width: 580px;
      line-height: 1.6;
    }

    /* Footer */
    .footer {
      background: #ffffff;
      border-top: 1px solid #edf2f7;
      padding: 48px 0 32px;
      font-size: 13px;
      color: #64748b;
    }
    .footer-top {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
      margin-bottom: 28px;
      padding-bottom: 28px;
      border-bottom: 1px solid #f1f5f9;
    }
    .footer-bottom {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      font-size: 12px;
      color: #94a3b8;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .hero-grid { grid-template-columns: 1fr; gap: 32px; }
      .about-card { grid-template-columns: 1fr; padding: 32px 24px; gap: 32px; }
      .location-banner { padding: 32px 24px; text-align: center; }
      .nav-links { display: none; }
    }
    @media (max-width: 600px) {
      .hero { padding: 48px 0; }
      .hero h1 { font-size: 32px; }
      .hero-card { padding: 20px; }
      .hero-stats { grid-template-columns: 1fr; }
      .plans-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <!-- Announcement Bar -->
  @if(!empty($landingPage?->announcement))
    <div class="announcement">
      <span class="announcement-dot"></span>
      <span>{{ $landingPage->announcement }}</span>
    </div>
  @endif

  <!-- Admin Preview Warning -->
  @if($isPreview)
    <div class="preview-bar">
      <div>
        ⚠️ <strong>Preview Mode:</strong> This landing page is currently disabled and not visible to public visitors. Only you (Admin/Owner) can see this.
      </div>
      <a href="{{ route('library.landing-page.edit') }}">
        Enable in Settings →
      </a>
    </div>
  @endif

  <!-- Site Navigation Header -->
  <header class="header">
    <div class="container">
      <nav class="nav">
        <a href="#top" class="brand">
          <div class="brand-logo">
            {{ strtoupper(substr($library->name, 0, 1)) }}
          </div>
          <div class="brand-info">
            <strong>{{ $library->name }}</strong>
            <small>{{ $library->city ? $library->city . ', ' . $library->state : 'Quiet Study Center' }}</small>
          </div>
        </a>

        <div class="nav-links">
          <a href="#about">About</a>
          <a href="#facilities">Facilities</a>
          @if(!$landingPage || $landingPage->show_pricing)
            <a href="#plans">Plans &amp; Pricing</a>
          @endif
          @if(!$landingPage || $landingPage->show_timing)
            <a href="#hours">Timings</a>
          @endif
          <a href="#contact">Contact</a>
        </div>

        <div>
          @php
            $whatsappNum = preg_replace('/[^0-9]/', '', $landingPage?->whatsapp_number ?: $library->mobile);
          @endphp
          @if(!empty($whatsappNum))
            <a
              href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Hello, I am interested in joining ' . $library->name . '. Could you please share seat availability and admission details?') }}"
              target="_blank"
              class="nav-cta nav-cta-whatsapp"
            >
              <span>💬</span>
              <span>Chat on WhatsApp</span>
            </a>
          @else
            <a href="tel:{{ $landingPage?->contact_phone ?: $library->mobile }}" class="nav-cta">
              <span>📞</span>
              <span>Call Us</span>
            </a>
          @endif
        </div>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero" id="top">
    <div class="container">
      <div class="hero-grid">
        <div>
          <div class="hero-badge">
            <span>✨</span>
            <span>Premier Quiet Study Center in {{ $library->city ?: 'Your Area' }}</span>
          </div>

          <h1>
            {{ $landingPage?->hero_title ?: ('Welcome to ' . $library->name) }}
          </h1>

          <p>
            {{ $landingPage?->hero_tagline ?: 'Experience a focused, disciplined environment designed for serious competitive exam aspirants, medical & engineering students, and book lovers.' }}
          </p>

          <div class="hero-actions">
            @if(!$landingPage || $landingPage->show_pricing)
              <a href="#plans" class="btn btn-primary">
                <span>View Membership Plans</span>
                <span>↓</span>
              </a>
            @endif

            @if(!empty($whatsappNum))
              <a
                href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Hello, I would like to inquire about seat booking at ' . $library->name . '.') }}"
                target="_blank"
                class="btn btn-whatsapp"
              >
                <span>💬</span>
                <span>Inquire on WhatsApp</span>
              </a>
            @endif

            <a href="#contact" class="btn btn-outline">
              <span>Get Directions</span>
            </a>
          </div>
        </div>

        <!-- Live Snapshot Card -->
        <div>
          <div class="hero-card">
            <div class="hero-card-header">
              <div class="hero-card-title">
                Study Center Status
                <small>Live facilities snapshot</small>
              </div>
              <div class="live-badge">
                <span class="announcement-dot"></span>
                Open for Admissions
              </div>
            </div>

            <div class="hero-stats">
              @if(!$landingPage || $landingPage->show_seats_status)
                <div class="hero-stat-box">
                  <span>Available Desks</span>
                  <strong>{{ $seatStats['available'] > 0 ? $seatStats['available'] : 'Available' }}</strong>
                  <small>✓ Open for booking</small>
                </div>
              @endif

              <div class="hero-stat-box">
                <span>Daily Hours</span>
                <strong style="font-size: 18px; line-height: 1.35;">
                  {{ $library->settings->opening_time ? date('h:i A', strtotime($library->settings->opening_time)) : '06:00 AM' }} - 
                  {{ $library->settings->closing_time ? date('h:i A', strtotime($library->settings->closing_time)) : '11:00 PM' }}
                </strong>
                <small>7 Days Open</small>
              </div>
            </div>

            <div class="hero-perk-row">
              <span>✓</span>
              <div>
                <strong>Pin-Drop Silence Enforced</strong>
                <div style="font-size: 11px; color: #64748b;">Strict quiet zone rules for uninterrupted concentration</div>
              </div>
            </div>

            <div class="hero-perk-row">
              <span>✓</span>
              <div>
                <strong>High-Speed Wi-Fi &amp; Power Backup</strong>
                <div style="font-size: 11px; color: #64748b;">Continuous power and internet for online test prep</div>
              </div>
            </div>

            <div class="hero-perk-row">
              <span>✓</span>
              <div>
                <strong>Comfortable Reserved Seating</strong>
                <div style="font-size: 11px; color: #64748b;">Personal dedicated desks with individual charging points</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Facilities & Amenities Section -->
  @php
    $allAmenities = \App\Models\LibraryLandingPage::availableAmenities();
    $activeAmenities = $landingPage?->amenities ?: array_slice(array_keys($allAmenities), 0, 8);
  @endphp

  @if(count($activeAmenities) > 0)
    <section class="section section-soft" id="facilities">
      <div class="container">
        <div class="section-head">
          <span class="section-eyebrow">World-Class Facilities</span>
          <h2>Everything You Need for 10+ Hours of Focused Study</h2>
          <p>
            Designed from the ground up for maximum productivity, physical comfort, and peace of mind during your exam preparations.
          </p>
        </div>

        <div class="amenities-grid">
          @foreach($activeAmenities as $amenity)
            @php
              $meta = $allAmenities[$amenity] ?? ['icon' => 'check', 'description' => 'Premium facility designed for student comfort and success.'];
            @endphp
            <div class="amenity-card">
              <div class="amenity-icon">
                @if(str_contains(strtolower($amenity), 'wi-fi'))
                  📶
                @elseif(str_contains(strtolower($amenity), 'air conditioning') || str_contains(strtolower($amenity), 'ac'))
                  ❄️
                @elseif(str_contains(strtolower($amenity), 'chair') || str_contains(strtolower($amenity), 'seat'))
                  🪑
                @elseif(str_contains(strtolower($amenity), 'silent') || str_contains(strtolower($amenity), 'silence'))
                  🤫
                @elseif(str_contains(strtolower($amenity), 'power') || str_contains(strtolower($amenity), 'socket'))
                  ⚡
                @elseif(str_contains(strtolower($amenity), 'backup'))
                  🔋
                @elseif(str_contains(strtolower($amenity), 'water'))
                  💧
                @elseif(str_contains(strtolower($amenity), 'cctv') || str_contains(strtolower($amenity), 'security'))
                  🛡️
                @elseif(str_contains(strtolower($amenity), 'locker'))
                  🔐
                @elseif(str_contains(strtolower($amenity), 'newspaper'))
                  📰
                @elseif(str_contains(strtolower($amenity), 'discussion'))
                  👥
                @else
                  ✨
                @endif
              </div>
              <h3>{{ $amenity }}</h3>
              <p>{{ $meta['description'] }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <!-- About Study Center Section -->
  <section class="section" id="about">
    <div class="container">
      <div class="about-card">
        <div class="about-copy">
          <span class="section-eyebrow">Our Philosophy</span>
          <h3>{{ $landingPage?->about_title ?: ('Why Choose ' . $library->name . '?') }}</h3>
          <p>
            {{ $landingPage?->about_text ?: "We understand the relentless effort it takes to crack competitive examinations. That's why we have created an environment that completely eliminates household noise, unpredictable electricity, and internet distractions.

Join a community of motivated aspirants striving for civil services, medical, engineering, defense, and management exams. Here, productivity is not an accident—it's a habit." }}
          </p>

          <div>
            @if(!empty($whatsappNum))
              <a
                href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Hello, I would like to schedule a visit to ' . $library->name . '.') }}"
                target="_blank"
                class="btn btn-primary"
              >
                <span>Schedule a Free Visit →</span>
              </a>
            @endif
          </div>
        </div>

        <div class="about-highlights">
          <div class="about-highlight-item">
            <span>🎯</span>
            <div>
              <strong>Disciplined &amp; Quiet Atmosphere</strong>
              <small>Zero phone calls and whispers inside the study hall ensures uninterrupted deep focus.</small>
            </div>
          </div>

          <div class="about-highlight-item">
            <span>🛡️</span>
            <div>
              <strong>Safe, Secure &amp; Hygienic</strong>
              <small>CCTV surveillance, biometric/QR access control, and sanitised restrooms.</small>
            </div>
          </div>

          <div class="about-highlight-item">
            <span>💡</span>
            <div>
              <strong>Eye-Friendly Lighting</strong>
              <small>Flicker-free warm white lighting calibrated to prevent eye strain during long hours.</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Membership Plans & Pricing Section -->
  @if((!$landingPage || $landingPage->show_pricing) && $membershipPlans->count() > 0)
    <section class="section section-soft" id="plans">
      <div class="container">
        <div class="section-head">
          <span class="section-eyebrow">Transparent Pricing</span>
          <h2>Affordable Membership Plans for Every Study Need</h2>
          <p>
            Flexible plans designed to accommodate full-time aspirants and part-time learners alike. No hidden fees.
          </p>
        </div>

        <div class="plans-grid">
          @foreach($membershipPlans as $index => $plan)
            @php
              $isFeatured = $index === 1 || $plan->duration_days == 90 || $plan->duration_days == 180;
              $perDay = $plan->duration_days > 0 ? round($plan->price / $plan->duration_days) : 0;
            @endphp
            <div class="plan-card {{ $isFeatured ? 'featured' : '' }}">
              @if($isFeatured)
                <div class="plan-badge">Most Popular</div>
              @endif

              <h3 class="plan-name">{{ $plan->name }}</h3>
              <span class="plan-duration">
                Valid for <strong>{{ $plan->duration_days }} Days</strong> (≈ ₹{{ $perDay }}/day)
              </span>

              <div class="plan-price">
                <strong>₹{{ number_format($plan->price, 0) }}</strong>
                <span>/ {{ $plan->duration_days }} days</span>
              </div>

              <ul class="plan-features">
                <li>
                  <span>✓</span>
                  <span>Dedicated Reserved Study Desk</span>
                </li>
                <li>
                  <span>✓</span>
                  <span>Unlimited High-Speed Optical Wi-Fi</span>
                </li>
                <li>
                  <span>✓</span>
                  <span>Full Air Conditioning &amp; Power Backup</span>
                </li>
                <li>
                  <span>✓</span>
                  <span>Digital QR / RFID Attendance Card</span>
                </li>
                <li>
                  <span>✓</span>
                  <span>Free RO Filtered Drinking Water</span>
                </li>
              </ul>

              @if(!empty($whatsappNum))
                <a
                  href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Hello, I would like to book or inquire about the ' . $plan->name . ' (₹' . number_format($plan->price, 0) . ') at ' . $library->name . '.') }}"
                  target="_blank"
                  class="btn {{ $isFeatured ? 'btn-whatsapp' : 'btn-outline' }}"
                  style="width: 100%;"
                >
                  <span>Book This Plan</span>
                  <span>→</span>
                </a>
              @else
                <a
                  href="#contact"
                  class="btn {{ $isFeatured ? 'btn-primary' : 'btn-outline' }}"
                  style="width: 100%;"
                >
                  <span>Inquire at Reception</span>
                </a>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <!-- Operating Hours & Schedule Section -->
  @if(!$landingPage || $landingPage->show_timing)
    <section class="section" id="hours">
      <div class="container">
        <div class="section-head">
          <span class="section-eyebrow">Operating Hours</span>
          <h2>Always Open When You Need to Study</h2>
          <p>
            Convenient schedules allowing early risers and late-night learners to make the most of every day.
          </p>
        </div>

        <div class="hours-card">
          <div class="hours-block">
            <div class="hours-icon">⏰</div>
            <div>
              <strong>Daily Working Hours</strong>
              <p>
                From <strong>{{ $library->settings->opening_time ? date('h:i A', strtotime($library->settings->opening_time)) : '06:00 AM' }}</strong> to <strong>{{ $library->settings->closing_time ? date('h:i A', strtotime($library->settings->closing_time)) : '11:00 PM' }}</strong><br>
                Open all 7 days of the week, including Sundays and public holidays.
              </p>
            </div>
          </div>

          <div class="hours-block">
            <div class="hours-icon">📅</div>
            <div>
              <strong>Shift &amp; Flexible Slots</strong>
              <p>
                Full day, morning, evening, and night slots available. Contact the front desk for tailored shift timings that fit your schedule.
              </p>
            </div>
          </div>

          <div class="hours-block">
            <div class="hours-icon">📋</div>
            <div>
              <strong>Easy Check-In</strong>
              <p>
                Instant check-in with your digital student ID card or barcode kiosk scanner at the entrance.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif

  <!-- Contact & Directions Section -->
  <section class="section section-soft" id="contact">
    <div class="container">
      <div class="section-head">
        <span class="section-eyebrow">Get In Touch</span>
        <h2>Visit Us or Reach Out for Inquiries</h2>
        <p>
          Drop by for a campus tour, test the comfort of our seats, and choose your preferred study spot today.
        </p>
      </div>

      <div class="contact-grid">
        @if(!empty($whatsappNum))
          <div class="contact-card whatsapp-card">
            <div class="contact-card-icon">💬</div>
            <h4>WhatsApp Us</h4>
            <p>Instant answers on fees, desk availability &amp; batches</p>
            <a
              href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Hello, I would like to get more information about ' . $library->name . '.') }}"
              target="_blank"
              class="contact-action"
            >
              Start WhatsApp Chat →
            </a>
          </div>
        @endif

        @php
          $phone = $landingPage?->contact_phone ?: $library->mobile;
        @endphp
        @if(!empty($phone))
          <div class="contact-card">
            <div class="contact-card-icon">📞</div>
            <h4>Call Reception</h4>
            <p>{{ $phone }}</p>
            <a href="tel:{{ $phone }}" class="contact-action">
              Call Now →
            </a>
          </div>
        @endif

        @php
          $email = $landingPage?->contact_email ?: $library->email;
        @endphp
        @if(!empty($email))
          <div class="contact-card">
            <div class="contact-card-icon">✉️</div>
            <h4>Email Inquiries</h4>
            <p>{{ $email }}</p>
            <a href="mailto:{{ $email }}" class="contact-action">
              Send Email →
            </a>
          </div>
        @endif

        <div class="contact-card">
          <div class="contact-card-icon">📍</div>
          <h4>Our Center Location</h4>
          <p>{{ $landingPage?->address ?: ($library->address . ', ' . $library->city) }}</p>
          @if(!empty($landingPage?->google_maps_url))
            <a href="{{ $landingPage->google_maps_url }}" target="_blank" class="contact-action">
              Open Google Maps →
            </a>
          @endif
        </div>
      </div>

      <!-- Location Callout -->
      <div class="location-banner">
        <div>
          <h3>{{ $library->name }}</h3>
          <p>
            {{ $landingPage?->address ?: ($library->address ? $library->address . ', ' : '') . ($library->city ? $library->city . ', ' : '') . ($library->state ? $library->state : '') }}
          </p>
        </div>

        <div>
          @if(!empty($landingPage?->google_maps_url))
            <a href="{{ $landingPage->google_maps_url }}" target="_blank" class="btn btn-outline" style="background: rgba(255,255,255,0.12); color: #fff; border-color: rgba(255,255,255,0.25);">
              <span>Get Directions on Map 📍</span>
            </a>
          @elseif(!empty($whatsappNum))
            <a
              href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Hello, please share the Google Maps location for ' . $library->name . '.') }}"
              target="_blank"
              class="btn btn-whatsapp"
            >
              <span>Ask for Location on WhatsApp</span>
            </a>
          @endif
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-top">
        <div class="brand">
          <div class="brand-logo">
            {{ strtoupper(substr($library->name, 0, 1)) }}
          </div>
          <div class="brand-info">
            <strong>{{ $library->name }}</strong>
            <small>{{ $library->city ? $library->city . ', ' . $library->state : 'Study Center & Reading Room' }}</small>
          </div>
        </div>

        <div style="font-size: 13px; color: #64748b;">
          {{ $landingPage?->address ?: $library->address }}
        </div>
      </div>

      <div class="footer-bottom">
        <div>
          &copy; {{ date('Y') }} {{ $library->name }}. All rights reserved.
        </div>
        <div>
          Study Center OS powered by <a href="{{ url('/') }}" target="_blank" style="color: var(--primary); font-weight: 700;">StudyCenter Pro</a>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>
