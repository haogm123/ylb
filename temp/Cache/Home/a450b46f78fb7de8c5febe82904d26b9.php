<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html lang="zh-CN"><head><meta charset="utf-8"><title><?php if(($si['link'] == '/') OR ($si['link'] == '')): else: echo ($si['title']); ?>-<?php endif; echo ($s["sys_name"]); ?></title><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="description" content="<?php echo ($si['remark']?$si['remark']:$s['sys_describe']); echo ($so["title"]); ?>"><meta name="KeyWords" content="<?php echo ($si['keyword']?$si['keyword']:$s['sys_keyword']); echo ($so["title"]); ?>"><meta name="generator" content="Dswjcms! X3.2" /><meta name="author" content="Dswjcms! Team and Tf Team" /><meta name="copyright" content="2013-2016 Tf Inc." /><meta property="qc:admins" content="6461155451641617526375" /><meta http-equiv="X-UA-Compatible" content="IE=9"><!--[if lt IE 9 ] ><META http-equiv="X-UA-Compatible" content="IE=8" ></META><![endif]--><link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet"><link href='__PUBLIC__/bootstrap/css/jquery.iphone.toggle.css' rel='stylesheet'><link href='__PUBLIC__/bootstrap/css/uploadify.css' rel='stylesheet'><link href='__PUBLIC__/bootstrap/css/jquery-ui-1.8.21.custom.css' rel='stylesheet'><link href='__PUBLIC__/bootstrap/css/uniform.default.css' rel='stylesheet'><link href="__PUBLIC__/css/hdocs.css" rel="stylesheet"><link href='__PUBLIC__/bootstrap/css/opa-icons.css' rel='stylesheet'><link href='__PUBLIC__/css/fotorama.css' rel='stylesheet'><link  href="__PUBLIC__/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"><link href='__PUBLIC__/jmhz/css/hdocs.css' rel='stylesheet'><link href='__PUBLIC__/jmhz/css/css.css' rel='stylesheet'><link href='__PUBLIC__/bootstrap/css/colorbox.css' rel='stylesheet'><link type="text/css" rel="stylesheet" href="__PUBLIC__/css/jquery.datetimepicker.css"><!--[if lte IE 6]><link href="__PUBLIC__/bootstrap/css/bootstrap-ie6.min.css" rel="stylesheet" type="text/css"><link href="__PUBLIC__/bootstrap/css/ie.css" rel="stylesheet" type="text/css"><script type="text/javascript" src="__PUBLIC__/bootstrap/js/bootstrap-ie.js"></script><![endif]--><?php echo ($head); ?><link rel="shortcut icon" href="__PUBLIC__/bootstrap/img/favicon.ico"><!-- jQuery --><script src="__PUBLIC__/js/timecount.js"></script><script src="__PUBLIC__/bootstrap/js/jquery-1.7.2.min.js"></script></head><body data-spy="scroll" data-target=".bs-docs-sidebar"><!--start: Header --><header><!--start: Container --><div class="container"><div role="banner" class="visible-desktop row-fluid"><div class="span6"><a href="/"><img src="__PUBLIC__/uploadify/uploads/logo/<?php echo ($s["sys_logo"]); ?>" style="height: 80px;margin-top: 10px;" alt="<?php echo ($s["sys_briefTitle"]); ?>"></a></div><div class="info span6"><?php if($_SESSION['user_name']== ''): ?><a href="__ROOT__/Logo/login.html">登陆</a>                |
                <a href="__ROOT__/Logo/register.html">注册</a><?php else: echo (session('user_name')); ?>                |
                <a href="__ROOT__/Center/mails.html">消息</a>                |
                <a href="__ROOT__/Logo/exits.html">退出</a><?php endif; ?><span class="phone"><?php echo ($s["sys_phone"]); ?></span><small>服务时间：9:00 - 17:00</small></div></div><hr class="dashed visible-desktop"><!--start: Navigation --><nav class="navbar navbar-inverse" role="navigation"><div class="navbar-inner"><a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a><a class="brand hidden-desktop" href="/"><img src="__PUBLIC__/uploadify/uploads/logo/<?php echo ($s["sys_logo"]); ?>" style="height: 50px;" alt="<?php echo ($s["sys_briefTitle"]); ?>"></a><div class="nav-collapse collapse"><ul class="nav"><li class="<?php echo ($active["index"]); ?>"><a href="/">首页</a></li><li class="<?php echo ($active["loan"]); ?>"><a href="__ROOT__/Loan.html">我要投资</a></li></ul><ul class="nav pull-right"><li class="<?php echo ($active["security"]); ?>"><a href="__ROOT__/Site/page/id/32">安全保障</a></li><li class="<?php echo ($active["center"]); ?>"><a href="__ROOT__/Center.html">我的账户</a></li><li class="<?php echo ($active["explanation"]); ?>" ><a href="__ROOT__/Site/listTpl/id/28.html">名词解释</a></li></ul></div></div></nav><!--end: Navigation --></div><!--end: Container--></header><!--end: Header--><div class="layout"><!--头部 end --><!--主体 --><div class="page-desc js-ignore-pagemark"><!-- start:Page-desc-inner --><div class="page-desc-inner"><div class="container"><h3>欢迎注册<?php echo ($s["sys_briefTitle"]); ?></h3></div></div><!-- end:Page-desc-inner --></div><div class="container"><!-- start:Row --><div class="row"><!-- start:Wall --><div class="span4 offset4 control-panle"><div class="control-panle-header"><h4>注册</h4><span><a href="__ROOT__/Logo/login.html">手机号注册</a></span></div><hr><form name="myform" id="myform" method="post" action='__URL__/addreg'><div class="row-fluid"><div class="control-group"><label class="control-label">用户名&nbsp;<span class="red">*</span></label><div class="controls"><input class="span12" type="text" maxlength="16" name="username" datatype="me" nullmsg="请输入用户名！" errormsg="用户名允许2-16个字,可包含中英文、数字、点和下划线！" ajaxurl="__URL__/ajaxverify" placeholder="用户名"></div><span class="help-block"></span></div><div class="control-group"><label class="control-label">密码&nbsp;<span class="red">*</span></label><div class="controls"><input class="span12" type="password" datatype="*6-15" maxlength="15" errormsg="密码范围在6~15位之间,不能使用空格！" nullmsg="请输入登录密码！" plugin="passwordStrength" name="password" placeholder="密码"></div><span class="help-block"></span></span></div><div class="control-group"><label class="control-label">重复密码&nbsp;<span class="red">*</span></label><div class="controls"><input class="span12" type="password" name="password" placeholder="重复密码" datatype="*" recheck="password" maxlength="15" errormsg="您两次输入的账号密码不一致！"  nullmsg="请重复上面所输入的密码！"  onkeyup="var va=$(this).val(); $('#pay_pass').val(va);"><input id="pay_pass" name="pay_password" type="hidden" value="" /></div><span class="help-block"></span></span></div><div class="control-group"><label class="control-label">验证码&nbsp;<span class="red">*</span></label><div class="controls"><input id="CaptchaInputText" type="text" class="span12" name="proving" placeholder="验证码" maxlength="4" datatype="*"  nullmsg="验证码不能为空！"><img class="CaptchaImage" id="verifyImg" src='__APP__/Public/verify/' onClick="changeVerify()" title="点击刷新验证码" data-rel="tooltip" style="cursor:pointer;padding-left: 10px;"/></div><span class="help-block"></span></div><div class="control-group"><div class="controls" style="*position:relative"><label class="checkbox" style="*left: 60px; *position: absolute; *margin-bottom:30px"><input class="valid" checked="checked" name="ck" type="checkbox"  datatype="*" value="1" nullmsg="必须同意用户协议才可通过注册！">同意<?php echo ($s["sys_briefTitle"]); ?><a href="#Contract" data-toggle="modal" class="btn btn-primary btn-mini">用户协议</a></label></div><span class="help-block"></span></div><hr><button type="submit" class="btn btn-primary span12" style="margin-left: 0" tabindex="4">注册</button></div></form></div><!-- end:Wall --></div><!-- end:Row --></div><!-- 主体 end--><!--底部 --><div style="display: none;" id="Contract" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ContractLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="ContractLabel"><?php echo ($s["sys_briefTitle"]); ?>网站服务协议</h3></div><div class="modal-body"><p>"<?php echo ($s["sys_briefTitle"]); ?>"网站（以下简称"本网站"）由宁波天发网络科技有限公司(以下简称"本公司")负责运营。本服务协议双方为本网站用户与本公司，适用于用户注册使用本网站服务的全部活动。</p><p>在注册成为本网站用户前，请您务必认真、仔细阅读并充分理解本服务协议全部内容。您在注册本网站取得用户身份时勾选同意本服务协议
