<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $library->name }} — Coming Soon</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --navy: #101d35;
      --primary: #465fff;
      --ink: #17233a;
      --muted: #6f7b90;
      --paper: #fff;
      --soft: #f8fafc;
      --font: 'DM Sans', sans-serif;
      --display: 'Manrope', sans-serif;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: var(--font);
      background: radial-gradient(circle at 50% 30%, #eef2ff 0%, #ffffff 80%);
      color: var(--ink);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 24px;
      text-align: center;
    }
    .card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 20px;
      padding: 48px 36px;
      max-width: 520px;
      width: 100%;
      box-shadow: 0 25px 60px rgba(16, 29, 53, 0.08);
    }
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #eff2fe;
      color: var(--primary);
      padding: 6px 14px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 20px;
    }
    h1 {
      font-family: var(--display);
      font-size: 26px;
      font-weight: 800;
      color: var(--navy);
      letter-spacing: -0.5px;
      margin-bottom: 12px;
      line-height: 1.3;
    }
    p {
      color: var(--muted);
      font-size: 14px;
      line-height: 1.6;
      margin-bottom: 28px;
    }
    .contact-box {
      background: #f8fafc;
      border: 1px solid #edf2f7;
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 24px;
      text-align: left;
    }
    .contact-row {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 13px;
      color: #334155;
      padding: 6px 0;
    }
    .contact-row span {
      font-size: 16px;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 12px 24px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      text-decoration: none;
      transition: all 0.2s;
      cursor: pointer;
    }
    .btn-primary {
      background: var(--navy);
      color: #fff;
    }
    .btn-primary:hover {
      background: #1e293b;
      transform: translateY(-1px);
    }
    .footer {
      margin-top: 24px;
      font-size: 12px;
      color: #94a3b8;
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="badge">
      <span>🚧</span> Website Under Construction
    </div>

    <h1>{{ $library->name }}</h1>
    <p>
      The official landing page for this study center is currently being prepared. Please check back soon or get in touch directly using the contact details below.
    </p>

    <div class="contact-box">
      @if($library->mobile)
        <div class="contact-row">
          <span>📞</span>
          <strong>Phone:</strong> {{ $library->mobile }}
        </div>
      @endif

      @if($library->email)
        <div class="contact-row">
          <span>✉️</span>
          <strong>Email:</strong> {{ $library->email }}
        </div>
      @endif

      @if($library->city)
        <div class="contact-row">
          <span>📍</span>
          <strong>Location:</strong> {{ $library->city }}{{ $library->state ? ', ' . $library->state : '' }}
        </div>
      @endif
    </div>

    <a href="{{ route('login') }}" class="btn btn-primary">
      Admin &amp; Staff Login →
    </a>
  </div>

  <div class="footer">
    Powered by StudyCenter Pro
  </div>
</body>
</html>
