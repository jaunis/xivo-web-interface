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

$array = array();

$array['ini'] = array();

$array['ini']['error'] = array();
$array['ini']['error']['level'] = 2047;
$array['ini']['error']['report_type'] = 1;
$array['ini']['error']['report_mode'] = 1;
$array['ini']['error']['report_func'] = 1;
$array['ini']['error']['email'] = 'xivo-webinterface-error@proformatique.com';
$array['ini']['error']['file'] = '/var/log/xivo-web-interface/error.log';

$array['ini']['locale'] = array();
$array['ini']['locale']['language'] = 'en';
$array['ini']['locale']['territory'] = 'US';
$array['ini']['locale']['charset'] = 'UTF-8';

$array['ini']['session'] = array();
$array['ini']['session']['name'] = '_eid';
$array['ini']['session']['time'] = 7200;
$array['ini']['session']['path'] = '/';

$array['ini']['service'] = array();
$array['ini']['service']['ipbx'] = true;
$array['ini']['service']['monitoring'] = true;

$array['ini']['report'] = array();
$array['ini']['report']['error'] = true;
$array['ini']['report']['warning'] = true;
$array['ini']['report']['info'] = true;
$array['ini']['report']['notice'] = true;
$array['ini']['report']['debug'] = false;

?>
