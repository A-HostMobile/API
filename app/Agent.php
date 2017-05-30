<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'AGENTS';
    protected $fillable = ['A_LABEL','A_LATTITUDE','A_LONGTITUDE'];
    protected $key = 'A_AGENT_ID';
}
