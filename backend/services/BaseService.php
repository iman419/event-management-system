<?php
abstract class BaseService {
  protected function requireFields(array $data, array $fields) {
    foreach ($fields as $f) {
      if (!array_key_exists($f, $data) || $data[$f] === null || $data[$f] === '') {
        throw new InvalidArgumentException("Missing or empty field: $f");
      }
    }
  }
  protected function notEmptyString($val, $name, $min=1, $max=255) {
    if (!is_string($val)) throw new InvalidArgumentException("$name must be string");
    $len = mb_strlen(trim($val));
    if ($len < $min || $len > $max) throw new InvalidArgumentException("$name length invalid");
  }
  protected function positiveInt($val, $name) {
    if (!is_numeric($val) || (int)$val <= 0) throw new InvalidArgumentException("$name must be > 0");
  }
  protected function nonNegativeNumber($val, $name) {
    if (!is_numeric($val) || (float)$val < 0) throw new InvalidArgumentException("$name must be >= 0");
  }
}
