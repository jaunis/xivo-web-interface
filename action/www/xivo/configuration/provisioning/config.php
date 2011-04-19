<?php

#
# XiVO Web-Interface
# Copyright (C) 2006-2011  Proformatique <technique@proformatique.com>
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#

$act = isset($_QR['act']) === true ? $_QR['act']  : '';
$page = isset($_QR['page']) === true ? dwho_uint($_QR['page'],1) : 1;

$param = array();
$param['act'] = 'list';

$result = $fm_save = $error = null;

$ipbx = &$_SRE->get('ipbx');	
$provd = &$_XOBJ->get_module('provd');
$provd_config = &$provd->get_module('config');

switch($act)
{
	case 'add':
		$appconfig = &$_XOBJ->get_application('config',null,false);

		if(isset($_QR['fm_send']) === true)
		{
			if($appconfig->set_add($_QR) === false
			|| $appconfig->add() === false)
			{
				$fm_save = false;
				$result = $appconfig->get_result('config');
				$error = $appconfig->get_error('config');
			}
			else
				$_QRY->go($_TPL->url('xivo/configuration/provisioning/config'),$param);
		}

		$_TPL->set_var('info',$result);
		$_TPL->set_var('element',$appconfig->get_elements());
		$_TPL->set_var('territory',dwho_i18n::get_territory_translated_list());
		break;
	case 'edit':
		$appconfig = &$_XOBJ->get_application('config');

		if(isset($_QR['id']) === false || ($info = $appconfig->get($_QR['id'])) === false)
			$_QRY->go($_TPL->url('xivo/configuration/provisioning/config'),$param);

		$return = &$info['config'];

		if(isset($_QR['fm_send']) === true)
		{
			$return = &$result;

			if($appconfig->set_edit($_QR) === false
			|| $appconfig->edit() === false)
			{
				$fm_save = false;
				$result = $appconfig->get_result('config');
				$error = $appconfig->get_error('config');
			}
			else
				$_QRY->go($_TPL->url('xivo/configuration/provisioning/config'),$param);
		}

		$_TPL->set_var('id',$info['config']['id']);
		$_TPL->set_var('info',$return);
		$_TPL->set_var('element',$appconfig->get_elements());
		$_TPL->set_var('territory',dwho_i18n::get_territory_translated_list());
		break;
	case 'delete':
		$param['page'] = $page;

		$appconfig = &$_XOBJ->get_application('config');

		if(isset($_QR['id']) === false || $appconfig->get($_QR['id']) === false)
			$_QRY->go($_TPL->url('xivo/configuration/provisioning/config'),$param);

		$appconfig->delete();

		$_QRY->go($_TPL->url('xivo/configuration/provisioning/config'),$param);
		break;
	case 'deletes':
		$param['page'] = $page;

		if(($values = dwho_issa_val('config',$_QR)) === false)
			$_QRY->go($_TPL->url('xivo/configuration/provisioning/config'),$param);

		$appconfig = &$_XOBJ->get_application('config');

		$nb = count($values);

		for($i = 0;$i < $nb;$i++)
		{
			if($appconfig->get($values[$i]) !== false)
				$appconfig->delete();
		}

		$_QRY->go($_TPL->url('xivo/configuration/provisioning/config'),$param);
		break;
	case 'enables':
	case 'disables':
		$param['page'] = $page;

		if(($values = dwho_issa_val('config',$_QR)) === false)
			$_QRY->go($_TPL->url('xivo/configuration/provisioning/config'),$param);

		$appconfig = &$_XOBJ->get_application('config',null,false);

		$nb = count($values);

		for($i = 0;$i < $nb;$i++)
		{
			if($appconfig->get($values[$i]) === false)
				continue;
			else if($act === 'disables')
				$appconfig->disable();
			else
				$appconfig->enable();
		}

		$_QRY->go($_TPL->url('xivo/configuration/provisioning/config'),$param);
		break;
	default:
		$act = 'list';
		$prevpage = $page - 1;
		$nbbypage = 20;

		$order = array();
		$order['name'] = SORT_ASC;

		$limit = array();
		$limit[0] = $prevpage * $nbbypage;
		$limit[1] = $nbbypage;

		$list = $provd_config->get_config_list($order,$limit);
		#$total = $provd_config->get_cnt();
		$total= count($list);

		if($list === false && $total > 0 && $prevpage > 0)
		{
			$param['page'] = $prevpage;
			$_QRY->go($_TPL->url('xivo/configuration/provisioning/config'),$param);
		}

		$_TPL->set_var('pager',dwho_calc_page($page,$nbbypage,$total));
		$_TPL->set_var('list',$list);
}

$_TPL->set_var('act',$act);
$_TPL->set_var('fm_save',$fm_save);
$_TPL->set_var('error',$error);

$menu = &$_TPL->get_module('menu');
$menu->set_top('top/user/'.$_USR->get_info('meta'));
$menu->set_left('left/xivo/configuration');
$menu->set_toolbar('toolbar/xivo/configuration/provisioning/config');

$_TPL->set_bloc('main','xivo/configuration/provisioning/config/'.$act);
$_TPL->set_struct('xivo/configuration');
$_TPL->display('index');

?>
