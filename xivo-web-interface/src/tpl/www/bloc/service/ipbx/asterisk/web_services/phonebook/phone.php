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

$xmlphone = &$this->get_module('xmlphone');
$xmlvendor = $xmlphone->factory($this->get_var('vendor'));

if(($vendor = $directory = $xmlvendor->get_vendor()) === false)
	dwho_die('Error/Invalid Vendor and User-Agent');

header($xmlvendor->get_header_contenttype());

switch($vendor)
{
	case 'snom':
	case 'thomson':
	case 'yealink':
	case 'cisco':
		$directory = 'genericxml';
		break;
}

$this->file_include($this->get_var('path').'/'.$directory.'/'.$this->get_var('act'));

?>
