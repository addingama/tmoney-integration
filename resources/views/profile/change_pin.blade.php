@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form id="inquiry" class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    <div class="panel panel-default">
                        <div class="panel-heading">Change PIN</div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="old_pin" class="col-md-4 control-label">Old PIN</label>

                                <div class="col-md-6">
                                    <input id="old_pin" type="password" class="form-control" name="old_pin"
                                            maxlength="6" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new_pin" class="col-md-4 control-label">New PIN</label>

                                <div class="col-md-6">
                                    <input id="new_pin" type="password" class="form-control" name="new_pin"
                                           maxlength="6" required>
                                </div>
                            </div>
                            <div class="form-group pull-right" style="margin-right: 10px">
                                <p>Forgot PIN? <a href="#" id="reset-pin">reset your PIN</a></p>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button>Submit</button>
                        </div>
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
            // submit form inquiry
            $('#inquiry').submit(function (event) {
                showProgress();
                axios.post('/api/change-pin', {
                    old_pin: $('input[name=old_pin]').val(),
                    new_pin: $('input[name=new_pin]').val(),
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
                                showSuccess(response.resultDesc);
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

            $('#reset-pin').on('click', function() {
                showProgress();
                axios({
                    method: 'get',
                    url: '/api/reset-pin?token='+localStorage.getItem('token'),
                    headers: {
                        'Authorization': localStorage.getItem('authorization')
                    }
                }).then(function (res) {
                    console.log(res);
                    window.swal.close();
                    if (!res.data.error) {
                        const response = res.data.response;
                        console.log(response);
                        if (response.resultCode === 'RP-009') {
                            showSuccess(response.resultDesc);
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
            });


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

            function showSuccess(message) {
                window.swal({
                    title: "Success",
                    text: message,
                    icon: "success"
                })
            }
        });

    </script>
@endpush