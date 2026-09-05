<?php 

require __DIR__ . "/database/connection.php";

class User {
    public ?int $id;
    public string $name;
    public string $email;
    public ?string $phone;
    public string $password;
    public bool $admin = false;

    public static function checkEmailIfExist(string $email): bool {
        global $connection;
        $query = "SELECT 1 FROM `users` WHERE `email` = :email LIMIT 1";
        $statement = $connection->prepare($query);
        $statement->execute([':email' => $email]);

        return (bool) $statement->fetch();
    }

    public static function getAll(): array {
        global $connection;
        $query = "SELECT * FROM `users`";
        $statement = $connection->query($query);
        $data = $statement->fetchAll();

        if (!$data) return [];

        return array_map(function($item) {
            $user = new self();
            $user->id = (int) $item['id'];
            $user->name = $item['name'];
            $user->email = $item['email'];
            $user->phone = $item['phone'];
            $user->admin = (bool) $item['admin'];
            return $user;
        }, $data);
    }

    public static function create(string $name, string $email, ?string $phone, string $password): ?User {
        global $connection;
        $query = "INSERT INTO `users` (`name`, `email`, `phone`, `password`) VALUES (:name, :email, :phone, :password)";
        $statement = $connection->prepare($query);
        $statement->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $id = (int) $connection->lastInsertId();
        return self::find($id);
    }

