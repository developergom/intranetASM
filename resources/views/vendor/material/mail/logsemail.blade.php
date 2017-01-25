<div style="width:100%;background-color:'#cccccc';margin-left:auto;margin-right:auto;">
	<div style="width:75%;background-color:'#ffffff';padding:'15px';text-align:'center';">
		<h1>Access log intranet ASM</h1><br/>
		<table class="table">
			<thead>
				<tr>
					<th>IP Address</th>
					<th>Device</th>
					<th>URL</th>
					<th>OS</th>
					<th>Browser</th>
					<th>User</th>
					<th>Time</th>
				</tr>
			</thead>
			<tbody>
			@foreach($data['logs'] as $row)
				<tr>
					<td>{{ $row->log_ip }}</td>
					<td>{{ $row->log_device }}</td>
					<td>{{ $row->log_url }}</td>
					<td>{{ $row->log_os }}</td>
					<td>{{ $row->log_browser }}</td>
					<td>{{ $row->created_by }}</td>
					<td>{{ $row->created_at }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<br/>
		Regards,<br/>
		<b>Intranet ASM Apps</b>
	</div>
</div>