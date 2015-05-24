<?php

/**
 * DeviceModel
 * This is basically a simple CRUD (Create/Read/Update/Delete) demonstration.
 */
class DeviceModel
{
    /**
     * Get all notes (notes are just example data that the user has created)
     * @return array an array with several objects (the results)
     */
   
    public static function getAllDevices()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, device_id, device_serial, device_version, yard_id FROM devices LIMIT 10";
        $query = $database->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

    public static function getUserDevices()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, device_id, device_serial, device_version, yard_id FROM devices WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id')));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

    /**
     * Get a single note
     * @param int $note_id id of the specific note
     * @return object a single object (the result)
     */
    public static function getDevice($device_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, device_id, device_serial, device_version, yard_id FROM devices WHERE user_id = :user_id AND note_id = :device_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id'), ':device_id' => $note_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }

    /**
     * Set a note (create a new one)
     * @param string $note_text note text that will be created
     * @param string $device_version note text that will be created
     * @return bool feedback (was the note created properly ?)
     */
    public static function createDevice($device_serial, $device_version)
    {
        if (!$device_serial|| strlen($device_serial) == 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_DEVICE_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO devices (device_serial, device_version) VALUES (:device_serial, :device_version)";
        $query = $database->prepare($sql);
        $query->execute(array(':device_serial' => $device_serial, ':device_version' => $device_version));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_DEVICE_CREATION_FAILED'));
        return false;
    }

    /**
     * Update an existing note
     * @param int $note_id id of the specific note
     * @param string $note_text new text of the specific note
     * @return bool feedback (was the update successful ?)
     */
    public static function updateDevice($device_id, $device_serial, $device_version)
    {
        if (!$device_id) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE devices SET device_serial = :device_serial WHERE device_id = :device_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':device_id' => $device_id, ':device_serial' => $device_serial, ':device_version' => $device_version));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_DEVICE_EDITING_FAILED'));
        return false;
    }

     /**
     * Update an existing note
     * @param int $note_id id of the specific note
     * @param string $note_text new text of the specific note
     * @return bool feedback (was the update successful ?)
     */
    public static function registerDevice($user_id, $device_serial)
    {
        if (!$device_serial) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE devices SET user_id = :user_id, device_registered = 1 WHERE device_serial = :device_serial AND device_registered = 0 LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':device_serial' => $device_serial));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_DEVICE_REGISTRATION_FAILED'));
        return false;
    }


    /**
     * Delete a specific note
     * @param int $note_id id of the note
     * @return bool feedback (was the note deleted properly ?)
     */
    public static function deleteDevice($device_id)
    {
        if (!$device_id) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM notes WHERE device_id = :device_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':device_id' => $device_id));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_DEVICE_DELETION_FAILED'));
        return false;
    }
}
