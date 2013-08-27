<?
function makeForm($name = '', $action = false, $method = 'post', $formOpts = false)
{
	global $PHP_SELF;

	if($action === false)
		$action = $PHP_SELF;

	$opts = array(
		'name' => $name,
		'action' => $action,
		'method' => $method,
		'accept-charset' => 'utf-8',
	);

	if($formOpts)
		$opts = array_merge($opts, $formOpts);

	$form = '<form ' . HTMLFlattenAttrs($opts) . ">\n";

	return $form;
}

function makeFinalizeForm($name, $action = false, $method = 'post', $formOpts = array())
{
	$formOpts = array_merge($formOpts, array(
		'onsubmit' => 'return _FinalizeForm(this);'
	));

	return makeForm($name, $action, $method, $formOpts);
}

function formAddFinalizeFunction($formName, $fn)
{
	return makeFormHiddenItem('_FinalizeFunctions', $fn, array('disabled' => 'disabled'));
}

function formFinalizeSelectElts($fieldName, $formName = 'form')
{
	//evaluated in the context of _FinalizeForm(form)

	return "selectAllOptions(form.elements['$fieldName'])";
}

function formAddFinalizeSelectElts($formName, $fieldName)
{
	return formAddFinalizeFunction($formName, formFinalizeSelectElts($fieldName, $formName));
}

//-----------------------------------------------------------------------

function makeFormPullDown($name, $title, $options, $selected = false, $formOpts = false)
{
	if(!is_array($formOpts))
		$formOpts = array();

	$formOpts['name'] = $name;
	if(!isset($formOpts['class']))
		$formOpts['class'] = '';

	$pullDown = '<select';
	$pullDown .= HTMLFlattenAttrs($formOpts);
	$pullDown .= ">\n";

	if($title != '')
	{
		if(!array_key_exists('multiple', $formOpts))
		{
			$pullDown .= "\t<option value=\"\"";
			if(!strlen($selected))
				$pullDown .= ' selected="selected"';
			$pullDown .= ">$title</option>\n";

			$pullDown .= "\t<option value=\"\">----------------</option>\n";
		}
		else
			$pullDown = "$title: <br />" . $pullDown;
	}

	if($selected !== false && !is_array($selected))
		$selected = array($selected);

	if(is_array($options))
		foreach($options as $key => $val)
		{
			if(is_array($val))
			{
				if(isset($val['value']))
					$key = $val['value'];

				$val = $val['name'];
			}

			$pullDown .= "\t<option value=\"$key\"";
			if($selected)
				foreach($selected as $v)
					if((string)$key == (string)$v)
						$pullDown .= ' selected="selected"';

			$pullDown .= ">$val</option>\n";
		}

	return $pullDown . "</select>\n";
}

function makeFormSelectBox($name, $title, $options, $selected = array(), $formOpts = false)
{
	if(!is_array($formOpts))
		$formOpts = array();

	$formOpts['multiple'] = false;

	return makeFormPullDown($name, $title, $options, $selected, $formOpts);
}

function makeFormInputElement($type, $name, $value, $opts = array())
{
	$attr = HTMLFlattenAttrs(array_merge(array(
		'type' => $type,
		'name' => $name,
		'value' => $value,
	), $opts));

	return "<input $attr />\n";
}

function makeFormTextArea($name, $value, $cols, $rows, $opt = array())
{
	$attr = HTMLFlattenAttrs(array_merge(array(
		'name' => $name,
		'cols' => $cols,
		'rows' => $rows,
	), $opt));

	$value = htmlspecialchars($value);

	return "<textarea $attr>$value</textarea>\n";
}

function makeFormTextField($name, $value, $size = 40, $maxlen = 0, $opt = false, $type = 'text')
{
	$opts = array();

	if($size)
		$opts['size'] = $size;
	if($maxlen)
		$opts['maxlength'] = $maxlen;
	if($opt)
		$opts = array_merge($opts, $opt);

	return makeFormInputElement($type, $name, $value, $opts);
}

