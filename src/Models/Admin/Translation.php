<?php

namespace Tripteki\SettingLocale\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = "string";

    /**
     * @var string
     */
    protected $primaryKey = "key";

    /**
     * @var array
     */
    protected $fillable = [ "key", "translate", ];

    /**
     * @var array
     */
    protected $hidden = [ "language_code", ];
};