并成功注册为本网站用户，视为您已经充分理解和同意本服务协议全部内容，并签署了本服务协议，本服务协议立即在您与本公司之间产生合同法律效力，您注册使
用本网站服务的全部活动将受到本服务协议的约束并承担相应的责任和义务。如您不同意本服务协议内容，请不要注册使用本网站服务。</p><p>本服务协议包括以下所有条款，同时也包括本网站已经发布的或者将来可能发布的各类规则。所有规则均为本服务协议不可分割的一部分，与本服务协议具有同等法律效力。</p><p>用户在此确认知悉并同意本公司有权根据需要不时修改、增加或删减本服务协议。本公司将采用在本网站公示的方式通知用户该等修改、增
加或删减，用户有义务注意该等公示。一经本网站公示，视为已经通知到用户。若用户在本服务协议及各类规则变更后继续使用本网站服务的，视为用户已仔细认真
阅读、充分理解并同意接受修改后的本服务协议及各类规则，且用户承诺遵守修改后的本服务协议及各类规则内容，并承担相应的义务和责任。若用户不同意修改后
的本服务协议及各类规则内容，应立即停止使用本网站服务，本公司保留中止、终止或限制用户继续使用本网站服务的权利，但该等终止、中止或限制行为并不豁免
用户在本网站已经进行的交易下所应承担的责任和义务。本公司不承担任何因此导致的法律责任。</p><h4>一. 本网站服务</h4><p>本网站为用户提供【信用咨询、评估、管理，促成用户与本网站其他用户达成交易的居间服务，还款管理等服务】，用户通过本网站居间服务与其他用户达成的所有交易项下资金的存放和移转均通过本网站。</p><h4>二. 服务费用</h4><p>用户注册使用本网站服务，本公司有权向用户收取服务费用，具体服务费用以本网站公告或其他协议为准。用户承诺按照本服务协议约定向
本网站支付服务费用，并同意本网站有权自其有关账户中直接扣划服务费用。用户通过本网站与其他方签订协议的，用户按照签署的协议约定向其他方支付费用。</p><h4>三. 使用限制</h4><ol><li>注册成为本网站用户必须满足如下主体资格条件：具有中华人民币共和国（以下简称"中国"）国籍（不包括中国香港、澳门及
台湾地区）、年龄在18周岁以上、具有完全民事行为能力的自然人。若不具备前述主体资格条件，请立即终止注册使用本网站服务.若违反前述规定注册使用本网
站服务，本公司保留终止用户资格、追究用户或用户的监护人相关法律责任的权利。</li><li>用户在注册使用本网站服务时应当根据本网站的要求提供自己的真实信息（包括但不限于真实姓名、联系电话、地址、电子邮箱
等信息），并保证向本网站提供的各种信息和资料是真实、准确、完整、有效和合法的，复印件与原件一致。如用户向本网站提供的各项信息和资料发生变更，用户
应当及时向本网站更新用户的信息和资料，如因用户未及时更新信息和资料导致本网站无法向用户提供服务或发生错误，由此产生的法律责任和后果由用户自己承
担。如使用他人信息和文件注册使用本网站服务或向本网站提供的信息和资料不符合上述规定，由此引起的一切责任和后果均由用户本人全部承担，本公司及本网站
不因此承担任何法律责任，如因此而给本公司及本网站造成损失，用户应当承担赔偿本公司及本网站损失的责任。</li><li>成功注册为本网站用户后，用户应当妥善保管自己的用户名和密码，不得将用户名转让、赠与或授权给第三方使用。用户在此确
认，使用其用户的用户名和密码登录本网站及由用户在本网站的用户账户下发出的一切指令均视为用户本人的行为和意思，该等指令不可逆转，由此产生的一切责任
和后果由用户本人承担，本公司及本网站不承担任何责任。</li><li>用户不得利用本网站从事任何违法违规活动，用户在此承诺合法使用本网站提供的服务，遵守中国现行法律、法规、规章、规范
性文件以及本服务协议的约定。若用户违反上述规定，所产生的一切法律责任和后果与本公司和本网站无关，由用户自行承担，如因此给本公司和本网站造成损失
的，由用户赔偿本公司和本网站的损失。本公司保留将用户违法违规行为及有关信息资料进行公示、计入用户信用档案、按照法律法规的规定提供的有关政府部门或
按照有关协议约定提供给第三方的权利。</li><li>如用户在本网站的某些行为或言论不合法、违反有关协议约定、侵犯本公司的利益等，本公司有权基于独立判断直接删除用户在
本网站上作出的上述行为或言论，有权中止、终止、限制用户使用本网站服务，而无需通知用户，亦无需承担任何责任。如因此而给本公司及本网站造成损失的，应
当赔偿本公司及本网站的损失。</li></ol><h4>四. 不保证条款</h4><p>本网站提供的服务中不含有任何明示、暗示的，对任何用户、任何交易的真实性、准确性、可靠性、有效性、完整性等的任何保证和承诺，
用户需根据自身风险承受能力，衡量本网站披露的交易内容及交易对方的真实性、可靠性、有效性、完整性，用户因其选择使用本网站提供的服务、参与的交易等而
产生的直接或间接损失均由用户自己承担，包括但不限于资金损失、利润损失、营业中断等。本公司及其股东、创始人、全体员工、代理人、关联公司、子公司、分
公司均不对以上损失承担任何责任。</p><h4>五. 责任限制</h4><ol><li>基于互联网的特殊性，本公司无法保证本网站的服务不会中断，对于包括但不限于本公司、本网站及相关第三方的设备、系统存
在缺陷，计算机发生故障、遭到病毒、黑客攻击或者发生地震、海啸等不可抗力而造成服务中断或因此给用户造成的损失，本公司不承担任何责任，有关损失由用户
自己承担。</li><li>本公司无义务监测本网站内容。用户对于本网站披露的信息、选择使用本网站提供的服务，选择参与交易等，应当自行判断真实性和承担风险，由此而产生的法律责任和后果由用户自己承担，本公司不承担任何责任。</li><li>与本公司合作的第三方机构向用户提供的服务由第三方机构自行负责，本公司不对此等服务承担任何责任。</li><li>本网站的内容可能涉及第三方所有的信息或第三方网站，该等信息或第三方网站的真实性、可靠性、有效性等由相关第三方负责，用户对该等信息或第三方网站自行判断并承担风险，与本网站和本公司无关。</li><li>无论如何，本公司对用户承担的违约赔偿（如有）总额不超过向用户收取的服务费用总额。</li></ol><h4>六. 用户资料的使用与披露</h4><ol><li>用户在此同意，对于用户提供的和本公司为提供本网站服务所需而自行收集的用户个人信息和资料，本公司有权按照本服务协议的约定进行使用或者披露。</li><li><p>用户授权本公司基于履行有关协议、解决争议、调停纠纷、保障本网站用户交易安全的目的等使用用户的个人资料（包括
但不限于用户自行提供的以及本公司信审行为所获取的其他资料）。本公司有权调查多个用户以识别问题或解决争议， 
特别是本公司可审查用户的资料以区分使用多个用户名或别名的用户。</p><p>为避免用户通过本网站从事欺诈、非法或其他刑事犯罪活动，保护本网站及其正常用户合法权益，用户授权本公司可通过人工或自动程序对用户的个人资料进行评价和衡量。</p><p>用户同意本公司可以使用用户的个人资料以改进本网站的推广和促销工作、分析网站的使用率、改善本网站的内容和产品
推广形式，并使本网站内容、设计和服务更能符合用户的要求。这些使用能改善本网站的网页，以调整本网站网页使其更能符合用户的需求，从而使用户在使用本网
站服务时得到更为顺利、有效、安全及度身订造的交易体验。</p><p>用户在此同意允许本公司通过在本网站的某些网页上使用诸如"Cookies"的设置收集用户信息并进行分析研究，以为用户提供更好的量身服务。</p></li><li><p>本公司有义务根据有关法律、法规、规章及其他政府规范性文件的要求向司法机关和政府部门提供用户的个人资料及交易信息。</p><p>在用户未能按照与本公司签订的包括但不限于本服务协议或者与本网站其他用户签订的借款协议等其他法律文本的约定履
行自己应尽的义务时，本公司有权将用户提供的及本公司自行收集的用户的个人信息、违约事实等通过网络、报刊、电视等方式对任何第三方披露，且本公司有权将
用户提交或本公司自行收集的用户的个人资料和信息与任何第三方进行数据共享，以便对用户的其他申请进行审核等使用。由此而造成用户损失的，本公司不承担法
律责任。</p></li><li>本公司采用行业标准惯例以保护用户的个人信息和资料，鉴于技术限制，本公司不能确保用户的全部私人通讯及其他个人资料不会通过本条款中未列明的途径泄露出去。</li></ol><h4>七. 知识产权保护条款</h4><ol><li>本网站中的所有内容均属于本公司所有,包括但不限于文本、数据、文章、设计、源代码、软件、图片、照片、音频、视频及其他全部信息。本网站内容受中国知识产权法律法规及各国际版权公约的保护。</li><li>未经本公司事先书面同意,用户承诺不以任何形式复制、模仿、传播、出版、公布、展示本网站内容,包括但不限于电子的、机械的、复印的、录音录像的方式和形式等。用户承认本网站内容是属于本公司的财产。</li><li>未经本公司书面同意,用户不得将本网站包含的资料等任何内容发布到任何其他网站或者服务器。任何未经授权对本网站内容的使用均属于违法行为,本公司有权追究用户的法律责任。</li></ol><h4>八. 违约责任</h4><p>如一方发生违约行为，守约方可以书面通知方式要求违约方在指定的时限内停止违约行为，并就违约行为造成的损失要求违约方进行赔偿。</p><h4>九. 法律适用及争议解决</h4><ol><li>本服务协议的签订、效力、履行、终止、解释和争端解决受中国法律法规的管辖。</li><li>因本服务协议发生任何争议或与本服务协议有关的争议，首先应由双方友好协商解决，协商不成的，任何一方有权将纠纷提交至本公司所在地有管辖权的人民法院诉讼解决。</li></ol><h4>十. 其他条款</h4><ol><li>本服务协议自您同意勾选并成功注册为本网站用户之日起生效，除非本网站终止本服务协议或者用户丧失本网站用户资格，否则本服务协议始终有效。本服务协议终止并不免除用户根据本服务协议或其他有关协议、规则所应承担的义务和责任。</li><li>本公司对于用户的违约行为放弃行使本服务协议规定的权利的，不得视为其对用户的其他违约行为放弃主张本服务协议项下的权利。</li><li>本服务协议部分条款被认定为无效时，不影响本服务协议其他条款的效力。</li><li>本服务协议不涉及用户与本网站其他用户之间因网上交易而产生的法律关系及法律纠纷，但用户在此同意将全面接受和履行与本网站其他用户通过本网站签订的任何电子法律文本，并承诺按该法律文本享有和/或放弃相应的权利、承担和/或豁免相应的义务。</li><li>本公司对本服务协议享有最终的解释权。</li></ol></div><div class="modal-footer"><button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">确认</button></div></div><script language="JavaScript">	function changeVerify(){
		var timenow = new Date().getTime();
		document.getElementById('verifyImg').src='__APP__/Public/verify/'+timenow;
	}
