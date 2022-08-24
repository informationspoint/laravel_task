<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $table = 'team_members';

    protected $fillable = [
        'full_name',
        'email'
    ]; 

    public function mortageVolumn()
    {
        return $this->hasOne(MortageVolumn::class,'team_member_id', 'id')->orderby('id','desc')->latest();
    }

    public function mortageVolumns()
    {
        return $this->hasMany(MortageVolumn::class,'team_member_id', 'id');
    }
}
