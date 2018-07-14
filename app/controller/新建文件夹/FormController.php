<?php
namespace App\controller;
class FormController{

	public function group()
	{
		$verify = [//inted
			'city_name' => ['required', '当前城市信息获取失败'],
			'brand_id' => ['required', '当前品牌信息获取失败'],
			'car_id' => ['required', '未选择车型配置'],
			'car_config'=> ['required', '未选择车型配置'],
			'car_color' => ['required', '未选择颜色'],
			'buy_type' => ['required', '未选择购买方式'],
			'buyer_name' => ['required', '未填写姓名'],
			'buyer_number' => ['telphone', '请输入11位的手机号'],
		];
		$form = new \VerifyForm($verify, 'post');
		#验证不通过
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		if(strpos($form->car_config, '__')) list($car_name, $car_price) = explode('__', $form->car_config);
		else returnJson(-100, '未选择车型配置', 'car_config');

		$insert = M('order')->insert([

			'city_name' => $form->city_name,
			'brand_id' => $form->brand_id,
			'car_id' => $form->car_id,
			'car_name'=> $car_name,
			'car_price' => $car_price,
			'car_color' => $form->car_color,
            'buy_type' => $form->buy_type,
            'buyer_name' => $form->buyer_name,
            'buyer_number' => $form->buyer_number,

			'order_type' => 1,//团车

			'ip' => $form->ip(),
			'sendtime' => $form->time(),
		]);

		if ($insert) {
			returnJson(200, '团车订单已生成');
		} else {
			returnJson(-100, '网络延时, 无法生成订单');
		}

	}
	public function grab()
	{
		$verify = [//inted
			'city_name' => ['required', '当前城市信息获取失败'],
			'brand_id' => ['required', '当前品牌信息获取失败'],
			'car_id' => ['required', '未选择车型配置'],
			'car_config'=> ['required', '未选择车型配置'],
			'buyer_name' => ['required', '未填写姓名'],
			'buyer_number' => ['telphone', '请输入11位的手机号'],
		];
		$form = new \VerifyForm($verify, 'post');
		#验证不通过
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		if(strpos($form->car_config, '__')) list($car_name, $car_price) = explode('__', $form->car_config);
		else returnJson(-100, '未选择车型配置', 'car_config');

		$insert = M('order')->insert([

			'city_name' => $form->city_name,
			'brand_id' => $form->brand_id,
			'car_id' => $form->car_id,
			'car_name'=> $car_name,
			'car_price' => $car_price,
            'buyer_name' => $form->buyer_name,
            'buyer_number' => $form->buyer_number,

			'order_type' => 2,//秒车

			'ip' => $form->ip(),
			'sendtime' => $form->time(),
		]);

		if ($insert) {
			returnJson(200, '秒车订单已生成');
		} else {
			returnJson(-100, '网络延时, 无法生成订单');
		}

	}
	/*
	 * 完善秒车订单需求
	 */
	public function grabComplete()
	{
		$verify = [//inted
			'order_id' => ['required', '订单信息拉去失败'],
            'car_color' => ['required', '未选择颜色'],
			'buy_type' => ['required', '未选择购买方式'],
			'card_location' => ['required', '未填写上牌地点'],
			'is_offsite' => ['required', '未选择是否接受异地提车'],
		];
		$form = new \VerifyForm($verify, 'post');
		#验证不通过
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}

		$insert = M('order')->where('id='.$form->order_id)->update([

			'car_color' => $form->car_color,
            'buy_type' => $form->buy_type,
            'card_location' => $form->card_location,
            'is_offsite' => $form->is_offsite,

			'ip' => $form->ip(),
			'sendtime' => $form->time(),
		]);

		if ($insert) {
			returnJson(200, '秒车订单已生成');
		} else {
			returnJson(-100, '网络延时, 无法生成订单');
		}

	}
	public function index()
	{
		$verify = [//inted
			'name' => ['required', lang('name')],
			'email' => ['email', lang('email')],
			'phone' => ['telphone', lang('phone')],
			'address' => ['required', lang('address')],
		];
		$form = new \VerifyForm($verify, 'post');
		#验证不通过
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		/*$file = uppro_file('resume', config('pic.document'));
		if ($file === false) {
			returnJson(-100, '请上传你的简历,文件格式为word或jpg');
		}*/

		$insert = M('message')->insert([

			'name'  => $form->name,
		    'email' => $form->email,
			'phone'  => $form->phone,
			'address' => $form->address,
			// 'message' => $form->message,

			'type' => 47,
			'ip' => $form->ip(),
			'sendtime' => $form->time(),
		]);

		if ($insert) {
			returnJson(200, lang('message_success'));
		} else {
			returnJson(-100, lang('message_failed'));
		}

	}

}