</script><script src="__PUBLIC__/jquery/Validform_v5.3.2min.js"></script><script language="JavaScript"> $(function(){
	//$(".form-horizontal").Validform();  //就这一行代码！;

	$("#myform").Validform({
		datatype:{
			"me" : /^[\u4E00-\u9FA5\uf900-\ufa2d\w]{2,16}$/,
		}
	});
})
</script><script type="text/javascript">//获取验证码倒计时
var wait=60;
function time(o) {
		if (wait == 0) {
			o.removeAttribute("disabled");			
			o.value="免费获取验证码";
			wait = 60;
		} else {
			o.setAttribute("disabled", true);
			o.value="重新发送(" + wait + ")";
			wait--;
			setTimeout(function() {
				time(o)
			},
			1000)
		}
	}
$(function(){
	$('#btn').click( function () { 
		var phone=$('#phone').val();
		var myreg = /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/;
		 if(!myreg.test(phone))
        {
            alert('请输入有效的手机号码！');
            return false;
        }
		time(this); 
		//$.post("__URL__/cellpcode", {id:1} );
		$('#abc').load("__URL__/reMessage", {phone:phone} );
	});
});
</script></div><!-- Footer
    ================================================== --><div class="sup-footer" role="menu"><!--Container start--><div class="container"><!--Row start--><div class="row-fluid"><!--Contact start--><div class="span6"><h3>联系我们</h3><ul class="unstyled"><li><i class="icon icon-darkgray icon-bookmark"></i>&nbsp;&nbsp;<?php echo ($s["sys_officeAddress"]); ?></li><li><i class="icon icon-darkgray icon-cellphone"></i>&nbsp;&nbsp;<?php echo ($s["sys_phone"]); ?></li><li><i class="icon icon-darkgray icon-print"></i>&nbsp;&nbsp;<?php echo ($s["sys_fax"]); ?></li><li><i class="icon icon-darkgray icon-envelope-closed"></i>&nbsp;&nbsp;<?php echo ($s["sys_email"]); ?></li></ul></div><!--Contact end--><!--Guide start--><div class="span3 visible-desktop"><h3>关于我们</h3><ul class="unstyled"><li><a href="__ROOT__/Site/page/id/1.html">关于我们</a></li><li><a href="__ROOT__/Site/listTpl/id/16.html">新闻中心</a></li><li><a href="__ROOT__/Site/page/id/21.html">联系我们</a></li></ul></div><!--Guide end--><!--Law start--><div class="span3 visible-desktop"><h3>新手指南</h3><ul class="unstyled"><li><a href="__ROOT__/Site/listTpl/id/28.html">名词解释</a></li><li><a href="__ROOT__/Site/page/id/29.html">收费规则</a></li><li><a href="__ROOT__/Site/listTpl/id/31.html">帮助中心</a></li></ul></div><!--Law end--></div><!--Row end--><hr class="dashed visible-desktop"><div class="row-fluid visible-desktop"><!--Follow start--><div class="span12"><ul class="inline widget-list"><li><a title="" data-original-title="" class="no-link qqgroup fwidget" id="qqgroup-popover" href="javascript:void(0)" data-toggle="popover" data-placement="top"><span class="social-qq-pure"></span><span class="widget-text">投资理财群</span></a></li><li><a href="javascript:void(0)" target="_blank" class="weibo fwidget"><span class="social-weibo-pure"></span><span class="widget-text"><?php echo ($s["sys_briefTitle"]); ?>微博</span></a></li><li><a title="" data-original-title="" class="no-link wechat fwidget" id="wechat-popover" data-toggle="popover" data-placement="top"><span class="social-wechat-pure"></span><span class="widget-text"><?php echo ($s["sys_briefTitle"]); ?>微信</span></a></li><li><a class="calculator no-link fwidget" href="__ROOT__/Index/counter.html" id="act_cal"><span class="social-calc-pure"></span><span class="widget-text">理财计算器</span></a></li></ul></div><!--Follow end--></div><div class="row-fluid favlink"><div class="span12"><p><b>友情链接：</b><?php if(is_array($links)): $i = 0; $__LIST__ = $links;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ls): $mod = ($i % 2 );++$i;?><span class="links_fg"><a target="_blank" href="<?php echo ($ls["url"]); ?>"><?php echo ($ls["title"]); ?></a></span><?php endforeach; endif; else: echo "" ;endif; ?></p></div></div><div class="copyright pull-left"><?php echo ($s["sys_copy"]); ?></div></div><!--Container  end--></div><!--Footer end--><div class="online-service hidden-phone"><a class="online-service-title" href="http://wpa.qq.com/msgrd?v=3&uin=2224054248&site=qq&menu=yes" target="_blank"><div class="social-qq-pure"></div><h4 style="">在线客服</h4></a></div><!--Calculator start--><?php echo ($ajax_list); ?><!-- external javascript
	================================================== --><!-- jQuery UI --><!-- 首页宽屏轮播--><!--[if lte IE 6]><script type="text/javascript" src="__PUBLIC__/bootstrap/js/bootstrap-ie.js"></script><![endif]--><!-- bootstrap--><script src="__PUBLIC__/bootstrap/js/bootstrap.min.js"></script><script src="__PUBLIC__/bootstrap/js/jquery.dataTables.min.js"></script><script>	$(document).ready(function(){
		$.extend( $.fn.dataTableExt.oPagination, {
			"bootstrap": {
				"fnInit": function( oSettings, nPaging, fnDraw ) {
					var oLang = oSettings.oLanguage.oPaginate;
					var fnClickHandler = function ( e ) {
						e.preventDefault();
						if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
							fnDraw( oSettings );
						}
					};
		
					$(nPaging).addClass('pagination').append(
						'<ul>'+
							'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
							'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
						'</ul>'
					);
					var els = $('a', nPaging);
					$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
					$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
				},
		
				"fnUpdate": function ( oSettings, fnDraw ) {
					var iListLength = 5;
					var oPaging = oSettings.oInstance.fnPagingInfo();
					var an = oSettings.aanFeatures.p;
					var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);
		
					if ( oPaging.iTotalPages < iListLength) {
						iStart = 1;
						iEnd = oPaging.iTotalPages;
					}
					else if ( oPaging.iPage <= iHalf ) {
						iStart = 1;
						iEnd = iListLength;
					} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
						iStart = oPaging.iTotalPages - iListLength + 1;
						iEnd = oPaging.iTotalPages;
					} else {
						iStart = oPaging.iPage - iHalf + 1;
						iEnd = iStart + iListLength - 1;
					}
		
					for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
						// remove the middle elements
						$('li:gt(0)', an[i]).filter(':not(:last)').remove();
		
						// add the new list items and their event handlers
						for ( j=iStart ; j<=iEnd ; j++ ) {
							sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
							$('<li '+sClass+'><a href="#">'+j+'</a></li>')
								.insertBefore( $('li:last', an[i])[0] )
								.bind('click', function (e) {
									e.preventDefault();
									oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
									fnDraw( oSettings );
								} );
						}
		
						// add / remove disabled classes from the static elements
						if ( oPaging.iPage === 0 ) {
							$('li:first', an[i]).addClass('disabled');
						} else {
							$('li:first', an[i]).removeClass('disabled');
						}
		
						if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
							$('li:last', an[i]).addClass('disabled');
						} else {
							$('li:last', an[i]).removeClass('disabled');
						}
					}
				}
			}
		});
     //datatable
	var datasort=$('#datasort').val()?$('#datasort').val():0;//排序根据哪列
	var dataasc=$('#dataasc').val()?"asc":"desc";//排序条件
	$('.datatable').dataTable({
			"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
			"sPaginationType": "bootstrap",
			"aaSorting": [[ datasort, dataasc ]],
			"oLanguage": {
			"sLengthMenu": "_MENU_ 每页显示数"
			}
		} );
	
});
</script><script>$(document).ready(function () {
            
            $("#wechat-popover").popover({
                html: true,
                content: "<p style='white-space:nowrap'>扫码关注<?php echo ($s["sys_briefTitle"]); ?>微信</p><div style='width:120px;height:120px;margin-left:5px;'><img src='__PUBLIC__/img/erb.jpg' style='width:120px;height:120px;'></div>",
                trigger: "hover"
            });

        $("#qqgroup-popover").popover({
            html: true,
            content: "<p style='white-space:nowrap'><?php echo ($s["sys_briefTitle"]); ?>投资理财群 : </p><p style='white-space:nowrap'>群：<a target='_blank' href='http://shang.qq.com/wpa/qunwpa?idkey=bd41e8df34767e61c882d9599becec595fb5e51476c50470c9c5f26df5ef5f2f'><img border='0' src='http://pub.idqqimg.com/wpa/images/group.png' alt='天贷-投资理财群' title='天贷-投资理财群'></a></b></p><p>申请加入投资理财群时<br />请提供<?php echo ($s["sys_briefTitle"]); ?>用户名</p>",
            trigger: "click"
        });

            //disable pager invalid link
            $('.pagination a[href^=#]').on('click', function (e) {
                e.preventDefault();
            });
            $('a.no-link[href^=#]').on('click', function (e) {
                e.preventDefault();
            });
        })	

<?php echo ($endjs); ?>//计划任务
window.onload = Schedule();
function Schedule(){
$.post("__ROOT__/Api/Autos/timing", {id:1} );

}
$('a[href="#"][data-top!=true]').click(function(e){
		e.preventDefault();
	});
</script></body></html><!--底部 end-->