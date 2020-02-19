<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    //
    protected $guarded = [];

    protected $dates = ['livedate'];

    public function path() {
        // return url('/templates/' . $this->id);
        return '/templates/' . $this->id;
    }

    public function setLivedateAttribute($livedate)
    {
        $this->attributes['livedate'] = Carbon::parse($livedate);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
