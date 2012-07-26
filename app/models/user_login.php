<?php
class UserLogin extends AppModel
{
    public $name = 'UserLogin';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        )
    );
    function insertUserLogin($user_id)
    {
        $this->data['UserLogin']['user_id'] = $user_id;
        $this->data['UserLogin']['user_login_ip'] = $_SERVER['REMOTE_ADDR'];
        $this->data['UserLogin']['dns'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $this->data['UserLogin']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $this->save($this->data);
        $this->updateUserLanguage();
   
    }
    function updateUserLanguage()
    {
        $language = $this->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $_SESSION['Auth']['User']['id'],
            ) ,
            'fields' => array(
                'Language.iso2'
            ) ,
            'recursive' => 0
        ));
        if (!empty($language['Language']['iso2'])) {
            App::import('Core', 'ComponentCollection');
            $collection = new ComponentCollection();
            App::import('Component', 'Cookie');
            $objCookie = new CookieComponent($collection);
            $objCookie->write('user_language', $language['Language']['iso2'], false);
        }
    }
    function afterSave($created)
    {
        $this->User->updateAll(array(
            'User.last_login_ip' => '\'' . $_SERVER['REMOTE_ADDR'] . '\'',
            'User.last_logged_in_time' => '\'' . date('Y-m-d H:i:s') . '\'',
            'User.dns' => '\'' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . '\'',
        ) , array(
            'User.id' => $_SESSION['Auth']['User']['id']
        ));
    }
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
    }
}
?>