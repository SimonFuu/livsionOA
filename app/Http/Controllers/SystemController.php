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
            -> paginate(20);
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
        return view('system.actions.set', ['action' => $action, 'pActions' => $pActions]);
    }

    public function storeAction(Request $request)
    {
        $roles = [
            'actionName' => 'required|max:10',
            'menuUrl' => 'required|max:255',
            'urls' => 'sometimes|max:1000',
            'weight' => 'required|numeric|min:1|max:10000',
        ];
        $message = [
            'actionName.required' => '请输入权限名称！',
            'actionName.max' => '权限名称不要超过10个字符！',
            'menuUrl.required' => '请输入左侧菜单URL地址！',
            'menuUrl.max' => '长度请不要超过255！',
            'urls.sometimes' => '请输入权限对应的URL地址，一行一个！',
            'urls.max' => 'URL地址总体长度不要该超过1000！',
            'weight.required' => '请输入菜单展示权重！',
            'weight.numeric' => '菜单展示权重格式不正确，请输入1-10000的数字！',
            'weight.min' => '菜单展示权重格式不正确，请输入1-10000的数字！',
            'weight.max' => '菜单展示权重格式不正确，请输入1-10000的数字！',
        ];
        $this -> validate($request, $roles, $message);
        if ($request -> has('id')) {
            return $this -> updateExistAction($request);
        } else {
            return $this -> storeNewAction($request);
        }
    }

    private function storeNewAction(Request $request)
    {
        $this -> validate($request,
            ['actionName' => 'unique:system_actions,actionName,NULL,id,isDelete,0'],
            ['unique' => '已存在同名的权限，请确认！']
        );
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
        $this -> validate($request,
            ['actionName' => 'unique:system_actions,actionName,' . $request -> id . ',id,isDelete,0'],
            ['unique' => '已存在同名的权限，请确认！']
        );
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
            return redirect('/system/actions/list') -> with('success', '删除权限成功（自权限连带一起删除）！');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/system/actions/list') -> with('error', '删除权限失败：' . $e -> getMessage());
        }
    }
}
