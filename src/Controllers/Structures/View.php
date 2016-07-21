<?php
namespace Framework\Controllers\Structures;


interface View
{

	public function getMap();

	public function process( $data=null );
}