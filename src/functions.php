<?php
use Dawn\AssetManager;
use Dawn\Asset;

function register_script($name, $src, $dependency = array(), $version = '') {

}

function enqueue_script($name, $src, $dependency = array(), $version = '') {
}

function register_scripts($scripts = array()) {
    foreach ($scripts as $script) {
        register_script($script['name'], $script['src'], $script['dependency'], $script['version']);
    }
}

function register_style($name, $src, $dependency = array(), $version = '') {

}

function enqueue_style($name, $src, $dependency = array(), $version = '') {

}

function register_styles($styles = array()) {
    foreach ($styles as $style) {
        register_script($style['name'], $style['src'], $style['dependency'], $style['version']);
    }
}

function localize_script($handle, $obj_name, $data = array()) {

}

function getPath($name, $type = 'scripts') {

}

function getUrl($name, $type = 'scripts') {

}

function getScriptPath($name) {
    return getPath($name, 'scripts');
}

function getStylePath($name) {
    return getPath($name, 'styles');
}

function getScriptUrl($name) {
    return getUrl($name, 'scripts');
}

function getStyleUrl($name) {
    return getUrl($name, 'styles');
}