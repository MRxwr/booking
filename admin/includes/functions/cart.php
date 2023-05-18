<?php
// -- cart -- \\
function getCartId(){
	jump:
	$randomCart = rand("00000000","99999999");
	if( $cart = selectDB("cart", "`cartId` = '{$randomCart}'") ){
		goto jump;
	}else{
		return $randomCart;
	}
}

function getCartItemsTotal(){
	GLOBAL $_COOKIE,$cookieSession;
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDB("cart","`cartId` = '{$getCartId["cart"]}'") ){
		return sizeof($cart);
	}else{
		return 0;
	}
}

function getCartPrice(){
	GLOBAL $_COOKIE,$cookieSession;
	$extraPrice = [0];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDB("cart","`cartId` = '{$getCartId["cart"]}'") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$extras = json_decode($cart[$i]["extras"] ,true);
			$sale = checkProductDiscount($cart[$i]["subId"]);
			for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
				if ( !empty($extras["variant"][$y]) ){
					$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
					$extraPrice[] = $extraInfo[0]["price"] * $cart[$i]["quantity"];
				}
			}
			$totals[] = $sale * $cart[$i]["quantity"];
			$extraPrice = [0];
		}
	}
	if ( isset($totals) ){
		return numTo3Float(array_sum($totals)) . "KD";
	}else{
		return 0 . "KD";
	}
}

function getCartPriceTotal(){
	GLOBAL $_COOKIE,$cookieSession;
	$extraPrice = [0];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDB("cart","`cartId` = '{$getCartId["cart"]}'") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$extras = json_decode($cart[$i]["extras"] ,true);
			$sale = checkProductDiscount($cart[$i]["subId"]);
			for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
				if ( !empty($extras["variant"][$y]) ){
					$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
					$extraPrice[] = $extraInfo[0]["price"] * $cart[$i]["quantity"];
				}
			}
			$totals[] = $sale * $cart[$i]["quantity"] + array_sum($extraPrice);
			$extraPrice = [0];
		}
	}
	if ( isset($totals) ){
		return numTo3Float(array_sum($totals)) . "KD";
	}else{
		return 0 . "KD";
	}
}

function noDiscountCartPrice(){
	GLOBAL $_COOKIE,$cookieSession;
	$extraPrice = [0];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDB("cart","`cartId` = '{$getCartId["cart"]}'") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$extras = json_decode($cart[$i]["extras"] ,true);
			$price = selectDB("attributes_products","`id` = '{$cart[$i]["subId"]}'");
			$sale = $price[0]["price"];
			for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
				if ( !empty($extras["variant"][$y]) ){
					$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
					$extraPrice[] = $extraInfo[0]["price"] * $cart[$i]["quantity"];
				}
			}
			$totals[] = ($sale * $cart[$i]["quantity"]) + array_sum($extraPrice);
			$extraPrice = [0];
		}
	}
	if ( isset($totals) ){
		return numTo3Float(array_sum($totals)) . "KD";
	}else{
		return 0 . "KD";
	}
}

function noDiscountItemsPrice(){
	GLOBAL $_COOKIE,$cookieSession;
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDB("cart","`cartId` = '{$getCartId["cart"]}'") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$price = selectDB("attributes_products","`id` = '{$cart[$i]["subId"]}'");
			$totals[] = ($price[0]["price"] * $cart[$i]["quantity"]);
		}
	}
	if ( isset($totals) ){
		return numTo3Float(array_sum($totals)) . "KD";
	}else{
		return 0 . "KD";
	}
}

function getExtarsTotal(){
	GLOBAL $_COOKIE,$cookieSession;
	$extraPrice = [0];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDB("cart","`cartId` = '{$getCartId["cart"]}'") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$extras = json_decode($cart[$i]["extras"] ,true);
			for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
				if ( !empty($extras["variant"][$y]) ){
					$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
					$extraPrice[] = $extraInfo[0]["price"] * $cart[$i]["quantity"];
				}
			}
			$totals1[] = array_sum($extraPrice);
			$extraPrice = [0];
		}
	}
	if ( isset($totals1) ){
		return numTo3Float(array_sum($totals1)) . "KD";
	}else{
		return numTo3Float(0) . "KD";
	}
}

