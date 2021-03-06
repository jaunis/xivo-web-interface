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

$array['element'] = array();

$array['element']['name'] = array();
$array['element']['name']['default'] = '';

$array['element']['timeout'] = array();
$array['element']['timeout']['value'] = array(0,5,10,15,20,25,30,35,40,45,50,55,60);
$array['element']['timeout']['default'] = 15;
$array['element']['timeout']['setdef'] = true;

$array['element']['musicclass'] = array();
$array['element']['musicclass']['default'] = XIVO_SRE_IPBX_AST_MOH_DEFAULT;

$array['element']['announce'] = array();
$array['element']['announce']['default'] = '';

$array['element']['strategy'] = array();
$array['element']['strategy']['value'] = array('linear', 'leastrecent',
					       'fewestcalls',
					       'rrmemory',
					       'random',
								 'wrandom',
					       'ringall');
$array['element']['strategy']['default'] = 'ringall';
$array['element']['strategy']['setdef'] = true;

$array['element']['servicelevel'] = array();
$array['element']['servicelevel']['default'] = '0';
$array['element']['servicelevel']['null'] = true;

$array['element']['context'] = array();
$array['element']['context']['default'] = '';
$array['element']['context']['null'] = true;

$array['element']['retry'] = array();
$array['element']['retry']['value'] = array(1,5,10,15,20,25,30,35,40,45,50,55,60);
$array['element']['retry']['default'] = 5;
$array['element']['retry']['setdef'] = true;

$array['element']['weight'] = array();
$array['element']['weight']['value'] = range(0,10);
$array['element']['weight']['default'] = 0;
$array['element']['weight']['setdef'] = true;

$array['element']['wrapuptime'] = array();
$array['element']['wrapuptime']['value'] = array(0,5,10,15,20,25,30,35,40,45,50,55,60);
$array['element']['wrapuptime']['default'] = 0;
$array['element']['wrapuptime']['setdef'] = true;

$array['element']['maxlen'] = array();
$array['element']['maxlen']['default'] = 0;
$array['element']['maxlen']['setdef'] = true;

$array['element']['announce-frequency'] = array();
$array['element']['announce-frequency']['value'] = array(0,15,30,45,60,75,90,
							 105,120,135,150,165,180,195,
							 210,225,240,255,270,285,300);
$array['element']['announce-frequency']['default'] = 0;
$array['element']['announce-frequency']['setdef'] = true;

$array['element']['periodic-announce-frequency'] = array();
$array['element']['periodic-announce-frequency']['value'] = array(0,15,30,45,60,75,90,
								  105,120,135,150,165,180,195,
								  210,225,240,255,270,285,300);
$array['element']['periodic-announce-frequency']['default'] = 0;
$array['element']['periodic-announce-frequency']['setdef'] = true;

$array['element']['announce-holdtime'] = array();
$array['element']['announce-holdtime']['value'] = array('no','yes','once');
$array['element']['announce-holdtime']['default'] = 'no';
$array['element']['announce-holdtime']['setdef'] = true;

$array['element']['announce-round-seconds'] = array();
$array['element']['announce-round-seconds']['value'] = array(0,5,10,15,20,30);
$array['element']['announce-round-seconds']['default'] = 0;
$array['element']['announce-round-seconds']['setdef'] = true;

$array['element']['monitor-format'] = array();
$array['element']['monitor-format']['value'] = array('gsm','wav','wav49');
$array['element']['monitor-format']['default'] = '';
$array['element']['monitor-format']['null'] = true;

$array['element']['monitor-type'] = array();
$array['element']['monitor-type']['value'] = array('no','mixmonitor');
$array['element']['monitor-type']['default'] = '';
$array['element']['monitor-type']['null'] = true;

$array['element']['joinempty'] = array();
$array['element']['joinempty']['value']   = array('paused','penalty','inuse','ringing','unavailable','invalid','unknown','wrapup');
$array['element']['joinempty']['default'] = '';

