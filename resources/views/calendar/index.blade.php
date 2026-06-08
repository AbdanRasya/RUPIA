@extends('layouts.app')
@section('title', 'Kalender Keuangan')
@section('header_title', 'Kalender Keuangan')
@section('header_subtitle', 'Pantau aktivitas transaksi Anda dalam sebulan')

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    .calendar-container {
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        margin-bottom: 2rem;
    }

    /* Reset some table styles that might conflict with app layout */
    #calendar table { margin: 0; border-collapse: collapse; }
    
    /* Header Toolbar Styling */
    .fc .fc-toolbar.fc-header-toolbar {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px dashed var(--border-color);
    }
    .fc .fc-toolbar-title { 
        font-size: 1.25rem; 
        font-weight: 800; 
        color: var(--text-main); 
        letter-spacing: -0.5px;
    }

    /* Buttons */
    .fc .fc-button-primary { 
        background: var(--bg-page); 
        border-color: var(--border-color); 
        color: var(--text-main);
        font-weight: 600;
        text-transform: capitalize;
        border-radius: 8px;
        transition: all 0.2s;
        box-shadow: none !important;
    }
    .fc .fc-button-primary:hover {
        background: var(--border-color);
        border-color: var(--text-muted);
        color: var(--text-main);
    }
    .fc .fc-button-primary:not(:disabled):active, 
    .fc .fc-button-primary:not(:disabled).fc-button-active { 
        background: var(--primary); 
        border-color: var(--primary); 
        color: #fff;
    }

    /* Grid and Cells */
    .fc-theme-standard .fc-scrollgrid,
    .fc-theme-standard td, 
    .fc-theme-standard th { 
        border-color: var(--border-color); 
    }
    .fc-theme-standard th {
        padding: 0.75rem 0;
        background: var(--bg-page);
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom-width: 2px;
    }

    .fc-daygrid-day-frame {
        min-height: 100px !important;
        padding: 4px;
        transition: background 0.2s;
    }
    .fc-daygrid-day-frame:hover {
        background: rgba(0,0,0,0.01);
    }

    /* Day Numbers */
    .fc .fc-daygrid-day-number {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-main);
        padding: 8px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 4px;
        text-decoration: none !important;
    }
    
    .fc .fc-day-today .fc-daygrid-day-number { 
        background: var(--primary); 
        color: white;
    }
    .fc-day-today { background: transparent !important; } /* remove default yellow bg */

    /* Events */
    .fc-event { 
        border: none; 
        padding: 4px 6px; 
        border-radius: 6px; 
        font-size: 0.75rem; 
        font-weight: 600; 
        cursor: pointer; 
        margin-bottom: 4px !important;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .fc-event:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .fc-event-main {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Fix for mobile/small screens */
    @media (max-width: 768px) {
        .fc .fc-toolbar.fc-header-toolbar { flex-direction: column; gap: 1rem; }
        .fc-daygrid-day-frame { min-height: 70px !important; }
        .fc .fc-daygrid-day-number { font-size: 0.8rem; width: 24px; height: 24px; padding: 0; }
        .fc-event { font-size: 0.65rem; padding: 2px 4px; }
    }
</style>
@endsection

@section('content')
<div class="calendar-container">
    <div id='calendar'></div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            height: 'auto',
            contentHeight: 'auto',
            events: '/api/calendar/events',
            eventDidMount: function(info) {
                // Determine event style based on properties (fallback for older events)
                // In FullCalendar v5, you can use backgroundColor passed from API.
                
                // Add tooltip
                if(info.event.extendedProps.description) {
                    info.el.title = info.event.title + " - " + info.event.extendedProps.description;
                } else {
                    info.el.title = info.event.title;
                }
            }
        });
        calendar.render();
    });
</script>
@endsection
