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

$moh_list = $this->get_var('moh_list');
$context_list = $this->get_var('context_list');

if(dwho_has_len($info['meetmefeatures']['admin_internalid']) === true):
	$admin_suggest = $this->get_var('info','meetmeadmininternal','fullname');
else:
	$admin_suggest = null;
endif;

$dhtml = &$this->get_module('dhtml');
$dhtml->write_js('var xivo_fm_meetme_admin_suggest = \''.$dhtml->escape($admin_suggest).'\';');
$dhtml->write_js('var jsi18n_no_number_in_context = "'.$this->bbf('no_number_in_context').'"');

?>

<div id="sb-part-first" class="b-nodisplay">
<?php
	echo	$form->text(array('desc'	=> $this->bbf('fm_meetmefeatures_name'),
				  'name'	=> 'meetmefeatures[name]',
				  'labelid'	=> 'meetmefeatures-name',
				  'size'	=> 15,
				  'default'	=> $element['meetmefeatures']['name']['default'],
				  'value'	=> $info['meetmefeatures']['name'],
				  'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetmefeatures','name'))));
?>
<?php
	echo	$form->text(array('desc'	=> $this->bbf('fm_meetmefeatures_number'),
				  'name'	=> 'meetmefeatures[confno]',
				  'labelid'	=> 'meetmefeatures-confno',
				  'label'	=> 'lb-meetmefeatures-confno',
				  'size'	=> 15,
				  'default'	=> $element['meetmefeatures']['confno']['default'],
				  'value'	=> $info['meetmefeatures']['confno'],
				  'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetmefeatures','confno'))));
?>
		<div class="dialog-helper" style="margin-left:400px;" id="helper-context_num_pool"></div>
<?php 	echo	$form->text(array('desc'	=> $this->bbf('fm_meetmeroom_pin'),
				  'name'	=> 'meetmeroom[pin]',
				  'labelid'	=> 'meetmeroom-pin',
				  'size'	=> 15,
				  'default'	=> $element['meetmeroom']['pin']['default'],
				  'value'	=> $info['meetmeroom']['pin'],
				  'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetmeroom','pin'))));

if($context_list !== false):
	echo	$form->select(array('desc'	=> $this->bbf('fm_meetmefeatures_context'),
				    'name'		=> 'meetmefeatures[context]',
				    'labelid'	=> 'meetmefeatures-context',
				    'key'		=> 'identity',
				    'altkey'	=> 'name',
				    'default'	=> $element['meetmefeatures']['context']['default'],
				    'selected'	=> $info['meetmefeatures']['context']),
			      $context_list);
else:
	echo	'<div id="fd-meetmefeatures-context" class="txt-center">',
		$url->href_htmln($this->bbf('create_context'),
				'service/ipbx/system_management/context',
				'act=add'),
		'</div>';
endif;

	echo	$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_noplaymsgfirstenter'),
				      'name'	=> 'meetmefeatures[noplaymsgfirstenter]',
				      'labelid'	=> 'meetmefeatures-noplaymsgfirstenter',
				      'default'	=> $element['meetmefeatures']['noplaymsgfirstenter']['default'],
				      'checked' => $info['meetmefeatures']['noplaymsgfirstenter'])),

		$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_record'),
				      'name'	=> 'meetmefeatures[record]',
				      'labelid'	=> 'meetmefeatures-record',
				      'default'	=> $element['meetmefeatures']['record']['default'],
				      'checked' => $info['meetmefeatures']['record'])),

		$form->text(array('desc'	=> $this->bbf('fm_meetmefeatures_maxuser'),
				  'name'	=> 'meetmefeatures[maxusers]',
				  'labelid'	=> 'meetmefeatures-maxusers',
				  'size'	=> 5,
				  'default'	=> $element['meetmefeatures']['maxusers']['default'],
				  'value'	=> $info['meetmefeatures']['maxusers'],
				  'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetmefeatures','maxusers')))),

		$form->text(array('desc'	=> $this->bbf('fm_meetmefeatures_preprocess-subroutine'),
				  'name'	=> 'meetmefeatures[preprocess_subroutine]',
				  'labelid'	=> 'meetmefeatures-preprocess-subroutine',
				  'size'	=> 15,
				  'default'	=> $element['meetmefeatures']['preprocess_subroutine']['default'],
				  'value'	=> $info['meetmefeatures']['preprocess_subroutine'],
				  'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetmefeatures','preprocess_subroutine'))));
