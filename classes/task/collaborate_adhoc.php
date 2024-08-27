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
 * Class for handling an adhoc task.
 *
 * @package   mod_collaborate
 * @copyright 2020 Richard Jones https://richardnz.net
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */
namespace mod_collaborate\task;

/**
 * An adhoc task.
 *
 * @package    mod_collaborate
 * @since      Moodle 2.7
 * @copyright  2015 Flash Gordon http://www.flashgordon.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */
class collaborate_adhoc extends \core\task\adhoc_task {
    /**
     *  Run all the tasks.
     */
    public function execute() {
        $trace = new \text_progress_trace();
        $cd = $this->get_custom_data();
        self::collaborate_do_adhoc_task($trace, $cd);
    }

    /**
     * Do adhoc task.
     *
     * @param progress_trace $trace object.
     * @param $data - form data to update a database record.
     */
    protected static function collaborate_do_adhoc_task(\progress_trace $trace, $data) {
        global $DB;
        $trace->output('Executing collaborate do adhoc task');
        if ($DB->record_exists('collaborate', array('id' => $data->id))) {
            $DB->update_record('collaborate', $data);
            mtrace(get_string('namechanged', 'mod_collaborate', $data));
            purge_other_caches();  // Purge the 'file and miscellaneous' cache so that our change(s) are seen.
        }
    }
}