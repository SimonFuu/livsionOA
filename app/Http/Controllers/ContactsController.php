<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactsController extends Controller
{
    public function showIndex(Request $request)
    {
        if ($request -> ajax()) {
            $users = DB::table('system_users')
                -> select(
                    'system_users.username',
                    'system_users.name',
                    'system_users.telephone',
                    'system_users.officeTel',
                    'system_users.email',
                    'system_departments.departmentName',
                    'system_positions.positionName'
                )
                -> leftJoin('system_departments', 'system_departments.id', '=', 'system_users.departmentId')
                -> leftJoin('system_positions', 'system_positions.id', '=', 'system_users.positionId')
                -> where('system_users.status', 1)
                -> whereIn('system_users.departmentId', $this -> getChildrenDepartmentsAndSelf($request -> did))
                -> orderBy('system_users.weight', 'asc')
                -> paginate(self::PER_PAGE_RECORD_COUNT);
            return ['status' => true, 'message' => '获取成功！', 'data' => [
                'users' => $users, 'pagination' => (string) $users -> appends(['did' => $request -> did]) -> links()
            ]];
        } else {
            $dbDepartments = DB::table('system_departments')
                -> select('*')
                -> where('isDelete', 0)
                -> orderBy('weight', 'ASC')
                -> get();
            if (count($dbDepartments) > 0) {
                $departments = $this -> treeView($dbDepartments, 'parentDepartment');
                $departmentsHtml = $this -> treeViewDepartmentsHtml($departments);
            } else {
                $departmentsHtml = '';
            }
            $users = DB::table('system_users')
                -> select(
                    'system_users.username',
                    'system_users.name',
                    'system_users.telephone',
                    'system_users.officeTel',
                    'system_users.email',
                    'system_departments.departmentName',
                    'system_positions.positionName'
                )
                -> leftJoin('system_departments', 'system_departments.id', '=', 'system_users.departmentId')
                -> leftJoin('system_positions', 'system_positions.id', '=', 'system_users.positionId')
                -> where(function ($query) use ($request) {
                    $query -> where('system_users.status', 1);
                    if ($request -> has('name')) {
                        $query -> where('system_users.name', 'like', '%' . $request -> name . '%');
                    }
                    if ($request -> has('did')) {
                        $query -> whereIn('system_users.departmentId',
                            $this -> getChildrenDepartmentsAndSelf($request -> did));
                    }
                })
                -> orderBy('system_users.weight', 'asc')
                -> paginate(self::PER_PAGE_RECORD_COUNT);
            $query = [];
            if ($request -> has('name')) {
                $query['name'] = $request -> name;
            }
            if ($request -> has('did')) {
                $query['did'] = $request -> did;
            }

            return view('contacts.list', ['departmentsHtml' => $departmentsHtml, 'users' => $users, 'query' => $query]);
        }

    }
}
