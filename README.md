text-engine
===========

some homework for text-game engine :) just for fun

Simple text-game quest engine for PHP (PHP 5.4).
Supports readline completes for command hints.

Start:

  $ php index.php
  
To exit game just command:

  > exit


Expected commands format:

  > &lt;command&gt; [&lt;argument&gt;]

For example:

  > look

  > take test_box

  > drop all

  > inventory

  > go north
  

And list of supported commands:
 _look_ ( _l_ ), _go_, _north_ ( _n_ ), _south_ ( _s_ ), _west_ ( _w_ ), _east_ ( _e_ ), _inventory_ ( _i_ ), _take_ (and _get_ alias), _drop_.
 
Commands _take_ and _drop_ can accept item name to drop or _all_ param (to take all room's items or drop all inventory items):

  > take test_box
