@extends('layouts.admin');

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">
      <h3>Audit Trail Logs</h3>
      <div class="card mb-2">
        <div class="card-body">
          <div class="table-responsive">
            <table id="table-manage-trails" class="table table-striped table-bordered table-hover no-wrap">
              <thead>
                <tr>
                  <th class="fs-6">User ID</th>
                  <th class="fs-6">Name</th>
                  <th class="fs-6">Notes</th>
                  <th class="fs-6">Params</th>
                  <th class="fs-6">Model</th>
                  <th class="fs-6">Company ID</th>
                  <th class="fs-6">Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach($audits as $audit)
                <tr>
                  <td class="fs-5">{{$audit->user_id}}</td>
                  <td class="fs-5" style="width: 15%;">{{$audit->user}}</td>
                  <td class="fs-5">{{$audit->notes}}</td>
                  <td class="fs-5">{{$audit->data}}</td>
                  <td class="fs-5">{{$audit->model}}</td>
                  <td class="fs-5" style="width: 10%">{{$audit->company_id}}</td>
                  <td class="fs-5">{{$audit->created_at}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


@section('content_javascript')
<script type="text/javascript">
  $(document).ready(function () {
    $('#table-manage-trails').DataTable({
      "pageLength": 10
    })
  })
</script>
@endsection