$array['element']['leavewhenempty'] = array();
$array['element']['leavewhenempty']['value']   = array('paused','penalty','inuse','ringing','unavailable','invalid','unknown','wrapup');
$array['element']['leavewhenempty']['default'] = '';

$array['element']['ringinuse'] = array();
$array['element']['ringinuse']['value'] = array(0,1);
$array['element']['ringinuse']['default'] = 0;
$array['element']['ringinuse']['set'] = true;

$array['element']['eventwhencalled'] = array();
$array['element']['eventwhencalled']['value'] = array(0,1);
$array['element']['eventwhencalled']['default'] = 1;
$array['element']['eventwhencalled']['set'] = true;
$array['element']['eventwhencalled']['forcedef'] = true;

$array['element']['eventmemberstatus'] = array();
$array['element']['eventmemberstatus']['value'] = array(0,1);
$array['element']['eventmemberstatus']['default'] = 1;
$array['element']['eventmemberstatus']['set'] = true;
$array['element']['eventmemberstatus']['forcedef'] = true;

$array['element']['reportholdtime'] = array();
$array['element']['reportholdtime']['value'] = array(0,1);
$array['element']['reportholdtime']['default'] = 0;
$array['element']['reportholdtime']['set'] = true;

$array['element']['memberdelay'] = array();
$array['element']['memberdelay']['value'] = array(0,5,10,15,20,25,30,35,40,45,50,55,60);
$array['element']['memberdelay']['default'] = 0;
$array['element']['memberdelay']['setdef'] = true;

$array['element']['timeoutrestart'] = array();
$array['element']['timeoutrestart']['value'] = array(0,1);
$array['element']['timeoutrestart']['default'] = 0;
$array['element']['timeoutrestart']['set'] = true;

$array['element']['queue-youarenext'] = array();
$array['element']['queue-youarenext']['default'] = 'queue-youarenext';
$array['element']['queue-youarenext']['setdef'] = true;

$array['element']['queue-thereare'] = array();
$array['element']['queue-thereare']['default'] = 'queue-thereare';
$array['element']['queue-thereare']['setdef'] = true;

$array['element']['queue-callswaiting'] = array();
$array['element']['queue-callswaiting']['default'] = 'queue-callswaiting';
$array['element']['queue-callswaiting']['setdef'] = true;

$array['element']['queue-holdtime'] = array();
$array['element']['queue-holdtime']['default'] = 'queue-holdtime';
$array['element']['queue-holdtime']['setdef'] = true;

$array['element']['queue-minutes'] = array();
$array['element']['queue-minutes']['default'] = 'queue-minutes';
$array['element']['queue-minutes']['setdef'] = true;

$array['element']['queue-seconds'] = array();
$array['element']['queue-seconds']['default'] = 'queue-seconds';
$array['element']['queue-seconds']['setdef'] = true;

$array['element']['queue-thankyou'] = array();
$array['element']['queue-thankyou']['default'] = 'queue-thankyou';
$array['element']['queue-thankyou']['setdef'] = true;

$array['element']['queue-reporthold'] = array();
$array['element']['queue-reporthold']['default'] = 'queue-reporthold';
$array['element']['queue-reporthold']['setdef'] = true;

$array['element']['periodic-announce'] = array();
$array['element']['periodic-announce']['default'] = 'queue-periodic-announce';
$array['element']['periodic-announce']['setdef'] = true;

$array['element']['category'] = array();
$array['element']['category']['value'] = array('queue','group');

$array['element']['timeoutpriority'] = array();
$array['element']['timeoutpriority']['value'] = array('app','conf');
$array['element']['timeoutpriority']['default'] = 'conf';

$array['element']['autofill'] = array();
$array['element']['autofill']['value'] = array(0,1);
$array['element']['autofill']['default'] = 1;
$array['element']['autofill']['set'] = true;

