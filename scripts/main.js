$('.register_form').validate({
			rules : {
				reg_password : {
					minlength : 5
				},
				reg_confirm_password : {
					minlength : 5,
					equalTo : "#reg_password"
				}
			}
		});

$('input').click(function(){
	alert("a");
    console.log($('.register_form').valid());
});