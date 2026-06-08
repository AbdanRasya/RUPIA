@extends('layouts.app')
@section('title', 'Kalender Keuangan')
@section('header_title', 'Kalender Keuangan')
@section('header_subtitle', 'Lihat semua transaksi berdasarkan tanggal')

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    .fc-theme-standard td, .fc-theme-standard th { border-color: var(--border-color); }
    .fc-day-today { background: var(--primary-light) !important; }
    .fc .fc-toolbar-title { font-size: 1.25em; font-weight: 700; color: var(--text-main); }
    .fc .fc-button-primary { background: var(--primary); border-color: var(--primary); }
    .fc .fc-button-primary:not(:disabled):active, .fc .fc-button-primary:not(:disabled).fc-button-active { background: var(--primary-dark); border-color: var(--primary-dark); }
    .fc-event { border:none; padding:2px 4px; border-radius:4px; font-size:0.75rem; font-weight:600; cursor:pointer; }
</style>
@endsection

@section('content')
<div class="panel">
    <div id='calendar'></div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/api/calendar/events',
            eventDidMount: function(info) {
                // Tambahkan tooltip judul
                info.el.title = info.event.extendedProps.description + " | " + info.event.title;
            }
        });
        calendar.render();
    });
</script>
@endsection
