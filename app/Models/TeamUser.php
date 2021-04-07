<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class TeamUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'team_user';

    protected $fillable = ['user_id', 'team_id', 'nickname'];

    public function scopeGetByFkey($query, $uid, $tid)
    {
        return $query->where([
        	'team_id' => $tid,
        	'user_id' => $uid
        ]);
    }

    public function isExists($uid, $tid)
    {
        return $this->getByFkey($uid, $tid)->exists();
    }

    public function updateTeamUser($data, $uid, $tid)
    {
        try {
            $this->getByFkey($uid, $tid)->update($data);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
    }

    public function createTeamUser($uid, $tid)
    {
        try {
            $this->create([
                'user_id' => $uid,
                'team_id' => $tid,
            ]);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
    }

    public function destroyMember($uid, $tid)
    {
        try {
            DB::transaction(function() use ($uid, $tid) {
                $this->getByFkey($uid, $tid)->forceDelete();
            });
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
    }
}
