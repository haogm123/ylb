<?php
// +----------------------------------------------------------------------
// | dswjcms
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.tifaweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
// +----------------------------------------------------------------------
// | Author: 宁波市鄞州区天发网络科技有限公司 <dianshiweijin@126.com>
// +----------------------------------------------------------------------
// | Released under the GNU General Public License
// +----------------------------------------------------------------------
defined('THINK_PATH') or exit();
class CenterAction extends HomeAction {
//-------------个人中心--------------
//首页
	public function index(){
		$this->homeVerify();
		//标题、关键字、描述
		$Site = D("Site");
		$site=$Site->field('keyword,remark,title,link')->where('link="'.$_SERVER['REQUEST_URI'].'"')->find();
		$this->assign('si',$site);
		$active['center']='active';
		$this->assign('active',$active);
		$list=reset($this->user_details());	
		
		$this->assign('list',$list);
		$record=$this->moneyRecord($this->_session('user_uid'),3);	//最近资金记录
		$this->assign('record',$record);
		//数据统计
		//投资者
		$Collection=D('Collection');
		$collection=$Collection->where(array('uid'=>$this->_session('user_uid')))->relation('borrowing')->select();	//回款统计
		$collarr=array();
		foreach($collection as $coll){
			if($coll['type']==0){
				if(in_array($coll['bid'],$collarr)){
						$investment['returned_total']+=$coll['money'];	//回款中总额
				}else{
					$collarr[$coll['bid']]=$coll['bid'];
						$investment['returned_total']+=$coll['money'];	//回款中总额
						$investment['returned']+=1;	//回款中笔数
				}	
			}
		}
		unset($collection);
		$this->assign('investment',$investment);
		$this->display();
    }
//我是投资者
	public function invest(){
		$this->homeVerify();
		//正在收款的借款
		$isclosed=$this->bidRecords(1,0,$this->_session('user_uid'),1);
		$this->assign('isclosed',$isclosed);
		//投标的借款
		$isbid=$this->bidRecords(1,0,$this->_session('user_uid'));	
		$this->assign('isbid',$isbid);
		
		$refund=M('collection');
		$automatic=D('Automatic');
		$this->assign('mid',$this->_get('mid'));
		if($this->_get('bid') && $this->_get('mid')=='plan'){	//还款计划
				$refun=$refund->where('bid='.$this->_get('bid').' and uid='.$this->_session('user_uid'))->order('time ASC')->select();
			$this->assign('refun',$refun);
		}
		$active['center']='active';
		$this->assign('active',$active);
		$this->display();
    }
	
	/**
	* @标信息
	* @id		单条借款传入ID
	* @作者		shop猫
	* @版权		宁波天发网络
	* @官网		http://www.tifaweb.com http://www.dswjcms.com
	*/
	public function borrows($id){
		$borrowing = M("borrowing");
		return $borrowing->where('id='.$id)->field('id,title,rates,deadline,money,state')->find();
	}
	
