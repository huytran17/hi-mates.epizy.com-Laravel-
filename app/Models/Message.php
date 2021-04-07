<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'team_id', 'content', 'parent_id'];

    protected $appends = ['nickname', 'encrypted_id', 'dmy_created_at'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User')->withTrashed();
    }

    public function team()
    {
    	return $this->belongsTo('App\Models\Team')->withTrashed();
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Message', 'parent_id')->withTrashed()->with('user');
    }

    public function getNicknameAttribute($value)
    {
        $team_user = \App\Models\TeamUser::where([
            'user_id' => $this->attributes['user_id'], 
            'team_id' => $this->attributes['team_id']
        ]);

        if ($team_user->exists()) 
        {
            return $team_user->first()->nickname;
        }
        return null;
    }

    public function getEncryptedIdAttribute($value)
    {
        return base64_encode($this->attributes['id']);
    }

    public function getDmyCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i', strtotime($this->attributes['created_at']));
    }

    public function scopeGetLimitMessages($query, $skip, $take)
    {
        return $query->skip($skip)->take($take);
    }

    public function scopeGetMessageById($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeGetMessWithAllRelated($query)
    {
        return $query->with(['user', 'team', 'parent']);
    }

    public function scopeGetMessageByTeamId($query, $teamid)
    {
        return $query->where('team_id', $teamid);
    }

    public function getByTeamId($tid)
    {
        return $this->getMessWithAllRelated()->getMessageByTeamId($tid);
    }

    public function getById($id)
    {
        return $this->getMessWithAllRelated()->find($id);
    }

    public function createMessage($data)
    {
        try {
            return $this->create($data);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }

        return response()->axios([
            'error' => false,
        ]);
    }

    public function destroyMessage($id)
    {
        try {
            $this->getById($id)->delete();
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }

        return response()->axios([
            'error' => false
        ]);
    }
}
