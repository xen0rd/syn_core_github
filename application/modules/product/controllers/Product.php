<?php
class Product extends MX_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library("shopping_cart");
		$this->load->module('user');
		$this->load->model('product_model');
		
		if(!is_dir("uploads/thumbnails")){
			$mask = umask(0);
			mkdir("uploads/thumbnails", 0775);
			umask($mask);
		}
		
		if(!is_dir("uploads/downloadables")){
			$mask = umask(0);
			mkdir("uploads/downloadables", 0775);
			umask($mask);
		}
	}
	
	public function index(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
			
			$data['active']['menu'] = "Products";
			render('products.page', "user.template", $data);
		}
	}
	
	public function getProducts(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$products = $this->product_model->products();
			echo json_encode(array("data" => $products));
		}
	}
	
	public function viewProduct(){
		$productId = $this->uri->segment(3);
		$data['details'] = $this->product_model->productDetails($productId);
		$data['images'] = $this->product_model->productImages($productId);
		$data['cart'] = @$_SESSION['cart_item'];
                $data['payment_method'] = $this->user_model->paymentMethod();
		$data['shopping_cart'] = $this->load->view('shopping_cart.page.php', $data, TRUE);
		render('view_product.page', "client.template", $data);
	}
		
	public function addProduct(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
			
			if($this->input->post(NULL, TRUE)){
				//If a downloadable file is attached
				if(@$_FILES['downloadable_file']['size'] != 0){
					$fileName = date('mdY') . time();
					
					$fileExtension = pathinfo($_FILES['downloadable_file']['name'], PATHINFO_EXTENSION);
					$_POST['downloadable_file'] = $fileName . "." . $fileExtension;
					
					if(!move_uploaded_file($_FILES['downloadable_file']['tmp_name'], './uploads/downloadables/' . $_POST['downloadable_file'])){
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>upload</i> <b>' . $this->input->post('product_name', TRUE) . '</b> downloadable file', 0, _PRODUCT);
						$this->session->set_flashdata("error_message", "Failed to add new product.");
						redirect("admin/products");
					}
					else{
						$productId = $this->product_model->addProduct($this->input->post(NULL, TRUE));
						if($productId !== FALSE){
							if($_FILES['image']['size'][0] != 0){
								$this->uploadProductImages($_FILES['image'], $productId);
							}
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $this->input->post('product_name', TRUE) . '</b> product has been <i>added</i>', 1, _PRODUCT);
							$this->session->set_flashdata("success_message", "Product has been successfully added.");
							redirect("admin/products");
						}
						else{
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>add</i> <b>' . $this->input->post('product_name', TRUE) . '</b> product', 0, _PRODUCT);
							$this->session->set_flashdata("error_message", "Failed to add new product.");
							redirect("admin/products");
						}
					}
						
				}
				else{//If NO downloadable file is attached
					$productId = $this->product_model->addProduct($this->input->post(NULL, TRUE));
					if($productId !== FALSE){
						if($_FILES['image']['size'][0] != 0){
							$this->uploadProductImages($_FILES['image'], $productId);
						}
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $this->input->post('product_name', TRUE) . '</b> product has been <i>added</i>', 1, _PRODUCT);
						$this->session->set_flashdata("success_message", "Product has been successfully added.");
						redirect("admin/products");
					}
					else{
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>add</i> <b>' . $this->input->post('product_name', TRUE) . '</b> product', 0, _PRODUCT);
						$this->session->set_flashdata("error_message", "Failed to add new product.");
						redirect("admin/products");
					}
				}
			}
			else{
				$this->load->view("modals/add_product_modal", $data);
			}
		}
	}
	
	public function uploadProductImages($images, $productId){
		for($i = 0; $i < sizeof($images['tmp_name']); $i++){
			$fileName = date('mdY') . time();
			$tmpName = explode('.', basename($images['tmp_name'][$i]));
			
			$fileExtension = pathinfo($images['name'][$i], PATHINFO_EXTENSION);
			$imageName = $tmpName[0] . $fileName . "." . $fileExtension;
			
			//thumbnail upload failed
			if(!move_uploaded_file($images['tmp_name'][$i], './uploads/thumbnails/' . $imageName)){
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>upload</i> thumbnail', 0, _PRODUCT);
			}
			else{ //thumbnail upload successful
				if($this->product_model->addProductImages($productId, $imageName)){
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $this->input->post('product_name', TRUE) . '</b> thumbnail has been <i>added</i>', 1, _PRODUCT);
				}
				else{
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>add</i> <b>' . $this->input->post('product_name', TRUE) . '</b> thumbnail', 0, _PRODUCT);
				}
			}
		}
	}
	
	public function editProduct(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
				
			if($this->input->post(NULL, TRUE)){
				$productId = $this->input->post("product_id", TRUE);
				$name = $this->input->post("item_name", TRUE);
				$description = $this->input->post("item_description", TRUE);
				$stock = $this->input->post("stock", TRUE);
				$price = $this->input->post("item_price", TRUE);
				
				//If a downloadable file is attached
				if(@$_FILES['downloadable_file']['size'] != 0){
					$fileName = date('mdY') . time();
						
					$fileExtension = pathinfo($_FILES['downloadable_file']['name'], PATHINFO_EXTENSION);
					$_POST['downloadable_file'] = $fileName . "." . $fileExtension;
						
					if(!move_uploaded_file($_FILES['downloadable_file']['tmp_name'], './uploads/downloadables/' . $_POST['downloadable_file'])){
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> <b>' . $this->input->post('product_name', TRUE) . '</b> downloadable file', 0, _PRODUCT);
						$this->session->set_flashdata("error_message", "Failed to update product.");
						redirect("admin/products");
					}
					else{
						$update = $this->product_model->updateProduct($productId, $name, $description, $stock, $price, $_POST['downloadable_file']);
						if($update !== FALSE){
							if($_FILES['image']['size'][0] != 0){
								$this->updateProductImages($_FILES['image'], $productId);
							}
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $this->input->post('product_name', TRUE) . '</b> product has been <i>updated</i>', 1, _PRODUCT);
							$this->session->set_flashdata("success_message", "Product has been successfully updated.");
							redirect("admin/products");
						}
						else{
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> <b>' . $this->input->post('product_name', TRUE) . '</b> product', 0, _PRODUCT);
							$this->session->set_flashdata("error_message", "Failed to update product.");
							redirect("admin/products");
						}
					}
				
				}
				else{//If NO downloadable file is attached
					$update = $this->product_model->updateProduct($productId, $name, $description, $stock, $price);
					if($update !== FALSE){
						if($_FILES['image']['size'][0] != 0){
							$this->updateProductImages($_FILES['image'], $productId);
						}
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $this->input->post('product_name', TRUE) . '</b> product has been <i>updated</i>', 1, _PRODUCT);
						$this->session->set_flashdata("success_message", "Product has been successfully updated.");
						redirect("admin/products");
					}
					else{
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> <b>' . $this->input->post('product_name', TRUE) . '</b> product', 0, _PRODUCT);
						$this->session->set_flashdata("error_message", "Failed to update product.");
						redirect("admin/products");
					}
				}
			}
			else{
				$data['product_details'] = $this->product_model->productDetails($this->uri->segment(3));
				$data['images'] = $this->product_model->productImages($this->uri->segment(3));
				$this->load->view("modals/edit_product_modal", $data);
			}
		}
	}
	
	public function updateProductImages($images, $productId){
		for($i = 0; $i < sizeof($images['tmp_name']); $i++){
			$fileName = date('mdY') . time();
			$tmpName = explode('.', basename($images['tmp_name'][$i]));
				
			$fileExtension = pathinfo($images['name'][$i], PATHINFO_EXTENSION);
			$imageName = $tmpName[0] . $fileName . "." . $fileExtension;
				
			//thumbnail upload failed
			if(!move_uploaded_file($images['tmp_name'][$i], './uploads/thumbnails/' . $imageName)){
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> thumbnail', 0, _PRODUCT);
			}
			else{ //thumbnail upload successful
				if($this->product_model->addProductImages($productId, $imageName)){
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $this->input->post('product_name', TRUE) . '</b> thumbnail has been <i>updated</i>', 1, _PRODUCT);
				}
				else{
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> <b>' . $this->input->post('product_name', TRUE) . '</b> thumbnail', 0, _PRODUCT);
				}
			}
		}
	}
	
        public function deleteProductImage(){
            $productId = $this->input->post('item_id');
            $imageId = $this->input->post('image_id');
            
            $response = "0";
            if($this->product_model->deleteProductImage($productId, $imageId)){
                $response = "1";
            }
            
            echo $response;
        }
        
	public function deleteProduct(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
				
			if($this->input->post(NULL, TRUE)){
				$productId = $this->input->post('product_id', TRUE);
				$productName = $this->product_model->productName($productId);
				if($this->product_model->deleteProduct($productId)){
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $productName . '</b> product has been <i>deleted</i>', 1, _PRODUCT);
					$this->session->set_flashdata("success_message", "Product has been successfully deleted.");
					redirect("admin/products");
				}
				else{
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>delete</i> <b>' . $productName . '</b> product', 0, _PRODUCT);
					$this->session->set_flashdata("error_message", "Failed to delete product.");
					redirect("admin/products");
				}
			}
			else{
				$this->load->view("modals/delete_product_modal", $data);
			}
		}
	}
	
	public function changeProductStatus(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
				
			if($this->input->post(NULL, TRUE)){
				$productId = $this->input->post("id", TRUE);
				$productName = $this->product_model->productName($productId);
				$status = $this->product_model->productStatus($productId) == "0" ? "1" : "0";
				if($this->product_model->updateProductStatus($productId, $status)){
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $productName . '</b> product has been <i>' . ($status == '1' ? 'enabled' : 'disabled') . '</i>', 1, _PRODUCT);
					echo "TRUE";
				}
				else{
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to change the <i>status</i> of <b>' . $productName . '</b> product', 0, _PRODUCT);
					echo "FALSE";
				}
			}
			else{
				$this->load->view("modals/change_product_status_modal", $data);
			}
		}
	}
	
	public function productDetails(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			if($this->session->userdata("u_role") != "admin"){
				echo "403 Forbidden";
			}
			else{
				$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
				$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
				
				$productName = $this->product_model->productName($this->uri->segment(3));
				$data['product_details'] = $this->product_model->productDetails($this->uri->segment(3));
				$data['product_images'] = $this->product_model->productImages($this->uri->segment(3));
				$data['active']['menu'] = "Products";
				$data['active']['sub_menu'] = "<a href='" . base_url() . "admin/products'>Products</a>";
				$data['active']['sub_menu_breadcrumb'] = " > " . $productName;
					
				render("product/product_details.page", "user.template", $data);
			}
		}
	}
	
	public function cart(){
		echo json_encode($_SESSION['cart_item']);
	}
	
	public function updateCart(){
		$itemId = $this->uri->segment("3");
		$quantity = $this->uri->segment("4");
		if($this->shopping_cart->update($itemId, $quantity)){
			$this->session->set_flashdata("success_message", "Cart has been updated");
		}
		else{
			$this->session->set_flashdata("error_message", "Insufficient available stock");
		}
		
		redirect(base_url());
	}
	
	public function removeItem(){
		$productId = $this->uri->segment("3");
		unset($_SESSION["cart_item"][$productId]);
		$this->session->set_flashdata("success_message", "Item has been removed");
		redirect(base_url());
	}
	
	public function addToCart(){
		$itemId = $this->uri->segment("3");
		if($this->shopping_cart->add($itemId)){
			$this->session->set_flashdata("success_message", "Item has been added to cart");
		}
		else{
			$this->session->set_flashdata("error_message", "Item already in the cart");
		}
		redirect(base_url());
	} 
	
	public function emptyCart(){
		if($this->shopping_cart->clear()){
			$this->session->set_flashdata("success_message", "Cart has been emptied");
		}
		else{
			$this->session->set_flashdata("error_message", "Failed to empty cart");
		}
		
		redirect(base_url());
	}
	
	public function embed(){
		$productId = $this->uri->segment(3);
		$data['product'] = $this->product_model->productDetails($productId);
		$data['details'] = $this->product_model->productDetails($productId);
		$data['images'] = $this->product_model->productImages($productId);
		$this->load->view('frames/product_frame', $data);
	}
	
	public function paypalReturn(){
                $this->load->library('paypal_standard');
                $tx = $this->input->get('tx');
                $pdt = $this->paypal_standard->paymentStatus($tx);
                
                $rawData = preg_split("/\r\n|\n|\r/", $pdt);
                $arrayData['status'] = "";
                
                if (strcmp ($rawData[0], "SUCCESS") == 0) {
                    $arrayData['status'] = "SUCCESS";
                    log_message("error", "PAYPAL_SUCCESS");
                    for ($i = 1; $i < sizeof($rawData); $i++){
                       $explodeData = explode("=", $rawData[$i]);
                       @$arrayData[$explodeData[0]] = $explodeData[1];
                    }
                }
              else if (strcmp ($rawData[0], "FAIL") == 0) {
                    $arrayData['status'] = "FAIL";
                    log_message("error", "PAYPAL_FAIL");
                    $this->session->set_flashdata('error_message', 'Purchase Failed. Please try again');
              }
              
              if($arrayData['status'] == "SUCCESS"){
                  $userData = urldecode($arrayData['custom']);
                  $jsonObj = json_decode($userData);
                  $userId = $jsonObj->user_id;
                  $guestEmail = $jsonObj->guest_email;
                  $itemNumbers = array();
                  $itemNames = array();
                  $itemQuantities = array();
                  $itemGross = array();
                  //var_dump($arrayData);
                  
                    foreach($arrayData as $key => $val){
                        if(preg_match("/^item_number/", $key)){
                            $itemNumbers[$key] = $val;
                          }
                        if(preg_match("/^item_name/", $key)){
                          $itemNames[$key] = $val;
                        }
                        if(preg_match("/^quantity/", $key)){
                            $itemQuantities[$key] = $val;
                        }
                        if(preg_match("/^mc_gross_/", $key)){
                            $itemGross[$key] = $val;
                        }
                    }
                  
                  //echo "<br><br><br>";
                  
//                    var_dump($itemNumbers);
//                    var_dump($itemNames);
//                    var_dump($itemQuantities);
//                    var_dump($itemGross);
//                    
                    
                    
                    
                  $orders = array();
                  for($i = 1 ; $i <= sizeof($itemNumbers); $i++){
                    array_push($orders, array('item_number' . $i  => $itemNumbers['item_number' . $i],
                                            'item_name' . $i   => $itemNames['item_name' . $i],
                                            'quantity' . $i => $itemQuantities['quantity' . $i],
                                            'mc_gross_' . $i  => $itemGross['mc_gross_' . $i])
                            );
                  }
                  //echo "<br><br><br>";
                  //var_dump($orders);
                  $this->paypal_standard->addTransaction($arrayData['txn_id'], (int)$userId, $guestEmail, (float)$arrayData['payment_gross']);
                  for($i = 1 ; $i <= sizeof($orders); $i++){
                      $this->paypal_standard->addOrder($arrayData['txn_id'], (int)$arrayData['item_number' . $i], (int)$arrayData['quantity' . $i], (float)$arrayData['mc_gross_' . $i]);
                  }
                  
                  $arrayData['payment_date'] = date('m-d-Y');
                  $customerEmail = "";
                  
                  //Send order notification to admin and client
                  if($userId != ''){
                      $username = $this->user_model->username($userId);
                      $userInfo = $this->auth_model->userInfo($username);
                      $customerEmail = $userInfo->email;
                      $customerName = $userInfo->first_name . " " . $userInfo->last_name;
                      $this->sendOrderConfirmationToClient($customerEmail, $orders, $arrayData, $customerName);
                      $this->sendOrderConfirmationToAdmin($orders, $arrayData);
                  }
                  else{
                      $customerEmail = $guestEmail;
                      $this->sendOrderConfirmationToClient($customerEmail, $orders, $arrayData);
                      $this->sendOrderConfirmationToAdmin($orders, $arrayData);
                  }
                  
                  $this->session->unset_userdata('cart_item');
                  $this->session->set_flashdata('success_message', 'Purchase Successful');    
              }
              
              $this->session->unset_userdata('guest_email');
              redirect(base_url());
	}
        
        public function guestEmail(){
            $guestEmail = $this->input->post('email');
            $this->session->set_userdata('guest_email', $guestEmail);
            echo 1;
        }
        
