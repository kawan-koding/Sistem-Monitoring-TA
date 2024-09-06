@extends('layout.admin-main')
@section('content')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div id="calender"></div>
            </div>
        </div>
    </div>
</div>
{{-- @dd($data) --}}
<script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calender');
            
            // Periksa format data
            const eventsData = @json($data);
            console.log(eventsData);

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: eventsData
            });
            
            calendar.render();
        });
    </script>
@endsection
