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
        localStorage.setItem('idTmoney', window.idTmoney);
        localStorage.setItem('idFusion', window.idFusion);

        // setting numeral
        numeral.register('locale', 'id', {
            delimiters: {
                thousands: '.',
                decimal: ','
            },
            abbreviations: {
                thousand: 'k',
                million: 'm',
                billion: 'b',
                trillion: 't'
            },
            currency: {
                symbol: 'Rp.'
            }
        });
        numeral.locale('id');

        // update dashboard
        $('#balance-value').text(localStorage.getItem('balance'));

        // get balance
        $(function() {
            axios.post('/api/my_profile', {
                idTmoney: localStorage.getItem('idTmoney'),
                idFusion: localStorage.getItem('idFusion'),
                token: localStorage.getItem('token'),
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