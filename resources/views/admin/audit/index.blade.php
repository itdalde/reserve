@extends('layouts.admin');

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">
      <h3>Audit Trail Logs</h3>
      <div class="card mb-2">
        <div class="card-body">
          <div class="table-responsive">
            <table id="table-manage-trails" class="table table-striped table-bordered no-wrap">
              <thead>
                <tr>
                  <th>User</th>
                  <th>Module</th>
                  <th>Notes</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach($audits as $audit)
                <tr>
                  <td>{{$audit->user}}</td>
                  <td>{{$audit->module}}</td>
                  <td>{{$audit->notes}}</td>
                  <td>{{$audit->created_at}}</td>
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