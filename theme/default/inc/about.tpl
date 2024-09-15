<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div class="row about">
 <div class="col-md-4">
  <div class="img scale">
   <!-- {if $fragment.about.image} -->
   <img src="{$fragment.about.image}" />
   <!-- {else} -->
   <img src="../images/img_about.jpg" />
   <!-- {/if} -->
  </div>
 </div>
 <div class="col-md-8">
  <h2>{$about.page_name}</h2>
  <div class="desc">{$about.content|truncate:220:"..."}</div>
  <div class="more"><a href="{$about.link}">{$lang.about_link}</a></div>
 </div>
</div>