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

$form = &$this->get_module('form');
$url = &$this->get_module('url');

$info = $this->get_var('info');
$element = $this->get_var('element');
$bosslist = $this->get_var('bosslist');
$secretary = $this->get_var('secretary');

if($this->get_var('act') === 'add'):
	$invalid_boss = false;
elseif(dwho_issa('callfiltermember',$info) === false
|| dwho_issa('boss',$info['callfiltermember']) === false):
	$invalid_boss = true;
else:
	$invalid_boss = false;
endif;

?>

<div id="sb-part-first" class="b-nodisplay">
<?php
	echo	$form->text(array('desc'	=> $this->bbf('fm_callfilter_name'),
				  'name'	=> 'callfilter[name]',
				  'labelid'	=> 'callfilter-name',
				  'size'	=> 15,
				  'default'	=> $element['callfilter']['name']['default'],
				  'value'	=> $info['callfilter']['name'],
				  'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'callfilter', 'name')) ));

	echo	$form->select(array('desc'	=> $this->bbf('fm_callfilter_callfrom'),
				    'name'	=> 'callfilter[callfrom]',
				    'labelid'	=> 'callfilter-callfrom',
				    'key'	=> false,
				    'bbf'	=> 'fm_callfilter_callfrom-opt',
				    'bbfopt'	=> array('argmode' => 'paramvalue'),
				    'default'	=> $element['callfilter']['callfrom']['default'],
				    'selected'	=> $info['callfilter']['callfrom']),
			      $element['callfilter']['callfrom']['value']),

		$form->select(array('desc'	=> $this->bbf('fm_callfilter_bosssecretary'),
				    'name'	=> 'callfilter[bosssecretary]',
				    'labelid'	=> 'callfilter-bosssecretary',
				    'key'	=> false,
				    'bbf'	=> 'fm_callfilter_bosssecretary-opt',
				    'bbfopt'	=> array('argmode' => 'paramvalue'),
				    'default'	=> $element['callfilter']['bosssecretary']['default'],
				    'selected'	=> $info['callfilter']['bosssecretary']),
			      $element['callfilter']['bosssecretary']['value'],
			      'onchange="xivo_callfilter_chg_mode(\'bosssecretary\',this);"'),

		$form->select(array('desc'	=> $this->bbf('fm_callfilter_ringseconds'),
				    'name'	=> 'callfilter[ringseconds]',
				    'labelid'	=> 'callfilter-ringseconds',
				    'key'	=> false,
				    'bbf'	=> 'fm_callfilter_ringseconds-opt',
				    'bbfopt'	=> array('argmode' => 'paramvalue'),
				    'default'	=> $element['callfilter']['ringseconds']['default'],
				    'selected'	=> $info['callfilter']['ringseconds']),
			      $element['callfilter']['ringseconds']['value']),

		$form->select(array('desc'	=> $this->bbf('fm_callerid_mode'),
				    'name'	=> 'callerid[mode]',
				    'labelid'	=> 'callerid-mode',
				    'empty'	=> true,
				    'key'	=> false,
				    'bbf'	=> 'fm_callerid_mode-opt',
				    'bbfopt'	=> array('argmode' => 'paramvalue'),
				    'default'	=> $element['callerid']['mode']['default'],
				    'selected'	=> $info['callerid']['mode']),
			      $element['callerid']['mode']['value'],
			      'onchange="xivo_ast_chg_callerid_mode(this);"'),

		$form->text(array('desc'	=> '&nbsp;',
				  'name'	=> 'callerid[callerdisplay]',
				  'labelid'	=> 'callerid-callerdisplay',
				  'size'	=> 15,
				  'notag'	=> false,
				  'default'	=> $element['callerid']['callerdisplay']['default'],
				  'value'	=> $info['callerid']['callerdisplay'],
				  'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'callerid', 'callerdisplay')) ));
?>

<fieldset id="fld-callfilter-boss">
	<legend><?=$this->bbf('fld-callfilter-boss');?></legend>
<?php
	if(empty($bosslist) === false):
		echo	$form->select(array('desc'	=> $this->bbf('fm_callfiltermember-boss'),
					    'name'	=> 'callfiltermember[boss][id]',
					    'labelid'	=> 'callfiltermember-boss',
					    'key'	=> 'identity',
					    'altkey'	=> 'id',
					    'invalid'	=> $invalid_boss,
					    'selected'	=> $info['callfiltermember']['boss']['typeval']),
				      $bosslist),

			$form->select(array('desc'	=> $this->bbf('fm_callfiltermember_ringseconds-boss'),
					    'name'	=> 'callfiltermember[boss][ringseconds]',
					    'labelid'	=> 'callfiltermember-ringseconds-boss',
					    'key'	=> false,
					    'bbf'	=> 'fm_callfiltermember_ringseconds-boss-opt',
					    'bbfopt'	=> array('argmode' => 'paramvalue'),
					    'default'	=> $element['callfiltermember']['ringseconds']['default'],
					    'selected'	=> $info['callfiltermember']['boss']['ringseconds']),
				      $element['callfiltermember']['ringseconds']['value']);
	else:
		echo	'<div class="txt-center">',
			$url->href_htmln($this->bbf('create_user-boss'),
					'service/ipbx/pbx_settings/users',
					'act=add'),
			'</div>';
	endif;
?>
</fieldset>

<fieldset id="fld-callfilter-secretary">
	<legend><?=$this->bbf('fld-callfilter-secretary');?></legend>
<?php
	if($secretary['list'] !== false):
?>
    <div id="userlist" class="fm-paragraph fm-description">
    		<?=$form->jq_select(array('paragraph'	=> false,
    					 	'label'		=> false,
                			'name'    	=> 'callfiltermember[secretary][]',
    						'id' 		=> 'it-callfiltermember-secretary',
    						'key'		=> 'identity',
    				       	'altkey'	=> 'id',
                			'selected'  => $secretary['slt']),
    					$secretary['list']);?>
    </div>
    <div class="clearboth"></div>
<?php
	else:
		echo	'<div class="txt-center">',
			$url->href_htmln($this->bbf('create_user-secretary'),
					'service/ipbx/pbx_settings/users',
					'act=add'),
			'</div>';
	endif;
?>
</fieldset>

<div class="fm-paragraph fm-description">
	<p>
		<label id="lb-callfilter-description" for="it-callfilter-description"><?=$this->bbf('fm_callfilter_description');?></label>
	</p>
	<?=$form->textarea(array('paragraph'	=> false,
				 'label'	=> false,
				 'name'		=> 'callfilter[description]',
				 'id'		=> 'it-callfilter-description',
				 'cols'		=> 60,
				 'rows'		=> 5,
				 'default'	=> $element['callfilter']['description']['default'],
				 'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'callfilter', 'description')) ),
			   $info['callfilter']['description']);?>
</div>

</div>

<div id="sb-part-last" class="b-nodisplay">
	<fieldset id="fld-dialaction-noanswer">
		<legend><?=$this->bbf('fld-dialaction-noanswer');?></legend>
<?php
		$this->file_include('bloc/service/ipbx/asterisk/dialaction/all',
				    array('event'	=> 'noanswer'));
?>
	</fieldset>
</div>