	//资金管理	
	public function fund(){
		$this->homeVerify();
		$this->assign('mid',$this->_get('mid'));
		switch($this->_get('mid')){
			case 'fundrecord':	//资金明细
			$moneys=M('money')->where(array('uid'=>$this->_session('user_uid')))->find();//资金
			//待还总金额（管理费+逾期管理费+逾期罚息+原本息）
			$systems=$this->systems();
			$borrs=D('Refund')->field('interest,bid')->relation('borrowing')->where(array('uid'=>$this->_session('user_uid'),'type'=>0))->select();
			foreach($borrs as $bo){
				$moneys['stay_still']+=$bo['interest']/($bo['rates']*0.01/12)*$systems['sys_InterestMF'];
			}
			import('ORG.Util.Page');// 导入分页类
			$count      = D('Money_log')->where(array('type'=>0,'uid'=>$this->_session('user_uid')))->count();// 查询满足要求的总记录数
			$Page       = new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
			$show       = $Page->show();// 分页显示输出
			$record=D('Money_log')->relation(true)->where(array('type'=>0,'uid'=>$this->_session('user_uid')))->order('`time` DESC,`id` DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
			foreach($record as $id => $r){
				$record[$id]['finetypename']=$this->finetypeName($r['finetype']);
			}
			$this->assign('page',$show);// 赋值分页输出
			$this->assign('record',$record);
			$this->assign('money',$moneys);
			$active['center']='active';
			$this->assign('active',$active);
			break;
			case 'bank':	//银行账户
			$available_funds=M('money')->where(array('uid'=>$this->_session('user_uid')))->getField('available_funds');
			$userinfos = D('Userinfo')->relation(true)->field('uid,name,bank,bank_name,bank_account,certification')->where(array('uid'=>$this->_session('user_uid')))->find();	
			if($userinfos['certification']!=='2'){
				$this->error("请先通过实名认证",'__ROOT__/Center/approve/autonym.html');
			}
			$userinfos['available_funds']=$available_funds;
			$this->assign('userinfos',$userinfos);
			$list=M('unite')->field('name,value')->where('`state`=0 and `pid`=14')->order('`order` asc,`id` asc')->select();
			$this->assign('list',$list);
			
			break;
			case 'draw'://账户提现
			$userinfos = D('Userinfo')->relation(true)->field('uid,name,bank,bank_name,bank_account,certification')->where(array('uid'=>$this->_session('user_uid')))->find();
			if($userinfos['certification']!=='2'){
				$this->error("请先通过实名认证",'__ROOT__/Center/approve/autonym.html');
			}
			$available_funds=M('money')->where(array('uid'=>$this->_session('user_uid')))->getField('available_funds');
			$userinfos['available_funds']=$available_funds;
			$list=M('unite')->field('name,value')->where('`state`=0 and `pid`=14')->order('`order` asc,`id` asc')->select();
			foreach($list as $lt){
				if($lt['value']==$userinfos['bank']){
					$userinfos['banks']=$lt['name'];
					break;
				}
			}
			$this->assign('list',$list);
			$this->assign('userinfos',$userinfos);
			break;
			case 'drawrecord'://提现记录
			import('ORG.Util.Page');// 导入分页类
			$count      = D('Withdrawal')->where(array('uid'=>$this->_session('user_uid')))->count();// 查询满足要求的总记录数
			$Page       = new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
			$show       = $Page->show();// 分页显示输出
			$withuser=$this->showUser('',$this->_session('user_uid'),'',$Page->firstRow.','.$Page->listRows);
			$this->assign('withuser',$withuser);
			$this->assign('page',$show);// 赋值分页输出
			break;
			case 'inject':	//充值
			$audit=$this->offlineBank();
			$this->assign('audit',$audit);
			$online=M('online');
			$onlines=$online->field('id,name')->where('`state`=0')->order('`order` asc,`id` asc')->select();
			$this->assign('onlines',$onlines);
			break;
			case 'injectrecord':	//充值记录
			import('ORG.Util.Page');// 导入分页类
			$count      = D('Recharge')->where(array('uid'=>$this->_session('user_uid')))->count();// 查询满足要求的总记录数
			$Page       = new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
			$show       = $Page->show();// 分页显示输出
			$showuser=$this->rechargeUser('',$this->_session('user_uid'),'',$Page->firstRow.','.$Page->listRows);
			$this->assign('showuser',$showuser);
			$this->assign('page',$show);// 赋值分页输出
			break;
			
		}
		$this->display();
    }
	
	//提现申请	
	public function drawUpda(){
		$this->homeVerify();
		$withdrawal=D('Withdrawal');
		$user=D('User');
		$money=M('money');
		$userinfo=M('userinfo');
		$message=reset($userinfo->field('certification,bank,bank_name,bank_account')->where(array('uid'=>$this->_session('user_uid')))->select());//获取姓名、银行帐号信息用来判断
		if($message['certification']!=='2'){
			$this->error("请先通过实名认证",'__ROOT__/Center/approve/autonym.html');
		}
		if(!$message['bank'] || !$message['bank_name'] || !$message['bank_account'] ){
			$this->error("请先填写银行账户",'__ROOT__/Center/fund/mid/bank.html');
		}
		$moneys=reset($money->field('total_money,available_funds,freeze_funds')->where(array('uid'=>$this->_session('user_uid')))->select());
		$pay_password=$user->where(array('id'=>$this->_session('user_uid')))->getField('pay_password');
		if($user->userPayMd5($this->_post('password'))==$pay_password){	//验证支付密码
			if($this->_post('money')<=$moneys['available_funds']){	//提现金额必须小于可用余额
				if($create=$withdrawal->create()){
					$create['withdrawal_poundage']=$this->withdrawalPoundage($this->_post('money'));
					$create['account']=$this->_post('money')-$create['withdrawal_poundage'];
					$create['time']=time();
					$result = $withdrawal->add($create);
					if($result){
						$moneyarr['available_funds']=$moneys['available_funds']-$create['money'];
						$moneyarr['freeze_funds']=$moneys['freeze_funds']+$create['money'];
						$money->where(array('uid'=>$this->_session('user_uid')))->save($moneyarr);
						$this->moneyLog(array(0,'提现申请成功，冻结资金',$this->_post('money'),'平台',$moneys['total_money'],$moneyarr['available_funds'],$moneyarr['freeze_funds']),4);	//资金记录
						$this->success("提现申请成功",'__ROOT__/Center/fund/mid/drawrecord.html');
					}else{
						$this->error("提现申请失败");
					}
					
				}else{
					$this->error($withdrawal->getError());
				}
			}else{
				$this->error("提现金额需小于可提现金额");
			}
		}else{
			$this->error("支付密码错误");
		}
	}
//提现撤销	
	public function drawUndo(){
		$this->homeVerify();
		$id=$this->_post('id');
		$withdrawal=D('Withdrawal');
		$user=D('User');
		$money=M('money');
		$userinfo=M('userinfo');
		
		$moneys=reset($money->field('total_money,available_funds,freeze_funds')->where(array('uid'=>$this->_session('user_uid')))->select());
		$withdrawals=M('withdrawal')->field('money')->where(array('id'=>$id))->find();
		if($create=$withdrawal->create()){
			$result = $withdrawal->where(array('id'=>$id))->save();	//改变提现状态
			if($result){
				$moneyarr['available_funds']=$moneys['available_funds']+$withdrawals['money'];
				$moneyarr['freeze_funds']=$moneys['freeze_funds']-$withdrawals['money'];
				$money->where(array('uid'=>$this->_session('user_uid')))->save($moneyarr);
				$this->moneyLog(array(0,'提现撤销',$withdrawals['money'],'平台',$moneys['total_money'],$moneyarr['available_funds'],$moneyarr['freeze_funds']),12);	//资金记录
				$this->success("提现撤销成功",'__ROOT__/Center/fund/mid/drawrecord.html');
			}else{
				$this->error("提现撤销失败");
			}
			
		}else{
			$this->error($withdrawal->getError());
		}
	}
	
	//账号充值	
	public function injectAdd(){
		$this->homeVerify();
		$recharge=D('Recharge');
		
		if($create=$recharge->create()){	
			 	$create['nid']				=$this->orderNumber();	//订单号
				$create['uid']				=$this->_session('user_uid');	//用户ID
				$create['poundage']			=$this->topUpFees($create['money']);//充值手续费
				$create['account_money']	=$create['money']-$create['poundage'];//到帐金额
				$create['time']				=time();
				$create['type']				=1;
				if($this->_post('way')==0){
					if(!$this->_post('oid')){
						$this->error("请选择充值类型");
					}
					if(!$this->_post('number')){
						$this->error("流水号必须");
					}
					$create['genre']				=0;		//线下充值
				}else{	//网上充值
			/*Dswjcmsalipay start*/
			
		if($this->_post('onid')==1){
			echo "<script>window.location.href='".__ROOT__."/Center/alipayapi?price=".$this->_post('money')."';</script>";
			exit;
		}
		
			/*Dswjcmsalipay end*/
			
				}
				$result = $recharge->add($create);
			if($result){
				$this->success("充值已提交","__ROOT__/Center/fund/mid/injectrecord.html");			
			}else{
				 $this->error("充值提交失败");
			}	
		}else{
			$this->error($recharge->getError());
			
		}
	}
	
	public function approve(){
		$this->homeVerify();
		$head='<link  href="__PUBLIC__/css/style.css" rel="stylesheet">';
		$this->assign('head',$head);
		$unite=M('unite');
		$userinfo=M('userinfo');
		$list=$unite->field('name,value')->where('`state`=0 and `pid`=13')->order('`order` asc,`id` asc')->select();
		$this->assign('list',$list);
		$user_details=$this->user_details();
		$certification=$user_details[0][certification];
		$this->assign('user_details',$user_details);
		$userfo=$userinfo->field('qq,certification')->where(array('uid'=>$this->_session('user_uid')))->find();
		
		if($this->_get('mid')=='video'){	//视频认证
			if($userfo['certification']!=='2'){
				$this->error("请先通过实名认证！",'__ROOT__/Center/approve/autonym.html');
			}
			if(!$userfo['qq']){
				$this->error("请先完善个人资料！",'__ROOT__/Center/basic/personal_data.html');
			}
		}
		if($this->_get('mid')=='scene'){	//现场认证
			if($userfo['certification']!=='2'){
				$this->error("请先通过实名认证！",'__ROOT__/Center/approve/autonym.html');
			}
			if(!$userfo['qq']){
				$this->error("请先完善个人资料！",'__ROOT__/Center/basic/personal_data.html');
			}
		}
		$this->assign('certification',$certification);
		$this->assign('mid',$this->_get('mid'));
		$this->display();
    }
	
	//注册AJAX验证
	public function ajaxverify(){
		if($this->_post("name")=="cellphone"){	//验证手机
			$user=D('Userinfo');
			$row=$user->where('cellphone="'.$this->_post('param').'"')->count();
			if($row){
				echo '{
					"info":"手机号已存在！",
					"status":"n"
				 }';
			}else{
				echo '{
					"info":"可以注册！",
					"status":"y"
				 }';
			}
		}
	}
	
	//手机号码更换
	public function cellphoneedit(){
		M('userinfo')->where(array('uid'=>$this->_session('user_uid')))->save(array('cellphone'=>$this->_post('cellphone')));
		$this->success("手机更换成功");
	}
	
	//实名认证提交
	function autonymUpda(){
		$userinfo=D('Userinfo');
		
		if(count($this->_post('idcard_img'))<2) {
		   $this->error('身份证证未上传！','__ROOT__/Center/approve/autonym.html');
			exit;
		}
		
		if($create=$userinfo->create()){
			$create['idcard_img']=implode(",",$this->_post('idcard_img'));
			$userinfo->where(array('uid'=>$this->_session('user_uid')))->save($create);
			$this->success("申请成功");
		}else{
			$this->error($userinfo->getError(),'__ROOT__/Center/approve/autonym.html');
		}
	}
	
	//手机手动认证
	function appphone(){
		$userinfo=D('Userinfo');
		if($create=$userinfo->create()){
			$create['cellphone_audit']=1;
			$userinfo->where(array('uid'=>$this->_session('user_uid')))->save($create);
			$this->success("申请成功");
		}else{
			$this->error($userinfo->getError());
		}
	}
	
	//邮箱验证
	public function emailVerify(){
		$this->homeVerify();
		$userinfo=M('user');
		$smtp=M('smtp');
		$stmpArr=$smtp->find();
		$getfield = $userinfo->where(array('id'=>$this->_session('user_uid'),'email'=>$this->_post('email')))->find();
		if(!$getfield){		
			if($userinfo->create()){
				$result = $userinfo->where(array('id'=>$this->_session('user_uid')))->save();
				if(!$result){
					$this->error("邮箱未能发送，请联系管理员");
				}		
			}else{
				$this->error($userinfo->getError());
			}
		}
		$stmpArr['receipt_email']	=$this->_post('email');
		$stmpArr['title']			="用户激活邮件";
		$stmpArr['content']			='<div>
											<p>您好，<b>'.$this->_session('user_name').'</b> ：</p>
										</div>
										<div style="margin: 6px 0 60px 0;">
											<p>欢迎加入<strong>'.$stmpArr['addresser'].'</strong>！请点击下面的链接来认证您的邮箱。</p>
											<p><a href="http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/Center/emailVerifyConfirm/'.base64_encode($this->_session('user_uid')).'">http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/Center/emailVerifyConfirm/'.base64_encode($this->_session('user_uid')).'</a></p>
											<p>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中认证。</p>
										</div>
										<div style="color: #999;">
											<p>发件时间：'.date('Y/m/d H:i:s').'</p>
											<p>此邮件为系统自动发出的，请勿直接回复。</p>
										</div>';
		$emailsend=$this->email_send($stmpArr);	
		if($emailsend){
			$this->success('邮件发送成功', '__ROOT__/Center/approve/email.html');
		}else{
			$this->error("邮箱激活失败，请联系管理员");
		}	
	}

	//邮箱验证确认
	public function emailVerifyConfirm(){
		//$this->homeVerify();
		$userinfo=M('userinfo');
		$username=base64_decode($this->_get('email_audit'));
			$emailVerifyConfirm['email_audit']=$username?2:0;
			$result = $userinfo->where(array('uid'=>$username))->save($emailVerifyConfirm);
			if($result){
			//记录添加点
			$sendMsg=$this->silSingle(array('title'=>'用户通过邮箱验证','sid'=>$this->_session('user_uid'),'msg'=>'用户通过邮箱验证'));//站内信
			$this->userLog('通过邮箱验证');//前台操作
			$arr['member']=array('uid'=>$this->_session('user_uid'),'name'=>'mem_email_audit');
			$vip_points=M('vip_points');	
			$vips=$vip_points->where(array('uid'=>$this->_session('user_uid')))->find();
			if($vips['audit']==2){	//判断是不是开通了VIP
				$arr['vip']=array('uid'=>$this->_post('uid'),'name'=>'vip_email_audit');
			}
			$userss=M('user');
			$promotes=$userss->where(array('id'=>$this->_session('user_uid')))->find();
			if($promotes['uid']){	//判断是不是有上线
				$arr['promote']=array('uid'=>$promotes['uid'],'name'=>'pro_email_audit');
			}
			//$integralAdd=$this->integralAdd($arr);	//积分操作
				$this->success('邮箱已激活','__ROOT__/Center.html');
			}else{
				$this->error("邮箱激活失败，请联系管理员");
			}		
	}
	
	//邮箱找回密码
	public function emailBack(){
		$this->homeVerify();
		$smtp=M('smtp');
		$stmpArr=$smtp->find();
		$email=$this->_post('email');
		$stmpArr['receipt_email']	=$email;
		$cache = cache(array('expire'=>3600));
		$cache->set('pawss'.$this->_session('user_uid'),md5($email));	//设置缓存
		$stmpArr['title']			="找回密码";
		$stmpArr['content']			='<div>
											<p>您好，<b>'.$this->_session('user_name').'</b> ：</p>
										</div>
										<div style="margin: 6px 0 60px 0;">
											<p>请点击这里，修改您的密码</p>
											<p><a href="http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/Center/security/Rpasswordpag?pass='.$cache->get('pawss'.$this->_session('user_uid')).'">http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/Center/security/Rpasswordpag?pass='.$cache->get('pawss'.$this->_session('user_uid')).'</a></p>
											<p>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中认证。</p>
										</div>
										<div style="color: #999;">
											<p>发件时间：'.date('Y/m/d H:i:s').'</p>
											<p>此邮件为系统自动发出的，请勿直接回复。</p>
										</div>';
		$emailsend=$this->email_send($stmpArr);	
		if($emailsend){
			$this->success('邮件发送成功', '__ROOT__/Center/security/Rpassword.html');
		}else{
			$this->error("邮箱找回密码失败，请联系管理员");
		}	
	}
	
	//邮箱找回密码提交
	public function emailPasssubmit(){
		$user=D('User');
		$users=$user->where(array('id'=>$this->_session('user_uid')))->find();
		if($user->create()){
			$result = $user->where(array('id'=>$this->_session('user_uid')))->save();
			if($result){
				$cache = cache(array('expire'=>50));
				$cache->rm('pawss'.$this->_session('user_uid'));// 删除缓存
			 	$this->success("密码重置成功","__ROOT__/Center.html");
			}else{
			$this->error("新密码不要和原始密码相同！");
			}		
		}else{
			$this->error($user->getError());
		}

	}
	
	//邮箱找回交易密码
	public function dealemailBack(){
		$this->homeVerify();
		$smtp=M('smtp');
		$stmpArr=$smtp->find();
		$email=$this->_post('email');
		$stmpArr['receipt_email']	=$email;
		$cache = cache(array('expire'=>3600));
		$cache->set('dealpawss'.$this->_session('user_uid'),md5($email));	//设置缓存
		$stmpArr['title']			="找回交易密码";
		$stmpArr['content']			='<div>
											<p>您好，<b>'.$this->_session('user_name').'</b> ：</p>
										</div>
										<div style="margin: 6px 0 60px 0;">
											<p>请点击这里，修改您的交易密码</p>
											<p><a href="http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/Center/security/dealRpasswordpag?pass='.$cache->get('dealpawss'.$this->_session('user_uid')).'">http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/Center/security/dealRpasswordpag?pass='.$cache->get('dealpawss'.$this->_session('user_uid')).'</a></p>
											<p>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中认证。</p>
										</div>
										<div style="color: #999;">
											<p>发件时间：'.date('Y/m/d H:i:s').'</p>
											<p>此邮件为系统自动发出的，请勿直接回复。</p>
										</div>';
		$emailsend=$this->email_send($stmpArr);	
		if($emailsend){
			$this->success('邮件发送成功', '__ROOT__/Center/security/dealRpassword.html');
		}else{
			$this->error("邮箱找回密码失败，请联系管理员");
		}	
	}
	
	//邮箱找回交易密码提交
	public function dealemailPasssubmit(){
		$user=D('User');
		$users=$user->where(array('id'=>$this->_session('user_uid')))->find();
		if($user->create()){
			$result = $user->where(array('id'=>$this->_session('user_uid')))->save();
			if($result){
				$cache = cache(array('expire'=>50));
				$cache->rm('dealpawss'.$this->_session('user_uid'));// 删除缓存
			 	$this->success("交易密码重置成功","__ROOT__/Center.html");
			}else{
			$this->error("新交易密码不要和原始交易密码相同！");
			}		
		}else{
			$this->error($user->getError());
		}

	}
