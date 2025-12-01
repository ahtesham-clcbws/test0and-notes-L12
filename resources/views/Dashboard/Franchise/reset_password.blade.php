
@extends('Layouts.franchise')
@section('css')
    <style>
        .dashboard-container .alertx {
            position: relative;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
            min-height: 49px;
        }

        .dashboard-container .form-switch {
            padding-top: 4px;
        }

        .dashboard-container .form-switch label {
            width: -webkit-fill-available;
        }

        .noDisplay {
            display: none;
        }

    </style>
@endsection
@section('main')
    <div class="container p-0">
        <form id="resetpasswordForm" class="card dashboard-container mb-5">
            <div class="card-body">
                {{-- part 1 --}}
                <div class="row">

				<div class="col-md-3">
				</div>
					<div class="col-md-6">
						<div class="form-group">
                        	<label for="New Password" class="control-label">New Password</label>
                            <input type="password" name="new_password"  class="form-control form-control-sm" placeholder="Enter New Password" style="border: 1px solid #aaa;" required>
                        </div>
                    </div>
					<div class="col-md-3">
				</div>
				<div class="col-md-3">
				</div>
					<div class="col-md-6">
						<div class="form-group">
                        	<label for="Confirm Password" class="control-label">Confirm Password</label>
                            <input type="password" name="confirm_password"  class="form-control form-control-sm" placeholder="Enter Confirm Password" style="border: 1px solid #aaa;" required>
                        </div>
                    </div>
					<div class="col-md-3">
				</div>
				<div class="row mt-3">
					<div class="col-sm-9">
						<div class="form-group" style="float:right">
							<button type="submit" class="btn btn-primary">Reset Password</button>
						</div>
					</div>
				</div>
            </div>
        </form>
    </div>

@endsection

@section('javascript')
<script>
var resetpassword="{{ url('resetpassword') }}";
</script>
<script>
	$(document).ready(function () {
		$.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
     	});

		 $(document).on("submit", "#resetpasswordForm", function(e) {
			e.preventDefault();
			var values = {};
			$.each($("form#resetpasswordForm").serializeArray(), function (i, field) {
				values[field.name] = field.value;
			});

			console.log("Data:",values['new_password']);

			if (values['new_password'] != values['confirm_password']) {
                    alert('New Password and Confirm Password not matched!');
            }else{
				$.ajax({
				    data: { values},
				    url: resetpassword,
				    type: "POST",
				    dataType: 'json',
				    async: false,
				    success: function(data) {
						// console.log("data response:", data);
						alert(data['message']);
						$('#resetpasswordForm')[0].reset();
				    }
				});
			}
    	});

	});
</script>
@endsection
