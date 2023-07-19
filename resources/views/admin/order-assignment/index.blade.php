@extends('layouts.admin')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-12">
                <h3>Occasions & Services</h3>

                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex flex-column">
                            <div class="p-2">
                                Occasions
                                <div class="border p-1">
                                    @foreach($occasionTypes as $occasionType)
                                       <button type="button"> <img src="https://reservegcc.com/{{$occasionType['logo']}}" alt="..."></button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="p-2">
                                Services
                                <div class="border p-1">
                                    <div class="row">
                                        @foreach($serviceTypes as $serviceType)
                                            <div class="col">
                                                <div class="card mb-2">
                                                    <div class="card-body">
                                                        <span>{{$serviceType['name']}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

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

        });
    </script>
@endsection
