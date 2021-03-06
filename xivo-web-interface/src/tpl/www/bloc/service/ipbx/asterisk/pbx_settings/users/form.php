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
$error = $this->get_var('error');
$element = $this->get_var('element');

$voicemail_list = $this->get_var('voicemail_list');
$agent_list = $this->get_var('agent_list');
$profileclient_list = $this->get_var('profileclient_list');
$rightcall = $this->get_var('rightcall');
$schedules = $this->get_var('schedules');
$parking_list = $this->get_var('parking_list');

if(empty($info['userfeatures']['voicemailid']) === true):
	$voicemail_identity = false;
elseif(($voicemail_identity = (string) $this->get_var('voicemail','identity')) === ''):
	$voicemail_identity = $this->get_var('voicemail','fullname');
endif;

if(($outcallerid = (string) $info['userfeatures']['outcallerid']) === ''
|| in_array($outcallerid,$element['userfeatures']['outcallerid']['value'],true) === true):
	$outcallerid_custom = false;
else:
	$outcallerid_custom = true;
endif;

$line_nb = 0;
$line_list = false;

if(dwho_issa('linefeatures',$info) === true
&&($line_nb = count($info['linefeatures'])) > 0)
	$line_list = $info['linefeatures'];

?>

<div id="sb-part-first" class="b-nodisplay">

<div id="box-userfeatures_picture" class="box_userfeatures_picture">

<?php

if (isset($info['picture']) === true
&& is_array($info['picture']) === true
&& isset($info['picture']['id']) === true):
	echo $url->img_attachement($info['picture']['id'],$info['picture']['name']);
endif;

?>

</div>

