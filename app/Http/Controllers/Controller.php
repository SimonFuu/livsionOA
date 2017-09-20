<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $searchCondition = [];

    const PER_PAGE_RECORD_COUNT = 10;

    protected function treeView($data = array(), $field = 'level', $id = 0, $level = 0)
    {
        $tree = [];
        foreach ($data as $value) {
            if (is_array($value)) {
                if ($value[$field] == $id) {
                    $value['level'] = $level;
                    $value['children'] = $this -> treeView($data, $field, $value['id'], $level+1);
                    $tree[] = $value;
                }
            } elseif(is_object($value)) {
                if ($value -> $field == $id) {
                    $value -> level = $level;
                    $value -> children = $this -> treeView($data, $field, $value -> id, $level+1);
                    $tree[] = $value;
                }
            }
        }
        return $tree;
    }

    /**
     * 生成部门Tree 的Html
     * @param array $data
     * @param int $level
     * @return string
     */
    protected function treeViewDepartmentsHtml($data = array(), $level = 0)
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

    protected function treeViewSearch($data = [], $id = 0)
    {
        $ids = [];
        if (!empty($data)) {
            foreach ($data as $value) {
                if ($value['parent'] == $id) {
                    $ids = array_merge($ids, [$value['id']]);
                    $ids = array_merge($ids, $this -> treeViewSearch($value['children'], $value['id']));
                } else {
                    $ids = array_merge($ids, $this -> treeViewSearch($value['children'], $id));
                }
            }
        }
        return $ids;
    }

    /**
     * 获取所有下级部门及本身
     * @param int $id
     * @return array
     */
    protected function getChildrenDepartmentsAndSelf($id = 0)
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

    public function getRoleActionsInfo($roleId = 0, $isAdmin = 1)
    {
        $basePermissions = [
            'index',
            'notify',
            'panel/init/password',
            'panel/user/center',
            'panel/user/edit',
            'panel/user/store'
        ];
        $permissions = [];
        $m = [];
        $menus = [];
        $cMenus = [];  // 临时存放二级菜单 key为父级菜单的id
        if ($roleId == 0) {
            $rawActions = DB::table('system_actions')
                -> select('id', 'actionName', 'description', 'menuUrl', 'icon', 'urls', 'parentId')
                -> orderBy('weight', 'ASC')
                -> where('isDelete', 0)
                -> where('adminOnly', '<=', $isAdmin)
                -> get();
        } else {
            if (is_array($roleId)) {
                $rawActions = DB::table('system_actions')
                    -> select('system_actions.id', 'system_actions.actionName', 'system_actions.description',
                        'system_actions.menuUrl', 'system_actions.icon', 'system_actions.urls', 'system_actions.parentId')
                    -> leftJoin('system_roles_actions', 'system_roles_actions.aid', '=', 'system_actions.id')
                    -> groupBy('system_actions.id')
                    -> orderBy('system_actions.weight', 'ASC')
                    -> where('system_actions.isDelete', 0)
                    -> where('system_actions.adminOnly', '<=', $isAdmin)
                    -> orWhere(function ($query) use ($roleId) {
                        $query -> where('system_roles_actions.isDelete', 0);
                        $query -> whereIn('system_roles_actions.rid', $roleId);
                    })
                    -> get();
            } else {
                $rawActions = DB::table('system_actions')
                    -> select('system_actions.id', 'system_actions.actionName', 'system_actions.description',
                        'system_actions.menuUrl', 'system_actions.icon', 'system_actions.urls', 'system_actions.parentId')
                    -> leftJoin('system_roles_actions', 'system_roles_actions.aid', '=', 'system_actions.id')
                    -> groupBy('system_actions.id')
                    -> orderBy('system_actions.weight', 'ASC')
                    -> where('system_actions.isDelete', 0)
                    -> where('system_actions.adminOnly', '<=', $isAdmin)
                    -> orWhere(function ($query) use ($roleId) {
                        $query -> where('system_roles_actions.isDelete', 0);
                        $query -> where('system_roles_actions.rid', $roleId);
                    })
                    -> get();
            }
        }
        if ($rawActions) {
            foreach ($basePermissions as $permission) {
                $permissions[$permission] = 1;
            }
            foreach ($rawActions as $rawAction) {
                $urls = json_decode($rawAction -> urls, true);
                # 获取权限
                if ($urls) {
                    foreach ($urls as $url) {
                        $permissions[$url] = 1;
                    }
                }
                if ($rawAction -> parentId == 0) {
                    $m[] = [
                        'id' => $rawAction -> id,
                        'actionName' => $rawAction -> actionName,
                        'menuUrl' => $rawAction -> menuUrl,
                        'icon' => $rawAction -> icon,
                        'childrenMenus' => []
                    ];
                } else {
                    $cMenus[$rawAction -> parentId][] = [
                        'id' => $rawAction -> id,
                        'actionName' => $rawAction -> actionName,
                        'menuUrl' => $rawAction -> menuUrl,
                        'icon' => $rawAction -> icon,
                    ];
                }
            }
            // 生成菜单列表（二维数组）
            $existMenuIds = [];
            foreach ($m as $key => $menu) {
                if (!isset($existMenuIds[$menu['id']])) {
                    $existMenuIds[$menu['id']] = 1;
                    $menus[$key] = $menu;
                    if (isset($cMenus[$menu['id']])) {
                        $menus[$key]['childrenMenus'] = $cMenus[$menu['id']];
                    }
                }
            }
            unset($existMenuIds);
        }
        return ['permissions' => $permissions, 'menus' => $menus];
    }