$array['element']['autopause'] = array();
$array['element']['autopause']['value'] = array(0,1);
$array['element']['autopause']['default'] = 0;
$array['element']['autopause']['set'] = true;

$array['element']['setinterfacevar'] = array();
$array['element']['setinterfacevar']['value'] = array(0,1);
$array['element']['setinterfacevar']['default'] = 0;
$array['element']['setinterfacevar']['set'] = true;

$array['element']['setqueueentryvar'] = array();
$array['element']['setqueueentryvar']['value'] = array(0,1);
$array['element']['setqueueentryvar']['default'] = 1;
$array['element']['setqueueentryvar']['set'] = true;

$array['element']['setqueuevar'] = array();
$array['element']['setqueuevar']['value'] = array(0,1);
$array['element']['setqueuevar']['default'] = 1;
$array['element']['setqueuevar']['set'] = true;

$array['element']['membermacro'] = array();
$array['element']['membermacro']['default'] = '';
$array['element']['membermacro']['null'] = true;

$array['element']['min-announce-frequency'] = array();
$array['element']['min-announce-frequency']['value'] = array(0,10,20,30,40,50,60,70,80,90,100,110,120,130,140,150,160,170,180,190,200,210,220,230,240,250,260,270,280,290,300,310,320,330,340,350,360,370,380,390,400,410,420,430,440,450,460,470,480,490,500,510,520,530,540,550,560,570,580,590,600);
$array['element']['min-announce-frequency']['default'] = 60;

$array['element']['random-periodic-announce'] = array();
$array['element']['random-periodic-announce']['value'] = array(0,1);
$array['element']['random-periodic-announce']['default'] = 0;
$array['element']['random-periodic-announce']['set'] = true;

$array['element']['announce-position'] = array();
$array['element']['announce-position']['value'] = array('yes','no','limit','more');
$array['element']['announce-position']['default'] = 'yes';

$array['element']['announce-position-limit'] = array();
$array['element']['announce-position-limit']['value']   = range(0, 50);
$array['element']['announce-position-limit']['default'] = 5;

$array['element']['defaultrule'] = array();
$array['element']['defaultrule']['default'] = '';
$array['element']['defaultrule']['null'] = true;


// FILTERS
$array['filter'] = array();
$array['filter']['name'] = array('regexp' => '/^[a-z0-9_\.-]+$/i','minlen' => 1,'maxlen' => 128);
$array['filter']['timeout'] = array('set' => false,'chk' => 2,'cast' => 'uint','between' => array(0,60,5));
$array['filter']['musicclass'] = array('set' => false,'chk' => 2,'maxlen' => 20);
$array['filter']['announce'] = array('set' => false,'chk' => 2,'cast' => 'sgraph','maxlen' => 128);
$array['filter']['strategy'] = array('set'	=> false,
				     'chk'	=> 2,
				     'key'	=> array('leastrecent',
							 'fewestcalls',
							 'rrmemory',
							 'random',
							 'ringall', 'linear', 'wrandom'));
$array['filter']['servicelevel'] = array('set' => false,'chk' => 2,'cast' => 'int');
$array['filter']['context'] = array('set' => false,'chk' => 2,'callback' => 'xivo_service_asterisk::chk_context');
$array['filter']['retry'] = array('set' => false,'chk' => 2,'cast' => 'uint','between' => array(1,60,5));
$array['filter']['weight'] = array('set' => false,'chk' => 2,'cast' => 'uint','between' => array(0,10));
$array['filter']['wrapuptime'] = array('set' => false,'chk' => 2,'cast' => 'uint','between' => array(0,60,5));
$array['filter']['maxlen'] = array('set' => false,'chk' => 2,'cast' => 'uint','between' => array(0,65535));
$array['filter']['announce-frequency'] = array('set'	=> false,
					       'chk'	=> 2,
					       'key' => array(0,15,30,45,60,75,90,
							      105,120,135,150,165,180,
							      210,225,240,255,270,285,300));
