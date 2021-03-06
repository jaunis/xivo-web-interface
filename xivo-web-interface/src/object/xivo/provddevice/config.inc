<?php

#
# XiVO Web-Interface
# Copyright (C) 2013-2014  Avencall
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

$array = array();
$array['element'] = array();

$array['element']['mac'] = array();
$array['element']['mac']['default'] = '';

$array['element']['ip'] = array();
$array['element']['ip']['default'] = '';

$array['element']['plugin'] = array();
$array['element']['plugin']['default'] = '';

$array['element']['config'] = array();
$array['element']['config']['default'] = '';

$array['element']['sn'] = array();
$array['element']['sn']['default'] = '';

$array['element']['vendor'] = array();
$array['element']['vendor']['default'] = '';

$array['element']['model'] = array();
$array['element']['model']['default'] = '';

$array['element']['proto'] = array();
$array['element']['proto']['default'] = '';

$array['element']['version'] = array();
$array['element']['version']['default'] = '';

$array['element']['configured'] = array();
$array['element']['configured']['value'] = array(0,1);
$array['element']['configured']['default'] = 0;
$array['element']['configured']['set'] = true;


$array['filter'] = array();
$array['filter']['config'] = array('set' => false,'chk' => 2,'regexp' => '/^[a-z0-9_-]+$/','minlen' => 1,'maxlen' => 32);
$array['filter']['plugin'] = array('set' => false,'chk' => 2,'minlen' => 1,'maxlen' => 64);
$array['filter']['ip'] = array('set' => false,
							'chk' => 2,
							'callback' => 'dwho_network::valid_host',
							'callbackarg' => array(DWHO_NETWORK_HOST_IPV4_DOTDEC));
$array['filter']['mac'] = array('set' => false,
							'chk' => 2,
							'regexp' => '/^(?:[A-F0-9]{2}:){5}(?:[A-F0-9]{2})$/i');
$array['filter']['sn'] = array('set' => false,'chk' => 2,'minlen' => 1,'maxlen' => 64);
$array['filter']['vendor'] = array('set' => false,'chk' => 2,'minlen' => 1,'maxlen' => 32);
$array['filter']['model'] = array('set' => false,'chk' => 2,'minlen' => 1,'maxlen' => 32);
$array['filter']['version'] = array('set' => false,'chk' => 2,'minlen' => 1,'maxlen' => 32);
$array['filter']['proto'] = array('set' => false,'chk' => 2,'key' => array('sip'));
$array['filter']['configured'] = array('bool' => true);

?>
