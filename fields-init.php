<?php

/**
 * WooCommerce product data tab definition
 *
 * @return array
 */

add_action('wc_cpdf_init', 'prefix_custom_product_data_tab_init', 10, 0);
if(!function_exists('prefix_custom_product_data_tab_init')) :

   function prefix_custom_product_data_tab_init(){


     $custom_product_data_fields = array();


     /** First product data tab starts **/
     /** ===================================== */

     $custom_product_data_fields['custom_data_1'] = array(

       array(
             'tab_name'    => __('Custom Data 2sss', 'wc_cpdf'),
       ),

       array(
             'id'          => '_mytext2',
             'type'        => 'text',
             'label'       => __('Text', 'wc_cpdf'),
             'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
             'class'       => 'large',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'          => '_mynumber2',
             'type'        => 'number',
             'label'       => __('Number', 'wc_cpdf'),
             'placeholder' => __('Number.', 'wc_cpdf'),
             'class'       => 'short',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'          => '_mytextarea2',
             'type'        => 'textarea',
             'label'       => __('Textarea', 'wc_cpdf'),
             'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
             'style'       => 'width:70%;height:140px;',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'          => '_mycheckbox2',
             'type'        => 'checkbox',
             'label'       => __('Checkbox', 'wc_cpdf'),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'          => '_myselect2',
             'type'        => 'select',
             'label'       => __('Select', 'wc_cpdf'),
             'options'     => array(
                 'option_1'  => 'Option 1',
                 'option_2'  => 'Option 2',
                 'option_3'  => 'Option 3'
             ),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'          => '_myradio2',
             'type'        => 'radio',
             'label'       => __('Radio', 'wc_cpdf'),
             'options'     => array(
                   'radio_1' => 'Radio 1',
                   'radio_2' => 'Radio 2',
                   'radio_3' => 'Radio 3'
             ),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'         => '_myhidden2',
             'type'       => 'hidden',
             'value'      => 'Hidden Value',
       ),


       // New field type goes here
       // Multiselect
       array(
             'id'         => '_mymultiselect22',
             'type'       => 'multiselect',
             'label'      => __('Multiselect', 'wc_cpdf'),
             'placeholder' => __('Multiselect maan!', 'wc_cpdf'),
             'options'     => array(
                   'option_1' => 'Option 1',
                   'option_2' => 'Option 2',
                   'option_3' => 'Option 3',
                   'option_4' => 'Option 4',
                   'option_5' => 'Option 5'
             ),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
             'class'       => 'medium'
       ),

       // image
       array(
             'id'         => '_myimage_12',
             'type'       => 'image',
             'label'      => __('Image 1', 'wc_cpdf'),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'         => '_myimage_22',
             'type'       => 'image',
             'label'      => __('Image 2', 'wc_cpdf'),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),


       array(
             'id'         => '_mygallery2',
             'type'       => 'gallery',
             'label'      => __('Gallery', 'wc_cpdf'),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       // Color
       array(
             'id'          => '_mycolor2',
             'type'        => 'color',
             'label'       => __('Select color', 'wc_cpdf'),
             'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
             'class'       => 'large',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'          => '_mycolor22',
             'type'        => 'color',
             'label'       => __('Select color 2', 'wc_cpdf'),
             'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
             'class'       => 'large',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       // Datepicker

       array(
             'id'          => '_mydatepicker2',
             'type'        => 'datepicker',
             'label'       => __('Select date', 'wc_cpdf'),
             'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
             'class'       => 'large',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'type'        => 'divider'
       ),

       array(
             'id'          => '_mydatepicker22',
             'type'        => 'datepicker',
             'label'       => __('Select date 2', 'wc_cpdf'),
             'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
             'class'       => 'large',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       )

     );

     /** First product data tab ends **/
     /** ===================================== */


     /** Second product data tab starts **/
     /** ===================================== */

     $custom_product_data_fields['custom_data_2'] = array(

       array(
             'tab_name'    => __('Custom Data ABC', 'wc_cpdf'),
       ),

       array(
             'id'          => '_mytext_abcd',
             'type'        => 'text',
             'label'       => __('Text ABCD', 'wc_cpdf'),
             'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
             'class'       => 'large',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       )

     );

     return $custom_product_data_fields;

   }

endif;
