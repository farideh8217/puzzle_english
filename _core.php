<?php
$database = [
  'host'=>'localhost',
  'dbname'=>'puzzle_english',
  'user'=>'root',
  'pass'=>''
];
try {
  $db = new PDO("mysql:host={$database['host']};dbname={$database['dbname']}", $database['user'], $database['pass']);
} catch (PDOException $e) {
  exit("An error happend, Error: " . $e->getMessage());
}


function getRandomQuestion() : ?int {
  global $db;

  $sql = "SELECT `id` FROM `question` ORDER BY RAND() LIMIT 1;";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchColumn();
  if($result === false) return null;
  return $result;
}

function getWordOfQuestion(int $question_id) : array {
  global $db;

  $sql = "SELECT `id`,`text`,`order` FROM `word` WHERE `question_id` = :question_id ORDER BY RAND();";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':question_id',$question_id);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getRealOrderOfWord(int $word_id) : ?int {
  global $db;

  $sql = "SELECT `order` From `word` WHERE `id` = :word_id;";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':word_id', $word_id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetchColumn();
  if ($result === false) return null;
  return $result;
} 