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
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
/* StudyCenter Pro — responsive landing page */
:root{--navy:#101d35;--navy-2:#162744;--ink:#17233a;--muted:#6f7b90;--line:#e8edf4;--paper:#fff;--soft:#f6f8fc;--purple:#5b66e8;--green:#20b783;--font:'DM Sans',sans-serif;--display:'Manrope',sans-serif;--shadow:0 24px 70px rgba(21,39,72,.12)}
*{box-sizing:border-box}html{scroll-behavior:smooth;scroll-padding-top:92px}body{margin:0;font-family:var(--font);color:var(--ink);background:#fff;-webkit-font-smoothing:antialiased}a{color:inherit;text-decoration:none}button{font:inherit}.container{width:min(1180px,calc(100% - 48px));margin:0 auto}.section{padding:108px 0}.section-soft{background:#f7f9fd}.announcement{min-height:35px;background:#111f39;color:#cdd7e9;display:flex;align-items:center;justify-content:center;gap:9px;font-size:11px;letter-spacing:.025em}.announcement-dot,.live-dot{width:7px;height:7px;border-radius:50%;background:#2ad09a;display:inline-block;box-shadow:0 0 0 3px rgba(42,208,154,.13)}.announcement-separator{color:#647591}.site-header{height:78px;background:rgba(255,255,255,.94);border-bottom:1px solid #edf0f5;position:sticky;top:0;z-index:50;backdrop-filter:blur(14px)}.nav{height:100%;display:flex;align-items:center;justify-content:space-between}.brand{display:inline-flex;align-items:center;gap:10px}.brand-mark{width:39px;height:39px;color:var(--navy);display:block}.brand-mark svg{width:100%;height:100%}.brand-name{font:800 18px var(--display);letter-spacing:-.8px;color:#14223b}.brand-name span{color:#5b66e8}.nav-links{display:flex;align-items:center;gap:30px;font-size:12px;font-weight:700;color:#5f6b80}.nav-links>a:not(.nav-cta):hover{color:var(--purple)}.nav-cta{display:inline-flex;align-items:center;gap:10px;padding:12px 18px;background:var(--navy);border-radius:9px;color:white;box-shadow:0 5px 14px #101d3521;transition:.2s;font-size:12px;font-weight:700}.nav-cta:hover{background:#243b60;transform:translateY(-1px);color:#fff}.nav-cta span,.button span{font-size:16px}.menu-toggle{display:none;background:transparent;border:0;padding:8px;cursor:pointer}.menu-toggle span{width:23px;height:2px;background:var(--navy);display:block;margin:5px}
.hero{padding:76px 0 0;position:relative;overflow:hidden;background:radial-gradient(ellipse at 78% 36%,#f0f3ff 0,rgba(246,248,255,.8) 28%,transparent 58%),linear-gradient(180deg,#fff 0%,#fbfcff 100%)}.hero-glow{position:absolute;border-radius:50%;filter:blur(1px);pointer-events:none}.glow-one{width:460px;height:460px;right:-170px;top:20px;background:radial-gradient(circle,#e5eaff 0,rgba(229,234,255,0) 70%)}.glow-two{width:300px;height:300px;left:-190px;top:220px;background:radial-gradient(circle,#e7faf4 0,rgba(231,250,244,0) 70%)}.hero-grid{display:grid;grid-template-columns:.86fr 1.14fr;align-items:center;gap:38px;position:relative;z-index:1}.hero-copy{padding:0 0 38px}.eyebrow{font-size:10px;font-weight:800;letter-spacing:1.7px;color:#6673d9;display:flex;align-items:center;gap:9px;margin-bottom:23px}.eyebrow-icon{width:23px;height:23px;border-radius:7px;display:grid;place-items:center;background:#eef0ff;color:#5b66e8;font-size:14px;letter-spacing:0}.hero h1,.section-heading h2,.security-copy h2,.reports-copy h2,.cta-content h2{font:800 clamp(38px,4.1vw,57px)/1.13 var(--display);letter-spacing:-2.8px;margin:0;color:#13213b}.hero h1 span,.section-heading h2 span,.security-copy h2 span,.reports-copy h2 span{color:#5c68e8}.hero-subtitle{font-size:15px;line-height:1.9;color:#6c788c;max-width:440px;margin:24px 0 28px}.hero-actions{display:flex;align-items:center;gap:13px;flex-wrap:wrap}.button{min-height:48px;padding:0 20px;display:inline-flex;align-items:center;justify-content:center;gap:14px;border-radius:9px;font-size:12px;font-weight:700;transition:transform .2s,box-shadow .2s,background .2s;border:1px solid transparent;cursor:pointer}.button:hover{transform:translateY(-2px)}.button-primary{background:var(--navy);color:#fff;box-shadow:0 9px 18px rgba(16,29,53,.13)}.button-primary:hover{background:#243b60;box-shadow:0 12px 22px rgba(16,29,53,.2);color:#fff}.button-quiet{color:#39475f;background:#fff;border-color:#e7ebf3}.button-quiet:hover{border-color:#b9c0f6}.play-icon{width:23px;height:23px;border-radius:50%;background:#f0f1ff;color:#5965e6;display:grid;place-items:center;font-size:8px;padding-left:2px}.hero-proof{display:flex;align-items:center;gap:12px;margin-top:36px}.proof-avatars{display:flex;padding-left:3px}.proof-avatars span{width:31px;height:31px;margin-left:-3px;border:2px solid #fff;border-radius:50%;display:grid;place-items:center;background:#e6eaff;color:#5a64d8;font-size:9px;font-weight:800}.proof-avatars span:nth-child(2){background:#dff8ed;color:#138b63}.proof-avatars span:nth-child(3){background:#fff0db;color:#b8751a}.hero-proof strong,.hero-proof small{display:block}.hero-proof strong{font-size:11px;color:#2d3a52}.hero-proof small{font-size:10px;color:#8b95a7;margin-top:3px}.hero-trust{margin-top:25px;font-size:10px;color:#758198;display:flex;align-items:center;gap:8px}.hero-trust span{width:17px;height:17px;border-radius:50%;display:grid;place-items:center;color:#12966c;background:#e4f8ef;font-size:10px;font-weight:800}
.dashboard-wrap{position:relative;padding:20px 0 48px 12px;min-width:0}.dashboard-orbit{position:absolute;border:1px solid rgba(101,117,221,.12);border-radius:50%;pointer-events:none}.orbit-a{width:530px;height:530px;right:-90px;top:-20px}.orbit-b{width:440px;height:440px;right:-45px;top:25px}.dashboard{position:relative;z-index:2;display:grid;grid-template-columns:157px minmax(0,1fr);width:100%;min-height:430px;background:white;border:1px solid #e7ebf3;border-radius:15px;overflow:hidden;box-shadow:0 32px 90px rgba(27,43,80,.16);transform:perspective(1300px) rotateY(-2deg) rotateX(1deg)}.dash-sidebar{background:#fbfcff;border-right:1px solid #eef1f6;padding:19px 12px 12px;display:flex;flex-direction:column}.dash-brand{display:flex;align-items:center;gap:7px;font-size:9px;font-weight:800;line-height:1.2;white-space:nowrap;color:#182641;padding:0 2px 25px}.dash-brand small{display:block;color:#99a2b3;font-size:6px;letter-spacing:1px;margin-top:4px}.mini-logo{width:26px;height:26px;border-radius:8px;display:grid;place-items:center;background:#5b66e8;color:#fff;font:800 14px var(--display)}.dash-label{font-size:7px;letter-spacing:1px;color:#a2aabc;font-weight:800;margin:0 0 10px 8px}.dash-link{font-size:8px;font-weight:600;color:#778298;display:flex;align-items:center;gap:9px;padding:10px 8px;border-radius:7px;margin-bottom:3px;white-space:nowrap;cursor:pointer;transition:.2s}.dash-link:hover{background:#f4f6fd;color:#4e5bd4}.dash-link>span{width:12px;text-align:center;font-size:13px}.dash-link.active{color:#4e5bd4;background:#eeefff}.dash-side-bottom{margin-top:auto;border-top:1px solid #e9edf4;padding:13px 0 0;display:flex;align-items:center;gap:6px}.avatar{width:24px;height:24px;border-radius:50%;display:grid;place-items:center;background:#dfe6ff;color:#4e5bd4;font-size:7px;font-weight:800}.dash-side-bottom strong,.dash-side-bottom small{display:block;font-size:7px;white-space:nowrap}.dash-side-bottom small{font-size:6px;color:#929caf;margin-top:3px}.dash-side-bottom>span{margin-left:auto;color:#8b95a7;font-size:11px}.dash-main{padding:20px 17px 12px;min-width:0}.dash-topbar{display:flex;align-items:center;justify-content:space-between;gap:8px}.dash-greeting{font-size:7px;color:#818ca1}.dash-topbar h3{font:800 15px var(--display);letter-spacing:-.5px;margin:5px 0 0;color:#1b2941}.dash-top-actions{display:flex;align-items:center;gap:9px}.dash-date{padding:7px 8px;border:1px solid #e8ecf3;border-radius:6px;font-size:7px;color:#67748a;white-space:nowrap}.bell{position:relative;width:26px;height:26px;border:1px solid #e8ecf3;border-radius:7px;display:grid;place-items:center;font-size:13px;color:#6c7890}.bell i{position:absolute;width:5px;height:5px;border-radius:50%;background:#ee8b63;right:5px;top:4px}.dash-branch{margin:17px 0 12px;padding:8px 9px;background:#f7f8fc;border:1px solid #edf0f6;border-radius:6px;display:flex;align-items:center;gap:4px;font-size:8px;color:#56637b}.dash-branch>span:nth-child(1){margin-left:auto}.dash-branch .live-dot{margin-left:7px;width:5px;height:5px}.dash-branch small{font-size:7px;color:#8994a7}.stat-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:7px}.stat-card{border:1px solid #e9edf4;border-radius:8px;padding:10px 8px;min-width:0}.stat-heading{display:flex;align-items:center;justify-content:space-between;gap:2px;color:#7b879a;font-size:7px;white-space:nowrap}.stat-icon{width:19px;height:19px;border-radius:6px;display:grid;place-items:center;font-size:11px;font-style:normal}.purple{background:#f0efff;color:#646ce1}.blue{background:#e9f3ff;color:#478be0}.green{background:#e5f9f0;color:#159b70}.orange{background:#fff3e6;color:#df8c38}.stat-card>strong{display:block;font:800 18px var(--display);letter-spacing:-.7px;color:#182641;margin:8px 0 6px;white-space:nowrap}.stat-total{font-size:9px;color:#9ca5b4;font-weight:500;letter-spacing:0}.positive{color:#1aab7a!important;font-size:7px;font-weight:800}.positive span{color:#8792a4;font-weight:500}.warning{color:#d98a32!important}.stat-card>small{font-size:7px;color:#8792a4;white-space:nowrap}.progress{height:4px;background:#eef0ff;border-radius:4px;margin:0 0 6px;overflow:hidden}.progress span{height:100%;display:block;background:#6770e9;border-radius:4px}.dash-content-grid{display:grid;grid-template-columns:1.18fr .82fr;gap:9px;margin-top:10px}.dash-panel{border:1px solid #e9edf4;border-radius:8px;padding:12px 10px;min-width:0}.panel-head{display:flex;align-items:flex-start;justify-content:space-between;gap:6px}.panel-head h4{font-size:9px;margin:0;color:#24314a}.panel-head p{font-size:7px;color:#939daf;margin:4px 0 0}.panel-select{border:1px solid #e9edf4;padding:5px;border-radius:5px;font-size:6px;color:#778398;white-space:nowrap}.chart-summary{margin:13px 0 0}.chart-summary strong{display:block;font:800 15px var(--display);color:#24314a}.chart-summary .positive{margin-left:7px}.chart-summary small{font-size:7px;color:#98a2b2}.chart{display:flex;margin-top:9px;height:110px}.chart-y{width:23px;display:flex;flex-direction:column;justify-content:space-between;padding-bottom:15px;color:#a0a8b7;font-size:6px}.chart-area{position:relative;flex:1;min-width:0}.grid-line{position:absolute;left:0;right:0;border-top:1px dashed #e8ecf3}.line1{top:0}.line2{top:27px}.line3{top:54px}.line4{top:81px}.chart-area svg{position:absolute;width:100%;height:87px;top:0;left:0;overflow:visible}.chart-x{position:absolute;left:0;right:0;bottom:0;display:flex;justify-content:space-between;font-size:6px;color:#9ca5b4}.action-count{width:18px;height:18px;border-radius:6px;background:#fff0e8;color:#df8d5a;display:grid;place-items:center;font-size:8px;font-weight:800}.action-row{display:flex;align-items:center;gap:7px;margin-top:14px}.action-ico{width:24px;height:24px;flex:0 0 24px;border-radius:7px;display:grid;place-items:center;font-size:11px}.amber{background:#fff5df;color:#cf982e}.coral{background:#fff0ed;color:#df7d6d}.mint{background:#e6faf2;color:#16a678}.action-row>div{min-width:0;flex:1}.action-row strong,.action-row small{display:block;white-space:nowrap}.action-row strong{font-size:7px;color:#36435b}.action-row small{font-size:6px;color:#929bad;margin-top:4px}.action-arrow{color:#8994a8;font-size:12px}.view-all{display:flex;justify-content:space-between;border-top:1px solid #eef1f6;padding-top:10px;margin-top:12px;font-size:7px;color:#5665d8;font-weight:800}.dash-footer{display:flex;justify-content:space-between;align-items:center;font-size:6px;color:#a1aaba;margin-top:10px}.dash-footer .live-dot{width:5px;height:5px;margin-right:4px}.floating-card{position:absolute;z-index:3;background:#fff;border:1px solid #e8edf5;border-radius:11px;box-shadow:0 14px 38px rgba(31,47,83,.15);display:flex;align-items:center}.qr-float{left:-18px;bottom:24px;padding:11px 13px;gap:10px}.qr-mini{width:35px;height:35px;display:grid;grid-template-columns:repeat(3,1fr);grid-template-rows:repeat(3,1fr);gap:2px;padding:3px;border:1px solid #e8edf5;border-radius:4px}.qr-mini span{background:#202d46}.qr-mini span:nth-child(2),.qr-mini span:nth-child(4),.qr-mini span:nth-child(6){background:#fff;border:1px solid #202d46}.qr-mini i{grid-column:3;grid-row:3;background:#202d46}.qr-float strong,.qr-float small{display:block;white-space:nowrap}.qr-float strong{font-size:10px}.qr-float small{font-size:8px;color:#8994a7;margin-top:4px}.qr-float>b{width:17px;height:17px;border-radius:50%;background:#e4f8ef;color:#13a073;display:grid;place-items:center;font-size:10px;margin-left:4px}.seat-float{right:-16px;top:42%;padding:12px;gap:9px}.seat-float-icon{width:31px;height:31px;border-radius:8px;background:#eff0ff;color:#5b66e8;display:grid;place-items:center;font-size:17px}.seat-float small,.seat-float strong{display:block}.seat-float small{font-size:8px;color:#7f8a9d}.seat-float strong{font:800 15px var(--display);margin-top:3px}.seat-float em{font:700 8px var(--font);color:#18a878}.tiny-bars{height:28px;display:flex;align-items:flex-end;gap:3px;margin-left:6px}.tiny-bars i{width:4px;border-radius:3px 3px 0 0;background:#d4d8ff;height:35%}.tiny-bars i:nth-child(2){height:55%}.tiny-bars i:nth-child(3){height:42%}.tiny-bars i:nth-child(4){height:78%;background:#6972e9}.tiny-bars i:nth-child(5){height:62%}.tiny-bars i:nth-child(6){height:90%;background:#6972e9}.tiny-bars i:nth-child(7){height:72%}.hero-bottom{display:flex;justify-content:space-between;align-items:center;border-top:1px solid #edf0f5;margin-top:23px;padding:24px 0;color:#8b95a8;font-size:9px;letter-spacing:.6px}.hero-bottom>span{font-weight:800;font-size:8px;letter-spacing:1.2px}.hero-bottom>div{display:flex;gap:15px;align-items:center}.hero-bottom i{font-style:normal;color:#b9c1cf}
.section-heading{max-width:650px;margin-bottom:45px}.section-heading.centered{text-align:center;margin-left:auto;margin-right:auto}.section-heading.centered .eyebrow{justify-content:center}.section-heading h2,.security-copy h2,.reports-copy h2{font-size:clamp(32px,3.3vw,44px);letter-spacing:-2px;line-height:1.2}.section-heading p,.security-copy>p,.reports-copy>p{font-size:13px;line-height:1.9;color:#778398;margin:18px 0 0;max-width:580px}.centered p{margin-left:auto;margin-right:auto}.problem-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:15px}.problem-card{padding:25px 23px 26px;background:#fff;border:1px solid #e9edf4;border-radius:13px;transition:transform .2s,box-shadow .2s,border-color .2s}.problem-card:hover{transform:translateY(-4px);box-shadow:0 16px 34px rgba(30,47,81,.07);border-color:#dfe3fa}.problem-icon{width:42px;height:42px;border-radius:12px;display:grid;place-items:center;font-size:20px;margin-bottom:19px}.problem-purple{background:#f0efff;color:#626ce4}.problem-blue{background:#eaf4ff;color:#4b8cdb}.problem-green{background:#e7faf1;color:#169e70}.problem-orange{background:#fff2e5;color:#df8b37}.problem-pink{background:#fff0f3;color:#d96b8a}.problem-teal{background:#e6f8f8;color:#249d9a}.problem-card h3{font:800 14px var(--display);letter-spacing:-.3px;margin:0 0 10px}.problem-card p{font-size:11px;line-height:1.8;color:#7c879a;margin:0;max-width:280px}
.features{background:#fff}.feature-layout{display:grid;grid-template-columns:.86fr 1.14fr;gap:35px;align-items:stretch}.feature-list{display:flex;flex-direction:column;gap:9px}.feature-tab{width:100%;display:flex;align-items:center;text-align:left;gap:13px;padding:17px 14px;border:1px solid transparent;background:#fff;border-radius:11px;cursor:pointer;transition:.2s;color:inherit}.feature-tab:hover{background:#fafbff}.feature-tab.active{background:#f8f9ff;border-color:#e3e6fb;box-shadow:0 5px 18px rgba(39,51,106,.04)}.feature-tab-icon{width:39px;height:39px;flex:0 0 39px;display:grid;place-items:center;border-radius:11px;font-size:18px}.feature-tab>span:nth-child(2){min-width:0;flex:1}.feature-tab strong,.feature-tab small{display:block}.feature-tab strong{font-size:12px;color:#25324a}.feature-tab small{font-size:10px;color:#8a95a8;margin-top:5px}.tab-arrow{font-size:16px;color:#a2abc0;transition:.2s}.feature-tab.active .tab-arrow{color:#5c67e8;transform:translate(2px,-2px)}.feature-preview{border:1px solid #e7ebf3;border-radius:15px;background:linear-gradient(145deg,#fbfcff,#fff);padding:25px;box-shadow:0 20px 55px rgba(23,39,73,.06);min-width:0}.preview-top{display:flex;justify-content:space-between;gap:15px}.preview-kicker{font-size:8px;letter-spacing:1.2px;color:#8792a7;font-weight:800}.preview-kicker span{color:#626de3}.preview-top h3{font:800 20px/1.3 var(--display);letter-spacing:-.8px;margin:13px 0 8px;color:#1a2842}.preview-top p{font-size:10px;line-height:1.7;color:#7e899c;max-width:340px;margin:0 0 22px}.preview-dots{display:flex;gap:4px;padding-top:4px}.preview-dots i{width:5px;height:5px;border-radius:50%;background:#d9deeb}.preview-dots i:first-child{background:#6670e8}.student-table{background:#fff;border:1px solid #e9edf4;border-radius:9px;overflow:hidden}.table-heading,.student-row{display:grid;grid-template-columns:1.45fr 1fr .8fr;gap:7px;align-items:center;padding:12px 10px}.table-heading{background:#fafbfe;border-bottom:1px solid #eef1f6;font-size:7px;font-weight:800;letter-spacing:.7px;color:#929caf}.student-row{border-bottom:1px solid #f0f2f7}.student-row:last-of-type{border-bottom:0}.student-info{display:flex;align-items:center;gap:7px;min-width:0}.student-avatar{width:26px;height:26px;border-radius:8px;display:grid;place-items:center;font-size:7px;font-weight:800;flex:0 0 26px}.avatar-lilac{background:#eeedff;color:#6765c8}.avatar-peach{background:#ffede5;color:#c57a52}.avatar-mint{background:#e4f8ef;color:#24966d}.avatar-blue{background:#e8f2ff;color:#4d7fc4}.student-info strong,.student-info small{display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.student-info strong{font-size:8px;color:#36435a}.student-info small{font-size:7px;color:#a0a9b8;margin-top:3px}.membership{font-size:8px;color:#647087;white-space:nowrap}.status-pill{font-size:7px;padding:5px 6px;border-radius:5px;text-align:center;white-space:nowrap}.status-active{background:#e6f8f0;color:#149a6c}.status-due{background:#fff4df;color:#b98126}.table-bottom{display:flex;justify-content:space-between;align-items:center;padding:12px 10px;background:#fbfcfe;border-top:1px solid #edf0f5;font-size:8px;color:#929caf}.table-bottom button{border:0;background:transparent;color:#5965d8;font-size:8px;font-weight:800;cursor:pointer}.table-bottom button span{margin-left:7px}.preview-note{margin-top:17px;display:flex;align-items:center;gap:8px;color:#7e899d;font-size:9px}.preview-note span{color:#6670e8;font-size:14px}
.section-dark{background:#111f39;color:#fff;position:relative;overflow:hidden}.section-dark:before,.section-dark:after{content:"";position:absolute;border:1px solid #ffffff0d;border-radius:50%;width:560px;height:560px;pointer-events:none}.section-dark:before{top:-300px;left:-130px}.section-dark:after{bottom:-380px;right:-80px}.journey .section-heading{position:relative;z-index:1}.eyebrow-light{color:#a8b1ff}.journey .section-heading h2{color:#fff}.journey .section-heading h2 span{color:#9da6ff}.journey .section-heading p{color:#a6b2c7}.journey-track{display:grid;grid-template-columns:1fr 18px 1fr 18px 1fr 18px 1fr 18px 1fr;gap:10px;align-items:start;position:relative;z-index:1}.journey-step{min-width:0}.journey-number{font:700 10px var(--display);color:#8794b0;letter-spacing:1px;margin-bottom:20px}.journey-icon{width:49px;height:49px;border:1px solid #ffffff21;background:#ffffff0b;border-radius:14px;display:grid;place-items:center;color:#a9b0ff;font-size:22px;margin-bottom:17px}.journey-step h3{font:800 13px var(--display);margin:0 0 9px;color:#fff}.journey-step p{font-size:10px;line-height:1.8;color:#a6b2c7;margin:0}.journey-connector{padding-top:64px;color:#6b7897;font-size:17px}.journey-callout{margin-top:47px;position:relative;z-index:1;border:1px solid #ffffff18;border-radius:12px;background:#ffffff08;padding:19px 22px;display:flex;align-items:center;gap:15px}.callout-spark{font-size:22px;color:#a5adff}.journey-callout p{font-size:10px;line-height:1.8;color:#aeb9cd;margin:0;flex:1}.journey-callout strong{font-size:12px;color:#fff}.callout-check{width:25px;height:25px;border-radius:50%;background:#173f45;color:#61e0b4;display:grid;place-items:center;font-size:12px}
.security-grid{display:grid;grid-template-columns:1fr .92fr;gap:80px;align-items:center}.security-copy h2{font-size:clamp(32px,3.3vw,43px)}.security-points{display:grid;gap:20px;margin:29px 0 26px}.security-points>div{display:flex;align-items:flex-start;gap:12px}.check-round{width:22px;height:22px;border-radius:50%;background:#e6f8f0;color:#159b70;display:grid;place-items:center;font-size:11px;flex:0 0 22px}.security-points strong,.security-points small{display:block}.security-points strong{font-size:12px;color:#2a3851}.security-points small{font-size:10px;line-height:1.7;color:#8a95a8;margin-top:5px}.text-link{display:inline-flex;align-items:center;gap:13px;color:#5864dc;font-size:11px;font-weight:800}.text-link span{font-size:16px}.roles-card{border:1px solid #e7ebf3;border-radius:15px;background:#fff;padding:22px;box-shadow:0 25px 65px rgba(25,43,79,.08)}.roles-card-head{display:flex;align-items:center;gap:11px;padding-bottom:18px;border-bottom:1px solid #eef1f6}.roles-shield{width:38px;height:38px;border-radius:11px;background:#eeefff;color:#5c68e8;display:grid;place-items:center;font-size:21px}.roles-card-head h3{font:800 14px var(--display);margin:0;color:#23314a}.roles-card-head p{font-size:9px;color:#8b96a8;margin:5px 0 0}.roles-menu{margin-left:auto;color:#8e99ab;font-size:18px}.role-row{display:flex;align-items:center;gap:10px;padding:15px 0;border-bottom:1px solid #f0f2f7}.role-avatar{width:31px;height:31px;border-radius:9px;display:grid;place-items:center;font-size:10px;font-weight:800;flex:0 0 31px}.role-admin{background:#eceeff;color:#5b65d7}.role-owner{background:#e5f8f0;color:#188c69}.role-manager{background:#e9f3ff;color:#4887cf}.role-staff{background:#fff2e5;color:#c78236}.role-student{background:#f2ecff;color:#8660ce}.role-row>div{flex:1;min-width:0}.role-row strong,.role-row small{display:block}.role-row strong{font-size:10px;color:#36435a}.role-row small{font-size:8px;color:#939daf;margin-top:4px}.role-tag{font-size:8px;color:#78849a;background:#f5f7fb;padding:6px 8px;border-radius:6px;white-space:nowrap}.roles-foot{display:flex;align-items:center;gap:8px;padding-top:17px;font-size:8px;line-height:1.6;color:#7e899d}.lock-icon{font-size:15px;color:#5b66e8}
.reports-grid{display:grid;grid-template-columns:.9fr 1.1fr;gap:80px;align-items:center}.reports-copy .button{margin-top:28px}.report-list{list-style:none;padding:0;margin:23px 0 0;display:grid;gap:13px}.report-list li{display:flex;align-items:center;gap:10px;color:#526078;font-size:11px}.report-list li span{width:18px;height:18px;border-radius:50%;display:grid;place-items:center;background:#e5f8ef;color:#1aa074;font-size:10px}.reports-visual{position:relative;padding:12px 12px 26px 0}.report-window{border:1px solid #e6eaf2;border-radius:15px;background:#fff;padding:23px;box-shadow:0 25px 70px rgba(22,40,76,.1);position:relative;z-index:1}.report-window-head{display:flex;justify-content:space-between;align-items:center;gap:10px}.report-eyebrow{font-size:7px;font-weight:800;letter-spacing:1.3px;color:#8994a8}.report-window-head h3{font:800 17px var(--display);letter-spacing:-.5px;margin:7px 0 0;color:#24324a}.report-period{padding:8px 10px;border:1px solid #e9edf4;border-radius:7px;font-size:8px;color:#7b879b;white-space:nowrap}.collection-total{margin-top:25px;display:flex;justify-content:space-between;align-items:center}.collection-total small,.collection-total strong,.collection-total span{display:block}.collection-total small{font-size:9px;color:#8590a4}.collection-total strong{font:800 28px var(--display);letter-spacing:-1.2px;margin:5px 0}.collection-total .positive{font-size:8px}.collection-icon{width:42px;height:42px;border-radius:12px;background:#e7f8f0;color:#1aa274;display:grid;place-items:center;font-size:20px}.bar-chart{display:flex;height:175px;margin-top:24px}.bar-y{width:39px;display:flex;flex-direction:column;justify-content:space-between;padding-bottom:24px;color:#a1aabb;font-size:8px}.bar-area{position:relative;flex:1;display:flex;flex-direction:column;justify-content:space-between;padding-bottom:24px}.bar-grid{height:1px;width:100%;border-top:1px dashed #e8ecf3}.bars{position:absolute;inset:0 9px 24px;display:flex;align-items:flex-end;justify-content:space-around;gap:12px}.bars>div{width:min(32px,12%);min-width:15px;border-radius:5px 5px 0 0;background:#dfe3ff;position:relative;transition:height .4s}.bars>div.bar-current{background:linear-gradient(180deg,#7881f0,#5965dd)}.bars i{position:absolute;bottom:-21px;left:50%;transform:translateX(-50%);font-style:normal;font-size:8px;color:#8e99ac}.report-bottom{display:flex;gap:25px;border-top:1px solid #edf0f5;padding-top:17px;margin-top:3px}.report-bottom>div{display:grid;grid-template-columns:8px auto;column-gap:7px;row-gap:5px;align-items:center}.report-bottom span:nth-child(2){font-size:8px;color:#8b96a8}.report-bottom strong{grid-column:2;font:800 12px var(--display);color:#34425a}.legend-dot{width:7px;height:7px;border-radius:2px;grid-row:span 2}.collection-dot{background:#626de7}.due-dot{background:#dce1f2}.report-floating{position:absolute;z-index:2;right:-28px;bottom:0;background:#fff;border:1px solid #e7ebf3;border-radius:11px;box-shadow:0 15px 40px rgba(22,40,76,.13);padding:13px 16px;display:flex;align-items:center;gap:10px}.report-float-icon{width:30px;height:30px;border-radius:9px;background:#e7f8f0;color:#1aa274;display:grid;place-items:center;font-size:15px}.report-floating small,.report-floating strong{display:block}.report-floating small{font-size:8px;color:#8b96a8}.report-floating strong{font-size:10px;color:#34425a;margin-top:4px}
.cta-section{padding-top:35px;padding-bottom:75px}.cta-card{border-radius:20px;background:#111f39;position:relative;overflow:hidden;padding:55px 58px;display:grid;grid-template-columns:1fr .62fr;gap:45px;color:#fff}.cta-decoration{position:absolute;border:1px solid #ffffff0d;border-radius:50%;pointer-events:none}.deco-one{width:420px;height:420px;right:80px;top:-300px}.deco-two{width:330px;height:330px;right:-80px;bottom:-240px}.cta-content,.cta-side{position:relative;z-index:1}.cta-content .eyebrow{margin-bottom:17px}.cta-content h2{font-size:clamp(32px,3.5vw,45px);color:#fff;letter-spacing:-2px}.cta-content h2 span{color:#a4adff}.cta-content p{font-size:12px;line-height:1.8;color:#b0bdd1;max-width:440px;margin:17px 0 24px}.cta-actions{display:flex;flex-wrap:wrap;gap:10px}.button-white{background:#fff;color:#15233e}.button-white:hover{background:#f0f2ff;color:#15233e}.button-outline{border-color:#ffffff38;color:#e1e7f3;background:transparent}.button-outline:hover{background:#ffffff0c}.cta-disclaimer{display:block;font-size:8px;color:#8291ad;margin-top:22px}.cta-side{display:flex;flex-direction:column;justify-content:center;gap:12px}.cta-check-card{display:flex;align-items:center;gap:12px;padding:15px 16px;border:1px solid #ffffff1c;border-radius:11px;background:#ffffff08}.cta-check-icon{width:32px;height:32px;border-radius:9px;background:#ffffff12;color:#aab2ff;display:grid;place-items:center;font-size:17px}.cta-check-card strong,.cta-check-card small{display:block}.cta-check-card strong{font-size:11px}.cta-check-card small{font-size:9px;color:#a6b3c9;margin-top:5px}
.footer{border-top:1px solid #edf0f5;background:#fff}.footer-main{min-height:100px;display:flex;align-items:center;gap:26px}.footer-brand .brand-mark{width:31px;height:31px}.footer-brand .brand-name{font-size:15px}.footer-main>p{font-size:10px;color:#8a95a8;margin:0}.footer-links{margin-left:auto;display:flex;gap:23px;font-size:10px;color:#68758b;font-weight:700}.footer-links a:hover{color:#5b66e8}.footer-bottom{border-top:1px solid #f0f2f6;min-height:49px;display:flex;align-items:center;justify-content:space-between;font-size:9px;color:#a0a9b8}.back-to-top{position:fixed;right:22px;bottom:22px;width:39px;height:39px;border:0;border-radius:11px;background:#15233e;color:white;font-size:19px;box-shadow:0 8px 25px #15233e2b;cursor:pointer;opacity:0;pointer-events:none;transform:translateY(8px);transition:.2s;z-index:40}.back-to-top.visible{opacity:1;pointer-events:auto;transform:translateY(0)}

/* Dynamic Preview & Interactive Components Styles */
.seat-preview,.attendance-preview,.invoice-preview,.mini-report{background:#fff;border:1px solid #e9edf4;border-radius:9px;padding:15px}
.seat-preview-head,.id-top,.id-bottom,.invoice-top,.invoice-line,.invoice-total,.mini-report-foot{display:flex;justify-content:space-between;align-items:center;gap:8px}
.seat-preview-head{font-size:8px;font-weight:800;color:#67748a}.seat-preview-head span:last-child{font-weight:600;color:#8994a7}
.seat-legend{display:flex;gap:13px;flex-wrap:wrap;margin:16px 0 12px;font-size:8px;color:#7e899d}.seat-legend span{display:flex;align-items:center;gap:5px}.seat-legend i{width:8px;height:8px;border-radius:3px;display:inline-block}.seat-free{background:#e8f8f0}.seat-taken{background:#6872e9}.seat-reserved{background:#ffe9cb}
.seat-grid{display:grid;grid-template-columns:repeat(8,1fr);gap:7px}.seat{aspect-ratio:1;display:grid;place-items:center;border:1px solid #dcefe5;border-radius:5px;background:#effaf4;color:#37916f;font-size:8px}.seat.taken{background:#6872e9;border-color:#6872e9;color:#fff}.seat.reserved{background:#fff0d8;border-color:#ffe3b3;color:#b77c24}.seat.selected{outline:2px solid #192b49;outline-offset:2px}.seat-selected{margin-top:16px;border-top:1px solid #eef1f6;padding-top:12px;display:flex;align-items:center;justify-content:space-between;gap:8px}.seat-selected b,.seat-selected small{display:block}.seat-selected b{font-size:10px}.seat-selected small{font-size:8px;color:#8a95a8;margin-top:4px}
.id-top{font-size:7px;letter-spacing:1px;font-weight:800;color:#6c7890}.id-active{background:#e5f8ef;color:#149b6e;padding:5px 7px;border-radius:5px;font-size:6px}.id-body{display:flex;align-items:center;gap:10px;padding:22px 0}.id-avatar{width:43px;height:43px;border-radius:11px;background:#eeedff;color:#6668d3;display:grid;place-items:center;font-size:13px;font-weight:800}.id-body>div:nth-child(2){flex:1}.id-body strong,.id-body small{display:block}.id-body strong{font-size:11px}.id-body small{font-size:8px;color:#8792a6;margin-top:5px}.fake-qr{width:47px;height:47px;display:grid;grid-template-columns:repeat(5,1fr);grid-template-rows:repeat(5,1fr);gap:2px;padding:3px;border:1px solid #e8edf4}.fake-qr i{background:#263650}.fake-qr i:nth-child(3n){background:#fff;border:1px solid #263650}.id-bottom{border-top:1px solid #eef1f6;padding-top:12px;font-size:8px;color:#8792a6}.id-bottom strong{color:#33415a}.checkin-success{display:flex;align-items:center;gap:10px;background:#eaf9f2;border:1px solid #d8f3e7;border-radius:8px;padding:12px;margin-top:12px}.checkin-success>span{width:26px;height:26px;border-radius:50%;background:#c9f0df;color:#138d63;display:grid;place-items:center}.checkin-success strong,.checkin-success small{display:block}.checkin-success strong{font-size:9px;color:#23775a}.checkin-success small{font-size:8px;color:#60937e;margin-top:4px}
.invoice-label{font-size:7px;letter-spacing:1.2px;color:#8994a7;font-weight:800}.invoice-top h4{font:800 14px var(--display);margin:5px 0 0}.invoice-student{display:flex;align-items:center;gap:9px;background:#f8f9fc;border-radius:7px;padding:10px;margin:15px 0}.invoice-student strong,.invoice-student small{display:block}.invoice-student strong{font-size:9px}.invoice-student small{font-size:8px;color:#8b96a8;margin-top:4px}.invoice-line{font-size:9px;color:#7e899d;padding:9px 1px;border-bottom:1px solid #f0f2f7}.invoice-line strong{color:#35425a}.invoice-total{padding:14px 1px 10px;font-size:10px;font-weight:700}.invoice-total strong{font:800 18px var(--display)}.invoice-payment{padding:10px;border-radius:7px;background:#eaf9f2;color:#16885f;font-size:8px}
.mini-report-stats{display:grid;grid-template-columns:1fr 1fr;gap:10px}.mini-report-stats>div{padding:11px;background:#f9faff;border:1px solid #edf0f6;border-radius:7px}.mini-report-stats small,.mini-report-stats strong,.mini-report-stats span{display:block}.mini-report-stats small{font-size:8px;color:#8792a6}.mini-report-stats strong{font:800 22px var(--display);margin:7px 0 4px}.mini-report-stats span{font-size:7px;color:#8b96a8}.mini-report-chart{height:130px;position:relative;margin-top:18px;background:repeating-linear-gradient(to bottom,transparent 0,transparent 31px,#edf0f6 32px)}.mini-report-bars{position:absolute;inset:0 8px 20px;display:flex;align-items:flex-end;justify-content:space-around;gap:10px}.mini-report-bars span{width:9%;border-radius:4px 4px 0 0;background:#dfe3ff}.mini-report-days{position:absolute;bottom:0;left:5px;right:5px;display:flex;justify-content:space-around;font-size:7px;color:#929caf}.mini-report-foot{border-top:1px solid #eef1f6;padding-top:12px;margin-top:4px;font-size:7px;color:#8994a7}.mini-report-foot span:first-child{color:#626de7}
.site-toast{position:fixed;z-index:100;left:50%;bottom:24px;transform:translate(-50%,15px);opacity:0;pointer-events:none;max-width:min(520px,calc(100% - 32px));padding:13px 18px;border-radius:10px;background:#14223d;color:#fff;font-size:12px;line-height:1.6;box-shadow:0 12px 35px #101d3533;transition:opacity .2s,transform .2s}.site-toast.show{opacity:1;transform:translate(-50%,0)}

@media(min-width:1400px){.hero{padding-top:90px}.dashboard{min-height:455px}.dash-main{padding:23px 19px 14px}.stat-card{padding:12px 9px}.chart{height:120px}.chart-area svg{height:97px}}
@media(max-width:1100px){.hero-grid{grid-template-columns:.85fr 1.15fr;gap:18px}.hero h1{font-size:46px}.dashboard{grid-template-columns:135px minmax(0,1fr)}.dash-main{padding:17px 12px 10px}.dash-sidebar{padding:17px 9px 10px}.stat-heading{font-size:6px}.stat-card>strong{font-size:15px}.seat-float{right:-9px}.feature-layout{gap:22px}.security-grid,.reports-grid{gap:45px}.cta-card{padding:48px 42px;gap:30px}}
@media(max-width:850px){.section{padding:82px 0}.hero{padding-top:57px}.hero-grid{grid-template-columns:1fr;gap:8px}.hero-copy{max-width:650px;padding-bottom:5px}.hero h1{font-size:clamp(42px,7vw,58px)}.hero-subtitle{max-width:560px}.dashboard-wrap{width:min(680px,100%);margin:0 auto;padding:22px 8px 47px}.dashboard{transform:none;min-height:430px}.hero-bottom{margin-top:5px}.problem-grid{grid-template-columns:repeat(2,1fr)}.feature-layout{grid-template-columns:1fr}.feature-list{display:grid;grid-template-columns:repeat(2,1fr)}.feature-tab{padding:13px 10px}.feature-preview{margin-top:4px}.journey-track{grid-template-columns:repeat(5,1fr);gap:17px}.journey-connector{display:none}.journey-step p{font-size:9px}.security-grid,.reports-grid{grid-template-columns:1fr;gap:42px}.security-copy{max-width:620px}.roles-card{max-width:590px;width:100%;margin:0 auto}.reports-copy{max-width:620px}.reports-visual{max-width:620px;width:100%;margin:0 auto}.cta-card{grid-template-columns:1fr .7fr;gap:25px;padding:42px 32px}.footer-main{flex-wrap:wrap;padding:24px 0;gap:14px}.footer-main>p{flex:1;min-width:190px}.footer-links{width:100%;margin:6px 0 0}}
@media(max-width:600px){.container{width:calc(100% - 34px)}.announcement{font-size:9px;padding:0 10px;text-align:center;min-height:33px}.site-header{height:67px}.brand-mark{width:34px;height:34px}.brand-name{font-size:16px}.menu-toggle{display:block}.nav-links{display:none;position:absolute;left:0;right:0;top:66px;background:#fff;border-bottom:1px solid #e8edf4;padding:14px 22px 20px;flex-direction:column;align-items:stretch;gap:0;box-shadow:0 18px 30px #15233e12}.nav-links.open{display:flex}.nav-links>a:not(.nav-cta){padding:14px 4px;border-bottom:1px solid #f0f2f7}.nav-cta{justify-content:center;margin-top:13px}.section{padding:69px 0}.hero{padding-top:43px}.eyebrow{font-size:8px;letter-spacing:1.2px;margin-bottom:17px}.hero h1{font-size:39px;letter-spacing:-2px}.hero-subtitle{font-size:13px;line-height:1.8;margin:17px 0 22px}.hero-actions{gap:9px}.button{min-height:45px;padding:0 13px;font-size:10px;gap:10px}.hero-proof{margin-top:25px}.hero-trust{margin-top:18px;font-size:9px}.dashboard-wrap{padding:20px 0 43px}.dashboard{grid-template-columns:94px minmax(0,1fr);border-radius:11px;min-height:340px}.dash-sidebar{padding:13px 6px 8px}.dash-brand{gap:4px;font-size:7px;padding-bottom:19px;white-space:normal}.dash-brand small{font-size:5px}.mini-logo{width:21px;height:21px;flex:0 0 21px}.dash-label{font-size:5px;margin-left:5px}.dash-link{font-size:6px;gap:4px;padding:9px 4px}.dash-link>span{font-size:10px;width:10px}.dash-side-bottom{gap:4px}.avatar{width:19px;height:19px;font-size:6px}.dash-side-bottom strong{font-size:5px}.dash-side-bottom small{font-size:5px}.dash-side-bottom>span{font-size:8px}.dash-main{padding:12px 7px 8px}.dash-greeting{font-size:6px}.dash-topbar h3{font-size:11px}.dash-date{font-size:5px;padding:5px}.dash-top-actions{gap:4px}.bell{width:20px;height:20px;font-size:10px}.dash-branch{font-size:6px;margin:11px 0 7px;padding:6px 5px;flex-wrap:wrap}.dash-branch small{font-size:5px}.stat-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:5px}.stat-card{padding:7px 6px}.stat-heading{font-size:6px}.stat-icon{width:15px;height:15px;font-size:9px}.stat-card>strong{font-size:14px;margin:5px 0}.stat-card>small{font-size:6px}.positive{font-size:6px}.dash-content-grid{grid-template-columns:1fr;gap:6px;margin-top:7px}.dash-panel{padding:8px}.action-panel{display:none}.panel-head h4{font-size:8px}.panel-head p{font-size:6px}.chart-summary{margin-top:8px}.chart-summary strong{font-size:12px}.chart{height:78px;margin-top:5px}.chart-y{font-size:5px;width:17px}.chart-area svg{height:61px}.chart-x{font-size:5px}.dash-footer{font-size:5px;margin-top:7px}.floating-card{transform:scale(.8)}.qr-float{left:-24px;bottom:12px;transform-origin:left bottom}.seat-float{right:-20px;top:44%;transform-origin:right center}.hero-bottom{display:block;padding:18px 0;margin-top:3px}.hero-bottom>span{display:block;margin-bottom:12px}.hero-bottom>div{gap:8px;flex-wrap:wrap;font-size:8px}.section-heading{margin-bottom:30px}.section-heading h2,.security-copy h2,.reports-copy h2{font-size:32px;letter-spacing:-1.5px}.section-heading p,.security-copy>p,.reports-copy>p{font-size:12px}.problem-grid{grid-template-columns:1fr;gap:10px}.problem-card{padding:19px}.problem-icon{margin-bottom:13px;width:37px;height:37px}.problem-card h3{font-size:13px}.problem-card p{font-size:10px;max-width:none}.feature-list{grid-template-columns:1fr;gap:5px}.feature-tab{padding:12px 10px}.feature-tab-icon{width:34px;height:34px;flex-basis:34px;font-size:16px}.feature-tab strong{font-size:11px}.feature-tab small{font-size:9px}.feature-preview{padding:16px 11px}.preview-top h3{font-size:17px}.preview-top p{font-size:9px}.table-heading,.student-row{grid-template-columns:1.3fr .8fr .72fr;gap:4px;padding:10px 6px}.table-heading{font-size:6px}.student-info{gap:4px}.student-avatar{width:21px;height:21px;flex-basis:21px;font-size:6px}.student-info strong{font-size:7px}.student-info small{font-size:6px}.membership{font-size:6px}.status-pill{font-size:6px;padding:4px 3px}.table-bottom{font-size:7px;padding:10px 6px}.table-bottom button{font-size:7px}.journey-track{grid-template-columns:repeat(2,1fr);gap:24px 17px}.journey-step:nth-of-type(5){grid-column:1}.journey-number{margin-bottom:12px}.journey-icon{width:42px;height:42px;margin-bottom:12px}.journey-step h3{font-size:12px}.journey-step p{font-size:9px}.journey-callout{margin-top:30px;padding:15px 13px;gap:9px}.journey-callout p{font-size:9px}.journey-callout strong{font-size:10px}.callout-spark{font-size:18px}.callout-check{width:22px;height:22px;flex:0 0 22px}.roles-card{padding:15px}.roles-card-head h3{font-size:12px}.role-row{gap:7px;padding:12px 0}.role-avatar{width:27px;height:27px;flex-basis:27px}.role-row strong{font-size:9px}.role-row small{font-size:7px}.role-tag{font-size:7px;padding:5px}.roles-foot{font-size:7px}.report-window{padding:16px 12px}.report-window-head h3{font-size:15px}.report-period{font-size:7px;padding:7px}.collection-total strong{font-size:23px}.collection-icon{width:36px;height:36px}.bar-chart{height:150px}.bars{gap:7px}.report-floating{right:-3px;padding:10px 12px}.cta-section{padding-top:10px;padding-bottom:45px}.cta-card{grid-template-columns:1fr;padding:31px 21px;gap:25px;border-radius:15px}.cta-content h2{font-size:33px;letter-spacing:-1.6px}.cta-content p{font-size:11px}.cta-actions{flex-direction:column;align-items:stretch}.cta-actions .button{width:100%}.cta-side{display:grid;grid-template-columns:1fr;gap:8px}.cta-check-card{padding:11px}.footer-main{gap:12px}.footer-main>p{font-size:9px;min-width:100%;margin:0}.footer-links{gap:16px;flex-wrap:wrap;font-size:9px}.footer-bottom{align-items:flex-start;justify-content:center;flex-direction:column;gap:7px;padding:13px 0;font-size:8px}.back-to-top{right:13px;bottom:13px;width:35px;height:35px}
.seat-preview,.attendance-preview,.invoice-preview,.mini-report{padding:10px}.seat-grid{gap:4px}.seat{font-size:7px}.seat-legend{gap:8px;font-size:7px}.id-body{gap:7px}.id-avatar{width:34px;height:34px}.fake-qr{width:39px;height:39px}.mini-report-stats strong{font-size:18px}}
@media(prefers-reduced-motion:reduce){*,*::before,*::after{scroll-behavior:auto!important;transition:none!important;animation:none!important}}
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
