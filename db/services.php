/**
 * @package    local_experience
 * @copyright  2020 Center for Learning Management (http://www.lernmanagement.at)
 * @author     Robert Schrenk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

// We define the web service functions to install.
$functions = array(
    'local_experience_injecttext' => array(
        'classname' => 'local_experience_external',
        'methodname' => 'injecttext',
        'classpath' => 'local/experience/externallib.php',
        'description' => 'Retrieves an injecttext.',
        'type' => 'read',
        'ajax' => 1,
    ),
    'local_experience_keycode' => array(
        'classname' => 'local_experience_external',
        'methodname' => 'keycode',
        'classpath' => 'local/experience/externallib.php',
        'description' => 'Performs an action upon keycode press.',
        'type' => 'read',
        'ajax' => 1,
    ),
);