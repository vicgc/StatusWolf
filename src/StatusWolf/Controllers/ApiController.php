<?php
/**
 * ApiController
 *
 * Describe your class here
 *
 * Author: Mark Troyer <disco@box.com>
 * Date Created: 4 March 2014
 *
 */

namespace StatusWolf\Controllers;


use Silex\Application;
use Silex\ControllerProviderInterface;

class ApiController implements ControllerProviderInterface {

    public function connect(Application $sw) {

        $sw->mount('/api/dashboard', new ApiDashboardController());
        $sw->mount('/api/session', new ApiSessionController());

        $controllers = $sw['controllers_factory'];

        $controllers->get('/load_saved_dashboard/{dashboard_id}', function(Application $sw, $dashboard_id) {
            return $sw->redirect('/api/get_dashboard_config/' . $dashboard_id);
        })->bind('load_saved_dashboard');

        return $controllers;
    }

}
