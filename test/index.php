<?php
require "../vendor/autoload.php";
//假设1为最高级 5为最低级
//$tool 会员等级为降序
//$share_rule 为降序分润
$share_type = "shop_vip";
switch ($share_type) {
    case 'recharge':
        $tool = new \Sharemoney\Tool();
        $tool->initData([
            [
                'id' => 5,
                'role_type' => 20
            ],
            [
                'id' => 4,
                'role_type' => 20
            ],
//    [
//        'id'=>3,
//        'role_type'=>15
//    ],
            [
                'id' => 2,
                'role_type' => 10
            ],
            [
                'id' => 1,
                'role_type' => 5
            ],
        ]);
        $share_object = new \Sharemoney\ShareType\ShareIm\Recharge();
        $share_rule['parent_back_money'] = [
            100,
            20,
            10,
        ];
        $share_object->shareMoney($tool, $share_rule, []);
        break;
    case "shop_vip":
        $tool = new \Sharemoney\Tool();
        $tool->initData([
//            [
//                'id'=>5,
//                'role_type'=>20
//            ],
//    [
//        'id'=>4,
//        'role_type'=>20
//    ],
            [
                'id' => 3,
                'role_type' => 15
            ],
            [
                'id' => 2,
                'role_type' => 10
            ],
            [
                'id' => 1,
                'role_type' => 5
            ],
        ]);
        $share_object = new \Sharemoney\ShareType\ShareIm\ShopVip();
        $share_rule['self_back_money'] = 5;
        $share_rule['parent_back_money'] = [
            3,
            2
        ];
        $share_object->shareMoney($tool, $share_rule, [
            'id' => 20,
            'role_type' => 20
        ]);
        break;
    case "shop_goods":
        $tool = new \Sharemoney\Tool();
        $tool->initData([
            [
                'id' => 5,
                'role_type' => 20
            ],
//    [
//        'id'=>4,
//        'role_type'=>20
//    ],
//    [
//        'id'=>3,
//        'role_type'=>15
//    ],
//            [
//                'id'=>2,
//                'role_type'=>10
//            ],
            [
                'id' => 1,
                'role_type' => 5
            ],
        ]);
        $share_object = new \Sharemoney\ShareType\ShareIm\ShopGoods();
        $share_rule['parent_back_money'] = [
            5
        ];
        $share_object->shareMoney($tool, $share_rule, [
            'id' => 2,
            'role_type' => 10
        ]);
        break;
}


var_dump($share_object->share_object_list);
