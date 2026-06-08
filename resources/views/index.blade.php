@extends('layouts.app')
@section('title', 'Beranda')
@section('header_title')
    Halo, {{ Auth::user()->name ?? 'Pengguna' }} 👋
@endsection
@section('header_subtitle', 'Ringkasan finansialmu hari ini')

@section('content')
<div class="toggle-row panel" style="display:flex; justify-content:space-between; align-items:center; padding:1rem 1.25rem;">
    <div>
        <h4 style="font-size: 0.875rem; font-weight: 600; color: var(--text-main);">Mode Anti-Impuls</h4>
        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;">Verifikasi tambahan sebelum transaksi non-esensial.</p>
    </div>
    <label class="switch" style="width:36px; height:20px; position:relative; display:inline-block;">
        <input type="checkbox" id="impulseToggle" style="opacity:0; width:0; height:0;">
        <span class="slider" style="position:absolute; cursor:pointer; inset:0; background:var(--border-color); transition:.3s; border-radius:20px;"></span>
    </label>
</div>

<div class="main-grid" style="display:grid; grid-template-columns: 2fr 1fr; gap:1.5rem;">
    <section>
        <!-- Balance Card -->
        <div style="background: linear-gradient(135deg, var(--primary) 0%, #0077B6 100%); color: #FFFFFF; border-radius: var(--radius-lg); padding: 1.75rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 8px 24px rgba(0,165,80,0.25); position: relative; overflow: hidden;">
            <div style="position:absolute; top:-40px; right:-40px; width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,0.07);"></div>
            <div style="position:relative; z-index:1;">
                <span style="font-size:0.7rem; font-weight:500; letter-spacing:1px; color:rgba(255,255,255,0.7); display:block; text-transform:uppercase; margin-bottom:0.4rem;">Total Saldo Dompet</span>
                <h2 style="font-size:2.2rem; font-weight:700; letter-spacing:-1px; margin-bottom:0.8rem; line-height:1;">Rp {{ number_format($totalBalance ?? 0, 0, ',', '.') }}</h2>
                
                <div style="display:flex; gap:1.5rem; margin-bottom: 1.25rem;">
                    <div>
                        <span style="font-size:0.65rem; color:rgba(255,255,255,0.7); text-transform:uppercase; letter-spacing:0.5px;">Pengeluaran Bulan Ini</span>
                        <div style="font-size:1rem; font-weight:700; color:#FFA8A8;">Rp {{ number_format($expense ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <span style="font-size:0.65rem; color:rgba(255,255,255,0.7); text-transform:uppercase; letter-spacing:0.5px;">Pemasukan Bulan Ini</span>
                        <div style="font-size:1rem; font-weight:700; color:#A8FFC5;">Rp {{ number_format($income ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div style="display:flex; gap:0.6rem;">
                    <a href="{{ url('/topup') }}" class="btn" style="background:#fff; color:var(--primary-dark);">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> Pemasukan
                    </a>
                    <a href="{{ url('/transaction/create') }}" class="btn" style="background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.3);">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg> Pengeluaran
                    </a>
                </div>
            </div>
            <div style="position:relative; z-index:1; display:flex; flex-direction:column; align-items:flex-end;">
                <div style="font-size:2rem; font-weight:700; color:rgba(255,255,255,0.95); line-height:1;">{{ $healthScore }}</div>
                <div style="font-size:0.65rem; color:rgba(255,255,255,0.6); letter-spacing:0.5px; text-transform:uppercase; margin-top:0.2rem;">Health Score</div>
            </div>
        </div>

        <!-- AI Insight -->
        <div class="panel" style="background:var(--primary-light); border-color:var(--primary); display:flex; gap:1rem; align-items:flex-start;">
            <div style="font-size:1.5rem;">🤖</div>
            <div>
                <h4 style="font-size:0.85rem; font-weight:700; color:var(--primary-dark); margin-bottom:0.25rem;">AI Insight Bulan Ini</h4>
                <p style="font-size:0.8rem; color:var(--text-main);">Pemasukanmu bulan ini Rp {{ number_format($income, 0, ',', '.') }} dan pengeluaran Rp {{ number_format($expense, 0, ',', '.') }}. @if($income > $expense) Bagus! Kamu berhasil surplus. Pertahankan kebiasaan ini! @else Awas, pengeluaranmu lebih besar dari pemasukan. Yuk rem sedikit belanjanya! @endif</p>
            </div>
        </div>

        <!-- Quick Shortcuts -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.875rem; margin-bottom:1.5rem;">
            <a href="{{ url('/transfer') }}" class="panel" style="display:flex; flex-direction:column; align-items:center; padding:1.1rem 0.75rem; text-decoration:none; margin:0;">
                <div style="width:40px; height:40px; background:var(--primary-light); border-radius:10px; display:flex; align-items:center; justify-content:center; color:var(--primary); margin-bottom:0.6rem;"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg></div>
                <span style="font-size:0.75rem; font-weight:600; color:var(--text-main);">Transfer</span>
            </a>
            <a href="{{ url('/budgets') }}" class="panel" style="display:flex; flex-direction:column; align-items:center; padding:1.1rem 0.75rem; text-decoration:none; margin:0;">
                <div style="width:40px; height:40px; background:var(--primary-light); border-radius:10px; display:flex; align-items:center; justify-content:center; color:var(--primary); margin-bottom:0.6rem;"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg></div>
                <span style="font-size:0.75rem; font-weight:600; color:var(--text-main);">Budget</span>
            </a>
            <a href="{{ url('/saving') }}" class="panel" style="display:flex; flex-direction:column; align-items:center; padding:1.1rem 0.75rem; text-decoration:none; margin:0;">
                <div style="width:40px; height:40px; background:var(--primary-light); border-radius:10px; display:flex; align-items:center; justify-content:center; color:var(--primary); margin-bottom:0.6rem;"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
                <span style="font-size:0.75rem; font-weight:600; color:var(--text-main);">Tabung</span>
            </a>
            <a href="{{ url('/history') }}" class="panel" style="display:flex; flex-direction:column; align-items:center; padding:1.1rem 0.75rem; text-decoration:none; margin:0;">
                <div style="width:40px; height:40px; background:var(--primary-light); border-radius:10px; display:flex; align-items:center; justify-content:center; color:var(--primary); margin-bottom:0.6rem;"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <span style="font-size:0.75rem; font-weight:600; color:var(--text-main);">Riwayat</span>
            </a>
        </div>

        <!-- Cashflow Chart -->
        <div class="panel">
            <h3 class="panel-title">Arus Kas (7 Hari Terakhir)</h3>
            <div style="position: relative; height: 220px; width: 100%;">
                <canvas id="cashflowChart"></canvas>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="panel">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                <h3 class="panel-title" style="margin:0;">Transaksi Terakhir</h3>
                <a href="{{ url('/history') }}" style="font-size:0.8rem; color:var(--primary); text-decoration:none; font-weight:600;">Lihat Semua</a>
            </div>
            
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                @forelse($recentTransactions as $trx)
                <div style="display:flex; justify-content:space-between; align-items:center; padding-bottom:0.75rem; border-bottom:1px solid var(--border-color);">
                    <div style="display:flex; gap:0.75rem; align-items:center;">
                        <div style="width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:{{ $trx->type == 'income' ? 'var(--primary-light)' : 'var(--danger-light)' }}; color:{{ $trx->type == 'income' ? 'var(--primary-dark)' : 'var(--danger)' }};">
                            @if($trx->type == 'income')
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                            @else
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"></path></svg>
                            @endif
                        </div>
                        <div>
                            <h4 style="font-size:0.9rem; font-weight:600; color:var(--text-main);">{{ $trx->description ?: $trx->category }}</h4>
                            <span style="font-size:0.75rem; color:var(--text-muted);">{{ \Carbon\Carbon::parse($trx->transaction_date ?: $trx->created_at)->diffForHumans() }} &bull; {{ $trx->wallet ? $trx->wallet->name : '' }}</span>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <span style="font-size:0.9rem; font-weight:700; color:{{ $trx->type == 'income' ? 'var(--primary)' : 'var(--danger)' }};">
                            {{ $trx->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
                @empty
                <p style="font-size:0.8rem; color:var(--text-muted); text-align:center; padding:1rem 0;">Belum ada transaksi.</p>
                @endforelse
            </div>
        </div>
    </section>

    <aside>
        <div class="panel">
            <h3 class="panel-title">Live Market</h3>
            <div style="display:flex; justify-content:space-between; align-items:center; padding:0.7rem 0; border-bottom:1px solid var(--border-color);">
                <span style="font-size:0.825rem; font-weight:500; color:var(--text-muted);">USD / IDR</span>
                <span style="font-size:0.875rem; font-weight:700; color:var(--text-main);">Rp {{ number_format($usdToIdr ?? 15500, 0, ',', '.') }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; padding:0.7rem 0;">
                <span style="font-size:0.825rem; font-weight:500; color:var(--text-muted);">Bitcoin (BTC)</span>
                <span style="font-size:0.875rem; font-weight:700; color:var(--primary);">Rp {{ number_format($btcToIdr ?? 1000000000, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="panel">
            <h3 class="panel-title">Berita Keuangan</h3>
            <div style="display:flex; flex-direction:column; gap:1rem;">
                @forelse($newsList ?? [] as $news)
                    <a href="{{ $news['link'] }}" target="_blank" style="text-decoration:none; display:flex; gap:0.75rem;">
                        <img src="{{ $news['thumbnail'] }}" alt="News" style="width:70px; height:50px; object-fit:cover; border-radius:6px; flex-shrink:0;">
                        <div style="display:flex; flex-direction:column; justify-content:center;">
                            <h4 style="font-size:0.75rem; font-weight:600; color:var(--text-main); margin-bottom:0.2rem; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $news['title'] }}</h4>
                        </div>
                    </a>
                @empty
                    <p style="font-size:0.8rem; color:var(--text-muted); text-align:center;">Tidak ada berita terkini.</p>
                @endforelse
            </div>
        </div>
    </aside>
</div>


@endsection

@section('styles')
<style>
    .slider:before { position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px; background: white; transition: .3s; border-radius: 50%; }
    input:checked + .slider { background: var(--primary); }
    input:checked + .slider:before { transform: translateX(16px); }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Impulse Toggle
    const impulseToggle = document.getElementById('impulseToggle');
    if(impulseToggle) {
        impulseToggle.checked = localStorage.getItem('antiImpulse') === 'true';
        impulseToggle.addEventListener('change', e => localStorage.setItem('antiImpulse', e.target.checked));
    }

    // Chart
    Chart.defaults.color = document.documentElement.getAttribute('data-theme') === 'dark' ? '#94A3B8' : '#6B7280';
    const cashCtx = document.getElementById('cashflowChart').getContext('2d');
    const chart = new Chart(cashCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels ?? []) !!},
            datasets: [
                {
                    label: 'Pemasukan',
                    data: {!! json_encode($incomeData ?? []) !!},
                    borderColor: '#00A550',
                    backgroundColor: 'rgba(0, 165, 80, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Pengeluaran',
                    data: {!! json_encode($expenseData ?? []) !!},
                    borderColor: '#EF4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top', labels: { boxWidth:12, font:{family:'Inter', size:11} } } },
            scales: { y: { beginAtZero: true, grid: { color: 'rgba(150,150,150,0.1)' } }, x: { grid: { display: false } } }
        }
    });

    window.addEventListener('themeChanged', () => {
        Chart.defaults.color = document.documentElement.getAttribute('data-theme') === 'dark' ? '#94A3B8' : '#6B7280';
        chart.update();
    });
</script>
@endsection
