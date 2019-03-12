@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!<br>
                        <a href="/horizon" target="_blank">Horizon</a><br>
                        <a href="/telescope" target="_blank">Telescope</a><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
