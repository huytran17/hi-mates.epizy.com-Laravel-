<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
	use HasFactory;

    protected $fillable = [
        'token', 'email', 'created_at'
    ];

    public function scopeGetPRByToken($query, $token)
    {
        return $query->where('token', $token);
    }

    public function getByToken($token)
    {
        return $this->getPRByToken($token)->firstOrFail();
    }

    public function createPasswordReset($data)
    {
        try {
        	$this->updateOrCreate([
        		'email' => $data['email']
        	], [
        		'token' => $data['token'],
        	]);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }

        return response()->axios([
            'error' => false,
        ]);
    }
}
