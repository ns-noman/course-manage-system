@extends('layouts.admin.master')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Schedule Calendar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Schedule Calendar</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="calendar" style="background-color: #D4D4D4; color: dark;border-color: red;"></div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
<!-- JS for jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- JS for full calender -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<!-- bootstrap css and js -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    
    $(document).ready(function() {
        display_events();
    }); //end document.ready block

    function display_events() {
        var events = new Array();
        $.ajax({
            url: '{{ url("admin/schedule/all-schedule") }}',
            dataType: 'json',
            success: function(res) {
                $.each(res, function(i, item) {
                    events.push({
                        event_id: item.event_id,
                        title: item.title,
                        start: item.start,
                        end: item.start,
                        color: '#3D3D3D',
                        textColor: 'white',
                        // url: '{{ url("admin/schedule/all-schedule") }}/' + item.event_id,
                        start_time: item.start_time,
                        end_time: item.end_time,
                    });
                });
                var calendar = $('#calendar').fullCalendar({
                defaultView: 'month',
                timeZone: 'local',
                editable: true,
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                        //alert(start);
                        //alert(end);
                        $('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
                        $('#event_end_date').val(moment(end).format('YYYY-MM-DD'));
                        // $('#event_entry_modal').modal('show');
                    },
                events: events,
                eventRender: function(event, element, view) { 
                    element.bind('click', function() {
                        Swal.fire(event.start_time +' - '+event.end_time);
                });
    	}
		});
            },
            error: function(xhr, status) {
                alert(response.msg);
            }
        }); //end ajax block	
    }
</script>

@endsection