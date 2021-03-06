<?php
class User extends AppModel
{
    public $name = 'User';
    public $displayField = 'username';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'username'
            )
        ) ,
    );
    public $belongsTo = array(
        'UserType' => array(
            'className' => 'UserType',
            'foreignKey' => 'user_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
 	
     );
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $hasMany = array(
        'UserView' => array(
            'className' => 'UserView',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
      'UserShipping' => array(
            'className' => 'UserShipping',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
	    'BeautyTip' => array(
            'className' => 'BeautyTip',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
	    'Brand' => array(
            'className' => 'Brand',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'UserLogin' => array(
            'className' => 'UserLogin',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Subscription' => array(
            'className' => 'Subscription',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        ), 
       'PackageUser' => array(
            'className' => 'PackageUser',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
     'BeautyProfile' => array(
            'className' => 'BeautyProfile',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
		
		'ProductSurvey' => array(
            'className' => 'ProductSurvey',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
		
		
		'WonderSpree' => array(
            'className' => 'WonderSpree',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
	
    );
    public $hasOne = array(
        'UserProfile' => array(
            'className' => 'UserProfile',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
       
        'UserAvatar' => array(
            'className' => 'UserAvatar',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'UserAvatar.class' => 'UserAvatar',
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'CkSession' => array(
            'className' => 'CkSession',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'user_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'message' => __l('Required')
                )
            ) ,
           'username' => array(
                'rule5' => array(
                    'rule' => array(
                        'between',
                        3,
                        20
                    ) ,
                    'message' => __l('Must be between of 3 to 20 characters')
                ) ,
                'rule4' => array(
                    'rule' => 'alphaNumeric',
                    'message' => __l('Must be a valid character')
                ) ,
                'rule3' => array(
                    'rule' => 'isUnique',
                    'message' => __l('Username is already exist')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'custom',
                        '/^[a-zA-Z]/'
                    ) ,
                    'message' => __l('Must be start with an alphabets')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
           'email' => array(
                'rule3' => array(
                    'rule' => 'isUnique',
                    'message' => __l('Email address is already exist')
                ) ,
                'rule2' => array(
                    'rule' => 'email',
                    'message' => __l('Must be a valid email')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'passwd' => array(
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'old_password' => array(
                'rule3' => array(
                    'rule' => array(
                        '_checkOldPassword',
                        'old_password'
                    ) ,
                    'message' => __l('Your old password is incorrect, please try again')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'confirm_password' => array(
                'rule3' => array(
                    'rule' => array(
                        '_checkPassword',
                        'passwd',
                        'confirm_password'
                    ) ,
                    'message' => __l('New and confirm password field must match, please try again')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'captcha' => array(
                'rule2' => array(
                    'rule' => '_isValidCaptcha',
                    'message' => __l('Please enter valid captcha')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'is_agree_terms_conditions' => array(
                'rule' => array(
                    'equalTo',
                    '1'
                ) ,
                'message' => __l('You must agree to the terms and policies')
            ) ,
            'message' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'subject' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'city' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'amount' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,    
			'friends_email' => array(
                'rule2' => array(
                    'rule' => '_checkMultipleEmail',
                    'message' => __l('Must be a valid email')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ),
			'available_wonder_points' => array(
                 'rule2' => array(
                    'rule' => array(
                        'comparison',
                        '>',
                        0
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Should be greater than 0')
                ) ,
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            ),  
			'transaction_type' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'message' => __l('Required')
                )
            ) ,
        );
        $this->validateCreditCard = array(
            'firstName' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'lastName' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'creditCardNumber' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Should be numeric') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'expiration_month' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'expiration_year' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'cvv2Number' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Should be numeric') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'zip' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'address' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'city' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'state' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'country' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
        );
        // filter options in admin index
        $this->isFilterOptions = array(
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Active => __l('Active')
        );
        $this->moreActions = array(
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::Delete => __l('Delete') ,
            ConstMoreAction::Export => __l('Export')
        );
        $this->adminMoreActions = array(
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::Export => __l('Export')
        );
        $this->bulkMailOptions = array(
            1 => __l('All Users') ,
            2 => __l('Inactive Users') ,
            3 => __l('Active Users')
        );
    }
	function _checkMultipleEmail()
    {
        $multipleEmails = explode(',', $this->data['User']['friends_email']);
        foreach($multipleEmails as $key => $singleEmail) {
            if (!Validation::email(trim($singleEmail))) {
                return false;
            }
        }
        return true;
    }
    // check the new and confirm password
    function _checkPassword($field1 = array() , $field2 = null, $field3 = null)
    {
        if ($this->data[$this->name][$field2] == $this->data[$this->name][$field3]) {
            return true;
        }
        return false;
    }
    // check the old password field with database
    function _checkOldPassword($field1 = array() , $field2 = null)
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => $_SESSION['Auth']['User']['id']
            ) ,
            'recursive' => - 1
        ));
        if (AuthComponent::password($this->data[$this->name][$field2]) == $user['User']['password']) {
            return true;
        }
        return false;
    }
    // hash for forgot password mail
    function getResetPasswordHash($user_id = null)
    {
        return md5($user_id . '-' . date('y-m-d') . Configure::read('Security.salt'));
    }
    // check the forgot password hash
    function isValidResetPasswordHash($user_id = null, $hash = null)
    {
        return (md5($user_id . '-' . date('y-m-d') . Configure::read('Security.salt')) == $hash);
    }
    // hash for activate mail
    function getActivateHash($user_id = null)
    {
        return md5($user_id . '-' . Configure::read('Security.salt'));
    }
    // check the activate mail
    function isValidActivateHash($user_id = null, $hash = null)
    {
        return (md5($user_id . '-' . Configure::read('Security.salt')) == $hash);
    }
    function getUserIdHash($user_ids = null)
    {
        return md5($user_ids . Configure::read('Security.salt'));
    }
    function isValidUserIdHash($user_ids = null, $hash = null)
    {
        return (md5($user_ids . Configure::read('Security.salt')) == $hash);
    }
    function isAllowed($user_type = null)
    {
        if ($user_type != ConstUserTypes::Company || ($user_type == ConstUserTypes::Company && Configure::read('user.is_company_actas_normal_user'))) {
            return true;
        }
        return false;
    }
	function _sendReminderMail(){
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
		App::import('Core', 'ComponentCollection');
		$collection = new ComponentCollection();
		App::import('Component', 'Email');
		$this->Email = new EmailComponent($collection);	
		$users = $this->find('all', array(
				'conditions'=> array(
					'User.is_verified_user'=> 0 ,
					'User.subscription_expire_date != ' => '0000-00-00' ,
					'User.subscription_expire_date < ' => _formatDate('Y-m-d', date('Y-m-d') , true) ,
					'User.is_email_confirmed'=> 1 ,
					'User.is_active' => 1
				),
				'contain'=> array(
					'UserProfile' => array(
						'fields'=> array(
							'UserProfile.first_name'
						)
					)
				),
				'fields' => array(
					'User.id',
					'User.email',
				),
				'recursive'=> 1
				)
		);
		if(!empty($users)){
			$template = $this->EmailTemplate->selectTemplate('Subscription reminder');
			foreach($users as $user){
				 $emailFindReplace = array(
					'##SITE_LINK##' => Cache::read('site_url_for_shell', 'long') ,
					'##USERNAME##' => $user['UserProfile']['first_name'],
					'##SITE_NAME##' => Configure::read('site.name'),
					'##FROM_EMAIL##' => $this->changeFromEmail(($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from']) ,
					'##SITE_LOGO##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
						'controller' => 'img',
						'action' => 'blue-theme',
						'logo-black.png',
						'admin' => false
					) , false) , 1) ,
					'##SUPPORT_EMAIL##' => Configure::read('site.contact_email') ,
					'##CONTACT_URL##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', 'contactus', 1) ,
					'##CONTACT_LINK##' => "<a href='mailto:" . Configure::read('site.contact_email') . "'>" . Configure::read('site.contact_email') . "</a>",
				);
				$this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from'];
				$this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $template['reply_to'];
				$this->Email->to = $user['User']['email'];
				$this->Email->subject = strtr($template['subject'], $emailFindReplace);
				$this->Email->content = strtr($template['email_content'], $emailFindReplace);
				$this->Email->sendAs = ($template['is_html']) ? 'html' : 'text';
				$this->Email->send($this->Email->content);
			}
		}
	}
	// Send welcome mail to User how purchase the Gift Package
	function _sendWelcomeMailToGiftUser(){
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
		App::import('Core', 'ComponentCollection');
		$collection = new ComponentCollection();
		App::import('Component', 'Email');
		$this->Email = new EmailComponent($collection);	
	    $email = $this->EmailTemplate->selectTemplate('Welcome Email To GiftUser');
		$users = $this->find('all', array(
				'conditions'=> array(
					'User.is_gift_user'=> 1 ,
					'User.is_email_confirmed'=> 1 ,
					'User.is_active' => 1
				),
				'contain'=> array(
					'UserProfile' => array(
						'fields'=> array(
							'UserProfile.first_name'
						)
					)
				),
				'fields' => array(
					'User.id',
					'User.email',
					'User.username',
				),
				'recursive'=> 1
				)
		);
		if(!empty($users)){ 
			foreach($users as $user){
				$user_email =  $user['User']['email'];
				$emailFindReplace = array(
					'##SITE_LINK##' => Router::url('/', true) ,
					'##SITE_NAME##' => Configure::read('site.name') ,
					'##FROM_EMAIL##' => $this->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
					'##USERNAME##' => $user['User']['username'],
					'##SUPPORT_EMAIL##' => Configure::read('site.contact_email') ,
					'##LOGIN_EMAIL##' => $user_email,
					'##PASSWORD##' => Configure::read('gift.login_password'),
					'##SITE_URL##' => Router::url('/', true) ,
					'##CONTACT_URL##' => Router::url(array(
						'controller' => 'contacts',
						'action' => 'add',
						'admin' => false
					) , true) ,
					'##LOGIN_LINK##' => Router::url(array(
						'controller' => 'users',
						'action' => 'login',
						'admin' => false
					) , true),
					'##SITE_LOGO##' => Router::url(array(
						'controller' => 'img',
						'action' => 'blue-theme',
						'logo-email.png',
						'admin' => false
					) , true) ,
				);

				$this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
				$this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
				$this->Email->to = $user_email;
				$this->Email->subject = strtr($email['subject'], $emailFindReplace);
				$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
				$this->Email->send(strtr($email['email_content'], $emailFindReplace));
			}
		}
	}
    function checkUserBalance($user_id = null)
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.available_balance_amount'
            ) ,
            'recursive' => - 1
        ));
        if ($user['User']['available_balance_amount']) {
            return $user['User']['available_balance_amount'];
        }
        return false;
    }
    function _checkamount($amount)
    {
        if (!empty($amount) && !is_numeric($amount)) {
            $this->validationErrors['amount'] = __l('Amount should be Numeric');
        }
        if (empty($amount)) {
            $this->validationErrors['amount'] = __l('Required');
        }
        if (!empty($amount) && $amount < Configure::read('wallet.min_wallet_amount')) {
            $this->validationErrors['amount'] = __l('Amount should be greater than minimum amount');
        }
        if (Configure::read('wallet.max_wallet_amount') && !empty($amount) && $amount > Configure::read('wallet.max_wallet_amount')) {
            $this->validationErrors['amount'] = sprintf(__l('Given amount should lies from  %s%s to %s%s') , Configure::read('site.currency') , Configure::read('wallet.min_wallet_amount') , Configure::read('site.currency') , Configure::read('wallet.max_wallet_amount'));
        }
        return false;
    }
    function checkUsernameAvailable($username)
    {
        $user = $this->find('count', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'recursive' => - 1
        ));
        if (!empty($user)) {
            return false;
        }
        return $username;
    }
    function _getCimObject()
    {
        require_once (APP . 'vendors' . DS . 'CIM' . DS . 'AuthnetCIM.class.php');
        $paymentGateway = $this->Transaction->PaymentGateway->getPaymentSettings(ConstPaymentGateways::AuthorizeNet);
        if (!empty($paymentGateway) && !empty($paymentGateway['PaymentGateway']['authorize_net_api_key']) && !empty($paymentGateway['PaymentGateway']['authorize_net_trans_key'])) {
            if ($paymentGateway['PaymentGateway']['is_test_mode']) {
                $cim = new AuthnetCIM($paymentGateway['PaymentGateway']['authorize_net_api_key'], $paymentGateway['PaymentGateway']['authorize_net_ratns_key'], true);
            } else {
                $cim = new AuthnetCIM($paymentGateway['PaymentGateway']['authorize_net_api_key'], $paymentGateway['PaymentGateway']['authorize_net_trans_key']);
            }
            return $cim;
        }
        return false;
    }
    function _createCimProfile($user_id)
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.email',
                'User.id',
                'User.username'
            ) ,
            'recursive' => - 1
        ));
        $cim = $this->_getCimObject();
        if (!empty($cim) && !empty($user['User']['email'])) {
            $cim->setParameter('email', $user['User']['email']);
            $cim->setParameter('description', 'Profile for ' . $user['User']['username']); // Optional
            $cim->setParameter('merchantCustomerId', $user['User']['id']);
            $cim->createCustomerProfile();
            $profile_id = $cim->getProfileID();
            $this->updateAll(array(
                'User.cim_profile_id' => $profile_id,
            ) , array(
                'User.id' => $user['User']['id']
            ));
        }
    }
    function _createCimPaymentProfile($data)
    {
        $cim = $this->_getCimObject();
        if (!empty($cim)) {
            $cim->setParameter('refId', time());
            $cim->setParameter('billToCompany', Configure::read('site.name'));
            $cim->setParameter('customerProfileId', $data['customerProfileId']);
            $cim->setParameter('billToFirstName', $data['firstName']);
            $cim->setParameter('billToLastName', $data['lastName']);
            $cim->setParameter('billToAddress', $data['address']);
            $cim->setParameter('billToCity', $data['city']);
            $cim->setParameter('billToState', $data['state']);
            $cim->setParameter('billToZip', $data['zip']);
            $cim->setParameter('billToCountry', $data['country']);
            $cim->setParameter('cardNumber', $data['creditCardNumber']);
            $cim->setParameter('cardCode', $data['cvv2Number']);
            $cim->setParameter('expirationDate', $data['expirationDate']);
            $cim->createCustomerPaymentProfile();
            if ($cim->isSuccessful()) {
                $payment_profile_id = $cim->getPaymentProfileId();
                $profile_info = array_reverse(explode(',', $cim->validationDirectResponse()));
                if (end($profile_info) == 1) {
                    $return['payment_profile_id'] = $payment_profile_id;
                    $return['masked_cc'] = $profile_info[16] . ' ' . $profile_info[17];
                } else {
                    $return = $profile_info[3];
                }
            } else {
                $return['message'] = $cim->getResponse();
            }
            return $return;
        }
        return false;
    }
    function _updateCimPaymentProfile($data)
    {
        $cim = $this->_getCimObject();
        if (!empty($cim)) {
            $cim->setParameter('refId', time());
            $cim->setParameter('company', Configure::read('site.name'));
            $cim->setParameter('customerProfileId', $data['customerProfileId']);
            $cim->setParameter('customerPaymentProfileId', $data['customerPaymentProfileId']);
            $cim->setParameter('firstName', $data['firstName']);
            $cim->setParameter('lastName', $data['lastName']);
            $cim->setParameter('address', $data['address']);
            $cim->setParameter('city', $data['city']);
            $cim->setParameter('state', $data['state']);
            $cim->setParameter('zip', $data['zip']);
            $cim->setParameter('country', $data['country']);
            $cim->setParameter('cardNumber', $data['creditCardNumber']);
            $cim->setParameter('expirationDate', $data['expirationDate']);
            $cim->updateCustomerPaymentProfile();
            if ($cim->isSuccessful()) {
                return true;
            } else {
                $return['message'] = $cim->getResponse();
            }
        }
        return false;
    }
    function _deleteCimPaymentProfile($data)
    {
        $cim = $this->_getCimObject();
        if (!empty($cim)) {
            $cim->setParameter('refId', time());
            $cim->setParameter('customerProfileId', $data['customerProfileId']);
            $cim->setParameter('customerPaymentProfileId', $data['customerPaymentProfileId']);
            $cim->deleteCustomerPaymentProfile();
            if ($cim->isSuccessful()) {
                return true;
            }
        }
        return false;
    }
    function _getCimPaymentProfile($data)
    {
        $cim = $this->_getCimObject();
        if (!empty($cim)) {
            $cim->setParameter('refId', time());
            $cim->setParameter('customerProfileId', $data['customerProfileId']);
            $cim->setParameter('customerPaymentProfileId', $data['customerPaymentProfileId']);
            $cim->getCustomerPaymentProfile();
            if ($cim->isSuccessful()) {
                $return = $cim->getPaymentProfile();
            }
            return $return;
        }
        return false;
    }
    function _createCustomerProfileTransaction($data, $type)
    {
        $cim = $this->_getCimObject();
        if (!empty($cim)) {
            $cim->setParameter('refId', time());
            $cim->setParameter('amount', $data['amount']);
            $cim->setParameter('customerProfileId', $data['customerProfileId']);
            $cim->setParameter('customerPaymentProfileId', $data['customerPaymentProfileId']);
            if ($type == 'profileTransAuthOnly') {
                $title = Configure::read('site.name') . ' - Deal Amount Authorize';
                $description = 'Authorize deal amount in ' . Configure::read('site.name');
            } else {
                $title = Configure::read('site.name') . ' - Deal Bought';
                $description = 'Deal Bought in ' . Configure::read('site.name');
            }
            // CIM accept only 30 character in title
            if (strlen($title) > 30) {
                $title = substr($title, 0, 27) . '...';
            }
            $unit_amount = $data['amount'] / $data['quantity'];
            $unit_amount = round($unit_amount, 2);
            $cim->setLineItem($data['deal_id'], $title, $description, $data['quantity'], $unit_amount);
            $cim->createCustomerProfileTransaction($type);
            $response = $cim->getDirectResponse();
            $response_array = explode(',', $response);
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['deal_user_id'] = $data['deal_id'];
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response_text'] = $cim->getResponseText();
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_authorization_code'] = $cim->getAuthCode();
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_avscode'] = $cim->getAVSResponse();
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['transactionid'] = $cim->getTransactionID();
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_amt'] = $response_array[9];
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_gateway_feeamt'] = $response_array[32];
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_cvv2match'] = $cim->getCVVResponse();
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response'] = $response;
            $this->DealUser->AuthorizenetDocaptureLog->save($data_authorize_docapture_log);
            $get_authorize_id = $this->DealUser->AuthorizenetDocaptureLog->getLastInsertId();
            if ($cim->isSuccessful()) {
                $outputResponse['cim_approval_code'] = $cim->getAuthCode();
                $outputResponse['cim_transaction_id'] = $cim->getTransactionID();
                if ($type == 'profileTransAuthCapture') {
                    $outputResponse['capture'] = 1;
                }
                $outputResponse['pr_authorize_id'] = $get_authorize_id;
            } else {
                $outputResponse['message'] = $cim->getResponse();
            }
            return $outputResponse;
        }
        return false;
    }
	function lockuser_status() {
		/* Lock the user status */
       	$this->updateAll(array(
            'User.is_verified_user' => 0
        ) , array(
            'User.is_verified_user'=> 1,
			'User.subscription_expire_date <' => _formatDate('Y-m-d', date('Y-m-d') , true) 
        ));
	}
	public function getShippingAddress($user_id = null){
		$userShipping = $this->UserShipping->find('first', array(
            'conditions' => array(
                'UserShipping.user_id' => $user_id,
            ) ,
            'fields' => array(
                'UserShipping.id',
                	'UserShipping.address',
					'UserShipping.address2',
					'UserShipping.address3',
					'UserShipping.contact_no',
					'UserShipping.contact_no1',
					'UserShipping.zip_code',
            ) ,
            'recursive' => -1
        ));
		return $userShipping['UserShipping']['address'].','.$userShipping['UserShipping']['address2'].','.$userShipping['UserShipping']['address3'].','.$userShipping['UserShipping']['contact_no'].','.$userShipping['UserShipping']['contact_no1'].','.$userShipping['UserShipping']['zip_code'];
	}
}
?>