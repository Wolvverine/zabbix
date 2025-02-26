<?php
/*
** Zabbix
** Copyright (C) 2001-2021 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/


class CMenuPopupHelper {

	/**
	 * Prepare data for dashboard popup menu.
	 *
	 * @param string $dashboardid
	 */
	public static function getDashboard($dashboardid, $editable) {
		return [
			'type' => 'dashboard',
			'data' => [
				'dashboardid' => $dashboardid,
				'editable' => $editable
			]
		];
	}

	/**
	 * Prepare data for item history menu popup.
	 *
	 * @param string $itemid
	 *
	 * @return array
	 */
	public static function getHistory($itemid) {
		return [
			'type' => 'history',
			'data' => [
				'itemid' => $itemid
			]
		];
	}

	/**
	 * Prepare data for Ajax host menu popup.
	 *
	 * @param string $hostid
	 * @param bool   $has_goto     Show "Go to" block in popup.
	 *
	 * @return array
	 */
	public static function getHost($hostid, $has_goto = true) {
		$data = [
			'type' => 'host',
			'data' => [
				'hostid' => $hostid
			]
		];

		if ($has_goto === false) {
			$data['data']['has_goto'] = '0';
		}

		return $data;
	}

	/**
	 * Prepare data for Ajax map element menu popup.
	 *
	 * @param string $sysmapid                   Map ID.
	 * @param array  $selement                   Map element data (ID, type, URLs, etc...).
	 * @param string $selement[selementid_orig]  Map element ID.
	 * @param string $selement[elementtype]      Map element type (host, map, trigger, host group, image).
	 * @param string $selement[urls]             Map element URLs.
	 * @param int    $severity_min               Minimum severity.
	 * @param string $hostid                     Host ID.
	 *
	 * @return array
	 */
	public static function getMapElement($sysmapid, $selement, $severity_min, $hostid) {
		$data = [
			'type' => 'map_element',
			'data' => [
				'sysmapid' => $sysmapid,
				'selementid' => $selement['selementid_orig'],
				'elementtype' => $selement['elementtype'],
				'urls' => $selement['urls']
			]
		];

		if (array_key_exists('unique_id', $selement)) {
			$data['data']['unique_id'] = $selement['unique_id'];
		}

		if ($severity_min != TRIGGER_SEVERITY_NOT_CLASSIFIED) {
			$data['data']['severity_min'] = $severity_min;
		}
		if ($hostid != 0) {
			$data['data']['hostid'] = $hostid;
		}

		return $data;
	}

	/**
	 * Prepare data for Ajax trigger menu popup.
	 *
	 * @param string $triggerid
	 * @param string $eventid      (optional) Mandatory for Acknowledge menu.
	 * @param bool   $acknowledge  (optional) Whether to show Acknowledge menu.
	 *
	 * @return array
	 */
	public static function getTrigger($triggerid, $eventid = 0, $acknowledge = false) {
		$data = [
			'type' => 'trigger',
			'data' => [
				'triggerid' => $triggerid
			]
		];

		if ($eventid != 0) {
			$data['data']['eventid'] = $eventid;
			$data['data']['acknowledge'] = $acknowledge ? '1' : '0';
		}

		return $data;
	}

	/**
	 * Prepare data for trigger macro menu popup.
	 *
	 * @return array
	 */
	public static function getTriggerMacro() {
		return [
			'type' => 'trigger_macro'
		];
	}

	/**
	 * Prepare data for item popup menu.
	 *
	 * @param array  $data
	 * @param string $data['itemid']   Item ID.
	 * @param string $data['context']  Additional parameter in URL to identify main section.
	 *
	 * @return array
	 */
	public static function getItem(array $data): array {
		return [
			'type' => 'item',
			'data' => [
				'itemid' => $data['itemid']
			],
			'context' => $data['context']
		];
	}

	/**
	 * Prepare data for item prototype popup menu.
	 *
	 * @param array  $data
	 * @param string $data['itemid']   Item ID.
	 * @param string $data['context']  Additional parameter in URL to identify main section.
	 *
	 * @return array
	 */
	public static function getItemPrototype(array $data): array {
		return [
			'type' => 'item_prototype',
			'data' => [
				'itemid' => $data['itemid']
			],
			'context' => $data['context']
		];
	}
}
