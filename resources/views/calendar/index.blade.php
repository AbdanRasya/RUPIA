@extends('layouts.app')
@section('title', 'Kalender Keuangan')
@section('header_title', 'Aktivitas Bulanan')
@section('header_subtitle', 'Pantau aktivitas transaksi Anda dalam sebulan')

@section('styles')
@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<style>

.calendar-container{
    background:var(--card-bg);
    border-radius:20px;
    padding:1.5rem;
    border:1px solid var(--border-color);
    box-shadow:0 10px 30px rgba(0,0,0,.05);
}

/* ===== STAT CARDS ===== */

.calendar-stats{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:1rem;
    margin-bottom:1.5rem;
}

.stat-card{
    background:var(--card-bg);
    border:1px solid var(--border-color);
    border-radius:18px;
    padding:1.25rem;
    transition:.25s;
    box-shadow:0 2px 10px rgba(0,0,0,.03);
}

.clickable-card{
    text-decoration:none;
    color:inherit;
    display:block;
    cursor:pointer;
}

.clickable-card:hover{
    transform:translateY(-4px);
}

.clickable-card span,
.clickable-card h3{
    color:inherit;
}

.stat-card:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 25px rgba(0,0,0,.08);
}

.stat-card span{
    display:block;
    font-size:.8rem;
    color:var(--text-muted);
    margin-bottom:.5rem;
}

.stat-card h3{
    font-size:1.5rem;
    font-weight:800;
}

.income{
    border-left:5px solid var(--primary);
}

.expense{
    border-left:5px solid var(--danger);
}

.balance{
    border-left:5px solid var(--accent);
}

.transaction{
    border-left:5px solid var(--warning);
}

.income h3{
    color:var(--primary);
}

.expense h3{
    color:var(--danger);
}

.balance h3{
    color:var(--accent);
}

.transaction h3{
    color:var(--warning);
}

/* ===== FULLCALENDAR ===== */

.fc{
    font-family:'Inter',sans-serif;
}

.fc .fc-toolbar.fc-header-toolbar{
    margin-bottom:1.5rem;
}

.fc-toolbar-title{
    font-size:1.6rem !important;
    font-weight:800 !important;
    color:var(--text-main);
}

/* BUTTON */

.fc .fc-button{
    border:none !important;
    border-radius:12px !important;
    padding:.65rem 1rem !important;
    font-weight:600 !important;
    transition:.2s;
}

.fc .fc-button-primary{
    background:var(--bg-page) !important;
    color:var(--text-main) !important;
}

.fc .fc-button-primary:hover{
    transform:translateY(-2px);
}

.fc .fc-button-primary.fc-button-active,
.fc .fc-button-primary:active{
    background:var(--primary) !important;
    color:#fff !important;
}

/* HEADER HARI */

.fc-theme-standard th{
    background:#f8fafc;
    border:none !important;
    padding:14px 0;
    color:var(--text-muted);
    font-weight:700;
    text-transform:uppercase;
    font-size:.75rem;
}

/* GRID */

.fc-theme-standard td,
.fc-theme-standard th,
.fc-theme-standard .fc-scrollgrid{
    border-color:#edf2f7 !important;
}

.fc-daygrid-day{
    transition:.2s;
}

.fc-daygrid-day:hover{
    background:#f8fafc;
}

/* TANGGAL */

.fc .fc-daygrid-day-number{
    font-weight:700;
    color:var(--text-main);
    margin:6px;
    width:34px;
    height:34px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
}

.fc-day-today{
    background:transparent !important;
}

.fc-day-today .fc-daygrid-day-number{
    background:var(--primary);
    color:white;
    box-shadow:0 0 0 6px rgba(0,165,80,.12);
}

/* EVENT */

.fc-event{
    border:none !important;
    border-radius:8px !important;
    padding:4px 8px !important;
    font-size:.72rem !important;
    font-weight:700 !important;
    transition:.2s;
}

.fc-event:hover{
    transform:translateY(-2px);
}

.fc-event-title{
    overflow:hidden;
    text-overflow:ellipsis;
}

/* MORE LINK */

.fc-daygrid-more-link{
    color:var(--primary);
    font-weight:700;
}

/* MOBILE */

@media(max-width:900px){

    .calendar-stats{
        grid-template-columns:repeat(2,1fr);
    }

}

@media(max-width:768px){

    .fc-toolbar{
        flex-direction:column;
        gap:1rem;
    }

    .fc-toolbar-title{
        font-size:1.2rem !important;
    }

    .fc-daygrid-day-frame{
        min-height:70px !important;
    }

}

@media(max-width:600px){

    .calendar-stats{
        grid-template-columns:1fr;
    }

}

</style>
@endsection

@section('content')
@section('content')

<div class="calendar-stats">

    <div class="stat-card income">
        <span>Pemasukan Bulan Ini</span>
        <h3>Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}</h3>
    </div>

    <div class="stat-card expense">
        <span>Pengeluaran Bulan Ini</span>
        <h3>Rp {{ number_format($totalExpense ?? 0, 0, ',', '.') }}</h3>
    </div>

    <div class="stat-card balance">
        <span>Saldo Bersih</span>
        <h3>Rp {{ number_format($totalBalance ?? 0, 0, ',', '.') }}</h3>
    </div>

    <a href="{{ url('/history') }}" class="stat-card transaction clickable-card">
    <span>Total Transaksi</span>
    <h3>{{ $totalTransactions ?? 0 }}</h3>
</a>

</div>

<div class="calendar-container">
    <div id="calendar"></div>
</div>

@endsection