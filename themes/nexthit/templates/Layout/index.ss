<div class="jumbotron">
  <div class="container">
    <h2>Start your NextHit</h2>
    <h3>People powered music. Vote for your favourite music.</h3>
    <% if $SessionError %>
    <div class="alert alert-danger">$SessionError</div>
    <% end_if %>
    <div id="roomformresponse"></div>
    <form class="form-inline ajaxform" method="post" name="roomform" action="/room/createajax">
	  <div class="form-group">
	    <label for="eventname">My event is called</label>
	    <input type="text" class="form-control" id="eventname" name="eventname" placeholder="Sarah's Birthday">
	  </div>
	  <button type="submit" class="btn btn-default">Go</button>
	</form>
  </div>
</div>