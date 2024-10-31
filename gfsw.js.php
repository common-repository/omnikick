<?php
header("Service-Worker-Allowed: /");
header("Content-Type: application/javascript");
header("X-Robots-Tag: none");
?>
const urlParams = new URLSearchParams(location.search);
const version = urlParams.has('_v') ? urlParams.get('_v') : '0.1.7';
let apiHost = '';
let siteId = '';
importScripts('https://cdn.omnikick.com/sw/serviceWorker.js?v=' + version);
