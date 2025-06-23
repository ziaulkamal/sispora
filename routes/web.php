<?php

foreach (glob(base_path('routes/web/*.php')) as $filename) {
    require $filename;
}