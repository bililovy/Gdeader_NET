<?php if (!defined('THINK_PATH')) exit(); if($cartlist): ?><li class="begin"><p>Recently Added Items (<?php echo ($count); ?>)</p></li>
<?php if(is_array($cartlist)): foreach($cartlist as $key=>$goods): ?><li class="goods">
	<div class="img fl"><a href="<?php echo U('Goods/detail', array('gid'=>$goods['id']));?>" title="<?php echo ($goods["goodsname"]); ?>" ><img src="<?php echo ($goods["goodsimg"]); ?>" alt="<?php echo ($goods["goodsname"]); ?>" /></a></div>
	<div class="ginfo fl">
		<p class="gname"><a href="<?php echo U('Goods/detail', array('gid'=>$goods['id']));?>" title="goods name" ><?php echo ($goods["goodsname"]); ?></a></p>
		<p class="price">$<?php echo ($goods["price"]); ?></p>
	</div>
	<div class="operator fr"><a href="<?php if(empty($goods["goodslink"])): echo U('Goods/detail', array('gid'=>$goods['id'])); else: echo ($goods["goodslink"]); endif; ?>" class="buy_btn" title="Buy Now"><i class="fa fa-shopping-cart"></i></a></div>
</li><?php endforeach; endif; ?>	  					
<li class="end">
<a href="<?php echo U('Goods/wishlist');?>"  class="fl" title="check cart">check out</a>
<span class="cartsum fr">Total: <b>$<?php echo ($totalPrice); ?></b>  </span>
</li>
<?php else: ?>
	<li class="goods" style="line-height: 35px; padding:10px 15px;border: none; text-align: center;color: #1593A0;font-size: 1.3em;">Wishlist Empty !</li><?php endif; ?>