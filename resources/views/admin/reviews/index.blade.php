@extends('layouts.admin')
@section('content')
    <h3>Reviews</h3>
    <div class="card" >
        <div class="card-body">
            <table class="table" id="reviews-table">
                <thead>
                <tr>
                    <th scope="col">Customer name</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td>{{$review->user ? ($review->user->first_name ? $review->user->first_name . ' ' . $review->user->last_name : $review->user->email) : ''}}</td>
                            <td>{{$review->title}}</td>
                            <td>{{$review->description}}</td>
                            <td>{{$review->rate }}</td>
                            <td>{{$review->status ? 'Accepted' : 'Declined' }}</td>
                            <td>
                                <div class="d-inline-flex">
                                    <a class="btn btn-{{$review->status ? 'warning' : 'success' }} btn-sm mx-2" href="{{route('reviews.accept_declined',['id' => $review->id])}}" >
                                        {{$review->status ? 'Decline' : 'Accept' }}
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="{{route('reviews.delete',['id' => $review->id])}}"  onclick="return confirm('Are you sure want to delete this review?')">
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('content_javascript')
    <script type="text/javascript">
        $(document).ready( function () {
            $.fn.dataTable.ext.errMode = 'none';
            let datatable = $('#reviews-table').DataTable({
                "pageLength": 10,
            });
            $('#reviews-table').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'An error has been reported by DataTables: ', message);
            })
            $('#reviews-table_length').remove();
        } );
    </script>
@endsection