?>
	<div class="fm-paragraph fm-description">
		<p>
			<label id="lb-meetmefeatures-description" for="it-meetmefeatures-description">
				<?=$this->bbf('fm_meetmefeatures_description');?>
			</label>
		</p>
		<?=$form->textarea(array('paragraph'	=> false,
					 'label'	=> false,
					 'name'		=> 'meetmefeatures[description]',
					 'id'		=> 'it-meetmefeatures-description',
					 'cols'		=> 60,
					 'rows'		=> 5,
					 'default'	=> $element['meetmefeatures']['description']['default'],
					 'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetmefeatures','description'))),
				   $info['meetmefeatures']['description']);?>
	</div>
</div>

<div id="sb-part-administrator" class="b-nodisplay">
<?php
	echo	$form->select(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-typefrom'),
				    'name'	=> 'meetmefeatures[admin_typefrom]',
				    'labelid'	=> 'meetmefeatures-admin-typefrom',
				    'key'	=> false,
				    'bbf'	=> 'fm_meetmefeatures_admin-typefrom-opt',
				    'bbfopt'	=> array('argmode'	=> 'paramvalue'),
				    'default'	=> $element['meetmefeatures']['admin_typefrom']['default'],
				    'selected'	=> $info['meetmefeatures']['admin_typefrom']),
			      $element['meetmefeatures']['admin_typefrom']['value']),

		$form->hidden(array('name'	=> 'meetmefeatures[admin_internalid]',
				    'id'	=> 'it-meetmefeatures-admin-internalid',
				    'value'	=> $info['meetmefeatures']['admin_internalid'])),

		$form->text(array('desc'	=> '&nbsp;',
				  'name'	=> 'meetme-admin-suggest',
				  'labelid'	=> 'meetme-admin-suggest',
				  'size'	=> 20,
				  'default'	=> $this->bbf('fm_meetme_admin-suggest-default'),
				  'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetme-admin-suggest')))),

		$form->text(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-externalid'),
				  'name'	=> 'meetmefeatures[admin_externalid]',
				  'labelid'	=> 'meetmefeatures-admin-externalid',
				  'value'	=> $info['meetmefeatures']['admin_externalid'],
				  'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetmefeatures','admin_externalid')))),

		$form->text(array('desc'	=> $this->bbf('fm_meetmeroom_pinadmin'),
				  'name'	=> 'meetmeroom[pinadmin]',
				  'labelid'	=> 'meetmeroom-pinadmin',
				  'size'	=> 15,
				  'default'	=> $element['meetmeroom']['pinadmin']['default'],
				  'value'	=> $info['meetmeroom']['pinadmin'],
				  'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetmeroom','pinadmin')))),

		$form->select(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-identification'),
				    'name'	=> 'meetmefeatures[admin_identification]',
				    'labelid'	=> 'meetmefeatures-admin-identification',
				    'key'	=> false,
				    'bbf'	=> 'fm_meetmefeatures_admin-identification-opt',
				    'bbfopt'	=> array('argmode'	=> 'paramvalue'),
				    'default'	=> $element['meetmefeatures']['admin_identification']['default'],
				    'selected'	=> $info['meetmefeatures']['admin_identification']),
			      $element['meetmefeatures']['admin_identification']['value']),

		$form->select(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-mode'),
				    'name'	=> 'meetmefeatures[admin_mode]',
				    'labelid'	=> 'meetmefeatures-admin-mode',
				    'key'	=> false,
				    'bbf'	=> 'fm_meetmefeatures_admin-mode-opt',
				    'bbfopt'	=> array('argmode'	=> 'paramvalue'),
				    'default'	=> $element['meetmefeatures']['admin_mode']['default'],
				    'selected'	=> $info['meetmefeatures']['admin_mode']),
			      $element['meetmefeatures']['admin_mode']['value']),

		$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-announceusercount'),
				      'name'	=> 'meetmefeatures[admin_announceusercount]',
				      'labelid'	=> 'meetmefeatures-admin-announceusercount',
				      'default'	=> $element['meetmefeatures']['admin_announceusercount']['default'],
				      'checked'	=> $info['meetmefeatures']['admin_announceusercount'])),

		$form->select(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-announcejoinleave'),
				    'name'	=> 'meetmefeatures[admin_announcejoinleave]',
				    'labelid'	=> 'meetmefeatures-admin-announcejoinleave',
				    'key'	=> false,
				    'bbf'	=> 'fm_meetmefeatures_admin-announcejoinleave-opt',
				    'bbfopt'	=> array('argmode'	=> 'paramvalue'),
				    'default'	=> $element['meetmefeatures']['admin_announcejoinleave']['default'],
				    'selected'	=> $info['meetmefeatures']['admin_announcejoinleave']),
			      $element['meetmefeatures']['admin_announcejoinleave']['value']),

		$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-moderationmode'),
				      'name'	=> 'meetmefeatures[admin_moderationmode]',
				      'labelid'	=> 'meetmefeatures-admin-moderationmode',
				      'default'	=> $element['meetmefeatures']['admin_moderationmode']['default'],
				      'checked' => $info['meetmefeatures']['admin_moderationmode'])),

		$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-initiallymuted'),
				      'name'	=> 'meetmefeatures[admin_initiallymuted]',
				      'labelid'	=> 'meetmefeatures-admin-initiallymuted',
				      'default'	=> $element['meetmefeatures']['admin_initiallymuted']['default'],
				      'checked'	=> $info['meetmefeatures']['admin_initiallymuted']));

