<div class="container">
	<div class="row">
		<div class="row">
	        <div class="col-md-12">
	        	<h2>$Room.Title <small>$Room.Type</small></h2>
	        	
	        	<p>Start typing a song name to request a song</p>
	        	
	        	<div id="addOptionresponse"></div>
	        	
	        	<form class="form-horizontal ajaxform" method="post" name="addOption" action="/room/addOption">
				  <div class="form-group">
				    <label for="mobilenumber" class="col-sm-2 control-label">Request A Song</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control typeahead" id="song" name="song" placeholder="Gangnam Style">
				    </div>
				  </div>
				  <input type="hidden" name="roomid" value="$Room.ID">
				  <input type="hidden" id="lastFMResponse" name="lastFMResponse">
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
        		<ul id="songListing">
        		<% loop $Room.sortedOptions %>
        		<li>
        			<span class="img">
        				<img src="$Image">
        			</span>
        			
        			<span class="title">$Song</span><br />
        			<span class="artist">$Artist</span>
        			$Position
        			<div class="buttons">
        			<button class="btn btn-success" onclick="registervote(true,$Top.Room.ID,$ID,this);"><i class="glyphicon glyphicon-menu-up"></i></button> <button class="btn btn-danger" onclick="registervote(false,$Top.Room.ID,$ID,this);"><i class="glyphicon glyphicon-menu-down"></i></button>
        			</div>
        			<div style="clear: both;"></div>
        		</li>
        		<% end_loop %>
        		</ul>
        	</div>
        </div>
	</div>
</div>