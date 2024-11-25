@extends('layouts.user')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel1">
                <header class="panel-heading">
                    Thêm địa điểm
                </header>
                <div class="panel-body">

                    @if (Session::get('message'))
                        <div class="text-center">
                            <span class="text-alert ">{{Session::get('message')}}</span>
                        </div>
                    @endif

                    <div class="position-center">
                        @livewire('add-location')
                    </div>

                </div>
            </section>

        </div>
    </div>
@endsection