if($moh_list !== false):
	echo	$form->select(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-musiconhold'),
				    'name'	=> 'meetmefeatures[admin_musiconhold]',
				    'labelid'	=> 'meetmefeatures-admin-musiconhold',
				    'empty'	=> true,
				    'key'	=> 'category',
				    'invalid'	=> ($this->get_var('act') === 'edit'),
				    'default'	=> ($this->get_var('act') === 'add' ?
				    		    $element['meetmefeatures']['admin_musiconhold']['default'] :
						    null),
				    'selected'	=> $info['meetmefeatures']['admin_musiconhold']),
			      $moh_list);
endif;

	echo	$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-poundexit'),
				      'name'	=> 'meetmefeatures[admin_poundexit]',
				      'labelid'	=> 'meetmefeatures-admin-poundexit',
				      'default'	=> $element['meetmefeatures']['admin_poundexit']['default'],
				      'checked'	=> $info['meetmefeatures']['admin_poundexit'])),

		$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-quiet'),
				      'name'	=> 'meetmefeatures[admin_quiet]',
				      'labelid'	=> 'meetmefeatures-admin-quiet',
				      'default'	=> $element['meetmefeatures']['admin_quiet']['default'],
				      'checked'	=> $info['meetmefeatures']['admin_quiet'])),

		$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-closeconflastmarkedexit'),
				      'name'	=> 'meetmefeatures[admin_closeconflastmarkedexit]',
				      'labelid'	=> 'meetmefeatures-admin-closeconflastmarkedexit',
				      'default'	=> $element['meetmefeatures']['admin_closeconflastmarkedexit']['default'],
				      'checked' => $info['meetmefeatures']['admin_closeconflastmarkedexit']));

