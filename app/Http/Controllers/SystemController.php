<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    /**
     * 菜单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionsList()
    {
        $actions = DB::table('system_actions')
            -> select('id', 'actionName', 'description', 'urls', 'weight', 'parentId')
            -> where('isDelete', 0)
            -> orderBy('weight', 'ASC')
            -> paginate(self::PER_PAGE_RECORD_COUNT);
        return view('system.actions.list', ['actions' => $actions]);
    }

    /**
     * 编辑／添加菜单Form
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setAction(Request $request)
    {
        $action = null;
        if ($request -> has('id')) {
            $a = DB::table('system_actions')
                -> select('id', 'actionName', 'menuUrl', 'urls', 'weight', 'parentId', 'description', 'icon', 'adminOnly')
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

    /**
     * 编辑／添加菜单
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAction(Request $request)
    {
        $rules = [
            'actionName' => 'required|max:10|unique:system_actions,actionName,'
                . ($request -> has('id')  ? $request -> id : 'NULL') . ',id,isDelete,0',
            'menuUrl' => 'required|max:255',
            'description' => 'required|max:255',
            'urls' => 'required|max:1000',
            'weight' => 'required|numeric|min:1|max:10000',
            'icon' => 'required|exists:system_icons,icon',
            'adminOnly' => 'required|boolean'
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
            'icon.exists' => '请选择系统提供的图标！',
            'adminOnly.required' => '请选择是否是后台菜单！',
            'adminOnly.boolean' => '后台菜单标识不正确，请重新选择！'
        ];
        $this -> validate($request, $rules, $message);
        if ($request -> has('id')) {
            return $this -> updateExistAction($request);
        } else {
            return $this -> storeNewAction($request);
        }
    }

    /**
     * 保存添加菜单
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * 保存编辑菜单
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * 删除菜单
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * 角色列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rolesList()
    {
        $roles = DB::table('system_roles')
            -> select('id', 'roleName', 'description')
            -> where('isDelete', 0)
            -> paginate(self::PER_PAGE_RECORD_COUNT);
        return view('system.roles.list', ['roles' => $roles]);
    }

    /**
     * 编辑／添加角色Form
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
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

    /**
     * 编辑／保存角色
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * 保存添加角色
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * 保存编辑角色
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * 删除角色
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * 用户列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function usersList(Request $request)
    {
        $users = DB::table('system_users')
            -> select(
                'system_users.id',
                'system_users.username',
                'system_users.name',
                'system_users.gender',
                'system_users.telephone',
                'system_users.email',
                'system_users.officeTel',
                'system_departments.departmentName as department',
                'system_positions.positionName as position',
                'system_users.status',
                'system_users.isAdmin'
            )
            -> leftJoin('system_departments', 'system_departments.id', '=', 'system_users.departmentId')
            -> leftJoin('system_positions', 'system_positions.id', '=', 'system_users.positionId')
            -> where('system_departments.isDelete', 0)
            -> where('system_users.isDelete', 0)
            -> where(function ($query) use ($request) {
                if ($request -> has('username')) {
                    $this -> searchCondition['username'] = $request -> username;
                    $query -> where('system_users.username', $request -> username);
                }
                if ($request -> has('name')) {
                    $this -> searchCondition['name'] = $request -> name;
                    $query -> where('system_users.name', 'like', '%' . $request -> name . '%');
                }
                if ($request -> has('telephone')) {
                    $this -> searchCondition['telephone'] = $request -> telephone;
                    $query -> where('system_users.telephone', $request -> telephone);
                }
                if ($request -> has('gender') && $request -> gender >= 0) {
                    $this -> searchCondition['gender'] = $request -> gender;
                    $query -> where('system_users.gender', $request -> gender);
                }

                if ($request -> has('isAdmin') && $request -> isAdmin >= 0) {
                    $this -> searchCondition['isAdmin'] = $request -> isAdmin;
                    $query -> where('system_users.isAdmin', $request -> isAdmin);
                }
            })
            -> orderBy('system_users.weight', 'ASC')
            -> paginate(self::PER_PAGE_RECORD_COUNT);
        return view('system.users.list', ['users' => $users, 'sCondition' => $this -> searchCondition]);
    }

    /**
     * 编辑／添加用户Form
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setUsers(Request $request)
    {
        $user = null;
        if ($request -> has('id')) {
            $userItem = DB::table('system_users')
                -> select(
                    'system_users.id',
                    'system_users.username',
                    'system_users.name',
                    'system_users.gender',
                    'system_users.isAdmin',
                    'system_users.status',
                    'system_users.telephone',
                    'system_users.departmentId',
                    'system_users.positionId',
                    'system_users.officeTel',
                    'system_users.email',
                    'system_departments.departmentName',
                    'system_users_roles.rid'
                )
                -> leftJoin('system_users_roles', 'system_users_roles.uid', '=', 'system_users.id')
                -> leftJoin('system_departments', 'system_departments.id', '=', 'system_users.departmentId')
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
                    $user -> isAdmin = $item -> isAdmin;
                    $user -> telephone = $item -> telephone;
                    $user -> officeTel = $item -> officeTel;
                    $user -> email = $item -> email;
                    $user -> status = $item -> status;
                    $user -> departmentId = $item -> departmentId;
                    $user -> positionId = $item -> positionId;
                    $user -> departmentName = $item -> departmentName;
                }
                $user -> roles[$key] = $item -> rid;
            }
        }
        $roles = DB::table('system_roles')
            -> select('id', 'roleName')
            -> where('isDelete', 0)
            -> get();
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
        $dbPositions = DB::table('system_positions')
            -> select('id', 'positionName')
            -> where('isDelete', 0)
            -> orderBy('weight', 'ASC')
            -> get();
        $positions = [];
        if (count($dbPositions) > 0) {
            foreach ($dbPositions as $item) {
                $positions[$item -> id] = $item -> positionName;
            }
        }
        return view('system.users.set',
            ['user' => $user, 'roles' => $roles, 'departmentsHtml' => $departmentsHtml, 'positions' => $positions]);
    }

    /**
     * 保存编辑／添加用户
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeUser(Request $request)
    {
        $rules = [
            'username' => 'required|max:30|unique:system_users,username,'
                . ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0',
            'password' => ($request -> has('id') ? 'nullable|' : 'required|') . 'max:255|min:6|confirmed',
            'name' => 'required|max:30',
            'telephone' => 'required|max:16|min:11|unique:system_users,telephone,'
                . ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0',
            'departmentId' => 'required|exists:system_departments,id,isDelete,0',
            'positionId' => 'required|exists:system_positions,id,status,1',
            'officeTel' => 'nullable|max:16',
            'email' => 'nullable|email|max:64|unique:system_users,email,'
                . ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0',
            'gender' => 'required|boolean',
            'isAdmin' => 'required|boolean',
            'roles' => 'required_if:isAdmin,1|array'
        ];
        $message = [
            'username.required' => '请输入用户名！',
            'username.max' => '用户名长度最大为30！',
            'username.unique' => '该用户名已经存在，请重新输入！',
            'password.required' => '请输入密码！',
            'password.max' => '密码长度最大为255！',
            'password.min' => '密码长度最短为6',
            'password.confirmed' => '两次输入的密码不一致，请重新输入！',
            'name.required' => '请输入姓名！',
            'name.max' => '姓名长度最大为30！',
            'telephone.required' => '请输入手机号！',
            'telephone.unique' => '该手机号已存在，请重新输入！！',
            'telephone.min' => '手机号长度最低为11位！',
            'telephone.max' => '手机号长度最高位16位！',
            'departmentId.required' => '请选择用户所属部门！',
            'departmentId.exists' => '您选择的部门不存在或已被删除，请重试！',
            'positionId.required' => '请选择用户职位！',
            'positionId.exists' => '您选择的职位不存在或已被删除，请重试！',
            'officeTel.max' => '办公电话长度最大为16位！',
            'email.email' => '请输入合法的电子邮箱地址！',
            'email.unique' => '该电子邮箱已存在，请重新输入！',
            'email.max' => '电子邮箱长度，最长为64位！',
            'gender.required' => '请选择用户性别！',
            'gender.boolean' => '性别格式不正确！',
            'isAdmin.required' => '请选择是否是管理员！',
            'isAdmin.boolean' => '管理员标识格式不正确！',
            'roles.required_if' => '请选择用户角色！',
            'roles.array' => '用户角色格式不正确，请联系管理员！',
        ];
        $this -> validate($request, $rules, $message);
        if ($request -> has('id')) {
            return $this -> updateExistUser($request);
        } else {
            return $this -> storeNewUser($request);
        }
    }

    /**
     * 保存编辑用户
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
                -> update(['isDelete' => 1]);
            if ($request -> isAdmin == 0) {
                $userRoles[] = [
                    'uid' => $request -> id,
                    'rid' => 1
                ];
            } else {
                foreach ($request -> roles as $role) {
                    $userRoles[] = [
                        'uid' => $request -> id,
                        'rid' => $role
                    ];
                }
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

    /**
     * 保存添加用户
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function storeNewUser(Request $request)
    {
        $req = $request -> except(['_token', 'roles', 'password_confirmation']);
        $req['password'] = bcrypt($req['password']);
        $userRoles = [];
        DB::beginTransaction();
        try {
            $uid = DB::table('system_users')
                -> insertGetId($req);
            if ($request -> isAdmin == 0) {
                $userRoles[] = [
                    'uid' => $uid,
                    'rid' => 1
                ];
            } else {
                foreach ($request -> roles as $role) {
                    $userRoles[] = [
                        'uid' => $uid,
                        'rid' => $role
                    ];
                }
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

    /**
     * 部门列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function departmentsList()
    {
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
        return view('system.departments.list', ['departmentsHtml' => $departmentsHtml]);
    }

    /**
     * 根据ID获取部门信息
     * @param Request $request
     * @return array
     */
    public function getDepartmentInfo(Request $request)
    {
        if ($request -> ajax()) {
            if ($request -> has('id')) {
                $department = DB::table('system_departments')
                    -> select('id', 'departmentName', 'weight', 'parentDepartment', 'description')
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
                    $res = ['status' => true, 'message' => '请求成功！', 'data' => $department];
                } else {
                    $res = ['status' => false, 'message' => '该部门不存在或已被删除！', 'data' => []];
                }
            } else {
                $res = ['status' => false, 'message' => '请求异常，缺少关键参数！', 'data' => []];
            }
        } else {
            $res = ['status' => false, 'message' => '请求方式异常！', 'data' => []];

        }
        return $res;
    }

    /**
     * 添加部门Form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setDepartment()
    {
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
        return view('system.departments.add', ['departmentsHtml' => $departmentsHtml]);
    }

    /**
     * 保存添加／编辑部门
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeDepartment(Request $request)
    {
        $rules = [
            'departmentName' => 'required|max:30|unique:system_departments,departmentName,'
                . ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0',
            'parentDepartment' => 'required'
                . ($request ->parentDepartment == 0 ? '' : '|exists:system_departments,id,isDelete,0'),
            'weight' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|max:255'
        ];
        $message = [
            'departmentName.required' => '请输入部门名称！',
            'departmentName.max' => '部门名称不要超过30个字符！',
            'departmentName.unique' => '该部门名称已存在，请修改！',
            'parentDepartment.required' => '请选择上级部门！',
            'parentDepartment.exists' => '您选择的上级部门不存在，请重新选择！',
            'weight.required' => '请输入0-100之间的数字作为部门展示权重！',
            'weight.numeric' => '请输入0-100之间的数字作为部门展示权重！',
            'weight.min' => '请输入0-100之间的数字作为部门展示权重！',
            'weight.max' => '请输入0-100之间的数字作为部门展示权重！',
            'description.max' => '部门描述不要超过255个字符！'
        ];
        $this -> validate($request, $rules, $message);
        if ($request -> has('id')) {
            return $this -> updateExistDepartment($request);
        } else {
            return $this -> storeNewDepartment($request);
        }
    }

    /**
     * 删除部门
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDepartment(Request $request)
    {
        if ($request -> has('id')) {
            if ($request -> id == 1) {
                return redirect('/system/departments/list') -> with('error', '删除失败，系统根节点无法删除！');
            }
            $ids = $this -> getChildrenDepartmentsAndSelf($request -> id);
            try {
                DB::table('system_departments') -> whereIn('id', $ids) -> update(['isDelete' => 1]);
                DB::table('system_users') -> whereIn('departmentId', $ids) -> update(['departmentId' => 1]);
                return redirect('/system/departments/list') -> with('success', '部门删除成功，部门内原有用户已移至"根节点"下！');
            } catch (\Exception $e) {
                return redirect('/system/departments/list') -> with('error', '部门删除失败：' . $e -> getMessage());
            }
        } else {
            return redirect('/system/departments/list') -> with('error', '删除失败，请提供必要参数！');
        }
    }

    /**
     * 保存添加部门
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function storeNewDepartment(Request $request)
    {
        $data = [
            'departmentName' => $request -> departmentName,
            'description' => $request -> description,
            'parentDepartment' => $request -> parentDepartment,
            'weight' => $request -> weight,
        ];
        DB::table('system_departments') -> insert($data);
        return redirect('/system/departments/list') -> with('success', '添加成功！');
    }

    /**
     * 保存编辑部门
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function updateExistDepartment(Request $request)
    {
        if ($request -> id == 1) {
            return redirect('/system/departments/list') -> with('error', '修改失败，根节点无法修改，请联系管理员！');
        }
        $childrenIds = $this -> getChildrenDepartmentsAndSelf($request -> id);
        if (in_array($request -> parentDepartment, $childrenIds)) {
            return redirect('/system/departments/list') -> with('error', '修改失败，该部门的下级部门或自己不能作为"上级部门"！');
        } else {
            $data = [
                'departmentName' => $request -> departmentName,
                'description' => $request -> description,
                'parentDepartment' => $request -> parentDepartment,
                'weight' => $request -> weight,
            ];
            DB::table('system_departments') -> where('id', $request -> id) -> update($data);
            return redirect('/system/departments/list') -> with('success', '修改成功！');
        }
    }

    /**
     * 获取所有下级部门及本身
     * @param int $id
     * @return array
     */
    private function getChildrenDepartmentsAndSelf($id = 0)
    {
        $dbDepartments = DB::table('system_departments')
            -> select('*')
            -> where('isDelete', 0)
            -> orderBy('weight', 'ASC')
            -> get();
        $dps = [];
        foreach ($dbDepartments as $key => $value) {
            $dps[] = [
                'id' => $value -> id,
                'parent' => $value -> parentDepartment,
            ];
        }
        $departments[] = [
            'id' => '0',
            'parent' => '0',
            'level' => 0,
            'children' => $this -> treeView($dps, 'parent', 0, 1)
        ];
        $childrenIds = $this -> treeViewSearch($departments, $id);
        $childrenIds[] = $id;
        return $childrenIds;
    }

    /**
     * 生成部门Tree 的Html
     * @param array $data
     * @param int $level
     * @return string
     */
    private function treeViewDepartmentsHtml($data = array(), $level = 0)
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

    public function positionsList()
    {
        $dbPositions = DB::table('system_positions')
            -> select('id', 'positionName', 'weight', 'status', 'description')
            -> where('isDelete', 0)
            -> orderBy('weight', 'ASC')
            -> get();
        return view('system.positions.list', ['positions' => $dbPositions]);
    }

    public function getPositionInfo(Request $request)
    {
        if ($request -> ajax()) {
            if ($request -> has('id')) {
                $position = DB::table('system_positions')
                    -> select('id', 'positionName', 'weight', 'status', 'description')
                    -> where('isDelete', 0)
                    -> where('id', $request -> id)
                    -> first();
                if ($position) {
                    $res = ['status' => true, 'message' => '请求成功！', 'data' => $position];
                } else {
                    $res = ['status' => false, 'message' => '请求成功！', 'data' => []];
                }
            } else {
                $res = ['status' => false, 'message' => '请求异常，缺少关键参数！', 'data' => []];
            }
        } else {
            $res = ['status' => false, 'message' => '请求方式异常！', 'data' => []];

        }
        return $res;
    }

    public function setPosition()
    {
        return view('system.positions.add');
    }

    public function storePosition(Request $request)
    {
        $rules = [
            'positionName' => 'required|max:30|unique:system_positions,positionName,'
                . ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0',
            'status' => 'required|boolean',
            'weight' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|max:255'
        ];
        $message = [
            'positionName.required' => '请输入职位名称！',
            'positionName.max' => '职位名称不要超过30个字符！',
            'positionName.unique' => '该职位名称已存在，请修改！',
            'status.required' => '请选择职位状态！',
            'status.boolean' => '职位状态不正确，请重试！',
            'weight.required' => '请输入0-100之间的数字作为职位展示权重！',
            'weight.numeric' => '请输入0-100之间的数字作为职位展示权重！',
            'weight.min' => '请输入0-100之间的数字作为职位展示权重！',
            'weight.max' => '请输入0-100之间的数字作为职位展示权重！',
            'description.max' => '职位描述不要超过255个字符！'
        ];
        $this -> validate($request, $rules, $message);
        if ($request -> has('id')) {
            return $this -> updateExistPosition($request);
        } else {
            return $this -> storeNewPosition($request);
        }
    }


    public function deletePosition(Request $request)
    {
        if ($request -> has('id')) {
            if ($request -> id == 1) {
                return redirect('/system/positions/list') -> with('error', '删除失败，系统保留职位无法删除！');
            }
            try {
                DB::table('system_positions') -> where('id', $request -> id) -> update(['isDelete' => 1, 'status' => 0]);
                DB::table('system_users') -> where('positionId', $request -> id) -> update(['positionId' => 1]);
                return redirect('/system/positions/list') -> with('success', '职位删除成功，职位原有用户已移至"default"下！');
            } catch (\Exception $e) {
                return redirect('/system/positions/list') -> with('error', '职位删除失败：' . $e -> getMessage());
            }
        } else {
            return redirect('/system/positions/list') -> with('error', '删除失败，请提供必要参数！');
        }
    }

    private function updateExistPosition(Request $request)
    {
        if ($request -> id == 1) {
            return redirect('/system/positions/list') -> with('error', '系统保留职位，请勿删除！');
        }

        try {
            if ($request -> status == 0) {
                DB::table('system_users') -> where('positionId', $request -> id) -> update(['positionId' => 1]);
            }

            DB::table('system_positions')
                -> where('id', $request -> id) -> update([
                    'positionName' => $request -> positionName,
                    'weight' => $request -> weight,
                    'status' => $request -> status,
                    'description' => $request -> description,
                ]);
            return redirect('/system/positions/list') -> with('success', '编辑成功！');
        } catch (\Exception $e) {
            return redirect('/system/positions/list') -> with('error', '编辑失败：' . $e -> getMessage());
        }

    }

    private function storeNewPosition(Request $request)
    {
        $data = [
            'positionName' => $request -> positionName,
            'description' => $request -> description,
            'status' => $request -> status,
            'weight' => $request -> weight,
        ];
        DB::table('system_positions') -> insert($data);
        return redirect('/system/positions/list') -> with('success', '添加成功！');
    }
}
