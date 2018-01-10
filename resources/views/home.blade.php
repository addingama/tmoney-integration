@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-default ">
                            <a href="#" class="no-hover">
                                <div class="panel-body">
                                    <h3>Balance</h3>
                                    <span id="balance-value">test</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                {{--<div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        localStorage.setItem('token', window.tmoney_token);

    </script>
@endsection