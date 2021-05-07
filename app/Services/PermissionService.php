<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    /**
     * @var Permission
     */
    protected $permission;

    /**
     * PermissionService constructor.
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Method to get all the permissions
     * @param $request
     * @param $limit
     * @return LengthAwarePaginator
     */
    public function getAllPermissions($request, $limit=10)
    {
        $permission = $this->permission->query();

        // check if request has limit
        if ($request->limit)
            $limit = $request->limit;

        // check if request has a search term
        if ($request->search)
            $permission->where('name', 'LIKE', "%{$request->search}%");

        return $permission->paginate($limit);
    }

    /**
     * Method to create a permission
     * @param $request
     */
    public function createPermission($request)
    {
        $this->permission->create(['name' => $request->name]);
    }

    /**
     * Method to find the permission detail
     * @param $id
     * @return mixed
     */
    public function getPermission($id)
    {
        // fetch the permission by id
        $permission = $this->permission->find($id);

        // throw not found error if unable to find the permission
        if (!$permission)
            throw new ModelNotFoundException('Unable to find the permission');

        return $permission;
    }

    /**
     * Method to update the permission name
     * @param $id
     * @param $request
     */
    public function updatePermission($id, $request)
    {
        // fetch the permission by id
        $permission = $this->permission->find($id);

        // throw not found error if unable to find the permission
        if (!$permission)
            throw new ModelNotFoundException('Unable to find the permission');

        // update the permission name
        $permission->name = $request->name;
        $permission->save();
    }

    /**
     * Method to delete the permission
     * @param $id
     */
    public function deletePermission($id)
    {
        // fetch the permission by id
        $permission = $this->permission->find($id);

        // throw not found error if unable to find the permission
        if (!$permission)
            throw new ModelNotFoundException('Unable to find the permission');

        $permission->delete();
    }
}