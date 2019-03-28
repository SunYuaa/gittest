<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\Address;

class UserController extends Controller
{
    //用户主页
    public function user(){
        $userInfo = session('loginInfo')->toArray();
//        $user_id = $userInfo[0]['user_id'];
//        dd($userInfo);
        return view('user.user',(['userInfo'=>$userInfo[0]['user_email']]));
    }

    //我的订单
    public function order(){
        return view('user.order');
    }


    //收货地址
    public function receiveAddress(){
        return view('user.receiveAddress');
    }

    //收货地址添加页面
    public function addressAdd(){
        $province = $this->getArea(0);

        return view('user.addressAdd',(['province'=>$province]));
    }

    //执行添加
    public function addressDo(){
        $data = request()->input();
        $userInfo  = session('loginInfo')->toArray();
        $user_id = $userInfo[0]['user_id'];
        $data['user_id']=$user_id;
        $address_model = new Address;
        if($data['is_default']==1){
            //设为默认
            $where = [
                'user_id'=>$user_id
            ];
            $result = Address::where($where)->update(['is_default'=>2]);
            $res = Address::insert($data);
            if($result!==false && $res){
                echo 1;
            }else{
                echo 2;
            }
        }else{
            $res = Address::insert($data);
            if($res){
                echo 1;
            }else{
                echo 2;
            }
        }

    }
    //根据pid查询地址
    public function getArea($pid){
        $where  = [
            'pid'=>$pid
        ];
        $res = Area::where($where)->get();
        return $res;
    }
    //三级联动
    public function selectArea(){
        $id = request()->post('id');
        $area = $this->getArea($id);
        echo $area;
    }

//    //我的收藏
//    public function collect(){
//        return view('user.collect');
//    }

//    //我的浏览记录
//    public function history(){
//        return view('user.history');
//    }
//

}
