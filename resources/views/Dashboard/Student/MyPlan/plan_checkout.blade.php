@extends('Layouts.student')

@section('css')
@endsection
@section('main')
<meta name="_token" content="{!! csrf_token() !!}" />
<div class="row">
    <div class="col-xs-12">
        <!-- <hr> -->
        <div class="row">
            <div class="col-md-6">
                <address>
                    <strong>To:</strong><br>
                    {{ $user_detail->name 	}} ,<br>
                    {{ $user_detail->email 	}} ,<br>
                    {{ $user_detail->mobile }} <br>
                </address>
            </div>
            <div class="col-md-6 text-right" style="text-align: right;">
                <address>
                    <strong>Plan Date:</strong><br>
                    {{ date('d/m/Y') }}<br>
                    <strong>Transaction Id:</strong><br>
                    {{ $transaction_id }}<br>
                </address>
            </div>
            {{-- <div class="col-xs-6 text-right">
				<address>
					<strong>Shipped To:</strong><br>
					Jane Smith<br>
					1234 Main<br>
					Apt. 4B<br>
					Springfield, ST 54321
				</address>
			</div> --}}
        </div>
        {{-- <div class="row">
			<div class="col-xs-6">
				<address>
					<strong>Payment Method:</strong><br>
					Visa ending **** 4242<br>
					jsmith@email.com
				</address>
			</div> --}}
        {{-- <div class="col-xs-6">
				<address>
					<strong>Order Date:</strong><br>
					{{ date('d/m/Y') }}<br><br>
        </address>
    </div>
</div> --}}
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Plan summary</strong></h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <td><strong>Plan Name</strong></td>
                                <td class="text-center"><strong>Price</strong></td>
                                <td class="text-center"><strong>Duration</strong></td>
                                <td class="text-center"><strong>Quantity</strong></td>
                                <td class="text-right"><strong>Totals</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- foreach ($order->lineItems as $line) or some such thing here -->
                            <tr>
                                <td>{{ $package_plan->plan_name }}</td>
                                <td class="text-center">{{ $package_plan->final_fees }}</td>
                                <td class="text-center">{{ $package_plan->duration }} Days</td>
                                <td class="text-center">{{ '1' }}</td>
                                <td class="text-right">{{ $package_plan->final_fees }}</td>
                            </tr>
                            <tr>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                <td class="thick-line text-right">{{ $package_plan->final_fees }}</td>
                            </tr>
                            {{--
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-center"><strong>Tax 18%</strong></td>
									<td class="no-line text-right">{{ ($package_plan->plan_price/100)*18 }}</td>
                            </tr>
                            --}}
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>Total</strong></td>
                                <td class="no-line text-right">{{ $package_plan->final_fees }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="text-align: center;">
    <button id="rzp-button1" class="btn btn-primary btn-xl">{{ __('Purchase Package') }}</button>
</div>
@endsection

@section('javascript')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        var options = {
            "key": "{{ env('RAZORPAY_KEY') }}",
            "amount": "{{ ($package_plan->final_fees)*100 }}",
            "currency": "INR",
            "name": "GYANOLOGY",
            "description": "{{ $package_plan->plan_name }}",
            "order_id": "{{ $order_id }}",
            "prefill": {
                "name": "{{ $user_detail->name 	 }}",
                "email": "{{ $user_detail->email  }}",
                "contact": "{{ $user_detail->mobile }}"
            },
            "handler": function(response) {
                $.ajax({
                    url: "{!! route('student.package-checkout') !!}",
                    method: 'post',
                    data: {
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature,
                    },
                    success: function(response) {
                        if (response.data == 'false') {
                            var data_false = "/student/plan";
                            window.location.replace(data_false);
                        } else if (response.data == 'success') {
                            var success = "{{ route('student.payment-success')}}";
                            window.location.replace(success);
                        } else if (response.data == 'failed') {
                            var failed = "{{ route('student.payment-failed')}}";
                            window.location.replace(failed);
                        } else {
                            var data_false = "/student/plan";
                            window.location.replace(data_false);
                        }
                    }
                });
            },
            "notes": {
                "address": "Razorpay Corporate Office"
            },
            "theme": {
                "color": "#0074BA"
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function(response) {
            var failed = "{{ route('student.payment-failed') }}";
            window.location.replace(failed);
            // alert(response.error.code);
            // alert(response.error.description);
            // alert(response.error.source);
            // alert(response.error.step);
            // alert(response.error.reason);
            // alert(response.error.metadata.order_id);
            // alert(response.error.metadata.payment_id);
        });

        $('#rzp-button1').click(function(e) {
            rzp1.open();
            e.preventDefault();
        });
    });
</script>
@endsection
