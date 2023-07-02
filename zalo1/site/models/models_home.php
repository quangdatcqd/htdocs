<?php
require_once "../../system/config.php";
class models_home extends model_system
{
    function get_list_friends($sdt)
    {
        $sql = "SELECT * FROM banbe WHERE number = '$sdt'";
        return $this->query($sql)->fetchAll();
    }
    function get_list_number()
    {
        return $this->query("SELECT * FROM `phone_number`  ORDER BY id DESC  ")->fetchAll();
    }

    function get_page_number( $start,$limit)
    {
        return $this->query("SELECT * FROM `phone_number` ORDER BY id DESC  LIMIT $start,$limit ")->fetchAll();
    }
    function update($id, $note, $used )
    {
        $this->query("UPDATE `phone_number` SET `used` = '$used',  `note` = '$note'    WHERE `phone_number`.`number` = $id");
    }
    function delete($id){
        $this->query("DELETE FROM  `phone_number`  WHERE `phone_number`.`number` = $id");
    }
    function deletefr($id){
        $this->query("DELETE FROM  `banbe`  WHERE `number` = $id");
    }
}
