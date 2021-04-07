<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Avatar;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
        'slug',
        'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $appends = [
        'encrypted_id', 'dmy_created_at',
    ];

    public function messages()
    {
        return $this->hasMany('App\Models\Message')->withTrashed();
    }

    public function teams()
    {
        return $this->belongsToMany('App\Models\Team', 'team_user')->withTrashed()->withPivot('nickname')->withTimestamps()->orderBy('team_user.created_at', 'desc');
    }

    public function scopeCurrentUser($query)
    {
        return $query->where('id', auth()->id());
    }

    public function scopeGetUserByName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function scopeGetUserByEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    public function scopeGetUserByTeamId($query, $teamid)
    {
        return $query->where('team_id', $teamid);
    }

    public function scopeGetUserWithAllRelated($query)
    {
        return $query->with(['teams', 'messages']);
    }

    public function scopeGetUserWith($query, array $relate)
    {
        return $query->with($relate);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getProfilePhotoPathAttribute($value)
    {
        if (empty($this->attributes['profile_photo_path'])) {
            return Avatar::create($this->attributes['name'])
            ->setDimension(80, 80)
            ->setFontSize(40)
            ->setShape('circle')
            ->toBase64()
            ->encoded;
        }
        return $this->attributes['profile_photo_path'];
    }

    public function getDmyCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($this->attributes['created_at']));
    }

    public function getEncryptedIdAttribute($value)
    {
        return base64_encode($this->attributes['id']);
    }

    public function makeHash($value)
    {
        return Hash::make($value);
    }

    public function getByTeamId($userid, $teamid)
    {
        return $this->with(['teams' => function($query) use ($teamid) {
            $this->getUserByTeamId($teamid);
        }])->findOrFail($userid);
    }

    public function getByIdWithRelateOnly(array $relate, $id)
    {
        return $this->getUserWith($relate)->findOrFail($id);
    }

    public function getByName($name)
    {
        return $this->getUserByName($name)->first();
    }

    public function getByEmail($email)
    {
        return $this->getUserByEmail($email);
    }

    public function getById($id)
    {
        return $this->getUserWithAllRelated()->find($id);
    }

    public function getByIdWithException($id)
    {
        return $this->getUserWithAllRelated()->findOrFail($id);
    }

    public function updatePwd($data)
    {
        try {
            $this->update($data);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
    }

    public function updateUser($data)
    {
        try {
            $this->currentUser()->update($data);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
    }

    public function createUser($data)
    {
        $user = $this;
        try {
            $user = $this->create($data);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }

        return $user;
    }

    public function register($data)
    {
        $user = $this->createUser([
            'name' => $data['name'],
            'email' => $data['email'],
            'slug' => $data['name'],
            'password' => $this->makeHash($data['password']),
        ]);

        auth()->login($user);

        return redirect('/');
    }

    public function login($data)
    {
        $credentials = $data;

        if (auth()->attempt($credentials, true)) {
            return redirect()->intended('/');
        }
        return redirect()->back()->withInput($data)->withErrors(['name' => 'Tên đăng nhập hoặc mật khẩu không đúng']);
    }
}
