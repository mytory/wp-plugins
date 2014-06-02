<?php
    class Postcode_finder implements Iterator {
        public function __construct (&$csv_handle, $dong, $col_dong=4) {
            $this->csv_handle = $csv_handle;
            $this->dong = $dong;
            $this->col_dong = $col_dong;
            $this->count = -1;
            $this->current = false;
        }
        public function current () {
            return $this->current;
        }
        public function key () {
            return $this->count;
        }
        public function next () {
            while (($row = fgetcsv($this->csv_handle))
                   && !$this->match($row));
            if ($this->valid()) {
                $this->current = $row;
                $this->count++;
            } else {
                $this->current = false;
            }
        }
        public function rewind () {
            $this->count = -1;
            $this->next();
        }
        public function valid () {
            return !feof($this->csv_handle);
        }
        private function match ($row) {
            return mb_strpos($row[$this->col_dong],
                             $this->dong, 0, 'utf8') !== false;
        }
    }