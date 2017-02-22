<?php

namespace WebModularity\LaravelSession;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $timestamps = false;

    public function getIpAddressAttribute($value)
    {
        return inet_ntop($value);
    }

    public function setIpAddressAttribute($value)
    {
        $this->attributes['ip_address'] = inet_pton($value);
    }
}
