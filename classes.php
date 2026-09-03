<?php 

require "../database/connection.php";

function create_query(string $type, string $table, ?array $data = [], mixed $id = null, ?string $email = null) {
    global $connection;

    switch (strtoupper($type)) {
        case 'CREATE':
            $columns = implode('`, `', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            
            $stmt = mysqli_prepare($connection, "INSERT INTO `{$table}` (`{$columns}`) VALUES ({$placeholders})");
            
            $types = str_repeat('s', count($data));
            mysqli_stmt_bind_param($stmt, $types, ...array_values($data));
            
            mysqli_stmt_execute($stmt);
            return mysqli_insert_id($connection);

        case 'SELECT':
            if ($id) {
                $stmt = mysqli_prepare($connection, "SELECT * FROM `{$table}` WHERE `id` = ?");
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                
                $result = mysqli_stmt_get_result($stmt);
                return mysqli_fetch_assoc($result);
            }

            if ($email) {
                $stmt = mysqli_prepare($connection, "SELECT * FROM `{$table}` WHERE `email` = ?");
                mysqli_stmt_bind_param($stmt, 's', $email);
                mysqli_stmt_execute($stmt);
                
                $result = mysqli_stmt_get_result($stmt);
                return mysqli_fetch_assoc($result);
            }

            $result = mysqli_query($connection, "SELECT * FROM `{$table}`");
            return mysqli_fetch_all($result, MYSQLI_ASSOC);

        case 'UPDATE':
            $sets = implode(' = ?, ', array_keys($data)) . ' = ?';
            $values = array_values($data);
            $values[] = $id;

            $stmt = mysqli_prepare($connection, "UPDATE `{$table}` SET {$sets} WHERE `id` = ?");
            
            $types = str_repeat('s', count($data)) . 'i';
            mysqli_stmt_bind_param($stmt, $types, ...$values);
            
            return mysqli_stmt_execute($stmt);

        case 'DELETE':
            $stmt = mysqli_prepare($connection, "DELETE FROM `{$table}` WHERE `id` = ?");
            mysqli_stmt_bind_param($stmt, 'i', $id);
            return mysqli_stmt_execute($stmt);
    }
}


class User {
    public ?int $id;
    public string $name;
    public string $email;
    public ?string $phone;
    public string $password;
    public bool $admin = false;

    public static function checkEmailIfExist(string $email) : bool {
        $user = create_query(type: 'SELECT', table: 'users', email: $email);
        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    public static function create(string $name, string $email, ?string $phone, string $password) {
        $id = create_query(type: 'CREATE', table: 'users', data: [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return self::find($id);
    }

    public static function find(int $id) {
        $data = create_query(type: 'SELECT', table: 'users', id: $id);
        if (!$data) return null;

        $user = new self();
        $user->id = (int)$data['id'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        return $user;
    }

    public function delete() {
        if ($this->id) {
            return create_query(type: 'DELETE', table: 'users', id: $this->id);
        }
        return false;
    }
}

class Product {
    public ?int $id;
    public string $name;
    public ?string $description;
    public float $price;
    public ?string $image;
    public int $stock = 1;

    public static function create(string $name, ?string $description, float $price, ?string $image, int $stock = 1) {
        $id = create_query(type: 'CREATE', table: 'products', data: [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image,
            'stock' => $stock
        ]);

        return self::find($id);
    }

    public static function find(int $id) {
        $data = create_query(type: 'SELECT', table: 'products', id: $id);
        if (!$data) return null;

        $product = new self();
        $product->id = (int) $data['id'];
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = (float) $data['price'];
        $product->image = $data['image'];
        $product->stock = (int) $data['stock'];

        return $product;
    }

    public function update(?string $name, ?string $description, ?float $price, ?string $image, ?int $stock) {

        $data = [];
        if (!empty($name)) $data['name'] = $name;
        if (!empty($description)) $data['description'] = $description;
        if (!empty($price)) $data['price'] = $price;
        if (!empty($image)) $data['iamge'] = $image;
        if (!empty($stock)) $data['stock'] = $stock;

        if (!$data) {
            return false;
        }
        return create_query(type: 'UPDATE', table: 'products', data: $data);
    }

    public function delete() {
        if ($this->id) {
            return create_query(type: 'DELETE', table: 'products', id: $this->id);
        }
        return false;
    }
}
