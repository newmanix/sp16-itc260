<?php
//News_model.php
class News_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
    
    
    public function get_news($slug = FALSE)
    {
            if ($slug === FALSE)
            {
                    $query = $this->db->get('sp16_news');
                    return $query->result_array();
            }

            $query = $this->db->get_where('sp16_news', array('slug' => $slug));
            return $query->row_array();
    }
    
    
    public function set_news()
    {
        $this->load->helper('url');

        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'text' => $this->input->post('text')
        );

        if($this->db->insert('sp16_news', $data))
        {//good data, show record!
            //get id number of last inserted record
            $id = $this->db->insert_id();

            $query = $this->db->get_where('sp16_news', array('id' => $id));
            return $query->row_array();
 
        }else{//bad data?  feedback!
            echo "Oh oh!!";
            die;
        }
        
        
        //return $this->db->insert('sp16_news', $data);
    }

}

