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
				  <div class="form-group">
				    <label for="mobilenumber" class="col-sm-2 control-label">Boost Vote?</label>
				    <div class="col-sm-10">
				      <input type="checkbox" id="boostpost" name="boostvote" onclick="showboostform();"> You can boost your vote for $1
				    </div>
				  </div>
				  <div id="payment-form" style="display: none;"></div>
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

<script>
// We generated a client token for you so you can test out this code
// immediately. In a production-ready integration, you will need to
// generate a client token on your server (see section below).
var clientToken = "eyJ2ZXJzaW9uIjoyLCJhdXRob3JpemF0aW9uRmluZ2VycHJpbnQiOiJkZjkwZWYwMjEzODI5MGE2MDJlODlhNDQxZDViMWJkOTM0MWY2OGI0MGM3ZWYwZmRjMjY4ZDJhZDM2NzAxODY0fGNyZWF0ZWRfYXQ9MjAxNS0wOC0xNlQwMzoyOTo1NS43MjI3MzEyNDcrMDAwMFx1MDAyNm1lcmNoYW50X2lkPTM0OHBrOWNnZjNiZ3l3MmJcdTAwMjZwdWJsaWNfa2V5PTJuMjQ3ZHY4OWJxOXZtcHIiLCJjb25maWdVcmwiOiJodHRwczovL2FwaS5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tOjQ0My9tZXJjaGFudHMvMzQ4cGs5Y2dmM2JneXcyYi9jbGllbnRfYXBpL3YxL2NvbmZpZ3VyYXRpb24iLCJjaGFsbGVuZ2VzIjpbXSwiZW52aXJvbm1lbnQiOiJzYW5kYm94IiwiY2xpZW50QXBpVXJsIjoiaHR0cHM6Ly9hcGkuc2FuZGJveC5icmFpbnRyZWVnYXRld2F5LmNvbTo0NDMvbWVyY2hhbnRzLzM0OHBrOWNnZjNiZ3l3MmIvY2xpZW50X2FwaSIsImFzc2V0c1VybCI6Imh0dHBzOi8vYXNzZXRzLmJyYWludHJlZWdhdGV3YXkuY29tIiwiYXV0aFVybCI6Imh0dHBzOi8vYXV0aC52ZW5tby5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tIiwiYW5hbHl0aWNzIjp7InVybCI6Imh0dHBzOi8vY2xpZW50LWFuYWx5dGljcy5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tIn0sInRocmVlRFNlY3VyZUVuYWJsZWQiOnRydWUsInRocmVlRFNlY3VyZSI6eyJsb29rdXBVcmwiOiJodHRwczovL2FwaS5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tOjQ0My9tZXJjaGFudHMvMzQ4cGs5Y2dmM2JneXcyYi90aHJlZV9kX3NlY3VyZS9sb29rdXAifSwicGF5cGFsRW5hYmxlZCI6dHJ1ZSwicGF5cGFsIjp7ImRpc3BsYXlOYW1lIjoiQWNtZSBXaWRnZXRzLCBMdGQuIChTYW5kYm94KSIsImNsaWVudElkIjpudWxsLCJwcml2YWN5VXJsIjoiaHR0cDovL2V4YW1wbGUuY29tL3BwIiwidXNlckFncmVlbWVudFVybCI6Imh0dHA6Ly9leGFtcGxlLmNvbS90b3MiLCJiYXNlVXJsIjoiaHR0cHM6Ly9hc3NldHMuYnJhaW50cmVlZ2F0ZXdheS5jb20iLCJhc3NldHNVcmwiOiJodHRwczovL2NoZWNrb3V0LnBheXBhbC5jb20iLCJkaXJlY3RCYXNlVXJsIjpudWxsLCJhbGxvd0h0dHAiOnRydWUsImVudmlyb25tZW50Tm9OZXR3b3JrIjp0cnVlLCJlbnZpcm9ubWVudCI6Im9mZmxpbmUiLCJ1bnZldHRlZE1lcmNoYW50IjpmYWxzZSwiYnJhaW50cmVlQ2xpZW50SWQiOiJtYXN0ZXJjbGllbnQzIiwibWVyY2hhbnRBY2NvdW50SWQiOiJhY21ld2lkZ2V0c2x0ZHNhbmRib3giLCJjdXJyZW5jeUlzb0NvZGUiOiJVU0QifSwiY29pbmJhc2VFbmFibGVkIjpmYWxzZSwibWVyY2hhbnRJZCI6IjM0OHBrOWNnZjNiZ3l3MmIiLCJ2ZW5tbyI6Im9mZiJ9";

braintree.setup(clientToken, "dropin", {
  container: "payment-form"
});
</script>