<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div id="footer">
 <a href="javascript:;" onfocus="this.blur();" class="goTop">{$lang.go_top}</a>
 <ul>
  <li class="footNav"><!-- {if $open.user} --><!-- {if $global_user} --><a href="{$url.user}">{$global_user.user_name}，{$lang.user_welcom_top}</a><a href="{$url.logout}">{$lang.user_logout}</a><!-- {else} --><a href="{$url.login}">{$lang.user_login_nav}</a><s></s><a href="{$url.register}">{$lang.user_register_nav}</a><!-- {/if} --><!-- {/if} --><a href="{$site.m_url}">{$lang.dou_mobile}</a><a href="{$site.root_url}?mobile">{$lang.dou_pc}</a></li>
  <li class="copyRight">{$lang.copyright}</li>
  <li class="powered">{$lang.powered_by} <!-- {if $site.icp} --><a href="https://beian.miit.gov.cn/" target="_blank">{$site.icp}</a><!-- {/if} --></li>
  <!-- {if $site.net_safe_record} -->
  <li><a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode={$site.net_safe_record_number}" class="netSafeRecord" target="_blank"><img src="../images/icon_net_safe_record.png" />{$site.net_safe_record}</a></li>
  <!-- {/if} -->
 </ul>
</div>
<!-- {if $site.code} -->
<div style="display:none">{$site.code}</div>
<!-- {/if} -->