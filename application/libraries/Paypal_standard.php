<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Paypal_standard Class
 * @author	Grizzlysts - Dean Manalo
 * @since 2018
 * @version	1.0.0
 */
class Paypal_standard {
	protected $CI;
	
	public function __construct(){
		$this->CI =& get_instance();
	}
        
        public function paymentStatus(string $tx): string{
                $this->CI->load->module("user");
                
                $data = array('tx' => $tx,
                            'at' => $this->CI->user_model->paymentMethod(),
                            'cmd' => '_notify-synch'
                    );
                $init = curl_init();
                curl_setopt($init, CURLOPT_URL, _PAYPAL_PAYMENTS_URL);
                curl_setopt($init, CURLOPT_POST, true);
                curl_setopt($init, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
                return curl_exec($init);
                curl_close($init);
        }
        
        public function addTransaction(string $transactionId, int $userId, string $guestEmail, float $total): bool{
                if($userId != ''){
                    $sql = "INSERT INTO transaction (transaction_id, user_id, total) VALUES (?, ?, ?)";
                    $query = $this->CI->db->query($sql, array($transactionId, $userId, $total));    
                }
                else{
                    $sql = "INSERT INTO transaction (transaction_id, guest_email, total) VALUES (?, ?, ?)";
                    $query = $this->CI->db->query($sql, array($transactionId, $guestEmail, $total));    
                }
                
		return $this->CI->db->affected_rows() > 0 ? TRUE : FALSE;
	}
        
        public function addOrder(string $transactionId, int $itemId, int $quantity, float $total){
            $sql = "INSERT INTO `order` (transaction_id, item_id, quantity, sub_total) VALUES (?, ?, ?, ?)";
            $query = $this->CI->db->query($sql, array($transactionId, $itemId, $quantity, $total));
            
            return $this->CI->db->affected_rows() > 0 ? TRUE : FALSE;
        }
}
?>