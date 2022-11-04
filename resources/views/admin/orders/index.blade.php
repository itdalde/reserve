@extends('layouts.admin')
@section('content')
<div class="container">

    <div class="row">
        <div class="col-9">
            <h3>Order List</h3>

            <div class="card mb-2" >
                <div class="card-body">
                    <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col" style="border-top-left-radius: 11px;background: #F2F1F0;">Name</th>
                    <th scope="col" style=" background: #F2F1F0;">ID</th>
                    <th scope="col" style=" background: #F2F1F0;">Type</th>
                    <th scope="col" style=" background: #F2F1F0;">Volume</th>
                    <th scope="col" style=" background: #F2F1F0;">Date</th>
                    <th scope="col" style="border-top-right-radius: 11px;background: #F2F1F0;">Status</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
                </div>
            </div>
        </div>
        <div class="col-3">
            <h3>Upcoming orders</h3>
            <div class="card mb-2" >
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