//基本设置	
	public function basic(){
		$this->homeVerify();
		$unite=M('unite');
		$list=$unite->field('pid,name,value')->where('`state`=0 and `pid`=8 or `pid`=9 or `pid`=10 or `pid`=11 or `pid`=12')->order('`order` asc,`id` asc')->select();
		foreach($list as $lt){
			switch($lt[pid]){
				case 8:
				$education[]=$lt;
				break;
				case 9:
				$monthly_income[]=$lt;
				break;
				case 10:
				$housing[]=$lt;
				break;
				case 11:
				$buy_cars[]=$lt;
				break;
				case 12:
				$industry[]=$lt;
				break;
			}
		}
		$citys=$this->city();
		$userinfo=M('userinfo');
		$userinfo=$userinfo->field('location,marriage,education,monthly_income,housing,buy_cars,qq,fixed_line,industry,company')->where(array('uid'=>$this->_session('user_uid')))->order('`id` asc')->select();		
		$userinfo[0]['location']=explode(" ",$userinfo[0]['location']);
		foreach($userinfo[0]['location'] as $id=>$location){
			$lon.=$citys[$location]." ";
		}
		$userinfo[0]['location']=$lon;
		$this->assign('userinfo',$userinfo);
		$this->assign('education',$education);
		$this->assign('monthly_income',$monthly_income);
		$this->assign('housing',$housing);
		$this->assign('buy_cars',$buy_cars);
		$this->assign('industry',$industry);
		$this->assign('list',$list);
		$this->assign('mid',$this->_get('mid'));
		$active['center']='active';
		$this->assign('active',$active);
		$this->display();
    }
	
	
	//站内信
	public function mails(){
		$active['center']='active';
		$this->assign('active',$active);
		$this->assign('mid',$this->_get('mid'));
		$this->homeVerify();
		//标题、关键字、描述
		$active['review']='active';
		$this->assign('active',$active);
		//区分会员本人登陆还是其它人访问
		$this->homeVerify();
		$user_uid=$this->_session('user_uid');
		if($this->_get('pid')=='discuss'){
			$site['title']="发出的评论";
		}else{
			$site['title']="收到的通知";
		}
		$site['link']=1;
		$this->assign('si',$site);
		import('ORG.Util.Page');// 导入分页类
		if(isset($_GET['mid'])){
			$where=' and `state`="'.$this->_get('mid').'"';
		}else{
			$where=' and `state`<2';
		}
		$count      = M('instation')->where('`sid`="'.$this->_session('user_uid').'"'.$where)->count();// 查询满足要求的总记录数
		$Page       = new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出
		$all=$this->silReceipt($this->_session('user_uid'),$this->_get('mid'),$Page->firstRow.','.$Page->listRows);
		$this->assign('all',$all);
		$this->assign('page',$show);// 赋值分页输出
		$this->display();
	}
	
	//站内信显示
	public function standLetter(){
		
		$id=$this->_post('id');
		echo $this->singleReceipt($id);
	}
	
	//站内信删除
	public function stationexit(){
		$Instation=M('instation');
		$id=$this->_get('id');
		$Instation->where('`id`="'.$id.'"')->setField('state',2);
		$this->success("删除成功");
	}
	
	//站内信还原
	public function reduction(){
		$Instation=M('instation');
		$id=$this->_get('id');
		$Instation->where('`id`="'.$id.'"')->setField('state',1);
		$this->success("还原成功");
	}

