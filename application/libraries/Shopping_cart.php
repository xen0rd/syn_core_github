<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Shopping_cart Class
 * @author	Grizzlysts - Dean Manalo
 * @since 2017
 * @version	1.0.0
 */
class Shopping_cart {
	protected $CI;
	
	public function __construct(){
		$this->CI =& get_instance();
	}
	
	/**
	 * Adds item to cart
	 * @param int $itemId
	 * @return bool
	 */
	public function add(int $itemId): bool{
		$productDetails = $this->CI->product_model->productDetails($itemId);
		$itemArray = array($productDetails->id => array('item_name' => $productDetails->item_name,
													'id' => $productDetails->id,
													'quantity' => 1,
													'price' => $productDetails->item_price,
													'sub_total' => $productDetails->item_price
													)
							);
		
		if(!empty($_SESSION["cart_item"])) {
			if(in_array($productDetails->id ,array_keys($_SESSION["cart_item"]))) {
				return FALSE;
			}
			else{
				$_SESSION["cart_item"] = $_SESSION["cart_item"] + $itemArray;
				return TRUE;
			}
		}
		else{
			$_SESSION["cart_item"] = $itemArray;
			return TRUE;
		}
	}
	
	/**
	 * Updates quantity of the item
	 * @param int $itemId
	 * @param int $quantity
	 * @return bool
	 */
	public function update(int $itemId, int $quantity): bool{
		$productDetails = $this->CI->product_model->productDetails($itemId);
		$stock = $productDetails->stock;
		$price = $productDetails->item_price;
		if($quantity <= $stock){
			$_SESSION['cart_item'][$productDetails->id]['quantity'] = $quantity;
			$subTotal = $price * $quantity;
			$_SESSION['cart_item'][$productDetails->id]['sub_total'] = $subTotal;
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Removes all item in cart
	 * @return bool
	 */
	public function clear(): bool{
		unset($_SESSION['cart_item']);
		return TRUE;
	}
	
}
?>