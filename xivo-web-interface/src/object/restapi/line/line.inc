<?php
#
# XiVO Web-Interface
# Copyright (C) 2013  Avencall
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

class restapi_ressource_line extends xivo_restapi_ressource_abstract
{

	protected $_name      = 'line';
	protected $_base_url  = 'lines';

	public function __construct($_RAPI, $param=null)
	{
		parent::__construct($_RAPI, $param);
	}

	public function associate_device($line_id, $device_id)
	{
		$uri = $this->_build_uri(array($line_id, 'device'));
		$rs = $this->request_post($uri, array('device_id' => $device_id));

		if($this->_status_code !== 204)
		{
			dwho_report::push('error', 'fail to associate line to the device: '.$rs[0]);
			return(false);
		}

		return(true);
	}

	public function remove_device($line_id)
	{
		$uri = $this->_build_uri(array($line_id, 'device'));
		$rs = $this->request_delete($uri);

		if($this->_status_code !== 204)
		{
			dwho_report::push('error', 'fail to remove device from the line: '.$rs[0]);
			return(false);
		}

		return(true);
	}
}
?>
