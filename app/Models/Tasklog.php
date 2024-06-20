<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasklog extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
    ];        

    protected $guarded = ['id'];
    protected $table = 'tasklogs';
}
/*
TIAGO J1603 DOOR => numero da Unit: J1603
Dr. TILE 6-313 RENO BACKSPLASH => numero da Unit: 6-313
Dr. TILE 6-107 RENO BACKSPLASH => numero da Unit: 6-107
Dr. TILE  10-205 RENO BACKSPLASH => numero da Unit: 10-205
PAULO G308 **DRYWALL REPAIR => numero da Unit: G308
PASTOR J305 FIX => numero da Unit: J305
PAULO 2110 **FIX => numero da Unit: 2110
TIAGO 14120 BASEBOARD => numero da Unit: 14120
TIAGO 11AM 809 CHECK THE DOOR => numero da Unit: 809 (deve saltar o 11AM)
ARTUR 8-411 **(PAINT / PUNCH / CLEAN) + TRASH REMOVAL => numero da Unit: 8-411
PASTOR 1603 FIX => numero da Unit: 1603
PASTOR 417 LIVING ROOM CEILING => numero da Unit: 417
TIAGO + FERNANDO 8AM CABINETS 335 ** => numero da Unit:  335
CLEYTON 6-107 RENO OUTLET => numero da Unit: 6-107
CLEYTON 6-313 RENO OUTLET => numero da Unit: 6-313
CLEYTON  10-205 RENO OUTLET => numero da Unit: 10-205
*/
