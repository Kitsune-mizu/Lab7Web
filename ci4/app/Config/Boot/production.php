<?php

/*
 |--------------------------------------------------------------------------
 | ERROR DISPLAY
 |--------------------------------------------------------------------------
 | Don't show ANY in production environments. Instead, let the system catch
 | it and display a generic error message.
 |
 | If you set 'display_errors' to '1', CI4's detailed error report will show.
 */
// MENGUBAH TAMPILAN ERROR MENJADI AKTIF (UNTUK TRACING)
error_reporting(E_ALL);
ini_set('display_errors', '1');

/*
 |--------------------------------------------------------------------------
 | DEBUG MODE
 |--------------------------------------------------------------------------
 | Debug mode is an experimental flag that can allow changes throughout
 | the system. It's not widely used currently, and may not survive
 | release of the framework.
 */
// MENGUBAH DEBUG MODE MENJADI TRUE
defined('CI_DEBUG') || define('CI_DEBUG', true);