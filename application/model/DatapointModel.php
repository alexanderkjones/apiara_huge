<?php

/**
 * NoteModel
 * This is basically a simple CRUD (Create/Read/Update/Delete) demonstration.
 */
class DatapointModel
{
    

    //create datapoint, round to nearest interval


     public static function createDatapointFromImp($data)
    {

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO datapoints (device_id, device_channel, datapoint_timestamp, datapoint_value) VALUES ";
        $exec_values = array();

        

        /** Sample Imp Datapoint
        {
          "device_id": "1c2a6906c69f",
          "batt_voltage" : 2.7,
          "timestamp" : 1431381914,
          "chanel_data" : [0,1,2,3]
        }
        **/

        $channel_count = 1;
        
        foreach($data["values"] as $d){

            $sql .= "((SELECT device_id FROM devices WHERE device_serial = ?), ?, ?, ?)";
            array_push($exec_values, $data['device_id'], $channel_count, $data['timestamp'], $d);

            if($channel_count != count($data['values'])){
                $sql .=", ";
            }

            $channel_count ++;
        }

        $query = $database->prepare($sql);
        $query->execute($exec_values);

        if ($query->rowCount()) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

}
