@extends('home.layout.MasterLayout')
@Section('content')
    <div class="card m-5 ">
        <div class="card-header">
            Social Activity
        </div>
        <img src="" alt="image">
        <div class="card-body text-center">
            <div class="card-title">
                <div class="card-text text-danger">
                    <p><b>{{-- $activity->program_name--}}</b></p>
                </div>
                <div class="card-text">
                    {{-- $activity->program_category --}}
                </div>
                <div class="card-text">
                    {{-- $activity->program_address --}}
                </div>
            </div>
        </div>
    </div>
@endsection
