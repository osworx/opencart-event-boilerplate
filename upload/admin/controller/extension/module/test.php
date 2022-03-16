<?php
/**
 * @version		$Id: test.php 2022-3-14 21:21Z mic $
 * @package		Boilerplate for event in OpenCart 3.x
 * @author		mic - https://osworx.net
 * @copyright		2022 OSWorX
 * @license		MIT https://opensource.org/licenses/MIT
 */

class ControllerExtensionModuleTest extends Controller
{
	public $_version	= '1.0.0';

	private $_extension	= 'module_test';
	private $_route		= 'extension/module/test';
	private $_model		= 'extension_module_test';
	private $error		= [];

	/**
	 * section 1:
	 * first functions here are the event(s) which called later
	 */

	/**
	 * what it does:	event to be called after creating a new user to send an email to this user
	 * event values:
	 * code:    		ox_test_admin_add_user	unique identifier
	 * trigger: 		admin/model/user/user	which action trigger the action
	 * action:  		extension/module/test/eventModelCustomerCustomerAddCustomerAfter
	 *
	 * @param string    $route      the current called route, not used here
	 * @param array     $args       array with all needed values
	 * @param string    $output     not used here (=parsed template) - only available when after method is used
	 */
	public function eventModelCustomerCustomerAddCustomerAfter( &$route, &$args, &$output = null ) {
		// check if extension is enabled
		if( $this->config->get( $this->_extension . '_status' ) ) {
			// check if variable is set and check
			if( !empty( $args[0]['email'] ) && filter_var( $args[0]['email'], FILTER_VALIDATE_EMAIL ) ) {
				// load first language
				$this->load->language( $this->_route );
				// assign then the values
				$store_name	= html_entity_decode( $this->config->get( 'config_name' ), ENT_QUOTES, 'UTF-8' );
				$subject	= sprintf( $this->language->get( 'text_subject' ), $args[0]['firstname'], $args[0]['lastname'] );
				$body		= sprintf( $this->language->get( 'text_body' ), $store_name, HTTPS_SERVER, $args[0]['username'], $args[0]['password'], $store_name, HTTPS_SERVER );

				// call the mail class and init
				$mail = new \Mail( $this->config->get( 'config_mail_engine' ) );
				$mail->parameter	= $this->config->get( 'config_mail_parameter' );
				$mail->smtp_hostname	= $this->config->get( 'config_mail_smtp_hostname' );
				$mail->smtp_username	= $this->config->get( 'config_mail_smtp_username' );
				$mail->smtp_password	= html_entity_decode( $this->config->get( 'config_mail_smtp_password' ), ENT_QUOTES, 'UTF-8' );
				$mail->smtp_port	= $this->config->get( 'config_mail_smtp_port' );
				$mail->smtp_timeout	= $this->config->get( 'config_mail_smtp_timeout' );
				// set values
				$mail->setTo( trim( $this->request->post['email'] ) );
				$mail->setFrom( $this->config->get( 'config_email' ) );
				$mail->setSender( $store_name );
				$mail->setSubject( html_entity_decode( $subject, ENT_QUOTES, 'UTF-8' ) );
				// we use html and text
				$mail->setHtml( $body );
				$mail->setText( str_replace( '<br>', "\n", $body ) );
				// send finally the email
				$mail->send();
			}
		}
	}

	/**
	 * section 2: installer and uninstaller
	 * both are automatically called whenever this extension is installed - or uninstalled
	 * call inside all further functions (within this controller) or from the associated model (if it exists)
	 * to add e.g. events, create new database tables, remove or change database tables and values, etc.
	 */

	/**
	 * install this module
	 * options are:
	 * - add tables if used
	 * - add events if used
	 * - set user permissions (only if required, because the main installer will do this automatically)
	 */
	public function install() {
		// a model is not always used, if - load it and call
		// $this->load->model( $this->_route );
		// $this->{$this->_model}->checkTables();

		// normally when a model is used, add events via the model
		// $this->{$this->_model}->checkEvents();

		// here we have only this controller, therefore we do it here
		$this->checkEvents();
	}

