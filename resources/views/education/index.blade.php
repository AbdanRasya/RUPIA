@extends('layouts.app')
@section('title', 'Edukasi')
@section('header_title', 'Knowledge Base')
@section('header_subtitle', 'Pelajari cara mengelola aset dengan cerdas')

@section('styles')
<style>
    /* ── ACCORDION EDU ── */
    .edu-item { border-bottom: 1px solid var(--border-color); overflow: hidden; }
    .edu-item:last-child { border-bottom: none; }
    .edu-header { display: flex; justify-content: space-between; align-items: center; padding: 1.1rem 0; cursor: pointer; transition: 0.2s; }
    .edu-header:hover h3 { color: var(--primary); }
    .edu-header h3 { font-size: 0.9rem; font-weight: 600; color: var(--text-main); }
    .edu-icon { transition: 0.3s; color: var(--text-muted); flex-shrink: 0; }
    .edu-detail { display: none; font-size: 0.875rem; color: var(--text-muted); line-height: 1.7; padding-bottom: 1.1rem; }

    /* ── INSIGHT CARD ── */
    .insight-card {
        background: var(--primary-light);
        border: 1px solid rgba(0,165,80,0.2);
        border-radius: var(--radius-md);
        padding: 1.5rem;
    }
    .insight-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--primary-dark); margin-bottom: 0.75rem; }
    .insight-quote { font-size: 0.9rem; line-height: 1.65; color: var(--text-main); font-style: italic; }
</style>
@endsection

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    <div class="panel">
        <div class="edu-item" onclick="toggleDetail(this)">
            <div class="edu-header">
                <h3>Kenapa Harus Dana Darurat?</h3>
                <svg class="edu-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
            </div>
            <div class="edu-detail">
                Dana darurat adalah uang yang disimpan khusus untuk kejadian tak terduga (seperti biaya perbaikan motor atau kebutuhan mendesak lainnya). Bagi pelajar atau pekerja magang, idealnya simpan minimal 3-6 bulan pengeluaran bulananmu.
            </div>
        </div>
        <div class="edu-item" onclick="toggleDetail(this)">
            <div class="edu-header">
                <h3>Strategi Alokasi 50/30/20</h3>
                <svg class="edu-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
            </div>
            <div class="edu-detail">
                Bagi pendapatanmu menjadi tiga bagian: 50% untuk kebutuhan pokok (Needs), 30% untuk hiburan atau keinginan (Wants), dan 20% wajib untuk tabungan atau investasi (Savings).
            </div>
        </div>
        <div class="edu-item" onclick="toggleDetail(this)">
            <div class="edu-header">
                <h3>Mengenal Bahaya Inflasi</h3>
                <svg class="edu-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
            </div>
            <div class="edu-detail">
                Inflasi adalah penurunan nilai mata uang seiring berjalannya waktu. Itulah sebabnya menabung di instrumen seperti emas atau aset investasi lainnya lebih baik daripada sekadar menyimpan uang tunai di bawah bantal.
            </div>
        </div>
        <div class="edu-item" onclick="toggleDetail(this)">
            <div class="edu-header">
                <h3>Investasi Reksadana untuk Pemula</h3>
                <svg class="edu-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
            </div>
            <div class="edu-detail">
                Reksadana adalah wadah untuk menghimpun dana dari masyarakat yang kemudian diinvestasikan oleh Manajer Investasi ke dalam portofolio efek. Sangat cocok untuk pemula karena tidak perlu repot menganalisa pasar sendiri dan bisa dimulai dengan modal kecil (mulai Rp10.000).
            </div>
        </div>
        <div class="edu-item" onclick="toggleDetail(this)">
            <div class="edu-header">
                <h3>Perbedaan Tabungan vs Investasi</h3>
                <svg class="edu-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
            </div>
            <div class="edu-detail">
                Tabungan sifatnya menjaga nilai uang agar aman, namun rawan tergerus inflasi karena bunganya rendah. Sementara Investasi bertujuan untuk melipatgandakan uang dan mengalahkan inflasi, namun memiliki tingkat risiko yang lebih tinggi. Gunakan tabungan untuk dana darurat, dan investasi untuk tujuan jangka panjang.
            </div>
        </div>
    </div>

    <aside>
        <div class="insight-card">
            <p class="insight-label">Insight Hari Ini</p>
            <p class="insight-quote">"Jangan menabung apa yang tersisa setelah dibelanjakan, tapi belanjakan apa yang tersisa setelah menabung."</p>
        </div>
    </aside>
</div>
@endsection

@section('scripts')
<script>
    function toggleDetail(panel) {
        const detail = panel.querySelector('.edu-detail');
        const icon = panel.querySelector('.edu-icon');
        const isHidden = window.getComputedStyle(detail).display === 'none';
        detail.style.display = isHidden ? 'block' : 'none';
        icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
    }
</script>
@endsection
