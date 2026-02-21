<?php
/**
 * Plugin name: Admin-Bar-Panaikinimas
 * Version: 1.0
 */

function Panaikinimas() {
    if(!current_user_can("administrator")){
        add_filter("show_admin_bar","__return_false"); //filtras pakeicia duomenis pries tai kai WP juos apdoroja
    }
}

add_action("init","Panaikinimas"); //init action hook, kuris suveikia po to kai WP uzloadina

