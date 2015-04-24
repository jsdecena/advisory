<?php

class AdvisoryViewModuleFrontController extends ModuleFrontController
{
	public $ssl = true;
	public $display_column_left = false;

	/**
	 * @see FrontController::initContent()
	 */
	public function initContent()
	{
		parent::initContent();

		$records = $this->module->getSingleAdvisory(Tools::getValue('id'));

		$this->context->smarty->assign(array(
			'records' => $records
		));

		$this->setTemplate('pop.tpl');
	}	
}