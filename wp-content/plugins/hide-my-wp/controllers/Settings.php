<?php

class HMW_Controllers_Settings extends HMW_Classes_FrontController {

    public $tabs;
    public $logout = false;

    public function __construct() {
        parent::__construct();
        add_filter('relative_url', array(HMW_Classes_ObjController::getClass('HMW_Models_Rewrite'), 'relative_url'));
    }

    function init() {
        $this->tabs = array('hmw_settings' => 'Permalinks');

        HMW_Classes_Error::setError('If a page is not working, add this parameter <strong>?hmw_disable=' . HMW_Classes_Tools::getOption('hmw_disable') . '</strong> to access the admin page');

        if (HMW_Classes_Tools::getOption('logout') && !HMW_Classes_Tools::getOption('error')) {
            $logoutForm = '
                        <form method="POST">
                            <input type="hidden" name="action" value="hmw_logout" />
                            <input type="hidden" name="hmw_nonce" value="' . wp_create_nonce(_HMW_NONCE_ID_) . '" />
                            <input type="submit" class="btn btn-success save" value="Yes, I\'m ready" />
                        </form>
                        ';
            $abortForm = '
                        <form method="POST">
                            <input type="hidden" name="action" value="hmw_abort" />
                            <input type="hidden" name="hmw_nonce" value="' . wp_create_nonce(_HMW_NONCE_ID_) . '" />
                            <input type="submit" class="btn btn-warning save" value="No, abort" />
                        </form>
                        ';
            HMW_Classes_Error::setError('Did you copied the safe code? Ready to log out? <div class="hmw_logout">' . $logoutForm . '</div><div class="hmw_abort" style="display: inline-block; margin-left: 5px;">' . $abortForm . '</div>');
        } elseif (HMW_Classes_Tools::getOption('error')) {
            $abortForm = '
                        <form method="POST">
                            <input type="hidden" name="action" value="hmw_abort" />
                            <input type="hidden" name="hmw_nonce" value="' . wp_create_nonce(_HMW_NONCE_ID_) . '" />
                            <input type="submit" class="btn btn-warning save" value="Cancel the changes" />
                        </form>
                        ';
            HMW_Classes_Error::setError(__('Action Required. Proceed with the instrutions or cancel the changes ', _HMW_PLUGIN_NAME_) . '<div class="hmw_abort" style="display: inline-block;">' . $abortForm . '</div>');

        }

        if (!get_option('permalink_structure')) {
            HMW_Classes_Error::setError(sprintf(__('Hide my WP does not work with %s Permalinks. Change it to %s or other type in Settings > Permalinks in order to hide it', _HMW_PLUGIN_NAME_), __('Plain'), __('Post Name')));
        }

        if (HMW_Classes_Tools::isNginx()) {
            HMW_Classes_Error::setError(sprintf(__('Nginx detected! You need %sHide my WP PRO%s to work with Nginx servers.', _HMW_PLUGIN_NAME_), '<a href="http://wpplugins.tips/wordpress" target="_blank">', '</a>'));
        }

        if (is_multisite()) {
            HMW_Classes_Error::setError(sprintf(__('WP Multisite detected! You need %sHide my WP PRO%s to work with WP Multisites.', _HMW_PLUGIN_NAME_), '<a href="http://wpplugins.tips/wordpress" target="_blank">', '</a>'));
        }

        HMW_Classes_ObjController::getClass('HMW_Classes_DisplayController')->loadMedia('settings');
        HMW_Classes_ObjController::getClass('HMW_Classes_DisplayController')->loadMedia('switchery.min');

        if (HMW_Classes_Tools::getIsset('page')) {
            foreach ($this->tabs as $slug => $value) {
                if (HMW_Classes_Tools::getValue('page') == $slug) {
                    echo $this->admin_tabs($slug);
                    HMW_Classes_ObjController::getClass('HMW_Classes_Error')->hookNotices();
                    echo $this->getView(ucfirst(str_replace('hmw_', '', $slug)));
                }
            }
        }

    }

    function admin_tabs($current = null) {
        $content = '';
        $content .= '<h2 class="nav-tab-wrapper">';
        foreach ($this->tabs as $location => $tabname) {
            if ($current == $location) {
                $class = ' nav-tab-active';
            } else {
                $class = '';
            }
            $content .= '<a class="nav-tab' . $class . '" href="?page=' . $location . '">' . $tabname . '</a>';
        }
        $content .= '</h2>';
        return $content;
    }

