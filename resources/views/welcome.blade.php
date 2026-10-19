<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#101d35" />
  <meta name="description" content="A smarter operating system for study centers. Manage students, seats, attendance, fees, staff, and reports from one dashboard." />
  <title>{{ config('app.name', 'StudyCenter Pro') }} — One Center. One Dashboard.</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

  <style>
/* StudyCenter Pro — Ultra-attractive modern UI design system */
:root {
  --navy: #0a0f1d;
  --navy-2: #111827;
  --ink: #0f172a;
  --ink-secondary: #334155;
  --muted: #64748b;
  --muted-light: #94a3b8;
  --line: #e2e8f0;
  --line-light: rgba(226, 232, 240, 0.8);
  --paper: #ffffff;
  --soft: #f8fafc;
  --soft-indigo: #f5f7ff;
  --indigo: #4f46e5;
  --indigo-light: #6366f1;
  --indigo-glow: rgba(79, 70, 229, 0.35);
  --violet: #7c3aed;
  --violet-glow: rgba(124, 58, 237, 0.3);
  --cyan: #06b6d4;
  --cyan-glow: rgba(6, 182, 212, 0.25);
  --green: #10b981;
  --green-glow: rgba(16, 185, 129, 0.25);
  --orange: #f59e0b;
  --orange-glow: rgba(245, 158, 11, 0.25);
  --coral: #f43f5e;
  --purple: #6366f1;
  --font: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
  --display: 'Plus Jakarta Sans', 'Manrope', sans-serif;
  --shadow-sm: 0 2px 8px -1px rgba(15, 23, 42, 0.05);
  --shadow-md: 0 10px 25px -4px rgba(15, 23, 42, 0.08), 0 4px 10px -2px rgba(15, 23, 42, 0.04);
  --shadow-lg: 0 20px 50px -10px rgba(15, 23, 42, 0.12), 0 8px 20px -5px rgba(79, 70, 229, 0.08);
  --shadow-glow: 0 20px 50px -10px rgba(79, 70, 229, 0.3);
}

* { box-sizing: border-box; }
html { scroll-behavior: smooth; scroll-padding-top: 88px; }
body {
  margin: 0;
  font-family: var(--font);
  color: var(--ink);
  background: #ffffff;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  overflow-x: hidden;
}
a { color: inherit; text-decoration: none; }
button { font: inherit; }
.container { width: min(1180px, calc(100% - 48px)); margin: 0 auto; }
.section { padding: 104px 0; position: relative; }
.section-soft {
  background: radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.03) 0%, transparent 40%),
              radial-gradient(circle at 90% 80%, rgba(6, 182, 212, 0.03) 0%, transparent 40%),
              linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
  border-top: 1px solid var(--line);
  border-bottom: 1px solid var(--line);
}

