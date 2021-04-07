<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'team_data';

    protected $fillable = ['user_id', 'team_id', 'color', 'background'];

    public function team()
    {
    	return $this->belongsTo('App\Models\Team');
    }

    public function scopeGetTeamDataById($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeCurrentTeamData($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeGetTeamDataByTeamId($query, $teamid)
    {
        return $query->where('team_id', $teamid);
    }

    public function scopeGetTeamDataByUserId($query, $userid)
    {
        return $query->where('user_id', $userid);
    }

    public function createTeamData($teamid)
    {
        try {
			$this->create([
			    'team_id' => $teamid,
		        'color' => '#F2EAEA',
	        ]);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
    }

    public function updateTeamData($data, $id)
    {
        try {
            $this->currentTeamData($id)->update($data);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
    }

    public function updateByTeamId($data, $tid)
    {
        try {
            $this->getTeamDataByTeamId($tid)->update($data);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
    }
}
