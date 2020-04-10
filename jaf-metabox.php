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
//muestro el metabox 
add_action('add_meta_boxes','jaf_add_metabox');

//save the metabox data, cuando le damos a aztualizar el post o la pagina 
//que guarde los datos de nuestro metabox
add_action('save_post', 'jaf_mv_save_data');

function jaf_add_metabox(){

    add_meta_box('jaf_description',' Descripción de tu grupo','jaf_mvx_description', 'post');
}

//registro los campos del metabox
function jaf_mvx_description(){

    $values = get_post_custom( $post->ID );
    $jaf_valor = esc_attr($values['description'][0]); //recojo los valores anteriores si los hay
    $jaf_valor_text = esc_attr($values['nombre'][0]);
     
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
                        <textarea rows="3" cols="30" id="descripcion" class="widefat" name="descripcion">'.$jaf_valor.'</textarea> 
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
                        <input type="text" id="nombre" value="'.$jaf_valor_text.'">
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

function jaf_mv_save_data($post_id){       //recive el parametro de id del articulo

   /*  //compruebo que no guarde con auto salvado
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
        return;
    }
        //compruebo que tenga permiso para editar
    if( !current_user_can( 'edit_post' ) ){
        return;
    } */

    //si modifica alguno de los imput actualizo los datos
    if( isset( $_POST['descripcion'] ) || isset( $_POST['nombre'] ) ){

        update_post_meta( $post_id, 'description', esc_attr( $_POST['descripcion'] ) );
        update_post_meta( $post_id, 'nombre', esc_attr( $_POST['nombre'] ) );
     /*    update_post_meta($post_id, $meta_key, $meta_value, $prev_value) */

    }


}








?>