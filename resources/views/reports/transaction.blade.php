@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Transaction Report</div>
                    <div class="panel-body table-responsive ">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Tanggal</td>
                                    <td>Transaksi</td>
                                    <td>Info</td>
                                    <td>Jumlah</td>
                                    <td>Fee</td>
                                    <td>Total</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')

@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script>
        $(document).ready(function () {
            getTransactionReport();

            function getTransactionReport() {
                showProgress("Fetching");
                const params = {
                    token: localStorage.getItem('token'),
                    limit: 10000,
                    startDate: '2000-01-01',
                    endDate: moment().format('YYYY-MM-DD')
                };

                // this different from donation because the header not passed on get request
                axios({
                    method: 'get',
                    url: '/api/transaction-report?' + $.param(params),
                    headers: {
                        'Authorization': localStorage.getItem('authorization')
                    }
                }).then(function (res) {
                    console.log(res);
                    window.swal.close();
                    if (!res.data.error) {
                        const response = res.data.response;
                        console.log(response);
                        if (response.resultCode === 0) {
                            $('table tbody').html('');
                            const format = '$0,0.00';
                            response.record.forEach(function(item, index) {
                                $('table tbody').append('<tr>');
                                $('table tbody').append('<td class="text-center">'+ (index + 1)  +'</td>');
                                $('table tbody').append('<td>'+ item.trans_time  +'</td>');
                                $('table tbody').append('<td>'+ item.trans_title  +'</td>');
                                // traverse through
                                var info = '';
                                var counter = 1;
                                $.each(item.detitle, function(key, value) {
                                    if (value !== '') {
                                        info += value + ': ' + item.detail['detail_'+(counter)] + '<br>';
                                    }
                                    counter++;
                                });
                                $('table tbody').append('<td><p>' + info +'</p></td>');
                                $('table tbody').append('<td class="text-right">'+ numeral(item.amount).format(format) +'</td>');
                                $('table tbody').append('<td class="text-right">'+ numeral(item.fee).format(format)  +'</td>');
                                $('table tbody').append('<td class="text-right">'+ numeral(item.eup).format(format)  +'</td>');
                                $('table tbody').append('<td class="text-center">'+ item.status  +'</td>');
                                $('table tbody').append('</tr>');
                            })
                        } else {
                            showError(response.resultDesc);
                        }

                    } else {
                        showError(res.data.message);
                    }


                })
                    .catch(function (error) {
                        console.log(error.toString());
                        showError(error.toString());
                    });
            }

            function showProgress(title) {
                window.swal({
                    title: title,
                    text: "Please wait",
                    icon: "info",
                    button: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
            }

            function showError(message) {
                window.swal({
                    title: "Error",
                    text: message,
                    icon: "error"
                })
            }
        });

    </script>
@endpush