function makeFormPasswordField($name, $value, $size = 40, $maxlen = 0, $opt = false)
{
	return makeFormTextField($name, $value, $size, $maxlen, $opt, 'password');
}

function makeFormCheckBox($name, $label, $value = false, $checked = 0, $opt = array())
{
	if($value === false)
		$value = 1;

	if($checked)
		$opt['checked'] = false;

	$attr = HTMLFlattenAttrs(array_merge(array(
		'type' => 'checkbox',
		'name' => $name,
		'value' => $value,
	), $opt));

	$elt = "<input $attr>";

	if($label != '')
		return "<label>$elt $label</label>\n";
	else
		return $elt . "\n";
}

function makeFormRadioButton($name, $label, $value, $testValue, $opt = array())
{
	$opt['type'] = 'radio';

	return makeFormCheckBox($name, $label, $value, ($value == $testValue), $opt);
}

function makeFormFileButton($name)
{
	return "<input type=\"file\" name=\"$name\" />\n";
}

function makeFormSubmitButton($name, $value, $opt = array())
{
	return makeFormInputElement('submit', $name, $value, $opt);
}

function makeFormButton($name, $value, $opt = array())
{
	return makeFormInputElement('button', $name, $value, $opt);
}

function makeFormResetButton($value, $opt = array())
{
	$attr = HTMLFlattenAttrs(array_merge(array(
		'type' => 'reset',
		'value' => $value,
	), $opt));

	return "<input $attr />\n";
}

function makeFormImageButton($name, $value, $src, $opt = array())
{
	$opts = array_merge(array(
		'src' => $src,
	), $opt);

	return makeFormInputElement('image', $name, $value, $opts);
}

function makeFormHiddenItem($name, $value, $opts = array())
{
	return makeFormInputElement('hidden', $name, $value, $opts);
}

//-----------------------------------------------------------------------

function makeFormCheckboxArray($name, $arr, $sel, $width)
{
	$s = '<table border="0" cellspacing="0" cellpadding="3">';

	$cnt = 0;
	foreach($arr as $k => $v)
	{
		if(!$cnt++)
			$s .= '<tr>';

		$s .= '<td>';
		$s .= makeFormCheckBox($name . "[$k]", $v, $k, $sel[$k]);
		$s .= '</td>';

		if($cnt == $width)
		{
			$s .= '</tr>';
			$cnt = 0;
		}
	}

	if($cnt)
		$s .= '</tr>';

	$s .= '</table>';

	return $s;
}

function makeFormHiddenItemList($arr, $name = '')
{
	$s = '';
	foreach($arr as $k => $v)
	{
		if($name)
			$kn = $name . "[$k]";
		else
			$kn = $k;

		if(!is_array($v))
			$s .= makeFormHiddenItem($kn, $v);
		else
			$s .= makeFormHiddenItemList($v, $kn);
	}

	return $s;
}

//-----------------------------------------------------------------------

function makeFormSelectBoxOrderButtons($formName, $selListName)
{
	$selListElt = "document.$formName.elements['$selListName']";

	$s = <<< EOF
		<a href="javascript:;" onclick="reorderSelectedOptions($selListElt, -1)"><img src="/images/uparrow.gif" width="13" height="14" border="0" /></a>
		<br /><br />
		<a href="javascript:;" onclick="reorderSelectedOptions($selListElt, +1)"><img src="/images/downarrow.gif" width="13" height="14" border="0" /></a>
EOF;

return $s;
}

function makeFormSelectBoxWithOrder($formName, $name, $title, $options, $selected = array(), $formOpts = false, $withOrder = true)
{
	$s = '';

	if($withOrder)
		$s .= '<table border="0" cellspacing="0" cellpadding="4"><tr valign="middle"><td>';

	$s .= makeFormSelectBox($name, $title, $options, $selected, $formOpts);

	if($withOrder)
	{
		$s .= '</td><td valign="middle">';
		$s .= makeFormSelectBoxOrderButtons($formName, $name);
		$s .= '</td></tr></table>';
	}

	return $s;
}

//-----------------------------------------------------------------------

