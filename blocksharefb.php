<?php
/**
 * Copyright (C) 2017-2018 thirty bees
 * Copyright (C) 2007-2016 PrestaShop SA
 *
 * thirty bees is an extension to the PrestaShop software by PrestaShop SA.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * @author    thirty bees <modules@thirtybees.com>
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2017-2018 thirty bees
 * @copyright 2007-2016 PrestaShop SA
 * @license   Academic Free License (AFL 3.0)
 * PrestaShop is an internationally registered trademark of PrestaShop SA.
 */

if (!defined('_CAN_LOAD_FILES_'))
	exit;

class blocksharefb extends Module
{
	public function __construct()
	{
		$this->name = 'blocksharefb';
		if(version_compare(_PS_VERSION_, '1.4.0.0') >= 0)
			$this->tab = 'front_office_features';
		else
			$this->tab = 'Blocks';
		$this->version = '2.0.0';
		$this->author = 'thirty bees';

		parent::__construct();

		$this->displayName = $this->l('Block Facebook Share');
		$this->description = $this->l('Allows customers to share products or content on Facebook.');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => '1.6.99.99');
	}

	public function install()
	{
		return (parent::install() AND $this->registerHook('extraLeft'));
	}

	public function uninstall()
	{
		//Delete configuration
		return (parent::uninstall() AND $this->unregisterHook(Hook::getIdByName('extraLeft')));
	}

	public function hookExtraLeft($params)
	{
		global $smarty, $cookie, $link;

		$id_product = Tools::getValue('id_product');

		if (isset($id_product) && $id_product != '')
		{
			$product_infos = $this->context->controller->getProduct();
			$smarty->assign(array(
				'product_link' => urlencode($link->getProductLink($product_infos)),
				'product_title' => urlencode($product_infos->name),
			));

			return $this->display(__FILE__, 'blocksharefb.tpl');
		} else {
			return '';
		}
	}
}