$array['filter']['periodic-announce-frequency'] = array('set'	=> false,
							'chk'	=> 2,
							'key' => array(0,15,30,45,60,75,90,
								       105,120,135,150,165,180,
								       210,225,240,255,270,285,300));
$array['filter']['announce-holdtime'] = array('set' => false,'chk' => 2,'key' => array('no','yes','once'));
$array['filter']['announce-round-seconds'] = array('set' => false,'chk' => 2,'cast' => 'uint', 'key' => array(0,5,10,15,20,30));
$array['filter']['monitor-format'] = array('set' => false,'chk' => 2,'key' => array('gsm','wav','wav49'));
$array['filter']['monitor-type'] = array('set' => false,'chk' => 2,'key' => array('no','mixmonitor'));
$array['filter']['joinempty'] = array('set' => false,'chk' => 2);
$array['filter']['leavewhenempty'] = array('set' => false,'chk' => 2);
$array['filter']['ringinuse'] = array('bool' => true);
$array['filter']['eventwhencalled'] = array('bool' => true);
$array['filter']['eventmemberstatus'] = array('bool' => true);
$array['filter']['reportholdtime'] = array('bool' => true);
$array['filter']['memberdelay'] = array('set' => false,'chk' => 2,'cast' => 'uint','between' => array(0,60,5));
$array['filter']['timeoutrestart'] = array('bool' => true);
$array['filter']['queue-youarenext'] = array('set' => false,'chk' => 2,'cast' => 'sgraph','maxlen' => 128);
$array['filter']['queue-thereare'] = array('set' => false,'chk' => 2,'cast' => 'sgraph','maxlen' => 128);
$array['filter']['queue-callswaiting'] = array('set' => false,'chk' => 2,'cast' => 'sgraph','maxlen' => 128);
$array['filter']['queue-holdtime'] = array('set' => false,'chk' => 2,'cast' => 'sgraph','maxlen' => 128);
$array['filter']['queue-minutes'] = array('set' => false,'chk' => 2,'cast' => 'sgraph','maxlen' => 128);
$array['filter']['queue-seconds'] = array('set' => false,'chk' => 2,'cast' => 'sgraph','maxlen' => 128);
$array['filter']['queue-thankyou'] = array('set' => false,'chk' => 2,'cast' => 'sgraph','maxlen' => 128);
$array['filter']['queue-reporthold'] = array('set' => false,'chk' => 2,'cast' => 'sgraph','maxlen' => 128);
$array['filter']['periodic-announce'] = array('set'	=> false,
					      'chk'	=> 2,
					      'regexp'	=> '/^(?:['.XIVO_SRE_IPBX_AST_REGEXP_AUDIO_FILE_PATTERN.
								    preg_quote(DWHO_SEP_DIR,'/').']{1,79}\,?){1,10}$/');
$array['filter']['category'] = array('key' => array('queue','group'));
$array['filter']['timeoutpriority'] = array('key' => array('app','conf'));
$array['filter']['autofill'] = array('bool' => true);
$array['filter']['autopause'] = array('bool' => true);
$array['filter']['setinterfacevar'] = array('bool' => true);
$array['filter']['setqueueentryvar'] = array('bool' => true);
$array['filter']['setqueuevar'] = array('bool' => true);
$array['filter']['membermacro'] = array('set' => false,'chk' => 2,'maxlen' => 1024);
$array['filter']['min-announce-frequency'] = array('cast' => 'uint','between' => array(0,600,10));
$array['filter']['random-periodic-announce'] = array('bool' => true);
$array['filter']['announce-position'] = array('key' => array('yes','no','limit','more'));
$array['filter']['announce-position-limit'] = array('cast' => 'uint');
$array['filter']['announce-position-limit'] = array('cast' => 'uint', 'between' => array(1,50));
$array['filter']['defaultrule'] = array('set' => false,'chk' => 2,'maxlen' => 1024);

?>