	/**
	 * uninstall this module
	 * options are:
	 * - remove tables if set
	 * - remove events if used
	 * - unset user permissions
	 */
	public function uninstall() {
		// if a model is used, load it and call
		// $this->load->model( $this->_route );
		// $this->{$this->_model}->deleteTables();

		// here again, when model exists - remove events there
		// $this->{$this->_model}->deleteEvents();

		// here we have only this controller, therefore we do it here
		$this->removeEvents();
	}

	/**
	 * main function - is always called when no function explecitely is called
	 * purpose:
	 * - load language file(s)
	 * - load database data (if used)
	 * - assign several variables (if used and required)
	 * - build breadcumbs
	 * - get sub templates (like header, footer, etc.)
	 */
	public function index() {
		// load associated language variables - automatically assigned to the $data array
		$this->load->language( $this->_route );

		// if request comes from the form, check permission and store values
		// otherwise assign error message
		if( $this->request->server['REQUEST_METHOD'] == 'POST' ) {
			if( $this->checkPermission() ) {
				$this->saveConfig();
				$this->session->data['success'] = $this->language->get( 'text_success' );
			}else{
				$this->session->data['error'] = implode( '<br>', $this->error );
			}

			// redirects directly to the form (form must have an "apply" button)
			if( isset( $this->request->post['mode'] ) ) {
				$this->response->redirect( $this->url->link( $this->_route, '&user_token=' . $this->session->data['user_token'], true ) );
			}

			// standard redirect (when form has no "apply button")
			$this->response->redirect( $this->url->link( $this->_route, '&user_token=' . $this->session->data['user_token'], true ) );
		}

		// set the documents title
		$this->document->setTitle( $this->language->get( 'heading_title' ) );

		// get warning and error messages
		$data['error_warning']	= '';
		$data['success']	= '';

		if( isset( $this->error['warning'] ) ) {
			$data['error_warning'] = $this->error['warning'];
		}

		if( isset( $this->session->data['success'] ) ) {
			$data['success'] = trim( $this->session->data['success'], '<br>' );
			unset( $this->session->data['success'] );
		}

		if( isset( $this->session->data['error'] ) ) {
			$data['error_warning'] = $this->session->data['error'];
			unset( $this->session->data['error'] );
		}

		// define the 2 action buttons, note: apply is done inside the template via javascript
		$data['action']	= $this->url->link( $this->_route, 'user_token=' . $this->session->data['user_token'], true );
		$data['cancel']	= $this->url->link( 'extension/extension/module', 'user_token=' . $this->session->data['user_token'], true );

		// add / define here further values we need in the template
		$data['_route']		= $this->_route;
		$data['user_token']	= $this->session->data['user_token'];

		// get config values
		$this->getConfig( $data );
		// get breadcumbs
		$this->getBreadCrumbs( $data );
		// get template children
		$this->getChildren( $data );
		// assign data to template and output the parsed template
		$this->response->setOutput( $this->load->view( $this->_route, $data ) );
	}

	/**
	 * load default / config values
	 * define them here as pairs: varable name - base value
	 * note: by using a function, it is much easier when new values are added later
	 * also we loop through only once instead of repeating the same code many times
	 *
	 * @param array		$data	data values assigned by reference
	 */
	private function getConfig( &$data ) {
		$vars = [
			'status'		=> 0,	// integer -  general module status
			'second'		=> 1,	// integer -  second value
			// add here further variables and base values
			// for example:
			// 'text_id'	=> 0,	// integer - id of an information text
			// 'text'		=> [],	// array - an array of all possible texts for to use in shop
			// 'position'	=> 'bottom',	// text - position of somewhat
			// an array with values
			// 'design'		=> [
			//	'use_icon'	=> 0,
			//	'opacity'	=> 0.3
			// ],
		];

		// loop through values and assign variable name and base value (or already stored) to the array $cfg
		// note: if new values are added later above, they will be automatically added correct
		foreach( $vars as $k => $v ) {
			if( isset( $this->request->post['cfg'][$k] ) ) {
				$data['cfg'][$k] = $this->request->post['cfg'][$k];
			}elseif( !is_null( $this->config->get( $this->_extension . '_' . $k  ) ) ) {
				if( is_array( $v ) ) {
					$data['cfg'][$k] = array_replace_recursive( $v, (array) $this->config->get( $this->_extension . '_' . $k  ) );
				}else{
					$data['cfg'][$k] = $this->config->get( $this->_extension . '_' . $k  );
				}
			}else{
				$data['cfg'][$k] = $v;
			}
		}

		// unset the array and empty space
		unset( $vars );
	}

