<?php

class FormBuilder
{
	public $Descriptor = 'label';		// label, placeholder
	public $Style = 'defaultForm';		//defaultForm, defaultFormRO
	public $ReadOnly = false;		//true, false
	public $TextBoxSize = 40;
	public $SetFormName = true;
	public $Heading;

	public function FlattenAttrs($attrs)
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
	public function __construct($name = false, $action = false, $method = 'POST')
	{
		global $PHP_SELF;

		if($name)
			$this->FormName = $name;
		else
			$this->FormName = 'form'. rand();

		if($action === false)
			$this->Action = $PHP_SELF;
		else
			$this->Action = $action;

		$this->Method = $method;
	}
	public function BeginForm($formOpts = false)
	{
		$opts = array(
			'name' => $this->FormName,
			'action' => $this->Action,
			'method' => $this->Method,
			'class' => $this->Style,
			'accept-charset' => 'utf-8',
		);

		if($formOpts)
			$opts = array_merge($opts, $formOpts);

		$this->Heading = '<form ' . $this->FlattenAttrs($opts) . ">
			<input type=\"hidden\" name=\"formName\" value=\"{$this->FormName}\">";
//			<!--input type=\"hidden\" name=\"{$this->FormName}[FormName]\" value=\"{$this->FormName}\" /--!>\n";

		echo $this->Heading;
	}
	public function BeginValidatedForm($formOpts = array())
	{
		$formOpts = array_merge($formOpts, array(
			'onsubmit' => 'return ValidateForm(this);'
		));

		echo $this->BeginForm($formOpts);
	}
	public function AddSelect($name, $title, $options, $selected = false, $formOpts = false)
	{
		if(!is_array($formOpts))
			$formOpts = array();

		if($this->SetFormName)
			$formOpts['name'] = "{$this->FormName}[{$name}]";
		else
			$formOpts['name'] = $name;

		if(!isset($formOpts['class']))
			$formOpts['class'] = '';

		$pullDown = '<select';
		$pullDown .= $this->FlattenAttrs($formOpts);
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
					{
						if((string)$key === (string)$v)
							$pullDown .= ' selected="selected"';
					}

				$pullDown .= ">$val</option>\n";
			}

		return $pullDown . "</select>\n";
	}
	public function AddSelectBox($name, $title, $options, $selected = array(), $formOpts = false)
	{
		if(!is_array($formOpts))
			$formOpts = array();

		$formOpts['multiple'] = false;

		return $this->AddSelect($name, $title, $options, $selected, $formOpts);
	}
	public function makeFormInputElement($type, $name, $value, $opts = array())
	{
		$attr = $this->FlattenAttrs(array_merge(array(
			'type' => $type,
			'name' => $name,
			'value' => $value,
		), $opts));

		return "<input $attr />\n";
	}
	public function AddTextArea($name, $value, $cols, $rows, $opt = array())
	{
		if($this->SetFormName)
			$name = "{$this->FormName}[{$name}]";

		$attr = $this->FlattenAttrs(array_merge(array(
			'name' => $name,
			'cols' => $cols,
			'rows' => $rows,
		), $opt));

		$value = htmlspecialchars($value);

		return "<textarea $attr>$value</textarea>\n";
	}
	public function AddTextField($name, $value, $size = 40, $maxlen = 0, $opt = false, $type = 'text')
	{
		$opts = array();

		if($size)
			$opts['size'] = $size;
		if($maxlen)
			$opts['maxlength'] = $maxlen;
		if($opt)
			$opts = array_merge($opts, $opt);
		if($this->SetFormName)
			$name = "{$this->FormName}[{$name}]";

		return $this->makeFormInputElement($type, $name, $value, $opts);
	}
	public function AddPassword($name, $value, $size = 40, $maxlen = 0, $opt = false)
	{
		return $this->AddTextField($name, $value, $size, $maxlen, $opt, 'password');
	}
	public function AddCheckBox($name, $label, $value = false, $checked = 0, $opt = array())
	{
		if($value === false)
			$value = 1;

		if($checked)
			$opt['checked'] = false;

		if($this->SetFormName)
			$name = "{$this->FormName}[{$name}]";

		$attr = $this->FlattenAttrs(array_merge(array(
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
	public function AddRadioButton($name, $label, $value, $testValue, $opt = array())
	{
		$opt['type'] = 'radio';

		return $this->AddCheckBox($name, $label, $value, ($value == $testValue), $opt);
	}
	public function AddFileButton($name)
	{
		return "<input type=\"file\" name=\"$name\" />\n";
	}
	public function AddSubmitButton($name, $value, $opt = array())
	{
		return $this->makeFormInputElement('submit', $name, $value, $opt);
	}
	public function AddButton($name, $value, $opt = array())
	{
		return $this->makeFormInputElement('button', $name, $value, $opt);
	}
	public function AddResetButton($value, $opt = array())
	{
		$attr = $this->FlattenAttrs(array_merge(array(
			'type' => 'reset',
			'value' => $value,
		), $opt));

		return "<input $attr />\n";
	}
	public function AddHiddenField($name, $value, $opts = array())
	{
		if($this->SetFormName)
			$name = "{$this->FormName}[{$name}]";
		return $this->makeFormInputElement('hidden', $name, $value, $opts);
	}
	public function EndForm()
	{
		echo "</FORM>\n";
	}
}
