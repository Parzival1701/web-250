<?php

declare(strict_types=1);

/**
 * GRADED ASSIGNMENT STARTER. Implement the TODOs yourself.
 * This is a read-only slice of Active Record; saving records comes later.
 */
final class Bird
{
  private static ?PDO $database = null;

  public int $id = 0;
  public string $common_name = '';
  public string $scientific_name = '';
  public string $family_name = '';
  public string $primary_habitat = '';
  public string $seasonal_status = '';
  public string $description = '';

  public static function set_database(PDO $pdo): void
  {
    // TODO: Save the PDO connection in the static property.
      self::$database = $pdo;
  }

  /** @return Bird[] */
  public static function find_all(): array
  {
    // TODO: SELECT all birds, sorted by common_name. Return Bird objects.
    if (self::$database === null) {
      throw new RuntimeException('Call set_database() before find_all().');
    }

    // No user input is used in this fixed SQL statement.
    $sql = 'SELECT * FROM birds ORDER BY common_name';
    $statement = self::$database->query($sql);
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    $birds = [];
    foreach ($rows as $row) {
      $birds[] = self::from_row($row);
      // Hydration: turn one associative row into one PHP object.

    }

    return $birds;
  }

  public static function find_by_id(int $id): ?self
  {
    // TODO: Use a prepared statement; return a Bird or null.
    if (self::$database === null) {
      throw new RuntimeException('Call set_database() before find_all().');
    }
    $sql = 'SELECT * FROM birds WHERE id = :id ';
    $statement = self::$database->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
      return null;
    }
    return self::from_row($row);
  }

  // Refactoring task: both query methods should reuse this single mapper.
  private static function from_row(array $row): self
  {
    // TODO: Populate all seven properties and return the Bird object.
    $bird = new self();
    $bird->id = (int) $row['id'];
    $bird->common_name = (string) $row['common_name'];
    $bird->scientific_name = (string) $row['scientific_name'];
    $bird->family_name = (string) $row['family_name'];
    $bird->primary_habitat = (string) $row['primary_habitat'];
    $bird->seasonal_status = (string) $row['seasonal_status'];
    $bird->description = (string) $row['description'];
    return $bird;
  }

  public static function count_all(): int
  {
    // TODO: Return the number of rows in birds (no hydration needed).
     if (self::$database === null) {
      throw new RuntimeException('Call set_database() before find_all().');
    }
    $sql = 'SELECT COUNT(*) FROM birds';
    $statement = self::$database->query($sql);
    $count = $statement->fetchColumn();
    return (int) $count;
  }
}
