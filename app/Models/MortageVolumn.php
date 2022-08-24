<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MortageVolumn extends Model
{
    use HasFactory;
    protected $table = 'mortage_volumns';

    protected $fillable = [
        'date',
        'amount',
        'team_member_id'
    ]; 

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }
}
