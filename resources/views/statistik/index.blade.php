@extends('layouts.app')
@section('title', 'Statistik & Laporan')
@section('header_title', 'Statistik Pengeluaran')
@section('header_subtitle', 'Analisa kemana uangmu pergi')

@section('content')
<div class="panel" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h2 class="panel-title" style="margin:0;">Laporan Bulan {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}</h2>
    </div>
    <form action="{{ url('/statistik') }}" method="GET" style="display:flex; gap:0.5rem; margin:0;">
        <select name="month" class="form-control" style="width:auto; padding:0.4rem;" onchange="this.form.submit()">
            @for($i=1; $i<=12; $i++)
                <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
            @endfor
        </select>
        <select name="year" class="form-control" style="width:auto; padding:0.4rem;" onchange="this.form.submit()">
            @for($i=date('Y'); $i>=date('Y')-2; $i--)
                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
    </form>
</div>

<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:1.5rem; margin-bottom:1.5rem;">
    <div class="panel" style="margin:0;">
        <div style="font-size:1.5rem; margin-bottom:0.5rem;">💸</div>
        <h3 style="font-size:0.8rem; color:var(--text-muted); font-weight:600; text-transform:uppercase;">Pengeluaran Terbesar</h3>
        @if($biggestExpense)
            <p style="font-size:1.25rem; font-weight:700; color:var(--text-main); margin:0.2rem 0;">Rp {{ number_format($biggestExpense->amount, 0, ',', '.') }}</p>
            <p style="font-size:0.75rem; color:var(--text-muted);">{{ $biggestExpense->description }}</p>
        @else
            <p style="font-size:0.9rem; color:var(--text-muted); margin-top:0.5rem;">Belum ada pengeluaran</p>
        @endif
    </div>

    <div class="panel" style="margin:0;">
        <div style="font-size:1.5rem; margin-bottom:0.5rem;">🔥</div>
        <h3 style="font-size:0.8rem; color:var(--text-muted); font-weight:600; text-transform:uppercase;">Kategori Paling Boros</h3>
        @if($mostExpensiveCategory)
            <p style="font-size:1.25rem; font-weight:700; color:var(--text-main); margin:0.2rem 0;">{{ $mostExpensiveCategory->category }}</p>
            <p style="font-size:0.75rem; color:var(--text-muted);">Total: Rp {{ number_format($mostExpensiveCategory->total, 0, ',', '.') }}</p>
        @else
            <p style="font-size:0.9rem; color:var(--text-muted); margin-top:0.5rem;">Belum ada data</p>
        @endif
    </div>

    <div class="panel" style="margin:0;">
        <div style="font-size:1.5rem; margin-bottom:0.5rem;">📈</div>
        <h3 style="font-size:0.8rem; color:var(--text-muted); font-weight:600; text-transform:uppercase;">Bulan Lalu vs Sekarang</h3>
        <p style="font-size:1.25rem; font-weight:700; color:var(--text-main); margin:0.2rem 0;">Rp {{ number_format($currentMonthExpense, 0, ',', '.') }}</p>
        
        @if($expenseDiff > 0)
            <p style="font-size:0.75rem; color:var(--danger); font-weight:600;">⬆️ Naik Rp {{ number_format($expenseDiff, 0, ',', '.') }} ({{ number_format($expenseDiffPercentage, 1) }}%)</p>
        @elseif($expenseDiff < 0)
            <p style="font-size:0.75rem; color:var(--primary); font-weight:600;">⬇️ Turun Rp {{ number_format(abs($expenseDiff), 0, ',', '.') }} ({{ number_format(abs($expenseDiffPercentage), 1) }}%)</p>
        @else
            <p style="font-size:0.75rem; color:var(--text-muted); font-weight:600;">Sama persis dengan bulan lalu.</p>
        @endif
    </div>
</div>

<div class="panel">
    <h3 class="panel-title">Distribusi Pengeluaran (Bulan Ini)</h3>
    @if(count($chartData) > 0)
        <div style="position:relative; height:300px; width:100%; display:flex; justify-content:center;">
            <canvas id="expenseChart"></canvas>
        </div>
    @else
        <div style="text-align:center; padding:3rem; border:1px dashed var(--border-color); border-radius:var(--radius-sm);">
            <p style="color:var(--text-muted);">Belum ada data pengeluaran untuk bulan ini.</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
@if(count($chartData) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                data: {!! json_encode($chartData) !!},
                backgroundColor: [
                    '#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#EC4899', '#14B8A6'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' }
            },
            cutout: '70%'
        }
    });
</script>
@endif
@endsection