function loadCartItems(){
	GLOBAL $_COOKIE,$cookieSession;
	$output = "";
	$extraPrice = [0];
	$getCartId = json_decode($_COOKIE[$cookieSession."activity"],true);
	if ( $cart = selectDB("cart","`cartId` = '{$getCartId["cart"]}'") ){
		for ($i =0; $i < sizeof($cart); $i++){
			$product = selectDB("products","`id` = '{$cart[$i]["productId"]}'");
			$attribute = selectDB("attributes_products","`id` = '{$cart[$i]["subId"]}'");
			$sale = checkProductDiscount($cart[$i]["subId"]);
			if( $product[0]["discount"] != 0 ){
				$realPrice = "[<span style='text-decoration: line-through;'>".numTo3Float($attribute[0]["price"])."KD]</span>";
			}else{
				$realPrice = "";
			}
			$output .= "<div class='checkoutsidebar-item'>
				<span class='quantity'>{$cart[$i]["quantity"]}</span>
				<span class='multiplier'>x</span>
				<span class='iteminfo'>";
			$output .= direction($product[0]["enTitle"],$product[0]["arTitle"]);
			if( !empty(direction($attribute[0]["enTitle"],$attribute[0]["arTitle"])) ){
				$output .= " - " . direction($attribute[0]["enTitle"],$attribute[0]["arTitle"]);
			}
			$items = json_decode($cart[$i]["collections"],true);
			for( $y = 0; $y < sizeof($items) ; $y++ ){
				if ( !empty($items[$y]) ){
					$productsInfo = selectDB('products', "`id` = '{$items[$y]}'");
					$output .= "[ " . direction($productsInfo[0]["enTitle"],$productsInfo[0]["arTitle"]) . " ]";
				}
			}
			$extras = json_decode($cart[$i]["extras"],true);
			for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
				if ( !empty($extras["variant"][$y]) ){
					$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
					$output .= "[ " . direction($extraInfo[0]["enTitle"],$extraInfo[0]["arTitle"]) . ": {$extras["variant"][$y]} ".numTo3Float($extraInfo[0]['price'])."KD]";
					$extraPrice[] = $extraInfo[0]['price'];
				}
			}
			if ( !empty($cart[$i]["note"]) ){
				$output .= "[{$cart[$i]["note"]}]</span>";
			}
			$output .= "<span class='Price'> {$realPrice} " . numTo3Float($sale) ."KD </span></div>";
			$extraPrice = [0];
		}
	}
	return $output;
}

function loadItems($items){
	$output = "";
	$extraPrice = [0];
	$items = json_decode($items,true);
	for ($i =0; $i < sizeof($items); $i++){
		$product = selectDB("products","`id` = '{$items[$i]["productId"]}'");
		$attribute = selectDB("attributes_products","`id` = '{$items[$i]["subId"]}'");
		if( $items[$i]["priceAfterVoucher"] != 0 ){
			$sale = $items[$i]["priceAfterVoucher"];
		}elseif( $items[$i]["discountPrice"] != $items[$i]["price"]){
			$sale = $items[$i]["discountPrice"];
		}else{
			$sale = $items[$i]["price"];
		}
		$output .= "<div class='checkoutsidebar-item'>
			<span class='quantity'>{$items[$i]["quantity"]}</span>
			<span class='multiplier'>x</span>
			<span class='iteminfo'>";
		$output .= direction($product[0]["enTitle"],$product[0]["arTitle"]);
		if( !empty(direction($attribute[0]["enTitle"],$attribute[0]["arTitle"])) ){
			$output .= " - " . direction($attribute[0]["enTitle"],$attribute[0]["arTitle"]);
		}
		$collection = $items[$i]["collections"];
		for( $y = 0; $y < sizeof($collection) ; $y++ ){
			if ( !empty($collection[$y]) ){
				$productsInfo = selectDB('products', "`id` = '{$collection[$y]}'");
				$output .= "[ " . direction($productsInfo[0]["enTitle"],$productsInfo[0]["arTitle"]) . " ]";
			}
		}
		$extras = $items[$i]["extras"];
		for( $y = 0; $y < sizeof($extras["id"]) ; $y++ ){
			if ( !empty($extras["variant"][$y]) ){
				$extraInfo = selectDB('extras', "`id` = '{$extras["id"][$y]}'");
				$output .= "[ " . direction($extraInfo[0]["enTitle"],$extraInfo[0]["arTitle"]) . ": {$extras["variant"][$y]} ".numTo3Float($extraInfo[0]['price'])."KD]";
				$extraPrice[] = $extraInfo[0]['price'];
			}
		}
		if ( !empty($items[$i]["note"]) ){
			$output .= "[{$items[$i]["note"]}]</span>";
		}
		$output .= "<span class='Price'> " . numTo3Float(($sale)) ."KD </span></div>";
		$extraPrice = [0];
	}
	return $output;
}

?>