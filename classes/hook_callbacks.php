<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    local_experience
 * @copyright  2021 Center for Learning Management (https://www.lernmanagement.at)
 * @author     Robert Schrenk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_experience;

defined('MOODLE_INTERNAL') || die;

class hook_callbacks {
    public static function after_config() {
        global $CFG;
        $scripts = array(
            '/course/dndupload.php',
        );
        $script = str_replace($CFG->dirroot, '', $_SERVER["SCRIPT_FILENAME"]);
        if (in_array($script, $scripts)) {
            \local_experience\lib_wshelper::buffer();
        }
    }

    public static function before_standard_head_html_generation(\core\hook\output\before_standard_head_html_generation $hook): void {
        global $CFG, $DB, $PAGE, $OUTPUT;

        $html = '';

        if (strpos($_SERVER["SCRIPT_FILENAME"], '/course/modedit.php') > 0) {
            $add = optional_param('add', '', PARAM_ALPHANUM);
            if (!empty($add)) {
                $enabled = \get_config('local_experience', 'auto_set_completion_details');
                $plusdays = \get_config('local_experience', 'auto_set_completion_add_days');
                if (!empty($enabled) && !empty($plusdays)) {
                    $PAGE->requires->js_call_amd("local_experience/main", "setCompletionDefaults", array($plusdays));
                }
            }
        }

        $PAGE->requires->js_call_amd("local_experience/main", "injectText", array());

        if ($PAGE->user_allowed_editing()) {
            $PAGE->requires->js_call_amd("local_experience/main", "captureKeycode", array());
        }

        $injectquestion = optional_param('local_experience_injectquestion', '', PARAM_TEXT);
        if (!empty($injectquestion)) {
            $x = explode(':', $injectquestion);
            if (count($x) == 3) {
                $html .= $OUTPUT->render_from_template('local_experience/overlay', []);
                $PAGE->requires->js_call_amd("local_experience/main", "injectQuestionTemplate", array($x[0], $x[1], $x[2]));
            }
        }

        $hook->add_html($html);
    }
}
