<?php
namespace App\Controller;

use App\Model\Contact;
use Exception;

/*ContactController handles CRUD operations for contacts.*/
class ContactController {
    private Contact $contactModel;
    
    /*Constructor to initialize the Contact model.*/
    public function __construct() {
        $this->contactModel = new Contact();
    }

    //Function to create a new contact using the model
    public function createContact(string $name, string $phone, string $email, string $address): array {
        try {
            $result = $this->contactModel->createContact($name, $phone, $email, $address);
            if ($result) {
                return [
                    'status' => 'success',
                    'code' => 201,
                    'message' => 'Contact created successfully.'
                ];
            } else {
                throw new Exception('Failed to create contact.');
            }
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage()
            ];
        }
    }

    //Function to retrieve a contact or all contacts 
    public function getContact(?int $id = null): array {
        try {
            if ($id === null) {
                $contacts = $this->contactModel->getContact();
                return [
                    'status' => 'success',
                    'code' => 200,
                    'data' => $contacts
                ];
            } else {
                $contact = $this->contactModel->getContact($id);
                if ($contact) {
                    return [
                        'status' => 'success',
                        'code' => 200,
                        'data' => $contact
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'code' => 404,
                        'message' => 'Contact not found.'
                    ];
                }
            }
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage()
            ];
        }
    }
    
    //Function to update contact
    public function updateContact(int $id, string $name, string $phone, string $email, string $address): array {
        try {
            $result = $this->contactModel->updateContact($id, $name, $phone, $email, $address);
            if ($result) {
                return [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Contact updated successfully.'
                ];
            } else {
                throw new Exception('Failed to update contact.');
            }
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage()
            ];
        }
    }

    //Function to delete a contact
    public function deleteContact(int $id): array {
        try {
            $result = $this->contactModel->deleteContact($id);
            if ($result) {
                return [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Contact deleted successfully.'
                ];
            } else {
                throw new Exception('Failed to delete contact.');
            }
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage()
            ];
        }
    }
}
?>
