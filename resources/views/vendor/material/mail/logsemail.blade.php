<div style="width:100%;background-color:'#cccccc';margin-left:auto;margin-right:auto;">
	<div style="width:75%;background-color:'#ffffff';padding:'15px';text-align:'center';">
		<h1>Access log intranet ASM</h1><br/>
		<table class="table">
			<thead>
				<tr>
					<th>NIK</th>
					<th>Name</th>
					<th>Total Request</th>
				</tr>
			</thead>
			<tbody>
			@foreach($data['logs'] as $row)
				<tr>
					<td>{{ $row->user_name }}</td>
					<td>{{ $row->user_firstname . ' ' . $row->user_lastname }}</td>
					<td>{{ $row->total }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<br/>
		Regards,<br/>
		<b>Intranet ASM Apps</b>
	</div>
</div>