//安全中心
	public function security(){
		$this->homeVerify();
		$active['center']='active';
		$this->assign('active',$active);
		$this->assign('mid',$this->_get('mid'));
		$userinfo=M('user');
		$email=$userinfo->field('email')->where('id="'.$this->_session('user_uid').'"')->find();
		$this->assign('email',$email);
		$cache = cache(array('expire'=>50));
		
		if($this->_get('mid')=='Rpasswordpag'){	//找回密码修改
		$value = $cache->get('pawss'.$this->_session('user_uid'));  // 获取缓存
			if(!md5($email['email'])==$value){	//判断链接是否过期
				$this->error("链接已过期！","__ROOT__/Logo/login.html");
			}
		}
		if($this->_get('mid')=='dealRpasswordpag'){	//找回密码修改
		$value = $cache->get('dealpawss'.$this->_session('user_uid'));  // 获取缓存
			if(!md5($email['email'])==$value){	//判断链接是否过期
				$this->error("链接已过期！","__ROOT__/Logo/login.html");
			}
		}
		//print_r($value);
		//$cache->rm('pawss'.$this->_session('user_uid'));
		//exit;
		$active['center']='active';
		$this->assign('active',$active);
		$this->display();
    }

	//修改密码
	public function updaPass(){
		$user=D('User');
		$users=$user->where('id="'.$this->_session('user_uid').'"')->find();
		if($user->create()){
			if($user->userMd5($this->_post('passwd'))==$users['password']){
				$result = $user->where(array('id'=>$this->_session('user_uid')))->save();
				if($result){
				 $this->success("密码重置成功","__ROOT__/Center/security/password.html");
				}else{
				$this->error("新密码不要和原始密码相同！");
				}		
			}else{
				$this->error("原始密码错误！");
			}
		}else{
			$this->error($user->getError());
		}

	}

	//修改交易密码
	public function updaPayPass(){
		$this->homeVerify();
		$user=D('User');
		$users=$user->where('id="'.$this->_session('user_uid').'"')->find();
		if($user->create()){
			if($user->userPayMd5($this->_post('pay_pasd'))==$users['pay_password']){
				$result = $user->where(array('id'=>$this->_session('user_uid')))->save();
				if($result){
				 $this->success("交易密码重置成功","__ROOT__/Center/security/tpassword.html");
				}else{
				$this->error("新交易密码不要和原始交易密码相同！");
				}		
			}else{
				$this->error("原始交易密码错误！");
			}
		}else{
			$this->error($user->getError());
		}

	}
