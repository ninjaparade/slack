<script type="text/template" data-grid="slackchannel" data-template="results">

	<% _.each(results, function(r) { %>

		<tr data-grid-row>
			<td><input content="id" input data-grid-checkbox="" name="entries[]" type="checkbox" value="<%= r.id %>"></td>
			<td><a class="btn btn-warning btn-sm" href="<%= r.edit_uri %>" href="<%= r.edit_uri %>">EDIT</a></td>
			<td><%= r.name %></td>
			<td><%= r.send_as %></td>
			
			<%if( parseInt(r.default)  === 1) { %>
				<td><span class="label label-success">Default</span></td>
			<%}else{%>
				<td><span class="label label-default">Other</span></td>
			<%}%>
			
			<%if( parseInt(r.active)  === 1) { %>
				<td><span class="label label-success">Active</span></td>
			<%}else{%>
				<td><span class="label label-danger">Not Active</span></td>
			<%}%>
			
			<td><%= r.created_at %></td>
		</tr>

	<% }); %>

</script>
