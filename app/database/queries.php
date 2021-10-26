<?php

$query = [];

// query builders
require 'query-builder/read.php';
require 'query-builder/limit.php';
require 'query-builder/order.php';
require 'query-builder/paginate.php';
require 'query-builder/where.php';
require 'query-builder/join.php';
require 'query-builder/search.php';
require 'query-builder/execute.php';


// no query builder
require 'no-query-builder/create.php';
require 'no-query-builder/read.php';
require 'no-query-builder/update.php';
require 'no-query-builder/delete.php';
