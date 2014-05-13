<?php

/**
 * Tiki Wiki CMS Groupware controller.
 *
 * @category   apps
 * @package    tiki
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2014 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/tiki/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Tiki Wiki CMS Groupware controller.
 *
 * @category   apps
 * @package    tiki
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2014 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/tiki/
 */

class Tiki extends ClearOS_Controller
{
    /**
     * Tiki Wiki CMS Groupware default controller.
     *
     * @return view
     */

    function index()
    {
        // Load libraries
        //---------------

        $this->lang->load('tiki');
        $this->load->library('tiki/Webapp_Driver');

        // Load view data
        //---------------

        try {
            $is_initialized = $this->webapp_driver->is_initialized();
        } catch (\Exception $e) {
            $this->page->view_exception($e);
            return;
        }

        // Load controllers
        //-----------------

        if (!$is_initialized)
            redirect('/tiki/initialize');

        $views = array('tiki/overview', 'tiki/upload', 'tiki/settings', 'tiki/advanced');

        $this->page->view_controllers($views, lang('tiki_app_name'));
    }
}
