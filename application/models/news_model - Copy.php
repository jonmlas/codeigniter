<?php
class News_model extends CI_Model
{
    
    public function __construct()
    {
        $this->load->database();
        # error_reporting(E_ALL);
    }
	
    function check_duplicates($barcode)
    {
		// Loading second db and running query.
        $CI =& get_instance();
		$this->db2 = $CI->load->database('otherdb', TRUE);
		$query 	   = $this->db2->get_where('wp_postmeta', array(//making selection
			'meta_value' => $barcode
		));
	
		$count = $query->num_rows(); //counting result from query

		if ($count === 0) {
			$duplicateitem = 0;
		}
		else {
			$duplicateitem = 1;
		}
		return $duplicateitem;
	}
	
	public function find_duplicate_id($barcode)
	{
		// Loading second db and running query.
		$CI =& get_instance();
		$this->db2 = $CI->load->database('otherdb', TRUE);
		
		$this->db2->where('meta_value', $barcode);
		//here we select every clolumn of the table
		$query = $this->db2->get('wp_postmeta');
		$data = $query->result_array();
		
		return $data[0]['post_id'];
	}
    
	function mywp_posts()
		{
			// Loading second db and running query.
			$CI =& get_instance();
			//setting the second parameter to TRUE (Boolean) the function will return the database object.
			$this->db2 = $CI->load->database('otherdb', TRUE);
			$qry       = $this->db2->query("SELECT * FROM wp_postmeta");
			return $qry->result_array();
			#print_r($qry->result());exit;
		}
	   
	public function get_cat($slug = FALSE)
	{
		$CI =& get_instance();
		//setting the second parameter to TRUE (Boolean) the function will return the database object.
		$this->db2 = $CI->load->database('otherdb', TRUE);
		$query = $this->db2->get_where('wp_term_taxonomy', array(
			'description' => $slug
		));
		return $query->row_array();
	}
    
	public function get_cat2($slug = FALSE)
	{
		$CI =& get_instance();
		//setting the second parameter to TRUE (Boolean) the function will return the database object.
		$this->db2 = $CI->load->database('otherdb', TRUE);
		$query = $this->db2->get_where('wp_term', array(
			'name' => $slug
		));
		return $query->row_array();
	}
 
    public function insert_post($data, $table_name)
    {
        $CI =& get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('otherdb', TRUE);
        
        if ($this->db2->insert($table_name, $data)) {
            return $this->db2->insert_id();
        } else {
            return "wala";
        }
    }
    
    public function insert_post2($data, $table_name)
    {
        $CI =& get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('otherdb', TRUE);
        
        if ($this->db2->insert($table_name, $data)) {
            
            return $this->db2->insert_id();
        } else {
            #$this->db2->last_query();exit;
            return $this->db2->last_query();
        }
    }
	
	public function update_post($data, $table_name, $col1name, $col1val, $col2name, $col2val)
    {
		// Loading second db and running query.
		$CI =& get_instance();
		$this->db2 = $CI->load->database('otherdb', TRUE);
		
		$this->db2->where($col1name, $col1val);
		$this->db2->where($col2name, $col2val);
		//here we select every clolumn of the table
		$query = $this->db2->update($table_name, $data);
	}
    
    public function get_news($slug = FALSE)
    {
        if ($slug === FALSE) {
     
            $limit = 1;
            $start = 0;
            $sidx  = 'newid()';
            $sord  = 'asc';
            
            $this->db->select('*,ProductImages.image myphoto');
            #$this->db->select('*');
            $this->db->from('stock');
            $this->db->join('ProductImages', 'ProductImages.Number = stock.[Name of Item]');
            $this->db->order_by($sidx, $sord);
            $this->db->limit($limit, $start);
            $query = $this->db->get();
            #echo  $this->db->last_query();exit;
            return $query->result_array();
            
            /*    $query = $this->db->get('dbo.stock');
            echo "<pre>";
            var_dump($query);
            echo "</pre>";
            exit;			
            return $query->result_array(); */
        }
        
        #$query = $this->db->get_where('Stock', array('slug' => $slug));
        #return $query->row_array();
    }
}