function makeSelectBoxEditPanels($selection, $formName, $varName, $buttonNames, $invalidSelection = array())
{
	if(count($invalidSelection))
	{
		$js = "<script type=\"text/javascript\">\n";

		$js .= "var _PanelInvalidList = new Array(" . count($invalidSelection) . ");";

		foreach($invalidSelection as $k => $isInval)
			$js .= "_PanelInvalidList[$k] = $isInval;";

		$js .= "\n</script>";
	}
	else
		$js = '';

	$selBox = makeFormSelectBoxWithOrder($formName, $varName, '', $selection, array(), array('onchange' => '_PanelChange(this)'));

	$buttons = '';

	if($buttonNames['new'])
		$buttons .= makeFormSubmitButton('func', $buttonNames['new'], array('id' => 'newBtn')) . ' ';

	if($buttonNames['edit'])
		$buttons .= makeFormSubmitButton('func', $buttonNames['edit'], array('id' => 'editBtn', 'disabled' => 1)) . ' ';

	if($buttonNames['copy'])
		$buttons .= makeFormSubmitButton('func', $buttonNames['copy'], array('id' => 'copyBtn', 'disabled' => 1)) . ' ';

	if($buttonNames['delete'])
		$buttons .= makeFormSubmitButton('func', $buttonNames['delete'], array('id' => 'delBtn', 'disabled' => 1)) . ' ';

	if($buttonNames['done'])
		$buttons .=  '<br />' . makeFormSubmitButton('func', $buttonNames['done'], array('onclick' => formFinalizeSelectElts($varName)));

	return array(
		'js' => $js,
		'selBox' => $selBox,
		'buttons' => $buttons,
	);
}

//-----------------------------------------------------------------------

function makeFormMigrationBox($formName, $name, $options, $selected, $limit, $opt, $prop = array())
{
	static $selListID;

	if(!isset($selListID))
		$selListID = 0;
	else
		$selListID++;

	$selListName = '__selectList' . $selListID;

	$complistField = $name;

	if(!is_array($selected))
		if($selected)
			$selected = array($selected);
		else
			$selected = array();

	$selList = array();
	foreach($selected as $k)
		if(isset($options[$k]))
		{
			$selList[$k] = $options[$k];
			unset($options[$k]);
		}

	if($limit)
		$limit = max($limit, count($selList));
	else
		$limit = 0;

	$out =  formAddFinalizeSelectElts($formName, $complistField);

	$defaultButtonSpec = array(
		'br' => array(
			'type' => 'br',
			'spec' => array(),
		),

		'add' => array(
			'name' => Language('migration:add'),
			'type' => 'image',
			'spec' => array(
				'src' => '/images/add.gif',
				'onclick' => "copySelected(*OPTLIST*, this.form.elements['$complistField'], $limit);",
			),
		),

		'remove' => array(
			'name' => Language('migration:remove'),
			'type' => 'image',
			'spec' => array(
				'src' => '/images/remove.gif',
				'onclick' => "copySelected(this.form.elements['$complistField'], *OPTLIST*);",
			),
		),
	);

	if(!$prop['buttonList'])
		$buttonList = array('add', 'br', 'remove');
	else
		$buttonList = $prop['buttonList'];

	$out .= '<table border="0" cellspacing="0" cellpadding="4"><tr valign="middle"><td>';

	$out .= makeFormSelectBox($selListName, '', $options, '', $opt);

	if($prop['multiline'])
		$out .= '<br />';
	else
		$out .= '</td><td align="center">';

	foreach($buttonList as $button)
	{
		if(!is_array($button))
			$button = $defaultButtonSpec[$button];
		else
		{
			if(!isset($button['spec']))
				$button['spec'] = array();

			if($button['inherit'])
			{
				$b = array_merge($defaultButtonSpec[$button['inherit']], $button);
				$b['spec'] = array_merge($defaultButtonSpec[$button['inherit']]['spec'], $button['spec']);
				$button = $b;
			}
		}

		if($button['type'] == 'br')
			$out .= '<br />';
		else
		{
			if($prop['migrationAction'])
				$button['spec']['onclick'] .= $prop['migrationAction'];

			$button['spec']['onclick'] .= ' return false;';

			$button['spec']['onclick'] = str_replace('*OPTLIST*', "this.form.elements['$selListName']", $button['spec']['onclick']);
			$button['spec']['onclick'] = str_replace('*VALLIST*', "this.form.elements['$complistField']", $button['spec']['onclick']);

			$out .= makeFormInputElement($button['type'], '', $button['name'], $button['spec']);
		}

		$out .= '<br />';
	}

	if($prop['multiline'])
		$out .= '<br />';
	else
		$out .= '</td><td align="center">';

	$out .= makeFormSelectBoxWithOrder($formName, $complistField, '', $selList, array_keys($selList), $opt, $prop['order']);

	$out .= '</td></tr></table>';

	return $out;
}

