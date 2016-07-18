<?php
namespace Framework\Views\Pages;

/**
 * Lewis Lancaster 2016
 *
 * Class Index
 *
 * @package Framework\Views\Pages
 */

use Framework\Exceptions\ViewException;
use Framework\Views\Structures\Page;
use Flight;

class Index implements Page
{

    /**
     * Called when a page is sent a 'GET' request
     *
     * @param null $splat
     *
     * @return mixed
     */

    public function get( $splat=null )
    {

        throw new ViewException('Get called');
    }

    /**
     * Called when a page is sent a 'POST' request.
     *
     * @param $post
     *
     * @param null $splat
     *
     * @return mixed
     */

    public function post( $post, $splat=null )
    {

        throw new ViewException('Post called');
    }
}