<?php
/**
 * @package jaf_funtions
 * @version 0.1
 */
/*
Plugin Name: Mi funtions-php
Plugin URI: http://joseaflores.com
Description: Este es un plugin para agregar customizaciones al theme. Soportes, tipografias, widgetareas...
Author: Jose Angel Flores
Version: 0.1
Author URI: http://joseaflores.com
*/





function jaf_widget_area () {

    register_sidebar( array(
    'name' => 'top-bar-area',
    'id' => 'top-bar-area',
    'class' => 'top-bar-area',
    'description' => __( 'Widget area para mi top-bar', 'genesis-sample' ),
    'class' => 'top-bar-area',
    'before_widget' => '<div class=" top-bar-area widget-event">',
    'after_widget' => '</div>',
    'before_title' => '<h2>',
    'after_title' => '</h2>'


    ) );
};
add_action( 'genesis_init', 'jaf_widget_area' );

// Añadimos la nueva widget area en el hook deseado

if(is_page()){
add_action('genesis_header','jaf_widget');
   
        function jaf_widget(){
            genesis_widget_area('top-bar-area', array(

                'before'    => '<div id="top-bar-area" class="top-bar-area widget-area"> ',
                'after'     => '</div>'
            ));
        };        

};

// Elimino el do_header para poner una cabecera personalizada
add_action('genesis_before_header','jaf_eliminar_header');

function jaf_eliminar_header() {

    remove_action('genesis_header', 'genesis_do_header');
     
};

//agrego los icons de fontawesome
function load_fonts() {
    wp_register_script('font-awesome', 'https://kit.fontawesome.com/8c14d0a1fa.js');
    wp_enqueue_script('font-awesome');
    }
    add_action('wp_enqueue_scripts', 'load_fonts');

//agregar mis scripts
function jaf_load_fonts() {
    wp_register_script('mi-javascript', 'http://localhost/communities.dev/wp-content/themes/genesis-sample/js/mis-scripts.js');
    wp_enqueue_script('mi-javascript');
    }
    add_action('wp_enqueue_scripts', 'jaf_load_fonts');

//eliminar titulos de las paginas
add_action( 'get_header', 'jaf_eliminar_titulos_paginas' );

function jaf_eliminar_titulos_paginas() {
if ( is_page() ) {
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
}
}
















?>