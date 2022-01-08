function validateSignUpForm()
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
				},
				password2: {
					required: true,
					equalTo: '#passwordValid'
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
				},
				password2: {
					required: 'Password conformation is required',
					equalTo: 'Entered passwords are not match!'
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
				if(element.attr('name') == 'password2') {
					error.appendTo('.errorPasswordConfirmation')
				}
				
			}
		});
	});
		
}

function showHidePassword()
{
    $(".showHide").on('click',function() {
        
        var $password = $(".passwordShowHide");
        
        if ($password.attr('type') === 'password') {
            
            $password.attr('type', 'text');
            $("#toggler").removeClass("icon-eye-1");
            $("#toggler").addClass("icon-eye-off-1");
            
        } else {
            
            $password.attr('type', 'password');
            $("#toggler").removeClass("icon-eye-off-1");
            $("#toggler").addClass("icon-eye-1");
        }
    });
}