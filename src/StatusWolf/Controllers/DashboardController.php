<?php
/**
 * DashboardController
 *
 * Describe your class here
 *
 * Author: Mark Troyer <disco@box.com>
 * Date Created: 3 March 2014
 *
 */

namespace StatusWolf\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use StatusWolf\Security\User\SWUser;
use Symfony\Component\Security\Http\HttpUtils;

class DashboardController implements ControllerProviderInterface {

    public function connect(Application $sw) {
        $controllers = $sw['controllers_factory'];

        $controllers->get('/', function(Application $sw) {
            $user_token = $sw['security']->getToken();
            $user = $user_token->getUser();
            $username = $user instanceof SWUser ? $user->getUsername() : $user;
            $fullname = $user instanceof SWUser ? $user->getFullName() : '';
            $user_id = $user instanceof SWUser ? $user->getId() : '0';
            $widgets = get_widgets();
            $widgets_json = json_encode($widgets);
            return $sw['twig']->render('dashboard.html', array(
                'username' => $username,
                'fullname' => $fullname,
                'user_id' => $user_id,
                'sw_version' => '0.8.11',
                'extra_css' => array('dashboard.css',),
                'extra_js' => array(
                    'sw_lib.js',
                    'lib/jquery-ui.js',
                    'lib/date.js',
                    'lib/md5.js',
                    'status_wolf_colors.js',
                    'lib/jquery.autocomplete.js',
                    'lib/jquery.datatables.min.js',
                ),
                'widgets' => $widgets,
                'widgets_json' => $widgets_json,
                'dashboard_id' => false,
            ));
        })->bind('dashboard_home');

        $controllers->get('/{id}', function(Application $sw, $id) {
            $user_token = $sw['security']->getToken();
            $user = $user_token->getUser();
            $username = $user instanceof SWUser ? $user->getUsername() : $user;
            $fullname = $user instanceof SWUser ? $user->getFullName() : '';
            $user_id = $user instanceof SWUser ? $user->getId() : '0';
            $widgets = get_widgets();
            $widgets_json = json_encode($widgets);
            return $sw['twig']->render('dashboard.html', array(
                'username' => $username,
                'fullname' => $fullname,
                'user_id' => $user_id,
                'sw_version' => '0.8.11',
                'extra_css' => array('dashboard.css', 'widget_base.css'),
                'extra_js' => array(
                    'sw_lib.js',
                    'lib/jquery-ui.js',
                    'lib/date.js',
                    'lib/md5.js',
                    'status_wolf_colors.js',
                    'lib/jquery.autocomplete.js',
                    'lib/jquery.datatables.min.js',
                ),
                'widgets' => $widgets,
                'widgets_json' => $widgets_json,
                'dashboard_id' => $id,
            ));
        })->bind('dashboard_load');

        return $controllers;
    }

}
