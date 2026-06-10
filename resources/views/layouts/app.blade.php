<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | @yield('title', 'Manajemen Keuangan')</title>
    <meta name="description" content="@yield('meta_description', 'Rupia membantu kamu mengelola keuangan harian, menabung, merencanakan masa depan, dan memantau transaksi dengan mudah.')">
    <meta name="theme-color" content="#00A550">
    <meta name="robots" content="index,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');

        :root {
            --sidebar-bg: #FAF9F6;
            --sidebar-text: #6B7280;
            --sidebar-active-bg: #FFFFFF;
            --sidebar-active-text: #C5D8A4;
            --sidebar-hover-bg: #E8ECE1;
            --topbar-bg: #FAF9F6;
            --bg-page: #FAF9F6;
            --card-bg: #FFFFFF;
            --primary: #C5D8A4;
            --primary-light: #E8ECE1;
            --primary-dark: #A1B881;
            --accent: #F4DFD0;
            --danger: #FCA5A5;
            --danger-light: #FEE2E2;
            --warning: #FCD34D;
            --warning-light: #FEF3C7;
            --text-main: #4A4A4A;
            --text-muted: #9CA3AF;
            --border-color: #E5E7EB;
            --shadow-sm: 0 4px 10px -2px rgba(0,0,0,0.03);
            --shadow-md: 0 10px 40px -10px rgba(0,0,0,0.05);
            --radius-sm: 12px;
            --radius-md: 20px;
            --radius-lg: 24px;
            --sidebar-w: 220px;
            --topbar-h: 64px;
        }

        [data-theme="dark"] {
            --sidebar-bg: #1F2937;
            --sidebar-text: #9CA3AF;
            --sidebar-active-bg: #374151;
            --sidebar-active-text: #C5D8A4;
            --sidebar-hover-bg: #374151;
            --topbar-bg: #1F2937;
            --bg-page: #111827;
            --card-bg: #1F2937;
            --text-main: #F3F4F6;
            --text-muted: #9CA3AF;
            --border-color: #374151;
            --shadow-sm: 0 4px 10px -2px rgba(0,0,0,0.2);
            --shadow-md: 0 10px 40px -10px rgba(0,0,0,0.3);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Outfit', sans-serif; background: var(--bg-page); color: var(--text-main); display: flex; min-height: 100vh; -webkit-font-smoothing: antialiased; }

        /* Accessibility helpers */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        :focus-visible {
            outline: 3px solid color-mix(in oklab, var(--accent) 70%, white);
            outline-offset: 2px;
        }

        /* ── SIDEBAR ── */
        .sidebar { width: var(--sidebar-w); background: var(--sidebar-bg); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100; overflow-y: auto; border-right: 1px solid var(--border-color); }
        .sidebar-brand { padding: 2rem 1.5rem 1rem; }
        .sidebar-brand a { font-size: 1.5rem; font-weight: 800; color: var(--text-main); text-decoration: none; letter-spacing: -0.5px; }
        .sidebar-brand span { color: var(--primary); }
        .sidebar-section-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; color: var(--text-muted); padding: 1.25rem 1.5rem 0.5rem; }
        .sidebar-nav { padding: 0.5rem 1rem; flex: 1; }
        .nav-item { display: flex; align-items: center; gap: 0.8rem; padding: 0.8rem 1rem; border-radius: var(--radius-sm); color: var(--sidebar-text); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: all 0.3s ease; margin-bottom: 0.2rem; }
        .nav-item:hover { background: var(--sidebar-hover-bg); color: var(--text-main); transform: translateX(4px); }
        .nav-item.active { background: var(--sidebar-active-bg); color: var(--sidebar-active-text); font-weight: 700; box-shadow: var(--shadow-sm); }
        .nav-icon { width: 20px; height: 20px; flex-shrink: 0; }

        /* ── MAIN AREA & PAGE CONTENT ── */
        .main-area { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .page-content { padding: 2rem; flex: 1; }

        /* ── TOPBAR ── */
        .topbar { height: var(--topbar-h); background: var(--topbar-bg); display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; position: sticky; top: 0; z-index: 50; border-bottom: 1px solid var(--border-color); }
        .topbar-left h1 { font-size: 1.2rem; font-weight: 700; color: var(--text-main); }
        .topbar-left p { font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
        .topbar-user { display: flex; align-items: center; gap: 0.6rem; padding: 0.4rem 0.8rem; border-radius: 999px; background: var(--card-bg); box-shadow: var(--shadow-sm); cursor: pointer; border: 1px solid var(--border-color); }
        .topbar-avatar { width: 32px; height: 32px; background: var(--primary-light); color: var(--primary-dark); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; }
        .topbar-name { font-size: 0.85rem; font-weight: 600; }
        .btn-icon-top { width: 38px; height: 38px; border-radius: 50%; background: var(--card-bg); display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text-main); transition: 0.3s; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); }
        .btn-icon-top:hover { transform: translateY(-2px); }

        /* DROPDOWN */
        .dropdown-menu { display: none; position: absolute; top: calc(100% + 0.5rem); right: 0; background: var(--card-bg); border-radius: var(--radius-md); box-shadow: var(--shadow-md); min-width: 200px; padding: 0.5rem; border: 1px solid var(--border-color); z-index: 60; }
        .dropdown-container:hover .dropdown-menu { display: block; animation: fadeIn 0.2s ease; }
        .dropdown-menu a { display: block; padding: 0.6rem 1rem; color: var(--text-main); text-decoration: none; font-size: 0.85rem; border-radius: var(--radius-sm); transition: 0.2s; }
        .dropdown-menu a:hover { background: var(--primary-light); color: var(--primary-dark); }
        .dropdown-divider { height: 1px; background: var(--border-color); margin: 0.4rem 0; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        /* General Utilities */
        .panel { background: var(--card-bg); border-radius: var(--radius-md); padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: var(--shadow-md); transition: transform 0.3s ease, box-shadow 0.3s ease; border: 1px solid var(--border-color); }
        .panel:hover { transform: translateY(-2px); box-shadow: 0 15px 50px -10px rgba(0,0,0,0.08); }
        .panel-title { font-size: 0.9rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.2rem; }
        
        .btn { padding: 0.6rem 1.2rem; border-radius: 999px; font-weight: 600; font-size: 0.85rem; cursor: pointer; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 0.5rem; border: none; }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary { background: var(--primary); color: #FFF; box-shadow: 0 4px 15px rgba(197, 216, 164, 0.4); }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-outline { background: transparent; border: 1px solid var(--border-color); color: var(--text-main); }
        .btn-outline:hover { background: var(--primary-light); color: var(--primary-dark); border-color: var(--primary-light); }
        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { background: #DC2626; }

        /* Forms */
        .form-group { margin-bottom: 1.2rem; }
        .form-label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-main); }
        .form-control { width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--bg-page); color: var(--text-main); font-family: 'Outfit', sans-serif; outline: none; transition: 0.3s; }
        .form-control:focus { background: #FFF; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(197, 216, 164, 0.2); }

        /* Alerts */
        .alert { padding: 1rem 1.25rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; font-size: 0.9rem; display: flex; align-items: center; gap: 0.75rem; font-weight: 500; border: 1px solid transparent; }
        .alert-success { background: var(--primary-light); color: var(--primary-dark); border-color: var(--primary); }
        .alert-error { background: var(--danger-light); color: var(--danger); border-color: var(--danger); }

        /* ── RESPONSIVE ── */
        .topbar-menu { display: none; }
        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(2px);
            z-index: 90;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }

        @media (max-width: 900px) {
            :root { --sidebar-w: 210px; }
            .page-content { padding: 1.25rem; }
            .topbar { padding: 0 1.25rem; }
        }

        @media (max-width: 768px) {
            body { display: block; }
            .topbar-menu { display: inline-flex; }
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.22s ease;
            }
            body.sidebar-open .sidebar { transform: translateX(0); }
            body.sidebar-open .sidebar-backdrop { opacity: 1; pointer-events: auto; }
            .main-area { margin-left: 0; }
            .topbar { padding: 0 1rem; }
            .topbar-right form { display: none !important; }
            .chat-panel { right: 1rem !important; width: calc(100vw - 2rem) !important; max-width: 420px; }
            .chatbot-fab { right: 1rem !important; bottom: 1rem !important; }
        }
        
        @yield('styles')
    </style>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    @yield('head')
