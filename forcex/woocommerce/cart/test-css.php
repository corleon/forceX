<?php
/**
 * CSS Loading Test - Remove after debugging
 */
defined('ABSPATH') || exit;

$manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
if (file_exists($manifest_path)) {
    $manifest = json_decode(file_get_contents($manifest_path), true);
    if (isset($manifest['src/main.js']['css'])) {
        $css_file = $manifest['src/main.js']['css'][0];
        $css_url = get_template_directory_uri() . '/dist/' . $css_file;
        echo '<!-- CSS File: ' . esc_url($css_url) . ' -->' . "\n";
        echo '<!-- CSS File Exists: ' . (file_exists(get_template_directory() . '/dist/' . $css_file) ? 'YES' : 'NO') . ' -->' . "\n";
    }
}
?>
