<?php
class Product_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function products(){
		$sql = "SELECT a.*, b.image FROM item a LEFT JOIN item_image b ON a.id = b.item_id GROUP BY a.id";
		$query = $this->db->query($sql);
		return $query->result();
	}
        
	public function downloadableProducts(){
		$sql = "SELECT a.*, b.image FROM item a LEFT JOIN item_image b ON a.id = b.item_id WHERE a.item_type = ? GROUP BY a.id";
		$query = $this->db->query($sql, "Downloadable");
		return $query->result();
	}
        
	public function virtualProducts(){
		$sql = "SELECT a.*, b.image FROM item a LEFT JOIN item_image b ON a.id = b.item_id WHERE a.item_type = ? GROUP BY a.id";
		$query = $this->db->query($sql, "Virtual");
		return $query->result();
	}
	
	public function productName($productId){
		$sql = "SELECT item_name FROM item WHERE id = ?";
		$query = $this->db->query($sql, array($productId));
		return $query->row()->item_name;
	}
	
	public function productDetails($productId){
		$sql = "SELECT a.*, b.image FROM item a LEFT JOIN item_image b ON a.id = b.item_id WHERE a.id = ?  GROUP BY a.id";
		$query = $this->db->query($sql, array($productId));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function productStatus($productId){
		$sql = "SELECT status FROM item WHERE id = ?";
		$query = $this->db->query($sql, array($productId));
		return $query->row()->status;
	}
	
	public function addProduct($postData){
		$this->db->insert("item", $postData);
		return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
	}
	
	public function allProductsImages(){
		$sql = "SELECT * FROM item_image";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function productImages($productId){
		$sql = "SELECT * FROM item_image WHERE item_id = ?";
		$query = $this->db->query($sql, array($productId));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function addProductImages($productId, $imageName){
		$sql = "INSERT INTO item_image (item_id, image) VALUES (?, ?)";
		$query = $this->db->query($sql, array($productId, $imageName));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function deleteProductImage($productId, $imageId){
		$sql = "DELETE FROM item_image WHERE item_id = ? AND id = ?";
		$query = $this->db->query($sql, array($productId, $imageId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function updateProduct($productId, $name, $description, $stock, $price, $downloadable_file = NULL){
		if($downloadable_file !== NULL){
			$sql = "UPDATE item SET item_name = ?, item_description = ?, stock = ?, item_price = ?, downloadable_file = ? WHERE id = ?";
			$query = $this->db->query($sql, array($name, $description, $stock, $price, $downloadable_file, $productId));
		}
		else{
			$sql = "UPDATE item SET item_name = ?, item_description = ?, stock = ?, item_price = ? WHERE id = ?";
			$query = $this->db->query($sql, array($name, $description, $stock, $price, $productId));
		}
	
		return TRUE;
	}
	
	public function deleteProduct($productId){
		$sql = "DELETE FROM item WHERE id = ?";
		$query = $this->db->query($sql, array($productId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function updateProductStatus($productId, $status){
		$sql = "UPDATE item SET status = ? WHERE id = ?";
		$query = $this->db->query($sql, array($status, $productId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
        
        public function purchaseHistory($userId){
                $sql = "SELECT * FROM transaction WHERE user_id = ?";
                $query = $this->db->query($sql, $userId);
                return $query->result();
        }
        
        public function clientOrderDetails($userId , $transactionId){
                $sql = "SELECT a.*, b.total, c.item_name, c.item_description, c.item_price, d.image FROM `order` a 
                        INNER JOIN transaction b ON a.transaction_id = b.transaction_id
                        INNER JOIN item c ON a.item_id = c.id
                        INNER JOIN item_image d ON c.id = d.item_id
                        WHERE a.transaction_id = ? AND b.user_id = ?";
                
                $query = $this->db->query($sql, array($transactionId, $userId));
                return $query->result();
        }
        
        public function orders(){
            $sql = "SELECT a.*, b.username, b.first_name, b.last_name FROM transaction a LEFT JOIN user b ON a.user_id = b.id";
            $query = $this->db->query($sql);
            return $query->result();
        }
        
        public function orderDetails($transactionId){
                $sql = "SELECT a.*, b.total, c.item_name, c.item_description, c.item_price, d.image FROM `order` a 
                        INNER JOIN transaction b ON a.transaction_id = b.transaction_id
                        INNER JOIN item c ON a.item_id = c.id
                        INNER JOIN item_image d ON c.id = d.item_id
                        WHERE a.transaction_id = ?";
                
                $query = $this->db->query($sql, array($transactionId));
                return $query->result();
        }
	
        public function clientProducts($userId){
            $sql = "SELECT a.*, b.total, c.item_name, c.item_description, c.item_price, c.downloadable_file, c.item_type, d.image FROM `order` a 
                        INNER JOIN transaction b ON a.transaction_id = b.transaction_id
                        INNER JOIN item c ON a.item_id = c.id
                        INNER JOIN item_image d ON c.id = d.item_id
                        WHERE b.user_id = ?";
                
                $query = $this->db->query($sql, array($userId));
                return $query->result();
        }
        
        public function adminEmails(){
		$sql = "SELECT email FROM user WHERE role_id = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result();
	}
        
}
?>