</head>
<body>
    <x-sidebar />
    <div class="sidebar-backdrop" id="sidebarBackdrop" aria-hidden="true"></div>

    <div class="main-area">
        <x-topbar />

        <main class="page-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Chatbot FAB (Global) -->
    <div class="chatbot-fab" id="chatbotFab" role="button" tabindex="0" aria-label="Buka chat Rupia AI" title="Tanya AI" style="position:fixed; bottom:2rem; right:2.5rem; width:56px; height:56px; background:var(--primary); color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 16px rgba(0,165,80,0.3); cursor:pointer; z-index:1000; transition:0.3s;">
        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
    </div>

    <!-- Chat Panel -->
    <div class="chat-panel" id="chatPanel" role="dialog" aria-label="Rupia AI Chat" aria-modal="false" style="position:fixed; bottom:6rem; right:2.5rem; width:340px; height:480px; background:var(--card-bg); border:1px solid var(--border-color); border-radius:var(--radius-lg); box-shadow:var(--shadow-md); display:flex; flex-direction:column; z-index:1001; display:none;">
        <div style="background:var(--sidebar-bg); padding:0.85rem 1rem; border-top-left-radius:calc(var(--radius-lg) - 1px); border-top-right-radius:calc(var(--radius-lg) - 1px); display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:0.6rem;">
                <div style="width:30px; height:30px; background:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:700; color:#fff;">AI</div>
                <div>
                    <h4 style="margin:0; font-size:0.85rem; font-weight:600; color:#fff;">Rupia AI</h4>
                    <span style="font-size:0.65rem; color:rgba(255,255,255,0.65); display:block;">Online</span>
                </div>
            </div>
            <button id="closeChatBtn" type="button" aria-label="Tutup chat" style="background:none; border:none; color:#fff; cursor:pointer;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div id="chatMessages" style="flex:1; padding:1rem; overflow-y:auto; display:flex; flex-direction:column; gap:0.75rem; background:var(--bg-page);">
            <div style="max-width:80%; padding:0.65rem 0.85rem; border-radius:var(--radius-md); font-size:0.825rem; line-height:1.4; background:var(--card-bg); color:var(--text-main); align-self:flex-start; border-bottom-left-radius:4px; border:1px solid var(--border-color);">Halo! Ada yang bisa saya bantu seputar keuangan?</div>
        </div>
        <div style="padding:0.75rem; background:var(--card-bg); border-top:1px solid var(--border-color); display:flex; gap:0.5rem; border-bottom-left-radius:calc(var(--radius-lg) - 1px); border-bottom-right-radius:calc(var(--radius-lg) - 1px);">
            <label class="sr-only" for="chatInput">Ketik pesan untuk Rupia AI</label>
            <input type="text" id="chatInput" placeholder="Ketik pesan..." autocomplete="off" style="flex:1; border:1px solid var(--border-color); background:var(--bg-page); color:var(--text-main); padding:0.55rem 0.75rem; border-radius:var(--radius-sm); font-size:0.825rem; outline:none;">
            <button id="sendChatBtn" type="button" aria-label="Kirim pesan" style="background:var(--primary); color:white; border:none; padding:0 0.85rem; border-radius:var(--radius-sm); cursor:pointer;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>
    </div>

    @yield('scripts')
    
    <script>
        // Theme logic
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        const themeBtn = document.getElementById('themeToggle');
        const moonSVG = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>`;
        const sunSVG  = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>`;
        if(themeBtn) {
            themeBtn.innerHTML = savedTheme === 'dark' ? sunSVG : moonSVG;
            themeBtn.addEventListener('click', () => {
                const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', next);
                localStorage.setItem('theme', next);
                themeBtn.innerHTML = next === 'dark' ? sunSVG : moonSVG;
                window.dispatchEvent(new Event('themeChanged'));
            });
        }

        // Mobile sidebar toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function closeSidebar() {
            document.body.classList.remove('sidebar-open');
        }
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-open');
        }
        if (sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
        if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', closeSidebar);
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeSidebar();
        });

        // Global Chatbot Logic
        const chatbotFab = document.getElementById('chatbotFab');
        const chatPanel = document.getElementById('chatPanel');
        const closeChatBtn = document.getElementById('closeChatBtn');
        const chatInput = document.getElementById('chatInput');
        const sendChatBtn = document.getElementById('sendChatBtn');
        const chatMessages = document.getElementById('chatMessages');

        if(chatbotFab && chatPanel) {
            function openChat() {
                chatPanel.style.display = 'flex';
                setTimeout(() => chatInput?.focus(), 0);
            }
            function closeChat() {
                chatPanel.style.display = 'none';
                chatbotFab?.focus?.();
            }
            function toggleChat() {
                const isOpen = chatPanel.style.display === 'flex';
                isOpen ? closeChat() : openChat();
            }

            chatbotFab.addEventListener('click', toggleChat);
            chatbotFab.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleChat();
                }
            });
            closeChatBtn?.addEventListener('click', closeChat);
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeChat();
            });

            function appendMessage(text, type) {
                const div = document.createElement('div');
                div.style.cssText = type === 'user' 
                    ? 'max-width:80%; padding:0.65rem 0.85rem; border-radius:var(--radius-md); font-size:0.825rem; line-height:1.4; background:var(--primary); color:white; align-self:flex-end; border-bottom-right-radius:4px;'
                    : 'max-width:80%; padding:0.65rem 0.85rem; border-radius:var(--radius-md); font-size:0.825rem; line-height:1.4; background:var(--card-bg); color:var(--text-main); align-self:flex-start; border-bottom-left-radius:4px; border:1px solid var(--border-color);';
                div.textContent = text;
                chatMessages.appendChild(div);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function sendMessage() {
                const text = chatInput.value.trim();
                if(!text) return;
                
                appendMessage(text, 'user');
                chatInput.value = '';
                
                fetch('/send-chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: text })
                })
                .then(async (res) => {
                    const contentType = res.headers.get('content-type') || '';
                    if (!res.ok) throw new Error(`HTTP ${res.status}`);
                    if (!contentType.includes('application/json')) throw new Error('Non-JSON response');
                    return res.json();
                })
                .then(data => appendMessage(data?.reply ?? 'Maaf, balasan tidak tersedia.', 'bot'))
                .catch(() => appendMessage('Error koneksi AI. Coba lagi nanti.', 'bot'));
            }

            sendChatBtn.addEventListener('click', sendMessage);
            chatInput.addEventListener('keypress', (e) => { if(e.key === 'Enter') sendMessage(); });
        }
    </script>
</body>
</html>
