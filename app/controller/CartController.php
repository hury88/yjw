<?php
/**
 * Created by PhpStorm.
 * User: 胡锐
 * Date: 2018/7/15
 * Time: 19:53
 */

namespace App\controller;

use App\model\Cart as Cart;

class CartController extends Controller
{
    public $cartModel = null;

    public function __construct()
    {
        $this->cartModel = new Cart;
    }

    public function addToCart($prod_id, $quantity, $flag, $sku_id)
    {
        $this->cartModel->push($prod_id, $quantity, Cart::operator_rising);
        echo $prod_id;
    }

    public function index(){
        $addrid = I('get.addrid', 0, 'intval');
        if (! $addrid) {
            if ($uid = Person::get()->_pk) {
                $addrid = M('usr_address')->where('uid='.$uid)->order('is_default desc')->getField('id');
            }
        }

        $this->assign('address', M('usr_address')->find($addrid));
        $acar = $this->shopCar->cart;
        $goodMD = KWFactory::create('GoodsModel');
        foreach ($acar as $goods_id => &$value) {
            if ($goods_info = $goodMD->field('*')->find($goods_id)) {
                $value = array_merge(['num' => $value], $goods_info);
            } else {
                unset($acar[$goods_id]);
            }
        }
        $this->assign('list', $acar);
        $this->display('cart');
    }

    public function delete(){
        $cart = isset($_POST['cart']) ? $_POST['cart'] : [];

        $this->shopCar->pop($cart);

        dieJson(-1, '删除成功', U('cart'));
    }

    public function pushToCart()
    {
        $cart = isset($_POST['cart']) ? $_POST['cart'] : [];
        // $operator = isset($_POST['operator']) ? $_POST['operate'] : ShopCar::operator_rising;
        if ($cart) {
            $this->shopCar->push($cart);
            dieJson(-1, '添加购物车成功', U('cart'));
        } else {
            dieJson(1, '请选择商品');
        }
    }

    public function setNumber()
    {
        $goods_id = I('post.id', 0, 'intval');
        $goods_num = I('post.num', 0, 'intval');
        $this->shopCar->push($goods_id, $goods_num, ShopCar::operator_assign);
        echo json_encode(['sysnNumber' => $this->shopCar->getGoodsId($goods_id)]);
    }

    public function __construct()
    {
        $this->shopCar = new ShopCar(Person::get()->getPk());
    }

}