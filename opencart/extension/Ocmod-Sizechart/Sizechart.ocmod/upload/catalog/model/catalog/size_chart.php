<?php
class ModelCatalogSizeChart extends Model
{
    function loadSizeChart($product_id)
    {
        $sql = "SELECT  c.* FROM " . DB_PREFIX . "size_chart_values c JOIN " . DB_PREFIX . "size_chart_option o ON(c.template_id = o.template_id) WHERE o.product_id = '" . $product_id . "'";        
        $query = $this->db->query($sql);
        return $query->rows;
    }
    public function checkCategory($product_id)
    {
        $sql = "SELECT ptc.product_id FROM " . DB_PREFIX . "size_chart_cat sc JOIN  " . DB_PREFIX . "product_to_category ptc ON (ptc.category_id = sc.category_id)";
			$data = $this->db->query($sql)->rows;
			$product_array = array();
			foreach ($data as $key => $value):
				$product_array[] = $value['product_id'];
			endforeach;
			if (in_array($product_id, $product_array)):
			endif;
			return $product_array;
    }
    public function catloadsizechart()
    {
        $sql = "SELECT  c.*,scc.category_id FROM " . DB_PREFIX . "size_chart_values c  JOIN " . DB_PREFIX . "size_chart_cat scc ON (scc.template_id = c.template_id)";
			$query = $this->db->query($sql);
			return $query->rows;
    }

    public function issizechart($product_id)
    {
        $count = $this->db->query("SELECT count(*) as total  FROM " . DB_PREFIX . "size_chart_option p WHERE p.product_id = '" . $product_id . "'");
        return $count->row['total'];
    }
    
    public function isinstall()
    {
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "extension WHERE type = 'module' AND code = 'size_chart'")->row;
        return $count['total'];
    }
}
?>