function validateResetPassword() {
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
            errorPlacement: function(error, element) {

                if (element.attr('name') == 'password1') {
                    error.appendTo('.errorPassword')
                }

            }
        });
    });
}

function validateSignUpForm() {
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
            errorPlacement: function(error, element) {

                if (element.attr('name') == 'userName') {
                    error.appendTo('.errorName')
                }
                if (element.attr('name') == 'email') {
                    error.appendTo('.errorEmail')
                }
                if (element.attr('name') == 'password1') {
                    error.appendTo('.errorPassword')
                }

            }
        });
    });

}

function validateItemForm() {
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
            errorPlacement: function(error, element) {

                if (element.attr('name') == 'amount') {
                    error.appendTo('.errorAmount')
                }
                if (element.attr('name') == 'category') {
                    error.appendTo('.errorCategory')
                }
                if (element.attr('name') == 'payment') {
                    error.appendTo('.errorPayment')
                }
            }
        });
    });

}

function newValidMethods() {
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

    $.validator.addMethod('lettersonly',
        function(value, element, param) {

            if (value.match(/^[a-zA-Z\s]+$/)) {

                return true;
            }
            return false;
        },
        'Name of category must have only letters'
    );

}

function showHidePassword(toggler, passwordShowHide, showHide) {
    $(showHide).on('click', function() {

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

function validateUsernameSettings() {
    $('.validUserName').validate({
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
        errorPlacement: function(error, element) {

            if (element.attr('name') == 'password') {
                error.appendTo('.errorPassword')
            }
            if (element.attr('name') == 'username') {
                error.appendTo('.errorUsername')
            }

        }
    });
}

function validateEmailSettings() {
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
        errorPlacement: function(error, element) {

            if (element.attr('name') == 'password') {
                error.appendTo('.errorPassword')
            }
            if (element.attr('name') == 'email') {
                error.appendTo('.errorEmail')
            }

        }
    });
}

function validateNewPasswordSettings() {
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
        errorPlacement: function(error, element) {

            if (element.attr('name') == 'password') {
                error.appendTo('.errorPassword')
            }
            if (element.attr('name') == 'new_password') {
                error.appendTo('.errorNewPassword')
            }

        }
    });
}

function validateUserSettings() {
    newValidMethods();

    $(document).ready(function() {
        $('.userSet').click(function() {
            $('.errorPassword').empty();
            $('.errorNewPassword').empty();

            $('.passwordValid').click(function() {

                validateUsernameSettings();

                validateEmailSettings();

                validateNewPasswordSettings();
            });
        });
    });
}

function expandTableRows() {
    $(document).ready(function() {
        $('tr.qq').css('display', 'none');

        $('tr.header').click(function() {
            $(this).nextUntil('tr.header').css('display', function(i, v) {

                if (this.style.display == 'table-row') {
                    return 'none';
                } else {
                    return 'table-row';
                }

            });
        });
    });
}

