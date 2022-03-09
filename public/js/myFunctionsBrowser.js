function validateResetPassword()
{
	newValidMethods();
	
	$(document).ready(function() {
		$('form').validate({
			errorElement: 'div',
			rules: {
				password1: {
					required: true,
					minlength: 6,
					passwordValidation: true
				}
					
			},
			messages: {
				password1: {
					required: 'Password is required',
					minlength: 'Please enter at least 6 characters for the password',
				}
			},
			errorPlacement: function(error, element){
				
				if(element.attr('name') == 'password1') {
					error.appendTo('.errorPassword')
				}
				
			}
		});
	});
}

function validateSignUpForm()
{
	newValidMethods();
	
	$(document).ready(function() {
		$('form').validate({
			errorElement: 'div',
			rules: {
				userName: {
					required: true,
					minlength: 3,
					maxlength: 20,
					nameValidation: true
				},
				email: {
					required: true,
					email: true,
					remote: '/account/validate-email'
				},
				password1: {
					required: true,
					minlength: 6,
					passwordValidation: true
				}
					
			},
			messages: {
				userName: {
					required: 'Name is required',
					minlength: 'Name needs to be between 3 to 20 characters',
					maxlength: 'Name needs to be between 3 to 20 characters'
				},
				email: {
					required: 'Email is required',
					email: 'Please enter a correct email adress',
					remote: 'Email already exists with this account'
				},
				password1: {
					required: 'Password is required',
					minlength: 'Please enter at least 6 characters for the password',
				}
			},
			errorPlacement: function(error, element){
				
				if(element.attr('name') == 'userName' ) {
					error.appendTo('.errorName')
				}
				if(element.attr('name') == 'email') {
					error.appendTo('.errorEmail')
				}
				if(element.attr('name') == 'password1') {
					error.appendTo('.errorPassword')
				}
				
			}
		});
	});
		
}

function validateItemForm()
{
	$(document).ready(function() {
		$('#addItemForm').validate({
			errorElement: 'div',
			rules: {
				amount: {
					required: true,
					number: true,
					min: 0,
					max: 9999999999.99,
					step: 0.01
				},
				category: {
					required: true
				},
				payment: {
					required: true
				}
			},
			messages: {
				amount: {
					required: 'Amount is required',
					number: 'Value must be a number with max 10 integers and 2 decimal characters',
					min: 'Enter a value greater than 0',
					max: 'Value must be a number with max 10 integers and 2 decimal characters'
				},
				category: {
					required: 'Category is required'
				},
				payment: {
					required: 'Payment method is required'
				}			
			},
			errorPlacement: function(error, element){
				
				if(element.attr('name') == 'amount' ) {
					error.appendTo('.errorAmount')
				}
				if(element.attr('name') == 'category') {
					error.appendTo('.errorCategory')
				}
				if(element.attr('name') == 'payment') {
					error.appendTo('.errorPayment')
				}
			}
		});
	});
		
}

function newValidMethods()
{
	$.validator.addMethod('nameValidation',
		function(value, element, param) {
			
            if (value != '') {
                
                if (value.match(/^[a-zA-Z0-9]+$/)) {
                    
                    return true;
                }
               }
            return false;
        },
		'Name of user must have only letters and numbers'
	);
	
	$.validator.addMethod('commentValidation',
		function(value, element, param) {
			
            if (value != '') {
                
                if (value.match(/^[a-zA-Z0-9]+$/)) {
                    
                    return true;
                }
               }
            return false;
        },
		'Comment must have only letters and numbers'
	);
	
	$.validator.addMethod('passwordValidation',
		function(value, element, param) {
			
            if (value != '') {
                
                if (value.match(/.*[a-z]+.*/i) == null) {

						return false;
                }
				if (value.match(/.*\d+.*/) == null) {

						return false;
                }

               }
            return true;
        },
		'Password needs letters and numbers'
	);
}

function showHidePassword(toggler, passwordShowHide, showHide)
{
    $(showHide).on('click',function() {
        
        var $password = $(passwordShowHide);
        
        if ($password.attr('type') === 'password') {
            
            $password.attr('type', 'text');
            $(toggler).removeClass("icon-eye-1");
            $(toggler).addClass("icon-eye-off-1");
            
        } else {
            
            $password.attr('type', 'password');
            $(toggler).removeClass("icon-eye-off-1");
            $(toggler).addClass("icon-eye-1");
        }
    });
}

function validateUsernameSettings()
{
	$('.modalEditOptionName').validate({
		errorElement: 'div',
		rules: {
			password: {
				required: true,
				equalTo: "#password2"
			},
			username: {
				required: true,
				minlength: 3,
				maxlength: 20,
				nameValidation: true
			}
		},
		messages: {
			password: {
				required: 'Password is required',
				equalTo: 'Incorrect password'
			},
			username: {
				required: 'Name is required',
				minlength: 'Name needs to be between 3 to 20 characters',
				maxlength: 'Name needs to be between 3 to 20 characters'
			}
		},
		errorPlacement: function(error, element){
			
			if(element.attr('name') == 'password') {
				error.appendTo('.errorPassword')
			}
			if(element.attr('name') == 'username') {
				error.appendTo('.errorUsername')
			}
			
		}
	});
}

function validateEmailSettings()
{
	$('.modalEditOptionEmail').validate({
		errorElement: 'div',
		rules: {
			password: {
				required: true,
				equalTo: "#password2"
			},
			email: {
				required: true,
				email: true,
				remote: '/account/validate-email'
			}
		},
		messages: {
			password: {
				required: 'Password is required',
				equalTo: 'Incorrect password'
			},
			email: {
				required: 'Email is required',
				email: 'Please enter a correct email adress',
				remote: 'Email already exists with this account'
			}
		},
		errorPlacement: function(error, element){
			
			if(element.attr('name') == 'password') {
				error.appendTo('.errorPassword')
			}
			if(element.attr('name') == 'email') {
				error.appendTo('.errorEmail')
			}
			
		}
	});
}
function validateNewPasswordSettings()
{
	$('.modalEditOptionPassword').validate({
		errorElement: 'div',
		rules: {
			password: {
				required: true,
				equalTo: "#password2"
			},
			new_password: {
				required: true,
				minlength: 6,
				passwordValidation: true
			}
		},
		messages: {
			password: {
				required: 'Password is required',
				equalTo: 'Incorrect password'
			},
			new_password: {
				required: 'Password is required',
				minlength: 'Please enter at least 6 characters for the password',
			}
		},
		errorPlacement: function(error, element){
			
			if(element.attr('name') == 'password') {
				error.appendTo('.errorPassword')
			}
			if(element.attr('name') == 'new_password') {
				error.appendTo('.errorNewPassword')
			}
			
		}
	});
}

function validatePasswordSettings()
{
	newValidMethods();

	$(document).ready(function() {
		$('.userSet').click(function(){
			$('.errorPassword').empty();
			$('.errorNewPassword').empty();

			$('.passwordValid').click(function(){
				
				validateUsernameSettings();

				validateEmailSettings();

				validateNewPasswordSettings();
			});
		});
	});
}


