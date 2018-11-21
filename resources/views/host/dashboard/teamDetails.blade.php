@extends('layouts.app')

@section('content')
	<div class="container">
		<h2>View Registration Detail</h2>
		<h3>Tournament: {{$tournament->name}}</h3>
		<h3>Subcategory: {{$subcat_id}}</h3>

		<div class="row my-4">
			<div class="col-sm-12">
				<a href="/host" class="btn btn-outline-primary">Return to Dashbaord</a>
			</div>
		</div>
		
		<div class="row">
			@foreach($teams as $team)
				<div class="col-sm-6">
					<div class="card my-2">
						<div class="card-header">
							Team Name: {{$team->team_name}}
						</div>
						<div class="card-body">
							<p class="card-text">
								Organization: {{$team->user->organization}}	
							</p>
							<p class="card-text">
								Coach Name: {{$team->coach_name}}
							</p>
							<p class="card-text">
								Coach Number: {{$team->mobile_number}}	
							</p>
							<div class="row mb-3" style="padding-left: 10px;">
								<div class="col-sm-6">Player Names</div>
								<div class="col-sm-6">Date of Birth</div>
							</div>
							@foreach($team->players as $player)
								<div class="row" style="padding-left: 10px;">
									<div class="col-sm-6">
										{{$player->name}}
									</div>
									<div class="col-sm-6">
										{{$player->date_of_birth}}
									</div>
								</div>
							@endforeach

						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection