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

// Package version provides zabbix release version
package version

import (
	"fmt"
	"strings"

	"zabbix.com/pkg/tls"
)

const (
	APPLICATION_NAME        = "Zabbix Agent"
	ZABBIX_REVDATE          = "22 March 2021"
	ZABBIX_VERSION_MAJOR    = 5
	ZABBIX_VERSION_MINOR    = 4
	ZABBIX_VERSION_PATCH    = 0
	ZABBIX_VERSION_RC       = "rc1"
	ZABBIX_VERSION_RC_NUM   = "{ZABBIX_RC_NUM}"
	ZABBIX_VERSION_REVISION = "{ZABBIX_REVISION}"
	copyrightMessage        = "Copyright (C) 2021 Zabbix SIA\n" +
		"License GPLv2+: GNU GPL version 2 or later <http://gnu.org/licenses/gpl.html>.\n" +
		"This is free software: you are free to change and redistribute it according to\n" +
		"the license. There is NO WARRANTY, to the extent permitted by law."
)

var (
	titleMessage string = "{undefined}"
	compileDate  string = "{undefined}"
	compileTime  string = "{undefined}"
	compileOs    string = "{undefined}"
	compileArch  string = "{undefined}"
	compileMode  string
)

func ApplicationName() string {
	return APPLICATION_NAME
}
func RevDate() string {
	return ZABBIX_REVDATE
}

func Major() int {
	return ZABBIX_VERSION_MAJOR
}

func Minor() int {
	return ZABBIX_VERSION_MINOR
}

func Patch() int {
	return ZABBIX_VERSION_PATCH
}

func RC() string {
	return ZABBIX_VERSION_RC
}

func LongStr() string {
	var ver string = fmt.Sprintf("%d.%d.%d", Major(), Minor(), Patch())
	if len(RC()) != 0 {
		ver += " " + RC()
	}
	return ver
}

func Long() string {
	var ver string = fmt.Sprintf("%d.%d.%d", Major(), Minor(), Patch())
	if len(RC()) != 0 {
		ver += RC()
	}
	return ver
}

func Short() string {
	return fmt.Sprintf("%d.%d", Major(), Minor())
}

func Revision() string {
	return ZABBIX_VERSION_REVISION
}

func copyrightMessageMQTT() string {
	return "\nWe use the library Eclipse Paho (eclipse/paho.mqtt.golang), which is\n" +
		"distributed under the terms of the Eclipse Distribution License 1.0 (The 3-Clause BSD License)\n" +
		"available at https://www.eclipse.org/org/documents/edl-v10.php\n"
}

func copyrightMessageModbus() string {
	return "\nWe use the library go-modbus (goburrow/modbus), which is\n" +
		"distributed under the terms of the 3-Clause BSD License\n" +
		"available at https://github.com/goburrow/modbus/blob/master/LICENSE\n"
}

func CopyrightMessage() string {
	msg := copyrightMessage
	tlsMsg := tls.CopyrightMessage()
	if tlsMsg == "" {
		msg += "\n"
	} else {
		msg += tlsMsg
	}

	return msg + copyrightMessageModbus() + copyrightMessageMQTT()
}

func CompileDate() string {
	return compileDate
}

func CompileTime() string {
	return compileTime
}

func CompileOs() string {
	return compileOs
}

func CompileArch() string {
	return compileArch
}

func CompileMode() string {
	return compileMode
}

func TitleMessage() string {
	var title string = titleMessage
	if "windows" == compileOs {
		if -1 < strings.Index(compileArch, "64") {
			title += " Win64"
		} else {
			title += " Win32"
		}
	}

	if len(compileMode) != 0 {
		title += fmt.Sprintf(" (%s)", compileMode)
	}

	return title
}

func Display() {
	fmt.Printf("%s (Zabbix) %s\n", TitleMessage(), Long())
	fmt.Printf("Revision %s %s, compilation time: %s %s\n\n", Revision(), RevDate(), CompileDate(), CompileTime())
	fmt.Println(CopyrightMessage())
}
