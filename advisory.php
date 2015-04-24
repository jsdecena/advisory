<?php
/*
*
* Author: Jeff Simons Decena @2013
*
*/

if (!defined('_PS_VERSION_'))
	exit;

class Advisory extends Module
{

	public function __construct()
	{
	$this->name 					= 'advisory';
	$this->tab 						= 'front_office_features';
	$this->version 					= '0.1';
	$this->author 					= 'Jeff Simons Decena';
	$this->need_instance 			= 0;
	$this->ps_versions_compliancy 	= array('min' => '1.5', 'max' => '1.6');

	parent::__construct();

	$this->adTable 					= 'advisory';
	$this->moduleUrl 				= $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name;	

	$this->displayName = $this->l('ADVISORY Module');
	$this->description = $this->l('ADVISORY configuration module');

	$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

	if (!Configuration::get('ADVISORY'))      
	  $this->warning = $this->l('No name provided');
	}

	public function install()
	{
	  return parent::install() &&
	  	Configuration::updateValue('ADVISORY', 'ADVISORY MODULE') &&
	  	$this->registerHook('footer') &&
	  	$this->registerHook('top');
	}	

	public function uninstall()
	{
	  return parent::uninstall() && 
	  	Configuration::deleteByName('ADVISORY');
	}

	public function getContent()
	{
		$this->context->smarty->assign(array(
			'url'		=> $this->moduleUrl
		));

		switch (Tools::getValue('page')) {
			case 'add':
				
				$this->context->smarty->assign(array(
					'action' 	=> $this->actionCreateAdvisory()
				));			

				return $this->display(__FILE__, 'views/templates/actions/add.tpl');

				break;

			case 'update':

				$advisory = $this->getSingleAdvisory(Tools::getValue('id'));

				$this->context->smarty->assign(array(
					'action' 	=> $this->actionUpdateAdvisory(),
					'advisory'	=> $advisory[0]
				));			

				return $this->display(__FILE__, 'views/templates/actions/update.tpl');

				break;

			case 'delete':

				$this->actionDeleteAdvisory();			
				
				break;
			
			default:

				$this->context->smarty->assign(array(
					'records' 	=> $this->getAllAdvisories()
				));			

				return $this->display(__FILE__, 'views/templates/actions/view.tpl');

				break;
		}
	}

	public function hookTop()
	{
		$results = $this->getActiveAdvisory();

		$title = null;
		foreach ($results as $result) {
			$title 	= $result['title'];
			$param 	= array('id'=>$result['id'], 'content_only' => true);
			$link 	= $this->context->link->getModuleLink('advisory', 'view', $param);
		}

		$this->context->smarty->assign(array(
			'url' 		=> $link,
			'advisory' 	=> $title
		));

		return $this->display(__FILE__, 'advisory.tpl');
	}

	public function hookFooter()
	{
		$this->context->controller->addJS($this->_path.'advisory.js');
	}

	public function getAllAdvisories()
	{
		$sql = '
				SELECT *
				FROM '._DB_PREFIX_.$this->adTable.'
		';

		$records = Db::getInstance()->executeS($sql);

		return $records;
	}

	public function actionCreateAdvisory()
	{
		if (Tools::isSubmit('action_add')) {
			//VALIDATE THE FIELDS
			if (strlen(Tools::getValue('title')) == 0) {
				$this->context->smarty->assign(array(
					'error' => Tools::displayError('The title field must not be empty.')
				));
			}else{

				$data = array(
					'title' 		=> Tools::getValue('title'),
					'description' 	=> Tools::getValue('description'),
					'active' 		=> Tools::getValue('active')
				);

				if ($data['active'] == 1) {

					$updateData = array('active' => 0);

					//UPDATE ALL THE OTHER ACTIVE ADVISORY TO INACTIVE
					Db::getInstance()->update($this->adTable, $updateData, 'active=1');
				}

				//PROCEED WITH THE ADD
				if(Db::getInstance()->insert($this->adTable, $data))
					Tools::redirectAdmin($this->moduleUrl);
				else{
					$this->context->smarty->assign(array(
						'error' 	=> 'We have problem creating the advisory.'
					));					
				}
			}
		}
	}

	public function actionUpdateAdvisory()
	{
		//PROCEED WITH THE UPDATE ONLY WHEN THE SUBMIT BUTTON IS CLICKED
		if (Tools::isSubmit('action_update')) {

			$data = array(
				'title' 		=> Tools::getValue('title'),
				'description' 	=> Tools::getValue('description'),
				'active' 		=> Tools::getValue('active')
			);

			if ($data['active'] == 1) {

				$updateData = array('active' => 0);
				//UPDATE ALL THE OTHER ACTIVE ADVISORY TO INACTIVE
				Db::getInstance()->update($this->adTable, $updateData, 'active=1');
			}		

			//UPDATE ALL THE OTHER ACTIVE ADVISORY TO INACTIVE
			if(Db::getInstance()->update($this->adTable, $data, 'id=' . Tools::getValue('id')))
				Tools::redirectAdmin($this->moduleUrl);
			else {
				$this->context->smarty->assign(array(
					'error' 	=> 'We have problem updating the advisory.'
				));				
			}
		}
	}

	public function actionDeleteAdvisory()
	{
		//UPDATE ALL THE OTHER ACTIVE ADVISORY TO INACTIVE
		if(Db::getInstance()->delete($this->adTable, 'id = ' . Tools::getValue('id')))
			Tools::redirectAdmin($this->moduleUrl . '&success=1&message=' . urlencode('You have successfully deleted the advisory.'));
		else {
			$this->context->smarty->assign(array(
				'error' 	=> 'We have problem deleting the advisory.'
			));				
		}
	}	

	public function getSingleAdvisory($id)
	{
		$sql = '
				SELECT *
				FROM '._DB_PREFIX_.$this->adTable.' AS a
				WHERE a.id = ' . $id;

		$records = Db::getInstance()->executeS($sql);

		return $records;
	}

	public function getActiveAdvisory()
	{
		$sql = '
				SELECT *
				FROM '._DB_PREFIX_.$this->adTable.' AS a
				WHERE a.active = 1';

		$records = Db::getInstance()->executeS($sql);

		return $records;
	}	
}