/* Announcement Top Bar */
.announcement {
  min-height: 38px;
  background: linear-gradient(90deg, #0a0f1d 0%, #1e1b4b 50%, #0a0f1d 100%);
  color: #cbd5e1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  font-size: 11.5px;
  font-weight: 500;
  letter-spacing: .02em;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  position: relative;
  z-index: 60;
}
.announcement-dot, .live-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #10b981;
  display: inline-block;
  box-shadow: 0 0 10px #10b981;
  animation: radarPulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
@keyframes radarPulse {
  0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7), 0 0 8px #10b981; }
  50% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0), 0 0 12px #10b981; }
}
.announcement-separator { color: #475569; }

/* Sticky Site Header with Luxury Glassmorphism */
.site-header {
  height: 78px;
  background: rgba(255, 255, 255, 0.85);
  border-bottom: 1px solid rgba(226, 232, 240, 0.85);
  position: sticky;
  top: 0;
  z-index: 50;
  backdrop-filter: blur(18px) saturate(180%);
  -webkit-backdrop-filter: blur(18px);
  transition: all 0.3s ease;
}
.nav { height: 100%; display: flex; align-items: center; justify-content: space-between; }
.brand { display: inline-flex; align-items: center; gap: 11px; transition: transform 0.2s ease; }
.brand:hover { transform: translateY(-1px); }
.brand-mark {
  width: 38px;
  height: 38px;
  color: #0f172a;
  display: block;
  filter: drop-shadow(0 4px 10px rgba(79, 70, 229, 0.18));
  transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.brand:hover .brand-mark { transform: scale(1.05) rotate(-2deg); }
.brand-mark svg { width: 100%; height: 100%; }
.brand-name {
  font: 800 19px var(--display);
  letter-spacing: -0.6px;
  color: #0f172a;
}
.brand-name span {
  background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 800;
}
.nav-links {
  display: flex;
  align-items: center;
  gap: 32px;
  font-size: 13px;
  font-weight: 600;
  color: #475569;
}
.nav-links > a:not(.nav-cta) {
  position: relative;
  padding: 6px 0;
  transition: color 0.2s ease;
}
.nav-links > a:not(.nav-cta)::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 0;
  height: 2px;
  background: linear-gradient(90deg, #4f46e5, #06b6d4);
  border-radius: 2px;
  transition: width 0.25s ease;
}
.nav-links > a:not(.nav-cta):hover {
  color: #4f46e5;
}
.nav-links > a:not(.nav-cta):hover::after {
  width: 100%;
}
.nav-cta {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 10px 18px;
  background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  color: #ffffff;
  box-shadow: 0 4px 14px rgba(15, 23, 42, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.15);
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  font-size: 12.5px;
  font-weight: 700;
}
.nav-cta:hover {
  background: linear-gradient(135deg, #4338ca 0%, #312e81 100%);
  transform: translateY(-2px);
  box-shadow: 0 10px 25px -4px rgba(79, 70, 229, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.25);
  color: #ffffff;
}
.nav-cta span, .button span {
  font-size: 15px;
  transition: transform 0.2s ease;
}
.nav-cta:hover span, .button:hover span {
  transform: translate(3px, -2px);
}
.menu-toggle {
  display: none;
  background: transparent;
  border: 0;
  padding: 8px;
  cursor: pointer;
}
.menu-toggle span {
  width: 22px;
  height: 2px;
  background: #0f172a;
  display: block;
  margin: 5px 0;
  border-radius: 2px;
  transition: 0.2s ease;
}

/* Hero Section with Ambient Glowing Orbs & Tech Matrix */
.hero {
  padding: 84px 0 20px;
  position: relative;
  overflow: hidden;
  background-color: #ffffff;
  background-image:
    radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.08) 0%, transparent 55%),
    radial-gradient(circle at 85% 30%, rgba(6, 182, 212, 0.07) 0%, transparent 45%),
    radial-gradient(#e2e8f0 1.2px, transparent 1.2px);
  background-size: 100% 100%, 100% 100%, 34px 34px;
}
.hero-glow {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  pointer-events: none;
  opacity: 0.75;
}
.glow-one {
  width: 480px;
  height: 480px;
  right: -140px;
  top: 10px;
  background: radial-gradient(circle, rgba(99, 102, 241, 0.28) 0%, rgba(124, 58, 237, 0.15) 50%, transparent 70%);
  animation: orbFloatA 16s ease-in-out infinite alternate;
}
.glow-two {
  width: 380px;
  height: 380px;
  left: -150px;
  top: 180px;
  background: radial-gradient(circle, rgba(6, 182, 212, 0.22) 0%, rgba(16, 185, 129, 0.12) 50%, transparent 70%);
  animation: orbFloatB 18s ease-in-out infinite alternate;
}
@keyframes orbFloatA {
  0% { transform: translate(0, 0) scale(1); }
  50% { transform: translate(-30px, 40px) scale(1.1); }
  100% { transform: translate(20px, -20px) scale(0.95); }
}
@keyframes orbFloatB {
  0% { transform: translate(0, 0) scale(1); }
  50% { transform: translate(40px, -30px) scale(1.12); }
  100% { transform: translate(-25px, 25px) scale(0.92); }
}

.hero-grid {
  display: grid;
  grid-template-columns: .88fr 1.12fr;
  align-items: center;
  gap: 44px;
  position: relative;
  z-index: 1;
}
.hero-copy { padding: 0 0 38px; }

/* Eyebrows & Badges */
.eyebrow {
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 1.5px;
  color: #4f46e5;
  display: inline-flex;
  align-items: center;
  gap: 9px;
  margin-bottom: 24px;
  padding: 6px 14px;
  background: rgba(238, 242, 255, 0.85);
  border: 1px solid rgba(165, 180, 252, 0.55);
  border-radius: 999px;
  box-shadow: 0 2px 10px rgba(99, 102, 241, 0.08);
  backdrop-filter: blur(8px);
}
.eyebrow-icon {
  width: 20px;
  height: 20px;
  border-radius: 6px;
  display: grid;
  place-items: center;
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  color: #ffffff;
  font-size: 11px;
  letter-spacing: 0;
  box-shadow: 0 2px 6px rgba(79, 70, 229, 0.35);
}

.hero h1, .section-heading h2, .security-copy h2, .reports-copy h2, .cta-content h2 {
  font: 800 clamp(38px, 4.2vw, 58px)/1.12 var(--display);
  letter-spacing: -2.2px;
  margin: 0;
  color: #0f172a;
}
.hero h1 span, .section-heading h2 span, .security-copy h2 span, .reports-copy h2 span {
  background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #06b6d4 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  display: inline-block;
}
.hero-subtitle {
  font-size: 16px;
  line-height: 1.8;
  color: #475569;
  max-width: 460px;
  margin: 24px 0 30px;
}
.hero-actions { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }

/* Enhanced Modern Buttons */
.button {
  min-height: 48px;
  padding: 0 22px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  border-radius: 11px;
  font-size: 13px;
  font-weight: 700;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  border: 1px solid transparent;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.button:hover { transform: translateY(-2px); }

.button-primary {
  background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
  color: #ffffff;
  box-shadow: 0 10px 25px -4px rgba(79, 70, 229, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.25);
}
.button-primary::after {
  content: '';
  position: absolute;
  top: -50%;
  left: -60%;
  width: 50%;
  height: 200%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
  transform: rotate(25deg);
  animation: buttonShimmer 5s infinite ease-in-out;
}
@keyframes buttonShimmer {
  0%, 75% { left: -60%; }
  100% { left: 140%; }
}
.button-primary:hover {
  background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
  box-shadow: 0 14px 30px -4px rgba(79, 70, 229, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.35);
  color: #ffffff;
}
.button-quiet {
  color: #1e293b;
  background: rgba(255, 255, 255, 0.95);
  border-color: #e2e8f0;
  box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
  backdrop-filter: blur(8px);
}
.button-quiet:hover {
  border-color: #a5b4fc;
  color: #4338ca;
  background: #ffffff;
  box-shadow: 0 8px 22px rgba(99, 102, 241, 0.14);
}
.play-icon {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: #eef2ff;
  color: #4f46e5;
  display: grid;
  place-items: center;
  font-size: 9px;
  padding-left: 2px;
  transition: transform 0.2s ease, background 0.2s ease;
}
.button-quiet:hover .play-icon {
  background: #4f46e5;
  color: #ffffff;
  transform: scale(1.1);
}

.hero-proof {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-top: 36px;
  padding: 10px 14px;
  background: rgba(248, 250, 252, 0.85);
  border: 1px solid var(--line);
  border-radius: 12px;
  width: fit-content;
}
.proof-avatars { display: flex; padding-left: 3px; }
.proof-avatars span {
  width: 32px;
  height: 32px;
  margin-left: -5px;
  border: 2px solid #ffffff;
  border-radius: 50%;
  display: grid;
  place-items: center;
  background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
  color: #4338ca;
  font-size: 10px;
  font-weight: 800;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
}
.proof-avatars span:nth-child(2) {
  background: linear-gradient(135deg, #dcfce7, #a7f3d0);
  color: #065f46;
}
.proof-avatars span:nth-child(3) {
  background: linear-gradient(135deg, #fef3c7, #fde68a);
  color: #92400e;
}
.hero-proof strong, .hero-proof small { display: block; }
.hero-proof strong { font-size: 12px; color: #0f172a; font-weight: 700; }
.hero-proof small { font-size: 10.5px; color: #64748b; margin-top: 2px; }

.hero-trust {
  margin-top: 24px;
  font-size: 11px;
  font-weight: 500;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 9px;
}
.hero-trust span {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  display: grid;
  place-items: center;
  color: #059669;
  background: #d1fae5;
  font-size: 11px;
  font-weight: 800;
  box-shadow: 0 0 8px rgba(16, 185, 129, 0.3);
}

/* Dashboard Mockup Container with Perspective & Floating Badges */
.dashboard-wrap {
  position: relative;
  padding: 24px 0 48px 12px;
  min-width: 0;
}
.dashboard-orbit {
  position: absolute;
  border: 1px dashed rgba(99, 102, 241, 0.18);
  border-radius: 50%;
  pointer-events: none;
  animation: orbitRotate 45s linear infinite;
}
.orbit-a { width: 540px; height: 540px; right: -95px; top: -25px; }
.orbit-b { width: 450px; height: 450px; right: -50px; top: 20px; animation-direction: reverse; animation-duration: 35s; }
@keyframes orbitRotate {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.dashboard {
  position: relative;
  z-index: 2;
  display: grid;
  grid-template-columns: 160px minmax(0, 1fr);
  width: 100%;
  min-height: 440px;
  background: #ffffff;
  border: 1px solid rgba(226, 232, 240, 0.95);
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 35px 95px -20px rgba(15, 23, 42, 0.18), 0 0 60px -10px rgba(99, 102, 241, 0.16);
  transform: perspective(1400px) rotateY(-2.5deg) rotateX(1.5deg);
  transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.6s ease;
}
.dashboard:hover {
  transform: perspective(1400px) rotateY(-0.5deg) rotateX(0.5deg) translateY(-4px);
  box-shadow: 0 45px 110px -20px rgba(15, 23, 42, 0.22), 0 0 75px -5px rgba(99, 102, 241, 0.24);
}

.dash-sidebar {
  background: #f8fafc;
  border-right: 1px solid #eef2f6;
  padding: 19px 12px 14px;
  display: flex;
  flex-direction: column;
}
.dash-brand {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 9.5px;
  font-weight: 800;
  line-height: 1.2;
  white-space: nowrap;
  color: #0f172a;
  padding: 0 2px 25px;
}
.dash-brand small {
  display: block;
  color: #94a3b8;
  font-size: 6px;
  letter-spacing: 1px;
  margin-top: 4px;
}
.mini-logo {
  width: 27px;
  height: 27px;
  border-radius: 8px;
  display: grid;
  place-items: center;
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  color: #ffffff;
  font: 800 14px var(--display);
  box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
}
.dash-label {
  font-size: 7px;
  letter-spacing: 1.2px;
  color: #94a3b8;
  font-weight: 800;
  margin: 0 0 10px 8px;
}
.dash-link {
  font-size: 8.5px;
  font-weight: 600;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 9px;
  padding: 10px 9px;
  border-radius: 8px;
  margin-bottom: 3px;
  white-space: nowrap;
  cursor: pointer;
  transition: all 0.2s ease;
}
.dash-link:hover {
  background: #edf2f7;
  color: #4f46e5;
  transform: translateX(2px);
}
.dash-link > span { width: 12px; text-align: center; font-size: 13px; }
.dash-link.active {
  color: #4f46e5;
  background: #eef2ff;
  font-weight: 700;
  box-shadow: inset 2px 0 0 #4f46e5;
}

.dash-side-bottom {
  margin-top: auto;
  border-top: 1px solid #e2e8f0;
  padding: 13px 0 0;
  display: flex;
  align-items: center;
  gap: 7px;
}
.avatar {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  display: grid;
  place-items: center;
  background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
  color: #4338ca;
  font-size: 7.5px;
  font-weight: 800;
}
.dash-side-bottom strong, .dash-side-bottom small { display: block; font-size: 7px; white-space: nowrap; }
.dash-side-bottom strong { color: #0f172a; font-weight: 700; }
.dash-side-bottom small { font-size: 6px; color: #94a3b8; margin-top: 3px; }
.dash-side-bottom > span { margin-left: auto; color: #94a3b8; font-size: 11px; }

.dash-main { padding: 20px 18px 14px; min-width: 0; background: #ffffff; }
.dash-topbar { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
.dash-greeting { font-size: 7px; font-weight: 600; color: #64748b; }
.dash-topbar h3 { font: 800 15px var(--display); letter-spacing: -.5px; margin: 5px 0 0; color: #0f172a; }
.dash-top-actions { display: flex; align-items: center; gap: 9px; }
.dash-date {
  padding: 7px 9px;
  border: 1px solid #e2e8f0;
  border-radius: 7px;
  font-size: 7px;
  font-weight: 600;
  color: #64748b;
  white-space: nowrap;
  background: #f8fafc;
}
.bell {
  position: relative;
  width: 26px;
  height: 26px;
  border: 1px solid #e2e8f0;
  border-radius: 7px;
  display: grid;
  place-items: center;
  font-size: 13px;
  color: #64748b;
  background: #f8fafc;
}
.bell i {
  position: absolute;
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #f97316;
  right: 5px;
  top: 4px;
  box-shadow: 0 0 6px #f97316;
}

.dash-branch {
  margin: 16px 0 12px;
  padding: 8px 10px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 8px;
  font-weight: 600;
  color: #334155;
}
.dash-branch > span:nth-child(1) { margin-left: auto; }
.dash-branch .live-dot { margin-left: 7px; width: 5px; height: 5px; }
.dash-branch small { font-size: 7px; color: #94a3b8; }

.stat-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 8px; }
.stat-card {
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 11px 9px;
  min-width: 0;
  background: #ffffff;
  transition: all 0.25s ease;
}
.stat-card:hover {
  transform: translateY(-2px);
  border-color: #cbd5e1;
  box-shadow: 0 8px 20px -4px rgba(15, 23, 42, 0.08);
}
.stat-heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 2px;
  color: #64748b;
  font-size: 7.5px;
  font-weight: 600;
  white-space: nowrap;
}
.stat-icon {
  width: 20px;
  height: 20px;
  border-radius: 6px;
  display: grid;
  place-items: center;
  font-size: 11px;
  font-style: normal;
}
.purple { background: #eef2ff; color: #4f46e5; }
.blue { background: #e0f2fe; color: #0284c7; }
.green { background: #d1fae5; color: #059669; }
.orange { background: #fef3c7; color: #d97706; }
.pink { background: #fce7f3; color: #db2777; }
.amber { background: #fef3c7; color: #d97706; }
.coral { background: #ffe4e6; color: #e11d48; }
.mint { background: #d1fae5; color: #059669; }

.stat-card > strong {
  display: block;
  font: 800 18px var(--display);
  letter-spacing: -.7px;
  color: #0f172a;
  margin: 8px 0 6px;
  white-space: nowrap;
}
.stat-total { font-size: 9px; color: #94a3b8; font-weight: 500; letter-spacing: 0; }
.positive { color: #059669 !important; font-size: 7px; font-weight: 800; }
.positive span { color: #94a3b8; font-weight: 500; }
.warning { color: #d97706 !important; font-size: 7px; font-weight: 700; }
.stat-card > small { font-size: 7px; color: #94a3b8; white-space: nowrap; }

.progress {
  height: 5px;
  background: #e2e8f0;
  border-radius: 6px;
  margin: 0 0 6px;
  overflow: hidden;
}
.progress span {
  height: 100%;
  display: block;
  background: linear-gradient(90deg, #4f46e5, #06b6d4);
  border-radius: 6px;
  box-shadow: 0 0 8px rgba(79, 70, 229, 0.4);
}

.dash-content-grid {
  display: grid;
  grid-template-columns: 1.18fr .82fr;
  gap: 10px;
  margin-top: 10px;
}
.dash-panel {
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 13px 11px;
  min-width: 0;
  background: #ffffff;
}
.panel-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 6px; }
.panel-head h4 { font-size: 9.5px; font-weight: 700; margin: 0; color: #0f172a; }
.panel-head p { font-size: 7px; color: #94a3b8; margin: 4px 0 0; }
.panel-select {
  border: 1px solid #e2e8f0;
  padding: 5px 7px;
  border-radius: 6px;
  font-size: 6.5px;
  font-weight: 600;
  color: #64748b;
  white-space: nowrap;
  background: #f8fafc;
}

.chart-summary { margin: 12px 0 0; }
.chart-summary strong { display: block; font: 800 15px var(--display); color: #0f172a; }
.chart-summary .positive { margin-left: 7px; }
.chart-summary small { font-size: 7px; color: #94a3b8; }

.chart { display: flex; margin-top: 9px; height: 110px; }
.chart-y {
  width: 24px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding-bottom: 15px;
  color: #94a3b8;
  font-size: 6px;
  font-weight: 600;
}
.chart-area { position: relative; flex: 1; min-width: 0; }
.grid-line { position: absolute; left: 0; right: 0; border-top: 1px dashed #e2e8f0; }
.line1 { top: 0; }
.line2 { top: 27px; }
.line3 { top: 54px; }
.line4 { top: 81px; }
.chart-area svg {
  position: absolute;
  width: 100%;
  height: 87px;
  top: 0;
  left: 0;
  overflow: visible;
  filter: drop-shadow(0 4px 10px rgba(79, 70, 229, 0.4));
}
.chart-x {
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  display: flex;
  justify-content: space-between;
  font-size: 6.5px;
  font-weight: 600;
  color: #94a3b8;
}

.action-count {
  width: 18px;
  height: 18px;
  border-radius: 6px;
  background: #fef2f2;
  color: #ef4444;
  display: grid;
  place-items: center;
  font-size: 8px;
  font-weight: 800;
}
.action-row {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 12px;
  padding: 6px 4px;
  border-radius: 7px;
  transition: background 0.2s ease;
}
.action-row:hover { background: #f8fafc; }
.action-ico {
  width: 24px;
  height: 24px;
  flex: 0 0 24px;
  border-radius: 7px;
  display: grid;
  place-items: center;
  font-size: 11px;
}
.action-row > div { min-width: 0; flex: 1; }
.action-row strong, .action-row small { display: block; white-space: nowrap; }
.action-row strong { font-size: 7.5px; color: #1e293b; font-weight: 700; }
.action-row small { font-size: 6.5px; color: #94a3b8; margin-top: 3px; }
.action-arrow { color: #94a3b8; font-size: 12px; transition: transform 0.2s ease; }
.action-row:hover .action-arrow { transform: translateX(3px); color: #4f46e5; }
.view-all {
  display: flex;
  justify-content: space-between;
  border-top: 1px solid #eef2f6;
  padding-top: 10px;
  margin-top: 12px;
  font-size: 7.5px;
  color: #4f46e5;
  font-weight: 800;
}
.view-all:hover { color: #4338ca; }
.dash-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 6.5px;
  color: #94a3b8;
  margin-top: 10px;
}
.dash-footer .live-dot { width: 5px; height: 5px; margin-right: 4px; }

/* Floating Elements with Levitating Animation */
.floating-card {
  position: absolute;
  z-index: 3;
  background: rgba(255, 255, 255, 0.95);
  border: 1px solid rgba(255, 255, 255, 0.9);
  border-radius: 14px;
  box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.16), 0 0 30px rgba(79, 70, 229, 0.12);
  display: flex;
  align-items: center;
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
}
.qr-float {
  left: -20px;
  bottom: 24px;
  padding: 12px 14px;
  gap: 11px;
  animation: floatCardA 6s ease-in-out infinite alternate;
}
.seat-float {
  right: -18px;
  top: 40%;
  padding: 13px 14px;
  gap: 10px;
  animation: floatCardB 7s ease-in-out infinite alternate;
}
@keyframes floatCardA {
  0% { transform: translateY(0px) rotate(0deg); }
  100% { transform: translateY(-10px) rotate(1.2deg); }
}
@keyframes floatCardB {
  0% { transform: translateY(0px) rotate(0deg); }
  100% { transform: translateY(-9px) rotate(-1.5deg); }
}

.qr-mini {
  width: 36px;
  height: 36px;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-template-rows: repeat(3, 1fr);
  gap: 2px;
  padding: 3px;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  background: #f8fafc;
}
.qr-mini span { background: #0f172a; border-radius: 1px; }
.qr-mini span:nth-child(2), .qr-mini span:nth-child(4), .qr-mini span:nth-child(6) {
  background: #ffffff;
  border: 1px solid #0f172a;
}
.qr-mini i { grid-column: 3; grid-row: 3; background: #4f46e5; border-radius: 1px; }
.qr-float strong, .qr-float small { display: block; white-space: nowrap; }
.qr-float strong { font-size: 11px; font-weight: 800; color: #0f172a; }
.qr-float small { font-size: 8.5px; color: #64748b; margin-top: 3px; }
.qr-float > b {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: #d1fae5;
  color: #059669;
  display: grid;
  place-items: center;
  font-size: 11px;
  margin-left: 4px;
  box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
}

.seat-float-icon {
  width: 32px;
  height: 32px;
  border-radius: 9px;
  background: linear-gradient(135deg, #eef2ff, #e0e7ff);
  color: #4f46e5;
  display: grid;
  place-items: center;
  font-size: 18px;
}
.seat-float small, .seat-float strong { display: block; }
.seat-float small { font-size: 8.5px; color: #64748b; }
.seat-float strong { font: 800 16px var(--display); margin-top: 2px; color: #0f172a; }
.seat-float em { font: 700 9px var(--font); color: #059669; font-style: normal; }
.tiny-bars { height: 28px; display: flex; align-items: flex-end; gap: 3px; margin-left: 6px; }
.tiny-bars i {
  width: 4px;
  border-radius: 3px 3px 0 0;
  background: #c7d2fe;
  height: 35%;
  animation: barDance 1.8s ease-in-out infinite alternate;
}
.tiny-bars i:nth-child(2) { height: 55%; animation-delay: 0.2s; }
.tiny-bars i:nth-child(3) { height: 42%; animation-delay: 0.4s; }
.tiny-bars i:nth-child(4) { height: 78%; background: #4f46e5; animation-delay: 0.6s; }
.tiny-bars i:nth-child(5) { height: 62%; animation-delay: 0.3s; }
.tiny-bars i:nth-child(6) { height: 90%; background: #4f46e5; animation-delay: 0.7s; }
.tiny-bars i:nth-child(7) { height: 72%; animation-delay: 0.5s; }
@keyframes barDance {
  0% { transform: scaleY(0.7); }
  100% { transform: scaleY(1.15); }
}

.hero-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-top: 1px solid var(--line);
  margin-top: 24px;
  padding: 26px 0;
  color: #64748b;
  font-size: 9.5px;
  letter-spacing: .8px;
}
.hero-bottom > span { font-weight: 800; font-size: 8.5px; letter-spacing: 1.3px; color: #334155; }
.hero-bottom > div { display: flex; gap: 16px; align-items: center; font-weight: 600; }
.hero-bottom i { font-style: normal; color: #cbd5e1; }

/* Problem Section Cards with Modern Hover Lift */
.section-heading { max-width: 650px; margin-bottom: 48px; }
.section-heading.centered { text-align: center; margin-left: auto; margin-right: auto; }
.section-heading.centered .eyebrow { justify-content: center; }
.section-heading h2, .security-copy h2, .reports-copy h2 {
  font-size: clamp(32px, 3.4vw, 46px);
  letter-spacing: -1.8px;
  line-height: 1.2;
}
.section-heading p, .security-copy > p, .reports-copy > p {
  font-size: 14px;
  line-height: 1.8;
  color: #64748b;
  margin: 18px 0 0;
  max-width: 580px;
}
.centered p { margin-left: auto; margin-right: auto; }

.problem-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
.problem-card {
  padding: 28px 25px;
  background: #ffffff;
  border: 1px solid var(--line);
  border-radius: 16px;
  box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.03);
  transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  position: relative;
  overflow: hidden;
}
.problem-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, transparent, #4f46e5, transparent);
  opacity: 0;
  transition: opacity 0.3s ease;
}
.problem-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.1), 0 0 25px -5px rgba(99, 102, 241, 0.15);
  border-color: rgba(99, 102, 241, 0.3);
}
.problem-card:hover::before { opacity: 1; }
.problem-icon {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: grid;
  place-items: center;
  font-size: 21px;
  margin-bottom: 20px;
  transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.problem-card:hover .problem-icon {
  transform: scale(1.1) rotate(4deg);
}
.problem-purple { background: #eef2ff; color: #4f46e5; }
.problem-blue { background: #e0f2fe; color: #0284c7; }
.problem-green { background: #d1fae5; color: #059669; }
.problem-orange { background: #fef3c7; color: #d97706; }
.problem-pink { background: #fce7f3; color: #db2777; }
.problem-teal { background: #ccfbf1; color: #0d9488; }
.problem-card h3 { font: 800 15px var(--display); letter-spacing: -.3px; margin: 0 0 10px; color: #0f172a; }
.problem-card p { font-size: 12px; line-height: 1.7; color: #64748b; margin: 0; max-width: 290px; }

/* Features Interactive Showcase */
.features { background: #ffffff; }
.feature-layout {
  display: grid;
  grid-template-columns: .88fr 1.12fr;
  gap: 38px;
  align-items: stretch;
}
.feature-list { display: flex; flex-direction: column; gap: 10px; }
.feature-tab {
  width: 100%;
  display: flex;
  align-items: center;
  text-align: left;
  gap: 14px;
  padding: 17px 16px;
  border: 1px solid transparent;
  background: #ffffff;
  border-radius: 13px;
  cursor: pointer;
  transition: all 0.25s ease;
  color: inherit;
}
.feature-tab:hover {
  background: #f8fafc;
  border-color: #e2e8f0;
  transform: translateX(4px);
}
.feature-tab.active {
  background: linear-gradient(135deg, #f5f3ff 0%, #eef2ff 100%);
  border-color: #c7d2fe;
  box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.16);
  transform: translateX(6px);
}
.feature-tab-icon {
  width: 40px;
  height: 40px;
  flex: 0 0 40px;
  display: grid;
  place-items: center;
  border-radius: 11px;
  font-size: 19px;
  transition: transform 0.25s ease;
}
.feature-tab:hover .feature-tab-icon { transform: scale(1.08); }
.feature-tab > span:nth-child(2) { min-width: 0; flex: 1; }
.feature-tab strong, .feature-tab small { display: block; }
.feature-tab strong { font-size: 13px; font-weight: 700; color: #0f172a; }
.feature-tab small { font-size: 10.5px; color: #64748b; margin-top: 4px; }
.tab-arrow { font-size: 16px; color: #94a3b8; transition: all 0.25s ease; }
.feature-tab.active .tab-arrow {
  color: #4f46e5;
  transform: translate(3px, -3px);
  font-weight: 800;
}

.feature-preview {
  border: 1px solid var(--line);
  border-radius: 18px;
  background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
  padding: 28px;
  box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.08), 0 0 35px -10px rgba(99, 102, 241, 0.1);
  min-width: 0;
  display: flex;
  flex-direction: column;
}
.preview-top { display: flex; justify-content: space-between; gap: 15px; }
.preview-kicker { font-size: 8.5px; letter-spacing: 1.3px; color: #64748b; font-weight: 800; }
.preview-kicker span { color: #4f46e5; }
.preview-top h3 { font: 800 21px/1.3 var(--display); letter-spacing: -.6px; margin: 12px 0 8px; color: #0f172a; }
.preview-top p { font-size: 11px; line-height: 1.7; color: #64748b; max-width: 350px; margin: 0 0 22px; }
.preview-dots { display: flex; gap: 5px; padding-top: 4px; }
.preview-dots i { width: 6px; height: 6px; border-radius: 50%; background: #cbd5e1; }
.preview-dots i:first-child { background: #4f46e5; box-shadow: 0 0 8px rgba(79, 70, 229, 0.5); }

.student-table {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 11px;
  overflow: hidden;
  box-shadow: var(--shadow-sm);
}
.table-heading, .student-row {
  display: grid;
  grid-template-columns: 1.45fr 1fr .8fr;
  gap: 8px;
  align-items: center;
  padding: 13px 12px;
}
.table-heading {
  background: #f8fafc;
  border-bottom: 1px solid #eef2f6;
  font-size: 7.5px;
  font-weight: 800;
  letter-spacing: .8px;
  color: #64748b;
}
.student-row { border-bottom: 1px solid #f1f5f9; transition: background 0.2s ease; }
.student-row:hover { background: #f8fafc; }
.student-row:last-of-type { border-bottom: 0; }
.student-info { display: flex; align-items: center; gap: 9px; min-width: 0; }
.student-avatar {
  width: 28px;
  height: 28px;
  border-radius: 8px;
  display: grid;
  place-items: center;
  font-size: 8px;
  font-weight: 800;
  flex: 0 0 28px;
}
.avatar-lilac { background: #eef2ff; color: #4f46e5; }
.avatar-peach { background: #ffedd5; color: #c2410c; }
.avatar-mint { background: #d1fae5; color: #047857; }
.avatar-blue { background: #e0f2fe; color: #0369a1; }
.student-info strong, .student-info small { display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.student-info strong { font-size: 9px; font-weight: 700; color: #0f172a; }
.student-info small { font-size: 7.5px; color: #94a3b8; margin-top: 2px; }
.membership { font-size: 8.5px; font-weight: 600; color: #475569; white-space: nowrap; }
.status-pill {
  font-size: 7.5px;
  font-weight: 700;
  padding: 5px 8px;
  border-radius: 6px;
  text-align: center;
  white-space: nowrap;
}
.status-active { background: #d1fae5; color: #047857; box-shadow: 0 0 6px rgba(16, 185, 129, 0.2); }
.status-due { background: #fef3c7; color: #b45309; }
.table-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px;
  background: #f8fafc;
  border-top: 1px solid #e2e8f0;
  font-size: 8.5px;
  color: #64748b;
}
.table-bottom button {
  border: 0;
  background: transparent;
  color: #4f46e5;
  font-size: 8.5px;
  font-weight: 800;
  cursor: pointer;
  transition: color 0.2s ease;
}
.table-bottom button:hover { color: #4338ca; }
.table-bottom button span { margin-left: 6px; }
.preview-note {
  margin-top: 18px;
  display: flex;
  align-items: center;
  gap: 8px;
  color: #64748b;
  font-size: 10px;
  font-weight: 500;
}
.preview-note span { color: #4f46e5; font-size: 14px; }

/* Dark Futuristic Student Journey Section */
.section-dark {
  background: radial-gradient(circle at 50% 0%, #1e1b4b 0%, #0a0f1d 70%, #05070d 100%);
  color: #ffffff;
  position: relative;
  overflow: hidden;
  border-top: 1px solid rgba(255, 255, 255, 0.08);
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}
.section-dark::before, .section-dark::after {
  content: "";
  position: absolute;
  border-radius: 50%;
  filter: blur(100px);
  pointer-events: none;
}
.section-dark::before {
  top: -150px;
  left: -100px;
  width: 450px;
  height: 450px;
  background: rgba(99, 102, 241, 0.15);
}
.section-dark::after {
  bottom: -150px;
  right: -100px;
  width: 450px;
  height: 450px;
  background: rgba(6, 182, 212, 0.12);
}
.journey .section-heading { position: relative; z-index: 1; }
.eyebrow-light {
  color: #c7d2fe;
  background: rgba(255, 255, 255, 0.08);
  border-color: rgba(255, 255, 255, 0.15);
}
.journey .section-heading h2 { color: #ffffff; }
.journey .section-heading h2 span {
  background: linear-gradient(135deg, #a5b4fc 0%, #c084fc 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.journey .section-heading p { color: #94a3b8; }

.journey-track {
  display: grid;
  grid-template-columns: 1fr 18px 1fr 18px 1fr 18px 1fr 18px 1fr;
  gap: 12px;
  align-items: start;
  position: relative;
  z-index: 1;
}
.journey-step {
  min-width: 0;
  background: rgba(255, 255, 255, 0.035);
  border: 1px solid rgba(255, 255, 255, 0.09);
  backdrop-filter: blur(12px);
  border-radius: 16px;
  padding: 22px 18px;
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.journey-step:hover {
  background: rgba(255, 255, 255, 0.07);
  border-color: rgba(165, 180, 252, 0.35);
  transform: translateY(-4px);
  box-shadow: 0 16px 35px -8px rgba(79, 70, 229, 0.3);
}
.journey-number {
  font: 800 11px var(--display);
  color: #818cf8;
  letter-spacing: 1.5px;
  margin-bottom: 16px;
}
.journey-icon {
  width: 48px;
  height: 48px;
  border: 1px solid rgba(255, 255, 255, 0.16);
  background: linear-gradient(135deg, rgba(99, 102, 241, 0.25), rgba(124, 58, 237, 0.1));
  border-radius: 14px;
  display: grid;
  place-items: center;
  color: #c7d2fe;
  font-size: 21px;
  margin-bottom: 16px;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
}
.journey-step h3 { font: 800 14px var(--display); margin: 0 0 9px; color: #ffffff; }
.journey-step p { font-size: 11px; line-height: 1.7; color: #94a3b8; margin: 0; }
.journey-connector {
  padding-top: 60px;
  color: #818cf8;
  font-size: 18px;
  animation: connectorPulse 2.5s ease-in-out infinite;
}
@keyframes connectorPulse {
  0%, 100% { opacity: 0.4; transform: translateX(0); }
  50% { opacity: 1; transform: translateX(3px); filter: drop-shadow(0 0 6px #818cf8); }
}

.journey-callout {
  margin-top: 48px;
  position: relative;
  z-index: 1;
  border: 1px solid rgba(255, 255, 255, 0.12);
  border-radius: 14px;
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(16px);
  padding: 20px 24px;
  display: flex;
  align-items: center;
  gap: 16px;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
}
.callout-spark { font-size: 22px; color: #a5b4fc; }
.journey-callout p { font-size: 11px; line-height: 1.7; color: #cbd5e1; margin: 0; flex: 1; }
.journey-callout strong { font-size: 13px; color: #ffffff; }
.callout-check {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: rgba(16, 185, 129, 0.2);
  border: 1px solid rgba(16, 185, 129, 0.4);
  color: #34d399;
  display: grid;
  place-items: center;
  font-size: 13px;
  box-shadow: 0 0 12px rgba(16, 185, 129, 0.3);
}

/* Security & Roles */
.security-grid { display: grid; grid-template-columns: 1fr .92fr; gap: 70px; align-items: center; }
.security-points { display: grid; gap: 20px; margin: 30px 0 28px; }
.security-points > div { display: flex; align-items: flex-start; gap: 14px; }
.check-round {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: #d1fae5;
  color: #059669;
  display: grid;
  place-items: center;
  font-size: 12px;
  font-weight: 800;
  flex: 0 0 24px;
  box-shadow: 0 2px 6px rgba(16, 185, 129, 0.2);
}
.security-points strong, .security-points small { display: block; }
.security-points strong { font-size: 13px; font-weight: 700; color: #0f172a; }
.security-points small { font-size: 11px; line-height: 1.7; color: #64748b; margin-top: 4px; }
.text-link {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  color: #4f46e5;
  font-size: 12.5px;
  font-weight: 800;
  transition: all 0.2s ease;
}
.text-link:hover { color: #4338ca; transform: translateX(3px); }
.text-link span { font-size: 16px; }

.roles-card {
  border: 1px solid var(--line);
  border-radius: 18px;
  background: #ffffff;
  padding: 24px;
  box-shadow: 0 25px 65px -15px rgba(15, 23, 42, 0.1);
}
.roles-card-head {
  display: flex;
  align-items: center;
  gap: 12px;
  padding-bottom: 18px;
  border-bottom: 1px solid #eef2f6;
}
.roles-shield {
  width: 40px;
  height: 40px;
  border-radius: 11px;
  background: linear-gradient(135deg, #eef2ff, #e0e7ff);
  color: #4f46e5;
  display: grid;
  place-items: center;
  font-size: 20px;
}
.roles-card-head h3 { font: 800 15px var(--display); margin: 0; color: #0f172a; }
.roles-card-head p { font-size: 9.5px; color: #94a3b8; margin: 4px 0 0; }
.roles-menu { margin-left: auto; color: #94a3b8; font-size: 18px; }

.role-row {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 0;
  border-bottom: 1px solid #f1f5f9;
  transition: all 0.2s ease;
}
.role-row:hover { background: #f8fafc; padding-left: 8px; border-radius: 8px; }
.role-avatar {
  width: 32px;
  height: 32px;
  border-radius: 10px;
  display: grid;
  place-items: center;
  font-size: 11px;
  font-weight: 800;
  flex: 0 0 32px;
}
.role-admin { background: #eef2ff; color: #4f46e5; }
.role-owner { background: #d1fae5; color: #047857; }
.role-manager { background: #e0f2fe; color: #0284c7; }
.role-staff { background: #fef3c7; color: #b45309; }
.role-student { background: #f3e8ff; color: #7e22ce; }
.role-row > div { flex: 1; min-width: 0; }
.role-row strong, .role-row small { display: block; }
.role-row strong { font-size: 11px; font-weight: 700; color: #0f172a; }
.role-row small { font-size: 8.5px; color: #94a3b8; margin-top: 3px; }
.role-tag {
  font-size: 8.5px;
  font-weight: 600;
  color: #475569;
  background: #f1f5f9;
  padding: 5px 9px;
  border-radius: 6px;
  white-space: nowrap;
}
.roles-foot {
  display: flex;
  align-items: center;
  gap: 8px;
  padding-top: 18px;
  font-size: 9px;
  line-height: 1.6;
  color: #64748b;
}
.lock-icon { font-size: 15px; color: #4f46e5; }

/* Reports & Operational Analytics */
.reports-grid { display: grid; grid-template-columns: .9fr 1.1fr; gap: 70px; align-items: center; }
.reports-copy .button { margin-top: 30px; }
.report-list { list-style: none; padding: 0; margin: 24px 0 0; display: grid; gap: 14px; }
.report-list li { display: flex; align-items: center; gap: 12px; color: #334155; font-size: 12px; font-weight: 600; }
.report-list li span {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  display: grid;
  place-items: center;
  background: #d1fae5;
  color: #059669;
  font-size: 11px;
  font-weight: 800;
}
.reports-visual { position: relative; padding: 12px 12px 26px 0; }
.report-window {
  border: 1px solid var(--line);
  border-radius: 18px;
  background: #ffffff;
  padding: 26px;
  box-shadow: 0 25px 70px -15px rgba(15, 23, 42, 0.12), 0 0 35px -10px rgba(99, 102, 241, 0.1);
  position: relative;
  z-index: 1;
}
.report-window-head { display: flex; justify-content: space-between; align-items: center; gap: 10px; }
.report-eyebrow { font-size: 7.5px; font-weight: 800; letter-spacing: 1.4px; color: #94a3b8; }
.report-window-head h3 { font: 800 17px var(--display); letter-spacing: -.5px; margin: 6px 0 0; color: #0f172a; }
.report-period {
  padding: 7px 11px;
  border: 1px solid #e2e8f0;
  border-radius: 7px;
  font-size: 8px;
  font-weight: 600;
  color: #475569;
  white-space: nowrap;
  background: #f8fafc;
}
.collection-total { margin-top: 24px; display: flex; justify-content: space-between; align-items: center; }
.collection-total small, .collection-total strong, .collection-total span { display: block; }
.collection-total small { font-size: 10px; color: #64748b; font-weight: 600; }
.collection-total strong { font: 800 30px var(--display); letter-spacing: -1.2px; margin: 5px 0; color: #0f172a; }
.collection-total .positive { font-size: 8.5px; }
.collection-icon {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: linear-gradient(135deg, #d1fae5, #a7f3d0);
  color: #047857;
  display: grid;
  place-items: center;
  font-size: 20px;
  font-weight: 800;
  box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25);
}

.bar-chart { display: flex; height: 175px; margin-top: 24px; }
.bar-y {
  width: 40px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding-bottom: 24px;
  color: #94a3b8;
  font-size: 8px;
  font-weight: 600;
}
.bar-area { position: relative; flex: 1; display: flex; flex-direction: column; justify-content: space-between; padding-bottom: 24px; }
.bar-grid { height: 1px; width: 100%; border-top: 1px dashed #e2e8f0; }
.bars {
  position: absolute;
  inset: 0 9px 24px;
  display: flex;
  align-items: flex-end;
  justify-content: space-around;
  gap: 12px;
}
.bars > div {
  width: min(32px, 12%);
  min-width: 16px;
  border-radius: 6px 6px 0 0;
  background: #e0e7ff;
  position: relative;
  transition: all 0.3s ease;
}
.bars > div:hover { transform: scaleY(1.05); background: #c7d2fe; }
.bars > div.bar-current {
  background: linear-gradient(180deg, #6366f1 0%, #4338ca 100%);
  box-shadow: 0 6px 20px rgba(99, 102, 241, 0.45);
}
.bars i {
  position: absolute;
  bottom: -22px;
  left: 50%;
  transform: translateX(-50%);
  font-style: normal;
  font-size: 8.5px;
  font-weight: 600;
  color: #64748b;
}

.report-bottom {
  display: flex;
  gap: 28px;
  border-top: 1px solid #eef2f6;
  padding-top: 18px;
  margin-top: 4px;
}
.report-bottom > div {
  display: grid;
  grid-template-columns: 8px auto;
  column-gap: 8px;
  row-gap: 5px;
  align-items: center;
}
.report-bottom span:nth-child(2) { font-size: 8.5px; color: #64748b; }
.report-bottom strong { grid-column: 2; font: 800 13px var(--display); color: #0f172a; }
.legend-dot { width: 8px; height: 8px; border-radius: 3px; grid-row: span 2; }
.collection-dot { background: #4f46e5; box-shadow: 0 0 6px rgba(79, 70, 229, 0.5); }
.due-dot { background: #e0e7ff; }

.report-floating {
  position: absolute;
  z-index: 2;
  right: -24px;
  bottom: 0;
  background: rgba(255, 255, 255, 0.95);
  border: 1px solid rgba(255, 255, 255, 0.9);
  border-radius: 12px;
  box-shadow: 0 16px 40px -10px rgba(15, 23, 42, 0.16), 0 0 25px rgba(79, 70, 229, 0.12);
  padding: 13px 18px;
  display: flex;
  align-items: center;
  gap: 12px;
  backdrop-filter: blur(14px);
  animation: floatCardB 6s ease-in-out infinite alternate;
}
.report-float-icon {
  width: 32px;
  height: 32px;
  border-radius: 9px;
  background: #d1fae5;
  color: #059669;
  display: grid;
  place-items: center;
  font-size: 16px;
  font-weight: 800;
}
.report-floating small, .report-floating strong { display: block; }
.report-floating small { font-size: 8.5px; color: #64748b; }
.report-floating strong { font-size: 11px; color: #0f172a; margin-top: 3px; }

/* Call-to-Action Section */
.cta-section { padding-top: 30px; padding-bottom: 80px; }
.cta-card {
  border-radius: 24px;
  background: radial-gradient(circle at 85% 20%, rgba(99, 102, 241, 0.28) 0%, transparent 45%),
              radial-gradient(circle at 15% 85%, rgba(6, 182, 212, 0.2) 0%, transparent 40%),
              linear-gradient(135deg, #0a0f1d 0%, #171e38 50%, #0a0f1d 100%);
  position: relative;
  overflow: hidden;
  padding: 60px 64px;
  display: grid;
  grid-template-columns: 1fr .62fr;
  gap: 48px;
  color: #ffffff;
  border: 1px solid rgba(255, 255, 255, 0.12);
  box-shadow: 0 35px 80px -20px rgba(15, 23, 42, 0.4), 0 0 60px -15px rgba(99, 102, 241, 0.25);
}
.cta-decoration {
  position: absolute;
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 50%;
  pointer-events: none;
}
.deco-one { width: 440px; height: 440px; right: 80px; top: -300px; }
.deco-two { width: 340px; height: 340px; right: -80px; bottom: -240px; }
.cta-content, .cta-side { position: relative; z-index: 1; }
.cta-content .eyebrow { margin-bottom: 20px; }
.cta-content h2 { font-size: clamp(34px, 3.6vw, 48px); color: #ffffff; letter-spacing: -2px; }
.cta-content h2 span {
  background: linear-gradient(135deg, #a5b4fc 0%, #c084fc 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.cta-content p { font-size: 13px; line-height: 1.8; color: #cbd5e1; max-width: 450px; margin: 18px 0 28px; }
.cta-actions { display: flex; flex-wrap: wrap; gap: 12px; }
.button-white {
  background: #ffffff;
  color: #0f172a;
  box-shadow: 0 8px 24px rgba(255, 255, 255, 0.2);
  font-weight: 800;
}
.button-white:hover {
  background: #f1f5f9;
  color: #0f172a;
  box-shadow: 0 12px 30px rgba(255, 255, 255, 0.3);
}
.button-outline {
  border-color: rgba(255, 255, 255, 0.25);
  color: #ffffff;
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(8px);
}
.button-outline:hover {
  background: rgba(255, 255, 255, 0.12);
  border-color: rgba(255, 255, 255, 0.4);
}
.cta-disclaimer { display: block; font-size: 8.5px; color: #94a3b8; margin-top: 24px; }
.cta-side { display: flex; flex-direction: column; justify-content: center; gap: 14px; }
.cta-check-card {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 16px 18px;
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 13px;
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(12px);
  transition: all 0.25s ease;
}
.cta-check-card:hover {
  background: rgba(255, 255, 255, 0.08);
  border-color: rgba(165, 180, 252, 0.3);
  transform: translateX(4px);
}
.cta-check-icon {
  width: 34px;
  height: 34px;
  border-radius: 10px;
  background: rgba(99, 102, 241, 0.2);
  color: #c7d2fe;
  display: grid;
  place-items: center;
  font-size: 17px;
  box-shadow: 0 0 10px rgba(99, 102, 241, 0.3);
}
.cta-check-card strong, .cta-check-card small { display: block; }
.cta-check-card strong { font-size: 12px; color: #ffffff; }
.cta-check-card small { font-size: 9.5px; color: #94a3b8; margin-top: 4px; }

/* Clean Minimal Footer */
.footer { border-top: 1px solid var(--line); background: #ffffff; }
.footer-main { min-height: 100px; display: flex; align-items: center; gap: 28px; }
.footer-brand .brand-mark { width: 32px; height: 32px; }
.footer-brand .brand-name { font-size: 16px; }
.footer-main > p { font-size: 11px; color: #64748b; margin: 0; }
.footer-links { margin-left: auto; display: flex; gap: 24px; font-size: 11px; color: #475569; font-weight: 700; }
.footer-links a:hover { color: #4f46e5; }
.footer-bottom {
  border-top: 1px solid #f1f5f9;
  min-height: 52px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 10px;
  color: #94a3b8;
}

/* Floating Back To Top Button */
.back-to-top {
  position: fixed;
  right: 24px;
  bottom: 24px;
  width: 42px;
  height: 42px;
  border: 0;
  border-radius: 12px;
  background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
  color: #ffffff;
  font-size: 18px;
  font-weight: 800;
  box-shadow: 0 10px 25px -4px rgba(79, 70, 229, 0.5);
  cursor: pointer;
  opacity: 0;
  pointer-events: none;
  transform: translateY(10px) scale(0.9);
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  z-index: 40;
}
.back-to-top.visible {
  opacity: 1;
  pointer-events: auto;
  transform: translateY(0) scale(1);
}
.back-to-top:hover {
  transform: translateY(-4px) scale(1.08);
  box-shadow: 0 14px 30px -4px rgba(79, 70, 229, 0.65);
}

/* Interactive Components Styles */
.seat-preview, .attendance-preview, .invoice-preview, .mini-report {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 11px;
  padding: 16px;
  box-shadow: var(--shadow-sm);
  animation: contentFadeIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes contentFadeIn {
  from { opacity: 0; transform: translateY(6px); }
  to { opacity: 1; transform: translateY(0); }
}

.seat-preview-head, .id-top, .id-bottom, .invoice-top, .invoice-line, .invoice-total, .mini-report-foot {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 8px;
}
.seat-preview-head { font-size: 8.5px; font-weight: 800; color: #475569; }
.seat-preview-head span:last-child { font-weight: 600; color: #94a3b8; }
.seat-legend { display: flex; gap: 14px; flex-wrap: wrap; margin: 16px 0 12px; font-size: 8.5px; color: #64748b; }
.seat-legend span { display: flex; align-items: center; gap: 5px; }
.seat-legend i { width: 9px; height: 9px; border-radius: 3px; display: inline-block; }
.seat-free { background: #d1fae5; border: 1px solid #a7f3d0; }
.seat-taken { background: #4f46e5; }
.seat-reserved { background: #fde68a; border: 1px solid #fcd34d; }

.seat-grid { display: grid; grid-template-columns: repeat(8, 1fr); gap: 7px; }
.seat {
  aspect-ratio: 1;
  display: grid;
  place-items: center;
  border: 1px solid #a7f3d0;
  border-radius: 6px;
  background: #ecfdf5;
  color: #047857;
  font-size: 8.5px;
  font-weight: 700;
  transition: all 0.2s ease;
}
.seat:hover { transform: scale(1.1); }
.seat.taken { background: #4f46e5; border-color: #4f46e5; color: #ffffff; box-shadow: 0 2px 6px rgba(79, 70, 229, 0.3); }
.seat.reserved { background: #fef3c7; border-color: #fde68a; color: #b45309; }
.seat.selected {
  outline: 2px solid #4f46e5;
  outline-offset: 2px;
  animation: seatPulse 2s infinite ease-in-out;
}
@keyframes seatPulse {
  0%, 100% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.6); }
  50% { box-shadow: 0 0 0 6px rgba(79, 70, 229, 0); }
}
.seat-selected {
  margin-top: 16px;
  border-top: 1px solid #eef2f6;
  padding-top: 13px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
}
.seat-selected b, .seat-selected small { display: block; }
.seat-selected b { font-size: 10.5px; color: #0f172a; }
.seat-selected small { font-size: 8.5px; color: #64748b; margin-top: 3px; }

.id-top { font-size: 7.5px; letter-spacing: 1.2px; font-weight: 800; color: #475569; }
.id-active {
  background: #d1fae5;
  color: #047857;
  padding: 5px 8px;
  border-radius: 6px;
  font-size: 6.5px;
  font-weight: 800;
  box-shadow: 0 0 8px rgba(16, 185, 129, 0.3);
}
.id-body { display: flex; align-items: center; gap: 12px; padding: 22px 0; }
.id-avatar {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
  color: #4338ca;
  display: grid;
  place-items: center;
  font-size: 14px;
  font-weight: 800;
}
.id-body > div:nth-child(2) { flex: 1; }
.id-body strong, .id-body small { display: block; }
.id-body strong { font-size: 12px; color: #0f172a; }
.id-body small { font-size: 8.5px; color: #64748b; margin-top: 4px; }
.fake-qr {
  width: 50px;
  height: 50px;
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  grid-template-rows: repeat(5, 1fr);
  gap: 2px;
  padding: 3px;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  background: #f8fafc;
}
.fake-qr i { background: #0f172a; border-radius: 1px; }
.fake-qr i:nth-child(3n) { background: #ffffff; border: 1px solid #0f172a; }
.id-bottom { border-top: 1px solid #eef2f6; padding-top: 12px; font-size: 8.5px; color: #64748b; }
.id-bottom strong { color: #0f172a; }
.checkin-success {
  display: flex;
  align-items: center;
  gap: 12px;
  background: #ecfdf5;
  border: 1px solid #a7f3d0;
  border-radius: 9px;
  padding: 13px;
  margin-top: 13px;
}
.checkin-success > span {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: #10b981;
  color: #ffffff;
  display: grid;
  place-items: center;
  font-size: 12px;
  font-weight: 800;
  box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
}
.checkin-success strong, .checkin-success small { display: block; }
.checkin-success strong { font-size: 9.5px; color: #065f46; }
.checkin-success small { font-size: 8px; color: #047857; margin-top: 3px; }

.invoice-label { font-size: 7.5px; letter-spacing: 1.3px; color: #94a3b8; font-weight: 800; }
.invoice-top h4 { font: 800 15px var(--display); margin: 5px 0 0; color: #0f172a; }
.invoice-student {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #f8fafc;
  border-radius: 8px;
  padding: 11px;
  margin: 15px 0;
  border: 1px solid #e2e8f0;
}
.invoice-student strong, .invoice-student small { display: block; }
.invoice-student strong { font-size: 9.5px; color: #0f172a; }
.invoice-student small { font-size: 8.5px; color: #64748b; margin-top: 3px; }
.invoice-line { font-size: 9.5px; color: #64748b; padding: 10px 2px; border-bottom: 1px solid #f1f5f9; }
.invoice-line strong { color: #0f172a; }
.invoice-total { padding: 14px 2px 10px; font-size: 11px; font-weight: 700; color: #0f172a; }
.invoice-total strong { font: 800 19px var(--display); color: #4f46e5; }
.invoice-payment {
  padding: 10px 12px;
  border-radius: 8px;
  background: #ecfdf5;
  border: 1px solid #a7f3d0;
  color: #047857;
  font-size: 8.5px;
  font-weight: 700;
}

.mini-report-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.mini-report-stats > div {
  padding: 12px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 9px;
}
.mini-report-stats small, .mini-report-stats strong, .mini-report-stats span { display: block; }
.mini-report-stats small { font-size: 8.5px; color: #64748b; }
.mini-report-stats strong { font: 800 23px var(--display); margin: 7px 0 4px; color: #0f172a; }
.mini-report-stats span { font-size: 7.5px; color: #94a3b8; }
.mini-report-chart {
  height: 130px;
  position: relative;
  margin-top: 18px;
  background: repeating-linear-gradient(to bottom, transparent 0, transparent 31px, #e2e8f0 32px);
}
.mini-report-bars {
  position: absolute;
  inset: 0 8px 20px;
  display: flex;
  align-items: flex-end;
  justify-content: space-around;
  gap: 10px;
}
.mini-report-bars span {
  width: 9%;
  border-radius: 5px 5px 0 0;
  background: #c7d2fe;
  transition: all 0.3s ease;
}
.mini-report-bars span:hover { background: #4f46e5; transform: scaleY(1.08); }
.mini-report-days {
  position: absolute;
  bottom: 0;
  left: 5px;
  right: 5px;
  display: flex;
  justify-content: space-around;
  font-size: 7.5px;
  font-weight: 600;
  color: #94a3b8;
}
.mini-report-foot {
  border-top: 1px solid #eef2f6;
  padding-top: 12px;
  margin-top: 4px;
  font-size: 7.5px;
  color: #64748b;
}
.mini-report-foot span:first-child { color: #4f46e5; font-weight: 700; }

/* Interactive Toast Notification */
.site-toast {
  position: fixed;
  z-index: 100;
  left: 50%;
  bottom: 24px;
  transform: translate(-50%, 15px);
  opacity: 0;
  pointer-events: none;
  max-width: min(520px, calc(100% - 32px));
  padding: 14px 20px;
  border-radius: 12px;
  background: #0f172a;
  color: #ffffff;
  font-size: 12.5px;
  line-height: 1.6;
  border: 1px solid rgba(255, 255, 255, 0.12);
  border-left: 4px solid #4f46e5;
  box-shadow: 0 16px 40px rgba(15, 23, 42, 0.35);
  transition: opacity .25s ease, transform .25s cubic-bezier(0.16, 1, 0.3, 1);
  backdrop-filter: blur(12px);
}
.site-toast.show { opacity: 1; transform: translate(-50%, 0); }

/* Responsive Adjustments */
@media (min-width: 1400px) {
  .hero { padding-top: 96px; }
  .dashboard { min-height: 460px; }
  .dash-main { padding: 24px 20px 16px; }
  .stat-card { padding: 13px 10px; }
  .chart { height: 120px; }
  .chart-area svg { height: 97px; }
}
@media (max-width: 1100px) {
  .hero-grid { grid-template-columns: .85fr 1.15fr; gap: 24px; }
  .hero h1 { font-size: 46px; }
  .dashboard { grid-template-columns: 140px minmax(0, 1fr); }
  .dash-main { padding: 17px 12px 10px; }
  .dash-sidebar { padding: 17px 9px 10px; }
  .stat-heading { font-size: 6.5px; }
  .stat-card > strong { font-size: 15px; }
  .seat-float { right: -9px; }
  .feature-layout { gap: 24px; }
  .security-grid, .reports-grid { gap: 45px; }
  .cta-card { padding: 48px 42px; gap: 30px; }
}
@media (max-width: 850px) {
  .section { padding: 80px 0; }
  .hero { padding-top: 56px; }
  .hero-grid { grid-template-columns: 1fr; gap: 12px; }
  .hero-copy { max-width: 650px; padding-bottom: 5px; }
  .hero h1 { font-size: clamp(40px, 7vw, 56px); }
  .hero-subtitle { max-width: 560px; }
  .dashboard-wrap { width: min(680px, 100%); margin: 0 auto; padding: 22px 8px 48px; }
  .dashboard { transform: none; min-height: 430px; }
  .dashboard:hover { transform: none; }
  .hero-bottom { margin-top: 5px; }
  .problem-grid { grid-template-columns: repeat(2, 1fr); }
  .feature-layout { grid-template-columns: 1fr; }
  .feature-list { display: grid; grid-template-columns: repeat(2, 1fr); }
  .feature-tab { padding: 13px 10px; }
  .feature-preview { margin-top: 4px; }
  .journey-track { grid-template-columns: repeat(5, 1fr); gap: 16px; }
  .journey-connector { display: none; }
  .journey-step p { font-size: 9.5px; }
  .security-grid, .reports-grid { grid-template-columns: 1fr; gap: 42px; }
  .security-copy { max-width: 620px; }
  .roles-card { max-width: 590px; width: 100%; margin: 0 auto; }
  .reports-copy { max-width: 620px; }
  .reports-visual { max-width: 620px; width: 100%; margin: 0 auto; }
  .cta-card { grid-template-columns: 1fr .7fr; gap: 25px; padding: 42px 32px; }
  .footer-main { flex-wrap: wrap; padding: 24px 0; gap: 14px; }
  .footer-main > p { flex: 1; min-width: 190px; }
  .footer-links { width: 100%; margin: 6px 0 0; }
}
@media (max-width: 600px) {
  .container { width: calc(100% - 32px); }
  .announcement { font-size: 9.5px; padding: 0 10px; text-align: center; min-height: 34px; }
  .site-header { height: 68px; }
  .brand-mark { width: 34px; height: 34px; }
  .brand-name { font-size: 16px; }
  .menu-toggle { display: block; }
  .nav-links {
    display: none;
    position: absolute;
    left: 0;
    right: 0;
    top: 67px;
    background: #ffffff;
    border-bottom: 1px solid var(--line);
    padding: 16px 24px 22px;
    flex-direction: column;
    align-items: stretch;
    gap: 0;
    box-shadow: 0 20px 35px -5px rgba(15, 23, 42, 0.14);
  }
  .nav-links.open { display: flex; }
  .nav-links > a:not(.nav-cta) { padding: 13px 4px; border-bottom: 1px solid #f1f5f9; }
  .nav-cta { justify-content: center; margin-top: 14px; }
  .section { padding: 68px 0; }
  .hero { padding-top: 40px; }
  .eyebrow { font-size: 9px; letter-spacing: 1.2px; margin-bottom: 18px; }
  .hero h1 { font-size: 38px; letter-spacing: -1.8px; }
  .hero-subtitle { font-size: 13.5px; line-height: 1.8; margin: 18px 0 24px; }
  .hero-actions { gap: 10px; }
  .button { min-height: 46px; padding: 0 14px; font-size: 11px; gap: 10px; }
  .hero-proof { margin-top: 26px; }
  .hero-trust { margin-top: 18px; font-size: 9.5px; }
  .dashboard-wrap { padding: 20px 0 44px; }
  .dashboard { grid-template-columns: 96px minmax(0, 1fr); border-radius: 12px; min-height: 340px; }
  .dash-sidebar { padding: 13px 6px 8px; }
  .dash-brand { gap: 4px; font-size: 7px; padding-bottom: 18px; white-space: normal; }
  .dash-brand small { font-size: 5px; }
  .mini-logo { width: 22px; height: 22px; flex: 0 0 22px; }
  .dash-label { font-size: 5px; margin-left: 5px; }
  .dash-link { font-size: 6px; gap: 4px; padding: 9px 4px; }
  .dash-link > span { font-size: 10px; width: 10px; }
  .dash-side-bottom { gap: 4px; }
  .avatar { width: 19px; height: 19px; font-size: 6px; }
  .dash-side-bottom strong { font-size: 5.5px; }
  .dash-side-bottom small { font-size: 5px; }
  .dash-side-bottom > span { font-size: 8px; }
  .dash-main { padding: 12px 8px 8px; }
  .dash-greeting { font-size: 6px; }
  .dash-topbar h3 { font-size: 11px; }
  .dash-date { font-size: 5px; padding: 5px; }
  .dash-top-actions { gap: 4px; }
  .bell { width: 20px; height: 20px; font-size: 10px; }
  .dash-branch { font-size: 6px; margin: 11px 0 7px; padding: 6px 5px; flex-wrap: wrap; }
  .dash-branch small { font-size: 5px; }
  .stat-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 6px; }
  .stat-card { padding: 8px 6px; }
  .stat-heading { font-size: 6px; }
  .stat-icon { width: 16px; height: 16px; font-size: 9px; }
  .stat-card > strong { font-size: 14px; margin: 5px 0; }
  .stat-card > small { font-size: 6px; }
  .positive { font-size: 6px; }
  .dash-content-grid { grid-template-columns: 1fr; gap: 6px; margin-top: 7px; }
  .dash-panel { padding: 8px; }
  .action-panel { display: none; }
  .panel-head h4 { font-size: 8px; }
  .panel-head p { font-size: 6px; }
  .chart-summary { margin-top: 8px; }
  .chart-summary strong { font-size: 12px; }
  .chart { height: 78px; margin-top: 5px; }
  .chart-y { font-size: 5px; width: 17px; }
  .chart-area svg { height: 61px; }
  .chart-x { font-size: 5px; }
  .dash-footer { font-size: 5px; margin-top: 7px; }
  .floating-card { transform: scale(.8); }
  .qr-float { left: -24px; bottom: 12px; transform-origin: left bottom; }
  .seat-float { right: -20px; top: 44%; transform-origin: right center; }
  .hero-bottom { display: block; padding: 18px 0; margin-top: 3px; }
  .hero-bottom > span { display: block; margin-bottom: 12px; }
  .hero-bottom > div { gap: 8px; flex-wrap: wrap; font-size: 8.5px; }
  .section-heading { margin-bottom: 30px; }
  .section-heading h2, .security-copy h2, .reports-copy h2 { font-size: 32px; letter-spacing: -1.5px; }
  .section-heading p, .security-copy > p, .reports-copy > p { font-size: 12.5px; }
  .problem-grid { grid-template-columns: 1fr; gap: 10px; }
  .problem-card { padding: 20px; }
  .problem-icon { margin-bottom: 14px; width: 38px; height: 38px; }
  .problem-card h3 { font-size: 13.5px; }
  .problem-card p { font-size: 10.5px; max-width: none; }
  .feature-list { grid-template-columns: 1fr; gap: 6px; }
  .feature-tab { padding: 12px 10px; }
  .feature-tab-icon { width: 34px; height: 34px; flex-basis: 34px; font-size: 16px; }
  .feature-tab strong { font-size: 11.5px; }
  .feature-tab small { font-size: 9px; }
  .feature-preview { padding: 16px 12px; }
  .preview-top h3 { font-size: 17px; }
  .preview-top p { font-size: 9.5px; }
  .table-heading, .student-row { grid-template-columns: 1.3fr .8fr .72fr; gap: 4px; padding: 10px 6px; }
  .table-heading { font-size: 6px; }
  .student-info { gap: 5px; }
  .student-avatar { width: 22px; height: 22px; flex-basis: 22px; font-size: 6.5px; }
  .student-info strong { font-size: 7.5px; }
  .student-info small { font-size: 6px; }
  .membership { font-size: 6.5px; }
  .status-pill { font-size: 6px; padding: 4px 4px; }
  .table-bottom { font-size: 7px; padding: 10px 6px; }
  .table-bottom button { font-size: 7px; }
  .journey-track { grid-template-columns: repeat(2, 1fr); gap: 20px 14px; }
  .journey-step:nth-of-type(5) { grid-column: 1; }
  .journey-number { margin-bottom: 12px; }
  .journey-icon { width: 42px; height: 42px; margin-bottom: 12px; }
  .journey-step h3 { font-size: 12.5px; }
  .journey-step p { font-size: 9.5px; }
  .journey-callout { margin-top: 30px; padding: 15px 14px; gap: 10px; }
  .journey-callout p { font-size: 9.5px; }
  .journey-callout strong { font-size: 10.5px; }
  .callout-spark { font-size: 18px; }
  .callout-check { width: 24px; height: 24px; flex: 0 0 24px; }
  .roles-card { padding: 16px; }
  .roles-card-head h3 { font-size: 12.5px; }
  .role-row { gap: 8px; padding: 12px 0; }
  .role-avatar { width: 28px; height: 28px; flex-basis: 28px; }
  .role-row strong { font-size: 9.5px; }
  .role-row small { font-size: 7.5px; }
  .role-tag { font-size: 7px; padding: 5px; }
  .roles-foot { font-size: 7.5px; }
  .report-window { padding: 16px 12px; }
  .report-window-head h3 { font-size: 15px; }
  .report-period { font-size: 7px; padding: 6px; }
  .collection-total strong { font-size: 24px; }
  .collection-icon { width: 36px; height: 36px; }
  .bar-chart { height: 150px; }
  .bars { gap: 7px; }
  .report-floating { right: -4px; padding: 10px 12px; }
  .cta-section { padding-top: 10px; padding-bottom: 45px; }
  .cta-card { grid-template-columns: 1fr; padding: 32px 22px; gap: 26px; border-radius: 18px; }
  .cta-content h2 { font-size: 32px; letter-spacing: -1.5px; }
  .cta-content p { font-size: 11.5px; }
  .cta-actions { flex-direction: column; align-items: stretch; }
  .cta-actions .button { width: 100%; }
  .cta-side { display: grid; grid-template-columns: 1fr; gap: 8px; }
  .cta-check-card { padding: 12px; }
  .footer-main { gap: 12px; }
  .footer-main > p { font-size: 9.5px; min-width: 100%; margin: 0; }
  .footer-links { gap: 16px; flex-wrap: wrap; font-size: 9.5px; }
  .footer-bottom { align-items: flex-start; justify-content: center; flex-direction: column; gap: 7px; padding: 14px 0; font-size: 8.5px; }
  .back-to-top { right: 14px; bottom: 14px; width: 36px; height: 36px; font-size: 16px; }
}
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after {
    scroll-behavior: auto !important;
    transition: none !important;
    animation: none !important;
  }
}
  </style>
</head>
<body>
  <div class="announcement">
    <span class="announcement-dot"></span>
    Built for modern study centers &amp; reading rooms
    <span class="announcement-separator">·</span>
    One unified operating system for everyday operations
  </div>

  <header class="site-header">
    <nav class="nav container" aria-label="Main navigation">
      <a class="brand" href="{{ url('/') }}" aria-label="{{ config('app.name', 'StudyCenter Pro') }} home">
        <span class="brand-mark">
          <svg viewBox="0 0 40 40" aria-hidden="true">
            <rect x="3" y="3" width="34" height="34" rx="11" fill="currentColor"/>
            <path d="M11 13.5c4-2.2 8-1.8 11 0v14c-3-1.8-7-2.2-11 0z" fill="#fff"/>
            <path d="M29 13.5c-4-2.2-8-1.8-11 0v14c3-1.8 7-2.2 11 0z" fill="#c8f2df"/>
            <path d="M20 14v13" stroke="#101d35" stroke-width="1.5"/>
          </svg>
        </span>
        <span class="brand-name">StudyCenter<span>Pro</span></span>
      </a>
      <button class="menu-toggle" aria-label="Toggle navigation" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
      <div class="nav-links" id="navLinks">
        <a href="#platform">Platform</a>
        <a href="#features">Features</a>
        <a href="#how-it-works">How it works</a>
        <a href="#security">Security</a>
        @if (Route::has('login'))
          @auth
            <a class="nav-cta" href="{{ route('dashboard') }}">Dashboard <span>→</span></a>
          @else
            <a href="{{ route('login') }}">Log in</a>
            @if (Route::has('register'))
              <a class="nav-cta" href="{{ route('register') }}">Get Started <span>↗</span></a>
            @else
              <a class="nav-cta" href="#contact">Book a walkthrough <span>↗</span></a>
            @endif
          @endauth
        @else
          <a class="nav-cta" href="#contact">Book a walkthrough <span>↗</span></a>
        @endif
      </div>
    </nav>
  </header>

  <main>
    <section class="hero section" id="home">
      <div class="hero-glow glow-one"></div><div class="hero-glow glow-two"></div>
      <div class="container hero-grid">
        <div class="hero-copy">
          <div class="eyebrow"><span class="eyebrow-icon">✦</span> THE OPERATING SYSTEM FOR STUDY CENTERS</div>
          <h1>Run your study center.<br><span>Not your registers.</span></h1>
          <p class="hero-subtitle">Students, seats, attendance, fees and staff — all connected in one simple, secure dashboard.</p>
          <div class="hero-actions">
            @auth
              <a class="button button-primary" href="{{ route('dashboard') }}">Go to Dashboard <span>→</span></a>
              <a class="button button-quiet" href="#platform"><span class="play-icon">▶</span> See how it works</a>
            @else
              @if (Route::has('register'))
                <a class="button button-primary" href="{{ route('register') }}">Get Started Free <span>↗</span></a>
              @else
                <a class="button button-primary" href="#contact">Explore the platform <span>↗</span></a>
              @endif
              <a class="button button-quiet" href="#platform"><span class="play-icon">▶</span> See how it works</a>
            @endauth
          </div>
          <div class="hero-proof">
            <div class="proof-avatars"><span>SC</span><span>QR</span><span>₹</span></div>
            <div><strong>One connected workspace</strong><small>From admission to daily reporting</small></div>
          </div>
          <div class="hero-trust"><span>✓</span> Designed around real study-center and library workflows</div>
        </div>

        <div class="dashboard-wrap" id="platform">
          <div class="dashboard-orbit orbit-a"></div><div class="dashboard-orbit orbit-b"></div>
          <div class="dashboard">
            <aside class="dash-sidebar">
              <div class="dash-brand"><span class="mini-logo">S</span><span>StudyCenter<small>PRO WORKSPACE</small></span></div>
              <div class="dash-label">WORKSPACE</div>
              <a class="dash-link active" href="#platform"><span>▦</span> Overview</a>
              <a class="dash-link" href="#features"><span>♙</span> Students</a>
              <a class="dash-link" href="#features"><span>▤</span> Seat map</a>
              <a class="dash-link" href="#features"><span>◷</span> Attendance</a>
              <a class="dash-link" href="#features"><span>₹</span> Fees & invoices</a>
              <a class="dash-link" href="#features"><span>▥</span> Reports</a>
              <div class="dash-side-bottom">
                @auth
                  <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'AM', 0, 2)) }}</div>
                  <div><strong>{{ Auth::user()->name ?? 'Admin Manager' }}</strong><small>Active session</small></div>
                @else
                  <div class="avatar">AM</div>
                  <div><strong>Admin Manager</strong><small>Workspace owner</small></div>
                @endauth
                <span>⌄</span>
              </div>
            </aside>
            <div class="dash-main">
              <div class="dash-topbar">
                <div>
                  <span class="dash-greeting">
                    @auth
                      Welcome back, {{ Auth::user()->name }} 👋
                    @else
                      Good morning, Admin 👋
                    @endauth
                  </span>
                  <h3>Your center at a glance</h3>
                </div>
                <div class="dash-top-actions">
                  <span class="dash-date">◷ &nbsp; Today, {{ now()->format('d M') }}</span>
                  <span class="bell">♧<i></i></span>
                </div>
              </div>
              <div class="dash-branch">⌖ &nbsp; Sector 34 Branch <span>⌄</span><span class="live-dot"></span><small>Live overview</small></div>
              <div class="stat-grid">
                <div class="stat-card">
                  <div class="stat-heading"><span>Active students</span><b class="stat-icon purple">♙</b></div>
                  <strong>428</strong>
                  <small class="positive">↗ 18 <span>this month</span></small>
                </div>
                <div class="stat-card">
                  <div class="stat-heading"><span>Seats occupied</span><b class="stat-icon blue">▤</b></div>
                  <strong>312<span class="stat-total"> / 360</span></strong>
                  <div class="progress"><span style="width:87%"></span></div>
                  <small>87% occupancy</small>
                </div>
                <div class="stat-card">
                  <div class="stat-heading"><span>Present today</span><b class="stat-icon green">✓</b></div>
                  <strong>286</strong>
                  <small class="positive">QR attendance</small>
                </div>
                <div class="stat-card">
                  <div class="stat-heading"><span>Fees due</span><b class="stat-icon orange">₹</b></div>
                  <strong>₹1.24L</strong>
                  <small class="warning">62 students pending</small>
                </div>
              </div>
              <div class="dash-content-grid">
                <div class="dash-panel attendance-panel">
                  <div class="panel-head">
                    <div><h4>Attendance overview</h4><p>Student check-ins this week</p></div>
                    <span class="panel-select">This week ⌄</span>
                  </div>
                  <div class="chart-summary"><strong>1,842 <span class="positive">↗ 12.8%</span></strong><small>check-ins recorded</small></div>
                  <div class="chart">
                    <div class="chart-y"><span>350</span><span>250</span><span>150</span><span>50</span></div>
                    <div class="chart-area">
                      <div class="grid-line line1"></div>
                      <div class="grid-line line2"></div>
                      <div class="grid-line line3"></div>
                      <div class="grid-line line4"></div>
                      <svg viewBox="0 0 420 130" preserveAspectRatio="none" aria-label="Attendance trend chart">
                        <defs>
                          <linearGradient id="areaFill" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#5a66e8" stop-opacity=".22"/>
                            <stop offset="100%" stop-color="#5a66e8" stop-opacity="0"/>
                          </linearGradient>
                        </defs>
                        <path d="M0 99 C22 90 28 82 54 87 S89 75 108 79 S145 51 163 62 S197 69 216 47 S253 61 270 42 S305 49 324 29 S359 48 378 22 S402 28 420 10 L420 130 L0 130Z" fill="url(#areaFill)"/>
                        <path d="M0 99 C22 90 28 82 54 87 S89 75 108 79 S145 51 163 62 S197 69 216 47 S253 61 270 42 S305 49 324 29 S359 48 378 22 S402 28 420 10" fill="none" stroke="#5b66e8" stroke-width="3" stroke-linecap="round"/>
                      </svg>
                      <div class="chart-x"><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span></div>
                    </div>
                  </div>
                </div>
                <div class="dash-panel action-panel">
                  <div class="panel-head"><div><h4>Needs your attention</h4><p>Quick actions for today</p></div><span class="action-count">3</span></div>
                  <div class="action-row"><span class="action-ico amber">◷</span><div><strong>Memberships expiring</strong><small>12 students need renewal</small></div><span class="action-arrow">→</span></div>
                  <div class="action-row"><span class="action-ico coral">₹</span><div><strong>Payments pending</strong><small>8 payments to follow up</small></div><span class="action-arrow">→</span></div>
                  <div class="action-row"><span class="action-ico mint">▤</span><div><strong>Seats available</strong><small>14 seats ready to allocate</small></div><span class="action-arrow">→</span></div>
                  <a href="#features" class="view-all">View all tasks <span>→</span></a>
                </div>
              </div>
              <div class="dash-footer"><span><i class="live-dot"></i> All systems operational</span><span>Last updated just now</span></div>
            </div>
          </div>
          <div class="floating-card qr-float"><div class="qr-mini"><span></span><span></span><span></span><span></span><i></i></div><div><strong>QR check-in</strong><small>Attendance recorded</small></div><b>✓</b></div>
          <div class="floating-card seat-float"><span class="seat-float-icon">▦</span><div><small>Seat occupancy</small><strong>87% <em>↗</em></strong></div><div class="tiny-bars"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div></div>
        </div>
      </div>
      <div class="container hero-bottom"><span>ONE PLACE FOR EVERYDAY OPERATIONS</span><div><span>Students</span><i>·</i><span>Seats</span><i>·</i><span>Attendance</span><i>·</i><span>Fees</span><i>·</i><span>Reports</span></div></div>
    </section>

    <section class="problem section section-soft">
      <div class="container">
        <div class="section-heading centered">
          <div class="eyebrow">A BETTER WAY TO WORK</div>
          <h2>Your center deserves more than<br><span>scattered spreadsheets.</span></h2>
          <p>When daily operations live in registers, Excel sheets and chat threads, the smallest tasks take too much time.</p>
        </div>
        <div class="problem-grid">
          <article class="problem-card"><div class="problem-icon problem-purple">♙</div><h3>Student records everywhere</h3><p>Find admissions, active members and contact details without searching multiple files.</p></article>
          <article class="problem-card"><div class="problem-icon problem-blue">▦</div><h3>Seat confusion</h3><p>Know which seats are available, occupied, reserved or under maintenance.</p></article>
          <article class="problem-card"><div class="problem-icon problem-green">◷</div><h3>Manual attendance</h3><p>Replace error-prone register entries with a connected QR check-in workflow.</p></article>
          <article class="problem-card"><div class="problem-icon problem-orange">₹</div><h3>Unclear fee status</h3><p>Connect invoices, payments, receipts and pending dues to each student.</p></article>
          <article class="problem-card"><div class="problem-icon problem-pink">♧</div><h3>Too much staff dependency</h3><p>Give each role the right access and make important information easier to find.</p></article>
          <article class="problem-card"><div class="problem-icon problem-teal">▥</div><h3>Slow reporting</h3><p>Understand occupancy, collections, attendance and renewals at a glance.</p></article>
        </div>
      </div>
    </section>

    <section class="features section" id="features">
      <div class="container">
        <div class="section-heading">
          <div class="eyebrow">ONE CONNECTED PLATFORM</div>
          <h2>Everything your center needs.<br><span>Nothing scattered.</span></h2>
          <p>Purpose-built modules work together, helping your team spend less time managing records and more time supporting students.</p>
        </div>
        <div class="feature-layout">
          <div class="feature-list">
            <button class="feature-tab active" data-feature="students" type="button"><span class="feature-tab-icon purple">♙</span><span><strong>Student & membership management</strong><small>Profiles, plans, validity and renewals</small></span><span class="tab-arrow">↗</span></button>
            <button class="feature-tab" data-feature="seats" type="button"><span class="feature-tab-icon blue">▦</span><span><strong>Visual seat allocation</strong><small>Branch, floor, room and seat status</small></span><span class="tab-arrow">↗</span></button>
            <button class="feature-tab" data-feature="attendance" type="button"><span class="feature-tab-icon green">⌗</span><span><strong>QR attendance & digital ID</strong><small>Check-in logs and live visibility</small></span><span class="tab-arrow">↗</span></button>
            <button class="feature-tab" data-feature="fees" type="button"><span class="feature-tab-icon orange">₹</span><span><strong>Fees, invoices & receipts</strong><small>Payment tracking and pending dues</small></span><span class="tab-arrow">↗</span></button>
            <button class="feature-tab" data-feature="reports" type="button"><span class="feature-tab-icon pink">▥</span><span><strong>Reports & branch operations</strong><small>Occupancy, revenue and performance</small></span><span class="tab-arrow">↗</span></button>
          </div>
          <div class="feature-preview">
            <div class="preview-top">
              <div>
                <span class="preview-kicker">STUDYCENTER PRO / <span id="previewCategory">STUDENTS</span></span>
                <h3 id="previewTitle">Every student, accounted for.</h3>
                <p id="previewText">Keep student profiles, membership plans and validity together in one searchable place.</p>
              </div>
              <span class="preview-dots"><i></i><i></i><i></i></span>
            </div>
            <div class="student-table" id="previewContent">
              <div class="table-heading"><span>STUDENT</span><span>MEMBERSHIP</span><span>STATUS</span></div>
              <div class="student-row"><div class="student-info"><span class="student-avatar avatar-lilac">AS</span><span><strong>Aarav Sharma</strong><small>SC-1048</small></span></div><span class="membership">Monthly Fixed</span><span class="status-pill status-active">Active</span></div>
              <div class="student-row"><div class="student-info"><span class="student-avatar avatar-peach">PK</span><span><strong>Priya Kapoor</strong><small>SC-1049</small></span></div><span class="membership">Monthly Flex</span><span class="status-pill status-active">Active</span></div>
              <div class="student-row"><div class="student-info"><span class="student-avatar avatar-mint">RV</span><span><strong>Rohan Verma</strong><small>SC-1050</small></span></div><span class="membership">Quarterly</span><span class="status-pill status-due">Renew soon</span></div>
              <div class="student-row"><div class="student-info"><span class="student-avatar avatar-blue">MS</span><span><strong>Meera Singh</strong><small>SC-1051</small></span></div><span class="membership">Monthly Fixed</span><span class="status-pill status-active">Active</span></div>
              <div class="table-bottom"><span>Showing sample records</span><button type="button" id="previewAction">View all students <span>→</span></button></div>
            </div>
            <div class="preview-note"><span>✦</span> One connected record. Fewer repeated entries.</div>
          </div>
        </div>
      </div>
    </section>

    <section class="journey section section-dark" id="how-it-works">
      <div class="container">
        <div class="section-heading centered">
          <div class="eyebrow eyebrow-light">A CONNECTED STUDENT JOURNEY</div>
          <h2>From admission to check-in.<br><span>One seamless flow.</span></h2>
          <p>Each step updates the same student record, giving your team a clearer picture of daily operations.</p>
        </div>
        <div class="journey-track">
          <article class="journey-step"><div class="journey-number">01</div><div class="journey-icon">♙</div><h3>Admission</h3><p>Create a student profile with contact details and photo.</p></article>
          <div class="journey-connector">→</div>
          <article class="journey-step"><div class="journey-number">02</div><div class="journey-icon">▤</div><h3>Membership</h3><p>Choose a plan and set its validity period.</p></article>
          <div class="journey-connector">→</div>
          <article class="journey-step"><div class="journey-number">03</div><div class="journey-icon">▦</div><h3>Seat allocation</h3><p>Assign an available seat in the right room.</p></article>
          <div class="journey-connector">→</div>
          <article class="journey-step"><div class="journey-number">04</div><div class="journey-icon">⌗</div><h3>QR check-in</h3><p>Record attendance with date and time.</p></article>
          <div class="journey-connector">→</div>
          <article class="journey-step"><div class="journey-number">05</div><div class="journey-icon">₹</div><h3>Fees & portal</h3><p>Track payments and let students view their details.</p></article>
        </div>
        <div class="journey-callout"><span class="callout-spark">✦</span><p><strong>One student. One connected record.</strong><br>Less time matching registers. More visibility into the whole center.</p><span class="callout-check">✓</span></div>
      </div>
    </section>

    <section class="security section" id="security">
      <div class="container security-grid">
        <div class="security-copy">
          <div class="eyebrow">ACCESS WITH CONFIDENCE</div>
          <h2>Everyone gets the access<br><span>they actually need.</span></h2>
          <p>Role-based access helps protect sensitive information while giving each person the tools for their work.</p>
          <div class="security-points">
            <div><span class="check-round">✓</span><div><strong>Role-based permissions</strong><small>Configure access for owners, managers, staff and students.</small></div></div>
            <div><span class="check-round">✓</span><div><strong>Branch-aware visibility</strong><small>Keep access aligned with authorized branch data.</small></div></div>
            <div><span class="check-round">✓</span><div><strong>Activity & audit logs</strong><small>Maintain records of important actions and changes.</small></div></div>
          </div>
          <a href="#contact" class="text-link">Discuss your workflow <span>→</span></a>
        </div>
        <div class="roles-card">
          <div class="roles-card-head"><span class="roles-shield">♢</span><div><h3>Access by role</h3><p>Illustrative permission structure</p></div><span class="roles-menu">···</span></div>
          <div class="role-row"><span class="role-avatar role-admin">A</span><div><strong>System administrator</strong><small>Configuration & access control</small></div><span class="role-tag">System</span></div>
          <div class="role-row"><span class="role-avatar role-owner">O</span><div><strong>Library owner</strong><small>Students, fees & reports</small></div><span class="role-tag">Full access</span></div>
          <div class="role-row"><span class="role-avatar role-manager">M</span><div><strong>Branch manager</strong><small>Branch operations</small></div><span class="role-tag">Branch</span></div>
          <div class="role-row"><span class="role-avatar role-staff">S</span><div><strong>Staff member</strong><small>Assigned operational tasks</small></div><span class="role-tag">Limited</span></div>
          <div class="role-row"><span class="role-avatar role-student">↗</span><div><strong>Student</strong><small>Own profile, seat, fees & ID</small></div><span class="role-tag">Self-service</span></div>
          <div class="roles-foot"><span class="lock-icon">♧</span> Permissions are checked at the action and data level.</div>
        </div>
      </div>
    </section>

    <section class="reports section section-soft">
      <div class="container reports-grid">
        <div class="reports-copy">
          <div class="eyebrow">SEE THE WHOLE PICTURE</div>
          <h2>Reports that help you<br><span>make better decisions.</span></h2>
          <p>Turn everyday activity into clear operational insight. Understand what is happening across your center without waiting for month-end manual summaries.</p>
          <ul class="report-list">
            <li><span>✓</span> Seat and room occupancy</li>
            <li><span>✓</span> Revenue, collections and pending dues</li>
            <li><span>✓</span> Attendance and membership renewals</li>
            <li><span>✓</span> Branch operations and growth trends</li>
          </ul>
          <a href="#contact" class="button button-primary">Plan your dashboard <span>↗</span></a>
        </div>
        <div class="reports-visual">
          <div class="report-window">
            <div class="report-window-head">
              <div><span class="report-eyebrow">MONTHLY OVERVIEW</span><h3>Collection snapshot</h3></div>
              <span class="report-period">{{ now()->format('M Y') }} ⌄</span>
            </div>
            <div class="collection-total">
              <div><small>Total collection</small><strong>₹ 3,84,500</strong><span class="positive">↗ Sample data</span></div>
              <div class="collection-icon">₹</div>
            </div>
            <div class="bar-chart">
              <div class="bar-y"><span>₹1L</span><span>₹75k</span><span>₹50k</span><span>₹25k</span><span>₹0</span></div>
              <div class="bar-area">
                <div class="bar-grid"></div><div class="bar-grid"></div><div class="bar-grid"></div><div class="bar-grid"></div>
                <div class="bars">
                  <div style="height:44%"><i>Jul</i></div>
                  <div style="height:58%"><i>Aug</i></div>
                  <div style="height:52%"><i>Sep</i></div>
                  <div class="bar-current" style="height:82%"><i>Oct</i></div>
                  <div style="height:67%"><i>Nov</i></div>
                  <div style="height:74%"><i>Dec</i></div>
                </div>
              </div>
            </div>
            <div class="report-bottom">
              <div><span class="legend-dot collection-dot"></span><span>Collected</span><strong>₹3.84L</strong></div>
              <div><span class="legend-dot due-dot"></span><span>Pending dues</span><strong>₹1.24L</strong></div>
            </div>
          </div>
          <div class="report-floating"><span class="report-float-icon">↗</span><div><small>Center visibility</small><strong>Clearer decisions</strong></div></div>
        </div>
      </div>
    </section>

    <section class="cta-section section" id="contact">
      <div class="container cta-card">
        <div class="cta-decoration deco-one"></div><div class="cta-decoration deco-two"></div>
        <div class="cta-content">
          <div class="eyebrow eyebrow-light">READY FOR A SIMPLER WORKDAY?</div>
          <h2>One center.<br><span>One dashboard. Full control.</span></h2>
          <p>Get started with StudyCenter Pro to modernize student admissions, seat allocation, attendance tracking, and fee collections.</p>
          <div class="cta-actions">
            @auth
              <a href="{{ route('dashboard') }}" class="button button-white">Open Dashboard <span>→</span></a>
              <a href="#features" class="button button-outline">Explore the features</a>
            @else
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="button button-white">Create an account <span>↗</span></a>
              @endif
              @if (Route::has('login'))
                <a href="{{ route('login') }}" class="button button-outline">Sign in</a>
              @endif
            @endauth
          </div>
          <small class="cta-disclaimer">Production-ready platform · Study Center &amp; Library Management System.</small>
        </div>
        <div class="cta-side">
          <div class="cta-check-card"><span class="cta-check-icon">✓</span><div><strong>Simple for staff</strong><small>Clear, focused workflows</small></div></div>
          <div class="cta-check-card"><span class="cta-check-icon">♢</span><div><strong>Secure by design</strong><small>Role-aware access model</small></div></div>
          <div class="cta-check-card"><span class="cta-check-icon">↗</span><div><strong>Ready to grow</strong><small>Designed for single or multi-branch</small></div></div>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container footer-main">
      <a class="brand footer-brand" href="{{ url('/') }}">
        <span class="brand-mark">
          <svg viewBox="0 0 40 40" aria-hidden="true">
            <rect x="3" y="3" width="34" height="34" rx="11" fill="currentColor"/>
            <path d="M11 13.5c4-2.2 8-1.8 11 0v14c-3-1.8-7-2.2-11 0z" fill="#fff"/>
            <path d="M29 13.5c-4-2.2-8-1.8-11 0v14c3-1.8 7-2.2 11 0z" fill="#c8f2df"/>
            <path d="M20 14v13" stroke="#101d35" stroke-width="1.5"/>
          </svg>
        </span>
        <span class="brand-name">StudyCenter<span>Pro</span></span>
      </a>
      <p>A smarter way to run everyday study-center and library operations.</p>
      <div class="footer-links">
        <a href="#platform">Platform</a>
        <a href="#features">Features</a>
        <a href="#security">Security</a>
        @if (Route::has('login'))
          @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
          @else
            <a href="{{ route('login') }}">Login</a>
          @endauth
        @endif
      </div>
    </div>
    <div class="container footer-bottom">
      <span>© <span id="year">{{ date('Y') }}</span> StudyCenter Pro. All rights reserved.</span>
      <span>Designed for focused learning spaces.</span>
    </div>
  </footer>

  <button class="back-to-top" aria-label="Back to top">↑</button>

  <script>
const menuToggle = document.querySelector('.menu-toggle');
const navLinks = document.querySelector('.nav-links');

if (menuToggle && navLinks) {
  menuToggle.addEventListener('click', () => {
    const isOpen = navLinks.classList.toggle('open');
    menuToggle.setAttribute('aria-expanded', String(isOpen));
  });

  navLinks.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      navLinks.classList.remove('open');
      menuToggle.setAttribute('aria-expanded', 'false');
    });
  });
}

const backToTop = document.querySelector('.back-to-top');
window.addEventListener('scroll', () => {
  backToTop.classList.toggle('visible', window.scrollY > 500);
}, { passive: true });
backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

const featureData = {
  students: {
    category: 'STUDENTS',
    title: 'Every student, accounted for.',
    text: 'Keep student profiles, membership plans and validity together in one searchable place.',
    button: 'View all students',
    content: `<div class="table-heading"><span>STUDENT</span><span>MEMBERSHIP</span><span>STATUS</span></div>
      <div class="student-row"><div class="student-info"><span class="student-avatar avatar-lilac">AS</span><span><strong>Aarav Sharma</strong><small>SC-1048</small></span></div><span class="membership">Monthly Fixed</span><span class="status-pill status-active">Active</span></div>
      <div class="student-row"><div class="student-info"><span class="student-avatar avatar-peach">PK</span><span><strong>Priya Kapoor</strong><small>SC-1049</small></span></div><span class="membership">Monthly Flex</span><span class="status-pill status-active">Active</span></div>
      <div class="student-row"><div class="student-info"><span class="student-avatar avatar-mint">RV</span><span><strong>Rohan Verma</strong><small>SC-1050</small></span></div><span class="membership">Quarterly</span><span class="status-pill status-due">Renew soon</span></div>
      <div class="student-row"><div class="student-info"><span class="student-avatar avatar-blue">MS</span><span><strong>Meera Singh</strong><small>SC-1051</small></span></div><span class="membership">Monthly Fixed</span><span class="status-pill status-active">Active</span></div>`
  },
  seats: {
    category: 'SEAT MANAGEMENT',
    title: 'Find the right seat, faster.',
    text: 'See seat availability across branches, floors and rooms before assigning a membership.',
    button: 'Explore seat map',
    content: `<div class="seat-preview"><div class="seat-preview-head"><span>SECTOR 34 · SILENT HALL</span><span>Floor 1 ⌄</span></div><div class="seat-legend"><span><i class="seat-free"></i>Available</span><span><i class="seat-taken"></i>Occupied</span><span><i class="seat-reserved"></i>Reserved</span></div><div class="seat-grid">${Array.from({length:32},(_,i)=>`<span class="seat ${[2,4,5,9,11,12,14,17,18,20,23,24,27,30].includes(i+1)?'taken':[6,15,22].includes(i+1)?'reserved':i+1===18?'selected':''}">${i+1}</span>`).join('')}</div><div class="seat-selected"><span><b>Seat 18</b><small>Occupied · Aarav Sharma</small></span><span class="status-pill status-active">Monthly Fixed</span></div></div>`
  },
  attendance: {
    category: 'QR ATTENDANCE',
    title: 'A scan makes attendance simple.',
    text: 'Connect each student’s digital ID to check-in records, membership validation and live visibility.',
    button: 'View attendance flow',
    content: `<div class="attendance-preview"><div class="digital-id"><div class="id-top"><span class="mini-logo">S</span><span>STUDYCENTER PRO</span><span class="id-active">ACTIVE</span></div><div class="id-body"><span class="id-avatar">AS</span><div><strong>Aarav Sharma</strong><small>Student ID · SC-1048</small><small>Monthly Fixed Seat</small></div><div class="fake-qr">${'<i></i>'.repeat(25)}</div></div><div class="id-bottom"><span>Membership valid until</span><strong>31 Oct {{ date('Y') }}</strong></div></div><div class="checkin-success"><span>✓</span><div><strong>Check-in recorded</strong><small>Today at 08:12 AM · Sector 34</small></div></div></div>`
  },
  fees: {
    category: 'FEES & PAYMENTS',
    title: 'Know what’s paid and what’s due.',
    text: 'Keep invoices, payment references, receipts and pending amounts connected to each student.',
    button: 'Explore fee tracking',
    content: `<div class="invoice-preview"><div class="invoice-top"><div><span class="invoice-label">INVOICE</span><h4>INV-{{ date('Y') }}-1048</h4></div><span class="status-pill status-active">PAID</span></div><div class="invoice-student"><span class="student-avatar avatar-lilac">AS</span><div><strong>Aarav Sharma</strong><small>Monthly Fixed Seat · {{ now()->format('M Y') }}</small></div></div><div class="invoice-line"><span>Membership fee</span><strong>₹ 1,800</strong></div><div class="invoice-line"><span>Locker</span><strong>₹ 200</strong></div><div class="invoice-line"><span>Discount</span><strong>− ₹ 100</strong></div><div class="invoice-total"><span>Total paid</span><strong>₹ 1,900</strong></div><div class="invoice-payment">✓ &nbsp; Paid via UPI · Ref: 83XX21</div></div>`
  },
  reports: {
    category: 'REPORTS & BRANCHES',
    title: 'Turn daily activity into insight.',
    text: 'Understand occupancy, collections, attendance and upcoming renewals in a single reporting view.',
    button: 'Explore reports',
    content: `<div class="mini-report"><div class="mini-report-stats"><div><small>Occupancy</small><strong>87%</strong><span>312 of 360 seats</span></div><div><small>Collected this month</small><strong>₹3.84L</strong><span class="positive">Sample data</span></div></div><div class="mini-report-chart"><div class="mini-report-line"></div><div class="mini-report-bars">${[43,61,53,78,64,88,72].map((h,i)=>`<span style="height:${h}%;${i===5?'background:#6570e8':''}"></span>`).join('')}</div><div class="mini-report-days"><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span></div></div><div class="mini-report-foot"><span>● &nbsp; Attendance trend</span><span>Updated for selected period</span></div></div>`
  }
};

const featureTabs = document.querySelectorAll('.feature-tab');
const previewCategory = document.getElementById('previewCategory');
const previewTitle = document.getElementById('previewTitle');
const previewText = document.getElementById('previewText');
const previewContent = document.getElementById('previewContent');

function selectFeature(key) {
  const item = featureData[key];
  if (!item) return;
  featureTabs.forEach(tab => {
    const active = tab.dataset.feature === key;
    tab.classList.toggle('active', active);
    tab.setAttribute('aria-pressed', String(active));
  });
  previewCategory.textContent = item.category;
  previewTitle.textContent = item.title;
  previewText.textContent = item.text;
  previewContent.style.animation = 'none';
  void previewContent.offsetWidth;
  previewContent.style.animation = 'contentFadeIn 0.35s cubic-bezier(0.16, 1, 0.3, 1)';
  previewContent.innerHTML = item.content + `<div class="table-bottom"><span>Illustrative interface</span><button type="button" id="previewAction">${item.button} <span>→</span></button></div>`;
  const action = document.getElementById('previewAction');
  action.addEventListener('click', () => {
    const labels = {
      students: 'Student profiles, memberships and renewal status are part of StudyCenter Pro.',
      seats: 'The visual seat map illustrates real-time available, occupied and reserved seats.',
      attendance: 'QR check-in validates ID credentials and records instant timestamped logs.',
      fees: 'Invoices, receipt references and automated dues calculation are integrated.',
      reports: 'Real-time analytics cover occupancy rates, revenue collections and attendance trends.'
    };
    showToast(labels[key]);
  });
}
featureTabs.forEach(tab => tab.addEventListener('click', () => selectFeature(tab.dataset.feature)));
featureTabs.forEach(tab => tab.setAttribute('aria-pressed', String(tab.classList.contains('active'))));

// Attach default click handler for first preview tab button
const initialAction = document.getElementById('previewAction');
if (initialAction) {
  initialAction.addEventListener('click', () => {
    showToast('Student profiles, memberships and renewal status are part of StudyCenter Pro.');
  });
}

let toastTimer;
function showToast(message) {
  let toast = document.querySelector('.site-toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.className = 'site-toast';
    toast.setAttribute('role', 'status');
    document.body.appendChild(toast);
  }
  toast.textContent = message;
  toast.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => toast.classList.remove('show'), 3400);
}
  </script>
</body>
</html>
