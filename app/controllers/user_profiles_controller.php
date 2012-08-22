<?php
class UserProfilesController extends AppController
{
    public $name = 'UserProfiles';
    public $components = array(
        'Email'
    );
    public $permanentCacheAction = array(
        'my_account' => array(
            'is_user_specific_url' => true
        ) ,
        'edit' => array(
            'is_user_specific_url' => true
        )
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'UserAvatar.filename',
            'City.id',
            'State.id'
        );
        parent::beforeFilter();
    }
    public function edit($user_id = null)
    {
        $this->pageTitle = __l('Edit Profile');
        $this->loadModel('EmailTemplate');
        $this->loadModel('Attachment');
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id',
                            'UserProfile.language_id',
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
                $this->request->data['UserProfile']['id'] = $user['UserProfile']['id'];
                if (!empty($user['UserAvatar']['id'])) {
                    $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }
            $this->request->data['UserProfile']['user_id'] = $this->request->data['User']['id'];
            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->request->data);
            }
            $this->UserProfile->set($this->request->data);
            $this->UserProfile->User->set($this->request->data);
            $this->UserProfile->State->set($this->request->data);
            $this->UserProfile->City->set($this->request->data);
            $ini_upload_error = 1;
            if (!empty($this->request->data['UserAvatar']['filename']) && $this->request->data['UserAvatar']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            unset($this->UserProfile->City->validate['City']);
            if ($this->UserProfile->User->validates() & $this->UserProfile->validates() & $this->UserProfile->User->UserAvatar->validates() && $ini_upload_error) {
                if ($this->UserProfile->save($this->request->data)) {
                    $this->UserProfile->User->save($this->request->data['User']);
                    if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                        $this->Attachment->create();
                        $this->request->data['UserAvatar']['class'] = 'UserAvatar';
                        $this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
                        $this->Attachment->save($this->request->data['UserAvatar']);
                    }
              
                }
                $this->Session->setFlash(__l('User Profile has been updated') , 'default', null, 'success');
                if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin and $this->Auth->user('id') != $this->request->data['User']['id'] and Configure::read('user.is_mail_to_user_for_profile_edit')) {
                    // Send mail to user to activate the account and send account details
                    $language_code = $this->UserProfile->getUserLanguageIso($user['User']['id']);
                    $email = $this->EmailTemplate->selectTemplate('Admin User Edit', $language_code);
                    $emailFindReplace = array(
                        '##FROM_EMAIL##' => $this->UserProfile->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                        '##SITE_LINK##' => Router::url('/', true) ,
                        '##USERNAME##' => $user['User']['username'],
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##CONTACT_URL##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'city' => $this->request->params['named']['city'],
                            'admin' => false
                        ) , true) ,
                        '##SITE_LOGO##' => Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'logo-email.png',
                            'admin' => false
                        ) , true) ,
                    );
                    $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                    $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                    $this->Email->to = $user['User']['email'];
                    $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                    $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                    $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                }
            } else {
                if (!empty($this->request->data['UserAvatar']['filename']) && $this->request->data['UserAvatar']['filename']['error'] == 1) {
                    $this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
                }
                $this->Session->setFlash(__l('User Profile could not be updated. Please, try again.') , 'default', null, 'error');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id'
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
                $this->request->data['UserAvatar'] = $user['UserAvatar'];
            }
            //Setting ajax layout when submitting through iframe with jquery ajax form plugin
            if (!empty($this->request->params['form']['is_iframe_submit'])) {
                $this->layout = 'ajax';
            }
        } else {
            unset($this->UserProfile->City->validate['City']);
            if (empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
            $this->request->data = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id,
                    'User.user_type_id !=' => ConstUserTypes::Company
                ) ,
                'fields' => array(
                    'User.user_type_id',
                    'User.username',
                    'User.id',
                    'User.email',
                    'User.user_type_id',
                    'User.user_login_count',
                    'User.user_view_count',
                    'User.is_active',
                    'User.is_email_confirmed',
                    'User.fb_user_id',
                ) ,
                'contain' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.first_name',
                            'UserProfile.last_name',
	                        'UserProfile.gender_id',
                            'UserProfile.address',
                            'UserProfile.country_id',
                            'UserProfile.state_id',
                            'UserProfile.city_id',
                            'UserProfile.zip_code',
                            'UserProfile.dob',
                            'UserProfile.language_id',
                            'UserProfile.user_id',
                            'UserProfile.phone_number',
                            'UserProfile.mobile_number',
                       
                        ) ,
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name'
                            )
                        )
                    )
                ) ,
                'recursive' => 2
            ));
            $this->request->data['UserProfile']['user_id'] = $user_id;
            if (!empty($this->request->data['UserProfile']['City'])) {
                $this->request->data['City']['name'] = $this->request->data['City']['name'] = $this->request->data['City']['name'] = $this->request->data['UserProfile']['City']['name'];
            }
            if (!empty($this->request->data['UserProfile']['State']['name'])) {
                $this->request->data['State']['name'] = $this->request->data['UserProfile']['State']['name'];
            }
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['User']['username'];
        $genders = $this->UserProfile->Gender->find('list');
      
        $countries = $this->UserProfile->Country->find('list', array(
            'order' => array(
                'Country.name' => 'ASC'
            )
        ));
		 $states = $this->UserProfile->State->find('list', array(
            'order' => array(
                'State.name' => 'ASC'
            )
        ));
        $this->set(compact('genders', 'countries', 'states','languages'));
    }
	public function shipping($id = null){
	 
		if(!empty($this->request->data)){
		  if ($this->UserProfile->save($this->request->data)) {
                $this->Session->setFlash(__l('Shipping info has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'shipping',

                ));
            } else {
                $this->Session->setFlash(__l('Shipping info could not be updated. Please, try again.') , 'default', null, 'error');
            }
		
		} else {
			$this->request->data = $this->UserProfile->find('first',array(
								'conditions'=> array(
								'UserProfile.user_id'=> $this->Auth->user('id')
								)
				));
		
		}
		  
        $countries = $this->UserProfile->Country->find('list', array(
            'order' => array(
                'Country.name' => 'ASC'
            )
        ));
		$states = $this->UserProfile->State->find('list', array(
            'order' => array(
                'State.name' => 'ASC'
            )
        ));

        $this->set(compact('states', 'countries'));

	}
	public function shipping_info(){
	 	  $user = $this->UserProfile->find('first',array(
								'conditions'=> array(
								'UserProfile.user_id'=> $this->Auth->user('id')
								)
				));
	$this->set('user',$user);
	}
    public function admin_edit($id = null)
    {
       $this->pageTitle = __l('Edit Profile');
        $this->loadModel('EmailTemplate');
        $this->loadModel('Attachment');
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id',
                            'UserProfile.language_id',
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
                $this->request->data['UserProfile']['id'] = $user['UserProfile']['id'];
                if (!empty($user['UserAvatar']['id'])) {
                    $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }
            $this->request->data['UserProfile']['user_id'] = $this->request->data['User']['id'];
            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->request->data);
            }
            $this->UserProfile->set($this->request->data);
            $this->UserProfile->User->set($this->request->data);
            $this->UserProfile->State->set($this->request->data);
            $this->UserProfile->City->set($this->request->data);
            $ini_upload_error = 1;
            if (!empty($this->request->data['UserAvatar']['filename']) && $this->request->data['UserAvatar']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            unset($this->UserProfile->City->validate['City']);
            if ($this->UserProfile->User->validates() & $this->UserProfile->validates() & $this->UserProfile->User->UserAvatar->validates() && $ini_upload_error) {
                if ($this->UserProfile->save($this->request->data)) {
                    $this->UserProfile->User->save($this->request->data['User']);
                    if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                        $this->Attachment->create();
                        $this->request->data['UserAvatar']['class'] = 'UserAvatar';
                        $this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
                        $this->Attachment->save($this->request->data['UserAvatar']);
                    }
              
                }
                $this->Session->setFlash(__l('User Profile has been updated') , 'default', null, 'success');
                if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin and $this->Auth->user('id') != $this->request->data['User']['id'] and Configure::read('user.is_mail_to_user_for_profile_edit')) {
                    // Send mail to user to activate the account and send account details
                    $language_code = $this->UserProfile->getUserLanguageIso($user['User']['id']);
                    $email = $this->EmailTemplate->selectTemplate('Admin User Edit', $language_code);
                    $emailFindReplace = array(
                        '##FROM_EMAIL##' => $this->UserProfile->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                        '##SITE_LINK##' => Router::url('/', true) ,
                        '##USERNAME##' => $user['User']['username'],
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##CONTACT_URL##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'city' => $this->request->params['named']['city'],
                            'admin' => false
                        ) , true) ,
                        '##SITE_LOGO##' => Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'logo-email.png',
                            'admin' => false
                        ) , true) ,
                    );
                    $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                    $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                    $this->Email->to = $user['User']['email'];
                    $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                    $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                    $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                }
            } else {
                if (!empty($this->request->data['UserAvatar']['filename']) && $this->request->data['UserAvatar']['filename']['error'] == 1) {
                    $this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
                }
                $this->Session->setFlash(__l('User Profile could not be updated. Please, try again.') , 'default', null, 'error');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id'
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
                $this->request->data['UserAvatar'] = $user['UserAvatar'];
            }
            //Setting ajax layout when submitting through iframe with jquery ajax form plugin
            if (!empty($this->request->params['form']['is_iframe_submit'])) {
                $this->layout = 'ajax';
            }
        } else {
            unset($this->UserProfile->City->validate['City']);
			$user_id = $id;
            if (empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
            $this->request->data = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id,
                    'User.user_type_id !=' => ConstUserTypes::Company
                ) ,
                'fields' => array(
                    'User.user_type_id',
                    'User.username',
                    'User.id',
                    'User.email',
                    'User.user_type_id',
                    'User.user_login_count',
                    'User.user_view_count',
                    'User.is_active',
                    'User.is_email_confirmed',
                    'User.fb_user_id',
                ) ,
                'contain' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.first_name',
                            'UserProfile.last_name',
	                        'UserProfile.gender_id',
                            'UserProfile.address',
                            'UserProfile.country_id',
                            'UserProfile.state_id',
                            'UserProfile.city_id',
                            'UserProfile.zip_code',
                            'UserProfile.dob',
                            'UserProfile.language_id',
                            'UserProfile.user_id',
                            'UserProfile.phone_number',
                            'UserProfile.mobile_number',
                       
                        ) ,
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name'
                            )
                        )
                    )
                ) ,
                'recursive' => 2
            ));
            $this->request->data['UserProfile']['user_id'] = $user_id;
            if (!empty($this->request->data['UserProfile']['City'])) {
                $this->request->data['City']['name'] = $this->request->data['City']['name'] = $this->request->data['City']['name'] = $this->request->data['UserProfile']['City']['name'];
            }
            if (!empty($this->request->data['UserProfile']['State']['name'])) {
                $this->request->data['State']['name'] = $this->request->data['UserProfile']['State']['name'];
            }
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['User']['username'];
        $genders = $this->UserProfile->Gender->find('list');
      
        $countries = $this->UserProfile->Country->find('list', array(
            'order' => array(
                'Country.name' => 'ASC'
            )
        ));
		 $states = $this->UserProfile->State->find('list', array(
            'order' => array(
                'State.name' => 'ASC'
            )
        ));
        $this->set(compact('genders', 'countries', 'states','languages'));
    }
    public function admin_user_account($user_id = null)
    {
        if (is_null($user_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->setAction('my_account', $user_id);
    }
    public function my_account($user_id = null)
    {
        if (is_null($user_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->set('user_id', $user_id);
    }
}
?>