//-----------------------------------------------------------------------
//Multi-Input Form Functions

function MIFJoinData($arr, $callback = '')
{
	$a = array();

	if($arr)
		foreach($arr as $v)
		{
			$s = '';

			if(function_exists($callback))
				$v = $callback($v);

			foreach($v as $k => $vv)
				$s .= "<[$k]>$vv</[$k]>";

			$a[] = $s;
		}

	return $a;
}

function MIFSplitData($str)
{
	$re = '/^\<([^>]+)\>(.*?)\<\/\1\>(.*)/';

	$arr = array();
	do
{
	if(preg_match($re, $str, $a))
	{
		$arr[$a[1]] = $a[2];
		$str = $a[3];
	}
	else
		$str = '';
} while($str != '');

return $arr;
}

function _MIFPrettyPrint($str, $callback = '')
{
	if(function_exists($callback))
		return $callback(MIFSplitData($str));
	else
		return '';
}

function MIFContainer($name, $dataPrefix, $vals, $callback, $formName, $valWidth = 0)
{
	$fieldName = $name . '[]';
	$store = "this.form.elements['$fieldName']";

	$s = '<br />';
	$s .= makeFormButton('', 'Add', array('onclick' => "return MIFAdd(this.form, '$dataPrefix', $store, $valWidth)"));
	$s .= makeFormButton('', 'Edit', array('onclick' => "MIFEdit(this.form, '$dataPrefix', $store)"));
	$s .= makeFormButton('', 'Delete', array('onclick' => "MIFDelete(this.form, $store)"));

	$s .= '<br /><br />';

	$a = array();
	if($vals)
		foreach($vals as $v)
		{
			$aK = $v;
			$aV = _MIFPrettyPrint($v, $callback);

			$a[htmlspecialchars_iw($aK)] = htmlspecialchars_iw($aV);
		}

	$s .= makeFormSelectBox($fieldName, '', $a, false, array('size' => 5));
	$s .= formAddFinalizeSelectElts($formName, $fieldName);

	return $s;
}

//-----------------------------------------------------------------------

function NSDateToday()
{
	return array('mon' => date('m'), 'day' => date('d'), 'year' => date('Y'));
}

function NSDateSelect($name, $value, $opt = false)
{
	$arr = array('');
	foreach(range(1, 12) as $v)
		$arr[$v] = $v;
	$out = makeFormPullDown($name . '[mon]', '', $arr, $value['mon'], $opt);

	$arr = array('');
	foreach(range(1, 31) as $v)
		$arr[$v] = $v;
	$out .= makeFormPullDown($name . '[day]', '', $arr, $value['day'], $opt);

	$curYr = date('Y');
	$arr = array('');
	foreach(range(2001, $curYr) as $v)
		$arr[$v] = $v;
	if(!$value['year'])
		$value['year'] = $curYr;
	$out .= makeFormPullDown($name . '[year]', '', $arr, $value['year'], $opt);

	return $out;
}

function HTMLFlattenAttrs($attrs)
{
	$s = '';
	if($attrs && count($attrs))
		foreach($attrs as $k => $v)
		{
			if($v === false)
				$v = $k;

			$s .= " $k=\"" . htmlspecialchars($v) . "\"";
		}

	return $s;
}