	/**
	 * edit/update setting values
	 *
	 * note: using an array will prevent us from unneded variables and values to assign
	 */
	private function saveConfig() {
		$this->load->model( 'setting/setting' );
		$data = [];

		foreach( $this->request->post['cfg'] as $k => $v ) {
			$data[$this->_extension . '_' . $k] = $v;
		}

		$this->model_setting_setting->editSetting( $this->_extension, $data );
	}

	/**
     * build breadcrumbs
	 * note: the language (file) is already called in parent funtion, so no ned to do it again
	 * here 2 breadcrumbs are assigned: Home > Name-of-extension-group > Title-of-extension
	 *
	 * @param array		$data		handover as reference
     */
	private function getBreadCrumbs( &$data ) {
    	$data['breadcrumbs'] = [
			[
				'text'	=> $this->language->get( 'text_home' ),
				'href'	=> $this->url->link( 'common/dashboard', 'user_token=' . $this->session->data['user_token'], true )
			],
			[
				'text'	=> $this->language->get( 'text_extension' ),
				'href'	=> $this->url->link( 'extension/extension&type=module', 'user_token=' . $this->session->data['user_token'], true )
			],
			[
				'text'	=> $this->language->get( 'heading_title' ),
				'href'	=> $this->url->link( $this->_route, 'user_token=' . $this->session->data['user_token'], true )
			]
		];
	}

	/**
	 * build children (templates)
	 * load every needed subtemplate and assign to data array
	 * note: using a function like that will avoid to repeat same code again
	 * and if later a new design position is added, just (1) line has to be added below
	 *
	 * @param array		$data		handover as reference
	 */
	private function getChildren( &$data ) {
		$data += [
			'header'		=> $this->load->controller( 'common/header' ),
			'column_left'	=> $this->load->controller( 'common/column_left' ),
			'footer'		=> $this->load->controller( 'common/footer' )
		];
	}

	/**
	 * check user permission (based on defined settings in Menu > Usergroup)
	 * note: because language (file) is already called in parent function, no need to do it here again
	 *
	 * @param string	$type	modify (standard) | access
	 * @return bool
	 */
	private function checkPermission( $type = 'modify' ) {
		if( !$this->user->hasPermission( $type, $this->_route ) ) {
			$this->error['error_permission'] = $this->language->get( 'error_' . $type );
		}

		return !$this->error;
	}

	/**
	 * further function beside basic routines
	 */

	/**
	 * check existing event table
	 * add new event(s) if not already in
	 */
	private function checkEvents() {
		$events = [
			// e.g. catalog (= shop): header data
			/*
			[
				'code'		=> 'test_common_header,
				'trigger'	=> 'catalog/controller/common/header/after',
				'action'	=> '/eventControllerCommonHeaderAfter'
			],
			*/
			// admin
			[
				'code'		=> 'ox_test_admin_add_user',
				'trigger'	=> 'admin/model/user/user',
				'action'	=> '/eventModelCustomerCustomerAddCustomerAfter'
			]
			// add here further parts when needed
		];

		$this->load->model( 'setting/event' );

		foreach( $events as $event ) {
			if( !$res = $this->model_setting_event->getEventByCode( $event['code'] ) ) {
				$this->model_setting_event->addEvent( $event['code'], $event['trigger'], $this->_route . $event['action'] );
			}
		}
	}

	/**
	 * remove existing event(s) (delete all once by code)
	 */
	private function removeEvents() {
		// add here additional event codes when needed
		$events = ['ox_test_admin_add_user'];

		$this->load->model( 'setting/event' );

		foreach( $events as $event ) {
			$this->model_setting_event->deleteEventByCode( $event );
		}
	}
}
