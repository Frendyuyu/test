<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div class="pager">
 <ul>
  <!-- {if $pager.page neq '1'} -->
  <li><a href="{$pager.first}"><i class="fa fa-angle-double-left"></i></a></li>
  <li><a href="{$pager.previous}"><i class="fa fa-angle-left"></i></a></li>
  <!-- {/if} -->
  <!-- {foreach from=$pager.box item=box} -->
  <li{if $box.cur} class="active"{/if}><a href="{$box.url}">{$box.page}</a></li>
  <!-- {/foreach} -->
  <!-- {if $pager.page neq $pager.page_count} -->
  <li><a href="{$pager.next}"><i class="fa fa-angle-right"></i></a></li>
  <li><a href="{$pager.last}"><i class="fa fa-angle-double-right"></i></a></li>
  <!-- {/if} -->
 </ul>
</div>