    public static function find(int $id): ?User {
        global $connection;
        $query = "SELECT * FROM `users` WHERE `id` = :id";
        $statement = $connection->prepare($query);
        $statement->execute([':id' => $id]);
        $data = $statement->fetch();

        if (!$data) return null;

        $user = new self();
        $user->id = (int) $data['id'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->password = $data['password'];
        $user->admin = (bool) $data['admin'];
        return $user;
    }

    public function update(?string $name = null, ?string $email = null, ?string $phone = null, ?string $currentPassword = null, ?string $newPassword = null) {
        global $connection;
        if (!$this->id) return false;

        $name = $name ?? $this->name;
        $email = $email ?? $this->email;
        $phone = $phone ?? $this->phone;

        if ($currentPassword && $newPassword) {
            if (password_verify($currentPassword, $this->password)) {
                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
            }
        }

        $password = $hashed_password ?? $this->password;
        
        $query = "UPDATE `users` SET 
            `id` = :id,
            `name` = :name,
            `email` = :email,
            `phone` = :phone,
            `password` = :password WHERE `id` = :id";
        $statement = $connection->prepare($query);
        $success = $statement->execute([
            ':id' => $this->id,
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':password' => $password,
        ]);

        if ($success) {
            $this->name = $name;
            $this->email = $email;
            $this->phone = $phone;
        }

        return $success;
    }

    public static function findByEmail(string $email): ?User {
        global $connection;
        $query = "SELECT * FROM `users` WHERE `email` = :email";
        $statement = $connection->prepare($query);
        $statement->execute([':email' => $email]);

        $data = $statement->fetch();

        if (!$data) return null;

        $user = new self();
        $user->id = (int) $data['id'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->admin = (bool) $data['admin'];
        $user->password = $data['password'];
        return $user;
    }

    public function delete(): bool {
        global $connection;
        if (!$this->id) return false;

        $query = "DELETE FROM `users` WHERE `id` = :id";
        $statement = $connection->prepare($query);
        return $statement->execute([':id' => $this->id]);
    }
}

class Product {
    public ?int $id;
    public string $name;
    public ?string $description;
    public float $price;
    public ?string $image;
    public int $stock = 1;

    public static function create(string $name, ?string $description, float $price, ?string $image, int $stock = 1): ?Product {
        global $connection;
        $query = "INSERT INTO `products` (`name`, `description`, `price`, `image`, `stock`) VALUES (:name, :description, :price, :image, :stock)";
        $statement = $connection->prepare($query);
        $statement->execute([
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':image' => $image,
            ':stock' => $stock,
        ]);

        $id = (int) $connection->lastInsertId();
        return self::find($id);
    }

    public static function getAll() {
        global $connection;
        $query = "SELECT * FROM `products`";
        $statement = $connection->query($query);
        $data = $statement->fetchAll();

        if (!$data) return [];

        return array_map(function($item) {
            $product = new self();
            $product->id = (int) $item['id'];
            $product->name = $item['name'];
            $product->description = $item['description'];
            $product->price = (float) $item['price'];
            $product->image = $item['image'];
            $product->stock = (int) $item['stock'];
            return $product;
        }, $data);
    }

    public static function find(int $id) {
        global $connection;
        $query = "SELECT * FROM `products` WHERE `id` = :id";
        $statement = $connection->prepare($query);
        $statement->execute([':id' => $id]);
        $data = $statement->fetch();

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
        global $connection;
        if (!$this->id) return false;

        $name = $name ?? $this->name;
        $description = $description ?? $this->description;
        $price = $price ?? $this->price;
        $image = $image ?? $this->image;
        $stock = $stock ?? $this->stock;
        
        $query = "UPDATE `products` SET 
            `id` = :id,
            `name` = :name,
            `description` = :description,
            `price` = :price,
            `image` = :image,
            `stock` = :stock WHERE `id` = :id";
        $statement = $connection->prepare($query);
        $success = $statement->execute([
            ':id' => $this->id,
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':image' => $image,
            ':stock' => $stock,
        ]);

        if ($success) {
            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
            $this->image = $image;
            $this->stock = $stock;
        }

        return $success;
    }

    public function delete() {
        global $connection;
        if (!$this->id) return false;

        $query = "DELETE FROM `products` WHERE `id` = :id";
        $statement = $connection->prepare($query);
        return $statement->execute([':id' => $this->id]);
    }
}

class Order {
    public ?int $id;
    public int $user_id;
    public ?string $status;
    public ?int $itemsCount;
    public ?float $totalPrice;
    public User $user;
    public array $orderItems = [];

    public static function create(?int $user_id, ?string $status = 'pending') {
        $user = User::find($user_id);

        if (!$user) {
            return false;
        }

        global $connection;
        $query = "INSERT INTO `orders` (`user_id`, `status`) VALUES (:user_id, :status)";
        $statement = $connection->prepare($query);
        $statement->execute([
            ':user_id' => $user->id,
            ':status' => $status,
        ]);

        $id = (int) $connection->lastInsertId();
        return self::find($id);
    }

    public static function find(int $id) {
        global $connection;
        $query = "SELECT * FROM `orders` WHERE `id` = :id";
        $statement = $connection->prepare($query);
        $statement->execute([':id' => $id]);
        $data = $statement->fetch();
        if (!$data) return null;

        $order = new self();
        $order->id = (int) $data['id'];
        $order->user_id = (int) $data['user_id'];
        $order->status = $data['status'];

        // Foreign
        $order->user = User::find($order->user_id);
        $order->orderItems = OrderItem::getOrderItems($order->id);

        // Auto counted variables
        $order->itemsCount = count($order->orderItems);
        $order->totalPrice = 0;
        foreach ($order->orderItems as $orderItem) {
            $price = $orderItem->quantity * $orderItem->product->price;
            $order->totalPrice += $price;
        }

        return $order;
    }

    public static function getUserOrders() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $connection;
        $user_id = (int) $_SESSION['user']['id'];
        $query = "SELECT * FROM `orders` WHERE `user_id` = $user_id";
        $statement = $connection->query($query);
        $data = $statement->fetchAll();

        if (!$data) return [];

        
        return array_map(function($item) {
            $order = new self();
            $order->id = (int) $item['id'];
            $order->user_id = (int) $item['user_id'];
            $order->status = $item['status'];
            
            // Foreign
            $order->user = User::find($order->user_id);
            $order->orderItems = OrderItem::getOrderItems($order->id);

            // Auto counted variables
            $order->itemsCount = count($order->orderItems);
            $order->totalPrice = 0;
            foreach ($order->orderItems as $orderItem) {
                $price = $orderItem->quantity * $orderItem->product->price;
                $order->totalPrice += $price;
            }

            return $order;
        }, $data);
    }

    public function update(?string $user_id = null, ?string $status = null) {
        global $connection;
        if (!$this->id) return false;

        $user_id = $user_id ?? $this->user_id;
        $status = $status ?? $this->status;
        
        $query = "UPDATE `orders` SET 
            `id` = :id,
            `user_id` = :user_id,
            `status` = :status WHERE `id` = :id";
        $statement = $connection->prepare($query);
        $success = $statement->execute([
            ':id' => $this->id,
            ':user_id' => $user_id,
            ':status' => $status,
        ]);

        if ($success) {
            $this->user_id = $user_id;
            $this->status = $status;
            $this->user = User::find($this->user_id);
            $this->orderItems = OrderItem::getOrderItems($this->id);

            $this->itemsCount = count($this->orderItems);
            $this->totalPrice = 0;
            foreach ($this->orderItems as $orderItem) {
                $price = $orderItem->quantity * $orderItem->product->price;
                $this->totalPrice += $price;
            }
        }

        return $success;
    }

    public function delete() {
        global $connection;
        if (!$this->id) return false;

        $query = "DELETE FROM `orders` WHERE `id` = :id";
        $statement = $connection->prepare($query);
        return $statement->execute([':id' => $this->id]);
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

        global $connection;
        $query = "INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`) VALUES (:order_id, :product_id, :quantity)";
        $statement = $connection->prepare($query);
        $statement->execute([
            ':order_id' => $order->id,
            ':product_id' => $product->id,
            ':quantity' => $quantity,
        ]);

        $id = (int) $connection->lastInsertId();
        return self::find($id);
    }

    public static function getOrderItems(int $order_id) {
        global $connection;
        $query = "SELECT * FROM `order_items` WHERE `order_id` = $order_id";
        $statement = $connection->query($query);
        $data = $statement->fetchAll();

        if (!$data) return [];
        
        return array_map(function($item) {
            $orderItem = new self();
            $orderItem->id = (int) $item['id'];
            $orderItem->product_id = $item['product_id'];
            $orderItem->product = Product::find($orderItem->product_id);
            $orderItem->quantity = $item['quantity'];

            return $orderItem;
        }, $data);
    }


    public static function find(int $id) {
        global $connection;
        $query = "SELECT * FROM `order_items` WHERE `id` = :id";
        $statement = $connection->prepare($query);
        $statement->execute([':id' => $id]);
        $data = $statement->fetch();

        if (!$data) return null;

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
        global $connection;
        if (!$this->id) return false;

        $order_id = $order_id ?? $this->order_id;
        $product_id = $product_id ?? $this->product_id;
        $quantity = $quantity ?? $this->quantity;
        
        $query = "UPDATE `order_items` SET 
            `id` = :id,
            `order_id` = :order_id,
            `product_id` = :product_id,
            `quantity` = :quantity WHERE `id` = :id";
        $statement = $connection->prepare($query);
        $success = $statement->execute([
            ':id' => $this->id,
            ':order_id' => $order_id,
            ':product_id' => $product_id,
            ':quantity' => $quantity,
        ]);

        if ($success) {
            $this->order_id = $order_id;
            $this->product_id = $product_id;
            $this->quantity = $quantity;
            $this->order = Order::find($this->order_id);
            $this->product = Product::find($this->product_id);
        }

        return $success;
    }

    public function delete() {
        global $connection;
        if (!$this->id) return false;

        $query = "DELETE FROM `order_items` WHERE `id` = :id";
        $statement = $connection->prepare($query);
        return $statement->execute([':id' => $this->id]);
    }
}

class Cart {
    private static function initSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public static function add(int $productId, int $quantity = 1): void {
        self::initSession();

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    public static function increaseQuantity(int $productId): void {
        self::initSession();

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]++;
        }
    }

    public static function decreaseQuantity(int $productId): void {
        self::initSession();

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]--;

            if ($_SESSION['cart'][$productId] <= 0) {
                self::remove($productId);
            }
        }
    }

    public static function remove(int $productId): void {
        self::initSession();
        unset($_SESSION['cart'][$productId]);
    }

    public static function getItems(): array {
        self::initSession();
        $cartData = $_SESSION['cart'];

        if (empty($cartData)) {
            return ['items' => [], 'grandTotal' => 0.0, 'totalQuantity' => 0];
        }

        $items = [];
        $grandTotal = 0.0;
        $totalQuantity = 0;

        foreach ($cartData as $productId => $quantity) {
            $product = Product::find((int) $productId);

            if ($product) {
                $subtotal = $product->price * $quantity;
                $grandTotal += $subtotal;
                $totalQuantity += $quantity;

                $items[] = [
                    'product'  => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
            } else {
                self::remove($productId);
            }
        }

        return [
            'items'         => $items,
            'grandTotal'    => $grandTotal,
            'totalQuantity' => $totalQuantity
        ];
    }

    public static function clear(): void {
        self::initSession();
        $_SESSION['cart'] = [];
    }
}