<?php
	echo	$form->text(array('desc'	=> $this->bbf('fm_userfeatures_firstname'),
				  'name'	=> 'userfeatures[firstname]',
				  'labelid'	=> 'userfeatures-firstname',
				  'size'	=> 15,
				  'default'	=> $element['userfeatures']['firstname']['default'],
				  'value'	=> $info['userfeatures']['firstname'],
				  'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'userfeatures', 'firstname')) )),

		$form->text(array('desc'	=> $this->bbf('fm_userfeatures_lastname'),
				  'name'	=> 'userfeatures[lastname]',
				  'labelid'	=> 'userfeatures-lastname',
				  'size'	=> 15,
				  'default'	=> $element['userfeatures']['lastname']['default'],
				  'value'	=> $info['userfeatures']['lastname'],
				  'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'userfeatures', 'lastname')) )),

		$form->file(array('desc'	=> $this->bbf('fm_userfeatures_picture'),
						  'name'	=> 'picture',
						  'id'		=> 'picture',
						  'size'	=> 15)),

		$form->text(array('desc'	=> $this->bbf('fm_userfeatures_mobilephonenumber'),
				  'name'	=> 'userfeatures[mobilephonenumber]',
				  'labelid'	=> 'userfeatures-mobilephonenumber',
				  'size'	=> 15,
				  'default'	=> $element['userfeatures']['mobilephonenumber']['default'],
				  'value'	=> $info['userfeatures']['mobilephonenumber'],
				  'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'userfeatures', 'mobilephonenumber')) ));

	if($schedules === false):
		echo	'<div class="txt-center">',
			$url->href_htmln($this->bbf('create_schedules'),
					'service/ipbx/call_management/schedule',
					'act=add'),
			'</div>';
	else:
		echo $form->select(array('desc'	=> $this->bbf('fm_user_schedule'),
				    'name'	    => 'schedule_id',
				    'labelid'	  => 'schedule_id',
						'key'	      => 'name',
						'altkey'    => 'id',
						'empty'     => true,
				    'selected'	=> $this->get_var('schedule_id')),
			      $schedules);
	endif;


		echo	$form->select(array('desc'	=> $this->bbf('fm_userfeatures_ringseconds'),
				    'name'	=> 'userfeatures[ringseconds]',
				    'labelid'	=> 'userfeatures-ringseconds',
				    'key'	=> false,
				    'bbf'	=> 'fm_userfeatures_ringseconds-opt',
				    'bbfopt'	=> array('argmode' => 'paramvalue'),
				    'default'	=> $element['userfeatures']['ringseconds']['default'],
				    'selected'	=> $info['userfeatures']['ringseconds']),
			      $element['userfeatures']['ringseconds']['value']),

		$form->select(array('desc'	=> $this->bbf('fm_userfeatures_simultcalls'),
				    'name'	=> 'userfeatures[simultcalls]',
				    'labelid'	=> 'userfeatures-simultcalls',
				    'key'	=> false,
				    'default'	=> $element['userfeatures']['simultcalls']['default'],
				    'selected'	=> $info['userfeatures']['simultcalls']),
			      $element['userfeatures']['simultcalls']['value']);

	if(($moh_list = $this->get_var('moh_list')) !== false):
		echo	$form->select(array('desc'	=> $this->bbf('fm_userfeatures_musiconhold'),
					    'name'	=> 'userfeatures[musiconhold]',
					    'labelid'	=> 'userfeatures-musiconhold',
					    'empty'	=> true,
					    'key'	=> 'category',
					    'invalid'	=> ($this->get_var('act') === 'edit'),
					    'default'	=> ($this->get_var('act') === 'add' ? $element['userfeatures']['musiconhold']['default'] : null),
					    'selected'	=> $info['userfeatures']['musiconhold']),
				      $moh_list);
	endif;

	echo	$form->select(array('desc'	=> $this->bbf('fm_userfeatures_language'),
				    'name'	=> 'userfeatures[language]',
				    'labelid'	=> 'userfeatures-language',
				    'empty'	=> true,
				    'key'	=> false,
				    'default'	=> $element['userfeatures']['language']['default'],
				    'selected'	=> $this->get_var('info','userfeatures','language'),
				  	'error'	=> $this->bbf_args('error',
							$this->get_var('error', 'voicemail', 'locale')) ),
			      $element['userfeatures']['language']['value']),

		$form->select(array('desc'	=> $this->bbf('fm_userfeatures_timezone'),
				    'name'	=> 'userfeatures[timezone]',
				    'labelid'	=> 'userfeatures-timezone',
				    'empty'	=> true,
				    'key'	=> false,
# no default value => take general value
#				    'default'		=> $element['userfeatures']['timezone']['default'],
				    'selected'	=> $this->get_var('info','userfeatures','timezone')),
			      array_keys(dwho_i18n::get_timezone_list())),

		$form->text(array('desc'	=> $this->bbf('fm_userfeatures_callerid'),
				  'name'	=> 'userfeatures[callerid]',
				  'labelid'	=> 'userfeatures-callerid',
				  'value'	=> $this->get_var('info','userfeatures','callerid'),
				  'size'	=> 15,
				  'notag'	=> false,
				  'error'	=> $this->bbf_args('error',
				$this->get_var('error', 'userfeatures', 'callerid')) )),

		$form->select(array('desc'	=> $this->bbf('fm_userfeatures_outcallerid'),
				    'name'	=> 'userfeatures[outcallerid-type]',
				    'labelid'	=> 'userfeatures-outcallerid-type',
				    'key'	=> false,
				    'bbf'	=> 'fm_userfeatures_outcallerid-opt',
				    'bbfopt'	=> array('argmode' => 'paramvalue'),
				    'selected'	=> ($outcallerid_custom === true ? 'custom' : $outcallerid)),
			      $element['userfeatures']['outcallerid-type']['value']),

		$form->text(array('desc'	=> '&nbsp;',
				  'name'	=> 'userfeatures[outcallerid-custom]',
				  'labelid'	=> 'userfeatures-outcallerid-custom',
				  'value'	=> ($outcallerid_custom === true ? $outcallerid : ''),
				  'size'	=> 15,
				  'notag'	=> false,
				  'error'	=> $this->bbf_args('error',
				$this->get_var('error', 'userfeatures', 'outcallerid-custom')) )),

		$form->text(array('desc'	=> $this->bbf('fm_userfeatures_preprocess-subroutine'),
				  'name'	=> 'userfeatures[preprocess_subroutine]',
				  'labelid'	=> 'userfeatures-preprocess-subroutine',
				  'size'	=> 15,
				  'default'	=> $element['userfeatures']['preprocess_subroutine']['default'],
				  'value'	=> $info['userfeatures']['preprocess_subroutine'],
				  'error'	=> $this->bbf_args('error',
				$this->get_var('error', 'userfeatures', 'preprocess_subroutine')) )),

		$form->text(array('desc'	=> $this->bbf('fm_userfeatures_userfield'),
				  'name'	=> 'userfeatures[userfield]',
				  'labelid'	=> 'userfeatures-userfield',
				  'size'	=> 15,
				  'value'	=> $this->get_var('info','userfeatures','userfield'),
				  'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'userfeatures', 'userfield')) ));
?>
<fieldset id="fld-xivoclient">
	<legend><?=$this->bbf('fld-client');?></legend>
<?php echo		$form->checkbox(array('desc'	=> $this->bbf('fm_userfeatures_enableclient'),
				      'name'	=> 'userfeatures[enableclient]',
				      'labelid'	=> 'userfeatures-enableclient',
				      'default'	=> $element['userfeatures']['enableclient']['default'],
				      'checked'	=> $info['userfeatures']['enableclient'])),

				$form->text(array('desc'	=> $this->bbf('fm_userfeatures_loginclient'),
				  'name'	=> 'userfeatures[loginclient]',
				  'labelid'	=> 'userfeatures-loginclient',
				  'size'	=> 15,
				  'default'	=> $element['userfeatures']['loginclient']['default'],
				  'value'	=> $info['userfeatures']['loginclient'],
				  'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'userfeatures', 'loginclient')) )),

		$form->text(array('desc'	=> $this->bbf('fm_userfeatures_passwdclient'),
				  'name'	=> 'userfeatures[passwdclient]',
				  'labelid'	=> 'userfeatures-passwdclient',
				  'size'	=> 15,
				  'default'	=> $element['userfeatures']['passwdclient']['default'],
				  'value'	=> $info['userfeatures']['passwdclient'],
				  'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'userfeatures', 'passwdclient')) ));

	if(is_array($profileclient_list) === true && empty($profileclient_list) === false):
		echo	$form->select(array('desc'	=> $this->bbf('fm_userfeatures_profileclient'),
						'name'	=> 'userfeatures[cti_profile_id]',
						'labelid'	=> 'userfeatures-cti_profile_id',
						'altkey'	=> 'name',
						'key'		=> 'id',
						'default'	=> $element['userfeatures']['cti_profile_id']['default'],
						'empty'	=> true,
						'selected'	=> $info['userfeatures']['cti_profile_id']),
					$profileclient_list);
	endif;
?>
</fieldset>
	<div class="fm-paragraph fm-description">
		<p>
			<label id="lb-userfeatures-description" for="it-userfeatures-description"><?=$this->bbf('fm_userfeatures_description');?></label>
		</p>
		<?=$form->textarea(array('paragraph' => false,
					 'label'	=> false,
					 'name'		=> 'userfeatures[description]',
					 'id'		=> 'it-userfeatures-description',
					 'cols'		=> 60,
					 'rows'		=> 5,
					 'default'	=> $element['userfeatures']['description']['default'],
					 'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'userfeatures', 'description')) ),
				   $info['userfeatures']['description']);?>
	</div>
</div>

<div id="sb-part-lines" class="b-nodisplay">
<?php
	if($line_list !== false):
		#echo $form->hidden(array('name' => 'userfeatures[entityid]','value' => $info['userfeatures']['entityid']));
	endif;
	if ($this->get_var('entity_list') === false):
	    echo $this->bbf('no_entity_with_intern_context_detected');
	else:
	    echo	$form->select(array('desc'	=> $this->bbf('fm_userfeatures_entity'),
				    'name'		=> 'userfeatures[entityid]',
				    'labelid'	=> 'userfeatures-entityid',
				    'help'		=> $this->bbf('hlp_fm_userfeatures_entity'),
				    'key'		=> 'displayname',
				    'altkey'	=> 'id',
				    'selected'  => $info['userfeatures']['entityid'],
				    'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'userfeatures', 'entityid'))),
			      $this->get_var('entity_list'));
?>
	<div class="sb-list">
<?php
	$this->file_include('bloc/service/ipbx/asterisk/pbx_settings/users/line',
			    array('count'	=> $line_nb,
					  'list'	=> $line_list));
?>
	</div>
<?php
	endif;
?>
</div>

<div id="sb-part-voicemail" class="b-nodisplay">
<?php
	echo    $form->select(array('desc' => $this->bbf('fm_userfeatures_voicemailtype'),
			           'name'      => 'userfeatures[voicemailtype]',
			           'labelid'   => 'userfeatures-voicemailtype',
			           'key'       => false,
			           'empty'     => $this->bbf('fm_userfeatures_voicemailtype-opt(none)'),
			           'bbf'       => 'fm_userfeatures_voicemailtype-opt',
						'bbfopt'	   => array('argmode' => 'paramvalue'),
			           'selected'  => $info['userfeatures']['voicemailtype'],
			           'default'   => $element['userfeatures']['voicemailtype']['default']),
			       $element['userfeatures']['voicemailtype']['value']),

		$form->checkbox(array('desc'	=> $this->bbf('fm_userfeatures_enablevoicemail'),
				      'name'	=> 'userfeatures[enablevoicemail]',
				      'labelid'	=> 'userfeatures-enablevoicemail',
				      'default'	=> $element['userfeatures']['enablevoicemail']['default'],
				      'checked'	=> $info['userfeatures']['enablevoicemail'])),

		$form->hidden(array('name'	=> 'userfeatures[voicemailid]',
				    'id'	=> 'it-userfeatures-voicemailid',
				    'value'	=> $info['userfeatures']['voicemailid'])),

		$form->select(array('desc'	=> $this->bbf('fm_voicemail_option'),
				    'name'		=> 'voicemail-option',
				    'labelid'	=> 'voicemail-option',
				    'empty'		=> $voicemail_identity,
				    'key'		=> false,
				    'bbf'		=> 'fm_voicemail_option-opt',
				    'bbfopt'	=> array('argmode' => 'paramvalue'),
				    'selected'	=> $this->get_var('info','voicemail-option')),
			      $element['voicemail']['option']['value']),

		$form->text(array('desc'	=> $this->bbf('fm_voicemail_suggest'),
				  'name'	=> 'voicemail-suggest',
				  'labelid'	=> 'voicemail-suggest',
				  'size'	=> 20,
				  'error'	=> $this->bbf_args('error',
				$this->get_var('error', 'voicemail', 'suggest')) )),

		$form->text(array('desc'	=> $this->bbf('fm_voicemail_fullname'),
				  'name'	=> 'voicemail[fullname]',
				  'labelid'	=> 'voicemail-fullname',
				  'size'	=> 15,
				  'default'	=> $element['voicemail']['fullname']['default'],
				  'value'	=> $this->get_var('voicemail','fullname'),
				  'error'	=> $this->bbf_args('error',
				$this->get_var('error', 'voicemail', 'fullname')) )),

		$form->text(array('desc'	=> $this->bbf('fm_voicemail_mailbox'),
				  'name'	=> 'voicemail[mailbox]',
				  'labelid'	=> 'voicemail-mailbox',
				  'size'	=> 10,
				  'default'	=> $element['voicemail']['mailbox']['default'],
				  'value'	=> $this->get_var('voicemail','mailbox'),
				  'error'	=> $this->bbf_args('error',
				$this->get_var('error', 'voicemail', 'mailbox')) )),

		$form->text(array('desc'	=> $this->bbf('fm_voicemail_password'),
				  'name'	=> 'voicemail[password]',
				  'labelid'	=> 'voicemail-password',
				  'size'	=> 10,
				  'default'	=> $element['voicemail']['password']['default'],
				  'value'	=> $this->get_var('voicemail','password'),
				  'error'	=> $this->bbf_args('error',
				$this->get_var('error', 'voicemail', 'password')) )),

		$form->text(array('desc'	=> $this->bbf('fm_voicemail_email'),
				  'name'	=> 'voicemail[email]',
				  'labelid'	=> 'voicemail-email',
				  'size'	=> 15,
				  'value'	=> $this->get_var('voicemail','email'),
				  'default'	=> $element['voicemail']['email']['default'],
				  'error'	=> $this->bbf_args('error',
				$this->get_var('error', 'voicemail', 'email')) ));

	if(($tz_list = $this->get_var('tz_list')) !== false):
		echo	$form->select(array('desc'	=> $this->bbf('fm_voicemail_tz'),
					    'name'	=> 'voicemail[tz]',
					    'labelid'	=> 'voicemail-tz',
					    'key'	=> 'name',
					    'default'	=> $element['voicemail']['tz']['default'],
					    'selected'	=> $this->get_var('voicemail','tz')),
				      $tz_list);
	endif;

	echo	$form->checkbox(array('desc'	=> $this->bbf('fm_voicemail_skipcheckpass'),
				      'name'	=> 'voicemail[skipcheckpass]',
				      'labelid'	=> 'voicemail-skipcheckpass',
				      'default'	=> $element['voicemail']['skipcheckpass']['default'],
				      'checked'	=> $this->get_var('info','voicemail','skipcheckpass'))),

		$form->select(array('desc'	=> $this->bbf('fm_voicemail_attach'),
				    'name'	=> 'voicemail[attach]',
				    'labelid'	=> 'voicemail-attach',
				    'empty'	=> true,
				    'key'	=> false,
				    'bbf'	=> 'fm_bool-opt',
				    'bbfopt'	=> array('argmode' => 'paramvalue'),
				    'default'	=> $element['voicemail']['attach']['default'],
				    'selected'	=> $this->get_var('voicemail','attach')),
			      $element['voicemail']['attach']['value']),

		$form->checkbox(array('desc'	=> $this->bbf('fm_voicemail_deletevoicemail'),
				      'name'	=> 'voicemail[deletevoicemail]',
				      'labelid'	=> 'voicemail-deletevoicemail',
				      'default'	=> $element['voicemail']['deletevoicemail']['default'],
				      'checked'	=> $this->get_var('voicemail','deletevoicemail')));
?>
</div>

<div id="sb-part-dialaction" class="b-nodisplay">
	<fieldset id="fld-dialaction-noanswer">
		<legend><?=$this->bbf('fld-dialaction-noanswer');?></legend>
<?php
		$this->file_include('bloc/service/ipbx/asterisk/dialaction/all',
				    array('event'	=> 'noanswer'));
?>
	</fieldset>

	<fieldset id="fld-dialaction-busy">
		<legend><?=$this->bbf('fld-dialaction-busy');?></legend>
<?php
		$this->file_include('bloc/service/ipbx/asterisk/dialaction/all',
				    array('event'	=> 'busy'));
?>
	</fieldset>

	<fieldset id="fld-dialaction-congestion">
		<legend><?=$this->bbf('fld-dialaction-congestion');?></legend>
<?php
		$this->file_include('bloc/service/ipbx/asterisk/dialaction/all',
				    array('event'	=> 'congestion'));
?>
	</fieldset>

	<fieldset id="fld-dialaction-chanunavail">
		<legend><?=$this->bbf('fld-dialaction-chanunavail');?></legend>
<?php
		$this->file_include('bloc/service/ipbx/asterisk/dialaction/all',
				    array('event'	=> 'chanunavail'));
?>
	</fieldset>
</div>

<div id="sb-part-service" class="b-nodisplay">

	<fieldset id="fld-services">
		<legend><?=$this->bbf('fld-services');?></legend>
<?php
	echo	$form->checkbox(array('desc'	=> $this->bbf('fm_userfeatures_enablehint'),
				      'name'	=> 'userfeatures[enablehint]',
				      'labelid'	=> 'userfeatures-enablehint',
				      'default'	=> $element['userfeatures']['enablehint']['default'],
				      'checked'	=> $info['userfeatures']['enablehint'])),

		$form->checkbox(array('desc'	=> $this->bbf('fm_userfeatures_enablexfer'),
				      'name'	=> 'userfeatures[enablexfer]',
				      'labelid'	=> 'userfeatures-enablexfer',
				      'default'	=> $element['userfeatures']['enablexfer']['default'],
				      'checked'	=> $info['userfeatures']['enablexfer'])),

		$form->checkbox(array('desc'	=> $this->bbf('fm_userfeatures_enableautomon'),
				      'name'	=> 'userfeatures[enableautomon]',
				      'labelid'	=> 'userfeatures-enableautomon',
				      'default'	=> $element['userfeatures']['enableautomon']['default'],
				      'checked'	=> $info['userfeatures']['enableautomon'])),

		$form->checkbox(array('desc'	=> $this->bbf('fm_userfeatures_callrecord'),
				      'name'	=> 'userfeatures[callrecord]',
				      'labelid'	=> 'userfeatures-callrecord',
				      'default'	=> $element['userfeatures']['callrecord']['default'],
				      'checked'	=> $info['userfeatures']['callrecord'])),

		$form->checkbox(array('desc'	=> $this->bbf('fm_userfeatures_incallfilter'),
				      'name'	=> 'userfeatures[incallfilter]',
				      'labelid'	=> 'userfeatures-incallfilter',
				      'default'	=> $element['userfeatures']['incallfilter']['default'],
				      'checked'	=> $info['userfeatures']['incallfilter'])),

		$form->checkbox(array('desc'	=> $this->bbf('fm_userfeatures_enablednd'),
				      'name'	=> 'userfeatures[enablednd]',
				      'labelid'	=> 'userfeatures-enablednd',
				      'default'	=> $element['userfeatures']['enablednd']['default'],
				      'checked'	=> $info['userfeatures']['enablednd'])),

		$form->select(array('desc'	=> $this->bbf('fm_userfeatures_bsfilter'),
				    'name'	=> 'userfeatures[bsfilter]',
				    'labelid'	=> 'userfeatures-bsfilter',
				    'key'	=> false,
				    'bbf'	=> 'fm_userfeatures_bsfilter-opt',
				    'bbfopt'	=> array('argmode' => 'paramvalue'),
				    'default'	=> $element['userfeatures']['bsfilter']['default'],
				    'selected'	=> $info['userfeatures']['bsfilter']),
			      $element['userfeatures']['bsfilter']['value']);

	if($agent_list !== false):
		echo	$form->select(array('desc'	=> $this->bbf('fm_userfeatures_agentid'),
					    'name'	=> 'userfeatures[agentid]',
					    'labelid'	=> 'userfeatures-agentid',
					    'empty'	=> true,
					    'key'	=> 'identity',
					    'altkey'	=> 'id',
					    'default'	=> $element['userfeatures']['agentid']['default'],
					    'selected'	=> $info['userfeatures']['agentid']),
				      $agent_list);
	else:
		echo	'<div id="fd-userfeatures-agentid" class="txt-center">',
			$url->href_htmln($this->bbf('create_agent'),
					'callcenter/settings/agents',
					array('act'	=> 'addagent',
					      'group'	=> 1)),
			'</div>';
	endif;
?>
	</fieldset>

	<fieldset id="fld-rightcalls">
		<legend><?=$this->bbf('fld-rightcalls');?></legend>
<?php

		echo	$form->text(array('desc'	=> $this->bbf('fm_userfeatures_rightcallcode'),
				  'name'	=> 'userfeatures[rightcallcode]',
				  'labelid'	=> 'userfeatures-rightcallcode',
				  'size'	=> 15,
				  'default'	=> $element['userfeatures']['rightcallcode']['default'],
				  'value'	=> $info['userfeatures']['rightcallcode'],
				  'error'	=> $this->bbf_args('error',
				$this->get_var('error', 'userfeatures', 'rightcallcode')) ));

				if($rightcall['list'] !== false):
?>
    <div id="rightcalllist" class="fm-paragraph fm-description">
    		<?=$form->jq_select(array('paragraph'	=> false,
    					 	'label'		=> false,
                			'name'    	=> 'rightcall[]',
    						'id' 		=> 'it-rightcall',
    						'key'		=> 'identity',
    				       	'altkey'	=> 'id',
                			'selected'  => $rightcall['slt']),
    					$rightcall['list']);?>
    </div>
    <div class="clearboth"></div>
<?php
				else:
					echo	'<div class="txt-center">',
						$url->href_htmln($this->bbf('create_rightcall'),
								'service/ipbx/call_management/rightcall',
								'act=add'),
						'</div>';
				endif;
?>
	</fieldset>

	<fieldset id="fld-callforwards">
		<legend><?=$this->bbf('fld-callforwards');?></legend>
<?php

	echo	$form->checkbox(array('desc'	=> $this->bbf('fm_userfeatures_enablerna'),
				      'name'	=> 'userfeatures[enablerna]',
				      'labelid'	=> 'userfeatures-enablerna',
				      'default'	=> $element['userfeatures']['enablerna']['default'],
				      'checked'	=> $info['userfeatures']['enablerna'])),

		$form->text(array('desc'	=> $this->bbf('fm_userfeatures_destrna'),
				  'name'	=> 'userfeatures[destrna]',
				  'labelid'	=> 'userfeatures-destrna',
				  'size'	=> 15,
				  'default'	=> $element['userfeatures']['destrna']['default'],
				  'value'	=> $info['userfeatures']['destrna'],
				  'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'userfeatures', 'destrna')) )),

		$form->checkbox(array('desc'	=> $this->bbf('fm_userfeatures_enablebusy'),
				      'name'	=> 'userfeatures[enablebusy]',
				      'labelid'	=> 'userfeatures-enablebusy',
				      'default'	=> $element['userfeatures']['enablebusy']['default'],
				      'checked'	=> $info['userfeatures']['enablebusy'])),

		$form->text(array('desc'	=> $this->bbf('fm_userfeatures_destbusy'),
				  'name'	=> 'userfeatures[destbusy]',
				  'labelid'	=> 'userfeatures-destbusy',
				  'size'	=> 15,
				  'default'	=> $element['userfeatures']['destbusy']['default'],
				  'value'	=> $info['userfeatures']['destbusy'],
				  'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'userfeatures', 'destbusy')) )),

		$form->checkbox(array('desc'	=> $this->bbf('fm_userfeatures_enableunc'),
				      'name'	=> 'userfeatures[enableunc]',
				      'labelid'	=> 'userfeatures-enableunc',
				      'default'	=> $element['userfeatures']['enableunc']['default'],
				      'checked'	=> $info['userfeatures']['enableunc'])),

		$form->text(array('desc'	=> $this->bbf('fm_userfeatures_destunc'),
				  'name'	=> 'userfeatures[destunc]',
				  'labelid'	=> 'userfeatures-destunc',
				  'size'	=> 15,
				  'default'	=> $element['userfeatures']['destunc']['default'],
				  'value'	=> $info['userfeatures']['destunc'],
				  'error'	=> $this->bbf_args('error',
						   $this->get_var('error', 'userfeatures', 'destunc')) ));
?>
	</fieldset>
</div>

<div id="sb-part-groups" class="b-nodisplay">
<?php
	$this->file_include('bloc/service/ipbx/asterisk/pbx_settings/users/groups');
?>
</div>

<div id="sb-part-funckeys" class="b-nodisplay">
<?php
	$this->file_include('bloc/service/ipbx/asterisk/pbx_settings/users/phonefunckey');
?>
</div>

<div id="sb-part-rightcalls" class="b-nodisplay">
</div>

<div id="sb-part-schedule" class="b-nodisplay">
</div>
