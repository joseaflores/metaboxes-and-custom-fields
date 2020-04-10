<?php
/*
* Plugin Name: Jaf Fast Metaboxes
* Plugin Uri:  http://joseaflores.com
* Description: Cuarto plugin en el que agregamos metaboxes y custom fields a los post, para asi guardar metadatos extra.
* Version: 1.0
* Author : joseaflores
* Author URI: https://joseaflores.com
* License: GPL2
*/


global $post;


// Función para agregar un nuevo metabox
function jaf_add_metabox(){

    add_meta_box('jaf_description',' Descripción de tu grupo','jaf_add_fields_to_description', 'post');
}
add_action('add_meta_boxes','jaf_add_metabox');
// Añado el metabox al hook 


// Función para registrar los campos del metabox
function jaf_add_fields_to_description(){

    $values = get_post_custom( $post->ID );
    $jaf_desc = esc_attr($values['description'][0]); //recojo los valores anteriores si los hay
    $jaf_name = esc_attr($values['nombre'][0]);
     
    //muestro los campos por medio de una tabla con clases de wordpress
    echo '
        <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="descripcion">Describe tu grupo</label>
                </th>
                <td>
                    <p>
                        <textarea rows="3" cols="30" id="descripcion" class="widefat" name="descripcion">'.$jaf_desc.'</textarea> 
                    </p>
                    <p>
                        Describe tu grupo de manera sencilla para que los demás se aclaren.
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="nombre">Comandante en jefe</label>
                </th>
                <td>
                    <p>
                        <input type="text" id="nombre" name="nombre" value="'.$jaf_name.'">
                    </p>
                    <p>
                        Quien va a dirigir el grupo.
                    </p>
                </td>
            </tr>
        </tbody>
        </table>'
    ;


}


// Funcion para guardar los datos de los campos personalizados
function jaf_save_data($post_id){       //recive el parametro de id del articulo

        // Si se ejecuta auto salvado salgo de la función
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
         return;
    }
         // Si no tiene permiso para editar salgo de la función
    if( !current_user_can( 'edit_post' ) ){
         return;
    }

    //si modifica alguno de los imput actualizo los datos
    if( isset( $_POST['descripcion'] ) || isset( $_POST['nombre'] ) ){
        update_post_meta( $post_id, 'description', esc_attr( $_POST['descripcion'] ) );
        update_post_meta( $post_id, 'nombre', esc_attr( $_POST['nombre'] ) );
    }
    

                    
                //Y para capturar y grabar los datos sería más seguro así:
                /* if ( isset( $_POST ) ) { 
                $description = sanitize_text_field( $_POST['description']); 
                $nombre = sanitize_text_field( $_POST['nombre']); 
                update_post_meta( $post_id, '_description', $description ); 
                update_post_meta( $post_id, '_nombre', $nombre ); 
                
                //update_post_meta($post_id, $meta_key, $meta_value, $prev_value)
                
            } */
}
add_action('save_post', 'jaf_save_data');



//función para mostrar los custom fields en el post
add_filter( 'the_content', 'jaf_show_custom_fields'); 
 
function jaf_show_custom_fields( $content ) { 
 $custom_fields = get_post_custom(); 
 if ( isset( $custom_fields['_descripcion'] ) && isset( $custom_fields['_nombre']) ) { 
  $description = esc_html ( $custom_fields['_descripcion'][0] ); 
  $nombre = esc_html ( $custom_fields['_nombre'][0] ); 
  $content .= '<p> Descripción: ' . $description . '</p>'; 
  $content .= '<p> Nombre: ' . $nombre . '</p>'; 
 } 
 return $content; 
}








?>