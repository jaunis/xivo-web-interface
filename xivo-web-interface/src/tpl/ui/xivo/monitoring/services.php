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

$url = &$this->get_module('url');
$dhtml = &$this->get_module('dhtml');

$groups = array('mon_server','mon_telephony','mon_grpundef');

foreach ($groups as $grpname) :

$grpdata = $this->get_var($grpname);
$memtotal = $this->get_var('memstats','memtotal');

if(is_array($grpdata) === true && ($nb = count($grpdata)) > 0):

?>
	<div class="monit-group">
		<table>
			<tr class="sb-top">
				<th colspan="8" class="th-left th-right"><?=$this->bbf('sysinfos_'.$grpname);?></th>
			</tr>
			<tr class="l-subth">
				<td><?=$this->bbf('sysinfos_col_process');?></td>
				<td><?=$this->bbf('sysinfos_col_status');?></td>
				<td><?=$this->bbf('sysinfos_col_uptime');?></td>
				<td><?=$this->bbf('sysinfos_col_cpu');?></td>
				<td colspan="3"><?=$this->bbf('sysinfos_col_memory');?></td>
				<td class="td-right"><?=$this->bbf('sysinfos_col_action');?></td>
			</tr>
<?php
		for($i = 0;$i < $nb;$i++):
			$ref = &$grpdata[$i];

			$mempx = 0;
			$uptime = $cpupcent = $mempcent = $memsize = $mempcent = $nummempcent = '-';

			if($ref['state'] === 'running' && $ref['type'] === 3):
				$uptime = $this->bbf('sysinfos_uptime-duration',
						     dwho_calc_time('second',
								    $ref['uptime'],
								    '%d%H%M%s'));
				$cpupcent = $this->bbf('number_percent',$ref['cpu']['percenttotal']);
				$membyte = dwho_size_si_to_byte('KB',$ref['memory']['kilobytetotal']);
				$mem = dwho_size_iec($membyte);
				$memsize = $this->bbf('size_iec_'.$mem[1],$mem[0]);

				if($memtotal > 0):
					$mempcent = ($membyte / $memtotal * 100);
				else:
					$mempcent = 0;
				endif;

				$nummempcent = $this->bbf('number_percent',$mempcent);
			endif;
?>
			<tr class="l-infos-<?=(($i % 2) + 1)?>on2">
				<td title="<?=dwho_alttitle($ref['name']);?>"><?=dwho_htmlen(dwho_trunc($ref['name'],20,'...',false));?></td>
				<td class="monit-state-<?=$ref['state']?>"><b><?=$this->bbf('sysinfos_state-opt',$ref['state']);?></b></td>
				<td class="txt-right"><?=$uptime?></td>
				<td class="txt-right"><?=$cpupcent?></td>
				<td class="gauge">
					<div><div style="width: <?=round($mempcent);?>px;">&nbsp;</div></div>
				</td>
				<td class="gaugepercent txt-right"><?=$nummempcent?></td>
				<td class="txt-right"><?=$memsize?></td>
				<td class="td-right">
<?php
			$actionable = false;

			if($ref['startable'] === true && xivo_user::chk_acl('control_system','start','service/monitoring') === true):
				$actionable = true;
				echo	$url->href_html($url->img_html('img/site/button/start.gif',
								       $this->bbf('sysinfos_opt_start',
										  $ref['name']),
								       'border="0"'),
							'#',
							null,
							'onclick="if(confirm(\''.$dhtml->escape($this->bbf('sysinfos_opt_start_confirm',$ref['name'])).'\'))
									{init_action(\''.$ref['name'].'\',\'start\')}else{return(false)};"',
							$this->bbf('sysinfos_opt_start',
								   $ref['name'])),"\n";
			endif;

			if($ref['restartable'] === true && xivo_user::chk_acl('control_system','restart','service/monitoring') === true):
				$actionable = true;
				echo	$url->href_html($url->img_html('img/site/button/restart.gif',
								       $this->bbf('sysinfos_opt_restart',
										  $ref['name']),
								       'border="0"'),
							'#',
							null,
							'onclick="if(confirm(\''.$dhtml->escape($this->bbf('sysinfos_opt_restart_confirm',$ref['name'])).'\'))
									{init_action(\''.$ref['name'].'\',\'restart\');}else{return(false);};"',
							$this->bbf('sysinfos_opt_restart',
								   $ref['name'])),"\n";
			endif;

			if($ref['stoppable'] === true && xivo_user::chk_acl('control_system','stop','service/monitoring') === true):
				$actionable = true;
				echo	$url->href_html($url->img_html('img/site/button/stop.gif',
								       $this->bbf('sysinfos_opt_stop',
										  $ref['name']),
								       'border="0"'),
							'#',
							null,
							'onclick="if(confirm(\''.$dhtml->escape($this->bbf('sysinfos_opt_stop_confirm',$ref['name'])).'\'))
									{init_action(\''.$ref['name'].'\',\'stop\')}else{return(false)};"',
							$this->bbf('sysinfos_opt_stop',
								   $ref['name'])),"\n";
			endif;

			if($ref['monitorable'] === true && xivo_user::chk_acl('control_system','monitor','service/monitoring') === true):
				$actionable = true;
				echo	$url->href_html($url->img_html('img/site/button/monitor.gif',
								       $this->bbf('sysinfos_opt_monitor',
										  $ref['name']),
								       'border="0"'),
							'#',
							null,
							'onclick="if(confirm(\''.$dhtml->escape($this->bbf('sysinfos_opt_monitor_confirm',$ref['name'])).'\'))
									{init_action(\''.$ref['name'].'\',\'monitor\')}else{return(false)};"',
							$this->bbf('sysinfos_opt_monitor',
								   $ref['name'])),"\n";
			elseif($ref['unmonitorable'] === true && xivo_user::chk_acl('control_system','unmonitor','service/monitoring') === true):
				$actionable = true;
				echo	$url->href_html($url->img_html('img/site/button/unmonitor.gif',
								       $this->bbf('sysinfos_opt_unmonitor',
										  $ref['name']),
								       'border="0"'),
							'#',
							null,
							'onclick="if(confirm(\''.$dhtml->escape($this->bbf('sysinfos_opt_unmonitor_confirm',$ref['name'])).'\'))
									{init_action(\''.$ref['name'].'\',\'unmonitor\');}else{return(false);};"',
							$this->bbf('sysinfos_opt_unmonitor',
								   $ref['name'])),"\n";
			endif;

			if($actionable === false):
				echo '-';
			endif;
?>
				</td>
			</tr>
<?php
		endfor;
?>
		</table>
	</div>
<?php

endif;

endforeach;

?>
