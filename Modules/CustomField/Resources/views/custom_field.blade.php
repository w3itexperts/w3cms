@php
    $inputType      = $custom_field->input_type ? $custom_field->input_type : 'text';
    $field_id       = $custom_field->id; 
    $field_type_id  = $custom_field->custom_field_types->where('custom_field_type',$field_type)->first()->id; 
    $required       = '';
    
    if ($custom_field->required) {
        $required = "required='required'";
    }

    $field['id'] = $field_id .'_'. $field_type_id;
    $custom_field_value = optional(optional($custom_field->custom_metas)->first())->value;
    $field['old_field_value'] = @$custom_field_value ?? @$custom_field->value;
    $field['type'] = $inputType;
    $field['title'] = $custom_field->title;
    $options = array_map('trim', explode(',', $custom_field->params));
    $field['options'] = array_combine($options, $options);
    $child_custom_fields = $custom_field->child_custom_fields;
    
    if (!empty($child_custom_fields->toArray())) {
        $group_values = [];
        
        foreach ($child_custom_fields as $child_custom_field) {
            
            $inputType      = $child_custom_field->input_type ? $child_custom_field->input_type : 'text';
            $field_id       = $child_custom_field->id; 
            $field_type_id  = $child_custom_field->custom_field_types->where('custom_field_type',$field_type)->first()->id; 

            $group_field['id'] = $field_id .'_'. $field_type_id;
            $custom_field_value = optional(optional($child_custom_field->custom_metas)->first())->value;
            $custom_field_value = json_decode($custom_field_value);
            if ($custom_field_value) {
                foreach ($custom_field_value as $i => $value) {
                    $group_values[$i][$group_field['id']] = $value;
                }
            }

            $group_field['type'] = $inputType;
            $group_field['title'] = $child_custom_field->title;
            $options = array_map('trim', explode(',', $child_custom_field->params));
            $group_field['options'] = array_combine($options, $options);


            $group_params[] = $group_field;
        }

        $field['params'] = $group_params;
        $field['old_field_value'] = $group_values;
    
    }


@endphp

<label for="custom_field_{{ $field_id }}_{{ $custom_field->key }}" class="form-label d-block">{{ $custom_field->title }}</label> 

{!! ThemeOption::CreateField($field,'custom-fields') !!}
<small class="d-inline-block mt-1">{!! $custom_field->description !!}</small>