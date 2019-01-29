<?php

namespace SlonCorp\Acl\Models\Eloquent;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are fillable via mass assignment.
     *
     * @var array
     */
    protected $fillable = ['name', 'label', 'slug', 'description', 'inherit_id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * Permissions can belong to many roles.
     *
     * @return Model
     */
    public function roles()
    {
        $model = config('acl.role', 'SlonCorp\Acl\Models\Eloquent\Role');

        return $this->belongsToMany($model)->withTimestamps()->where('enabled', 1);

    }

    /**
     * Permissions can belong to many users.
     *
     * @return Model|mixed
     */
    public function users()
    {
        $model = config('auth.providers.users.model', 'SlonCorp\Acl\Models\Eloquent\User');

        return $this->belongsToMany($model)->withTimestamps();
    }

    /**
     * Permissions can belong to a module.
     *
     * @return Model|mixed
     */
    public function module()
    {
        $model = config('acl.module', Module::class);

        return $this->belongsTo($model)->withTimestamps();
    }

    /**
     * @param $value
     *
     * @return array
     */
    public function getSlugAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        // if nothing being set, clear slug
        if (empty($value)) {
            $this->attributes['slug'] = '{}';
            return;
        }

        $value = is_array($value) ? $value : [$value => ['allowed' => 'false', 'label' => $value]];

        // remove null values.
        $value = array_filter($value, 'is_array');

        // store as json.
        $this->attributes['slug'] = json_encode($value);
    }

}
