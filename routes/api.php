<?php

foreach (glob(base_path('routes/api/*.php')) as $filename) {
    require $filename;
}