<?php

/*
 * Upload this file to:  htdocs/index.php   (the ROOT)
 * Fallback in case the host ignores the root .htaccess rewrite:
 * it simply hands the request to Laravel's real entry point in public/.
 */

require __DIR__.'/public/index.php';
