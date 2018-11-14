<h2>My Registered Tournaments</h2>
<div class="row">
	<div class="col sm-12">
		@foreach($my_tournaments as $t)
			<div class="card bg-faded my-3 pt-2">
				<div class="card-body">
					<div class="row align-items-center">
						<div class="col-sm-5">
							<h6 class="card-title">{{$t->name}}</h6>
							<h6 class="card-title">{{$t->location}}</h6>
							<h6 class="card-title">
								@if($t->date_start == $t->date_end)
									{{$t->date_start}}
								@else
									{{$t->date_start}} to {{ $t->date_end }}
								@endif
							</h6>	
						</div>
						<div class="col-sm-4">
							<div class="row my-2">
								<div class="col-sm-4">
									Team Name
								</div>
								<div class="col-sm-8 subcat-content">
									Division
								</div>
							</div>
							<ul style="list-style-type: none; padding-left: 10px;">
								@foreach($registeredTeams[$t->id] as $team)
									<li>
										<div class="row">
											<div class="col-sm-4">
												{{$team['teamname']}}
											</div>
											<div class="col-sm-8 subcat-content">
												{{$team['data']}}
											</div>
										</div>
									</li>
								@endforeach
							</ul>
						</div>
						<div class="col-sm-3 ">
							<div class="row justify-content-center">
								<form action="/participant/viewregistration/{{$t->id}}" method="GET">
									@csrf
									<button class="btn btn-primary">View Team Registration</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>