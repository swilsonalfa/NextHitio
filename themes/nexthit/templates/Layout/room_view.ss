<div class="container">
	<div class="row">
		<div class="row">
	        <div class="col-md-12">
	        	<h2>$Room.Title <small>$Room.Type</small></h2>
	        	
	        	<p>Start typing a song name to request a song</p>
	        	
	        	<script>
	        	
	        	</script>
	        	
	        	<form class="form-horizontal ajaxform" method="post" name="registerform" action="{$Link}register/go">
				  <div class="form-group">
				    <label for="mobilenumber" class="col-sm-2 control-label">Request A Song</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control typeahead" id="song" name="song" placeholder="Gangnam Style">
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="submit" class="btn btn-success">Request</button>
				    </div>
				  </div>
				</form>
	        </div>
        </div>
        
        <div class="row">
        	<div class="col-md-12">
        	
        	</div>
        </div>
	</div>
</div>