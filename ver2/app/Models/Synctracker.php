<?php

namespace App\Models;


class Synctracker extends MyModel
{
    //
	public function createNewSyncTracker($action, $school, $model, $id)
	{
		$sync = new Synctracker();
		$sync->action = $action;
		$sync->school_id = $school->id;
		$sync->model = $model;
		$sync->instanceId = $id;
		$sync->save();
		//dd($sync);
		return $sync;
	}
}
