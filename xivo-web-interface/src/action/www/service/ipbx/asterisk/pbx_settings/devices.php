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
$prefs = new dwho_prefs('devices');

$act     = isset($_QR['act']) === true ? $_QR['act'] : '';
$page    = dwho_uint($prefs->get('page', 1));
$search  = strval($prefs->get('search', ''));
$search_column  = strval($prefs->get('search_column', ''));
$sort    = $prefs->flipflop('sort', 'ip');

$param = array();
$param['act'] = 'list';

if($search !== '')
	$param['search'] = $search;

switch($act)
{
	case 'modeautoprov':
		$param['act'] = 'list';
		$appdevice = &$ipbx->get_application('device',null,false);

		if(isset($_QR['id']) === false || ($info = $appdevice->get($_QR['id'])) === false)
			$_QRY->go($_TPL->url('service/ipbx/pbx_settings/devices'),$param);
		elseif ($appdevice->mode_autoprov(true) === false)
			dwho_report::push('error','error_during_reset');
		else
			dwho_report::push('info','successfully_reset');
		$_QRY->go($_TPL->url('service/ipbx/pbx_settings/devices'),$param);
		break;
	case 'mass_synchronize':
		$param['page'] = $page;

		if(($values = dwho_issa_val('devices',$_QR)) === false)
			$_QRY->go($_TPL->url('service/ipbx/pbx_settings/devices'),$param);

		$appdevice = &$ipbx->get_application('device',null,false);

		$nb = count($values);

		$res = array();

		for($i = 0;$i < $nb;$i++)
		{
			if(($info = $appdevice->get($values[$i])) !== false)
			{
				if ($appdevice->is_sccp())
					$status = $ipbx->discuss_ipbx('sccp resync ' . $info['sep'],true);
				else
					$appdevice->synchronize();
			}
		}
		dwho_report::push('info', 'send_mass_synchronize');
		$_QRY->go($_TPL->url('service/ipbx/pbx_settings/devices'),$param);
		break;
	case 'add':
		$appdevice = &$ipbx->get_application('device');
		$modprovdplugin = &$_XOBJ->get_module('provdplugin');

		$plugininstalled = $modprovdplugin->get_plugin_installed();

		$appprovdconfig = &$_XOBJ->get_application('provdconfig');
		$order = array('label' => SORT_ASC);
		$listconfigdevice = $appprovdconfig->get_config_list('',$order,null,false,false,'device');

		$result = $fm_save = $error = null;

		if(isset($_QR['fm_send']) === true
		&& dwho_issa('device',$_QR) === true)
		{
			if($appdevice->set_add($_QR) === false
			|| $appdevice->add() === false)
			{
				$fm_save = false;
				$result = $appdevice->get_result();
				$error = $appdevice->get_error();
			}
			else
				$_QRY->go($_TPL->url('service/ipbx/pbx_settings/devices'),$param);
		}

		$element = $appdevice->get_elements();

		$dhtml = &$_TPL->get_module('dhtml');
		$dhtml->set_js('js/dwho/submenu.js');
		$dhtml->set_js('js/service/ipbx/'.$ipbx->get_name().'/devices.js');

		$_TPL->set_var('info',$result);
		$_TPL->set_var('error',$error);
		$_TPL->set_var('fm_save',$fm_save);
		$_TPL->set_var('plugininstalled',$plugininstalled);
		$_TPL->set_var('listconfigdevice',$listconfigdevice);
		$_TPL->set_var('element',$element);
		break;
	case 'edit':
		$appdevice = &$ipbx->get_application('device');

		if(isset($_QR['id']) === false || ($info = $appdevice->get($_QR['id'])) === false)
			$_QRY->go($_TPL->url('service/ipbx/pbx_settings/devices'),$param);

		$modprovdplugin = &$_XOBJ->get_module('provdplugin');
		$plugininstalled = $modprovdplugin->get_plugin_installed();

		$appprovdconfig = &$_XOBJ->get_application('provdconfig');
		$order = array('label' => SORT_ASC);
		$listconfigdevice = $appprovdconfig->get_config_list('',$order,null,false,false,'device');

		$fm_save = $error = null;

		if(isset($_QR['fm_send']) === true
		&& dwho_issa('device',$_QR) === true)
		{
			if($appdevice->set_edit($_QR) === false
			|| $appdevice->edit() === false)
			{
				$fm_save = false;
				$result = $appdevice->get_result();
				$error = $appdevice->get_error();
				$info = array_merge($info,$result);
			}
			else
				$_QRY->go($_TPL->url('service/ipbx/pbx_settings/devices'),$param);
		}

		$element = $appdevice->get_elements();

		$dhtml = &$_TPL->get_module('dhtml');
		$dhtml->set_js('js/dwho/submenu.js');
		$dhtml->set_js('js/service/ipbx/'.$ipbx->get_name().'/devices.js');

		$_TPL->set_var('id',$_QR['id']);
		$_TPL->set_var('info',$info);
		$_TPL->set_var('error',$error);
		$_TPL->set_var('fm_save',$fm_save);
		$_TPL->set_var('plugininstalled',$plugininstalled);
		$_TPL->set_var('listconfigdevice',$listconfigdevice);
		$_TPL->set_var('element',$element);
		break;
	case 'delete':
		$param['page'] = $page;

		$appdevice = &$ipbx->get_application('device');

		if(isset($_QR['id']) === false || $appdevice->get($_QR['id']) === false)
			$_QRY->go($_TPL->url('service/ipbx/pbx_settings/devices'),$param);

		$appdevice->delete();

		$_QRY->go($_TPL->url('service/ipbx/pbx_settings/devices'),$param);
		break;
	case 'deletes':
		$param['page'] = $page;

		if(($values = dwho_issa_val('devices',$_QR)) === false)
			$_QRY->go($_TPL->url('service/ipbx/pbx_settings/devices'),$param);

		$appdevice = &$ipbx->get_application('device');

		$nb = count($values);

		for($i = 0;$i < $nb;$i++)
		{
			if($appdevice->get($values[$i]) !== false)
				$appdevice->delete();
		}

		$_QRY->go($_TPL->url('service/ipbx/pbx_settings/devices'),$param);
		break;
	case 'list':
	default:
		$act = 'list';
		$prevpage = $page - 1;
		$nbbypage = XIVO_SRE_IPBX_AST_NBBYPAGE;

		$device_api = &$_RAPI->get_ressource('device');

		$order = array();
		if($sort[1] == 'ip')
			$order['ip'] = $sort[0];
		else
			$order[$sort[1]] = $sort[0];

		$limit = array();
		$limit[0] = $prevpage * $nbbypage;
		$limit[1] = $nbbypage;

		$list = $device_api->find_all($search,$order,$limit,$search_column);
		$total = $device_api->get_total();

		if($list === false && $total > 0 && $prevpage > 0)
		{
			$param['page'] = $prevpage;
			$_QRY->go($_TPL->url('service/ipbx/pbx_settings/devices'),$param);
		}

		$_TPL->set_var('pager',dwho_calc_page($page,$nbbypage,$total));
		$_TPL->set_var('list',$list);
		$_TPL->set_var('search',$search);
		$_TPL->set_var('sort',$sort);
		$_TPL->set_var('search_column',$search_column);

		$dhtml = &$_TPL->get_module('dhtml');
		$dhtml->set_js('js/service/ipbx/'.$ipbx->get_name().'/devices.js');
}

$_TPL->set_var('act',$act);

$menu = &$_TPL->get_module('menu');
$menu->set_top('top/user/'.$_USR->get_info('meta'));
$menu->set_left('left/service/ipbx/'.$ipbx->get_name());
$menu->set_toolbar('toolbar/service/ipbx/'.$ipbx->get_name().'/pbx_settings/devices');

$_TPL->set_bloc('main','service/ipbx/'.$ipbx->get_name().'/pbx_settings/devices/'.$act);
$_TPL->set_struct('service/ipbx/'.$ipbx->get_name());
$_TPL->display('index');

?>
