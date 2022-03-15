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
				minlength: 'Please enter at least 6 characters for the password'
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

function validateUserSettings()
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

function expandTableRows()
{
	$(document).ready(function() {
		$('tr.qq').css('display', 'none');

		$('tr.header').click(function(){
			$(this).nextUntil('tr.header').css('display', function(i,v) {
				
				if(this.style.display == 'table-row')
				{	
					return 'none';
				}else{
					return 'table-row';
				}

			});
		});
	});
}

function showChart(nameIncome, amountIncome, nameExpense, amountExpense)
{
	var colors = [];

	var dynamicColors = function() {
		var op = (Math.random() * (1-0.5)+0.5);

		return "rgba(" + 50 + "," + 57 + "," + 191 + "," + op + ")";
	};

	for(var i = 0; i <= nameExpense.length; i++)
	{
		colors.push(dynamicColors());
		
	}

	const char1 = $('#chart1');
	const myChart1 = new Chart(char1, {
		type: 'pie',
		data: {
			labels: nameIncome,
			datasets: [{
				label: '# of Votes',
				data: amountIncome,
				backgroundColor: colors,
				borderColor: [
					'rgb(13, 0, 99)'
				],
				borderWidth: 1
			}]
		},
		options: {
			plugins: {
				title: {
					display: true,
					text: 'Incomes',
					font: {
						size: 18,
						style: 'italic',
						weight: 'normal'

					}
				}
			}
		}
	});

	const char2 = $('#chart2');
	const myChart2 = new Chart(char2, {
		type: 'pie',
		data: {
			labels: nameExpense,
			datasets: [{
				label: '# of Votes',
				data: amountExpense,
				backgroundColor: colors,
				borderColor: [
					'rgb(13, 0, 99)'
				],
				borderWidth: 1
			}]
		},
		options: {
			plugins: {
				title: {
					display: true,
					text: 'Expenses',
					font: {
						size: 18,
						style: 'italic',
						weight: 'normal'

					}
				}
			}
		}
	});
}

function showCategories()
{
	// get incomes categories from database
	$.ajax({
		url: '/settings/incomeSet',
		dataType: 'json',
		success: function(res){
			for(var i = 0; i<res.length; i++){
				$('#incomeCategory').append(`
				<div class="input-group-text ps-3 pt-0 mb-2">
				
				<input class="form-control shadow-none border-secondary border-1" type="text" name="name" value="`+ res[i].name + `" id="nameInput" disabled>
	
				<button type="button" class="inputIcon userSet" style="font-size: 21px;" data-bs-toggle="modal" data-bs-target="#incomeSettings">
					
					<i class="icon-edit" id="toggler"></i>
				
				</button>
				</div>`
				);
			}
		}
	});

	// get expenses categories from database
	$.ajax({
		url: '/settings/expenseSet',
		dataType: 'json',
		success: function(res){
			for(var i = 0; i<res.length; i++){
				$('#expenseCategory').append(`
				<div class="input-group-text ps-3 pt-0 mb-2">
				
				<input class="form-control shadow-none border-secondary border-1" type="text" name="name" value="`+ res[i].name + `" id="nameInput" disabled>
	
				<button type="button" class="inputIcon userSet" style="font-size: 21px;" data-bs-toggle="modal" data-bs-target="#expenseSettings">
					
					<i class="icon-edit" id="toggler"></i>
				
				</button>
				</div>`
				);
			}
		}
	});

	// get payment methods categories from database
	$.ajax({
		url: '/settings/paymentSet',
		dataType: 'json',
		success: function(res){
			for(var i = 0; i<res.length; i++){
				$('#paymentCategory').append(`
				<div class="input-group-text ps-3 pt-0 mb-2">
				
				<input class="form-control shadow-none border-secondary border-1" type="text" name="name" value="`+ res[i].name + `" id="nameInput" disabled>
	
				<button type="button" class="inputIcon userSet" style="font-size: 21px;" data-bs-toggle="modal" data-bs-target="#paymentSettings">
					
					<i class="icon-edit" id="toggler"></i>
				
				</button>
				</div>`
				);
			}
		}
	});
}