//        public function purchaseHistory(){
//            $clientId = $this->uri->segment('3');
//        }
//        
//        public function remove(){
//            $this->session->unset_userdata('guest_email');
//        }
        
        public function orderHistory(){
            if($this->auth->isUserLoggedIn()){
                    if($this->uri->segment(1) == "admin"){
                        $userId = $this->uri->segment(4);
                        $username = $this->uri->segment(5);
                        $data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
                        $data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
                        $data['active']['menu'] = "Clients";
                        $data['active']['sub_menu'] = "<a href='" . base_url() . "client/clients'>Clients</a>";
                        $data['active']['sub_menu_breadcrumb'] = " > <a href='" . base_url() . "client/clientDetails/" . $userId . "/" . $username . "'> " . $username . "</a> > Order History";

                        $data['transactions'] = $this->product_model->purchaseHistory($userId);

                        render("order_history.page", "user.template", $data);   
                    }
            }
            
            if($this->auth->isClientLoggedIn()){
                if($this->uri->segment(1) == "purchase_history"){
                    $userId = $this->session->userdata('c_id');
                    $username = $this->session->userdata('c_username');
//                    $data['active']['menu'] = "Clients";
//                    $data['active']['sub_menu'] = "<a href='" . base_url() . "client/clients'>Clients</a>";
//                    $data['active']['sub_menu_breadcrumb'] = " > <a href='" . base_url() . "client/clientDetails/" . $userId . "/" . $username . "'> " . $username . "</a> > Order History";
                    
                    $data['transactions'] = $this->product_model->purchaseHistory($userId);
                    
                    render("order_history.page", "client.template", $data);   
                }
            }
        }
        
        public function clientOrderDetails(){
            if($this->uri->segment(1) == "admin"){
                $data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
                $data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);

                $userId = $this->uri->segment(4);
                $username = $this->uri->segment(5);
                $id = $this->uri->segment(6);
                $transactionId = $this->uri->segment(7);
                $data['order'] = $this->product_model->clientOrderDetails($userId, $transactionId);
                $data['active']['menu'] = "Clients";
                $data['active']['sub_menu'] = "<a href='" . base_url() . "client/clients'>Clients</a>";
                $data['active']['sub_menu_breadcrumb'] = " > <a href='" . base_url() . "client/clientDetails/" . $userId . "/" . $username . "'> " . $username . "</a> >
                                                                                                                        <a href='" . base_url() . "/admin/product/order_history/" . $userId . "/" . $username . "'> Order History </a>  > " . $transactionId;
                $data['orders'] = $this->product_model->clientOrderDetails($userId , $transactionId);
                render("product/order_details.page", "user.template", $data);
            }
            else{
                $userId = $this->session->userdata('c_id');
                $transactionId = $this->uri->segment(4);
                $data['orders'] = $this->product_model->clientOrderDetails($userId , $transactionId);
                render("product/order_details.page", "client.template", $data);
            }           
        }
        
        public function orders(){
            if(!$this->auth->isUserLoggedIn()){
                redirect("admin");
            }
            else{
                $data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
                $data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
                
                $data['orders'] = $this->product_model->orders();
                $data['active']['menu'] = "Orders";
                render("orders.page", "user.template", $data);
            }
        }
        
        public function orderDetails(){
            if(!$this->auth->isUserLoggedIn()){
                redirect("admin");
            }
            else{
                $data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
                $data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);

                $transactionId = $this->uri->segment(4);
                $data['active']['menu'] = "Orders";
                $data['active']['sub_menu'] = $transactionId;
                $data['orders'] = $this->product_model->orderDetails($transactionId);
                
                render("product/order_details.page", "user.template", $data);
                
            }
        }
        
        public function purchasedProducts(){
            $userId = $this->session->userdata('c_id');
            $data['purchasedItems'] = $this->product_model->clientProducts($userId);
            render("product/purchased_products.page", "client.template", $data);
        }
        
        public function getVirtualImages(){
            echo json_encode($this->product_model->virtualProducts());
        }
        
        public function getDownloadableImages(){
            echo json_encode($this->product_model->downloadableProducts());
        }
        
        
        public function sendOrderConfirmationToClient(string $email, $orders, $arrayData, string $customerName = null){
                $items = "";
            
                for($i = 1 ; $i <= sizeof($orders); $i++){
                    $items .= "\n " .
                                "\nItem name : " . urldecode($arrayData['item_name' . $i]) .
                                "\nQuantity : " . $arrayData['quantity' . $i] .
                                "\nAmount : $" . $arrayData['mc_gross_' . $i] . " USD";
                }	
                
                //return $items;
            
                $subject = "Order Confirmation";
                $orderNumber = $arrayData['txn_id'];
                $date = $arrayData['payment_date'];
                
		$msg = "Dear " . ($customerName ?? "guest") . ",
                        \n
This is a payment receipt for Order " . $orderNumber . " sent on " . $date .
$items .
"\n \n ------------------------------------------------------\n
Total: $" . $arrayData['payment_gross'] ." USD\n 
Transaction #: ". $arrayData['txn_id'] . "\n 
Total Paid: $" . $arrayData['payment_gross'] ." USD\n 
Status: Paid\n \n 
You may review your order history at any time by logging in to your account at http://synthia2.grizzlysts.com/
\n 
Note: This email will serve as an official receipt for this payment.
\n 
Grizzly Software & Technical Services
\n 
Making the world a slightly better place, one piece of software at a time.";
                        
		
		$this->load->module('user');
		$configHost = $this->user_model->SMTPConfig()->smtp_host;
		$configUser = $this->user_model->SMTPConfig()->smtp_user;
		$decryptedConfigPass = $this->encryption->decrypt($this->user_model->SMTPConfig()->smtp_pass);
		$configPass = $decryptedConfigPass;
		//$configPort = $this->user_model->SMTPConfig()->smtp_port;
		
	   $config = array(
		  'protocol' => 'smtp',
		  'smtp_host' => _SMTP_PROTOCOL ."://" . $configHost,
		  'smtp_port' => _SMTP_PORT,
		  'smtp_user' => $configUser,
		  'smtp_pass' => $configPass
		);
		
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		$this->email->from($configUser, 'SYNTHIA - NOREPLY');
		$this->email->to($email);

		$this->email->subject($subject);
		$this->email->message($msg);	
		
		if(!$this->email->send()){
			log_message('error', $this->email->print_debugger());
			return false;
		}
		
		return true;
	}
        
        public function sendOrderConfirmationToAdmin($orders, $arrayData){
                $adminEmails = array();
		foreach($this->product_model->adminEmails() as $admin){
			 array_push($adminEmails, $admin->email);
		}
            
                $items = "";
            
                for($i = 1 ; $i <= sizeof($orders); $i++){
                    $items .= "\n " .
                                "\nItem name : " . urldecode($arrayData['item_name' . $i]) .
                                "\nQuantity : " . $arrayData['quantity' . $i] .
                                "\nAmount : $" . $arrayData['mc_gross_' . $i] . " USD";
                }	
                
                //return $items;
            
                $subject = "Order Confirmation";
                $orderNumber = $arrayData['txn_id'];
                $date = $arrayData['payment_date'];
                
		$msg = "Dear admin,
                        \n
This is a payment receipt for Order " . $orderNumber . " sent on " . $date .
$items .
"\n \n ------------------------------------------------------\n
Total: $" . $arrayData['payment_gross'] ." USD\n 
Transaction #: ". $arrayData['txn_id'] . "\n 
Total Paid: $" . $arrayData['payment_gross'] ." USD\n 
Status: Paid\n \n 
You may review the order history at any time by logging in to your account at http://synthia2.grizzlysts.com/admin
\n 
Note: This email will serve as an official receipt for this payment.
\n 
Grizzly Software & Technical Services
\n 
Making the world a slightly better place, one piece of software at a time.";
                        
		
		$this->load->module('user');
		$configHost = $this->user_model->SMTPConfig()->smtp_host;
		$configUser = $this->user_model->SMTPConfig()->smtp_user;
		$decryptedConfigPass = $this->encryption->decrypt($this->user_model->SMTPConfig()->smtp_pass);
		$configPass = $decryptedConfigPass;
		//$configPort = $this->user_model->SMTPConfig()->smtp_port;
		
	   $config = array(
		  'protocol' => 'smtp',
		  'smtp_host' => _SMTP_PROTOCOL ."://" . $configHost,
		  'smtp_port' => _SMTP_PORT,
		  'smtp_user' => $configUser,
		  'smtp_pass' => $configPass
		);
		
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		$this->email->from($configUser, 'SYNTHIA - NOREPLY');
		$this->email->to($adminEmails);

		$this->email->subject($subject);
		$this->email->message($msg);	
		
		if(!$this->email->send()){
			log_message('error', $this->email->print_debugger());
			return false;
		}
		
		return true;
	}
        
        
        public function paypalPaymentsPro(){
            $this->load->library('paypal_payments_pro');
            $this->load->library('paypal_standard');
            
            $isGuest = $this->input->post('is_guest') == 1 ? TRUE : FALSE;
            
            $userId = $isGuest ? '' : $this->session->userdata('c_id');
            $guestEmail = $isGuest ? $this->input->post('email') : '';
            
            //temporarily put the order information in a session variable
            $this->session->set_userdata('order_pro', $_POST);
            
            //process paypal payment pro
            parse_str($this->paypal_payments_pro->doDirectPayment($_POST), $output);
            
            //var_dump($output);
            
            $arrayData = array();
            $orderCount = 0;
            $orders = array();
            
            foreach($_POST as $key => $val){
                if(preg_match("/^L_NUMBER/", $key)){
                    $orderCount++;
                    $arrayData['item_number' . $orderCount] = $val;
                    array_push($orders, $val);
                  }
                if(preg_match("/^L_AMT/", $key)){
                  $arrayData['mc_gross_' . $orderCount] = $val;
                }
                if(preg_match("/^L_NAME/", $key)){
                    $arrayData['item_name' . $orderCount] = $val;
                }
                if(preg_match("/^L_QTY/", $key)){
                    $arrayData['quantity' . $orderCount] = $val;
                }
            }
            
            $arrayData['txn_id'] = $output['TRANSACTIONID'];
            $arrayData['payment_date'] = date('m-d-Y');
            $arrayData['payment_gross'] = (float)$output['AMT'];
            
            if($output['ACK'] === 'Success'){
                $this->paypal_standard->addTransaction($output['TRANSACTIONID'], (int)$userId, $guestEmail, (float)$output['AMT']);
                    for($i = 1 ; $i <= sizeof($orders); $i++){
                        $this->paypal_standard->addOrder($output['TRANSACTIONID'], (int)$arrayData['item_number' . $i], (int)$arrayData['quantity' . $i], (float)$arrayData['mc_gross_' . $i]);
                    }
            }
            
            //Send order notification to admin and client
            if($userId != ''){
                $username = $this->user_model->username($userId);
                $userInfo = $this->auth_model->userInfo($username);
                $customerEmail = $userInfo->email;
                $customerName = $userInfo->first_name . " " . $userInfo->last_name;
                $this->sendOrderConfirmationToClient($customerEmail, $orders, $arrayData, $customerName);
                $this->sendOrderConfirmationToAdmin($orders, $arrayData);
            }
            else{
                $customerEmail = $guestEmail;
                $this->sendOrderConfirmationToClient($customerEmail, $orders, $arrayData);
                $this->sendOrderConfirmationToAdmin($orders, $arrayData);
            }
            
            
            $this->session->unset_userdata('order_pro');
            $this->session->unset_userdata('cart_item');
            $this->session->unset_userdata('guest_email');
            
            $this->session->set_flashdata('success_message', 'Purchase Successful');    
            redirect(base_url());
        }
}
?>