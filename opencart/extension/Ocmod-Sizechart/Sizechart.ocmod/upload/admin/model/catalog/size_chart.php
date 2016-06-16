<?php 
	class ModelCatalogSizeChart extends Model {
	/*------------------------------------Return total number of templates----------------------------------------*/
		public function total(){
			$query=$this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "size_chart_values")->row;
			return $query['total'];
		}
	/*-------------------------------------(Pagination)Return All record from size_chart_values------------------------------*/
		public function showtemplatename($data) {
			$cust_sql="SELECT * FROM " . DB_PREFIX . "size_chart_values";
			if(isset($data['start']) || isset($data['limit'])){
					if ($data['start'] < 0){
						$data['start'] = 0;
					}
					if ($data['limit'] < 1){
						$data['limit'] = 20;
					}
					$cust_sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
				} 
			$query = $this->db->query($cust_sql);
			return $query->rows;
		}
	/*-------------------------------------Inserting template details to database--------------------------------------*/
		public function puttemplate($temp_data) {
			$serialized_data=addslashes(serialize($temp_data['data']));
			$size_chart_images=$this->db->escape(addslashes(serialize($temp_data['size_chart_images'])));
			$this->db->query("INSERT INTO " . DB_PREFIX . "size_chart_values SET templatename= '".$this->db->escape($temp_data['templatename'])."', size_chart_data='".$this->db->escape($serialized_data)."', content='".$this->db->escape($temp_data['template_content'])."' , size_chart_images ='".$size_chart_images."'") ;
			$templateid = $this->db->getLastId();
			if(isset($temp_data['size_chart_product']) && $temp_data['size_chart_product'] != ''){
				$product_ids = explode(',',$temp_data['size_chart_product']);
				foreach($product_ids as $product_id){
					$this->db->query("INSERT INTO " . DB_PREFIX ."size_chart_option SET product_id = '".(int)$product_id."', template_id = '".(int)$templateid."'");
				}
			}
			if(isset($temp_data['product_category']) && $temp_data['product_category'] != ''){
				foreach($temp_data['product_category'] as $category_id){
					$this->db->query("INSERT INTO " . DB_PREFIX ."size_chart_cat SET category_id = '".$category_id."', template_id = '".(int)$templateid."'");
				}
			}
			return($templateid);
		}
	/*------------------------------------ Get the categories associated with the template/size chart id -----------------*/
		public function getCategories($size_chart_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "size_chart_cat WHERE template_id = '".$size_chart_id."'");
			return $query->rows;
		}	
	/*-------------------------------------All record from size_chart_values for editing------------------------------*/	
		public function edit_size_chart($size_chart_id){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "size_chart_values WHERE template_id = '".$size_chart_id."'");
			return $query->row;
		}
	/*--------------------------------------Updating Template Details---------------------------------------*/
		public function update_size_chart($data) {
			$size_chart_images=$this->db->escape(addslashes(serialize($data['size_chart_images'])));
			$this->db->query("DELETE FROM " . DB_PREFIX . "size_chart_values WHERE template_id = '".$data['template_id']."'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "size_chart_cat WHERE template_id = '".$data['template_id']."'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "size_chart_option WHERE template_id = '".$data['template_id']."'");
			$serialized_data=addslashes(serialize($data['data']));
			$this->db->query("INSERT INTO " . DB_PREFIX . "size_chart_values  SET template_id = ".$this->db->escape($data['template_id']).",templatename ='".$this->db->escape($data['templatename'])."',size_chart_data = '".$this->db->escape($serialized_data)."' , content = '".$this->db->escape($data['template_content'])."' , size_chart_images = '".$size_chart_images."' ");
			if(isset($data['size_chart_product']) && $data['size_chart_product'] != ''){
				$product_ids = explode(',',$data['size_chart_product']);
				foreach($product_ids as $product_id){
					$this->db->query("INSERT INTO " . DB_PREFIX ."size_chart_option SET product_id = '".$product_id."', template_id = '".$data['template_id']."'");
				}
			}
			if(isset($data['product_category']) && $data['product_category'] != ''){
				
				foreach($data['product_category'] as $category_id){
					$this->db->query("INSERT INTO " . DB_PREFIX ."size_chart_cat SET category_id = '".$category_id."', template_id = '".$data['template_id']."'");
				}
			}
		}
	/*--------------------------------------Deleting Template Permanently--------------*/	
		public function delete_size_chart($template_id){
			$this->db->query("DELETE FROM " . DB_PREFIX . "size_chart_values WHERE template_id = '".$template_id."'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "size_chart_option WHERE template_id = '".$template_id."'");
		}
		public function product_size_chart($template_id){
			$products = $this->db->query("SELECT product_id FROM " . DB_PREFIX ."size_chart_option WHERE template_id = '".$template_id."'")->rows;
			return $products;
		}
		public function createtable(){
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "size_chart_values`(`template_id` int(12) NOT NULL AUTO_INCREMENT ,`templatename` varchar(255) NOT NULL,`size_chart_data` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,`content` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,`size_chart_images` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,PRIMARY KEY (`template_id`))");
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "size_chart_option` (`id` int(12) NOT NULL AUTO_INCREMENT,`product_id` int(12) NOT NULL,`template_id`int(12) NOT NULL,PRIMARY KEY (`id`))");
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "size_chart_cat` (`id` int(255) NOT NULL AUTO_INCREMENT,`category_id` int(255) NOT NULL,`template_id` int(255) NOT NULL ,PRIMARY KEY (`id`))");
		
		}
	}
?>