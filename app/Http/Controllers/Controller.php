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

    public function getAdminActionsInfo($roleId = 0)
    {
        if ($roleId == 0) {
            return $this -> getAllActionsInfo();
        } else {
            return $this -> getRoleActionsInfo($roleId);
        }
    }

    private function getAllActionsInfo()
    {
        $permissions = [];
        $menus = [];
        $cMenus = [];  // 临时存放二级菜单 key为父级菜单的id
        $rawActions = DB::table('system_actions')
            -> select('id', 'actionName', 'description', 'menuUrl', 'urls', 'parentId')
            -> orderBy('weight', 'ASC')
            -> get();
        foreach ($rawActions as $rawAction) {
            $urls = json_decode($rawAction -> urls, true);
            # 获取权限
            $permissions = array_merge($permissions, $urls);
            if ($rawAction -> parentId == 0) {
                $menus[] = [
                    'id' => $rawAction -> id,
                    'actionName' => $rawAction -> actionName,
                    'menuUrl' => $rawAction -> menuUrl,
                    'childrenMenus' => []
                ];
            } else {
                $cMenus[$rawAction -> parentId][] = [
                    'id' => $rawAction -> id,
                    'actionName' => $rawAction -> actionName,
                    'menuUrl' => $rawAction -> menuUrl,
                ];
            }
        }
        // 生成菜单列表（二维数组）
        foreach ($menus as $menu) {
            if (isset($cMenus[$menu -> id])) {
                $menu -> childrenMenus = $cMenus[$menu -> id];
            }
        }
        return ['permissions' => $permissions, 'menus' => $menus];

    }

    private function getRoleActionsInfo($roleId = 0)
    {

    }


}
