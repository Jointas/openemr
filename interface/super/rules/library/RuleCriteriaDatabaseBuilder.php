<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RuleCriteriaDatabaseBuilder
 *
 * @author aron
 */
class RuleCriteriaDatabaseBuilder extends RuleCriteriaBuilder {

    function __construct() {
    }

    function build( $method, $methodDetail, $value ) {
        $exploded = explode("::", $value);
        if ( $exploded[0] == "LIFESTYLE" ) {
            $type = $exploded[1];
            echo $exploded[2];
            return new RuleCriteriaLifestyle( $type, sizeof( $exploded ) > 2 ? $exploded[2] : null );
        } else if ( $exploded[0] == 'CUSTOM' ) {
            $category = $exploded[1];
            $item = $exploded[2];
            $completed = $exploded[3] == "YES";
            $frequencyComparator = $exploded[4];
            $frequency = $exploded[5];
            return new RuleCriteriaDatabaseBucket( $category, $item, $completed,
                    $frequencyComparator, $frequency );
        } else {
            return new RuleCriteriaDatabaseCustom();
        }

        return null;
    }
    
}
?>
