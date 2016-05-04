<?php
//News.php
class News extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('news_model');
                $this->load->helper('url_helper');
                //global banner for all methods
                $this->config->set_item('banner','Global News Banner');
            
        }

        public function index()
        {
                $data['news'] = $this->news_model->get_news();
                $data['page_id'] = "News";
                $data['title'] = 'News archive';
                $this->load->view('news/index', $data);

        }

    public function view($slug = NULL)
    {
            $data['news_item'] = $this->news_model->get_news($slug);
            $data['page_id'] = "News";

            if (empty($data['news_item']))
            {
                    show_404();
            }

            $data['title'] = $data['news_item']['title'];
            $this->load->view('news/view', $data);
    }
    

    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a news item';
        $data['page_id'] = "News Create";

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE)
        {//no data, show form
            $this->load->view('news/create', $data);
        }
        else
        {//data, so enter add it!
            $slug = $this->news_model->set_news();
            
            if($slug)
            {//data present, load view
                feedback('News item successfully created!','notice');
                redirect('/news/view/' . $slug);
                
            }else{//we have an issue!
                feedback('News item NOT created!','warning');
                redirect('/news/create');
 
            }
            
        }
    }
  
}