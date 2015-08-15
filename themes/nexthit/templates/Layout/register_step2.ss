<div class="container">
	<div class="row">
		<div class="row">
	        <div class="col-md-12">
	        	<h3>Register</h3>
	        	<p>Register for an account below. Type in your mobile number and we'll send you a text message to verify your account.</p>
	        	
	        	<div id="registerformresponse"></div>
	        	
	        	<form class="form-horizontal ajaxform" method="post" name="completeregister" action="{$Link}register/go2">
				  <div class="form-group">
				    <label for="mobilenumber" class="col-sm-2 control-label">Mobile Number</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" placeholder="04" maxlength="10">
				    </div>
				  </div>
				  
				  <div class="form-group">
				    <label for="verificationcode" class="col-sm-2 control-label">Verification Code</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="verificationcode" name="verificationcode" maxlength="6">
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="submit" class="btn btn-success">Complete Registration</button>
				    </div>
				  </div>
				</form>
	        </div>
        </div>
	</div>
</div>