if($context_list !== false):
	echo	$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-enableexitcontext'),
				      'name'	=> 'meetmefeatures[admin_enableexitcontext]',
				      'labelid'	=> 'meetmefeatures-admin-enableexitcontext',
				      'default'	=> $element['meetmefeatures']['admin_enableexitcontext']['default'],
				      'checked' => $info['meetmefeatures']['admin_enableexitcontext'])),

		$form->select(array('desc'	=> $this->bbf('fm_meetmefeatures_admin-exitcontext'),
				    'name'	=> 'meetmefeatures[admin_exitcontext]',
				    'labelid'	=> 'meetmefeatures-admin-exitcontext',
				    'key'	=> 'identity',
				    'altkey'	=> 'name',
				    'default'	=> $element['meetmefeatures']['admin_exitcontext']['default'],
				    'selected'	=> $info['meetmefeatures']['admin_exitcontext']),
			      $context_list);
endif;
?>
</div>

<div id="sb-part-user" class="b-nodisplay">
<?php
	echo	$form->select(array('desc'	=> $this->bbf('fm_meetmefeatures_user-mode'),
				    'name'	=> 'meetmefeatures[user_mode]',
				    'labelid'	=> 'meetmefeatures-user-mode',
				    'key'	=> false,
				    'bbf'	=> 'fm_meetmefeatures_user-mode-opt',
				    'bbfopt'	=> array('argmode'	=> 'paramvalue'),
				    'default'	=> $element['meetmefeatures']['user_mode']['default'],
				    'selected'	=> $info['meetmefeatures']['user_mode']),
			      $element['meetmefeatures']['user_mode']['value']),

		$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_user-announceusercount'),
				      'name'	=> 'meetmefeatures[user_announceusercount]',
				      'labelid'	=> 'meetmefeatures-user-announceusercount',
				      'default'	=> $element['meetmefeatures']['user_announceusercount']['default'],
				      'checked'	=> $info['meetmefeatures']['user_announceusercount'])),

		$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_user-hiddencalls'),
				      'name'	=> 'meetmefeatures[user_hiddencalls]',
				      'labelid'	=> 'meetmefeatures-user-hiddencalls',
				      'default'	=> $element['meetmefeatures']['user_hiddencalls']['default'],
				      'checked'	=> $info['meetmefeatures']['user_hiddencalls'])),

		$form->select(array('desc'	=> $this->bbf('fm_meetmefeatures_user-announcejoinleave'),
				    'name'	=> 'meetmefeatures[user_announcejoinleave]',
				    'labelid'	=> 'meetmefeatures-user-announcejoinleave',
				    'key'	=> false,
				    'bbf'	=> 'fm_meetmefeatures_user-announcejoinleave-opt',
				    'bbfopt'	=> array('argmode'	=> 'paramvalue'),
				    'default'	=> $element['meetmefeatures']['user_announcejoinleave']['default'],
				    'selected'	=> $info['meetmefeatures']['user_announcejoinleave']),
			      $element['meetmefeatures']['user_announcejoinleave']['value']),

		$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_user-initiallymuted'),
				      'name'	=> 'meetmefeatures[user_initiallymuted]',
				      'labelid'	=> 'meetmefeatures-user-initiallymuted',
				      'default'	=> $element['meetmefeatures']['user_initiallymuted']['default'],
				      'checked'	=> $info['meetmefeatures']['user_initiallymuted']));

if($moh_list !== false):
	echo	$form->select(array('desc'	=> $this->bbf('fm_meetmefeatures_user-musiconhold'),
				    'name'	=> 'meetmefeatures[user_musiconhold]',
				    'labelid'	=> 'meetmefeatures-user-musiconhold',
				    'empty'	=> true,
				    'key'	=> 'category',
				    'invalid'	=> ($this->get_var('act') === 'edit'),
				    'default'	=> ($this->get_var('act') === 'add' ?
				    		    $element['meetmefeatures']['user_musiconhold']['default'] :
						    null),
				    'selected'	=> $info['meetmefeatures']['user_musiconhold']),
			      $moh_list);
