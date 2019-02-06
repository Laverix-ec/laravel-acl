<?php

namespace SlonCorp\Acl\Models\Eloquent;


use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * Modules constants
     */
    const MODULE_GXR = 1;
    const MODULE_ROADS = 2;
    const MODULE_CONFIGURATION = 3;

    /**
     * The attributes that are fillable via mass assignment.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'image', 'icon'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modules';

    /**
     * Modules can have many permissions.
     *
     * @return Model
     */
    public function permissions()
    {
        $model = config('acl.permission', 'SlonCorp\Acl\Models\Eloquent\Permission');

        return $this->hasMany($model)->withTimestamps()->where('enabled', 1);
    }
}
