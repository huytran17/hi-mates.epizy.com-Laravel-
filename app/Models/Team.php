<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use DB;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'join_code', 'created_by'];

    protected $appends = ['encrypted_id'];

    public function team_data()
    {
    	return $this->hasOne('App\Models\TeamData');
    }

    public function messages()
    {
    	return $this->hasMany('App\Models\Message')->withTrashed()->with(['user', 'parent'])->latest()->take(20);
    }

    public function allMessages()
    {
        return $this->hasMany('App\Models\Message')->withTrashed()->with(['user', 'parent']);
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'team_user')->withPivot('nickname')->withTimestamps()->orderBy('team_user.created_at', 'asc');
    }

    public function getEncryptedIdAttribute($value)
    {
        return base64_encode($this->attributes['id']);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function scopeGetTeamWithAllRelated($query)
    {
        return $query->with(['users', 'messages', 'team_data']);
    }

    public function scopeGetTeamWith($query, array $relate)
    {
        return $query->with($relate);
    }

    public function scopeGetTeamByJoinCode($query, $joincode)
    {
        return $query->where('join_code', $joincode);
    }

    public function scopeCountUser($query)
    {
        return $query->withCount('users');
    }

    public function scopeCurrentTeam($query, $teamid)
    {
        return $query->where('id', $teamid);
    }

    /**
     * public function scopeGetOnlyFields($query, $fields)
    {
        return $query->select($fields);
    }
     */

    public function getById($id)
    {
        return $this->getTeamWithAllRelated()->find($id);
    }

    public function getByIdWithException($id)
    {
        return $this->getTeamWithAllRelated()->findOrFail($id);
    }

    public function getByIdWithRelateOnly(array $relate, $id)
    {
        return $this->getTeamWith($relate)->findOrFail($id);
    }

    public function getByIdWithCountUser($id)
    {
        return $this->getTeamWithAllRelated()->countUser()->find($id);
    }

    public function getByJoinCode($joincode)
    {
        return $this->getTeamByJoinCode($joincode)->first();
    }

    public function hasJoinCode($joincode)
    {
        return $this->getTeamByJoinCode($joincode)->exists();
    }

    public function createTeam($data)
    {
        try {
            $this->create($data);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }

        return response()->axios([
            'error' => false,
        ]);
    }

    public function updateTeam($data, $teamid)
    {
        try {
            $this->currentTeam($teamid)->update($data);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
    }

    public function destroyTeam($tid)
    {
        try {
            DB::transaction(function() use ($tid) {
                $this->currentTeam($tid)->forceDelete();
            });
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }

        return response()->axios([
            'error' => false,
        ]);
    }
}
