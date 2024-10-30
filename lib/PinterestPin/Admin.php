<?php
class PinterestPin_Admin
{
    
    public function __construct() {
        add_action('admin_menu', array($this, 'menu'));
    }
    
    /**
     * Register the Menu.
     */
    public function menu() {
        add_menu_page('Pinterest Pin Settings', 'Pinterest Pin Settings', 'administrator', plugin_basename(PinterestPin::FILE), array($this, 'addPin'));
    }
    
    public function addPin() {
        if (isset($_POST['action'])) {
            $options = get_option(PinterestPin::OPTION_KEY . '_pin', array());
            $data['pin_button_size'] = $_POST['pin_button_size'];
            $data['pin_button_shape'] = $_POST['pin_button_shape'];
            $data['pin_count'] = $_POST['pin_count'];
            $options = $data;
            update_option(PinterestPin::OPTION_KEY . '_pin', $options);
            $this->addMessage('Pinterest setting has been updated successfully', 'success');
        }
        
        $templates = get_option(PinterestPin::OPTION_KEY, array());
        
        $queryArgs = array('page' => plugin_basename(PinterestPin::FILE) . '-addpin',);
        
        $data = array('queryArgs' => $queryArgs, 'baseUrl' => admin_url('/admin.php'), 'templates' => $templates, 'result' => get_option(PinterestPin::OPTION_KEY . '_pin', array()));
        echo PinterestPin_View::render('admin_addpin', $data);
    }
    
    private function addMessage($msg, $type = 'success') {
        if ($type == 'success') {
            printf("<div class='updated'><p><strong>%s</strong></p></div>", $msg);
        } else {
            printf("<div class='error'><p><strong>%s</strong></p></div>", $msg);
        }
    }
    
    private function redirectUrl($url) {
        echo '<script>';
        echo 'window.location.href="' . $url . '"';
        echo '</script>';
    }
}
?>
