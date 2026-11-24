<?php
// The familiar Bird Active Record stays separate from the new Member class.
// Expected WNC Birds columns: id, common_name, scientific_name, family_name,
// primary_habitat, seasonal_status, description.
class Bird
{
    // One shared connection for Bird queries; the remaining properties describe individual birds.
    private static PDO $database;

    public ?int $id = null;
    public string $common_name = '';
    public string $scientific_name = '';
    public string $family_name = '';
    public string $primary_habitat = '';
    public string $seasonal_status = '';
    public string $description = '';

    public static function set_database(PDO $pdo): void
    {
        // initialize.php supplies its existing PDO connection rather than each object opening one.
        self::$database = $pdo;
    }

    private static function db(): PDO
    {
        // A small private shortcut for retrieving the connection used throughout this class.
        return self::$database;
    }

    private static function from_row(array $row): Bird
    {
        // Hydration turns one associative PDO row into an object that pages can read with ->.
        // The text fields fall back to an empty string if a value is absent or null.
        $bird = new Bird();
        $bird->id = (int) $row['id'];
        $bird->common_name = (string) ($row['common_name'] ?? '');
        $bird->scientific_name = (string) ($row['scientific_name'] ?? '');
        $bird->family_name = (string) ($row['family_name'] ?? '');
        $bird->primary_habitat = (string) ($row['primary_habitat'] ?? '');
        $bird->seasonal_status = (string) ($row['seasonal_status'] ?? '');
        $bird->description = (string) ($row['description'] ?? '');
        return $bird;
    }

    public static function find_all(): array
    {
        // This fixed query has no browser-supplied values, so it can use query() directly.
        $statement = self::db()->query('SELECT * FROM birds ORDER BY common_name');
        $birds = [];
        // fetch() reads one row at a time; store each hydrated Bird in the result array.
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $birds[] = self::from_row($row);
        }
        return $birds;
    }

    public static function find_by_id(int $id): ?Bird
    {
        // Read one record. Bind the ID as integer data instead of joining it into the SQL.
        $statement = self::db()->prepare('SELECT * FROM birds WHERE id = :id LIMIT 1');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        // The ternary returns a Bird when a row exists, or null when no record matches.
        return $row ? self::from_row($row) : null;
    }

    public static function count_all(): int
    {
        // Ask MySQL for the count without loading every bird; fetchColumn() reads that one value.
        return (int) self::db()->query('SELECT COUNT(*) FROM birds')->fetchColumn();
    }

    public function create(): bool
    {
        // Insert this object's values. Named placeholders keep the data separate from SQL syntax.
        $sql = 'INSERT INTO birds
                (common_name, scientific_name, family_name, primary_habitat,
                 seasonal_status, description)
                VALUES (:common_name, :scientific_name, :family_name, :primary_habitat,
                        :seasonal_status, :description)';
        $statement = self::db()->prepare($sql);
        // Reuse the same property-to-placeholder mapping that update() uses.
        $ok = $statement->execute($this->form_parameters());
        if ($ok) {
            // Save MySQL's generated ID on the object so later code can identify its new row.
            $this->id = (int) self::db()->lastInsertId();
        }
        return $ok;
    }

    public function update(): bool
    {
        // An update needs an existing row ID; a new unsaved object cannot identify its target.
        if ($this->id === null) {
            throw new LogicException('Cannot update a Bird without an ID.');
        }
        // WHERE limits the changes to this bird, leaving other records untouched.
        $sql = 'UPDATE birds SET common_name = :common_name,
                scientific_name = :scientific_name, family_name = :family_name,
                primary_habitat = :primary_habitat, seasonal_status = :seasonal_status,
                description = :description WHERE id = :id';
        $statement = self::db()->prepare($sql);
        // The array union adds :id to the usual field values without changing their mapping.
        return $statement->execute($this->form_parameters() + [':id' => $this->id]);
    }

    public function delete(): bool
    {
        // The calling page handles permission and confirmation; this method performs the SQL.
        if ($this->id === null) {
            throw new LogicException('Cannot delete a Bird without an ID.');
        }
        $statement = self::db()->prepare('DELETE FROM birds WHERE id = :id');
        $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $statement->execute();
        // Report success only when the DELETE actually removed one row.
        return $statement->rowCount() === 1;
    }

    private function form_parameters(): array
    {
        // Keep the INSERT and UPDATE value lists in one place so their mappings stay consistent.
        return [
            ':common_name' => $this->common_name,
            ':scientific_name' => $this->scientific_name,
            ':family_name' => $this->family_name,
            ':primary_habitat' => $this->primary_habitat,
            ':seasonal_status' => $this->seasonal_status,
            ':description' => $this->description,
        ];
    }
}
