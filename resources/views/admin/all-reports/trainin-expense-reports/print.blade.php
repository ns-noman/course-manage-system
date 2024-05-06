<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.9/semantic.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.9/semantic.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<style>
  @page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
}

body{
  background:#EEE;
  /* font-size:0.9em !important; */
}

.bigfont {
  font-size: 3rem !important;
}
.invoice{
  width:970px !important;
  margin:50px auto;
}

.logo {
  float:left;
  padding-right: 10px;
  margin:10px auto;
}

dt {
float:left;
}
dd {
float:left;
clear:right;
}

.customercard {
  min-width:65%;
}

.itemscard {
  min-width:98.5%;
  margin-left:0.5%;
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
                            <th id="title">Course Title</th>
                            <th>Total Expense</th>
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
    data.search_by = params[3].split('=')[1];
    data.batch_id = params[4].split('=')[1];


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });
    $.ajax({
        url: "{{ url('admin/reports/training-expense-reports-data') }}",
        method: "post",
        dataType: "json",
        data: data,
        success: function(res){
            let td = '';
            let i = 1;
            let grand_total = 0;
            res.expenses.forEach((element) => {
                td += '<tr>';
                td +=   '<td align="center" >'+(i++)+'</td>';
                td +=   '<td align="center" >' + element.title + '</td>';
                td +=   '<td align="right" >' + element.total_expense + '/- </td>';
                td += '</tr>';
                grand_total += element.total_expense;
            });
            td += '<tr class="text-right">';
            td +=   '<th colspan="2">Grand Total:</th>';
            td +=   '<th>' + grand_total + '/- </th>';
            td += '</tr>';
            
            let summery = '';

            if(res.summery.year) summery += ' year-' + res.summery.year;
            if(res.summery.month) summery += ' month-' + res.summery.month;
            if(res.summery.department) summery += ' department-' + res.summery.department;
            if(res.summery.search_by) summery += ' ' + res.summery.search_by + ' wise';
            if(res.summery.batch) summery += ' batch-' + res.summery.batch + '.';
            $('#summery').html(summery);

            if(!res.expenses.length) td = 'No Data Found!';
            $('#table-data').html(td);
            $('#total_id').html(res.expenses.length);
            $('#title').text(res.summery.search_by.charAt(0).toUpperCase() + res.summery.search_by.slice(1));   
        }
    });

});

</script>
