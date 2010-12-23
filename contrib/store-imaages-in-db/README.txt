It is necessary to modify the my.cnf to allow InnoDB tables and to set the InnoDB up to auto increment. The usual defaults are way too small. Auto increment allows your table to get quite large. 

Execute the following to create the tables:

create-file-table.sql

copy these files into openemr/interface/patient_file/history/ :

getImageMetaData.php
getImage.php
history.php
upload.php
uploadprocess.php

The existing history.php file that I use is an older one and may not work with the most recent file.  I just dropped the following code in the the history.php table as an extra data element at the end of the file:

<td>
<a href="getImageMetaData.php" target="Main">
<span class=text>Cardiovascular</span><br>
<span class=text>Correspondence</span><br>
<span class=text>Gastrointestinal</span><br>
<span class=text>Hospital Reports</span><br>
<span class=text>Laboratory</span><br>
<span class=text>Operative Reports</span><br>
<span class=text>Miscellaneous</span><br>
<span class=text>Pulmonary</span><br>
<span class=text>X-Ray</span><br>
<span class=text>Administrative</span><br>
<span class=text>Billing</span><br> 
</a>
</td>

Sam Bowen, MD
oemr.org

// +-----------------------------------------------------------------------------+ 
// Copyright (C) 2006 OEMR.org
//
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
//
// A copy of the GNU General Public License is included along with this program:
// openemr/interface/login/GnuGPL.html
// For more information write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
// Author: 2006 Samuel T. Bowen, MD <drbowen@openmedsoftware.org>
//
// +------------------------------------------------------------------------------+
