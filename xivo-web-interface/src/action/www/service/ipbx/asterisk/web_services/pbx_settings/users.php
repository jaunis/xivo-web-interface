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

$access_category = 'pbx_settings';
$access_subcategory = 'users';

include(dwho_file::joinpath(dirname(__FILE__),'..','_common.php'));

$act = $_QRY->get('act');

switch($act)
{
	case 'view':
		$appuser = &$ipbx->get_application('user');

		$nocomponents = array('exten'		=> true);

		if(($info = $appuser->get($_QRY->get('id'),
					  null,
					  null, // we search in both internal and non-internal users
					  false,
						$nocomponents)) === false
		)
		{
			$http_response->set_status_line(404);
			$http_response->send(true);
		}

		$_TPL->set_var('info',$info);
		break;
	case 'add':
		$appuser = &$ipbx->get_application('user');

		if(($userid = $appuser->add_from_json()) !== false)
		{
			$status = 200;
			$_TPL->set_var('list',$userid);
		}
		else
		{
			dwho_error_log(array_merge($appuser->get_error(), dwho_report::get('error')));
			$http_response->set_status_line(400);
			$http_response->send(true);
		}
		break;
	case 'edit':
		$appuser = &$ipbx->get_application('user');

		if(($user = $appuser->get($_QRY->get('id'),
										 null,
										 false,
										 array('entity' => true))) === false)
				 $status = 404;

		else if($appuser->edit_from_json($user) === true)
			$status = 200;
		else
			$status = 400;

		dwho_error_log($appuser->get_error(), $status);

		$http_response->set_status_line($status);
		$http_response->send(true);
		break;
	case 'import':
		$appuser = &$ipbx->get_application('user');

		if($appuser->import_from_csv() === true)
			$status = 200;
		else
			$status = 400;

		dwho_error_log($appuser->get_error(), $status);

		$http_response->set_status_line($status);
		$http_response->send(true);
		break;
	case 'delete':
		$appuser = &$ipbx->get_application('user');

		if($appuser->get($_QRY->get('id')) === false)
			$status = 404;
		else if($appuser->delete() === true)
			$status = 200;
		else
			$status = 500;

		dwho_error_log($appuser->get_error(), $status);

		$http_response->set_status_line($status);
		$http_response->send(true);
		break;
	case 'deleteall':
		$appuser = &$ipbx->get_application('user');

		if(($list = $appuser->get_users_list()) === false
		|| ($nb = count($list)) === 0)
		{
			$http_response->set_status_line(204);
			$http_response->send(true);
		}
		for ($i=0; $i<$nb; $i++)
		{
			$ref = &$list[$i];
			$appuser->get($ref['id']);
			$appuser->delete();
		}
		$status = 200;

		$http_response->set_status_line($status);
		$http_response->send(true);
		break;
	case 'search':
		$appuser = &$ipbx->get_application('user',null,false);

		if(($list = $appuser->get_users_search($_QRY->get('search'))) === false)
		{
			$http_response->set_status_line(204);
			$http_response->send(true);
		}

		$_TPL->set_var('list',$list);
		break;
	case 'list':
	default:
		$act = 'list';

		$appuser = &$ipbx->get_application('user',null,false);

		if(($list = $appuser->get_users_list()) === false)
		{
			$http_response->set_status_line(204);
			$http_response->send(true);
		}

		$_TPL->set_var('list',$list);
}

$_TPL->set_var('act',$act);
$_TPL->set_var('sum',$_QRY->get('sum'));
$_TPL->display('/service/ipbx/'.$ipbx->get_name().'/generic');

?>
