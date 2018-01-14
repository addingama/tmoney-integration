@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form id="inquiry" class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    <div class="panel panel-default">
                        <div class="panel-heading">Beli Pulsa</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="product-picker" class="col-md-4 control-label">Operator</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="productCode" id="product-picker">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nominal-picker" class="col-md-4 control-label">Nominal</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="nominal" id="nominal-picker">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="billNumber" class="col-md-4 control-label">No. Telepon</label>

                                <div class="col-md-6">
                                    <input id="billNumber" type="number" class="form-control" name="billNumber"
                                           value="{{ old('billNumber') }}" maxlength="15" required>
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
                                <label for="billNumber" class="col-md-4 control-label">No. Telepon</label>

                                <div class="col-md-6">
                                    <input id="billNumber2" class="form-control" name="billNumber" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="billAmount" class="col-md-4 control-label">Jumlah</label>

                                <div class="col-md-6">
                                    <input id="billAmount" class="form-control" name="billAmount" readonly>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js"></script>
    <script>
        $(document).ready(function () {
            var operators = [];
            const format = '$0,0.00';
            getOperators();
            // submit form inquiry
            $('#inquiry').submit(function (event) {
                showProgress();
                axios.post('/api/topup-prepaid', {
                    transactionType: 1,
                    productCode: $('#product-picker').val(),
                    amount: $('#nominal-picker').val(),
                    billNumber: $('input[name=billNumber]').val(),
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
                                $('#billAmount').val(response.billAmount);
                                $('#billNumber2').val(response.billNumber);
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
                axios.post('/api/topup-prepaid', {
                    transactionType: 2,
                    productCode: $('#product-picker').val(),
                    amount: $('#nominal-picker').val(),
                    billNumber: $('input[name=billNumber]').val(),
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

            $('#product-picker').on('change', function() {
                // TODO: update nominal picker
                // Find product code on operators array then show value
                const productCode = $('#product-picker').val();
                const selectedOperator = _.find(operators, function(operator) {
                    return operator.code === productCode;
                });
                var nominalPicker = $('#nominal-picker');
                nominalPicker.html('');
                $.each(selectedOperator.value, function () {
                    const value = parseInt(this);
                    nominalPicker.append('<option value="' + value + '">' + numeral(value).format(format) + '</option>');
                });

            });

            function getOperators() {
                axios.get('/api/get_product/nominal?type=AIRTIME', {
                    token: localStorage.getItem('token')
                }, {
                    headers: {
                        Authorization: localStorage.getItem('authorization')
                    }
                })
                    .then(function (response) {
                        if (!response.data.error) {
                            const products = response.data.response.product;
                            var productPicker = $("#product-picker");
                            productPicker.html('');
                            $.each(products, function () {
                                if (this.value) {
                                    operators.push(this);
                                    productPicker.append('<option value="' + this.code + '">' + this.name + '</option>');
                                }
                            });
                            productPicker.trigger('change');
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