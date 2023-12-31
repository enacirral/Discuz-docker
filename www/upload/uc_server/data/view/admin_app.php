<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<?php include $this->gettpl('header');?>

<script src="js/common.js" type="text/javascript"></script>
<script type="text/javascript">
var apps = new Array();
var run = 0;
function testlink() {
	if(apps[run]) {
		$('status_' + apps[run]).innerHTML = '正在连接...';
		$('link_' + apps[run]).src = $('link_' + apps[run]).getAttribute('testlink') + '&sid=<?php echo $sid;?>';
	}
	run++;
}
function generatekey() {
	var scriptNode = document.createElement('script');
	scriptNode.type = 'text/javascript';
	scriptNode.src = '<?php echo UC_ADMINSCRIPT;?>?m=app&a=generatekey&inajax=1&sid=<?php echo $sid;?>';
	document.getElementsByTagName('head')[0].appendChild(scriptNode);
}
window.onload = testlink;
</script>
<div class="container">
	<?php if($a == 'ls') { ?>
		<h3 class="marginbot">应用列表<a href="<?php echo UC_ADMINSCRIPT;?>?m=app&a=add" class="sgbtn">添加新应用</a></h3>
		<?php if(!$status) { ?>
			<div class="note fixwidthdec">
				<p class="i">如果出现“通信失败”，请点击“编辑”尝试设置应用域名对应的 IP。</p>
			</div>
		<?php } elseif($status == '2') { ?>
			<div class="correctmsg"><p>应用列表成功更新。</p></div>
		<?php } ?>
		<div class="mainbox">
			<?php if($applist) { ?>
				<form action="<?php echo UC_ADMINSCRIPT;?>?m=app&a=ls" method="post">
					<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
					<table class="datalist fixwidth" onmouseover="addMouseEvent(this);">
						<tr>
							<th nowrap="nowrap"><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">删除</label></th>
							<th nowrap="nowrap">ID</th>
							<th nowrap="nowrap">应用名称</th>
							<th nowrap="nowrap">应用的主 URL</th>
							<th nowrap="nowrap">通信情况</th>
							<th nowrap="nowrap">详情</th>
						</tr>
						<?php $i = 0;?>
						<?php foreach((array)$applist as $app) {?>
							<tr>
								<td width="50"><input type="checkbox" name="delete[]" value="<?php echo $app['appid'];?>" class="checkbox" /></td>
								<td width="35"><?php echo $app['appid'];?></td>
								<td><a href="<?php echo UC_ADMINSCRIPT;?>?m=app&a=detail&appid=<?php echo $app['appid'];?>"><strong><?php echo $app['name'];?></strong></a></td>
								<td><a href="<?php echo $app['url'];?>" target="_blank"><?php echo $app['url'];?></a></td>
								<td width="90"><div id="status_<?php echo $app['appid'];?>"></div><script id="link_<?php echo $app['appid'];?>" testlink="<?php echo UC_ADMINSCRIPT;?>?m=app&a=ping&inajax=1&url=<?php echo urlencode($app['url']);?>&ip=<?php echo urlencode($app['ip']);?>&appid=<?php echo $app['appid'];?>&random=<?php echo rand()?>"></script><script>apps[<?php echo $i;?>] = '<?php echo $app['appid'];?>';</script></td>
								<td width="40"><a href="<?php echo UC_ADMINSCRIPT;?>?m=app&a=detail&appid=<?php echo $app['appid'];?>">编辑</a></td>
							</tr>
							<?php $i++?>
						<?php } ?>
						<tr class="nobg">
							<td colspan="9"><input type="submit" value="提 交" class="btn" /></td>
						</tr>
					</table>
					<div class="margintop"></div>
				</form>
			<?php } else { ?>
				<div class="note">
					<p class="i">目前没有相关记录!</p>
				</div>
			<?php } ?>
		</div>
	<?php } elseif($a == 'add') { ?>
		<h3 class="marginbot">添加新应用<a href="<?php echo UC_ADMINSCRIPT;?>?m=app&a=ls" class="sgbtn">返回应用列表</a></h3>
		<div class="note"><p>不能通过 URL 添加应用的可能原因：1. 通过 URL 添加应用开关被关闭；2. 连续多次错误输入 UCenter 创始人密码</p></div>
		<div class="mainbox">
			<table class="opt">
				<tr>
					<th>选择安装方式:</th>
				</tr>
				<tr>
					<td>
						<input type="radio" name="installtype" class="radio" checked="checked" onclick="$('url').style.display='none';$('custom').style.display='';" />自定义安装
						<input type="radio" name="installtype" class="radio" onclick="$('url').style.display='';$('custom').style.display='none';" />URL 安装 (推荐)
					</td>
				</tr>
			</table>
			<div id="url" style="display:none;">
				<form method="post" action="" target="_blank" onsubmit="document.appform.action=document.appform.appurl.value;" name="appform">
					<table class="opt">
						<tr>
							<th>应用程序安装地址:</th>
						</tr>
						<tr>
							<td><input type="text" name="appurl" size="50" value="http://domainname/install/index.php" style="width:300px;" /></td>
						</tr>
					</table>
					<div class="opt">
						<input type="hidden" name="ucapi" value="<?php echo UC_API;?>" />
						<input type="hidden" name="ucfounderpw" value="<?php echo $md5ucfounderpw;?>" />
						<input type="submit" name="installsubmit"  value=" 安 装 " class="btn" />
					</div>
				</form>
			</div>
			<div id="custom">
				<form action="<?php echo UC_ADMINSCRIPT;?>?m=app&a=add" method="post">
				<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
					<table class="opt">
						<tr>
							<th colspan="2">应用类型:</th>
						</tr>
						<tr>
							<td>
							<select name="type">
								<?php foreach((array)$typelist as $typeid => $typename) {?>
									<option value="<?php echo $typeid;?>"> <?php echo $typename;?> </option>
								<?php }?>
							</select>
							</td>
							<td></td>
						</tr>
						<tr>
							<th colspan="2">应用名称:</th>
						</tr>
						<tr>
							<td><input type="text" class="txt" name="name" value="" /></td>
							<td>限 20 字节。</td>
						</tr>
						<tr>
							<th colspan="2">应用的主 URL:</th>
						</tr>
						<tr>
							<td><input type="text" class="txt" name="url" value="" /></td>
							<td>该应用与 UCenter 通信的接口 URL，结尾请不要加“/” ，应用的通知只发送给主 URL</td>
						</tr>
						<tr>
							<th colspan="2">应用 IP:</th>
						</tr>
						<tr>
							<td><input type="text" class="txt" name="ip" value="" /></td>
							<td>正常情况下留空即可。如果由于域名解析问题导致 UCenter 与该应用通信失败，请尝试设置为该应用所在服务器的 IP 地址。</td>
						</tr>
						<tr>
							<th colspan="2">通信密钥:</th>
						</tr>
						<tr>
							<td><input type="text" class="txt" name="authkey" value="" /></td>
							<td>只允许使用英文字母及数字，限 64 字节。应用端的通信密钥必须与此设置保持一致，否则该应用将无法与 UCenter 正常通信。 <a href="#" onclick="generatekey();return false;" class="green">生成安全通信密钥</a></td>
						</tr>


						<tr>
							<th colspan="2">应用的物理路径:</th>
						</tr>
						<tr>
							<td>
								<input type="text" class="txt" name="apppath" value="" />
							</td>
							<td>默认请留空，如果填写的为相对路径（相对于UC），程序会自动转换为绝对路径，如 ../</td>
						</tr>
						<tr>
							<th colspan="2">查看个人资料页面地址:</th>
						</tr>
						<tr>
							<td>
								<input type="text" class="txt" name="viewprourl" value="" />
							</td>
							<td>URL中域名后面的部分，如：/space.php?uid=%s 这里的 %s 代表uid</td>
						</tr>
						<tr>
							<th colspan="2">应用接口文件名称:</th>
						</tr>
						<tr>
							<td>
								<input type="text" class="txt" name="apifilename" value="uc.php" />
							</td>
							<td>应用接口文件名称，不含路径，默认为uc.php</td>
						</tr>
						<tr>
							<th colspan="2">标签单条显示模板:</th>
						</tr>
						<tr>
							<td><textarea class="area" name="tagtemplates"></textarea></td>
							<td valign="top">当前应用的标签数据显示在其它应用时的单条数据模板。</td>
						</tr>

						<tr>
							<th colspan="2">标签模板标记说明:</th>
						</tr>
						<tr>
							<td><textarea class="area" name="tagfields"><?php echo $tagtemplates['fields'];?></textarea></td>
							<td valign="top">一行一个标记说明条目，用逗号分割标记和说明文字。如：<br />subject,主题标题<br />url,主题地址</td>
						</tr>
						<tr>
							<th colspan="2">是否开启同步登录:</th>
						</tr>
						<tr>
							<td>
								<input type="radio" class="radio" id="synlogin_yes" name="synlogin" value="1" /><label for="synlogin_yes">是</label>
								<input type="radio" class="radio" id="synlogin_no" name="synlogin" value="0" checked="checked" /><label for="synlogin_no">否</label>
							</td>
							<td>开启同步登录后，当用户在登录其他应用时，同时也会登录该应用。</td>
						</tr>
						<tr>
							<th colspan="2">是否接受通知:</th>
						</tr>
						<tr>
							<td>
								<input type="radio" class="radio" id="recvnote_yes" name="recvnote" value="1"/><label for="recvnote_yes">是</label>
								<input type="radio" class="radio" id="recvnote_no" name="recvnote" value="0" checked="checked" /><label for="recvnote_no">否</label>
							</td>
							<td></td>
						</tr>
					</table>
					<div class="opt"><input type="submit" name="submit" value=" 提 交 " class="btn" /></div>
				</form>
			</div>
		</div>
	<?php } else { ?>
		<h3 class="marginbot">编辑应用<a href="<?php echo UC_ADMINSCRIPT;?>?m=app&a=ls" class="sgbtn">返回应用列表</a></h3>
		<?php if($updated) { ?>
			<div class="correctmsg"><p>更新成功。</p></div>
		<?php } elseif($addapp) { ?>
			<div class="correctmsg"><p>成功添加应用。</p></div>
		<?php } ?>
		<div class="mainbox">
			<form action="<?php echo UC_ADMINSCRIPT;?>?m=app&a=detail&appid=<?php echo $appid;?>" method="post">
			<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
				<table class="opt">
					<tr>
						<th colspan="2">ID: <?php echo $appid;?></th>
					</tr>
					<tr>
						<th colspan="2">应用类型:</th>
					</tr>
					<tr>
						<td>
						<select name="type">
							<?php foreach((array)$typelist as $typeid => $typename) {?>
							<option value="<?php echo $typeid;?>" <?php if($typeid == $type) { ?>selected="selected"<?php } ?>> <?php echo $typename;?> </option>
							<?php }?>
						</select>
						</td>
						<td></td>
					</tr>

					<tr>
						<th colspan="2">应用名称:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="name" value="<?php echo $name;?>" /></td>
						<td>限 20 字节。</td>
					</tr>
					<tr>
						<th colspan="2">应用的主 URL:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="url" value="<?php echo $url;?>" /></td>
						<td>该应用与 UCenter 通信的接口 URL，结尾请不要加“/” ，应用的通知只发送给主 URL</td>
					</tr>
					<tr>
						<th colspan="2">应用的其他 URL:</th>
					</tr>
					<tr>
						<td><textarea name="extraurl" class="area"><?php echo $extraurl;?></textarea></td>
						<td>该应用可以访问的其他 URL，结尾请不要加“/” ，每行一个，只有在同步登录时请求该 URL</td>
					</tr>
					<tr>
						<th colspan="2">应用 IP:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="ip" value="<?php echo $ip;?>" /></td>
						<td>正常情况下留空即可。如果由于域名解析问题导致 UCenter 与该应用通信失败，请尝试设置为该应用所在服务器的 IP 地址。</td>
					</tr>
					<tr>
						<th colspan="2">通信密钥:</th>
					</tr>
					<tr>
						<td><input type="text" class="txt" name="authkey" value="<?php echo $authkey;?>" /></td>
						<td>只允许使用英文字母及数字，限 64 字节。应用端的通信密钥必须与此设置保持一致，否则该应用将无法与 UCenter 正常通信。 <a href="#" onclick="generatekey();return false;" class="green">生成安全通信密钥</a></td>
					</tr>

					<tr>
						<th colspan="2">应用的物理路径:</th>
					</tr>
					<tr>
						<td>
							<input type="text" class="txt" name="apppath" value="<?php echo $apppath;?>" />
						</td>
						<td>默认请留空，如果填写的为相对路径（相对于UC），程序会自动转换为绝对路径，如 ../</td>
					</tr>
					<tr>
						<th colspan="2">查看个人资料页面地址:</th>
					</tr>
					<tr>
						<td>
							<input type="text" class="txt" name="viewprourl" value="<?php echo $viewprourl;?>" />
						</td>
						<td>URL中域名后面的部分，如：/space.php?uid=%s 这里的 %s 代表uid</td>
					</tr>
					<tr>
						<th colspan="2">应用接口文件名称:</th>
					</tr>
					<tr>
						<td>
							<input type="text" class="txt" name="apifilename" value="<?php echo $apifilename;?>" />
						</td>
						<td>应用接口文件名称，不含路径，默认为uc.php</td>
					</tr>

					<tr>
						<th colspan="2">标签单条显示模板:</th>
					</tr>
					<tr>
						<td><textarea class="area" name="tagtemplates"><?php echo $tagtemplates['template'];?></textarea></td>
						<td valign="top">当前应用的标签数据显示在其它应用时的单条数据模板。</td>
					</tr>
					<tr>
						<th colspan="2">标签模板标记说明:</th>
					</tr>
					<tr>
						<td><textarea class="area" name="tagfields"><?php echo $tagtemplates['fields'];?></textarea></td>
						<td valign="top">一行一个标记说明条目，用逗号分割标记和说明文字。如：<br />subject,主题标题<br />url,主题地址</td>
					</tr>
					<tr>
						<th colspan="2">是否开启同步登录:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="synlogin_yes" name="synlogin" value="1" <?php echo $synlogin[1];?> /><label for="synlogin_yes">是</label>
							<input type="radio" class="radio" id="synlogin_no" name="synlogin" value="0" <?php echo $synlogin[0];?> /><label for="synlogin_no">否</label>
						</td>
						<td>开启同步登录后，当用户在登录其他应用时，同时也会登录该应用。</td>
					</tr>
					<tr>
						<th colspan="2">是否接受通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="recvnote_yes" name="recvnote" value="1" <?php echo $recvnotechecked[1];?> /><label for="recvnote_yes">是</label>
							<input type="radio" class="radio" id="recvnote_no" name="recvnote" value="0" <?php echo $recvnotechecked[0];?> /><label for="recvnote_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否需要自定义通知类别:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="recvnotediy_yes" name="recvnotediy" value="1" /><label for="recvnotediy_yes">是</label>
							<input type="radio" class="radio" id="recvnotediy_no" name="recvnotediy" value="0" /><label for="recvnotediy_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受用户删除通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_deleteuser_yes" name="disablenote_deleteuser" value="1" /><label for="disablenote_deleteuser_yes">是</label>
							<input type="radio" class="radio" id="disablenote_deleteuser_no" name="disablenote_deleteuser" value="0" /><label for="disablenote_deleteuser_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受用户改名通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_renameuser_yes" name="disablenote_renameuser" value="1" /><label for="disablenote_renameuser_yes">是</label>
							<input type="radio" class="radio" id="disablenote_renameuser_no" name="disablenote_renameuser" value="0" /><label for="disablenote_renameuser_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受获取标签通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_gettag_yes" name="disablenote_gettag" value="1" /><label for="disablenote_gettag_yes">是</label>
							<input type="radio" class="radio" id="disablenote_gettag_no" name="disablenote_gettag" value="0" /><label for="disablenote_gettag_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受更改用户密码通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_updatepw_yes" name="disablenote_updatepw" value="1" /><label for="disablenote_updatepw_yes">是</label>
							<input type="radio" class="radio" id="disablenote_updatepw_no" name="disablenote_updatepw" value="0" /><label for="disablenote_updatepw_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受更新关键字列表通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_updatebadwords_yes" name="disablenote_updatebadwords" value="1" /><label for="disablenote_updatebadwords_yes">是</label>
							<input type="radio" class="radio" id="disablenote_updatebadwords_no" name="disablenote_updatebadwords" value="0" /><label for="disablenote_updatebadwords_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受更新域名解析缓存通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_updatehosts_yes" name="disablenote_updatehosts" value="1" /><label for="disablenote_updatehosts_yes">是</label>
							<input type="radio" class="radio" id="disablenote_updatehosts_no" name="disablenote_updatehosts" value="0" /><label for="disablenote_updatehosts_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受更新应用列表通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_updateapps_yes" name="disablenote_updateapps" value="1" /><label for="disablenote_updateapps_yes">是</label>
							<input type="radio" class="radio" id="disablenote_updateapps_no" name="disablenote_updateapps" value="0" /><label for="disablenote_updateapps_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受更新客户端缓存通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_updateclient_yes" name="disablenote_updateclient" value="1" /><label for="disablenote_updateclient_yes">是</label>
							<input type="radio" class="radio" id="disablenote_updateclient_no" name="disablenote_updateclient" value="0" /><label for="disablenote_updateclient_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受更新用户积分通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_updatecredit_yes" name="disablenote_updatecredit" value="1" /><label for="disablenote_updatecredit_yes">是</label>
							<input type="radio" class="radio" id="disablenote_updatecredit_no" name="disablenote_updatecredit" value="0" /><label for="disablenote_updatecredit_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受获取用户的某项积分通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_getcredit_yes" name="disablenote_getcredit" value="1" /><label for="disablenote_getcredit_yes">是</label>
							<input type="radio" class="radio" id="disablenote_getcredit_no" name="disablenote_getcredit" value="0" /><label for="disablenote_getcredit_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受向 UCenter 提供积分设置通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_getcreditsettings_yes" name="disablenote_getcreditsettings" value="1" /><label for="disablenote_getcreditsettings_yes">是</label>
							<input type="radio" class="radio" id="disablenote_getcreditsettings_no" name="disablenote_getcreditsettings" value="0" /><label for="disablenote_getcreditsettings_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受更新应用积分设置通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_updatecreditsettings_yes" name="disablenote_updatecreditsettings" value="1" /><label for="disablenote_updatecreditsettings_yes">是</label>
							<input type="radio" class="radio" id="disablenote_updatecreditsettings_no" name="disablenote_updatecreditsettings" value="0" /><label for="disablenote_updatecreditsettings_no">否</label>
						</td>
						<td></td>
					</tr>
					<tr>
						<th colspan="2">是否接受添加事件通知:</th>
					</tr>
					<tr>
						<td>
							<input type="radio" class="radio" id="disablenote_addfeed_yes" name="disablenote_addfeed" value="1" /><label for="disablenote_addfeed_yes">是</label>
							<input type="radio" class="radio" id="disablenote_addfeed_no" name="disablenote_addfeed" value="0" /><label for="disablenote_addfeed_no">否</label>
						</td>
						<td></td>
					</tr>
				</table>
				<div class="opt"><input type="submit" name="submit" value=" 提 交 " class="btn" /></div>
<?php if($isfounder) { ?>
				<table class="opt">
					<tr>
						<th colspan="2">应用的 UCenter 配置信息:</th>
					</tr>
					<tr>
						<th>
<textarea class="area" onFocus="this.select()">
define('UC_CONNECT', 'mysql');
define('UC_STANDALONE', 0);
define('UC_DBHOST', '<?php echo UC_DBHOST;?>');
define('UC_DBUSER', '<?php echo UC_DBUSER;?>');
define('UC_DBPW', '<?php echo UC_DBPW;?>');
define('UC_DBNAME', '<?php echo UC_DBNAME;?>');
define('UC_DBCHARSET', '<?php echo UC_DBCHARSET;?>');
define('UC_DBTABLEPRE', '`<?php echo UC_DBNAME;?>`.<?php echo UC_DBTABLEPRE;?>');
define('UC_DBCONNECT', '0');
define('UC_AVTURL', '');
define('UC_AVTPATH', '');
define('UC_KEY', '<?php echo $authkey;?>');
define('UC_API', '<?php echo UC_API;?>');
define('UC_CHARSET', '<?php echo UC_CHARSET;?>');
define('UC_IP', '');
define('UC_APPID', '<?php echo $appid;?>');
define('UC_PPP', '20');
</textarea>
						</th>
						<td>当应用的 UCenter 配置信息丢失时可复制左侧的代码到应用的配置文件中</td>
					</tr>
				</table>
<?php } ?>
			</form>
		</div>
	<?php } ?>
</div>

<?php include $this->gettpl('footer');?>