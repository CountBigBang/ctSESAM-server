<?php
/*

    Copyright (c) 2015 Oliver Lau <ola@ct.de>, Heise Medien GmbH & Co. KG

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

require_once 'globals.php';

assert_basic_auth();

if ($dbh) {
  $sth = $dbh->prepare('SELECT * FROM `domains` WHERE `userid` = :userid');
  $sth->bindParam(':userid', $authenticated_user, PDO::PARAM_STR);
  $result = $sth->execute();
  $r = $sth->fetch(PDO::FETCH_ASSOC);
  if ($r) {
    $res['result'] = $r["data"];
  }
}
else {
  $res['status'] = 'error';
  $res['error'] = 'Connecting to database failed';
}

header('Content-Type: text/json');
$json = json_encode($res);
echo str_replace("\/", "/", $json);
