<?php
// Assignment 11: one Active Record class for the members table.
// The Bird class is still responsible for birds; Member handles accounts.
class Member
{
    // Static means this connection belongs to the class and is shared by its objects.
    private static PDO $database;

    // These instance properties hold one account. A new account has no database ID yet.
    public ?int $id = null;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $username = '';
    public string $password_hash = '';
    public string $role = 'member';

    public static function set_database(PDO $pdo): void
    {
        // Receive the connection opened by Database::connect(); do not open one per member.
        // self:: refers to this class, while $this-> refers to one particular account.
        self::$database = $pdo;
    }

    private static function from_row(array $row): Member
    {
        // Convert one associative database row into a Member object ("hydrate").
        // The casts match the declared property types; callers can then use ->first_name.
        $member = new Member();
        $member->id = (int) $row['id'];
        $member->first_name = (string) $row['first_name'];
        $member->last_name = (string) $row['last_name'];
        $member->email = (string) $row['email'];
        $member->username = (string) $row['username'];
        $member->password_hash = (string) $row['password_hash'];
        $member->role = (string) $row['role'];
        return $member;
    }

    public static function find_by_id(int $id): ?Member
    {
        // Used by current_member() to look up the latest name and role.
        $sql = 'SELECT id, first_name, last_name, email, username, password_hash, role
                FROM members WHERE id = :id LIMIT 1';
        // The SQL contains a placeholder; the integer ID is supplied separately as data.
        $statement = self::$database->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        // A found row becomes an object; fetch() returns false when there is no match.
        // This ternary returns that object or null, matching the ?Member return type.
        return $row ? self::from_row($row) : null;
    }

    public static function find_by_username(string $username): ?Member
    {
        // The login page needs the account and its stored hash to check a password.
        // Supplying the username separately prevents it from changing the SQL structure.
        $sql = 'SELECT id, first_name, last_name, email, username, password_hash, role
                FROM members WHERE username = :username LIMIT 1';
        $statement = self::$database->prepare($sql);
        // execute() can supply named values directly, instead of separate bindValue() calls.
        $statement->execute([':username' => $username]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row ? self::from_row($row) : null;
    }

    public static function username_exists(string $username): bool
    {
        // Registration only needs a yes/no answer, so retrieve one ID rather than a full account.
        $statement = self::$database->prepare(
            'SELECT id FROM members WHERE username = :username LIMIT 1'
        );
        $statement->execute([':username' => $username]);
        // Any returned row means the username is taken; false means no matching row.
        return $statement->fetch() !== false;
    }

    public static function email_exists(string $email): bool
    {
        // Check email separately so registration can explain exactly which value is duplicated.
        $statement = self::$database->prepare(
            'SELECT id FROM members WHERE email = :email LIMIT 1'
        );
        $statement->execute([':email' => $email]);
        return $statement->fetch() !== false;
    }

    public function validation_errors(): array
    {
        // Collect all problems so the form can show them together. An empty array means valid.
        $errors = [];
        // Browser form rules help the user, but PHP must also check the submitted values.
        if ($this->first_name === '' || strlen($this->first_name) > 80) {
            $errors[] = 'First name is required (maximum 80 characters).';
        }
        if ($this->last_name === '' || strlen($this->last_name) > 80) {
            $errors[] = 'Last name is required (maximum 80 characters).';
        }
        // Only check for an existing email after its format and length pass.
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL) || strlen($this->email) > 190) {
            $errors[] = 'Enter a valid email (maximum 190 characters).';
        } elseif (self::email_exists($this->email)) {
            $errors[] = 'An account already uses that email address.';
        }
        // This pattern accepts only the stated characters and a length of 3 through 50.
        if (!preg_match('/\A[A-Za-z0-9._-]{3,50}\z/D', $this->username)) {
            $errors[] = 'Username must be 3–50 letters, digits, dots, underscores, or hyphens.';
        } elseif (self::username_exists($this->username)) {
            $errors[] = 'An account already uses that username.';
        }
        return $errors;
    }

    public function set_password(string $plain_password): void
    {
        // Hash the plaintext password once before create(); only the hash is stored.
        // Login uses password_verify() to compare a supplied password with this saved hash.
        $this->password_hash = password_hash($plain_password, PASSWORD_DEFAULT);
    }

    public function create(): bool
    {
        // Create a public registration. The SQL below always receives the role 'member'.
        // Check that set_password() supplied a recognized hash before attempting the INSERT.
        if (!password_get_info($this->password_hash)['algo']) {
            throw new LogicException('Call set_password() before Member::create().');
        }

        $sql = 'INSERT INTO members
                (first_name, last_name, email, username, password_hash, role)
                VALUES (:first_name, :last_name, :email, :username, :password_hash, :role)';
        $statement = self::$database->prepare($sql);
        // Each array key matches a placeholder, keeping all account values out of the SQL text.
        $created = $statement->execute([
            ':first_name' => $this->first_name,
            ':last_name' => $this->last_name,
            ':email' => $this->email,
            ':username' => $this->username,
            ':password_hash' => $this->password_hash,
            // Force the role here even if a browser submission tries to request admin.
            ':role' => 'member',
        ]);
        if ($created) {
            // MySQL assigns the ID; copy it back so this object represents the saved row.
            $this->id = (int) self::$database->lastInsertId();
            $this->role = 'member';
        }
        return $created;
    }
}
