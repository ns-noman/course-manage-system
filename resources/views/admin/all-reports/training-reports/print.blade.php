<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.9/semantic.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.9/semantic.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<style>
    @page {
        size: A4;
        margin: 0;
    }

    @media print {

        html,
        body {
            width: 210mm;
            height: 297mm;
        }

        /* ... the rest of the rules ... */
    }

    body {
        background: #EEE;
        /* font-size:0.9em !important; */
    }

    .bigfont {
        font-size: 3rem !important;
    }

    .invoice {
        width: 970px !important;
        margin: 50px auto;
    }

    .logo {
        float: left;
        padding-right: 10px;
        margin: 10px auto;
    }

    dt {
        float: left;
    }

    dd {
        float: left;
        clear: right;
    }

    .customercard {
        min-width: 65%;
    }

    .itemscard {
        min-width: 98.5%;
        margin-left: 0.5%;
    }

    .logo {
        max-width: 5rem;
        margin-top: -0.25rem;
    }

    .invDetails {
        margin-top: 0rem;
    }

    .pageTitle {
        margin-bottom: -1rem;
    }
</style>

@php
    $basicInfo = App\Models\BasicInfo::first();
@endphp

<div class="container invoice">
    <div class="invoice-header">
      <div class="ui left aligned grid">
        <div class="row">
          <div class="left floated left aligned six wide column">
            <div class="ui">
              <h1 class = "ui header pageTitle">Training Expense Report</h1>
              <h4 class="ui sub header invDetails">Date: {{ date('d/m/Y') }}</h4>
            </div>
          </div>
          <div class="right floated left aligned six wide column">
            <div class="ui">
              <div class="column two wide right floated" style="float: left">
                <img class="logo" src="{{ asset('public/uploads/basic-info/'. $basicInfo->logo) }}"/>
                <ul class="" style="list-style-type: none;">
                  <li><strong>{{ $basicInfo->title }}</strong></li>
                  {{-- <li>{{ $basicInfo->address }}</li> --}}
                  <li>{{ $basicInfo->address }}</li>
                  <li>{{ $basicInfo->email }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="ui segment cards">
        <div class="row">
            <div class="col-12">
                <h3>Report is shown for the <span id="summery"></span></h3>

            </div>
        </div>
        {{-- <div class="ui card">
            <div class="content">
                <div class="header">Company Details</div>
            </div>
            <div class="content">
                <ul>
                    <li> <strong> Name: RCJA </strong> </li>
                    <li><strong> Address: </strong> 1 Unknown Street VIC</li>
                    <li><strong> Phone: </strong> (+61)404123123</li>
                    <li><strong> Email: </strong> admin@rcja.com</li>
                    <li><strong> Contact: </strong> John Smith</li>
                </ul>
            </div>
        </div>
        <div class="ui card customercard">
            <div class="content">
                <div class="header">Customer Details</div>
            </div>
            <div class="content">
                <ul>
                    <li> <strong> Name: RCJA </strong> </li>
                    <li><strong> Address: </strong> 1 Unknown Street VIC</li>
                    <li><strong> Phone: </strong> (+61)404123123</li>
                    <li><strong> Email: </strong> admin@rcja.com</li>
                    <li><strong> Contact: </strong> John Smith</li>
                </ul>
            </div>
        </div> --}}

        <div class="ui segment itemscard">
            <div class="content">
                <table class="ui celled table">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th class="text-center colfix">Course Name</th>
                            <th class="text-center colfix">From Date</th>
                            <th class="text-center colfix">To Date</th>
                            <th id="absent" class="text-center colfix" hidden>Absent/Class</th>
                        </tr>
                    </thead>
                    <tbody id="table-data">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const params = window.location.search.substr(1).split('&');
    const data = {};
    data.year = params[0].split('=')[1];
    data.month = params[1].split('=')[1];
    data.department_id = params[2].split('=')[1];
    data.trainee_id = params[3].split('=')[1];

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });
    $.ajax({
        url: "{{ url('admin/reports/training-reports-data') }}",
        method: "post",
        dataType: "json",
        data: data,
        success: function(res) {
            let td = '';
            let i = 1;
            res.courses.forEach((element) => {
                td += '<tr>';
                td += '<td align="center" valign="middle">' + (i++) + '</td>';
                td += '<td align="center" valign="middle">' + element.title + ' {' + element.batch_title + '}' + '</td>';
                td += '<td align="center" valign="middle">' + element.start_date + '</td>';
                td += '<td align="center" valign="middle">' + element.end_date + '</td>';
                if (data.trainee_id) {
                    td += '<td align="center" valign="middle">' + element.absent + '</td>';
                }
                td += '</tr>';
            });

                let sortTD = '<tr>';
                if(data.year){
                    sortTD +=   '<td>'+res.summery.year+'</td>';
                }
                if(data.month){
                    sortTD +=   '<td>'+res.summery.month+'</td>';
                }
                if(data.department_id){
                    sortTD +=   '<td>'+res.summery.department+'</td>';
                }
                if(data.trainee_id){
                    sortTD +=   '<td>'+res.summery.trainee+'</td>';
                }
                sortTD +=   '<td>'+res.courses.length+'</td>';
                sortTD += '</tr>';

            let summery = '';
            if(res.summery.year) summery += ' year-' + res.summery.year;
            if(res.summery.month) summery += ' month-' + res.summery.month;
            if(res.summery.department) summery += ' department-' + res.summery.department;
            if(res.summery.trainee) summery += ' trainee-' + res.summery.trainee + '.';
            $('#summery').html(summery);

            $('#absent').attr('hidden', (data.trainee_id ? false : true));

            if (!res.courses.length) td = 'No Data Found!';
            $('#table-data').html(td);
            $('#sortTD').html(sortTH);
            $('#total_id').html(res.courses.length);
            window.print();
        }
    });

});

</script>
