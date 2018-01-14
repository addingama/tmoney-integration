@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default ">
                            <a href="#" class="no-hover">
                                <div class="panel-body">
                                    <h3>Balance</h3>
                                    <span id="balance-value">test</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default ">
                            <a href="{{ url('/transaction-report') }}" class="no-hover">
                                <div class="panel-body">
                                    <h3>Transaction Report</h3>
                                    <i class="fa fa-exchange" aria-hidden="true"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default ">
                            <a href="{{ url('/donation') }}" class="no-hover">
                                <div class="panel-body">
                                    <h3>Donation</h3>
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default ">
                            <a href="{{ url('/topup-prepaid') }}" class="no-hover">
                                <div class="panel-body">
                                    <h3>Beli Pulsa HP</h3>
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{--<div class="col-md-3">--}}
                        {{--<div class="panel panel-default ">--}}
                            {{--<a href="{{ url('/topup') }}" class="no-hover">--}}
                                {{--<div class="panel-body">--}}
                                    {{--<h3>Topup Saldo</h3>--}}
                                    {{--<i class="fa fa-plus" aria-hidden="true"></i>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-3">--}}
                        {{--<div class="panel panel-default ">--}}
                            {{--<a href="{{ url('/transactions') }}" class="no-hover">--}}
                                {{--<div class="panel-body">--}}
                                    {{--<h3>Transactions</h3>--}}
                                    {{--<i class="fa fa-exchange" aria-hidden="true"></i>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        localStorage.setItem('token', window.tmoney_token);
        localStorage.setItem('idTmoney', window.idTmoney);
        localStorage.setItem('idFusion', window.idFusion);
        localStorage.setItem('authorization', 'Bearer ' + window.authorization);

        // update dashboard
        $('#balance-value').text(localStorage.getItem('balance'));

        // get balance
        $(function() {
            axios.post('/api/my_profile', {
                idTmoney: localStorage.getItem('idTmoney'),
                idFusion: localStorage.getItem('idFusion'),
                token: localStorage.getItem('token'),
            }, {
                headers: {
                    Authorization: localStorage.getItem('authorization')
                }
            })
                .then(function (response) {
                    const balance = numeral(response.data.response.balance).format('$0,0.00');
                    localStorage.setItem('balance', balance);
                    $('#balance-value').text(balance);
                })
                .catch(function (error) {
                    console.log(error);
                });
        })
    </script>
@endsection