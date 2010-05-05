<?php
    class Account_Controller extends My_Controller {
        public $model;
        public $uid;
        
        public function __construct() {
            parent::__construct();
            $this->model = new Vymol_Model();
            $uid = uniqid();
            $t1 =" CREATE TEMPORARY TABLE CI_$uid 
                   SELECT vymol_id, comments, images FROM vymoly
                    LEFT JOIN ( SELECT vymol_id, COUNT( * ) AS comments FROM comments GROUP BY vymol_id )t1 USING ( vymol_id )
                    LEFT JOIN ( SELECT vymol_id, COUNT( * ) AS images FROM image GROUP BY vymol_id )t2 USING ( vymol_id )
                ";
            $this->model->query($t1);

            $this->model->join("CI_$uid", 'vymol_id', 'LEFT JOIN');
            $this->model->orderBy('created DESC');
               //echo $this->model->getQuery();
            $this->uid = $this->session->get('user.user_id');
        }

        public function lastCommented(){
            $this->model->join('comments','vymol_id');
            $this->model->orderBy( 'comments.created DESC');
            $this->model->groupBy = 'vymol_id';
            $this->model->limit(0,20);
           
            $this->_givit();            
        }

        public function lastImaged(){
            $this->model->join('image','vymol_id')->orderBy( 'image_created')->limit(0,20);            
            $this->_givit();
        }

        public function mineCommented(){
            $this->model->where->where('vymoly.user_id',$this->uid);
            $this->model->join('comments','vymol_id');
            $this->model->orderBy('comments.created DESC');
            $this->_givit();
        }

        public function my(){
            $this->model->where->where('user_id',$this->uid);
            
            $this->_givit();
        }

        public function mostRecent(){
            $this->model->limit(0,20);
            $this->_givit();
        }
       
        public function _givit(){
            $holes = $this->model->fetch();
            $this->template->content = View::factory('vymoly/json_holes')->set('holes',$holes)->render();
        }
    }
?>