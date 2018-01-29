<?php

function get_host_of_url($url) {
  if (!$url) return '';
  $a = parse_url($url);
  return isset($a['host']) ? $a['host'] : $url;
}
