
@extends('Layouts.admin')
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
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ti-unlock"></i>
                                </span>
                                <input class="form-control" id="new_password" type="password"
                                    name="new_password" placeholder="New Password"
                                    minlength="5">
                                <button class="btn btn-dark togglePassword" type="button" onclick="togglePasswordVisibility(this)"
                                    style="width: 42px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="eye-icon" style="width: 18px; height: 18px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.644C3.483 8.653 7.379 5.8 12 5.8s8.517 2.853 9.964 5.878c.11.23.11.49 0 .721-1.447 3.025-5.341 5.875-9.964 5.875s-8.517-2.85-9.964-5.875Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="eye-slash-icon noDisplay" style="width: 18px; height: 18px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A11.055 11.055 0 0 0 2.036 12.322a1.012 1.012 0 0 0 0 .644C3.483 15.347 7.379 18.2 12 18.2c2.146 0 4.137-.604 5.824-1.653m1.884-2.185A11.052 11.052 0 0 0 21.964 12c0-.342-.11-.645-.276-.732-1.447-3.025-5.341-5.875-9.964-5.875a11.06 11.06 0 0 0-4.048.767m0 0a11.052 11.052 0 0 0-4.048 3.535M15.536 8.464A7.5 7.5 0 1 1 8.464 15.536m7.072-7.072L3.75 20.25" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
					<div class="col-md-3">
				</div>
				<div class="col-md-3">
				</div>
					<div class="col-md-6">
						<div class="form-group">
                        	<label for="Confirm Password" class="control-label">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ti-unlock"></i>
                                </span>
                                <input type="password" name="confirm_password"  class="form-control" placeholder="Enter Confirm Password" required>
                                <button class="btn btn-dark togglePassword" type="button" onclick="togglePasswordVisibility(this)" style="width: 42px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="eye-icon" style="width: 18px; height: 18px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.644C3.483 8.653 7.379 5.8 12 5.8s8.517 2.853 9.964 5.878c.11.23.11.49 0 .721-1.447 3.025-5.341 5.875-9.964 5.875s-8.517-2.85-9.964-5.875Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="eye-slash-icon noDisplay" style="width: 18px; height: 18px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A11.055 11.055 0 0 0 2.036 12.322a1.012 1.012 0 0 0 0 .644C3.483 15.347 7.379 18.2 12 18.2c2.146 0 4.137-.604 5.824-1.653m1.884-2.185A11.052 11.052 0 0 0 21.964 12c0-.342-.11-.645-.276-.732-1.447-3.025-5.341-5.875-9.964-5.875a11.06 11.06 0 0 0-4.048.767m0 0a11.052 11.052 0 0 0-4.048 3.535M15.536 8.464A7.5 7.5 0 1 1 8.464 15.536m7.072-7.072L3.75 20.25" />
                                    </svg>
                                </button>
                            </div>
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

function togglePasswordVisibility(element) {
    const container = $(element).parent();
    const input = container.find('input');
    const eyeIcon = $(element).find('.eye-icon');
    const eyeSlashIcon = $(element).find('.eye-slash-icon');

    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        eyeIcon.addClass('noDisplay');
        eyeSlashIcon.removeClass('noDisplay');
    } else {
        input.attr('type', 'password');
        eyeIcon.removeClass('noDisplay');
        eyeSlashIcon.addClass('noDisplay');
    }
}
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

			// console.log("Data:",values['new_password']);

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