function showChart(nameIncome, amountIncome, nameExpense, amountExpense) {
    var colors = [];

    var dynamicColors = function() {
        var r = (Math.random() * (200 - 50) + 50);
        var g = (Math.random() * (200 - 50) + 50);
        var b = (Math.random() * (200 - 50) + 50);

        return "rgba(" + r + "," + g + "," + b + "," + 1 + ")";
    };

    for (var i = 0; i <= nameExpense.length; i++) {
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

function modalCategory() {
    $(document).on('click', '#addButton', function() {
        $('#addCategoryIncomeModal input[name="categoryAdded"]').val('');
        $('#addCategoryExpenseModal input[name="categoryAdded"]').val('');
        $('#addCategoryPaymentModal input[name="categoryAdded"]').val('');
    });

    $(document).on('click', '#deleteButton', function() {
        $('#deleteCategoryIncomeModal input[name="categoryIdDel"]').val($(this).attr('delete-id'));
        $('#deleteCategoryExpenseModal input[name="categoryIdDel"]').val($(this).attr('delete-id'));
        $('#deleteCategoryPaymentModal input[name="categoryIdDel"]').val($(this).attr('delete-id'));
    });

    $(document).on('click', '#editButton', function() {
        $('.amountEnable').prop('disabled', true);
        $('.limitEnable').prop('checked', false);
        $('.errorLimit').empty();
        $('#editCategoryExpenseModal input[name="monthlyLimitAmount"]').val('');

        if ($(this).attr('limit-info')) {
            $('.amountEnable').prop('disabled', false);
            $('.limitEnable').prop('checked', true);

            $('#editCategoryExpenseModal input[name="monthlyLimitAmount"]').val($(this).attr('limit-info'));
        }


        $('.limitEnable').click(function() {
            if ($('.limitEnable').is(':checked')) {
                $('.amountEnable').prop('disabled', false);
            } else {
                $('.amountEnable').prop('disabled', true);
                $('.errorLimit').empty();
            }
        });

        $('#editCategoryIncomeModal input[name="categoryNewName"]').val($(this).attr('category-name'));
        $('#editCategoryIncomeModal input[name="categoryOldId"]').val($(this).attr('category-id'));
        $('#editCategoryExpenseModal input[name="categoryNewName"]').val($(this).attr('category-name'));
        $('#editCategoryExpenseModal input[name="categoryOldId"]').val($(this).attr('category-id'));
        $('#editCategoryPaymentModal input[name="categoryNewName"]').val($(this).attr('category-name'));
        $('#editCategoryPaymentModal input[name="categoryOldId"]').val($(this).attr('category-id'));
    });

}

function editValidate() {
    $('.editValidate').each(function() {
        $(this).validate({
            errorElement: 'div',
            rules: {
                categoryNewName: {
                    required: true,
                    minlength: 3,
                    maxlength: 20,
                    lettersonly: true
                },
                monthlyLimitAmount: {
                    required: true,
                    min: 1
                }
            },
            messages: {
                categoryNewName: {
                    required: 'Name of category is required',
                    minlength: 'Please enter at least 3 characters for the category',
                    maxlength: 'Please enter maximum 20 characters for the category'
                },
                monthlyLimitAmount: {
                    required: 'Monthly Limit Amount field is required',
                    min: 'Value must be greater or equal 1'
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr('name') == 'categoryNewName') {
                    error.appendTo('.errorName')
                }
                if (element.attr('name') == 'monthlyLimitAmount') {
                    error.appendTo('.errorLimit')
                }
            }
        });
    });
}

function addIncomeNewCategoryValidate() {
    $('.addValidateIncomeCategory').each(function() {
        $(this).validate({
            errorElement: 'div',
            rules: {
                categoryAdded: {
                    required: true,
                    minlength: 3,
                    maxlength: 20,
                    lettersonly: true,
                    remote: '/account/is-income-category-exists'
                }
            },
            messages: {
                categoryAdded: {
                    required: 'Name of category is required',
                    minlength: 'Please enter at least 3 characters for the category',
                    maxlength: 'Please enter maximum 20 characters for the category',
                    remote: 'Category already exists'
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr('name') == 'categoryAdded') {
                    error.appendTo('.errorName')
                }
            }
        });
    });
}

function addExpenseNewCategoryValidate() {
    $('.addValidateExpenseCategory').each(function() {
        $(this).validate({
            errorElement: 'div',
            rules: {
                categoryAdded: {
                    required: true,
                    minlength: 3,
                    maxlength: 20,
                    lettersonly: true,
                    remote: '/account/is-expense-category-exists'
                }
            },
            messages: {
                categoryAdded: {
                    required: 'Name of category is required',
                    minlength: 'Please enter at least 3 characters for the category',
                    maxlength: 'Please enter maximum 20 characters for the category',
                    remote: 'Category already exists'
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr('name') == 'categoryAdded') {
                    error.appendTo('.errorName')
                }
            }
        });
    });
}

function addPaymentNewCategoryValidate() {
    $('.addValidatePaymentCategory').each(function() {
        $(this).validate({
            errorElement: 'div',
            rules: {
                categoryAdded: {
                    required: true,
                    minlength: 3,
                    maxlength: 20,
                    lettersonly: true,
                    remote: '/account/is-payment-category-exists'
                }
            },
            messages: {
                categoryAdded: {
                    required: 'Name of category is required',
                    minlength: 'Please enter at least 3 characters for the category',
                    maxlength: 'Please enter maximum 20 characters for the category',
                    remote: 'Category already exists'
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr('name') == 'categoryAdded') {
                    error.appendTo('.errorName')
                }
            }
        });
    });
}

function validateCategories() {
    $(document).ready(function() {
        $('.editButton').click(function() {
            $('.errorName').empty();

            editValidate();
        });

        $('.addButton').click(function() {
            $('.errorName').empty();

            addIncomeNewCategoryValidate();
            addExpenseNewCategoryValidate();
            addPaymentNewCategoryValidate();
        });
    });
}

function showLimitInfo() {
    $('#addItemForm').on('input', function() {

        var category = $('select[name="category"]').val();
        var amount = $('input[name="amount"]').val();
        var date = $('input[name="date"]').val();

        if (amount && category) {

            $.ajax({
                url: '/expense/show-limit-info-category',
                type: 'POST',
                data: {
                    amount: amount,
                    category: category,
                    date: date
                },
                dataType: 'JSON',
                success: function(info) {

                    if (info && info[0].limitAmount != null) {
                        $('.limitInfo').prop('hidden', false);

                        $('.limit').html(info[0].limitAmount + ' PLN');
                        $('.previousExp').html(info[0].catSumAmount + ' PLN');
                        $('.remaining').html((parseFloat(info[0].limitAmount) - parseFloat(info[0].catSumAmount)).toFixed(2) + ' PLN');
                        $('.allExp').html(((parseFloat(info[0].catSumAmount) + parseFloat(amount)).toFixed(2)) + ' PLN');

                        if ((parseFloat(info[0].catSumAmount) + parseFloat(amount)) > parseFloat(info[0].limitAmount)) {
                            $('.limitInfo').css('background-color', '#e65a48');
                        } else {
                            $('.limitInfo').css('background-color', '#59c762');
                        }

                    } else {
                        $('.limitInfo').prop('hidden', true);
                    }
                }
            });
        } else {
            $('.limitInfo').prop('hidden', true);
        }


    });
}