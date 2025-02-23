<?php

namespace Laverix\Acl\Models\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Laverix\Acl\Traits\HasPermission;

class Role extends Model
{
    use HasPermission;

    /**
     * The attributes that are fillable via mass assignment.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'enabled', 'editable'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Roles can belong to many users.
     *
     * @return Model|mixed
     */
    public function users()
    {
        $model = config('auth.providers.users.model', 'Laverix\Acl\Models\Eloquent\User');

        return $this->belongsToMany($model)->withTimestamps();
    }

    /**
     * Checks if the role has the given permission.
     *
     * @param string $permission
     * @param string $operator
     * @param array $mergePermissions
     * @return bool
     */
    public function can($permission, $operator = null, $mergePermissions = [])
    {
        $operator = is_null($operator) ? $this->parseOperator($permission) : $operator;

        $permission = $this->hasDelimiterToArray($permission);
        $permissions = $this->getPermissions() + $mergePermissions;

        // make permissions to dot notation.
        // create.user, delete.admin etc.
        $permissions = $this->toDotPermissions($permissions);

        // validate permissions array
        if (is_array($permission)) {

            if (!in_array($operator, ['and', 'or'])) {
                $e = 'Invalid operator, available operators are "and", "or".';
                throw new \InvalidArgumentException($e);
            }

            $call = 'canWith' . ucwords($operator);

            return $this->$call($permission, $permissions);
        }

        // validate single permission
        return isset($permissions[$permission]) && $permissions[$permission] == true;
    }

    /**
     * List all permissions
     *
     * @return mixed
     */
    public function getPermissions()
    {
        return \Cache::remember('acl.getPermissionsInheritedById_' . $this->id, config('acl.cacheMinutes'), function () {
            return $this->getPermissionsInherited();
        });
    }

    /**
     * @param $permission
     * @param $permissions
     * @return bool
     */
    protected function canWithAnd($permission, $permissions)
    {
        foreach ($permission as $check) {
            if (!in_array($check, $permissions) || !isset($permissions[$check]) || $permissions[$check] != true) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $permission
     * @param $permissions
     * @return bool
     */
    protected function canWithOr($permission, $permissions)
    {
        foreach ($permission as $check) {
            if (in_array($check, $permissions) && isset($permissions[$check]) && $permissions[$check] == true) {
                return true;
            }
        }

        return false;
    }

}