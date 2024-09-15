<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div class="product-list">
 <div class="container">
  <div class="row"> 
   <!-- {foreach from=$recommend_product name=recommend_product item=product} -->
   <div class="col-md-3 col-6">
    <div class="item">
     <div class="img scale"><a href="{$product.url}"><img src="{$product.thumb}" /></a></div>
     <div class="name"><a href="{$product.url}">{$product.name}</a></div>
     <!-- {if $site.show_price} -->
     <div class="price"><!-- {if $product.level_price} -->{$product.level_price}<em class="price-line">{$product.price}</em><!-- {else} -->{$product.price}<!-- {/if} --></div>
     <!-- {/if} -->
    </div>
   </div>
   <!-- {/foreach} --> 
  </div>
 </div>
</div>