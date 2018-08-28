<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Paypal_payments_pro Class
 * @author	Grizzlysts - Dean Manalo
 * @since 2018
 * @version	1.0.0
 */
class Paypal_payments_pro {
	protected $CI;
	
	public function __construct(){
		$this->CI =& get_instance();
	}
        
        public function doDirectPayment($orderData){
            $data = array(
                "VERSION" => _PAYPAL_PAYMENTS_PRO_VERSION,
                "SIGNATURE" => _PAYPAL_PAYMENTS_PRO_SIGNATURE,
                "USER" => _PAYPAL_PAYMENTS_PRO_USER,
                "PWD" => _PAYPAL_PAYMENTS_PRO_PWD,
                "METHOD" => _PAYPAL_PAYMENTS_PRO_METHOD_DIRECT_PAYMENT,
                "IPADDRESS" => $_SERVER['REMOTE_ADDR'],
                "PAYMENTACTION" => _PAYPAL_PAYMENTS_PRO_ACTION_SALE,
                "AMT" => $orderData['total_amount'],
                "ITEMAMT" => $orderData['total_amount'],
                "CREDITCARDTYPE" => $orderData['card_type'],
                "ACCT" => $orderData['account_number'],
                "EXPDATE" => $orderData['expiry_date'],
                "CVV2" => $orderData['cvv'],
                "FIRSTNAME" => $orderData['first_name'],
                "LASTNAME" => $orderData['last_name'],
                "STREET" => $orderData['street'],
                "CITY" => $orderData['city'],
                "STATE" => $orderData['state'],
                "ZIP" => $orderData['zip'],
                "COUNTRYCODE" => $orderData['country']
            );
            
            foreach($orderData as $key => $val){
                if(preg_match("/^L_NUMBER/", $key)){
                    $data[$key] = $val;
                  }
                if(preg_match("/^L_AMT/", $key)){
                  $data[$key] = $val;
                }
                if(preg_match("/^L_NAME/", $key)){
                    $data[$key] = $val;
                }
                if(preg_match("/^L_QTY/", $key)){
                    $data[$key] = $val;
                }
            }
            
            
            $init = curl_init();
            curl_setopt($init, CURLOPT_URL, _PAYPAL_PAYMENTS_PRO_URL);
            curl_setopt($init, CURLOPT_POST, true);
            curl_setopt($init, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
            return curl_exec($init);
            curl_close($init);
                
        }
        
}
?>