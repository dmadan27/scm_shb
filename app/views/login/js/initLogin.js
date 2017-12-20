$(document).ready(function(){
	$("#form_lupaPassword").fadeOut();
	
	$('#lupa_password').on("click", function () {
		resetForm();
        $("#form_login").slideUp();
        $("#form_lupaPassword").fadeIn();
    });

	$('#back_login').on("click", function () {
        resetForm();
        $("#form_lupaPassword").slideUp();
        $("#form_login").slideDown();
    });

	// submit login
    $('#form_login').submit(function(e){
    	e.preventDefault();
		submit_login();

		return false;
    });

    // submit lupa password
    $('#form_lupaPassword').submit(function(e){
    	e.preventDefault();
		submit_lupaPassword();

		return false;
    });

    // onchange field
    	// username login
    	$("#username").change(function(){
    		if(this.value !== ""){
    			$('.field-username').removeClass('has-error').addClass('has-success');
				$(".field-username span.help-block").text('');	
    		}
    	});

    	// password
    	$("#password").change(function(){
    		if(this.value !== ""){
    			$('.field-password').removeClass('has-error').addClass('has-success');
				$(".field-password span.help-block").text('');	
    		}
    	});

    	// username lupa password
    	$("#username_lupaPassword").change(function(){
    		if(this.value !== ""){
    			$('.field-username-lupa-password').removeClass('has-error').addClass('has-success');
				$(".field-username-lupa-password span.help-block").text('');	
    		}
    	});

    	// email
    	$("#email").change(function(){
    		if(this.value !== ""){
    			$('.field-email').removeClass('has-error').addClass('has-success');
				$(".field-email span.help-block").text('');	
    		}
    	});
    // ========================== //
});

function submit_login(){
	$.ajax({
		url: base_url+"app/controllers/Login.php",
		type: "post",
		dataType: "json",
		data:{
			"username": $("#username").val().trim(),
			"password": $("#password").val().trim(),
			"action": $("#btnSubmit_login").val().trim(),
		},
		beforeSend: function(){
			$.blockUI({ 
				message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
	            css: {
	                border: '1px solid #fff'
	            } 
			}); 
		},
		success: function(output){
			$.unblockUI();
			console.log(output);
			if(output.status) document.location=base_url;
			else{
				setError_login(output.setError);
				setValue_login(output.setValue);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) { // error handling
			$.unblockUI();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

function submit_lupaPassword(){
	$.ajax({
		url: base_url+"app/controllers/Login.php",
		type: "post",
		dataType: "json",
		data:{
			"username": $("#username").val().trim(),
			"password": $("#password").val().trim(),
			"action": $("#btn_login").val().trim(),
		},
		success: function(output){
			console.log(output);
			if(output.status) document.location=base_url;
			else{
				setError_login(output.setError);
				setValue_login(output.setValue);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) { // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

function setError_login(error){
	// username
	if(!jQuery.isEmptyObject(error.usernameError)){
		$('.field-username').removeClass('has-success').addClass('has-error');
		$(".field-username span.help-block").text(error.usernameError);
	}
	else{
		$('.field-username').removeClass('has-error').addClass('has-success');
		$(".field-username span.help-block").text('');	
	}

	// password
	if(!jQuery.isEmptyObject(error.passwordError)){
		$('.field-password').removeClass('has-success').addClass('has-error');
		$(".field-password span.help-block").text(error.passwordError);
	}
	else{
		$('.field-password').removeClass('has-error').addClass('has-success');
		$(".field-password span.help-block").text('');
	}
}

function setValue_login(value){
	$("#username").val(value.username);
	$("#password").val(value.password);
}

function setError_lupaPassword(error){
	// username lupa password
	if(!jQuery.isEmptyObject(error.username_lupaPasswordError)){
		$('.field-username-lupa-password').removeClass('has-success').addClass('has-error');
		$(".field-username-lupa-password span.help-block").text(error.username_lupaPasswordError);
	}
	else{
		$('.field-username-lupa-password').removeClass('has-error').addClass('has-success');
		$(".field-username-lupa-password span.help-block").text('');	
	}

	// email
	if(!jQuery.isEmptyObject(error.emailError)){
		$('.field-email').removeClass('has-success').addClass('has-error');
		$(".field-email span.help-block").text(error.emailError);
	}
	else{
		$('.field-email').removeClass('has-error').addClass('has-success');
		$(".field-email span.help-block").text('');
	}
}

function setValue_lupaPassword(value){
	$("#username_lupaPassword").val(value.username_lupaPassword);
	$("#email").val(value.email);
}

function resetForm(){
	// form login
	$('#form_login').trigger('reset');
	$('#form_login').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
	$('#form_login').find("span.pesan").text(""); // hapus semua span help-block

	// form lupa password
	$('#form_lupaPassword').trigger('reset');
	$('#form_lupaPassword').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
	$('#form_lupaPassword').find("span.pesan").text(""); // hapus semua span help-block
}