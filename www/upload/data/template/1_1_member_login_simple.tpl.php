<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); if(CURMODULE != 'logging') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>logging.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<form method="post" autocomplete="off" id="lsform" action="member.php?mod=logging&amp;action=login&amp;loginsubmit=yes&amp;infloat=yes&amp;lssubmit=yes" onsubmit="return lsSubmit();">
<div class="fastlg cl">
<span id="return_ls" style="display:none"></span>
<div class="y pns">
<table cellspacing="0" cellpadding="0">
<tr>
<?php if(!$_G['setting']['autoidselect']) { ?>
<td>
<span class="ftid">
<select name="fastloginfield" id="ls_fastloginfield" width="40">
<option value="username">用户名</option>
<?php if(getglobal('setting/uidlogin')) { ?>
<option value="uid">UID</option>
<?php } ?>
<option value="email">Email</option>
<?php if(getglobal('setting/secmobilelogin')) { ?>
<option value="secmobile">安全手机号</option>
<?php } ?>
</select>
</span>
<script type="text/javascript">simulateSelect('ls_fastloginfield')</script>
</td>
<td><input type="text" name="username" id="ls_username" autocomplete="off" class="px vm" /></td>
<?php } else { ?>
<td><label for="ls_username">账号</label></td>
<td><input type="text" name="username" id="ls_username" class="px vm xg1" <?php if($_G['setting']['autoidselect']) { ?> value="<?php if(getglobal('setting/uidlogin')) { ?>UID/<?php } ?>用户名/Email" onfocus="if(this.value == '<?php if(getglobal('setting/uidlogin')) { ?>UID/<?php } if(getglobal('setting/secmobilelogin')) { ?>安全手机号/<?php } ?>用户名/Email'){this.value = '';this.className = 'px vm';}" onblur="if(this.value == ''){this.value = '<?php if(getglobal('setting/uidlogin')) { ?>UID/<?php } if(getglobal('setting/secmobilelogin')) { ?>安全手机号/<?php } ?>用户名/Email';this.className = 'px vm xg1';}"<?php } ?> /></td>
<?php } ?>
<td class="fastlg_l"><label for="ls_cookietime"><input type="checkbox" name="cookietime" id="ls_cookietime" class="pc" value="2592000" />自动登录</label></td>
<td>&nbsp;<a href="javascript:;" onclick="showWindow('login', 'member.php?mod=logging&action=login&viewlostpw=1')">找回密码</a></td>
</tr>
<tr>
<td><label for="ls_password"<?php if(!$_G['setting']['autoidselect']) { ?> class="z psw_w"<?php } ?>>密码</label></td>
<td><input type="password" name="password" id="ls_password" class="px vm" autocomplete="off" /></td>
<td class="fastlg_l"><button type="submit" class="pn vm" style="width: 75px;"><em>登录</em></button></td>
<td>&nbsp;<a href="member.php?mod=<?php echo $_G['setting']['regname'];?>" class="xi2 xw1"><?php echo $_G['setting']['reglinkname'];?></a></td>
</tr>
</table>
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
<input type="hidden" name="quickforward" value="yes" />
<input type="hidden" name="handlekey" value="ls" />
</div>
<?php if(!empty($_G['setting']['pluginhooks']['global_login_extra'])) echo $_G['setting']['pluginhooks']['global_login_extra'];?>
</div>
</form>
<?php } ?>