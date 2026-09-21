<?php

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver Framework
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */

header('Content-Type: text/plain');
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? '?') . "\n";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? '?') . "\n";
echo "PATH_INFO:   " . ($_SERVER['PATH_INFO']   ?? '?') . "\n";
echo "PHP_SELF:    " . ($_SERVER['PHP_SELF']    ?? '?') . "\n";
echo "QUERY:       " . ($_SERVER['QUERY_STRING'] ?? '?') . "\n";
