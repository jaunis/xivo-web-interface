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

require_once('xivo.php');

$go = array_key_exists('go', $_GET)?$_GET['go']:null;

if($_USR->mk_active() === false)
	$_QRY->go($_TPL->url('xivo'), array('go' => urlencode($_SERVER['REQUEST_URI'])));

if(xivo_user::chk_acl(true) === false)
	$_QRY->go($_TPL->url('statistics/call_center'));

$ipbx = &$_SRE->get('ipbx');

$action_path = $_LOC->get_action_path('statistics/call_center',2);

$dhtml = &$_TPL->get_module('dhtml');
$dhtml->set_css('/css/statistics/statistics.css');
$dhtml->set_css('extra-libs/jqplot/jquery.jqplot.css',true);
$dhtml->set_js('extra-libs/jqplot/jquery.jqplot.js',true);
$dhtml->add_js('/struct/js/date.js.php');

if($action_path === false)
	$_QRY->go($_TPL->url('xivo/logoff'), is_null($go)?null:array('go' => $go));

die(include($action_path));

?>
