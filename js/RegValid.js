	$(document).ready(function()
	{	
		// function to test if inputed email is valid
		function IsEmail(email) {
	        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	    	    if(!regex.test(email)) {
	        	   return false;
	        	}else{
	           return true;
	        }
	      }

		$("#submit").click(function()
		{
			if ($("#newuser").val() =="" )	{
				alert("Please select an username!");				
				$("#newuser").focus();	
				return false;
			}
			else	if($("#newuser").val().length < 3){
					alert("Username must be at least 3 charachters");
					$("#newuser").focus();	
					return false;	

			}		
			if ($("#firstname").val() =="" )	{
				alert("Please enter your firstname!");				
				$("#firstname").focus();	
				return false;
			}
			else	if($("#firstname").val().length < 2){
					alert("Firstname must be at least 2 charachters");
					$("#firstname").focus();	
					return false;	

			}		
			if ($("#lastname").val() =="" )	{
				alert("Please enter your lastname!");				
				$("#lastname").focus();	
				return false;
			}
			else	if($("#lastname").val().length < 2){
					alert("Lastname must be at least 2 charachters");
					$("#lastname").focus();	
					return false;	

			}		
			if ($("#email").val() =="" )	{
				alert("Please enter your email!");				
				$("#email").focus();	
				return false;
			}
			else	if(!IsEmail ( $("#email").val() ) ){
					alert("Please provide a valid email");
					$("#email").focus();	
					return false;	

			}	
			
			if ($("#newpass").val() =="" )	{
				alert("Please enter your password!");				
				$("#newpass").focus();	
				return false;
			}
			else	if($("#newpass").val().length < 8){
					alert("Password must be at least 8 charachters");
					$("#newpass").focus();	
					return false;	

			}	
			if ($("#newpass1").val() =="" )	{
				alert("Please confrim your password!");				
				$("#newpass1").focus();	
				return false;
			}
			else	if( $("#newpass").val() !=  $("#newpass1").val() ){
					alert("Passwords do not match!");
					$("#newpass").focus();	
					return false;	

			}

			/*if ($("#birthdate").datepicker("getDate") ===NULL)	{
				alert("Please select your birthdate!");				
				$("#email").focus();	
				return false;
			}*/
			
			
			
		});





	}

);