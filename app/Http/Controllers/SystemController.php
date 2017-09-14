<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    public function actionsList()
    {
        $actions = DB::table('system_actions')
            -> select('id', 'actionName', 'description', 'urls', 'weight', 'parentId')
            -> where('isDelete', 0)
            -> paginate(self::PER_PAGE_RECORD_COUNT);
        return view('system.actions.list', ['actions' => $actions]);
    }

    public function setAction(Request $request)
    {
        $action = null;
        if ($request -> has('id')) {
            $a = DB::table('system_actions')
                -> select('id', 'actionName', 'menuUrl', 'urls', 'weight', 'parentId', 'description')
                -> where('isDelete', 0)
                -> where('id', $request -> id)
                -> first();
            $action = empty($a) ? null: $a;
        }
        $pActions = [0 => '一级菜单'];
        $pActs = DB::table('system_actions')
            -> select('id', 'actionName')
            -> where('isDelete', 0)
            -> where('parentId', 0)
            -> get();
        if (count($pActs) !== 0) {
            foreach ($pActs as $pAct) {
                $pActions['二级菜单'][$pAct -> id] = $pAct -> actionName;
            }
        }
        $icons = [];
        $iconsItems = DB::table('system_icons')
            -> select('icon') -> get();
        if ($iconsItems) {
            foreach ($iconsItems as $iconItem) {
                $icons[] = $iconItem -> icon;
            }
        }
        return view('system.actions.set', ['action' => $action, 'pActions' => $pActions, 'icons' => json_encode($icons)]);
    }

    public function storeAction(Request $request)
    {
        $rules = [
            'actionName' => 'required|max:10|unique:system_actions,actionName,'
                . ($request -> has('id')  ? $request -> id : 'NULL') . ',id,isDelete,0',
            'menuUrl' => 'required|max:255',
            'description' => 'required|max:255',
            'urls' => 'required|max:1000',
            'weight' => 'required|numeric|min:1|max:10000',
            'icon' => 'required|exists:system_icons,icon'
        ];
        $message = [
            'actionName.required' => '请输入权限名称！',
            'actionName.unique' => '已存在同名的权限，请确认！',
            'actionName.max' => '权限名称不要超过10个字符！',
            'menuUrl.required' => '请输入左侧菜单URL地址！',
            'menuUrl.max' => '长度请不要超过255！',
            'description.required' => '请输入权限描述',
            'description.max' => '长度不要超过255！',
            'urls.required' => '请输入权限对应的URL地址，一行一个！',
            'urls.max' => 'URL地址总体长度不要该超过1000！',
            'weight.required' => '请输入菜单展示权重！',
            'weight.numeric' => '菜单展示权重格式不正确，请输入1-10000的数字！',
            'weight.min' => '菜单展示权重格式不正确，请输入1-10000的数字！',
            'weight.max' => '菜单展示权重格式不正确，请输入1-10000的数字！',
            'icon.required' => '请选择菜单图标！',
            'icon.exists' => '请选择系统提供的图标！'
        ];
        $this -> validate($request, $rules, $message);
        if ($request -> has('id')) {
            return $this -> updateExistAction($request);
        } else {
            return $this -> storeNewAction($request);
        }
    }

    private function storeNewAction(Request $request)
    {
        $req = $request -> except('_token');
        if ($request -> has('urls')) {
            $req['urls'] = json_encode(explode("\r\n", $request -> urls));
        }
        try {
            DB::table('system_actions')
                -> insert($req);
            return redirect('/system/actions/list') -> with('success', '添加成功！');
        } catch (\Exception $e) {
            return redirect('/system/actions/list') -> with('error', '添加权限失败：' . $e -> getMessage());
        }
    }

    private function updateExistAction(Request $request)
    {
        $req = $request -> except('_token');
        if ($request -> has('urls')) {
            $req['urls'] = json_encode(explode("\r\n", $request -> urls));
        }
        try {
            DB::table('system_actions')
                -> where('id', $request -> id)
                -> where('isDelete', 0)
                -> update($req);
            return redirect('/system/actions/list') -> with('success', '保存成功！');
        } catch (\Exception $e) {
            return redirect('/system/actions/list') -> with('error', '保存权限失败：' . $e -> getMessage());
        }
    }

    public function deleteAction(Request $request)
    {
        if (!$request -> has('id')) {
            return redirect('/system/actions/list') -> with('error', '请提供权限ID');
        }
        DB::beginTransaction();
        try {
            DB::table('system_actions')
                -> where('id', $request -> id)
                -> update(['isDelete' => 1]);
            DB::table('system_actions')
                -> where('isDelete', 0)
                -> where('parentId', $request -> id)
                -> update(['isDelete' => 1]);
            DB::commit();
            return redirect('/system/actions/list') -> with('success', '删除权限成功（子权限连带一起删除）！');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/system/actions/list') -> with('error', '删除权限失败：' . $e -> getMessage());
        }
    }

    public function rolesList()
    {
        $roles = DB::table('system_roles')
            -> select('id', 'roleName', 'description')
            -> where('isDelete', 0)
            -> paginate(self::PER_PAGE_RECORD_COUNT);
        return view('system.roles.list', ['roles' => $roles]);
    }

    public function setRole(Request $request)
    {
        $role = null;
        if ($request -> has('id')) {
            $roleItem = DB::table('system_roles')
                -> select('system_roles.id', 'system_roles.roleName', 'system_roles.description', 'system_actions.id as aid')
                -> leftJoin('system_roles_actions', 'system_roles_actions.rid', 'system_roles.id')
                -> leftJoin('system_actions', 'system_actions.id', 'system_roles_actions.aid')
                -> where('system_roles.isDelete', 0)
                -> where('system_roles_actions.isDelete', 0)
                -> where('system_actions.isDelete', 0)
                -> where('system_roles.id', $request -> id)
                -> get();
            if (count($roleItem) !== 0) {
                $role = (object) [];
                foreach ($roleItem as $key => $item) {
                    if ($key == 0) {
                        $role -> id = $item -> id;
                        $role -> roleName = $item -> roleName;
                        $role -> description = $item -> description;
                    }
                    $role -> aid[$key] = $item -> aid;
                }
            } else {
                return redirect() -> back() -> with('error', '角色状态异常，请联系管理员！');
            }
        }
        $actionsList = $this -> getRoleActionsInfo();
        $actions = $actionsList['menus'];
        return view('system.roles.set', ['actions' => $actions, 'role' => $role]);
    }

    public function storeRole(Request $request)
    {
        $rules = [
            'roleName' => ('required|max:30|unique:system_roles,roleName,' .
                ($request -> has('id')  ? $request -> id : 'NULL') . ',id,isDelete,0'),
            'description' => 'required|max:255',
            'actions' => 'required|array'
        ];
        $message = [
            'roleName.required' => '请输入角色名称！',
            'roleName.max' => '角色名称长度不要超过30！',
            'roleName.unique' => '已存在同名的角色，请确认！',
            'description.required' => '请输入角色描述！',
            'description.max' => '角色描述长度不要超过255！',
            'actions.required' => '请选择权限！',
            'actions.array' => '权限格式不正确，请联系管理员！',
        ];
        $this -> validate($request, $rules, $message);
        if ($request -> has('id')) {
            return $this -> updateExistRole($request);
        } else {
            return $this -> storeNewRole($request);
        }
    }

    private function storeNewRole(Request $request)
    {
        $req = $request -> except(['_token', 'actions']);
        $roleActions = [];
        DB::beginTransaction();
        try {
            $rid = DB::table('system_roles')
                -> insertGetId($req);
            foreach ($request -> actions as $action) {
                $roleActions[] = [
                    'rid' => $rid,
                    'aid' => $action
                ];
            }
            DB::table('system_roles_actions')
                -> insert($roleActions);
            DB::commit();
            return redirect('/system/roles/list') -> with('success', '添加后台角色成功');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/system/roles/list') -> with('error', '添加后台失败：' . $e -> getMessage());
        }
    }

    private function updateExistRole(Request $request)
    {
        $req = $request -> except(['_token', 'actions']);
        $roleActions = [];
        DB::beginTransaction();
        try {
            DB::table('system_roles')
                -> where('id', $request -> id)
                -> update($req);
            foreach ($request -> actions as $action) {
                $roleActions[] = [
                    'rid' => $request -> id,
                    'aid' => $action
                ];
            }
            DB::table('system_roles_actions')
                -> where('rid', $request -> id)
                -> update(['isDelete' => 1]);
            DB::table('system_roles_actions')
                -> insert($roleActions);
            DB::commit();
            return redirect('/system/roles/list') -> with('success', '更新后台角色成功');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/system/roles/list') -> with('error', '更新后台失败：' . $e -> getMessage());
        }
    }

    public function deleteRole(Request $request)
    {
        if (!$request -> has('id')) {
            return redirect('/system/roles/list') -> with('error', '请提供角色ID');
        }
        DB::beginTransaction();
        try {
            DB::table('system_roles')
                -> where('id', $request -> id)
                -> update(['isDelete' => 1]);
            DB::table('system_roles_actions')
                -> where('rid', $request -> id)
                -> update(['isDelete' => 1]);
            DB::table('system_users_roles')
                -> where('rid', $request -> id)
                -> update(['isDelete' => 1]);
            DB::commit();
            return redirect('/system/roles/list') -> with('success', '删除角色成功，角色下用户移至默认角色组！');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/system/roles/list') -> with('error', '删除角色失败：' . $e -> getMessage());
        }
    }

    public function usersList(Request $request)
    {
        $users = DB::table('system_users')
            -> select('id', 'name', 'gender', 'isAdmin', 'telephone', 'email', 'isDelete', 'officeTel')
            -> where(function ($query) use ($request) {
                if ($request -> has('name')) {
                    $this -> searchCondition['name'] = $request -> name;
                    $query -> where('name', 'like', '%' . $request -> name . '%');
                }
                if ($request -> has('telephone')) {
                    $this -> searchCondition['telephone'] = $request -> telephone;
                    $query -> where('telephone', $request -> telephone);

                }
                if ($request -> has('gender') && $request -> gender >= 0) {
                    $this -> searchCondition['gender'] = $request -> gender;
                    $query -> where('gender', $request -> gender);

                }
                if ($request -> has('isAdmin') && $request -> isAdmin >= 0) {
                    $this -> searchCondition['isAdmin'] = $request -> isAdmin;
                    $query -> where('isAdmin', $request -> isAdmin);
                }
            })
            -> paginate(self::PER_PAGE_RECORD_COUNT);
        return view('system.users.list', ['users' => $users, 'sCondition' => $this -> searchCondition]);
    }

    public function setUsers(Request $request)
    {
        $user = null;
        if ($request -> has('id')) {
            $userItem = DB::table('system_users')
                -> select('system_users.id', 'system_users.username', 'system_users.name', 'system_users.gender', 'system_users_roles.rid')
                -> leftJoin('system_users_roles', 'system_users_roles.uid', '=', 'system_users.id')
                -> where('system_users.id', $request -> id)
                -> where('system_users.isDelete', 0)
                -> where('system_users_roles.isDelete', 0)
                -> get();
            $user = (object) $user;
            foreach ($userItem as $key => $item) {
                if ($key == 0) {
                    $user -> id = $item -> id;
                    $user -> username = $item -> username;
                    $user -> name = $item -> name;
                    $user -> gender = $item -> gender;
                }
                $user -> roles[$key] = $item -> rid;
            }
        }
        $roles = DB::table('system_roles')
            -> select('id', 'roleName')
            -> where('isDelete', 0)
            -> get();
        return view('system.users.set', ['user' => $user, 'roles' => $roles]);
    }

    public function storeUser(Request $request)
    {
        $rules = [
            'username' => 'required|max:30|unique:system_users,username,'
                . ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0',
            'password' => 'required_without:id|max:255|min:6|confirmed',
            'name' => 'required|max:30',
            'gender' => 'required|boolean',
            'roles' => 'required|array'
        ];
        $message = [
            'username.required' => '请输入用户名！',
            'username.max' => '用户名长度最大为30！',
            'username.unique' => '该用户名已经存在，请重新输入！',
            'password.required_without' => '请输入密码！',
            'password.max' => '密码长度最大为255！',
            'password.min' => '密码长度最短为6',
            'password.confirmed' => '两次输入的密码不一致，请重新输入！',
            'name.required' => '请输入姓名！',
            'name.max' => '姓名长度最大为30！',
            'gender.max' => '请选择用户性别！',
            'gender.boolean' => '性别格式不正确！',
            'roles.required' => '请选择用户角色！',
            'roles.array' => '用户角色格式不正确，请联系管理员！',
        ];
        $this -> validate($request, $rules, $message);
        if ($request -> has('id')) {
            return $this -> updateExistUser($request);
        } else {
            return $this -> storeNewUser($request);
        }
    }

    private function updateExistUser(Request $request)
    {
        $req = $request -> except(['_token', 'roles', 'password_confirmation', 'username']);
        if ($request -> has('password') && $request -> password !== '') {
            $req['password'] = bcrypt($req['password']);
        } else {
            unset($req['password']);
        }
        $userRoles = [];
        DB::beginTransaction();
        try {
            DB::table('system_users')
                -> where('id', $request -> id)
                -> update($req);
            DB::table('system_users_roles')
                -> where('id', $request -> id)
                -> update(['isDelete', 1]);
            foreach ($request -> roles as $role) {
                $userRoles[] = [
                    'uid' => $request -> id,
                    'rid' => $role
                ];
            }
            DB::table('system_users_roles')
                -> insert($userRoles);
            DB::commit();
            return redirect('/system/users/list') -> with('success', '添加后台用户成功');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/system/users/list') -> with('error', '添加后台用户失败：' . $e -> getMessage());
        }
    }

    private function storeNewUser(Request $request)
    {
        $req = $request -> except(['_token', 'roles', 'password_confirmation']);
        $req['password'] = bcrypt($req['password']);
        $userRoles = [];
        DB::beginTransaction();
        try {
            $uid = DB::table('system_users')
                -> insertGetId($req);
            foreach ($request -> roles as $role) {
                $userRoles[] = [
                    'uid' => $uid,
                    'rid' => $role
                ];
            }
            DB::table('system_users_roles')
                -> insert($userRoles);
            DB::commit();
            return redirect('/system/users/list') -> with('success', '添加后台用户成功');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/system/users/list') -> with('error', '添加后台用户失败：' . $e -> getMessage());
        }
    }

    public function departmentsList()
    {
        $dbDepartments = DB::table('system_departments')
            -> select('*')
            -> where('isDelete', 0)
            -> orderBy('displayWeight', 'ASC')
            -> get();
        if (count($dbDepartments) > 0) {
            $departments = $this -> treeView($dbDepartments, 'parentDepartment');
            $departmentsHtml = $this -> treeViewDepartmentsHtml($departments);
        } else {
            $departmentsHtml = '';
        }
        return view('system.departments.list', ['departmentsHtml' => $departmentsHtml]);
    }

    protected function treeViewDepartmentsHtml($data = array(), $level = 1)
    {
        $html = '<ul class="tree-menu">';
        foreach ($data as $value) {
            $html .= '<li><a href="javascript:;" data-d-id="' . $value -> id . '">';
            $html .= '<i class="fa fa-angle-right level' . $level . '"></i>';
            $html .= '<span class="department-name">' . $value -> departmentName . '</span></a></li>';
            if ($value -> children) {
                $html .= '<li>' . $this -> treeViewDepartmentsHtml($value -> children, $level+1) . '</li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }

    public function getDepartmentInfo(Request $request)
    {
        if ($request -> ajax()) {
            if ($request -> has('id')) {
                $department = DB::table('system_departments')
                    -> select('id', 'departmentName', 'displayWeight', 'parentDepartment', 'description')
                    -> where('isDelete', 0)
                    -> where('id', $request -> id)
                    -> first();
                if ($department) {
                    if ($department -> parentDepartment == 0) {
                        $department -> parentName = '根节点';
                    } else {
                        $parent = DB::table('system_departments')
                            -> select('departmentName')
                            -> where('isDelete', 0)
                            -> where('id', $department -> parentDepartment)
                            -> first();
                        $department -> parentName = $parent ? $parent -> departmentName : 'NAN';
                    }
                }
                $res = ['status' => true, 'message' => '请求成功！', 'data' => $department];
            } else {
                $res = ['status' => false, 'message' => '请求异常，缺少关键参数！', 'data' => []];
            }
        } else {
            $res = ['status' => false, 'message' => '请求方式异常！', 'data' => []];

        }
        return $res;
    }

    public function storeDepartment(Request $request)
    {
        $rules = [
            'departmentName' => 'required|max:30|unique:system_departments,departmentName,'
                . ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0',
            'parentDepartment' => 'required'
                . ($request ->parentDepartment == 0 ? '' : '|exist:system_departments,id,isDelete,0'),
            'displayWeight' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|max:255'
        ];
        $message = [
            'department.required' => '请输入部门名称！',
            'department.max' => '部门名称不要超过30个字符！',
            'department.unique' => '该部门名称已存在，请修改！',
            'parentDepartment.required' => '请选择上级部门！',
            'parentDepartment.exist' => '您选择的上级部门不存在，请重新选择！',
            'displayWeight.required' => '请输入0-100之间的数字作为部门展示权重！',
            'displayWeight.numeric' => '请输入0-100之间的数字作为部门展示权重！',
            'displayWeight.min' => '请输入0-100之间的数字作为部门展示权重！',
            'displayWeight.max' => '请输入0-100之间的数字作为部门展示权重！',
            'description.max' => '部门描述不要超过255个字符！'
        ];
        $this -> validate($request, $rules, $message);
    }
}
