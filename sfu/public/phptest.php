<?php
 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = 'holding_v1';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'Year', 'dt' => 0 ),
    array( 'db' => 'Name',  'dt' => 1 ),
    array( 'db' => 'Security_Type', 'dt' => 2 ),
    array( 'db' => 'Country', 'dt' => 3 ),
    array( 'db' => 'Currency',  'dt' => 4 ),
    array( 'db' => 'Sector', 'dt' => 5 ),
    array( 'db' => 'Sub_Industry', 'dt' => 6 ),
    array( 'db' => 'Industry_Sector',  'dt' => 7 ),
    array( 'db' => 'Industry_Group', 'dt' => 8 ),
    array(
        'db'        => 'Price',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {
            return '$'.number_format($d,2,'.','');
        }
    ),
    array( 'db' => 'Coupon',  'dt' => 10 ),
    array( 'db' => 'Maturity', 'dt' => 11 ),
    array( 'db' => 'Duration', 'dt' => 12 ),
    // array(
    //     'db'        => 'Duration',
    //     'dt'        => 12,
    //     'formatter' => function( $d, $row ) {
    //         return number_format($d,2,'.','');
    //     }
    // ),
    array( 'db' => 'YTM',  'dt' => 13 ),
    array(
        'db'        => 'Market_Value',
        'dt'        => 14,
        'formatter' => function( $d, $row ) {
            return '$'.number_format($d,2,'.',',');
        }
    ),
    array( 'db' => 'Minimum_Rating', 'dt' => 15 ),
    array( 'db' => 'DBRS_Rating', 'dt' => 16 ),
    array( 'db' => 'Manager',  'dt' => 17 ),
    array( 'db' => 'Category', 'dt' => 18 ),
    array( 'db' => 'ISIN', 'dt' => 19 )

);
 
// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => 'ai',
    'db'   => 'sfu_treasury',
    'host' => 'localhost'
);

require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

?>


















