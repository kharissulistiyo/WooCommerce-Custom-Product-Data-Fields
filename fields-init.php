<?php

/**
 * (Example) Setting Up The Custom Product Data Fields.
 * Copy this function to your theme functions.php file.
 * Do not rename the function name, otherwise your fields won't be read.
 **/

if(!function_exists('wc_custom_product_data_fields')){

  function wc_custom_product_data_fields(){


    $custom_product_data_fields = array();

    $custom_product_data_fields[] = array(
          'tab_name'    => __('Custom Data', 'wc_cpdf'),
    );

    $custom_product_data_fields[] = array(
          'id'          => '_mytext',
          'type'        => 'text',
          'label'       => __('Text', 'wc_cpdf'),
          'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
          'class'       => 'large',
          'description' => __('Field description.', 'wc_cpdf'),
          'desc_tip'    => true,
    );

    $custom_product_data_fields[] = array(
          'id'          => '_mynumber',
          'type'        => 'number',
          'label'       => __('Number', 'wc_cpdf'),
          'placeholder' => __('Number.', 'wc_cpdf'),
          'class'       => 'short',
          'description' => __('Field description.', 'wc_cpdf'),
          'desc_tip'    => true,
    );

    $custom_product_data_fields[] = array(
          'id'          => '_mytextarea',
          'type'        => 'textarea',
          'label'       => __('Textarea', 'wc_cpdf'),
          'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
          'style'       => 'width:70%;height:140px;',
          'description' => __('Field description.', 'wc_cpdf'),
          'desc_tip'    => true,
    );

    $custom_product_data_fields[] = array(
          'id'          => '_mycheckbox',
          'type'        => 'checkbox',
          'label'       => __('Checkbox', 'wc_cpdf'),
          'description' => __('Field description.', 'wc_cpdf'),
          'desc_tip'    => true,
    );

    $custom_product_data_fields[] = array(
          'id'          => '_myselect',
          'type'        => 'select',
          'label'       => __('Select', 'wc_cpdf'),
          'options'     => array(
              'option_1'  => 'Option 1',
              'option_2'  => 'Option 2',
              'option_3'  => 'Option 3'
          ),
          'description' => __('Field description.', 'wc_cpdf'),
          'desc_tip'    => true,
    );

    $custom_product_data_fields[] = array(
          'id'          => '_myradio',
          'type'        => 'radio',
          'label'       => __('Radio', 'wc_cpdf'),
          'options'     => array(
                'radio_1' => 'Radio 1',
                'radio_2' => 'Radio 2',
                'radio_3' => 'Radio 3'
          ),
          'description' => __('Field description.', 'wc_cpdf'),
          'desc_tip'    => true,
    );

    $custom_product_data_fields[] = array(
          'id'         => '_myhidden',
          'type'       => 'hidden',
          'value'      => 'Hidden Value',
    );


    return $custom_product_data_fields;


  }



}

?>
