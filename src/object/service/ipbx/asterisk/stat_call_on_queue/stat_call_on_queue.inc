<?php

#
# XiVO Web-Interface
# Copyright (C) 2012  Avencall
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#

xivo_service_asterisk::required(array('abstract','abstract.inc'),true);

class xivo_service_asterisk_stat_call_on_queue extends xivo_service_asterisk_abstract
{
	protected $_dso		= null;
	protected $_name		= 'stat_call_on_queue';
	protected $_filter		= false;
	protected $_queuefeatures	= null;
	protected $_stat_queue	= null;

	public function __construct(&$sre,&$dso)
	{
		if(is_object($sre) === false)
			trigger_error('Invalid service in '.__CLASS__,E_USER_ERROR);

		if(is_object($dso) === false)
			trigger_error('Invalid datastorage in '.__CLASS__,E_USER_ERROR);

		$this->_sre = &$sre;
		$this->_dso = &$dso;

		$this->_queuefeatures = $this->_sre->get_module('queuefeatures');
		$this->_stat_queue = $this->_sre->get_module('stat_queue');
	}

	function get_count_under_qos($interval, $queuefeatures_id, $qos)
	{
		$queuefeatures_name = $this->_queuefeatures->name_from_id($queuefeatures_id);
		$queue_id = $this->_stat_queue->id_from_name($queuefeatures_name);

		$result = $this->_dso->queue_count_under_qos($qos, $interval, $queue_id);

		return $result;
	}
}

?>