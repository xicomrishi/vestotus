<?php
$config = [
    'Templates'=>[
        'fullForm' => [
            'formStart' => '<form class="form-horizontal" {{attrs}}>',
            'label' => '<label class="control-label col-md-3 col-sm-3 col-xs-12" {{attrs}}>{{text}}</label>',
            'input' => ' <div class="col-md-6 col-sm-6 col-xs-12"><input type="{{type}}" name="{{name}}" {{attrs}} /></div>',
            'select' => '<div class="col-md-6 col-sm-6 col-xs-12"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
            'error' => ' <div class="error formerror">{{content}}</div>',
            'inputContainer' => '<div class="form-group {{required}}" form-type="{{type}}">{{content}}</div>',
            'checkContainer' => '',],
        'simpleForm' => [
            'formStart' => '<form class="" {{attrs}}>',
            'label' => '',
            'input' => '<input type="{{type}}" name="{{name}}" {{attrs}} />',
            'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
            'inputContainer' => '{{content}}',
            'error'=>'<label class="error">{{content}}</label>',
            'checkContainer' => '',],
       
    ]
];