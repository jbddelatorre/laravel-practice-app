<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tournament;
use App\Team;
use App\Player;
use App\TournamentSubcategory;
use App\ParticipantTournament;

class HostDashboardController extends Controller
{
    function getTournaments() {
    	$current_id = auth()->user()->id;
    	$tournaments = Tournament::where('user_id', $current_id)->where('status', 1)->get();

    	$ongoing = Tournament::where('user_id', $current_id)->where('status', 2)->get();

    	$completed = Tournament::where('user_id', $current_id)->where('status', 3)->get();

    	$tournament_ids = [];

    	foreach($tournaments as $t) {
    		$subcats = [];
    		$subcategory = TournamentSubcategory::where('tournament_id', $t->id)->get();

    		foreach($subcategory as $sc) {
                $teams = Team::where('tournament_id', $t->id)->where('subcategory_id', $sc->subcategory_id)->get();

                $subcats[$sc->subcategory_id] = $teams;
    		}

    		$tournament_ids[$t->id] = $subcats;
    	}

    	return view('host.dashboard.dashboard', compact('tournaments', 'tournament_ids', 'ongoing', 'completed'));
    }

    function registerTournament(Request $request) {

    	$this->validate($request, [
    		'name' => 'required',
    		'location' => 'required',
    		'startdate' => 'required',
    		'subcategories' => 'required|array|between:1,10',
    		'enddate' => 'required_without:onedaytournament|sometimes|after_or_equal:startdate',
    	],[
    		'name.required' => 'Please enter a tournament name.',
    		'location.required' => 'Please enter a tournament location.',
    		'startdate.required' => 'Please specify tournament date.',
    		'subcategories.required' => 'Please check tournament division.',
    		'enddate.required_without' => 'Please specify tournament duration.',
    		'enddate.after_or_equal' => 'Make sure end date is correct.'
    	]);

    	$tournament = new Tournament;

    	$current_id = auth()->user()->id;

    	$tournament->name = $request->name;
    	$tournament->location = $request->location;
    	$tournament->user_id = $current_id;
    	$tournament->date_start = $request->startdate;

    	if($request->onedaytournament) {
    		$tournament->date_end = $request->startdate;
    	} else {
    		$tournament->date_end = $request->enddate;
    	}

    	$tournament->status = 1;

    	$tournament->save();

    	$tournament_id = $tournament->id;
    	$arr_sub = $request->subcategories;

    	foreach($arr_sub as $sub) {
    		$ts = new TournamentSubcategory;
    		$ts->tournament_id = $tournament_id;
    		$ts->subcategory_id = $sub;
    		$ts->save();
    	}
    	return redirect('/host')->with('success', 'Tournament '.$request->name.' Created!');
    }


    function deleteTournament($id) {
        $tournament = Tournament::find($id);
        $tournament_subcategories = TournamentSubcategory::where('tournament_id', $id);
        $teams = Team::where('tournament_id', $id);
        $players = Player::where('tournament_id', $id);
        $participants_tournaments = ParticipantTournament::where('tournament_id', $id);

        $players->delete();
        $teams->delete();
        $participants_tournaments->delete();
        $tournament_subcategories->delete();
        $tournament->delete();

        return redirect('/host')->with('success', "Successfully deleted Tournament!");
    }

}
