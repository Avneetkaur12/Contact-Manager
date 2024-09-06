<?php
namespace App\Model;

use App\Database\ConnectionFactory;
use Exception;
use PDO;

class Contact {
    private PDO $db;

    public function __construct() {
        $this->db = ConnectionFactory::getConnection();
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists(): void {
        $sql = '
            CREATE TABLE IF NOT EXISTS contacts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                phone VARCHAR(15) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                address TEXT NOT NULL
            );
        ';

        $this->db->exec($sql);
    }

    public function createContact(string $name, string $phone, string $email, string $address): bool {
        $stmt = $this->db->prepare('INSERT INTO contacts (name, phone, email, address) VALUES (:name, :phone, :email, :address)');
        return $stmt->execute([
            ':name' => $name,
            ':phone' => $phone,
            ':email' => $email,
            ':address' => $address
        ]);
    }

    public function getContact(?int $id = null): array {
        if ($id === null) {
            $stmt = $this->db->prepare('SELECT * FROM contacts');
            $stmt->execute();
            $contacts = $stmt->fetchAll();
    
            if (empty($contacts)) {
                return [];
            }
    
            return $contacts;
        } else {
            $stmt = $this->db->prepare('SELECT * FROM contacts WHERE id = :id');
            $stmt->execute([':id' => $id]);
            $contact = $stmt->fetch();
    
            if ($contact === false) {
                throw new Exception('Contact not found', 404);
            }
    
            return $contact;
        }
    }
    
    public function updateContact(int $id, string $name, string $phone, string $email, string $address): bool {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM contacts WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            throw new Exception('Contact not found', 404);
        }

        $stmt = $this->db->prepare('UPDATE contacts SET name = :name, phone = :phone, email = :email, address = :address WHERE id = :id');
        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':phone' => $phone,
            ':email' => $email,
            ':address' => $address
        ]);
    }

    public function deleteContact(int $id): bool {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM contacts WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            throw new Exception('Contact not found', 404);
        }

        $stmt = $this->db->prepare('DELETE FROM contacts WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}
?>
