@extends('layouts.admin')
@section('content')
    <div class="">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-column bd-highlight mb-4">
                    <div class="p-2 bd-highlight">
                        <div class="d-flex justify-content-between">
                            <h3>Promotions</h3>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-promotion-modal">New Promo Code</button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: -2em;" class="col">
                <div class="p-2 bd-highlight">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="promotions-table" class="table table-stripped table-bordered table-hover no-wrap">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" style="border-top-left-radius: 11px;background: #F2F1F0;">Name</th>
                                            <th scope="col" style="background: #F2F1F0;">Code</th>
                                            <th scope="col" style="background: #F2F1F0;">Description</th>
                                            <th scope="col" style="background: #F2F1F0;">price</th>
                                            <th scope="col" style="background: #F2F1F0;">percentage</th>
                                            <th scope="col" style="background: #F2F1F0;">single use</th>
                                            <th scope="col" style="background: #F2F1F0;">is used</th>
                                            <th scope="col" style="background: #F2F1F0;">Duration</th>
                                            <th scope="col" style="border-top-right-radius: 11px;background: #F2F1F0;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($promotions as $promotion)
                                            <tr>
                                               <td>{{$promotion->name}}</td>
                                               <td>{{$promotion->code}}</td>
                                               <td>{{$promotion->description}}</td>
                                               <td>{{number_format($promotion->price, 2, '.', ',')}}</td>
                                               <td>{{number_format($promotion->percent, 2)}}</td>
                                               <td>{{$promotion->single_use == 1 ? 'Single Use' : 'Multiple Use'}}</td>
                                               <td>{{$promotion->status == 1 ? 'Used' : 'Unused'}}</td>
                                               <td>
                                                    <div>
                                                        From: {{Carbon\Carbon::parse($promotion->start_date)->format('F d, Y H:m')}}<br />
                                                        To: {{Carbon\Carbon::parse($promotion->end_date)->format('F d, Y H:m')}}
                                                    </div>
                                               </td>
                                               <td>
                                                <button class="btn btn-sm btn-info text-white d-none">View</button>
                                                <button class="btn btn-sm btn-primary d-none">Edit</button>
                                                <form action="{{ route('promotions.destroy',  $promotion->id) }}" method="DELETE">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning text-white d-none">
                                                        Delete
                                                    </button>
                                                </form>
                                               </td>
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
    </div>
@endsection

@section('content_javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#promotions-table").DataTable({
                "pageLength": 10
            })

            $('#for_total_price').on('click', function() {
                if ($(this).prop('checked') == true) {
                    $('.percent-field').removeClass('d-none');
                    $('.price-field').addClass('d-none');
                } else {
                    $('.percent-field').addClass('d-none');
                    $('.price-field').removeClass('d-none');
                }
            });
        });
    </script>
@endsection