    /**
     * Called when Post action is triggered
     *
     * @return void
     */
    public function action() {
        parent::action();

        switch (HMW_Classes_Tools::getValue('action')) {

            case 'hmw_settings':
                if (HMW_Classes_Tools::getValue('data') <> '') {
                    parse_str(HMW_Classes_Tools::getValue('data'), $params);
                    $this->saveValues($params);
                    exit();
                } else {
                    $this->saveValues($_POST);
                }

                if (!HMW_Classes_Tools::getOption('error') && !HMW_Classes_Tools::getOption('logout')) {
                    HMW_Classes_ObjController::getClass('HMW_Models_Rewrite')->flushChanges();
                }

                break;

            case 'hmw_logout':
                if (ADMIN_COOKIE_PATH == rtrim(wp_make_link_relative(network_site_url(HMW_Classes_Tools::getOption('hmw_admin_url'))))) {

                    HMW_Classes_ObjController::getClass('HMW_Models_Rewrite')->flushChanges();
                    HMW_Classes_ObjController::getClass('HMW_Models_Rewrite')->wp_logout();
                    die();
                } else {
                    HMW_Classes_Error::setError(__("The value for 'ADMIN_COOKIE_PATH' in wp-config.php file is not set up correctly."));


                    HMW_Classes_Tools::saveOptions('error', true);
                    HMW_Classes_Tools::saveOptions('logout', false);
                }
                break;
            case 'hmw_savedefault':
                HMW_Classes_Tools::saveOptions('logout', false);

                $options = HMW_Classes_Tools::getOptions();
                foreach ($options as $key => $value) {
                    HMW_Classes_Tools::saveOptions($key, $value, true);
                }
                break;
            case 'hmw_abort':
                HMW_Classes_Tools::$options = HMW_Classes_Tools::getOptions(true);

                HMW_Classes_ObjController::getClass('HMW_Models_Rewrite')->hmw_create_config_cache(HMW_Classes_Tools::getOption('hmw_admin_url'));
                HMW_Classes_Tools::saveOptions('hmw_admin_url', HMW_Classes_Tools::getOption('hmw_admin_url'));
                HMW_Classes_Tools::saveOptions('error', false);
                HMW_Classes_Tools::saveOptions('logout', false);
                HMW_Classes_Tools::emptyCache();

                break;

            case 'hmw_manualrewrite':
                HMW_Classes_Tools::saveOptions('error', false);

                foreach (HMW_Classes_Tools::$options as $key => $value) {
                    HMW_Classes_Tools::saveOptions($key, $value, true);
                }

                HMW_Classes_Tools::emptyCache();

                break;
        }
    }

    public function saveValues($params) {
        if (!empty($params)) {
            HMW_Classes_Tools::saveOptions('error', false);
            HMW_Classes_Tools::$default['hmw_send_email'] = $params['hmw_send_email'];

            if ($params['hmw_mode'] == 'default') {
                $params = HMW_Classes_Tools::$default;
            }

            if ($params['hmw_mode'] == 'lite') {
                $params = @array_merge(HMW_Classes_Tools::$default, HMW_Classes_Tools::$lite);
            }


            //If the admin is changed, require a logout
            $lastsafeoptions = HMW_Classes_Tools::getOptions(true);
            if ($lastsafeoptions['hmw_admin_url'] <> $params['hmw_admin_url']) {
                HMW_Classes_Tools::saveOptions('logout', true);
            }


            foreach ($params as $key => $value) {
                $value = preg_replace('/[^a-z0-9-_.]/', '', $value);
                if ($value <> '' && $key <> 'action' && $key <> 'hmw_nonce') {
                    HMW_Classes_Tools::saveOptions($key, $value);
                }
            }

            if (!HMW_Classes_Tools::getOption('error')) {
                if ($params['hmw_admin_url'] == (HMW_Classes_Tools::$default['hmw_admin_url'])) {
                    if (!HMW_Classes_ObjController::getClass('HMW_Models_Rewrite')->hmw_remove_config_cache()) {
                        HMW_Classes_Tools::saveOptions('error', true);
                    }
                } elseif (!HMW_Classes_ObjController::getClass('HMW_Models_Rewrite')->hmw_create_config_cache($params['hmw_admin_url'])) {
                    HMW_Classes_Tools::saveOptions('error', true);
                }
            }

            //check if writable htaccess file
            if (!HMW_Classes_ObjController::getClass('HMW_Models_Rewrite')->is_writeable_Htaccess()) {
                //if not writeable, call the rules to show manually changes
                if (!HMW_Classes_ObjController::getClass('HMW_Models_Rewrite')->clearRedirect()->buildRedirect()->setRewriteRules()) {
                    HMW_Classes_Tools::saveOptions('error', true);
                }
            }


        }
    }

    function hookFooter() {
        HMW_Classes_Tools::saveOptions();
    }

}
