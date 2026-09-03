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
            // Convert booleans (true/false) to integers (1/0) safely
            $values = array_map(fn($v) => is_bool($v) ? (int)$v : $v, array_values($data));
            
            mysqli_stmt_bind_param($stmt, $types, ...$values);
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
            if (empty($data)) return false;

            $sets = implode(' = ?, ', array_keys($data)) . ' = ?';
            $values = array_map(fn($v) => is_bool($v) ? (int)$v : $v, array_values($data));
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

    public static function getAll() {
        $data = create_query(type: 'SELECT', table: 'products');

        if (!$data) return [];

        return array_map(function($item) {
            $product = new self();
            $product->id          = (int) $item['id'];
            $product->name        = $item['name'];
            $product->description = $item['description'];
            $product->price       = (float) $item['price'];
            $product->image       = $item['image'];
            $product->stock       = (int) $item['stock'];
            return $product;
        }, $data);
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

    public function update(?string $name = null, ?string $description = null, ?float $price = null, ?string $image = null, ?int $stock = null) {

        $data = [];
        if (!is_null($name)) $data['name'] = $name;
        if (!is_null($description)) $data['description'] = $description;
        if (!is_null($price)) $data['price'] = $price;
        if (!is_null($image)) $data['image'] = $image;
        if (!is_null($stock)) $data['stock'] = $stock;

        if (!$data) {
            return false;
        }
        return create_query(type: 'UPDATE', table: 'products', data: $data, id: $this->id);
    }

    public function delete() {
        if ($this->id) {
            return create_query(type: 'DELETE', table: 'products', id: $this->id);
        }
        return false;
    }
}

class Order {
    public ?int $id;
    public int $user_id;
    public ?string $status;
    public User $user;

    public static function create(?int $user_id, ?string $status = 'pending') {
        $user = User::find($user_id);

        if (!$user) {
            return false;
        }

        $id = create_query(type: 'CREATE', table: 'orders', data: [
            'user_id' => $user->id,
            'status' => $status
        ]);

        return self::find($id);
    }

    public static function find(int $id) {
        $data = create_query(type: 'SELECT', table: 'orders', id: $id);
        if (!$data) return null;

        $order = new self();
        $order->id = (int) $data['id'];
        $order->user_id = (int) $data['user_id'];

        $order->user = User::find($order->user_id);
        $order->status = $data['status'];

        return $order;
    }

    public function update(?string $user_id = null, ?string $status = null) {
        $data = [];

        if (!is_null($user_id)) {
            $user = User::find($user_id);
            if (!$user) {
                return false;
            }
            $data['user_id'] = $user_id;
        }

        if (!is_null($status)) {
            $data['status'] = $status;
        }

        if (empty($data)) {
            return false;
        }

        return create_query(type: 'UPDATE', table: 'orders', data: $data, id: $this->id);
    }

    public function delete() {
        if ($this->id) {
            return create_query(type: 'DELETE', table: 'orders', id: $this->id);
        }
        return;
    }
}

class OrderItem {
    public ?int $id;
    public int $order_id;
    public int $product_id;
    public ?int $quantity;
    public Order $order;
    public Product $product;

    public static function create(?int $order_id, ?int $product_id, ?int $quantity = 1) {
        $order = Order::find($order_id);
        $product = Product::find($product_id);

        if (!$order) {
            return false;
        }

        if (!$product) {
            return false;
        }

        $id = create_query(type: 'CREATE', table: 'order_items', data: [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity
        ]);

        return self::find($id);
    }

    public static function find(int $id) {
        $data = create_query(type: 'SELECT', table: 'order_items', id: $id);
        if (!$data) return false;

        $orderItem = new self();
        $orderItem->id = (int) $data['id'];
        $orderItem->order_id = (int) $data['order_id'];
        $orderItem->product_id = (int) $data['product_id'];

        $orderItem->order = Order::find($orderItem->order_id);
        $orderItem->product = Product::find($orderItem->product_id);
        $orderItem->quantity = (int) $data['quantity'];

        return $orderItem;
    }

    public function update(?int $order_id = null, ?int $product_id = null, ?int $quantity = null) {
        $data = [];

        if (!is_null($order_id)) {
            $order = Order::find($order_id);
            if (!$order) {
                return false;
            }
            $data['order_id'] = $order_id;
        }

        if (!is_null($product_id)) {
            $product = Product::find($product_id);
            if (!$product) {
                return false;
            }
            $data['product_id'] = $product_id;
        }

        if (!is_null($quantity)) {
            $data['quantity'] = $quantity;
        }

        if (empty($data)) {
            return false;
        }

        return create_query(type: 'UPDATE', table: 'order_items', data: $data, id: $this->id);
    }

    public function delete() {
        if ($this->id) {
            return create_query(type: 'DELETE', table: 'order_items', id: $this->id);
        }
        return;
    }
}