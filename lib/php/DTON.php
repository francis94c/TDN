<?php
class SimpleReply {
  private $reply;
  function SimpleReply($r) {
    $this->reply = "[<$r>]";
  }
  function send() {
    exit ($this->reply);
  }
}
class ListReply {
  private $reply = "[(";
  private $isUnique = false;
  function ListReply($unique){
    $this->isUnique = $unique;
  }
  function add($item) {
    if ($this->isUnique == false) {
      $this->reply .= $item . ";";
    } else {
      if (strpos($this->reply, $item . ";") <= 0) {
        $this->reply .= $item . ";";
      }
    }
  }
  function setUnique($value) {
    $this->isUnique = $value;
  }
  function send() {
    exit ($this->reply . ")]");
  }
}
class KeyMapReply {
  private $reply = "[{";
  function add($key, $value) {
    $this->reply .= $key . "=>" . $value . ";";
  }
  function next() {
    if (strlen($this->reply) > 2) {
      $this->reply .= "}{";
    }
  }
  function send() {
    exit ($this->reply . "}]");
  }
}
class Table {
  private $reply = "[-+";
  private $collCount;
  function Table($columns) {
    $this->collCount = count($columns);
    for ($x = 0; $x < count($columns); $x++) {
      if ($x == count($columns) - 1) {
        $this->reply .= $columns[$x] . "+";
      }
      else {
        $this->reply .= $columns[$x] . "|";
      }
    }
  }
  function addRow($row) {
    $rowStr = "(";
    for ($x = 0; $x < $this->collCount; $x++) {
      if ($row[$x] == "") {
        $rowStr .= " ;";
      } else {
      $rowStr .= $row[$x] . ";";
      }
    }
    $rowStr .= ")";
    $this->reply .= $rowStr;
  }
  function hasRows() {
    $buffer = substr($this->reply, 3);
    $buffer = substr($buffer, strpos($buffer, "+") + 1);
    if (strlen($buffer) > 5) {
      return true;
    }
    return false;
  }
  function send() {
    $this->reply .= "-]";
    exit ($this->reply);
  }
}
?>