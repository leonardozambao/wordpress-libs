<?php


class VueJS
{
    public function __construct()
    {
        // echo '<script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>';
        // echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js" integrity="sha256-S1J4GVHHDMiirir9qsXWc8ZWw74PHHafpsHp5PXtjTs=" crossorigin="anonymous"></script>';
        // echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" integrity="sha256-PHcOkPmOshsMBC+vtJdVr5Mwb7r0LkSVJPlPrp/IMpU=" crossorigin="anonymous" />';
    }

    public function ViewComponent($component) {
        require_once get_template_directory().'/VueComponents/'.$component.'.php';
    }
}