<?php
namespace Framework\Views\Structures;

/**
 * Lewis Lancaster 2016
 *
 * Interface Page
 *
 * @package Framework\Views\Structures
 */

interface Page
{

    /**
     * Called on post
     *
     * @param $post
     *
     * @param $splat
     *
     * @return mixed
     */

    public function post( $post, $splat );

    /**
     * Called on get
     *
     * @param $splat
     *
     * @return mixed
     */

    public function get( $splat=null );
}