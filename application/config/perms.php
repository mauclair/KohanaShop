<?php

 $config  = array(     
            'user'=>array(
                        'level'=>0, // minimal level that is allowed                        
                        'allow'=>array('user_id'=>2), // extra allow ... key must be ....  FeX:  user_id => array(1,15,20), group_id => array(10,25), group_name => ''
                        
                     //methods
                    'login' =>array(),
                    'loginAction'=>array(), // empty array means no perms required
                    'no_perms'=>array(),
                    'logout'=>array(),
                    'account'=>array('level'=>255),
                    'account_edit'=>array('level'=>255),
             ),
             'administrace'=> array('level'=>1),
             'adminUser'=>array('level'=>0),
             'admin'=>array('level'=>0),
             'adminVymol'=>array('level'=>0),
    
 );
?>
