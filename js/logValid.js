	$(document).ready(function()
	{	

		$("#submit").click(function()
		{
			if ($("#username").val() =="" ){

				alert("Please enter your username!");
				$("#username").removeAttr('placeholder');
				$("#username").focus();	
				return false;
			}
			if ($("#password").val()=="" )
			{
				alert("Please enter your password!");
				$("#password").removeAttr('placeholder');
				$("#password").focus();
				return false;

			}
		})

		



	}





		);