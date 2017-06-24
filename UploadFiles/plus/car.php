<?php
/**
 *
 * 显示购物车的商品
 *
 * @version        $Id: car.php
 * @package        Mi.Site
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/license.html
 * @link           http://www.missra.com
 */
require_once (dirname(__FILE__) . "/../include/common.inc.php");
define('_PLUS_TPL_', MIROOT.'/templets/plus');
require_once(MIINC.'/mitemplate.class.php');
require_once MIINC.'/shopcar.class.php';
require_once MIINC.'/memberlogin.class.php';
$cart = new MemberShops();

if(isset($dopost) && $dopost=='makeid')
{
    AjaxHead();
    $cart->MakeOrders();
    echo $cart->OrdersId;
    exit;
}
$cfg_ml = new MemberLogin();
//获得购物车内商品,返回数组
$Items = $cart->getItems();
if($cart->cartCount() < 1)
{
    ShowMsg("购物车中不存在任何商品！", "javascript:window.close();", false, 5000);
    exit;
}
@sort($Items);

$carts = array(
    'orders_id' => $cart->OrdersId,
    'cart_count' => $cart->cartCount(),
    'price_count' => $cart->priceCount()
);

$dtp = new MiTemplate();
$dtp->Assign('carts',$carts);
$dtp->LoadTemplate(_PLUS_TPL_.'/car.htm');
$dtp->Display();
exit;