endif;

	echo	$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_user-poundexit'),
				      'name'	=> 'meetmefeatures[user_poundexit]',
				      'labelid'	=> 'meetmefeatures-user-poundexit',
				      'default'	=> $element['meetmefeatures']['user_poundexit']['default'],
				      'checked'	=> $info['meetmefeatures']['user_poundexit'])),

		$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_user-quiet'),
				      'name'	=> 'meetmefeatures[user_quiet]',
				      'labelid'	=> 'meetmefeatures-user-quiet',
				      'default'	=> $element['meetmefeatures']['user_quiet']['default'],
				      'checked'	=> $info['meetmefeatures']['user_quiet'])),

		$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_user-starmenu'),
				      'name'	=> 'meetmefeatures[user_starmenu]',
				      'labelid'	=> 'meetmefeatures-user-starmenu',
				      'default'	=> $element['meetmefeatures']['user_starmenu']['default'],
				      'checked'	=> $info['meetmefeatures']['user_starmenu']));

if($context_list !== false):
	echo	$form->checkbox(array('desc'	=> $this->bbf('fm_meetmefeatures_user-enableexitcontext'),
				      'name'	=> 'meetmefeatures[user_enableexitcontext]',
				      'labelid'	=> 'meetmefeatures-user-enableexitcontext',
				      'default'	=> $element['meetmefeatures']['user_enableexitcontext']['default'],
				      'checked' => $info['meetmefeatures']['user_enableexitcontext'])),

		$form->select(array('desc'	=> $this->bbf('fm_meetmefeatures_user-exitcontext'),
				    'name'	=> 'meetmefeatures[user_exitcontext]',
				    'labelid'	=> 'meetmefeatures-user-exitcontext',
				    'key'	=> 'identity',
				    'altkey'	=> 'name',
				    'default'	=> $element['meetmefeatures']['user_exitcontext']['default'],
				    'selected'	=> $info['meetmefeatures']['user_exitcontext']),
			      $context_list);
endif;
?>
</div>

<div id="sb-part-email" class="b-nodisplay">
<?php
	echo	$form->text(array('desc'	=> $this->bbf('fm_meetmefeatures_emailfrom'),
				  'name'	=> 'meetmefeatures[emailfrom]',
				  'labelid'	=> 'meetmefeatures-emailfrom',
				  'size'	=> 20,
				  'default'	=> $element['meetmefeatures']['emailfrom']['default'],
				  'value'	=> $info['meetmefeatures']['emailfrom'],
				  'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetmefeatures','emailfrom')))),

		$form->text(array('desc'	=> $this->bbf('fm_meetmefeatures_emailfromname'),
				  'name'	=> 'meetmefeatures[emailfromname]',
				  'labelid'	=> 'meetmefeatures-emailfromname',
				  'size'	=> 20,
				  'default'	=> $element['meetmefeatures']['emailfromname']['default'],
				  'value'	=> $info['meetmefeatures']['emailfromname'],
				  'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetmefeatures','emailfromname')))),

		$form->text(array('desc'	=> $this->bbf('fm_meetmefeatures_emailsubject'),
				  'name'	=> 'meetmefeatures[emailsubject]',
				  'labelid'	=> 'meetmefeatures-emailsubject',
				  'size'	=> 20,
				  'default'	=> $this->bbf('meetmefeatures_emailsubject'),
				  'value'	=> $info['meetmefeatures']['emailsubject'],
				  'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetmefeatures','emailsubject'))));
?>
	<div class="fm-paragraph fm-description">
		<p>
			<label id="lb-meetmefeatures-emailbody" for="it-meetmefeatures-emailbody">
				<?=$this->bbf('fm_meetmefeatures_emailbody');?>
			</label>
		</p>
		<?=$form->textarea(array('paragraph'	=> false,
					 'name'		=> 'meetmefeatures[emailbody]',
					 'label'	=> false,
					 'id'		=> 'it-meetmefeatures-emailbody',
					 'cols'		=> 60,
					 'rows'		=> 10,
					 'default'	=> $this->bbf('it-meetmefeatures-emailbody'),
					 'error'	=> $this->bbf_args('error',
					   $this->get_var('error','meetmefeatures','emailbody'))),
				   $info['meetmefeatures']['emailbody']);?>
	</div>
</div>

<div id="sb-part-last" class="b-nodisplay">
<?php
	$this->file_include('bloc/service/ipbx/asterisk/pbx_settings/meetme/guest');
?>
</div>
