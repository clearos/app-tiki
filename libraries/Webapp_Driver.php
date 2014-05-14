<?php

/**
 * Tiki Wiki CMS Groupware webapp driver.
 *
 * @category   apps
 * @package    tiki
 * @subpackage libraries
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2014 ClearFoundation
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/tiki/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Lesser General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// N A M E S P A C E
///////////////////////////////////////////////////////////////////////////////

namespace clearos\apps\tiki;

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// T R A N S L A T I O N S
///////////////////////////////////////////////////////////////////////////////

clearos_load_language('tiki');

///////////////////////////////////////////////////////////////////////////////
// D E P E N D E N C I E S
///////////////////////////////////////////////////////////////////////////////

use \clearos\apps\base\File as File;
use \clearos\apps\system_database\System_Database as System_Database;
use \clearos\apps\webapp\Webapp_Engine as Webapp_Engine;

clearos_load_library('base/File');
clearos_load_library('system_database/System_Database');
clearos_load_library('webapp/Webapp_Engine');

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Tiki Wiki CMS Groupware webapp driver.
 *
 * @category   apps
 * @package    tiki
 * @subpackage libraries
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2014 ClearFoundation
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/tiki/
 */

class Webapp_Driver extends Webapp_Engine
{
    ///////////////////////////////////////////////////////////////////////////////
    // V A R I A B L E S
    ///////////////////////////////////////////////////////////////////////////////

    const FILE_PRECONFIG = 'db/preconfiguration.php';

    ///////////////////////////////////////////////////////////////////////////////
    // M E T H O D S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Tiki Wiki CMS Groupware webapp constructor.
     */

    public function __construct()
    {
        clearos_profile(__METHOD__, __LINE__);

        parent::__construct('tiki');
    }

    /**
     * Returns admin URLs.
     *
     * @return array list of admin URLs
     * @throws Engine_Exception
     */

    function get_admin_urls()
    {
        clearos_profile(__METHOD__, __LINE__);

        $this->_load_config();

        $urls = array();

        if ($this->get_hostname_access())
            $urls[] = 'https://' . $this->get_hostname() . '/tiki-login.php';

        if ($this->get_directory_access())
            $urls[] = 'https://' . $this->_get_ip_for_url() . $this->get_directory() . '/tiki-login.php';

        return $urls;
    }

    /**
     * Returns database admin URL.
     *
     * @return string database admin URL
     * @throws Engine_Exception
     */

    function get_database_url()
    {
        clearos_profile(__METHOD__, __LINE__);

        return '/app/tiki/database/login';
    }

    /**
     * Returns default directory access policy.
     *
     * @return boolean default directory access policy
     */

    function get_directory_access_default()
    {
        clearos_profile(__METHOD__, __LINE__);

        return TRUE;
    }

    /**
     * Returns default hostname access policy.
     *
     * @return boolean default hostname access policy
     */

    function get_hostname_access_default()
    {
        clearos_profile(__METHOD__, __LINE__);

        return TRUE;
    }

    /**
     * Returns webapp nickname.
     *
     * @return string webapp nickname
     */

    public function get_nickname()
    {
        clearos_profile(__METHOD__, __LINE__);

        return 'tiki';
    }

    /**
     * Returns getting started message to guide end user.
     *
     * @return string getting started message
     */

    public function get_getting_started_message()
    {
        clearos_profile(__METHOD__, __LINE__);

        return lang('tiki_getting_started_message');
    }

    /**
     * Returns getting started URL.
     *
     * @return string getting started URL
     */

    public function get_getting_started_url()
    {
        clearos_profile(__METHOD__, __LINE__);

        if ($this->get_directory_access())
            return 'https://' . $this->_get_ip_for_url() . $this->get_directory() . '/tiki-install.php';

        if ($this->get_hostname_access())
            return 'https://' . $this->get_hostname() . '/tiki-install.php';
    }

    /**
     * Hook called by Webapp engine after unpacking files.
     *
     * @return void
     */

    protected function _post_unpacking_hook()
    {
        clearos_profile(__METHOD__, __LINE__);

        $database = new System_Database();
        $password = $database->get_password('tiki');

        $config = $this->path_install . '/' . self::PATH_WEBROOT . '/' . self::PATH_LIVE . '/' . self::FILE_PRECONFIG;

        $file = new File($config, TRUE);

        if ($file->exists())
            $file->delete();

        $file->create('apache', 'apache', '0660');

        $lines = "<?php\n";
        $lines .= "\$host_tiki_preconfig='127.0.0.1;port=3308';\n";
        $lines .= "\$user_tiki_preconfig='tiki';\n";
        $lines .= "\$pass_tiki_preconfig='$password';\n";
        $lines .= "\$dbs_tiki_preconfig='tiki';\n";

        $file->add_lines($lines);
    }
}