//    private function getAllActionsInfo()
//    {
//        $permissions = [];
//        $m = [];
//        $menus = [];
//        $cMenus = [];  // 临时存放二级菜单 key为父级菜单的id
//        $rawActions = DB::table('system_actions')
//            -> select('id', 'actionName', 'description', 'menuUrl', 'urls', 'parentId')
//            -> orderBy('weight', 'ASC')
//            -> get();
//        foreach ($rawActions as $rawAction) {
//            $urls = json_decode($rawAction -> urls, true);
//            # 获取权限
//            $permissions = array_merge($permissions, $urls);
//            if ($rawAction -> parentId == 0) {
//                $m[] = [
//                    'id' => $rawAction -> id,
//                    'actionName' => $rawAction -> actionName,
//                    'menuUrl' => $rawAction -> menuUrl,
//                    'childrenMenus' => []
//                ];
//            } else {
//                $cMenus[$rawAction -> parentId][] = [
//                    'id' => $rawAction -> id,
//                    'actionName' => $rawAction -> actionName,
//                    'menuUrl' => $rawAction -> menuUrl,
//                ];
//            }
//        }
//        // 生成菜单列表（二维数组）
//        foreach ($m as $key => $menu) {
//            $menus[$key] = $menu;
//            if (isset($cMenus[$menu['id']])) {
//                $menus[$key]['childrenMenus'] = $cMenus[$menu['id']];
//            }
//        }
//        return ['permissions' => $permissions, 'menus' => $menus];
//    }
//
//    private function getRoleActionsInfoByRoleId($roleId = 0)
//    {
//        $permissions = [];
//        $m = [];
//        $menus = [];
//        $cMenus = [];  // 临时存放二级菜单 key为父级菜单的id
//        if ($roleId == 0) {
//            $rawActions = DB::table('system_actions')
//                -> select('id', 'actionName', 'description', 'menuUrl', 'urls', 'parentId')
//                -> orderBy('weight', 'ASC')
//                -> where('isDelete', 0)
//                -> get();
//        } else {
//            $rawActions = DB::table('system_actions')
//                -> select('system_actions.id', 'system_actions.actionName', 'system_actions.description',
//                    'system_actions.menuUrl', 'system_actions.urls', 'system_actions.parentId')
//                -> leftJoin('system_roles_actions', 'system_roles_actions.aid', '=', 'system_actions.id')
//                -> orderBy('system_actions.weight', 'ASC')
//                -> where('system_actions.isDelete', 0)
//                -> where('system_roles_actions.isDelete', 0)
//                -> get();
//        }
//        if ($rawActions) {
//            foreach ($rawActions as $rawAction) {
//                $urls = json_decode($rawAction -> urls, true);
//                # 获取权限
//                $permissions = array_merge($permissions, $urls);
//                if ($rawAction -> parentId == 0) {
//                    $m[] = [
//                        'id' => $rawAction -> id,
//                        'actionName' => $rawAction -> actionName,
//                        'menuUrl' => $rawAction -> menuUrl,
//                        'childrenMenus' => []
//                    ];
//                } else {
//                    $cMenus[$rawAction -> parentId][] = [
//                        'id' => $rawAction -> id,
//                        'actionName' => $rawAction -> actionName,
//                        'menuUrl' => $rawAction -> menuUrl,
//                    ];
//                }
//            }
//            // 生成菜单列表（二维数组）
//            foreach ($m as $key => $menu) {
//                $menus[$key] = $menu;
//                if (isset($cMenus[$menu['id']])) {
//                    $menus[$key]['childrenMenus'] = $cMenus[$menu['id']];
//                }
//            }
//        }
//        return ['permissions' => $permissions, 'menus' => $menus];
//    }
}
