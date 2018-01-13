@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form id="inquiry" class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    <div class="panel panel-default">
                        <div class="panel-heading">Donation</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="product-picker" class="col-md-4 control-label">Tujuan</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="productCode" id="product-picker">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">Jumlah</label>

                                <div class="col-md-6">
                                    <input id="amount" type="number" class="form-control" name="amount"
                                           value="{{ old('amount') }}" min="100" required>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button>Send Inquiry</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="confirmation-modal" class="modal fade bd-example-modal-lg" data-backdrop="false" tabindex="-1"
         role="dialog"
         aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" method="POST" id="confirmation">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a class=" btn-default pull-right" data-toggle="modal" data-target="#confirmation-modal">X</a>
                            <h4>Donation Confirmation</h4>
                        </div>

                        <div class="panel-body">

                            <input type="hidden" id="refNo" name="refNo"/>
                            <input type="hidden" id="transactionID" name="transactionID"/>
                            <input type="hidden" id="productCode" name="productCode"/>

                            <div class="form-group">
                                <label for="productName" class="col-md-4 control-label">Tujuan</label>

                                <div class="col-md-6">
                                    <input id="productName" class="form-control" name="productName" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="amount" class="col-md-4 control-label">Jumlah</label>

                                <div class="col-md-6">
                                    <input id="amount2" class="form-control" name="amount" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="feeAmount" class="col-md-4 control-label">Fee</label>

                                <div class="col-md-6">
                                    <input id="feeAmount" class="form-control" name="feeAmount" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="totalAmount" class="col-md-4 control-label">Total</label>

                                <div class="col-md-6">
                                    <input id="totalAmount" class="form-control" name="totalAmount" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pin" class="col-md-4 control-label">PIN</label>

                                <div class="col-md-6">
                                    <input id="pin" class="form-control" name="pin" type="password" minlength="6"
                                           maxlength="6" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="text-align: right; padding-right: 15px; padding-bottom: 10px;">
                        <button class="btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('styles')

@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            getProducts();
            // submit form inquiry
            $('#inquiry').submit(function (event) {
                showProgress();
                axios.post('/api/donation', {
                    transactionType: 1,
                    productCode: $('#product-picker').val(),
                    amount: $('input[name=amount]').val(),
                    token: localStorage.getItem('token'),
                }, {
                    headers: {
                        Authorization: localStorage.getItem('authorization')
                    }
                })
                    .then(function (res) {
                        console.log(res);
                        window.swal.close();

                        if (!res.data.error) {
                            const response = res.data.response;
                            console.log(response);
                            if (response.resultCode === 0) {
                                $('#productName').val(response.productName);
                                $('#refNo').val(response.refNo);
                                $('#transactionID').val(response.transactionID);
                                $('#amount2').val(response.amount);
                                $('#feeAmount').val(response.feeAmount);
                                $('#totalAmount').val(response.totalAmount);
                                $('#productCode').val(response.productCode);
                                $('#confirmation-modal').modal('show');
                            } else {
                                showError(response.resultDesc);
                            }

                        } else {
                            showError(res.data.message);
                        }


                    })
                    .catch(function (error) {
                        console.log(error);
                        showError(error.toString());
                    });
                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });


            $('#confirmation').submit(function (event) {
                showProgress();
                axios.post('/api/donation', {
                    transactionType: 2,
                    productCode: $('input[name=productCode]').val(),
                    amount: $('input[name=amount]').val(),
                    refNo: $('input[name=refNo]').val(),
                    transactionID: $('input[name=transactionID]').val(),
                    pin: $('input[name=pin]').val(),
                    token: localStorage.getItem('token'),
                }, {
                    headers: {
                        Authorization: localStorage.getItem('authorization')
                    }
                })
                    .then(function (res) {
                        console.log(res);
                        window.swal.close();

                        if (!res.data.error) {
                            const response = res.data.response;
                            console.log(response);
                            if (response.resultCode === 0) {
                                window.swal({
                                    title: "Sukses",
                                    text: response.resultDesc,
                                    icon: "success"
                                }).then(function(value) {
                                    window.location = '/home';
                                })
                            } else {
                                showError(response.resultDesc);
                            }

                        } else {
                            showError(res.data.message)
                        }


                    })
                    .catch(function (error) {
                        console.log(error);
                        showError(error.toString());
                    });
                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });

            function getProducts() {
                axios.get('/api/get_product?type=DONATION', {
                    token: localStorage.getItem('token')
                }, {
                    headers: {
                        Authorization: localStorage.getItem('authorization')
                    }
                })
                    .then(function (response) {
                        if (!response.data.error) {
                            const products = response.data.response.product;
                            $("#product-picker").html('');
                            $.each(products, function () {
                                $("#product-picker").append('<option value="' + this.code + '">' + this.name + '</option>');
                            });
                        }

                    })
                    .catch(function (error) {
                        console.log(error);
                    })
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