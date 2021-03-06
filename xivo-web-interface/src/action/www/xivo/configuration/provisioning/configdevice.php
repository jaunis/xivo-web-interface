<?php

#
# XiVO Web-Interface
# Copyright (C) 2006-2014  Avencall
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

dwho::load_class('dwho_prefs');
$prefs = new dwho_prefs('provd_config');

$act = isset($_QR['act']) === true ? $_QR['act']  : '';
$search = strval($prefs->get('search', ''));

$param = array();
$param['act'] = 'list';

if($search !== '')
	$param['search'] = $search;

$result = $fm_save = $error = null;

$appprovdconfig = &$_XOBJ->get_application('provdconfig');
$modprovdconfig = &$_XOBJ->get_module('provdconfig');

switch($act)
{
	case 'add':
		if(isset($_QR['fm_send']) === true
		&& dwho_issa('config',$_QR) === true)
		{
			$_QR['config']['X_type'] = 'device';
			if($appprovdconfig->set_add($_QR,'device') === false
			|| $appprovdconfig->add() === false)
			{
				$fm_save = false;
				$result = $appprovdconfig->get_result('config');
				$error = $appprovdconfig->get_error('config');
			}
			else
				$_QRY->go($_TPL->url('xivo/configuration/provisioning/configdevice'),$param);
		}

		$_TPL->set_var('info',$result);
		$_TPL->set_var('element',$appprovdconfig->get_elements());

		$dhtml = &$_TPL->get_module('dhtml');
		$dhtml->set_js('js/dwho/submenu.js');
		$dhtml->set_js('js/service/ipbx/asterisk/devices.js');
		break;
	case 'edit':
		if(isset($_QR['id']) === false || ($info = $appprovdconfig->get($_QR['id'])) === false)
			$_QRY->go($_TPL->url('xivo/configuration/provisioning/configdevice'),$param);

		$info['config'] = array_merge($info['config'],$info['config']['raw_config']);

		if(isset($_QR['fm_send']) === true
		&& dwho_issa('config',$_QR) === true)
		{
			$_QR['config']['X_type'] = 'device';
			if($appprovdconfig->set_edit($_QR,'device') === false
			|| $appprovdconfig->edit() === false)
			{
				$fm_save = false;
				$result = $appprovdconfig->get_result('config');
				$error = $appprovdconfig->get_error('config');
				$info = array_merge($info,$result);
			}
			else
				$_QRY->go($_TPL->url('xivo/configuration/provisioning/configdevice'),$param);
		}

		$_TPL->set_var('id',$info['config']['id']);
		$_TPL->set_var('info',$info);
		$_TPL->set_var('element',$appprovdconfig->get_elements());

		$dhtml = &$_TPL->get_module('dhtml');
		$dhtml->set_js('js/dwho/submenu.js');
		$dhtml->set_js('js/service/ipbx/asterisk/devices.js');
		break;
	case 'delete':
		if(isset($_QR['id']) === false || $appprovdconfig->get($_QR['id']) === false)
			$_QRY->go($_TPL->url('xivo/configuration/provisioning/configdevice'),$param);

		$appprovdconfig->delete();

		$_QRY->go($_TPL->url('xivo/configuration/provisioning/configdevice'),$param);
		break;
	case 'deletes':
		if(($values = dwho_issa_val('configdevice',$_QR)) === false)
			$_QRY->go($_TPL->url('xivo/configuration/provisioning/configdevice'),$param);

		$nb = count($values);

		for($i = 0;$i < $nb;$i++)
		{
			if($appprovdconfig->get($values[$i]) !== false)
				$appprovdconfig->delete();
		}

		$_QRY->go($_TPL->url('xivo/configuration/provisioning/configdevice'),$param);
		break;
	case 'list':
	default:
		$act = 'list';

		$order = array();
		$order['id'] = SORT_ASC;

		if (($list = $appprovdconfig->get_config_list($search,$order,null,false,false,'device')) === false)
			$list = array();

		$_TPL->set_var('list',$list);
		$_TPL->set_var('search',$search);
}

$_TPL->set_var('act',$act);
$_TPL->set_var('fm_save',$fm_save);
$_TPL->set_var('error',$error);

$menu = &$_TPL->get_module('menu');
$menu->set_top('top/user/'.$_USR->get_info('meta'));
$menu->set_left('left/xivo/configuration');
$menu->set_toolbar('toolbar/xivo/configuration/provisioning/configdevice');

$_TPL->set_bloc('main','xivo/configuration/provisioning/configdevice/'.$act);
$_TPL->set_struct('xivo/configuration');
$_TPL->display('index');

?>
