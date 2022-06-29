<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrItinerary extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mr_itineraries';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $casts = [
        'from_date' => 'datetime',
        'to_date' => 'datetime'
    ];

    protected $dates = [
        'from_date' => 'datetime',
        'to_date' => 'datetime'
    ];

    protected $dateFormat = 'd-m-Y';
}
