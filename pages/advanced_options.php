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
 * @copyright  2020 Zentrum für Lernmanagement (www.lernmanagement.at)
 * @author    Robert Schrenk
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Show information page for big blue button.
 */

require('../../../config.php');
require_login();
$PAGE->set_url(new \moodle_url('/local/experience/pages/advanced_options.php', []));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('advanced_options', 'local_experience'));
$PAGE->set_heading(get_string('advanced_options', 'local_experience'));
// $PAGE->set_cacheable(false);

$ison = get_user_preferences('local_experience_level', 0) == 1;

$set = optional_param('set', 0, PARAM_INT);
if (!empty($set)) {
    set_user_preference('local_experience_level', $set > 0 ? 1 : 0);

    redirect($PAGE->url);
}

echo $OUTPUT->header();

?>
    <h3><?php echo get_string('advanced_options:description', 'local_experience') ?></h3>

    <div style="text-align: center;">
        <a href="<?php echo new moodle_url($PAGE->url, ['set' => $ison ? '-1' : '1']); ?>" class="btn btn-secondary">
            <i class="fa-solid fa-toggle-on"></i>
            <span><?php echo get_string('advanced_options', 'local_experience') . ': ' . get_string($ison ? 'on' : 'off', 'mnet'); ?></span>
        </a>
    </div>
    </div>
<?php

echo $OUTPUT->footer();