//头像上传	
	public function portrait(){
		$this->homeVerify();
		$active['center']='active';
		$this->assign('active',$active);
		$head=$this->headPortrait('./Public/FaustCplus/php/img/big_user_'.$this->_session('user_uid').'.jpg');
		$this->assign('heads',$head);
		$this->display();
    }
	

			
			
			
			
			
			
			/*Dswjcmsalipay start*/
			
	//支付宝跳转页
	public function alipayapi($price){
		header("Content-Type:text/html; charset=utf-8");
		import('@.Plugin.Dswjcmsalipay.Alipay.Submit');
		$online=M('online');
		$list=$online->where('`id`=1')->find();
		$alipay_config['partner']		= $list['pid'];
		$alipay_config['key']			= $list['checking'];
		$alipay_config['sign_type']    = strtoupper('MD5');//签名方式 不需修改
		$alipay_config['input_charset']= strtolower('utf-8');//字符编码格式 目前支持 gbk 或 utf-8
		$alipay_config['transport']    = 'http';//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $payment_type = "1";//支付类型
        $notify_url = "http://".$_SERVER['HTTP_HOST']."/Center/notify";//服务器异步通知页面路径 
        $return_url = "http://".$_SERVER['HTTP_HOST']."/Center/alipayreturn";//页面跳转同步通知页面路径
        $seller_email = $list['account'];//卖家支付宝帐户
        $out_trade_no = $this->orderNumber();//商户订单号
        $subject = '支付宝';//订单名称
        $quantity = "1";//商品数量
        $logistics_fee = "0.00";//物流费用
        $logistics_type = "EXPRESS";//物流类型
        $logistics_payment = "SELLER_PAY";//物流支付方式
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "trade_create_by_buyer",
				"partner" => trim($alipay_config['partner']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"seller_email"	=> $seller_email,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"price"	=> $price,
				"quantity"	=> $quantity,
				"logistics_fee"	=> $logistics_fee,
				"logistics_type"	=> $logistics_type,
				"logistics_payment"	=> $logistics_payment,
				"body"	=> $body,
				"show_url"	=> $show_url,
				"receive_name"	=> $receive_name,
				"receive_address"	=> $receive_address,
				"receive_zip"	=> $receive_zip,
				"receive_phone"	=> $receive_phone,
				"receive_mobile"	=> $receive_mobile,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);
		//插入数据
		$recharge=M('recharge');
		$poundage=$this->onlineUpFees($price);//充值手续费
		$amount=$price-$poundage;	//到账金额
		$add=$recharge->add(array('uid'=>$this->_session('user_uid'),'genre'=>1,'nid'=>$out_trade_no,'money'=>$price,'time'=>time(),'type'=>1,'account_money'=>$amount,'poundage'=>$poundage));	//插入数据库
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		echo $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
	}
	
	
	//支付宝跳转同步通知
	public function alipayreturn(){
		header("Content-Type:text/html; charset=utf-8");
		import('@.Plugin.Dswjcmsalipay.Alipay.Notify');
		$online=M('online');
		$list=$online->where('`id`=1')->find();
		$alipay_config['partner']		= $list['pid'];
		$alipay_config['key']			= $list['checking'];
		$alipay_config['sign_type']    = strtoupper('MD5');//签名方式 不需修改
		$alipay_config['input_charset']= strtolower('utf-8');//字符编码格式 目前支持 gbk 或 utf-8
		$alipay_config['transport']    = 'http';//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		//获取充值
		$recharge=M('recharge');
		$rechar=$recharge->where('nid='.$this->_get('out_trade_no'))->find();
		if($verify_result) {//验证成功
			$recharge->where('nid='.$this->_get('out_trade_no'))->save(array('type'=>2,'audittime'=>time(),'date'=>json_encode($_GET),'handlers'=>'第三方支付'));
			//获取用户资金
			$money=M('money');
			$mon=$money->field('total_money,available_funds,freeze_funds')->where(array('uid'=>$rechar['uid']))->find();
			$array['total_money']				=$mon['total_money']+$rechar['account_money'];
			$array['available_funds']			=$mon['available_funds']+$rechar['account_money'];	
			//记录添加点
			$money->where(array('uid'=>$rechar['uid']))->save($array);
			$this->silSingle(array('title'=>'充值成功','sid'=>$rechar['uid'],'msg'=>'充值成功，帐户增加'.$rechar['account_money'].'元'));//站内信
			$this->moneyLog(array(0,'充值成功',$rechar['money'],'平台',$array['total_money']+$rechar['poundage'],$array['available_funds']+$rechar['poundage'],$mon['freeze_funds'],$rechar['uid']));	//资金记录
			$this->moneyLog(array(0,'充值手续费扣除',$rechar['poundage'],'平台',$array['total_money'],$array['available_funds'],$mon['freeze_funds'],$rechar['uid']));	//资金记录
			$this->userLog('充值成功');//会员操作
			$this->success('充值成功','__ROOT__/Center/fund/injectrecord.html');
		}else{
			$recharge->where('nid='.$billno)->save(array('type'=>3,'audittime'=>time(),'date'=>json_encode($_GET),'handlers'=>'第三方支付'));	//充值失败
			//记录添加点
			$this->error('充值失败!','__ROOT__/Center/fund/injectrecord.html');
		}
	}	
		
			/*Dswjcmsalipay end*/
			//协议书	
	public function agreement(){
		$this->homeVerify();
		if(!$this->_get('bid')){
			$this->error("操作有误！");
		}
		$refund=M('refund');
		$collection=M('collection');
		$re=$refund->where('uid='.$this->_session('user_uid').' and bid='.$this->_get('bid'))->find();
		$co=$collection->where('uid='.$this->_session('user_uid').' and bid='.$this->_get('bid'))->find();
		if($re || $co){
			$boow=reset($this->borrow_unicom($this->_get('bid')));
			$bid_record=$this->lendUser('1',$this->_get('bid'));
			$Guarantee = D("Guarantee");
			$gcompany=$Guarantee->field('gid,idname,idcard,number,use')->relation(true)->where('bid='.$this->_get('bid'))->find();
			$this->assign('gcompany',$gcompany);
			$this->assign('bid',$bid_record);
			$refun=$refund->where('uid='.$boow['uid'].' and bid='.$this->_get('bid'))->select();
			$this->assign('refun',$refun);
			$this->assign('boow',$boow);
		}else{
				$this->error("操作有误！");
		}
		$this->display();
		if($this->_get('export')==1){//导出
			$this->exportWord('agreement');
		}
    }

}