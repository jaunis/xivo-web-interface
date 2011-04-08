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

$dundi   = &$ipbx->get_module('dundi');
$general = &$ipbx->get_module('general');

$fm_save = null;
$info = $error = array();

$gen = $general->get(1);

if(isset($_QR['fm_send']) === true && dwho_issa('dundi',$_QR) === true)
{
	$fm_save = true;

	$gen['dundi'] = array_key_exists('general', $_QR) && ($_QR['general']['dundi'] == '1');

	if($dundi->edit(1, $_QR['dundi']) === false
	|| $general->edit(1, $gen)        === false)
	{
			$info['dundi']    = $_QR['dundi'];
			$error['general'] = $dundi->get_filter_error();

			$fm_save = false;
	}
}

if (!array_key_exists('dundi', $info))
	$info['dundi'] = $dundi->get(1);

$info['general'] = $gen;
$general = array('dundi' => array('default' => 0));

$dhtml = &$_TPL->get_module('dhtml');
$dhtml->set_js('js/dwho/submenu.js');

$_TPL->set_var('fm_save',$fm_save);
$_TPL->set_var('element', array('dundi' => $dundi->get_element(), 'general' => $general));
$_TPL->set_var('info',$info);
$_TPL->set_var('error',$error);
$_TPL->set_var('countries',dwho_i18n::get_territory_translated_list());

$menu = &$_TPL->get_module('menu');
$menu->set_top('top/user/'.$_USR->get_info('meta'));
$menu->set_left('left/service/ipbx/'.$ipbx->get_name());

$_TPL->set_bloc('main','service/ipbx/'.$ipbx->get_name().'/general_settings/dundi');
$_TPL->set_struct('service/ipbx/'.$ipbx->get_name());
$_TPL->display('index');

?>